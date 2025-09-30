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
        
        // Obtener usuarios recientes (últimos 5)
        $recent_users = $this->userModel->getAllUsers(5);
        
        // Simular datos adicionales (en un sistema real vendrían de otros modelos)
        $stats['total_properties'] = 25;
        $stats['total_contacts'] = 150;
        $stats['total_views'] = 1250;
        
        // Actividad reciente simulada
        $recent_activity = [
            [
                'icon' => 'user-plus',
                'description' => 'Nuevo usuario registrado: ' . ($recent_users[0]['nombre'] ?? 'Usuario'),
                'time' => 'Hace 5 minutos'
            ],
            [
                'icon' => 'building',
                'description' => 'Nueva propiedad agregada',
                'time' => 'Hace 1 hora'
            ],
            [
                'icon' => 'envelope',
                'description' => 'Nuevo mensaje de contacto',
                'time' => 'Hace 2 horas'
            ],
            [
                'icon' => 'chart-line',
                'description' => 'Reporte generado',
                'time' => 'Hace 3 horas'
            ]
        ];
        
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
        include __DIR__ . '/../views/admin/propiedades.php';
    }
    
    /**
     * Mostrar gestión de contactos
     */
    public function contactos() {
        $pageTitle = 'Gestión de Contactos';
        
        // Aquí se obtendrían los contactos de un ContactModel
        $contactos = []; // Por ahora vacío
        
        // Incluir la vista de contactos
        include __DIR__ . '/../views/admin/contactos.php';
    }
}
?>
