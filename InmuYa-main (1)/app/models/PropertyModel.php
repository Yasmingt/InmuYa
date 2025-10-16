<?php
/**
 * Modelo de Propiedades
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja todas las operaciones relacionadas con propiedades en la base de datos
 */

class PropertyModel {
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
     * Obtener todas las propiedades
     */
    public function getAllProperties($limit = null, $offset = 0, $filters = []) {
        $sql = "SELECT p.*, c.nombre as ciudad_nombre, b.nombre as barrio_nombre, u.nombre as usuario_nombre,
                       i.url_imagen as imagen_principal
                FROM propiedades p 
                LEFT JOIN ciudades c ON p.id_ciudad = c.id_ciudad 
                LEFT JOIN barrios b ON p.id_barrio = b.id_barrio 
                LEFT JOIN usuarios u ON p.id_usuario = u.id_usuario 
                LEFT JOIN imagenes i ON p.id_propiedad = i.id_propiedad AND i.es_principal = 1 AND i.activo = 1
                WHERE 1=1";
        
        // Aplicar filtros
        if (!empty($filters['estado'])) {
            $sql .= " AND p.estado = ?";
        }
        if (!empty($filters['tipo'])) {
            $sql .= " AND p.tipo = ?";
        }
        if (!empty($filters['tipo_propiedad'])) {
            $sql .= " AND p.tipo_propiedad = ?";
        }
        if (!empty($filters['destacado'])) {
            $sql .= " AND p.destacado = ?";
        }
        
        $sql .= " ORDER BY p.destacado DESC, p.fecha_publicacion DESC";
        
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
        }
        
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        // Bind parameters para filtros
        $paramTypes = "";
        $paramValues = [];
        
        if (!empty($filters['estado'])) {
            $paramTypes .= "s";
            $paramValues[] = $filters['estado'];
        }
        if (!empty($filters['tipo'])) {
            $paramTypes .= "s";
            $paramValues[] = $filters['tipo'];
        }
        if (!empty($filters['tipo_propiedad'])) {
            $paramTypes .= "s";
            $paramValues[] = $filters['tipo_propiedad'];
        }
        if (!empty($filters['destacado'])) {
            $paramTypes .= "i";
            $paramValues[] = $filters['destacado'];
        }
        
        if ($limit) {
            $paramTypes .= "ii";
            $paramValues[] = $limit;
            $paramValues[] = $offset;
        }
        
        if (!empty($paramValues)) {
            $stmt->bind_param($paramTypes, ...$paramValues);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $properties = [];
        while ($row = $result->fetch_assoc()) {
            // Construir la URL completa de la imagen
            if ($row['imagen_principal']) {
                $row['imagen_principal'] = BASE_URL . 'public/img/propiedades/propiedad_' . $row['id_propiedad'] . '/' . $row['imagen_principal'];
            } else {
                // Imagen por defecto si no hay imagen principal
                $row['imagen_principal'] = BASE_URL . 'public/img/edificio.jpg';
            }
            $properties[] = $row;
        }
        
        return $properties;
    }
    
    /**
     * Obtener propiedad por ID
     */
    public function getPropertyById($id) {
        $sql = "SELECT p.*, c.nombre as ciudad_nombre, b.nombre as barrio_nombre, u.nombre as usuario_nombre 
                FROM propiedades p 
                LEFT JOIN ciudades c ON p.id_ciudad = c.id_ciudad 
                LEFT JOIN barrios b ON p.id_barrio = b.id_barrio 
                LEFT JOIN usuarios u ON p.id_usuario = u.id_usuario 
                WHERE p.id_propiedad = ?";
        
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        
        return false;
    }
    
    /**
     * Crear nueva propiedad
     */
    public function createProperty($data) {
        $sql = "INSERT INTO propiedades (
            titulo, descripcion, tipo, precio, area, habitaciones, banos, parqueadero,
            direccion, id_ciudad, id_barrio, id_usuario, estado, tipo_propiedad,
            destacado, precio_negociable, activo
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("sssddiiisiiisssii", 
            $data['titulo'],
            $data['descripcion'],
            $data['tipo'],
            $data['precio'],
            $data['area'],
            $data['habitaciones'],
            $data['banos'],
            $data['parqueadero'],
            $data['direccion'],
            $data['id_ciudad'],
            $data['id_barrio'],
            $data['id_usuario'],
            $data['estado'] ?? 'disponible',
            $data['tipo_propiedad'],
            $data['destacado'] ?? 0,
            $data['precio_negociable'] ?? 1,
            $data['activo'] ?? 1
        );
        
        $result = $stmt->execute();
        
        if (!$result) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
        
        return $stmt->insert_id;
    }
    
    /**
     * Actualizar propiedad
     */
    public function updateProperty($id, $data) {
        $sql = "UPDATE propiedades SET 
            titulo = ?, descripcion = ?, tipo = ?, precio = ?, area = ?, 
            habitaciones = ?, banos = ?, parqueadero = ?, direccion = ?, 
            id_ciudad = ?, id_barrio = ?, estado = ?, tipo_propiedad = ?, 
            destacado = ?, precio_negociable = ?
            WHERE id_propiedad = ?";
        
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("sssddiiisiiisii", 
            $data['titulo'],
            $data['descripcion'],
            $data['tipo'],
            $data['precio'],
            $data['area'],
            $data['habitaciones'],
            $data['banos'],
            $data['parqueadero'],
            $data['direccion'],
            $data['id_ciudad'],
            $data['id_barrio'],
            $data['estado'],
            $data['tipo_propiedad'],
            $data['destacado'],
            $data['precio_negociable'],
            $id
        );
        
        return $stmt->execute();
    }
    
