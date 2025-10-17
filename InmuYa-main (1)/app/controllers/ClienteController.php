<?php
/**
 * Controlador de Clientes
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja toda la lógica relacionada con el panel de clientes
 */

require_once __DIR__ . '/../models/PropertyModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/ImageModel.php';

class ClienteController {
    private $propertyModel;
    private $userModel;
    private $imageModel;
    
    public function __construct() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->propertyModel = new PropertyModel();
        $this->userModel = new UserModel();
        $this->imageModel = new ImageModel();
    }
    
    /**
     * Verificar acceso de cliente
     */
    private function checkClienteAccess() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'index.php?route=auth/login');
            exit();
        }
        
        // Verificar que el usuario sea cliente (tipo_usuario = 'cliente')
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        if (!$user || $user['tipo_usuario'] !== 'cliente') {
            header('Location: ' . BASE_URL . 'index.php?route=auth/login');
            exit();
        }
    }
    
    /**
     * Dashboard del cliente - Redirige a propiedades
     */
    public function dashboard() {
        $this->checkClienteAccess();
        
        // Redirigir directamente a propiedades ya que es la funcionalidad principal
        header('Location: ' . BASE_URL . 'index.php?route=propiedades');
        exit;
    }
    
    
    /**
     * Ver propiedades contactadas
     */
    public function contactos() {
        $this->checkClienteAccess();
        $userId = $_SESSION['user_id'];
        
        // Obtener propiedades contactadas
        $contactos = $this->getContactedProperties($userId);
        
        // Incluir la vista
        include __DIR__ . '/../views/cliente/contactos.php';
    }
    
    
    /**
     * Obtener propiedades recomendadas
     */
    private function getRecommendedProperties($userId, $limit = 6) {
        try {
            // Por ahora, obtener propiedades destacadas como recomendadas
            return $this->propertyModel->getFeaturedProperties($limit);
        } catch (Exception $e) {
            return [];
        }
    }
    
    
    /**
     * Obtener propiedades contactadas
     */
    private function getContactedProperties($userId) {
        try {
            $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "SELECT c.*, p.titulo, p.precio, p.tipo, p.tipo_propiedad,
                           ci.nombre as ciudad_nombre, b.nombre as barrio_nombre,
                           i.url_imagen as imagen_principal
                    FROM contactos c
                    JOIN propiedades p ON c.id_propiedad = p.id_propiedad
                    LEFT JOIN ciudades ci ON p.id_ciudad = ci.id_ciudad
                    LEFT JOIN barrios b ON p.id_barrio = b.id_barrio
                    LEFT JOIN imagenes i ON p.id_propiedad = i.id_propiedad AND i.es_principal = 1 AND i.activo = 1
                    WHERE c.id_usuario = ?
                    ORDER BY c.fecha_contacto DESC";
            
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $contacts = [];
            while ($row = $result->fetch_assoc()) {
                // Construir URL de imagen
                if ($row['imagen_principal']) {
                    $row['imagen_principal'] = BASE_URL . 'public/img/' . $row['imagen_principal'];
                } else {
                    $row['imagen_principal'] = BASE_URL . 'public/img/edificio.jpg';
                }
                $contacts[] = $row;
            }
            
            return $contacts;
        } catch (Exception $e) {
            return [];
        }
    }
    
    /**
     * Guardar búsqueda
     */
    private function saveSearch($userId, $searchData) {
        $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "INSERT INTO busquedas (id_usuario, terminos, tipo, precio_min, precio_max, habitaciones, ciudad, barrio, fecha_busqueda) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("issiiiss", 
            $userId, 
            $searchData['terminos'], 
            $searchData['tipo'], 
            $searchData['precio_min'], 
            $searchData['precio_max'], 
            $searchData['habitaciones'], 
            $searchData['ciudad'], 
            $searchData['barrio']
        );
        $stmt->execute();
    }
}
?>
