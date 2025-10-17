<?php
/**
 * Controlador de Contactar
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja el formulario de contacto, envío de mensajes y acciones administrativas
 */

require_once __DIR__ . '/../models/ContactModel.php';

class ContactarController {
    private $contactModel;
    
    public function __construct() {
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
                    // Redirigir con mensaje de éxito (sin #contacto para evitar scroll automático)
                    header('Location: ' . BASE_URL . '?contact_success=1');
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
    
    /**
     * Cambiar estado de contacto
     */
    public function changeStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contact_id = isset($_POST['contact_id']) ? (int)$_POST['contact_id'] : 0;
            $estado = isset($_POST['estado']) ? trim($_POST['estado']) : '';
            
            if ($contact_id <= 0 || empty($estado)) {
                $this->sendJsonResponse(false, 'Datos inválidos');
                return;
            }
            
            try {
                $result = $this->contactModel->changeContactStatus($contact_id, $estado);
                $this->sendJsonResponse($result['success'], $result['message']);
            } catch (Exception $e) {
                $this->sendJsonResponse(false, 'Error del sistema: ' . $e->getMessage());
            }
        } else {
            $this->sendJsonResponse(false, 'Método no permitido');
        }
    }
    
    /**
     * Eliminar contacto 
     */
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contact_id = isset($_POST['contact_id']) ? (int)$_POST['contact_id'] : 0;
            
            if ($contact_id <= 0) {
                $this->sendJsonResponse(false, 'ID de contacto inválido');
                return;
            }
            
            try {
                $result = $this->contactModel->deleteContact($contact_id);
                $this->sendJsonResponse($result['success'], $result['message']);
            } catch (Exception $e) {
                $this->sendJsonResponse(false, 'Error del sistema: ' . $e->getMessage());
            }
        } else {
            $this->sendJsonResponse(false, 'Método no permitido');
        }
    }
    
    /**
     * Enviar respuesta JSON
     */
    private function sendJsonResponse($success, $message, $data = null) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }
}
?>
