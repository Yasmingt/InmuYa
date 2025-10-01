<?php
/**
 * Configuración de Rutas
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Define las rutas del sistema y sus controladores correspondientes
 */

// Definir la URL base del proyecto (solo si no está definida)
if (!defined('BASE_URL')) {
    // Detectar si estamos usando el servidor de desarrollo de PHP
    if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 8000) {
        define('BASE_URL', 'http://localhost:8000/');
    } elseif (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost:8000') !== false) {
        define('BASE_URL', 'http://localhost:8000/');
    } else {
        define('BASE_URL', 'http://localhost/InmuYa/InmuYa-main%20(1)/');
    }
}

// Definir rutas del sistema
$routes = [
    // Página principal
    'home' => [
        'controller' => 'ContactController',
        'view' => 'home/index.php',
        'layout' => 'index'
    ],
    
    // Autenticación
    'auth/login' => [
        'controller' => 'AuthController',
        'action' => 'showLogin',
        'view' => 'auth/login.php',
        'layout' => 'login'
    ],

    // Recuperación de contraseña
    'auth/recoverPassword' => [
        'controller' => 'AuthController',
        'action' => 'showRecover',
        'view' => 'auth/recoverPassword.php',
        'layout' => 'main'
    ],

    // Registro de usuario
    'auth/registration' => [
        'controller' => 'AuthController',
        'action' => 'showRegister',
        'view' => 'auth/registration.php',
        'layout' => 'main'
    ],
    
    'auth/process-login' => [
        'controller' => 'AuthController',
        'action' => 'processLogin',
        'view' => null,
        'layout' => null
    ],
    
    'auth/process-registro' => [
        'controller' => 'AuthController',
        'action' => 'processRegister',
        'view' => null,
        'layout' => null
    ],
    
    'auth/process-recuperar' => [
        'controller' => 'AuthController',
        'action' => 'processRecover',
        'view' => null,
        'layout' => null
    ],
    
    
    'auth/logout' => [
        'controller' => 'AuthController',
        'action' => 'logout',
        'view' => null,
        'layout' => null
    ],
    
    // Panel de Administración
    'admin/dashboard' => [
        'controller' => 'AdminController',
        'action' => 'dashboard',
        'view' => 'admin/dashboard.php',
        'layout' => 'admin'
    ],
    

    // Gestión de Usuarios
    'user/usuarios' => [
        'controller' => 'UserController',
        'action' => 'showUsers',
        'view' => 'user/usuarios.php',
        'layout' => 'admin'
    ],
    
    'user/new' => [
        'controller' => 'UserController',
        'action' => 'showCreateUser',
        'view' => 'user/newUsuario.php',
        'layout' => 'admin'
    ],
    
    'admin/propiedades' => [
        'controller' => 'AdminController',
        'action' => 'propiedades',
        'view' => 'admin/propiedades.php',
        'layout' => 'admin'
    ],
    
    'admin/contactos' => [
        'controller' => 'AdminController',
        'action' => 'contactos',
        'view' => 'admin/contactos.php',
        'layout' => 'admin'
    ],
        
    'contact/process' => [
        'controller' => 'ContactController',
        'action' => 'processContact',
        'view' => null,
        'layout' => null
    ],
    
];

// Función para obtener la ruta
function getRoute($route) {
    global $routes;
    return isset($routes[$route]) ? $routes[$route] : null;
}

// Función para obtener la URL base
function getBaseUrl() {
    return BASE_URL;
}
?>
