<?php
/**
 * Controlador de Propiedades para Administración
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja toda la lógica de gestión administrativa de propiedades
 */

class PropiedadController {
    private $propertyModel;
    private $imageModel;
    
    public function __construct() {
        // Incluir los modelos
        require_once __DIR__ . '/../models/PropertyModel.php';
        require_once __DIR__ . '/../models/ImageModel.php';
        
        $this->propertyModel = new PropertyModel();
        $this->imageModel = new ImageModel();
        
        // Iniciar sesión para todos los métodos
        session_start();
    }

    // =============================================================================
    // MÉTODOS PÚBLICOS (sin autenticación requerida)
    // =============================================================================
    
    /**
     * Mostrar página principal con propiedades destacadas
     */
    public function home() {
        $this->checkPublicAccess();
        
        try {
            // Obtener propiedades destacadas
            $propiedadesDestacadas = $this->propertyModel->getFeaturedProperties(6);
            
            // Agregar imagen principal a cada propiedad
            foreach ($propiedadesDestacadas as &$propiedad) {
                $imagenPrincipal = $this->imageModel->getMainImage($propiedad['id_propiedad']);
                if ($imagenPrincipal) {
                    $propiedad['imagen_principal'] = BASE_URL . 'public/img/' . $imagenPrincipal['url_imagen'];
                } else {
                    $propiedad['imagen_principal'] = BASE_URL . 'public/img/edificio.jpg';
                }
            }
            
            // Obtener estadísticas
            $stats = $this->propertyModel->getPropertyStats();
            
        } catch (Exception $e) {
            // Si hay error, usar datos por defecto
            $propiedadesDestacadas = [];
            $stats = [
                'total_propiedades' => 0,
                'propiedades_disponibles' => 0,
                'propiedades_vendidas' => 0,
                'propiedades_alquiladas' => 0
            ];
        }
        
        // Incluir la vista de la página principal
        // La vista incluye el layout completo
        include __DIR__ . '/../views/home/index.php';
    }
    
