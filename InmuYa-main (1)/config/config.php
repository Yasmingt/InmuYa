<?php
/**
 * Configuración General
 * InmuYa - Sistema de gestión inmobiliaria
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