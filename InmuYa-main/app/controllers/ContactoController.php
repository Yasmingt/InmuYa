<?php
/**
 * Controlador de Contacto
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja el formulario de contacto y envío de mensajes
 */

require_once __DIR__ . '/../models/ContactosModel.php';

class ContactoController {
    private $contactosModel;
    
    public function __construct() {
        require_once __DIR__ . '/../models/ContactosModel.php';
        $this->contactosModel = new ContactosModel();
    }
    
    /** Mostrar formulario de contacto (redirige a la página principal) */
    public function mostrarFormularioContacto() {
        // Redirigir a la página principal donde está el formulario
        header('Location: ' . BASE_URL . '#contacto');
        exit;
    }
    
    /** Procesar formulario de contacto */
    public function procesarFormularioContacto() {
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
            if (strlen($nombre) > 50) {
                header('Location: ' . BASE_URL . '?contact_error=' . urlencode('El nombre no puede exceder 50 caracteres') . '#contacto');
                exit;
            }
            
            if (strlen($email) > 50) {
                header('Location: ' . BASE_URL . '?contact_error=' . urlencode('El email no puede exceder 50 caracteres') . '#contacto');
                exit;
            }
            
            if (strlen($asunto) > 100) {
                header('Location: ' . BASE_URL . '?contact_error=' . urlencode('El asunto no puede exceder 100 caracteres') . '#contacto');
                exit;
            }
            
            try {
                // Guardar en la tabla contactar usando el modelo
                $result = $this->contactosModel->guardarContacto($nombre, $email, $asunto, $mensaje);
                
                // Verificar el resultado
                if ($result['success']) {
                    // Redirigir con mensaje de éxito
                    header('Location: ' . BASE_URL . '?contact_success=1#contacto');
                    exit;
                } else {
                    // Redirigir con mensaje de error específico
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
            // Si no es POST, redirigir a la página principal
            header('Location: ' . BASE_URL . '#contacto');
            exit;
        }
    }
    
    /** Cambiar estado de contacto */
    public function cambiarEstado() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contact_id = isset($_POST['contact_id']) ? (int)$_POST['contact_id'] : 0;
            $nuevo_estado = isset($_POST['estado']) ? $_POST['estado'] : '';
            
            if ($contact_id <= 0 || empty($nuevo_estado)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Datos inválidos'
                ]);
                exit;
            }
            
            try {
                $result = $this->contactosModel->cambiarEstadoContacto($contact_id, $nuevo_estado);
                
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => $result,
                    'message' => $result ? 'Estado actualizado correctamente' : 'Error al actualizar el estado'
                ]);
                exit;
                
            } catch (Exception $e) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al actualizar el estado: ' . $e->getMessage()
                ]);
                exit;
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Método no permitido'
        ]);
        exit;
    }
    
    /** Eliminar contacto */
    public function eliminarContacto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contact_id = isset($_POST['contact_id']) ? (int)$_POST['contact_id'] : 0;
            
            if ($contact_id <= 0) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'ID de contacto inválido'
                ]);
                exit;
            }
            
            try {
                $result = $this->contactosModel->eliminarContacto($contact_id);
                
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => $result,
                    'message' => $result ? 'Contacto eliminado correctamente' : 'Error al eliminar el contacto'
                ]);
                exit;
                
            } catch (Exception $e) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al eliminar el contacto: ' . $e->getMessage()
                ]);
                exit;
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Método no permitido'
        ]);
        exit;
    }
}
?>
