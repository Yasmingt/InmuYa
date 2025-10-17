<?php
/**
 * Script de diagnóstico para el problema del index
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Configurar para mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>🔍 Diagnóstico del Problema del Index</h1>\n";

try {
    // Simular variables de servidor
    $_SERVER['HTTP_HOST'] = 'localhost';
    $_SERVER['HTTPS'] = 'off';
    $_SERVER['SCRIPT_NAME'] = '/InmuYa/InmuYa-main%20(1)/index.php';
    
    echo "<h2>1. Verificando configuración básica</h2>\n";
    require_once __DIR__ . '/config/config.php';
    require_once __DIR__ . '/config/conexion.php';
    require_once __DIR__ . '/config/routes.php';
    echo "✅ Configuración cargada<br>\n";
    
    echo "<h2>2. Simulando acceso sin parámetros</h2>\n";
    // Limpiar cualquier parámetro GET previo
    $_GET = [];
    
    // Simular el comportamiento del index.php
    $route = isset($_GET['route']) ? htmlspecialchars($_GET['route'], ENT_QUOTES, 'UTF-8') : 'home';
    echo "Ruta detectada: <strong>{$route}</strong><br>\n";
    
    echo "<h2>3. Verificando configuración de la ruta</h2>\n";
    $routeConfig = getRoute($route);
    if ($routeConfig) {
        echo "✅ Configuración de ruta encontrada:<br>\n";
        echo "Controller: <strong>{$routeConfig['controller']}</strong><br>\n";
        echo "Action: <strong>{$routeConfig['action']}</strong><br>\n";
        echo "View: <strong>{$routeConfig['view']}</strong><br>\n";
        echo "Layout: <strong>{$routeConfig['layout']}</strong><br>\n";
    } else {
        echo "❌ No se encontró configuración para la ruta '{$route}'<br>\n";
        exit;
    }
    
    echo "<h2>4. Verificando archivo del controlador</h2>\n";
    $controllerName = $routeConfig['controller'];
    $controllerPath = __DIR__ . '/app/controllers/' . $controllerName . '.php';
    echo "Ruta del controlador: <strong>{$controllerPath}</strong><br>\n";
    
    if (file_exists($controllerPath)) {
        echo "✅ Archivo del controlador existe<br>\n";
    } else {
        echo "❌ Archivo del controlador NO existe<br>\n";
        exit;
    }
    
    echo "<h2>5. Cargando controlador</h2>\n";
    require_once $controllerPath;
    
    $className = basename($controllerName);
    echo "Nombre de la clase: <strong>{$className}</strong><br>\n";
    
    if (class_exists($className)) {
        echo "✅ Clase existe<br>\n";
    } else {
        echo "❌ Clase NO existe<br>\n";
        exit;
    }
    
    echo "<h2>6. Instanciando controlador</h2>\n";
    try {
        $controller = new $className();
        echo "✅ Controlador instanciado correctamente<br>\n";
    } catch (Exception $e) {
        echo "❌ Error al instanciar controlador: " . htmlspecialchars($e->getMessage()) . "<br>\n";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>\n";
        exit;
    }
    
    echo "<h2>7. Verificando método</h2>\n";
    $actionName = $routeConfig['action'];
    echo "Método a ejecutar: <strong>{$actionName}</strong><br>\n";
    
    if (method_exists($controller, $actionName)) {
        echo "✅ Método existe<br>\n";
    } else {
        echo "❌ Método NO existe<br>\n";
        echo "Métodos disponibles:<br>\n";
        $methods = get_class_methods($controller);
        foreach ($methods as $method) {
            echo "- {$method}<br>\n";
        }
        exit;
    }
    
    echo "<h2>8. Ejecutando método</h2>\n";
    try {
        echo "Ejecutando {$className}::{$actionName}()...<br>\n";
        ob_start();
        $controller->$actionName();
        $output = ob_get_contents();
        ob_end_clean();
        
        if (!empty($output)) {
            echo "✅ Método ejecutado correctamente<br>\n";
            echo "Longitud del output: " . strlen($output) . " caracteres<br>\n";
            
            // Mostrar una muestra del output
            $sample = substr($output, 0, 200);
            echo "Muestra del output:<br>\n";
            echo "<pre>" . htmlspecialchars($sample) . "...</pre>\n";
        } else {
            echo "⚠️ Método ejecutado pero no generó output<br>\n";
        }
        
    } catch (Exception $e) {
        echo "❌ Error al ejecutar método: " . htmlspecialchars($e->getMessage()) . "<br>\n";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>\n";
    }
    
    echo "<h2>9. Verificando vista</h2>\n";
    $viewPath = __DIR__ . '/app/views/' . $routeConfig['view'];
    echo "Ruta de la vista: <strong>{$viewPath}</strong><br>\n";
    
    if (file_exists($viewPath)) {
        echo "✅ Vista existe<br>\n";
    } else {
        echo "❌ Vista NO existe<br>\n";
    }
    
    echo "<h2>10. Test completo del index.php</h2>\n";
    echo "<div style='background-color: #e8f5e8; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>🔗 Enlaces para probar:</h3>\n";
    echo "<ul>\n";
    echo "<li><a href='index.php' target='_blank'>🏠 index.php (sin parámetros)</a></li>\n";
    echo "<li><a href='index.php?route=home' target='_blank'>🏠 index.php?route=home</a></li>\n";
    echo "<li><a href='index.php?route=propiedades' target='_blank'>🏘️ index.php?route=propiedades</a></li>\n";
    echo "</ul>\n";
    echo "</div>\n";
    
    echo "<h2>11. Información adicional</h2>\n";
    echo "<div style='background-color: #fff3e0; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>📋 Estado actual:</h3>\n";
    echo "<ul>\n";
    echo "<li>BASE_URL: <strong>" . BASE_URL . "</strong></li>\n";
    echo "<li>Directorio actual: <strong>" . __DIR__ . "</strong></li>\n";
    echo "<li>Ruta por defecto: <strong>home</strong></li>\n";
    echo "<li>Controlador: <strong>PropiedadController</strong></li>\n";
    echo "<li>Método: <strong>home</strong></li>\n";
    echo "<li>Vista: <strong>home/index.php</strong></li>\n";
    echo "</ul>\n";
    echo "</div>\n";
    
    echo "<p style='color: green; font-weight: bold;'>🎉 Diagnóstico completado. Revisa los resultados arriba.</p>\n";
    
} catch (Exception $e) {
    echo "<div style='background-color: #ffebee; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>❌ Error en el diagnóstico:</h3>\n";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>\n";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>\n";
    echo "</div>\n";
}
?>
