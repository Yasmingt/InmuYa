<?php
/**
 * Controlador de Administración
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja toda la lógica del panel de administración
 */

class AdminController {
    private $userModel;
    
    public function __construct() {
        // Incluir el modelo de usuario
        require_once __DIR__ . '/../models/UserModel.php';
        $this->userModel = new UserModel();
        
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
        $stats = $this->userModel->getUserStats();
        
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
        
        // Aquí se obtendrían las propiedades de un PropertyModel
        $propiedades = []; // Por ahora vacío
        
        // Incluir la vista de propiedades
        include __DIR__ . '/../views/property/propiedades.php';
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
