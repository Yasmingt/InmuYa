<?php
/**
 * Controlador de la Página Principal
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja la página principal con propiedades destacadas
 */

class HomeController {
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
     * Mostrar página principal
     */
    public function index() {
        // Obtener propiedades destacadas
        $propiedadesDestacadas = $this->propertyModel->getFeaturedProperties(6);
        
        // Agregar imagen principal a cada propiedad
        foreach ($propiedadesDestacadas as &$propiedad) {
            $imagenPrincipal = $this->imageModel->getMainImage($propiedad['id_propiedad']);
            if ($imagenPrincipal) {
                $propiedad['imagen_principal'] = BASE_URL . 'public/img/propiedades/propiedad_' . $propiedad['id_propiedad'] . '/' . $imagenPrincipal['url_imagen'];
            } else {
                $propiedad['imagen_principal'] = BASE_URL . 'public/img/edificio.jpg';
            }
        }
        
        // Obtener estadísticas
        $stats = $this->propertyModel->getPropertyStats();
        
        // Incluir la vista
        include __DIR__ . '/../views/home/index.php';
    }
}
?>
