<?php
/**
 * Test HTML del método home()
 */

// Configurar para mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<!DOCTYPE html>\n";
echo "<html><head><title>Test Home Method</title></head><body>\n";
echo "<h1>🔍 Test del Método Home()</h1>\n";

try {
    // Simular variables de servidor
    $_SERVER['HTTP_HOST'] = 'localhost';
    $_SERVER['HTTPS'] = 'off';
    $_SERVER['SCRIPT_NAME'] = '/InmuYa/InmuYa-main%20(1)/index.php';
    
    echo "<h2>1. Cargando configuración</h2>\n";
    require_once __DIR__ . '/config/config.php';
    require_once __DIR__ . '/config/conexion.php';
    require_once __DIR__ . '/config/routes.php';
    echo "✅ Configuración cargada<br>\n";
    
    echo "<h2>2. Cargando PropiedadController</h2>\n";
    require_once __DIR__ . '/app/controllers/PropiedadController.php';
    echo "✅ PropiedadController cargado<br>\n";
    
    echo "<h2>3. Instanciando controlador</h2>\n";
    $controller = new PropiedadController();
    echo "✅ Controlador instanciado<br>\n";
    
    echo "<h2>4. Verificando método home</h2>\n";
    if (method_exists($controller, 'home')) {
        echo "✅ Método home() existe<br>\n";
    } else {
        echo "❌ Método home() NO existe<br>\n";
        echo "</body></html>";
        exit;
    }
    
    echo "<h2>5. Ejecutando método home()</h2>\n";
    try {
        ob_start();
        $controller->home();
        $output = ob_get_contents();
        ob_end_clean();
        
        if (!empty($output)) {
            echo "✅ Método home() ejecutado correctamente<br>\n";
            echo "Longitud del output: " . strlen($output) . " caracteres<br>\n";
            echo "<h3>Muestra del output:</h3>\n";
            echo "<div style='border: 1px solid #ccc; padding: 10px; background: #f9f9f9;'>\n";
            echo htmlspecialchars(substr($output, 0, 500)) . "...\n";
            echo "</div>\n";
        } else {
            echo "⚠️ Método home() ejecutado pero no generó output<br>\n";
        }
        
    } catch (Exception $e) {
        echo "❌ Error al ejecutar home(): " . htmlspecialchars($e->getMessage()) . "<br>\n";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>\n";
    }
    
    echo "<h2>6. Verificando vista</h2>\n";
    $viewPath = __DIR__ . '/app/views/home/index.php';
    if (file_exists($viewPath)) {
        echo "✅ Vista home/index.php existe<br>\n";
    } else {
        echo "❌ Vista home/index.php NO existe<br>\n";
    }
    
    echo "<h2>7. Enlaces de prueba</h2>\n";
    echo "<div style='background-color: #e8f5e8; padding: 15px; border-radius: 5px;'>\n";
    echo "<h3>🔗 Prueba estos enlaces:</h3>\n";
    echo "<ul>\n";
    echo "<li><a href='index.php' target='_blank'>🏠 index.php (sin parámetros)</a></li>\n";
    echo "<li><a href='index.php?route=home' target='_blank'>🏠 index.php?route=home</a></li>\n";
    echo "<li><a href='index.php?route=propiedades' target='_blank'>🏘️ index.php?route=propiedades</a></li>\n";
    echo "</ul>\n";
    echo "</div>\n";
    
    echo "<p style='color: green; font-weight: bold;'>🎉 Test completado</p>\n";
    
} catch (Exception $e) {
    echo "<div style='background-color: #ffebee; padding: 15px; border-radius: 5px;'>\n";
    echo "<h3>❌ Error:</h3>\n";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>\n";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>\n";
    echo "</div>\n";
}

echo "</body></html>\n";
?>
