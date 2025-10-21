<?php
/**
 * Controlador de Administración
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja toda la lógica del panel de administración
 */

class AdminController {
    private $usuarioModel;
    private $propiedadModel;
    private $contactosModel;
    
    public function __construct() {
        // Incluir los modelos
        require_once __DIR__ . '/../models/UsuarioModel.php';
        require_once __DIR__ . '/../models/PropiedadModel.php';
        require_once __DIR__ . '/../models/ContactosModel.php';
        
        $this->usuarioModel = new UsuarioModel();
        $this->propiedadModel = new PropiedadModel();
        $this->contactosModel = new ContactosModel();
        
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
        $userStats = $this->usuarioModel->obtenerEstadisticasUsuarios();
        
        // Obtener estadísticas de propiedades
        $propiedadStats = $this->propiedadModel->obtenerEstadisticasDePropiedades();
        
        // Obtener estadísticas de contactos
        $contactosStats = $this->contactosModel->obtenerEstadisticasContactos();
        
        // Combinar todas las estadísticas
        $stats = array_merge($userStats, $propiedadStats, $contactosStats);
        
        // Obtener usuarios recientes (últimos 4)
        $recent_users = $this->usuarioModel->obtenerTodosLosUsuarios(4);
         
        // Incluir la vista del dashboard
        include __DIR__ . '/../views/admin/dashboard.php';
    }
    
    /**
     * Mostrar gestión de usuarios
     */
    public function usuarios() {
        $pageTitle = 'Gestión de Usuarios';
        
        // Obtener todos los usuarios
        $users = $this->usuarioModel->obtenerTodosLosUsuarios();
        
        // Incluir la vista de usuarios
        include __DIR__ . '/../views/admin/usuarios/usuarios.php';
    }
    
    /**
     * Mostrar gestión de contactos
     */
    public function contactos() {
        $pageTitle = 'Gestión de Contactos';
        
        // Obtener contactos de la base de datos
        require_once __DIR__ . '/../models/ContactosModel.php';
        $contactosModel = new ContactosModel();
        $contactos = $contactosModel->obtenerTodosLosContactos();
        
        // Incluir la vista de contactos
        include __DIR__ . '/../views/admin/contactos/contactos.php';
    }
}
?>