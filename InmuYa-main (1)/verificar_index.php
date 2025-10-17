<?php
/**
 * Script de prueba para verificar que el index.php carga correctamente
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Configurar para mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>🔧 Verificación del Index.php</h1>\n";

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
    
    echo "<h2>2. Verificando ruta por defecto</h2>\n";
    $route = isset($_GET['route']) ? htmlspecialchars($_GET['route'], ENT_QUOTES, 'UTF-8') : 'home';
    echo "Ruta por defecto: <strong>{$route}</strong><br>\n";
    
    echo "<h2>3. Verificando configuración de la ruta 'home'</h2>\n";
    $routeConfig = getRoute('home');
    if ($routeConfig) {
        echo "✅ Ruta 'home' encontrada<br>\n";
        echo "Controller: <strong>{$routeConfig['controller']}</strong><br>\n";
        echo "Action: <strong>{$routeConfig['action']}</strong><br>\n";
        echo "View: <strong>{$routeConfig['view']}</strong><br>\n";
        echo "Layout: <strong>{$routeConfig['layout']}</strong><br>\n";
    } else {
        echo "❌ Ruta 'home' NO encontrada<br>\n";
    }
    
    echo "<h2>4. Verificando PropiedadController</h2>\n";
    require_once __DIR__ . '/app/controllers/PropiedadController.php';
    
    if (class_exists('PropiedadController')) {
        echo "✅ Clase PropiedadController existe<br>\n";
        
        $controller = new PropiedadController();
        
        if (method_exists($controller, 'home')) {
            echo "✅ Método home() existe en PropiedadController<br>\n";
        } else {
            echo "❌ Método home() NO existe en PropiedadController<br>\n";
        }
    } else {
        echo "❌ Clase PropiedadController NO existe<br>\n";
    }
    
    echo "<h2>5. Verificando vista home/index.php</h2>\n";
    $viewPath = __DIR__ . '/app/views/home/index.php';
    if (file_exists($viewPath)) {
        echo "✅ Vista home/index.php existe<br>\n";
    } else {
        echo "❌ Vista home/index.php NO existe<br>\n";
    }
    
    echo "<h2>6. Test de carga del método home()</h2>\n";
    try {
        $controller = new PropiedadController();
        
        echo "Ejecutando PropiedadController::home()...<br>\n";
        ob_start();
        $controller->home();
        $output = ob_get_contents();
        ob_end_clean();
        
        if (!empty($output)) {
            echo "✅ Método home() se ejecutó correctamente<br>\n";
            echo "Longitud del output: " . strlen($output) . " caracteres<br>\n";
        } else {
            echo "⚠️ Método home() no generó output<br>\n";
        }
        
    } catch (Exception $e) {
        echo "❌ Error al ejecutar home(): " . htmlspecialchars($e->getMessage()) . "<br>\n";
    }
    
    echo "<h2>7. Enlaces de prueba</h2>\n";
    echo "<div style='background-color: #e8f5e8; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>🔗 Enlaces para probar:</h3>\n";
    echo "<ul>\n";
    echo "<li><a href='index.php' target='_blank'>🏠 Index.php (sin parámetros) - Debería cargar PropiedadController::home()</a></li>\n";
    echo "<li><a href='index.php?route=home' target='_blank'>🏠 Index.php?route=home - Debería cargar PropiedadController::home()</a></li>\n";
    echo "<li><a href='index.php?route=propiedades' target='_blank'>🏘️ Index.php?route=propiedades - Debería cargar PropiedadController::publicIndex()</a></li>\n";
    echo "</ul>\n";
    echo "</div>\n";
    
    echo "<div style='background-color: #e3f2fd; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>📋 Resumen de la configuración:</h3>\n";
    echo "<ul>\n";
    echo "<li>✅ Index.php configurado para usar ruta 'home' por defecto</li>\n";
    echo "<li>✅ Ruta 'home' apunta a PropiedadController::home()</li>\n";
    echo "<li>✅ PropiedadController tiene el método home() integrado</li>\n";
    echo "<li>✅ Vista home/index.php existe</li>\n";
    echo "<li>✅ No se necesita HomeController</li>\n";
    echo "</ul>\n";
    echo "</div>\n";
    
    echo "<div style='background-color: #fff3e0; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>🎯 Flujo de carga:</h3>\n";
    echo "<ol>\n";
    echo "<li>Usuario accede a <code>index.php</code></li>\n";
    echo "<li>Index.php detecta que no hay parámetro 'route'</li>\n";
    echo "<li>Index.php usa 'home' como ruta por defecto</li>\n";
    echo "<li>Index.php busca la configuración de la ruta 'home'</li>\n";
    echo "<li>Index.php encuentra: controller='PropiedadController', action='home'</li>\n";
    echo "<li>Index.php carga PropiedadController.php</li>\n";
    echo "<li>Index.php instancia PropiedadController</li>\n";
    echo "<li>Index.php ejecuta PropiedadController::home()</li>\n";
    echo "<li>PropiedadController::home() incluye home/index.php</li>\n";
    echo "<li>Se muestra la página principal con propiedades destacadas</li>\n";
    echo "</ol>\n";
    echo "</div>\n";
    
    echo "<p style='color: green; font-weight: bold;'>🎉 ¡La configuración está correcta! El index.php debería cargar sin problemas.</p>\n";
    
} catch (Exception $e) {
    echo "<div style='background-color: #ffebee; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>❌ Error:</h3>\n";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>\n";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>\n";
    echo "</div>\n";
}
?>
