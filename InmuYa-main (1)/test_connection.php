<?php
/**
 * Prueba de Conexión
 * Verificar que todo funcione correctamente
 */

// Incluir configuración
require_once __DIR__ . '/config/database.php';

echo "<h1>Prueba de Conexión - InmuYa</h1>";

// Probar conexión
if ($conexion) {
    echo "<p style='color: green;'>✅ Conexión a la base de datos exitosa</p>";
    
    // Probar consulta de usuarios
    $result = $conexion->query("SELECT COUNT(*) as total FROM usuarios");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>👥 Total de usuarios: " . $row['total'] . "</p>";
    }
    
    // Probar consulta de propiedades
    $result = $conexion->query("SELECT COUNT(*) as total FROM propiedades");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>🏠 Total de propiedades: " . $row['total'] . "</p>";
    }
    
    // Probar consulta de contactos
    $result = $conexion->query("SELECT COUNT(*) as total FROM contactar");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<p>📧 Total de contactos: " . $row['total'] . "</p>";
    }
    
} else {
    echo "<p style='color: red;'>❌ Error de conexión a la base de datos</p>";
}

echo "<hr>";
echo "<p><a href='index.php'>Volver al inicio</a></p>";
?>