    /**
     * Verificar acceso de administrador
     */
    private function checkAdminAccess() {
        session_start();
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'index.php?route=auth/login');
            exit;
        }
        
        if ($_SESSION['user_type'] !== 'admin') {
            header('Location: ' . BASE_URL);
            exit;
        }
    }
    
    /**
     * Verificar acceso público (sin autenticación requerida)
     */
    private function checkPublicAccess() {
        // No requiere autenticación para métodos públicos
        // La sesión ya se inició en el constructor
    }
    
    /**
     * Mostrar gestión de propiedades
     */
    public function index() {
        $this->checkAdminAccess();
        $pageTitle = 'Gestión de Propiedades';
        
        // Obtener filtros de la URL
        $filters = [];
        if (isset($_GET['estado'])) {
            $filters['estado'] = $_GET['estado'];
        }
        if (isset($_GET['tipo'])) {
            $filters['tipo'] = $_GET['tipo'];
        }
        if (isset($_GET['tipo_propiedad'])) {
            $filters['tipo_propiedad'] = $_GET['tipo_propiedad'];
        }
        
        // Obtener propiedades de la base de datos
        $propiedades = $this->propertyModel->getAllProperties(20, 0, $filters);
        
        // Obtener estadísticas
        $stats = $this->propertyModel->getPropertyStats();
        
        // Incluir la vista de propiedades
        include __DIR__ . '/../views/admin/property/propiedades.php';
    }
    
    /**
     * Mostrar formulario de creación de propiedad
     */
    public function create() {
        $this->checkAdminAccess();
        $pageTitle = 'Crear Nueva Propiedad';
        
        // Obtener ciudades y barrios para el formulario
        $ciudades = $this->propertyModel->getCiudades();
        $barrios = $this->propertyModel->getBarrios();
        
        // Incluir la vista de creación
        include __DIR__ . '/../views/admin/property/crearPropiedad.php';
    }
    
    /**
     * Procesar creación de nueva propiedad
     */
    public function store() {
        $this->checkAdminAccess();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
            exit;
        }
        
        try {
            $data = [
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'tipo' => $_POST['tipo'],
                'precio' => $_POST['precio'],
                'area' => $_POST['area'],
                'habitaciones' => $_POST['habitaciones'],
                'banos' => $_POST['banos'],
                'parqueadero' => isset($_POST['parqueadero']) ? 1 : 0,
                'direccion' => $_POST['direccion'],
                'id_ciudad' => $_POST['id_ciudad'] ?? null,
                'id_barrio' => $_POST['id_barrio'] ?? null,
                'id_usuario' => $_SESSION['user_id'],
                'tipo_propiedad' => $_POST['tipo_propiedad'],
                'destacado' => isset($_POST['destacado']) ? 1 : 0,
                'precio_negociable' => isset($_POST['precio_negociable']) ? 1 : 0
            ];
            
            $propertyId = $this->propertyModel->createProperty($data);
            
            $_SESSION['success_message'] = 'Propiedad creada exitosamente';
            header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
            exit;
            
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Error al crear la propiedad: ' . $e->getMessage();
            header('Location: ' . BASE_URL . 'index.php?route=admin/crear-propiedad');
            exit;
        }
    }
    
    /**
     * Mostrar formulario de edición de propiedad
     */
    public function edit($id) {
        $this->checkAdminAccess();
        $pageTitle = 'Editar Propiedad';
        
        // Obtener datos de la propiedad
        $propiedad = $this->propertyModel->getPropertyById($id);
        
        if (!$propiedad) {
            $_SESSION['error_message'] = 'Propiedad no encontrada';
            header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
            exit;
        }
        
        // Obtener ciudades y barrios para el formulario
        $ciudades = $this->propertyModel->getCiudades();
        $barrios = $this->propertyModel->getBarrios();
        
        include __DIR__ . '/../views/admin/property/editarPropiedad.php';
    }
    
    /**
     * Procesar actualización de propiedad
     */
    public function update($id) {
        $this->checkAdminAccess();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
            exit;
        }
        
        try {
            $data = [
                'titulo' => $_POST['titulo'],
                'descripcion' => $_POST['descripcion'],
                'tipo' => $_POST['tipo'],
                'precio' => $_POST['precio'],
                'area' => $_POST['area'],
                'habitaciones' => $_POST['habitaciones'],
                'banos' => $_POST['banos'],
                'parqueadero' => isset($_POST['parqueadero']) ? 1 : 0,
                'direccion' => $_POST['direccion'],
                'id_ciudad' => $_POST['id_ciudad'] ?? null,
                'id_barrio' => $_POST['id_barrio'] ?? null,
                'estado' => $_POST['estado'],
                'tipo_propiedad' => $_POST['tipo_propiedad'],
                'destacado' => isset($_POST['destacado']) ? 1 : 0,
                'precio_negociable' => isset($_POST['precio_negociable']) ? 1 : 0
            ];
            
            $this->propertyModel->updateProperty($id, $data);
            
            $_SESSION['success_message'] = 'Propiedad actualizada exitosamente';
            header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
            exit;
            
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Error al actualizar la propiedad: ' . $e->getMessage();
            header('Location: ' . BASE_URL . 'index.php?route=admin/editar-propiedad&id=' . $id);
            exit;
        }
    }
    
    /**
     * Eliminar propiedad
     */
    public function delete($id) {
        $this->checkAdminAccess();
        try {
            $this->propertyModel->deleteProperty($id);
            $_SESSION['success_message'] = 'Propiedad eliminada exitosamente';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Error al eliminar la propiedad: ' . $e->getMessage();
        }
        
        header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
        exit;
    }
    
    /**
     * Cambiar estado de propiedad
     */
    public function changeStatus($id) {
        $this->checkAdminAccess();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $estado = $_POST['estado'];
                $this->propertyModel->changePropertyStatus($id, $estado);
                $_SESSION['success_message'] = 'Estado actualizado exitosamente';
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Error al actualizar el estado: ' . $e->getMessage();
            }
        }
        
        header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
        exit;
    }
    
    /**
     * Toggle destacado
     */
    public function toggleFeatured($id) {
        $this->checkAdminAccess();
        try {
            $this->propertyModel->toggleFeatured($id);
            $_SESSION['success_message'] = 'Estado destacado actualizado';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Error al actualizar el estado destacado: ' . $e->getMessage();
        }
        
        header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
        exit;
    }
    
    
    
    /**
     * Mostrar todas las propiedades públicas
     */
    public function publicIndex() {
        $this->checkPublicAccess();
        
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
        $this->checkPublicAccess();
        
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
        
        // Incluir la vista
        include __DIR__ . '/../views/public/detallePropiedad.php';
    }
    
    /**
     * Buscar propiedades
     */
    public function buscar() {
        $this->checkPublicAccess();
        
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
        $this->checkPublicAccess();
        
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