    /**
     * Eliminar propiedad (soft delete)
     */
    public function deleteProperty($id) {
        $sql = "DELETE FROM propiedades WHERE id_propiedad = ?";
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    /**
     * Cambiar estado de propiedad
     */
    public function changePropertyStatus($id, $estado) {
        $estadosValidos = ['disponible', 'vendido', 'arrendado', 'reservado', 'inactivo'];
        
        if (!in_array($estado, $estadosValidos)) {
            throw new Exception("Estado no válido");
        }
        
        $sql = "UPDATE propiedades SET estado = ? WHERE id_propiedad = ?";
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("si", $estado, $id);
        
        return $stmt->execute();
    }
    
    /**
     * Marcar/desmarcar propiedad como destacada
     */
    public function toggleFeatured($id) {
        $sql = "UPDATE propiedades SET destacado = NOT destacado WHERE id_propiedad = ?";
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    /**
     * Obtener propiedades destacadas
     */
    public function getFeaturedProperties($limit = 6) {
        $sql = "SELECT p.*, c.nombre as ciudad_nombre, b.nombre as barrio_nombre
                FROM propiedades p 
                LEFT JOIN ciudades c ON p.id_ciudad = c.id_ciudad 
                LEFT JOIN barrios b ON p.id_barrio = b.id_barrio 
                WHERE p.destacado = 1 AND p.estado = 'disponible'
                ORDER BY p.fecha_publicacion DESC 
                LIMIT ?";
        
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $properties = [];
        while ($row = $result->fetch_assoc()) {
            $properties[] = $row;
        }
        
        return $properties;
    }
    
    /**
     * Obtener estadísticas de propiedades
     */
    public function getPropertyStats() {
        $stats = [];
        
        // Total de propiedades
        $result = $this->conexion->query("SELECT COUNT(*) as total FROM propiedades");
        $stats['total_properties'] = $result->fetch_assoc()['total'];
        
        // Propiedades por tipo
        $result = $this->conexion->query("SELECT tipo, COUNT(*) as count FROM propiedades GROUP BY tipo");
        $stats['by_type'] = [];
        while ($row = $result->fetch_assoc()) {
            $stats['by_type'][$row['tipo']] = $row['count'];
        }
        
        // Propiedades por estado
        $result = $this->conexion->query("SELECT estado, COUNT(*) as count FROM propiedades GROUP BY estado");
        $stats['by_status'] = [];
        while ($row = $result->fetch_assoc()) {
            $stats['by_status'][$row['estado']] = $row['count'];
        }
        
        // Propiedades destacadas
        $result = $this->conexion->query("SELECT COUNT(*) as count FROM propiedades WHERE destacado = 1");
        $stats['featured'] = $result->fetch_assoc()['count'];
        
        return $stats;
    }
    
    /**
     * Buscar propiedades
     */
    public function searchProperties($searchTerm, $filters = []) {
        $sql = "SELECT p.*, c.nombre as ciudad_nombre, b.nombre as barrio_nombre 
                FROM propiedades p 
                LEFT JOIN ciudades c ON p.id_ciudad = c.id_ciudad 
                LEFT JOIN barrios b ON p.id_barrio = b.id_barrio 
                WHERE (
                    p.titulo LIKE ? OR 
                    p.descripcion LIKE ? OR 
                    p.direccion LIKE ? OR
                    c.nombre LIKE ? OR
                    b.nombre LIKE ?
                )";
        
        // Aplicar filtros adicionales
        if (!empty($filters['tipo'])) {
            $sql .= " AND p.tipo = ?";
        }
        if (!empty($filters['precio_min'])) {
            $sql .= " AND p.precio >= ?";
        }
        if (!empty($filters['precio_max'])) {
            $sql .= " AND p.precio <= ?";
        }
        
        $sql .= " ORDER BY p.destacado DESC, p.fecha_publicacion DESC";
        
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $searchPattern = "%{$searchTerm}%";
        $paramTypes = "sssss";
        $paramValues = [$searchPattern, $searchPattern, $searchPattern, $searchPattern, $searchPattern];
        
        if (!empty($filters['tipo'])) {
            $paramTypes .= "s";
            $paramValues[] = $filters['tipo'];
        }
        if (!empty($filters['precio_min'])) {
            $paramTypes .= "d";
            $paramValues[] = $filters['precio_min'];
        }
        if (!empty($filters['precio_max'])) {
            $paramTypes .= "d";
            $paramValues[] = $filters['precio_max'];
        }
        
        $stmt->bind_param($paramTypes, ...$paramValues);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $properties = [];
        while ($row = $result->fetch_assoc()) {
            $properties[] = $row;
        }
        
        return $properties;
    }
}
?>
