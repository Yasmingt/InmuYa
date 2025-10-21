<?php
/**
 * Controlador de Propiedades
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja toda la funcionalidad relacionada con propiedades (pública y administrativa)
 */

class PropiedadController {
    private $propiedadModel;
    private $imageModel;
    private $favoritosModel;
    
    public function __construct() {
        // Incluir los modelos
        require_once __DIR__ . '/../models/PropiedadModel.php';
        require_once __DIR__ . '/../models/ImageModel.php';
        require_once __DIR__ . '/../models/FavoritosModel.php';
        
        $this->propiedadModel = new PropiedadModel();
        $this->imageModel = new ImageModel();
        $this->favoritosModel = new FavoritosModel();
    }
    
    /**
     * Mostrar página principal
     */
    public function index() {
        // Obtener propiedades destacadas
        $propiedadesDestacadas = $this->propiedadModel->obtenerPropiedadesDestacadas(6);
        
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
        $stats = $this->propiedadModel->obtenerEstadisticasDePropiedades();
        
        // Incluir la vista
        include __DIR__ . '/../views/home/index.php';
    }
    
    /** Obtener propiedades destacadas */
    public function destacadas() {
        $propiedades = $this->propiedadModel->obtenerPropiedadesDestacadas(6);
        
        // Agregar imagen principal a cada propiedad
        foreach ($propiedades as &$propiedad) {
            $imagenPrincipal = $this->imageModel->getMainImage($propiedad['id_propiedad']);
            $propiedad['imagen_principal'] = $imagenPrincipal ? 
                BASE_URL . 'public/img/' . $imagenPrincipal['url_imagen'] : 
                BASE_URL . 'public/img/edificio.jpg';
        }
        
        return $propiedades;
    }
    
    /** Verificar acceso de administrador */
    private function checkAdminAccess() {
        session_start();
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
        
        if ($_SESSION['user_type'] !== 'admin') {
            header('Location: ' . BASE_URL);
            exit;
        }
    }
    
    /**
     * Mostrar gestión de propiedades (admin)
     */
    public function adminPropiedades() {
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
        $propiedades = $this->propiedadModel->obtenerTodasLasPropiedades(20, 0, $filters);
        
        // Obtener estadísticas
        $stats = $this->propiedadModel->obtenerEstadisticasDePropiedades();
        
        // Incluir la vista de propiedades
        include __DIR__ . '/../views/admin/property/propiedades.php';
    }
    
