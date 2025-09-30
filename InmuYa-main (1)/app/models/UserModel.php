<?php
/**
 * Modelo de Usuario
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja todas las operaciones relacionadas con usuarios en la base de datos
 */

class UserModel {
    private $conexion;
    
    public function __construct() {
        // Incluir la conexión a la base de datos
        $conexionPath = __DIR__ . '/../../config/conexion.php';
        
        if (!file_exists($conexionPath)) {
            throw new Exception("Error: No se encontró el archivo de conexión en: " . $conexionPath);
        }
        
        require_once $conexionPath;
        
        // Obtener la conexión de diferentes maneras posibles
        if (isset($conexion)) {
            $this->conexion = $conexion;
        } elseif (isset($GLOBALS['conexion'])) {
            $this->conexion = $GLOBALS['conexion'];
        } else {
            throw new Exception("Error: No se pudo obtener la conexión a la base de datos");
        }
        
        // Verificar que la conexión se estableció correctamente
        if (!$this->conexion || $this->conexion->connect_error) {
            throw new Exception("Error: No se pudo establecer la conexión a la base de datos");
        }
    }
    
    /**
     * Obtener usuario por email
     */
    public function getUserByEmail($email) {
        $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return false;
    }
    
    /**
     * Obtener usuario por ID
     */
    public function getUserById($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return false;
    }
    
    /**
     * Crear nuevo usuario
     */
    public function createUser($data) {
        $sql = "INSERT INTO usuarios (id_usuario, nombre, email, telefono, tipodocumento, numerodocumento, fechadenacimiento, contrasena, tipo_usuario) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("isssissss", 
            $data['id_usuario'], 
            $data['nombre'], 
            $data['email'], 
            $data['telefono'], 
            $data['tipodocumento'], 
            $data['numerodocumento'], 
            $data['fechadenacimiento'], 
            $data['contrasena'], 
            $data['tipo_usuario']
        );
        
        $result = $stmt->execute();
        
        if (!$result) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
        
        return $result;
    }
    
    /**
     * Actualizar usuario
     */
    public function updateUser($id, $data) {
        $sql = "UPDATE usuarios SET nombre = ?, email = ?, telefono = ?, tipodocumento = ?, 
                numerodocumento = ?, fechadenacimiento = ?, tipo_usuario = ? 
                WHERE id_usuario = ?";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("sssisssi", 
            $data['nombre'], 
            $data['email'], 
            $data['telefono'], 
            $data['tipodocumento'], 
            $data['numerodocumento'], 
            $data['fechadenacimiento'], 
            $data['tipo_usuario'], 
            $id
        );
        
        return $stmt->execute();
    }
    
    /**
     * Cambiar contraseña
     */
    public function changePassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $sql = "UPDATE usuarios SET contrasena = ? WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("si", $hashedPassword, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Eliminar usuario
     */
    public function deleteUser($id) {
        $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    /**
     * Obtener todos los usuarios
     */
    public function getAllUsers($limit = null, $offset = 0) {
        $sql = "SELECT * FROM usuarios ORDER BY id_usuario DESC";
        
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
            $stmt = $this->conexion->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error en la consulta SQL: " . $this->conexion->error);
            }
            $stmt->bind_param("ii", $limit, $offset);
        } else {
            $stmt = $this->conexion->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error en la consulta SQL: " . $this->conexion->error);
            }
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        
        return $users;
    }
    
    /**
     * Verificar si el email ya existe
     */
    public function emailExists($email, $excludeId = null) {
        $sql = "SELECT id_usuario FROM usuarios WHERE email = ?";
        
        if ($excludeId) {
            $sql .= " AND id_usuario != ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("si", $email, $excludeId);
        } else {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("s", $email);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }
    
    /**
     * Verificar si la identificación ya existe
     */
    public function idExists($identificacion, $excludeId = null) {
        $sql = "SELECT id_usuario FROM usuarios WHERE id_usuario = ?";
        
        if ($excludeId) {
            $sql .= " AND id_usuario != ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ii", $identificacion, $excludeId);
        } else {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $identificacion);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }
    
    
    /**
     * Obtener estadísticas de usuarios
     */
    public function getUserStats() {
        $stats = [];
        
        // Total de usuarios
        $result = $this->conexion->query("SELECT COUNT(*) as total FROM usuarios");
        $stats['total'] = $result->fetch_assoc()['total'];
        
        // Usuarios por tipo
        $result = $this->conexion->query("SELECT tipo_usuario, COUNT(*) as count FROM usuarios GROUP BY tipo_usuario");
        $stats['by_type'] = [];
        while ($row = $result->fetch_assoc()) {
            $stats['by_type'][$row['tipo_usuario']] = $row['count'];
        }
        
        return $stats;
    }
}
?>
