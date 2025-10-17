<?php
/**
 * Modelo de Contactos
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja todas las operaciones relacionadas con contactos
 */

class ContactosModel {
    private $conexion;
    
    public function __construct() {
        // Incluir la configuración de la base de datos
        require_once __DIR__ . '/../../config/database.php';
        
        // Verificar que la conexión esté disponible
        if (isset($conexion)) {
            $this->conexion = $conexion;
        } else {
            // Crear conexión directamente si no está disponible
            try {
                $this->conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
                if ($this->conexion->connect_error) {
                    throw new Exception("Error de conexión: " . $this->conexion->connect_error);
                }
                
                $this->conexion->set_charset("utf8");
                
            } catch (Exception $e) {
                error_log("Error en ContactModel: " . $e->getMessage());
                $this->conexion = null;
            }
        }
    }
    
    /** Obtener estadísticas de contactos */
    public function obtenerEstadisticasContactos() {
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
    
    /** Obtener todos los contactos */
    public function obtenerTodosLosContactos($limit = null, $offset = 0) {
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
    
    /** Obtener contacto por ID */
    public function obtenerContactoPorId($id) {
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
    
    /** Cambiar estado de contacto */
    public function cambiarEstadoContacto($id, $estado) {
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
    
    /** Guardar nuevo contacto */
    public function guardarContacto($nombre, $email, $asunto, $mensaje) {
        try {
            // Verificar que la conexión esté disponible
            if (!$this->conexion) {
                return ['success' => false, 'message' => 'Error de conexión a la base de datos'];
            }
            
            $sql = "INSERT INTO contactar (nombre, email, asunto, mensaje, estado) VALUES (?, ?, ?, ?, 'nuevo')";
            $stmt = $this->conexion->prepare($sql);
            
            if (!$stmt) {
                return ['success' => false, 'message' => 'Error en la preparación de la consulta'];
            }
            
            $stmt->bind_param("ssss", $nombre, $email, $asunto, $mensaje);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Contacto guardado exitosamente'];
            } else {
                return ['success' => false, 'message' => 'Error al guardar el contacto'];
            }
            
        } catch (Exception $e) {
            error_log("Error en saveContact: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error del sistema al guardar el contacto'];
        }
    }
    
    /** Eliminar contacto */
    public function eliminarContacto($id) {
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