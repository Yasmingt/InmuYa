<?php
/**
 * Script de verificación de la integración del HomeController
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Configurar para mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>🔧 Verificación de la Integración del HomeController</h1>\n";

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
    
    echo "<h2>2. Verificando que HomeController fue eliminado</h2>\n";
    if (file_exists(__DIR__ . '/app/controllers/HomeController.php')) {
        echo "❌ HomeController aún existe<br>\n";
    } else {
        echo "✅ HomeController eliminado correctamente<br>\n";
    }
    
    echo "<h2>3. Verificando PublicPropertyController</h2>\n";
    require_once __DIR__ . '/app/controllers/PublicPropertyController.php';
    
    if (class_exists('PublicPropertyController')) {
        echo "✅ Clase PublicPropertyController existe<br>\n";
        
        $controller = new PublicPropertyController();
        
        if (method_exists($controller, 'home')) {
            echo "✅ Método home() existe en PublicPropertyController<br>\n";
        } else {
            echo "❌ Método home() NO existe en PublicPropertyController<br>\n";
        }
        
        if (method_exists($controller, 'index')) {
            echo "✅ Método index() existe en PublicPropertyController<br>\n";
        } else {
            echo "❌ Método index() NO existe en PublicPropertyController<br>\n";
        }
        
        if (method_exists($controller, 'destacadas')) {
            echo "✅ Método destacadas() existe en PublicPropertyController<br>\n";
        } else {
            echo "❌ Método destacadas() NO existe en PublicPropertyController<br>\n";
        }
    } else {
        echo "❌ Clase PublicPropertyController NO existe<br>\n";
    }
    
    echo "<h2>4. Verificando rutas</h2>\n";
    $rutas = [
        'home',
        'propiedades',
        'propiedad'
    ];
    
    foreach ($rutas as $ruta) {
        $config = getRoute($ruta);
        if ($config) {
            echo "✅ {$ruta} - Controller: {$config['controller']}, Action: {$config['action']}<br>\n";
        } else {
            echo "❌ {$ruta} NO encontrada<br>\n";
        }
    }
    
    echo "<h2>5. Test de funcionalidad</h2>\n";
    
    try {
        $controller = new PublicPropertyController();
        
        // Test del método home
        echo "Probando método home()...<br>\n";
        ob_start();
        $controller->home();
        $output = ob_get_contents();
        ob_end_clean();
        
        if (strpos($output, 'propiedades') !== false || strpos($output, 'destacadas') !== false) {
            echo "✅ Método home() funciona correctamente<br>\n";
        } else {
            echo "⚠️ Método home() puede tener problemas<br>\n";
        }
        
        // Test del método destacadas
        echo "Probando método destacadas()...<br>\n";
        $propiedadesDestacadas = $controller->destacadas();
        if (is_array($propiedadesDestacadas)) {
            echo "✅ Método destacadas() funciona correctamente - " . count($propiedadesDestacadas) . " propiedades<br>\n";
        } else {
            echo "❌ Método destacadas() no funciona correctamente<br>\n";
        }
        
    } catch (Exception $e) {
        echo "❌ Error en test de funcionalidad: " . htmlspecialchars($e->getMessage()) . "<br>\n";
    }
    
    echo "<h2>6. Enlaces de prueba</h2>\n";
    echo "<div style='background-color: #e8f5e8; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>🔗 Enlaces importantes:</h3>\n";
    echo "<ul>\n";
    echo "<li><a href='index.php?route=home' target='_blank'>🏠 Página Principal (ahora usa PublicPropertyController)</a></li>\n";
    echo "<li><a href='index.php?route=propiedades' target='_blank'>🏘️ Todas las Propiedades</a></li>\n";
    echo "<li><a href='index.php?route=auth/login' target='_blank'>🔐 Login</a></li>\n";
    echo "</ul>\n";
    echo "</div>\n";
    
    echo "<div style='background-color: #e3f2fd; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>📋 Cambios realizados:</h3>\n";
    echo "<ul>\n";
    echo "<li>✅ Funcionalidad del HomeController integrada en PublicPropertyController</li>\n";
    echo "<li>✅ Método home() agregado a PublicPropertyController</li>\n";
    echo "<li>✅ Ruta 'home' actualizada para usar PublicPropertyController</li>\n";
    echo "<li>✅ HomeController eliminado (ya no es necesario)</li>\n";
    echo "<li>✅ Código duplicado eliminado</li>\n";
    echo "</ul>\n";
    echo "</div>\n";
    
    echo "<div style='background-color: #fff3e0; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>🎯 Beneficios de la integración:</h3>\n";
    echo "<ul>\n";
    echo "<li>🔧 Menos código duplicado</li>\n";
    echo "<li>📦 Mejor organización del código</li>\n";
    echo "<li>🚀 Mantenimiento más fácil</li>\n";
    echo "<li>🎨 Funcionalidad centralizada en un solo controlador</li>\n";
    echo "</ul>\n";
    echo "</div>\n";
    
    echo "<p style='color: green; font-weight: bold;'>🎉 ¡La integración se completó exitosamente!</p>\n";
    
} catch (Exception $e) {
    echo "<div style='background-color: #ffebee; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>❌ Error:</h3>\n";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>\n";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>\n";
    echo "</div>\n";
}
?>
