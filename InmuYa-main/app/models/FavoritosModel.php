<?php
/**
 * Modelo de Favoritos
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja todas las operaciones relacionadas con favoritos de propiedades
 */

class FavoritosModel {
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
                error_log("Error en FavoritosModel: " . $e->getMessage());
                $this->conexion = null;
            }
        }
    }
    
    /**
     * Agregar propiedad a favoritos
     */
    public function agregarFavorito($idUsuario, $idPropiedad) {
        try {
            if (!$this->conexion) {
                return ['success' => false, 'message' => 'Error de conexión a la base de datos'];
            }
            
            // Verificar si ya existe el favorito
            if ($this->esFavorito($idUsuario, $idPropiedad)) {
                return ['success' => false, 'message' => 'La propiedad ya está en favoritos'];
            }
            
            $sql = "INSERT INTO favoritos (id_usuario, id_propiedad) VALUES (?, ?)";
            $stmt = $this->conexion->prepare($sql);
            
            if (!$stmt) {
                return ['success' => false, 'message' => 'Error en la preparación de la consulta'];
            }
            
            $stmt->bind_param("ii", $idUsuario, $idPropiedad);
            
            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Propiedad agregada a favoritos'];
            } else {
                return ['success' => false, 'message' => 'Error al agregar a favoritos'];
            }
            
        } catch (Exception $e) {
            error_log("Error en agregarFavorito: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error del sistema al agregar favorito'];
        }
    }
    
    /**
     * Eliminar propiedad de favoritos
     */
    public function eliminarFavorito($idUsuario, $idPropiedad) {
        try {
            if (!$this->conexion) {
                return ['success' => false, 'message' => 'Error de conexión a la base de datos'];
            }
            
            $sql = "DELETE FROM favoritos WHERE id_usuario = ? AND id_propiedad = ?";
            $stmt = $this->conexion->prepare($sql);
            
            if (!$stmt) {
                return ['success' => false, 'message' => 'Error en la preparación de la consulta'];
            }
            
            $stmt->bind_param("ii", $idUsuario, $idPropiedad);
            
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    return ['success' => true, 'message' => 'Propiedad eliminada de favoritos'];
                } else {
                    return ['success' => false, 'message' => 'La propiedad no estaba en favoritos'];
                }
            } else {
                return ['success' => false, 'message' => 'Error al eliminar de favoritos'];
            }
            
        } catch (Exception $e) {
            error_log("Error en eliminarFavorito: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error del sistema al eliminar favorito'];
        }
    }
    
    /**
     * Verificar si una propiedad es favorita del usuario
     */
    public function esFavorito($idUsuario, $idPropiedad) {
        try {
            if (!$this->conexion) {
                return false;
            }
            
            $sql = "SELECT COUNT(*) as count FROM favoritos WHERE id_usuario = ? AND id_propiedad = ?";
            $stmt = $this->conexion->prepare($sql);
            
            if (!$stmt) {
                return false;
            }
            
            $stmt->bind_param("ii", $idUsuario, $idPropiedad);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            
            return $row['count'] > 0;
            
        } catch (Exception $e) {
            error_log("Error en esFavorito: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtener todas las propiedades favoritas de un usuario
     */
    public function obtenerFavoritosUsuario($idUsuario, $limit = null, $offset = 0) {
        try {
            if (!$this->conexion) {
                return [];
            }
            
            $sql = "SELECT p.*, c.nombre as ciudad_nombre, b.nombre as barrio_nombre, 
                           u.nombre as usuario_nombre, i.url_imagen as imagen_principal,
                           f.fecha_agregado as fecha_favorito
                    FROM favoritos f
                    INNER JOIN propiedades p ON f.id_propiedad = p.id_propiedad
                    LEFT JOIN ciudades c ON p.id_ciudad = c.id_ciudad 
                    LEFT JOIN barrios b ON p.id_barrio = b.id_barrio 
                    LEFT JOIN usuarios u ON p.id_usuario = u.id_usuario 
                    LEFT JOIN imagenes i ON p.id_propiedad = i.id_propiedad AND i.es_principal = 1 AND i.activo = 1
                    WHERE f.id_usuario = ? AND p.activo = 1
                    ORDER BY f.fecha_agregado DESC";
            
            if ($limit) {
                $sql .= " LIMIT ? OFFSET ?";
            }
            
            $stmt = $this->conexion->prepare($sql);
            
            if (!$stmt) {
                return [];
            }
            
            if ($limit) {
                $stmt->bind_param("iii", $idUsuario, $limit, $offset);
            } else {
                $stmt->bind_param("i", $idUsuario);
            }
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            $favoritos = [];
            while ($row = $result->fetch_assoc()) {
                $favoritos[] = $row;
            }
            
            return $favoritos;
            
        } catch (Exception $e) {
            error_log("Error en obtenerFavoritosUsuario: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtener estadísticas de favoritos
     */
    public function obtenerEstadisticasFavoritos($idUsuario = null) {
        try {
            if (!$this->conexion) {
                return [];
            }
            
            $sql = "SELECT 
                        COUNT(*) as total_favoritos,
                        COUNT(DISTINCT f.id_propiedad) as propiedades_unicas,
                        COUNT(DISTINCT f.id_usuario) as usuarios_con_favoritos
                    FROM favoritos f";
            
            $params = [];
            $paramTypes = "";
            
            if ($idUsuario) {
                $sql .= " WHERE f.id_usuario = ?";
                $params[] = $idUsuario;
                $paramTypes .= "i";
            }
            
            $stmt = $this->conexion->prepare($sql);
            
            if (!$stmt) {
                return [];
            }
            
            if (!empty($params)) {
                $stmt->bind_param($paramTypes, ...$params);
            }
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->fetch_assoc();
            
        } catch (Exception $e) {
            error_log("Error en obtenerEstadisticasFavoritos: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Toggle favorito (agregar si no existe, eliminar si existe)
     */
    public function toggleFavorito($idUsuario, $idPropiedad) {
        try {
            if ($this->esFavorito($idUsuario, $idPropiedad)) {
                return $this->eliminarFavorito($idUsuario, $idPropiedad);
            } else {
                return $this->agregarFavorito($idUsuario, $idPropiedad);
            }
        } catch (Exception $e) {
            error_log("Error en toggleFavorito: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error del sistema al cambiar estado de favorito'];
        }
    }
}
?>

