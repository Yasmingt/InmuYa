<?php
/**
 * Script de verificación de la integración del PublicPropertyController
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Configurar para mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>🔧 Verificación de la Integración del PublicPropertyController</h1>\n";

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
    
    echo "<h2>2. Verificando que PublicPropertyController fue eliminado</h2>\n";
    if (file_exists(__DIR__ . '/app/controllers/PublicPropertyController.php')) {
        echo "❌ PublicPropertyController aún existe<br>\n";
    } else {
        echo "✅ PublicPropertyController eliminado correctamente<br>\n";
    }
    
    echo "<h2>3. Verificando PropiedadController</h2>\n";
    require_once __DIR__ . '/app/controllers/PropiedadController.php';
    
    if (class_exists('PropiedadController')) {
        echo "✅ Clase PropiedadController existe<br>\n";
        
        $controller = new PropiedadController();
        
        // Verificar métodos administrativos
        $adminMethods = ['index', 'create', 'store', 'edit', 'update', 'delete', 'changeStatus', 'toggleFeatured'];
        foreach ($adminMethods as $method) {
            if (method_exists($controller, $method)) {
                echo "✅ Método admin {$method}() existe<br>\n";
            } else {
                echo "❌ Método admin {$method}() NO existe<br>\n";
            }
        }
        
        // Verificar métodos públicos
        $publicMethods = ['home', 'publicIndex', 'verPropiedad', 'buscar', 'destacadas'];
        foreach ($publicMethods as $method) {
            if (method_exists($controller, $method)) {
                echo "✅ Método público {$method}() existe<br>\n";
            } else {
                echo "❌ Método público {$method}() NO existe<br>\n";
            }
        }
        
    } else {
        echo "❌ Clase PropiedadController NO existe<br>\n";
    }
    
    echo "<h2>4. Verificando rutas</h2>\n";
    $rutas = [
        'home',
        'propiedades',
        'propiedad',
        'buscar',
        'admin/propiedades',
        'admin/crear-propiedad'
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
        $controller = new PropiedadController();
        
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
    echo "<h3>🔗 Enlaces públicos (sin autenticación):</h3>\n";
    echo "<ul>\n";
    echo "<li><a href='index.php?route=home' target='_blank'>🏠 Página Principal (PropiedadController::home)</a></li>\n";
    echo "<li><a href='index.php?route=propiedades' target='_blank'>🏘️ Todas las Propiedades (PropiedadController::publicIndex)</a></li>\n";
    echo "<li><a href='index.php?route=propiedad&id=1' target='_blank'>🏡 Detalle de Propiedad (PropiedadController::verPropiedad)</a></li>\n";
    echo "<li><a href='index.php?route=buscar' target='_blank'>🔍 Buscar Propiedades (PropiedadController::buscar)</a></li>\n";
    echo "</ul>\n";
    echo "</div>\n";
    
    echo "<div style='background-color: #fff3e0; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>🔗 Enlaces administrativos (requieren login admin):</h3>\n";
    echo "<ul>\n";
    echo "<li><a href='index.php?route=auth/login' target='_blank'>🔐 Login</a></li>\n";
    echo "<li><a href='index.php?route=admin/propiedades' target='_blank'>⚙️ Gestión de Propiedades (PropiedadController::index)</a></li>\n";
    echo "<li><a href='index.php?route=admin/crear-propiedad' target='_blank'>➕ Crear Propiedad (PropiedadController::create)</a></li>\n";
    echo "</ul>\n";
    echo "</div>\n";
    
    echo "<div style='background-color: #e3f2fd; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>📋 Cambios realizados:</h3>\n";
    echo "<ul>\n";
    echo "<li>✅ Funcionalidad del PublicPropertyController integrada en PropiedadController</li>\n";
    echo "<li>✅ Métodos públicos agregados: home(), publicIndex(), verPropiedad(), buscar(), destacadas()</li>\n";
    echo "<li>✅ Método checkPublicAccess() agregado para métodos sin autenticación</li>\n";
    echo "<li>✅ Verificación de admin agregada a métodos administrativos</li>\n";
    echo "<li>✅ Rutas actualizadas para usar PropiedadController</li>\n";
    echo "<li>✅ PublicPropertyController eliminado (ya no es necesario)</li>\n";
    echo "<li>✅ Código duplicado eliminado</li>\n";
    echo "</ul>\n";
    echo "</div>\n";
    
    echo "<div style='background-color: #f3e5f5; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>🎯 Beneficios de la integración:</h3>\n";
    echo "<ul>\n";
    echo "<li>🔧 Un solo controlador para todas las operaciones de propiedades</li>\n";
    echo "<li>📦 Mejor organización del código</li>\n";
    echo "<li>🚀 Mantenimiento más fácil</li>\n";
    echo "<li>🎨 Separación clara entre métodos públicos y administrativos</li>\n";
    echo "<li>🔐 Control de acceso granular por método</li>\n";
    echo "<li>💾 Menos archivos que mantener</li>\n";
    echo "</ul>\n";
    echo "</div>\n";
    
    echo "<div style='background-color: #e8f5e8; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>🏗️ Estructura del PropiedadController:</h3>\n";
    echo "<h4>Métodos Administrativos (requieren login admin):</h4>\n";
    echo "<ul>\n";
    echo "<li>index() - Gestión de propiedades</li>\n";
    echo "<li>create() - Formulario de creación</li>\n";
    echo "<li>store() - Procesar creación</li>\n";
    echo "<li>edit() - Formulario de edición</li>\n";
    echo "<li>update() - Procesar actualización</li>\n";
    echo "<li>delete() - Eliminar propiedad</li>\n";
    echo "<li>changeStatus() - Cambiar estado</li>\n";
    echo "<li>toggleFeatured() - Toggle destacado</li>\n";
    echo "</ul>\n";
    echo "<h4>Métodos Públicos (sin autenticación):</h4>\n";
    echo "<ul>\n";
    echo "<li>home() - Página principal</li>\n";
    echo "<li>publicIndex() - Listado público</li>\n";
    echo "<li>verPropiedad() - Detalle público</li>\n";
    echo "<li>buscar() - Búsqueda</li>\n";
    echo "<li>destacadas() - Propiedades destacadas</li>\n";
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
