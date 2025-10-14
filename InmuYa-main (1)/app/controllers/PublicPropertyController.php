<?php
/**
 * Controlador Público de Propiedades
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja la visualización pública de propiedades
 */

class PublicPropertyController {
    private $propertyModel;
    private $imageModel;
    
    public function __construct() {
        // Incluir los modelos
        require_once __DIR__ . '/../models/PropertyModel.php';
        require_once __DIR__ . '/../models/ImageModel.php';
        
        $this->propertyModel = new PropertyModel();
        $this->imageModel = new ImageModel();
    }
    
    /**
     * Mostrar todas las propiedades públicas
     */
    public function index() {
        // Obtener filtros de la URL
        $filters = [];
        if (isset($_GET['tipo'])) {
            $filters['tipo'] = $_GET['tipo'];
        }
        if (isset($_GET['tipo_propiedad'])) {
            $filters['tipo_propiedad'] = $_GET['tipo_propiedad'];
        }
        if (isset($_GET['precio_min'])) {
            $filters['precio_min'] = $_GET['precio_min'];
        }
        if (isset($_GET['precio_max'])) {
            $filters['precio_max'] = $_GET['precio_max'];
        }
        
        // Solo mostrar propiedades disponibles
        $filters['estado'] = 'disponible';
        
        // Obtener propiedades
        $propiedades = $this->propertyModel->getAllProperties(12, 0, $filters);
        
        // Agregar imagen principal a cada propiedad
        foreach ($propiedades as &$propiedad) {
            $imagenPrincipal = $this->imageModel->getMainImage($propiedad['id_propiedad']);
            $propiedad['imagen_principal'] = $imagenPrincipal ? 
                BASE_URL . 'public/img/' . $imagenPrincipal['url_imagen'] : 
                BASE_URL . 'public/img/edificio.jpg'; // Imagen por defecto
        }
        
        // Obtener estadísticas
        $stats = $this->propertyModel->getPropertyStats();
        
        // Incluir la vista
        include __DIR__ . '/../views/public/propiedades.php';
    }
    
    /**
     * Mostrar detalles de una propiedad específica
     */
    public function verPropiedad($propertyId) {
        // Obtener información de la propiedad
        $propiedad = $this->propertyModel->getPropertyById($propertyId);
        
        if (!$propiedad || $propiedad['estado'] !== 'disponible') {
            $_SESSION['error_message'] = 'Propiedad no encontrada o no disponible';
            header('Location: ' . BASE_URL . 'propiedades');
            exit;
        }
        
        // Obtener todas las imágenes de la propiedad
        $imagenes = $this->imageModel->getImagesByProperty($propertyId);
        
        // Agregar URLs completas a las imágenes
        foreach ($imagenes as &$imagen) {
            $imagen['url_completa'] = BASE_URL . 'public/img/' . $imagen['url_imagen'];
            $imagen['url_thumb'] = BASE_URL . 'public/img/' . str_replace('.', '_thumb.', $imagen['url_imagen']);
        }
        
        // Obtener propiedades relacionadas (mismo tipo)
        $propiedadesRelacionadas = $this->propertyModel->getAllProperties(4, 0, [
            'tipo' => $propiedad['tipo'],
            'estado' => 'disponible'
        ]);
        
        // Agregar imagen principal a propiedades relacionadas
        foreach ($propiedadesRelacionadas as &$prop) {
            if ($prop['id_propiedad'] != $propertyId) {
                $imagenPrincipal = $this->imageModel->getMainImage($prop['id_propiedad']);
                $prop['imagen_principal'] = $imagenPrincipal ? 
                    BASE_URL . 'public/img/' . $imagenPrincipal['url_imagen'] : 
                    BASE_URL . 'public/img/edificio.jpg';
            }
        }
        
        // Incrementar contador de vistas
        $this->propertyModel->incrementViews($propertyId);
        
        // Incluir la vista
        include __DIR__ . '/../views/public/detallePropiedad.php';
    }
    
    /**
     * Buscar propiedades
     */
    public function buscar() {
        $searchTerm = $_GET['q'] ?? '';
        $filters = [];
        
        if (isset($_GET['tipo'])) {
            $filters['tipo'] = $_GET['tipo'];
        }
        if (isset($_GET['precio_min'])) {
            $filters['precio_min'] = $_GET['precio_min'];
        }
        if (isset($_GET['precio_max'])) {
            $filters['precio_max'] = $_GET['precio_max'];
        }
        
        if (!empty($searchTerm)) {
            $propiedades = $this->propertyModel->searchProperties($searchTerm, $filters);
        } else {
            $filters['estado'] = 'disponible';
            $propiedades = $this->propertyModel->getAllProperties(20, 0, $filters);
        }
        
        // Agregar imagen principal a cada propiedad
        foreach ($propiedades as &$propiedad) {
            $imagenPrincipal = $this->imageModel->getMainImage($propiedad['id_propiedad']);
            $propiedad['imagen_principal'] = $imagenPrincipal ? 
                BASE_URL . 'public/img/' . $imagenPrincipal['url_imagen'] : 
                BASE_URL . 'public/img/edificio.jpg';
        }
        
        // Incluir la vista
        include __DIR__ . '/../views/public/buscarPropiedades.php';
    }
    
    /**
     * Obtener propiedades destacadas
     */
    public function destacadas() {
        $propiedades = $this->propertyModel->getFeaturedProperties(6);
        
        // Agregar imagen principal a cada propiedad
        foreach ($propiedades as &$propiedad) {
            $imagenPrincipal = $this->imageModel->getMainImage($propiedad['id_propiedad']);
            $propiedad['imagen_principal'] = $imagenPrincipal ? 
                BASE_URL . 'public/img/' . $imagenPrincipal['url_imagen'] : 
                BASE_URL . 'public/img/edificio.jpg';
        }
        
        return $propiedades;
    }
}
?>
