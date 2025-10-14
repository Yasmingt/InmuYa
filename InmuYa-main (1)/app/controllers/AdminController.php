<?php
/**
 * Controlador de Administración
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja toda la lógica del panel de administración
 */

class AdminController {
    private $userModel;
    private $propertyModel;
    private $contactModel;
    
    public function __construct() {
        // Incluir los modelos
        require_once __DIR__ . '/../models/UserModel.php';
        require_once __DIR__ . '/../models/PropertyModel.php';
        require_once __DIR__ . '/../models/ContactModel.php';
        
        $this->userModel = new UserModel();
        $this->propertyModel = new PropertyModel();
        $this->contactModel = new ContactModel();
        
        // Verificar que el usuario esté autenticado y sea administrador
        $this->checkAdminAccess();
    }
    
    /**
     * Verificar acceso de administrador
     */
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
     * Mostrar dashboard principal
     */
    public function dashboard() {
        // Obtener estadísticas de usuarios
        $userStats = $this->userModel->getUserStats();
        
        // Obtener estadísticas de propiedades
        $propertyStats = $this->propertyModel->getPropertyStats();
        
        // Obtener estadísticas de contactos
        $contactStats = $this->contactModel->getContactStats();
        
        // Combinar todas las estadísticas
        $stats = array_merge($userStats, $propertyStats, $contactStats);
        
        // Obtener usuarios recientes (últimos 4)
        $recent_users = $this->userModel->getAllUsers(4);
         
        // Incluir la vista del dashboard
        include __DIR__ . '/../views/admin/dashboard.php';
    }
    
    /**
     * Mostrar gestión de usuarios
     */
    public function usuarios() {
        $pageTitle = 'Gestión de Usuarios';
        
        // Obtener todos los usuarios
        $users = $this->userModel->getAllUsers();
        
        // Incluir la vista de usuarios
        include __DIR__ . '/../views/user/usuarios.php';
    }
    
    /**
     * Mostrar gestión de propiedades
     */
    public function propiedades() {
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
        include __DIR__ . '/../views/property/propiedades.php';
    }
    
    /**
     * Crear nueva propiedad
     */
    public function crearPropiedad() {
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
                
                $propertyId = $this->propertyModel->createProperty($data);
                
                $_SESSION['success_message'] = 'Propiedad creada exitosamente';
                header('Location: ' . BASE_URL . 'admin/propiedades');
                exit;
                
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Error al crear la propiedad: ' . $e->getMessage();
            }
        }
        
        // Mostrar formulario de creación
        include __DIR__ . '/../views/property/crearPropiedad.php';
    }
    
    /**
     * Editar propiedad
     */
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
                
                $this->propertyModel->updateProperty($id, $data);
                
                $_SESSION['success_message'] = 'Propiedad actualizada exitosamente';
                header('Location: ' . BASE_URL . 'admin/propiedades');
                exit;
                
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Error al actualizar la propiedad: ' . $e->getMessage();
            }
        }
        
        // Obtener datos de la propiedad
        $propiedad = $this->propertyModel->getPropertyById($id);
        
        if (!$propiedad) {
            $_SESSION['error_message'] = 'Propiedad no encontrada';
            header('Location: ' . BASE_URL . 'admin/propiedades');
            exit;
        }
        
        include __DIR__ . '/../views/property/editarPropiedad.php';
    }
    
    /**
     * Eliminar propiedad
     */
    public function eliminarPropiedad($id) {
        try {
            $this->propertyModel->deleteProperty($id);
            $_SESSION['success_message'] = 'Propiedad eliminada exitosamente';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Error al eliminar la propiedad: ' . $e->getMessage();
        }
        
        header('Location: ' . BASE_URL . 'admin/propiedades');
        exit;
    }
    
    /**
     * Cambiar estado de propiedad
     */
    public function cambiarEstadoPropiedad($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $estado = $_POST['estado'];
                $this->propertyModel->changePropertyStatus($id, $estado);
                $_SESSION['success_message'] = 'Estado actualizado exitosamente';
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Error al actualizar el estado: ' . $e->getMessage();
            }
        }
        
        header('Location: ' . BASE_URL . 'admin/propiedades');
        exit;
    }
    
    /**
     * Toggle destacado
     */
    public function toggleDestacado($id) {
        try {
            $this->propertyModel->toggleFeatured($id);
            $_SESSION['success_message'] = 'Estado destacado actualizado';
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Error al actualizar el estado destacado: ' . $e->getMessage();
        }
        
        header('Location: ' . BASE_URL . 'admin/propiedades');
        exit;
    }
    
    /**
     * Mostrar gestión de contactos
     */
    public function contactos() {
        $pageTitle = 'Gestión de Contactos';
        
        // Obtener contactos de la base de datos
        require_once __DIR__ . '/../models/ContactModel.php';
        $contactModel = new ContactModel();
        $contactos = $contactModel->getAllContacts();
        
        // Incluir la vista de contactos
        include __DIR__ . '/../views/contactos/contactos.php';
    }
}
?>
