<?php
/**
 * Modelo de Propiedades
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja todas las operaciones relacionadas con propiedades en la base de datos
 */

class PropiedadModel {
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
    
    /** Obtener todas las propiedades */
    public function obtenerTodasLasPropiedades($limit = null, $offset = 0, $filters = []) {
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
        
        $sql .= " ORDER BY p.fecha_publicacion DESC";
        
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
    
    /** Obtener propiedad por ID */
    public function obtenerPropiedadPorId($id) {
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
    
    /** Crear nueva propiedad */
    public function crearNuevaPropiedad($data) {
        $sql = "INSERT INTO propiedades (
            titulo, descripcion, tipo, precio, area, habitaciones, banos, parqueadero,
            direccion, id_ciudad, id_barrio, id_usuario, estado, tipo_propiedad,
            destacado, piso, ascensor, balcon, terraza, jardin, piscina, gimnasio,
            seguridad_24h, mascotas_permitidas, precio_negociable, incluye_administracion,
            valor_administracion, incluye_servicios, telefono_contacto, email_contacto,
            nombre_contacto, mostrar_telefono, mostrar_email
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("sssddiiisiiissssiiiiiiiiiiisssiii", 
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
            $data['estado'],
            $data['tipo_propiedad'],
            $data['destacado'],
            $data['piso'],
            $data['ascensor'],
            $data['balcon'],
            $data['terraza'],
            $data['jardin'],
            $data['piscina'],
            $data['gimnasio'],
            $data['seguridad_24h'],
            $data['mascotas_permitidas'],
            $data['precio_negociable'],
            $data['incluye_administracion'],
            $data['valor_administracion'],
            $data['incluye_servicios'],
            $data['telefono_contacto'],
            $data['email_contacto'],
            $data['nombre_contacto'],
            $data['mostrar_telefono'],
            $data['mostrar_email']
        );
        
        $result = $stmt->execute();
        
        if (!$result) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
        
        return $stmt->insert_id;
    }
    
    /** Actualizar propiedad */
    public function actualizarPropiedad($id, $data) {
        // Debug: Log datos recibidos en el modelo
        error_log("PropiedadModel::actualizarPropiedad - ID: " . $id);
        error_log("PropiedadModel::actualizarPropiedad - Datos recibidos: " . print_r($data, true));
        error_log("PropiedadModel::actualizarPropiedad - Estado en datos: " . ($data['estado'] ?? 'NO DEFINIDO'));
        
        $sql = "UPDATE propiedades SET 
            titulo = ?, descripcion = ?, tipo = ?, precio = ?, area = ?, 
            habitaciones = ?, banos = ?, parqueadero = ?, direccion = ?, 
            id_ciudad = ?, id_barrio = ?, estado = ?, tipo_propiedad = ?, 
            destacado = ?, piso = ?, ascensor = ?, balcon = ?, 
            terraza = ?, jardin = ?, piscina = ?, gimnasio = ?, seguridad_24h = ?, 
            mascotas_permitidas = ?, precio_negociable = ?, incluye_administracion = ?, 
            valor_administracion = ?, incluye_servicios = ?, telefono_contacto = ?, 
            email_contacto = ?, nombre_contacto = ?, mostrar_telefono = ?, mostrar_email = ?
            WHERE id_propiedad = ?";
        
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("sssddiiisiiissssiiiiiiiiiiisssiii", 
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
            $data['piso'],
            $data['ascensor'],
            $data['balcon'],
            $data['terraza'],
            $data['jardin'],
            $data['piscina'],
            $data['gimnasio'],
            $data['seguridad_24h'],
            $data['mascotas_permitidas'],
            $data['precio_negociable'],
            $data['incluye_administracion'],
            $data['valor_administracion'],
            $data['incluye_servicios'],
            $data['telefono_contacto'],
            $data['email_contacto'],
            $data['nombre_contacto'],
            $data['mostrar_telefono'],
            $data['mostrar_email'],
            $id
        );
        
        $result = $stmt->execute();
        
        if (!$result) {
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
        
        return $result;
    }
    
    /** Eliminar propiedad */
    public function eliminarPropiedad($id) {
        $sql = "DELETE FROM propiedades WHERE id_propiedad = ?";
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    /** Marcar/desmarcar propiedad como destacada */
    public function toggleDestacado($id, $destacado = null) {
        error_log("PropiedadModel::toggleDestacado called with ID: $id, destacado: " . ($destacado ?? 'null'));
        
        if ($destacado !== null) {
            // Valor específico proporcionado
            $sql = "UPDATE propiedades SET destacado = ? WHERE id_propiedad = ?";
            error_log("SQL: $sql with params: $destacado, $id");
            $stmt = $this->conexion->prepare($sql);
            
            if (!$stmt) {
                error_log("Error preparing statement: " . $this->conexion->error);
                throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
            }
            
            $stmt->bind_param("ii", $destacado, $id);
        } else {
            // Toggle automático (comportamiento original)
            $sql = "UPDATE propiedades SET destacado = NOT destacado WHERE id_propiedad = ?";
            error_log("SQL: $sql with param: $id");
            $stmt = $this->conexion->prepare($sql);
            
            if (!$stmt) {
                error_log("Error preparing statement: " . $this->conexion->error);
                throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
            }
            
            $stmt->bind_param("i", $id);
        }
        
        $result = $stmt->execute();
        error_log("Execute result: " . ($result ? 'true' : 'false'));
        
        if (!$result) {
            error_log("Execute error: " . $stmt->error);
            throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
        }
        
        return $result;
    }
    
    /** Obtener propiedades destacadas */
    public function obtenerPropiedadesDestacadas($limit = 6) {
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
    
    /** Obtener estadísticas de propiedades */
    public function obtenerEstadisticasDePropiedades() {
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
     * Obtener todas las ciudades
     */
    public function obtenerCiudades() {
        $sql = "SELECT id_ciudad, nombre FROM ciudades ORDER BY nombre ASC";
        $result = $this->conexion->query($sql);
        
        if (!$result) {
            throw new Exception("Error al obtener ciudades: " . $this->conexion->error);
        }
        
        $ciudades = [];
        while ($row = $result->fetch_assoc()) {
            $ciudades[] = $row;
        }
        
        return $ciudades;
    }
    
    /**
     * Obtener barrios por ciudad
     */
    public function obtenerBarriosPorCiudad($id_ciudad) {
        $sql = "SELECT id_barrio, nombre FROM barrios WHERE id_ciudad = ? ORDER BY nombre ASC";
        $stmt = $this->conexion->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->conexion->error);
        }
        
        $stmt->bind_param("i", $id_ciudad);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $barrios = [];
        while ($row = $result->fetch_assoc()) {
            $barrios[] = $row;
        }
        
        return $barrios;
    }
}
?>
