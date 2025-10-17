<?php
/**
 * Controlador de Administración
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja toda la lógica del panel de administración
 */

class AdminController {
    private $userModel;
    private $contactModel;
    
    public function __construct() {
        // Incluir los modelos
        require_once __DIR__ . '/../models/UserModel.php';
        require_once __DIR__ . '/../models/ContactModel.php';
        
        $this->userModel = new UserModel();
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
            header('Location: ' . BASE_URL . 'index.php?route=auth/login');
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
        
        // Obtener estadísticas de contactos
        $contactStats = $this->contactModel->getContactStats();
        
        // Obtener estadísticas de propiedades (desde PropertyModel)
        require_once __DIR__ . '/../models/PropertyModel.php';
        $propertyModel = new PropertyModel();
        $propertyStats = $propertyModel->getPropertyStats();
        
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
