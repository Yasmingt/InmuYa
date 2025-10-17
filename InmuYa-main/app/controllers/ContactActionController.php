<?php
/**
 * Controlador de Acciones de Contacto
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja las acciones AJAX para contactos
 */

require_once __DIR__ . '/../models/ContactModel.php';

class ContactActionController {
    private $contactModel;
    
    public function __construct() {
        $this->contactModel = new ContactModel();
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
    public function deleteContact() {
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
