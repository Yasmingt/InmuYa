<?php
/**
 * Configuración de Base de Datos
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Incluir la configuración general
require_once __DIR__ . '/config.php';

// Crear conexión a la base de datos
try {
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Verificar la conexión
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }
    
    // Configurar charset
    $conexion->set_charset("utf8");
    
    // Configurar zona horaria
    $conexion->query("SET time_zone = '+00:00'");
    
} catch (Exception $e) {
    // En caso de error, mostrar mensaje de error
    if (DEBUG) {
        die("Error de conexión a la base de datos: " . $e->getMessage());
    } else {
        die("Error de conexión a la base de datos. Contacte al administrador.");
    }
}
