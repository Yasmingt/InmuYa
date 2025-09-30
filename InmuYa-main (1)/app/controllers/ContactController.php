<?php
/**
 * Controlador de Contacto
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja el formulario de contacto y envío de mensajes
 */

require_once __DIR__ . '/../models/ContactModel.php';

class ContactController {
    private $contactModel;
    
    public function __construct() {
        require_once __DIR__ . '/../models/ContactModel.php';
        $this->contactModel = new ContactModel();
    }
    
    /**
     * Mostrar formulario de contacto (redirige a la página principal)
     */
    public function showContact() {
        // Redirigir a la página principal donde está el formulario
        header('Location: ' . BASE_URL . '#contacto');
        exit;
    }
    
    /**
     * Procesar formulario de contacto
     */
    public function processContact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $asunto = trim($_POST['asunto'] ?? '');
            $mensaje = trim($_POST['mensaje'] ?? '');
            
            // Validar datos
            if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
                header('Location: ' . BASE_URL . '?contact_error=' . urlencode('Todos los campos son obligatorios') . '#contacto');
                exit;
            }
            
            // Validar email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('Location: ' . BASE_URL . '?contact_error=' . urlencode('El email no es válido') . '#contacto');
                exit;
            }
            
            // Validar longitud de campos
            if (strlen($nombre) > 100) {
                header('Location: ' . BASE_URL . '?contact_error=' . urlencode('El nombre no puede exceder 100 caracteres') . '#contacto');
                exit;
            }
            
            if (strlen($asunto) > 200) {
                header('Location: ' . BASE_URL . '?contact_error=' . urlencode('El asunto no puede exceder 200 caracteres') . '#contacto');
                exit;
            }
            
            try {
                // Guardar en la tabla contactar usando el modelo
                $result = $this->contactModel->saveContact($nombre, $email, $asunto, $mensaje);
                
                if ($result['success']) {
                    // Redirigir con mensaje de éxito
                    header('Location: ' . BASE_URL . '?contact_success=1#contacto');
                    exit;
                } else {
                    // Redirigir con mensaje de error
                    header('Location: ' . BASE_URL . '?contact_error=' . urlencode($result['message']) . '#contacto');
                    exit;
                }
                
            } catch (Exception $e) {
                error_log("Error en contacto: " . $e->getMessage());
                // Redirigir con mensaje de error del sistema
                header('Location: ' . BASE_URL . '?contact_error=' . urlencode('Error del sistema. Inténtalo más tarde.') . '#contacto');
                exit;
            }
        } else {
            $this->showContact();
        }
    }
}
?>
