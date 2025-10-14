<?php
/**
 * Modelo de Contactos
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja todas las operaciones relacionadas con contactos
 */

class ContactModel {
    private $conexion;
    
    public function __construct() {
        // Incluir la configuración de la base de datos
        require_once __DIR__ . '/../../config/database.php';
        
        $this->conexion = $conexion;
    }
    
    /**
     * Obtener estadísticas de contactos
     */
    public function getContactStats() {
        try {
            // Total de contactos
            $sql = "SELECT COUNT(*) as total FROM contactar";
            $result = $this->conexion->query($sql);
            $total = $result->fetch_assoc()['total'];
            
            // Contactos nuevos
            $sql = "SELECT COUNT(*) as nuevos FROM contactar WHERE estado = 'nuevo'";
            $result = $this->conexion->query($sql);
            $nuevos = $result->fetch_assoc()['nuevos'];
            
            // Contactos leídos
            $sql = "SELECT COUNT(*) as leidos FROM contactar WHERE estado = 'leido'";
            $result = $this->conexion->query($sql);
            $leidos = $result->fetch_assoc()['leidos'];
            
            // Contactos respondidos
            $sql = "SELECT COUNT(*) as respondidos FROM contactar WHERE estado = 'respondido'";
            $result = $this->conexion->query($sql);
            $respondidos = $result->fetch_assoc()['respondidos'];
            
            return [
                'total_contacts' => $total,
                'nuevos_contacts' => $nuevos,
                'leidos_contacts' => $leidos,
                'respondidos_contacts' => $respondidos
            ];
            
        } catch (Exception $e) {
            error_log("Error en getContactStats: " . $e->getMessage());
            return [
                'total_contacts' => 0,
                'nuevos_contacts' => 0,
                'leidos_contacts' => 0,
                'respondidos_contacts' => 0
            ];
        }
    }
    
    /**
     * Obtener todos los contactos
     */
    public function getAllContacts($limit = null, $offset = 0) {
        try {
            $sql = "SELECT * FROM contactar ORDER BY id DESC";
            
            if ($limit) {
                $sql .= " LIMIT ? OFFSET ?";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bind_param("ii", $limit, $offset);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $result = $this->conexion->query($sql);
            }
            
            $contacts = [];
            while ($row = $result->fetch_assoc()) {
                $contacts[] = $row;
            }
            
            return $contacts;
            
        } catch (Exception $e) {
            error_log("Error en getAllContacts: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtener contacto por ID
     */
    public function getContactById($id) {
        try {
            $sql = "SELECT * FROM contactar WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->fetch_assoc();
            
        } catch (Exception $e) {
            error_log("Error en getContactById: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Cambiar estado de contacto
     */
    public function changeContactStatus($id, $estado) {
        try {
            $sql = "UPDATE contactar SET estado = ? WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("si", $estado, $id);
            
            return $stmt->execute();
            
        } catch (Exception $e) {
            error_log("Error en changeContactStatus: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Eliminar contacto
     */
    public function deleteContact($id) {
        try {
            $sql = "DELETE FROM contactar WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $id);
            
            return $stmt->execute();
            
        } catch (Exception $e) {
            error_log("Error en deleteContact: " . $e->getMessage());
            return false;
        }
    }
}