    /**
     * Crear nueva propiedad (admin)
     */
    public function crearPropiedad() {
        // Verificar sesión de administrador
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
            header('Location: ' . BASE_URL . 'index.php?route=auth/login');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                
                $propertyId = $this->propiedadModel->crearNuevaPropiedad($data);
                
                $_SESSION['success_message'] = 'Propiedad creada exitosamente';
                header('Location: ' . BASE_URL . 'index.php?route=admin/propiedades');
                exit;
                
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Error al crear la propiedad: ' . $e->getMessage();
            }
        }
        
        // Mostrar formulario de creación
        include __DIR__ . '/../views/admin/property/crearPropiedad.php';
    }
    
    /**Editar propiedad (admin)*/
    public function editarPropiedad($id) {        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                
                $this->propiedadModel->actualizarPropiedad($id, $data);
                
                $_SESSION['success_message'] = 'Propiedad actualizada exitosamente';
                header('Location: ' . BASE_URL . 'admin/propiedades');
                exit;
                
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Error al actualizar la propiedad: ' . $e->getMessage();
            }
        }
        
        // Obtener datos de la propiedad
        $propiedad = $this->propiedadModel->obtenerPropiedadPorId($id);
        
        if (!$propiedad) {
            $_SESSION['error_message'] = 'Propiedad no encontrada';
            header('Location: ' . BASE_URL . 'admin/propiedades');
            exit;
        }
        
        include __DIR__ . '/../views/admin/property/editarPropiedad.php';
    }
    
    /**
     * Eliminar propiedad (admin)
     */
    public function eliminarPropiedad($id) {        
        try {
            $this->propiedadModel->eliminarPropiedad($id);
            $_SESSION['success_message'] = 'Propiedad eliminada exitosamente';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Error al eliminar la propiedad: ' . $e->getMessage();
        }
        
        header('Location: ' . BASE_URL . 'admin/propiedades');
        exit;
    }
    
    /**
     * Cambiar estado de propiedad (admin)
     */
    public function cambiarEstadoPropiedad($id) {        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $estado = $_POST['estado'];
                $this->propiedadModel->cambiarEstadoPropiedad($id, $estado);
                $_SESSION['success_message'] = 'Estado actualizado exitosamente';
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Error al actualizar el estado: ' . $e->getMessage();
            }
        }
        
        header('Location: ' . BASE_URL . 'admin/propiedades');
        exit;
    }
    
    /**
     * Toggle destacado (admin)
     */
    public function toggleDestacado($id) {        
        try {
            $this->propiedadModel->toggleDestacado($id);
            $_SESSION['success_message'] = 'Estado destacado actualizado';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Error al actualizar el estado destacado: ' . $e->getMessage();
        }
        
        header('Location: ' . BASE_URL . 'admin/propiedades');
        exit;
    }
    
    /**
     * Agregar/quitar propiedad de favoritos (AJAX)
     */
    public function toggleFavorito() {
        // Verificar que sea una petición AJAX
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Petición inválida']);
            exit;
        }
        
        // Verificar que el usuario esté logueado
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión para usar favoritos']);
            exit;
        }
        
        // Obtener datos del POST
        $input = json_decode(file_get_contents('php://input'), true);
        $idPropiedad = $input['id_propiedad'] ?? null;
        
        if (!$idPropiedad || !is_numeric($idPropiedad)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID de propiedad inválido']);
            exit;
        }
        
        try {
            $resultado = $this->favoritosModel->toggleFavorito($_SESSION['user_id'], $idPropiedad);
            
            // Agregar información adicional
            $resultado['es_favorito'] = $this->favoritosModel->esFavorito($_SESSION['user_id'], $idPropiedad);
            
            header('Content-Type: application/json');
            echo json_encode($resultado);
            
        } catch (Exception $e) {
            error_log("Error en toggleFavorito: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error del servidor']);
        }
    }
    
    /**
     * Verificar si una propiedad es favorita (AJAX)
     */
    public function verificarFavorito() {
        // Verificar que sea una petición AJAX
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Petición inválida']);
            exit;
        }
        
        // Verificar que el usuario esté logueado
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
            exit;
        }
        
        $idPropiedad = $_GET['id_propiedad'] ?? null;
        
        if (!$idPropiedad || !is_numeric($idPropiedad)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID de propiedad inválido']);
            exit;
        }
        
        try {
            $esFavorito = $this->favoritosModel->esFavorito($_SESSION['user_id'], $idPropiedad);
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'es_favorito' => $esFavorito
            ]);
            
        } catch (Exception $e) {
            error_log("Error en verificarFavorito: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error del servidor']);
        }
    }
    
    /**
     * Mostrar página de favoritos del usuario
     */
    public function misFavoritos() {
        // Verificar que el usuario esté logueado
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
        
        try {
            // Obtener favoritos del usuario
            $favoritos = $this->favoritosModel->obtenerFavoritosUsuario($_SESSION['user_id'], 20, 0);
            
            // Agregar imagen principal a cada propiedad
            foreach ($favoritos as &$propiedad) {
                $imagenPrincipal = $this->imageModel->getMainImage($propiedad['id_propiedad']);
                $propiedad['imagen_principal'] = $imagenPrincipal ? 
                    BASE_URL . 'public/img/' . $imagenPrincipal['url_imagen'] : 
                    BASE_URL . 'public/img/edificio.jpg';
            }
            
            // Obtener estadísticas
            $stats = $this->favoritosModel->obtenerEstadisticasFavoritos($_SESSION['user_id']);
            
            // Incluir la vista
            include __DIR__ . '/../views/public/misFavoritos.php';
            
        } catch (Exception $e) {
            error_log("Error en misFavoritos: " . $e->getMessage());
            $_SESSION['error_message'] = 'Error al cargar tus favoritos';
            header('Location: ' . BASE_URL);
            exit;
        }
    }
}
?>
