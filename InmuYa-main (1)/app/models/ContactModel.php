<?php
/**
 * Modelo de Contacto
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja las operaciones de la tabla contactar
 */

require_once __DIR__ . '/../../config/conexion.php';

class ContactModel {
    private $conexion;
    
    public function __construct() {
        global $conexion;
        $this->conexion = $conexion;
    }
    
    /**
     * Guardar mensaje de contacto
     */
    public function saveContact($nombre, $email, $asunto, $mensaje) {
        $stmt = $this->conexion->prepare("INSERT INTO contactar (nombre, email, asunto, mensaje) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            return [
                'success' => false,
                'message' => 'Error al preparar la consulta'
            ];
        }
        $stmt->bind_param("ssss", $nombre, $email, $asunto, $mensaje);
        if ($stmt->execute()) {
            $contactId = $stmt->insert_id;
            $stmt->close();
            return [
                'success' => true,
                'contact_id' => $contactId,
                'message' => 'Mensaje guardado correctamente'
            ];
        } else {
            $stmt->close();
            return [
                'success' => false,
                'message' => 'Error al guardar el mensaje'
            ];
        }
    }
    
    /**
     * Obtener todos los mensajes de contacto
     */
    public function getAllContacts($limit = null, $offset = 0) {
        $sql = "SELECT * FROM contactar ORDER BY id_contacto DESC";
        if ($limit !== null) {
            $sql .= " LIMIT ? OFFSET ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ii", $limit, $offset);
            $stmt->execute();
            $result = $stmt->get_result();
            $contacts = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $contacts;
        } else {
            $result = $this->conexion->query($sql);
            return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        }
    }
    
    /**
     * Obtener mensaje por ID
     */
    public function getContactById($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM contactar WHERE id_contacto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $contact = $result->fetch_assoc();
        $stmt->close();
        return $contact;
    }
    
    /**
     * Eliminar mensaje de contacto
     */
    public function deleteContact($id) {
        $stmt = $this->conexion->prepare("DELETE FROM contactar WHERE id_contacto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        if ($affected > 0) {
            return [
                'success' => true,
                'message' => 'Mensaje eliminado correctamente'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'No se pudo eliminar el mensaje'
            ];
        }
    }
}
?>