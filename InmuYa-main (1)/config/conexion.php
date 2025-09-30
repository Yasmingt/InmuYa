<?php
/**
 * Configuración de Conexión a Base de Datos
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Configuración de la base de datos
$servidor = "localhost";
$usuario = "root";
$clave = "";
$bd = "propertypro_bd";

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $clave, $bd);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configurar charset
$conexion->set_charset("utf8");

// Asegurar que la variable $conexion esté disponible globalmente
if (!isset($GLOBALS['conexion'])) {
    $GLOBALS['conexion'] = $conexion;
}

// La variable $conexion ya está disponible globalmente
?>
