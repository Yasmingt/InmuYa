<?php
/**
 * Configuración General
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Definir la URL base del proyecto (solo si no está definida)
if (!defined('BASE_URL')) {
    // Detectar automáticamente la URL base del proyecto
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    
    // Para este proyecto específico, usar la ruta correcta
    $baseUrl = $protocol . '://' . $host . '/InmuYa/InmuYa-main%20(1)/';
    
    define('BASE_URL', $baseUrl);
}

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'propertypro_bd');
define('DB_USER', 'root');
define('DB_PASS', '');

// Configuración de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Zona horaria
date_default_timezone_set('America/Bogota');

// Configuración de sesión
ini_set('session.gc_maxlifetime', 1800); // 30 minutos
ini_set('session.cookie_lifetime', 0); // La cookie expira cuando se cierra el navegador
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => false, // Cambiar a true en producción con HTTPS
    'httponly' => true, // Prevenir acceso a cookies vía JavaScript
    'samesite' => 'Lax' // Protección CSRF
]);

// Modo debug (cambiar a false en producción)
define('DEBUG', true);

// Configuración de timeout de sesión
define('SESSION_TIMEOUT', 1800); // 30 minutos
?>