<?php
/**
 * Test directo del método home()
 */

// Configurar para mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "=== TEST DIRECTO DEL MÉTODO HOME() ===\n";

try {
    // Simular variables de servidor
    $_SERVER['HTTP_HOST'] = 'localhost';
    $_SERVER['HTTPS'] = 'off';
    $_SERVER['SCRIPT_NAME'] = '/InmuYa/InmuYa-main%20(1)/index.php';
    
    echo "1. Cargando configuración...\n";
    require_once __DIR__ . '/config/config.php';
    require_once __DIR__ . '/config/conexion.php';
    require_once __DIR__ . '/config/routes.php';
    echo "   ✅ Configuración cargada\n";
    
    echo "2. Cargando PropiedadController...\n";
    require_once __DIR__ . '/app/controllers/PropiedadController.php';
    echo "   ✅ PropiedadController cargado\n";
    
    echo "3. Instanciando controlador...\n";
    $controller = new PropiedadController();
    echo "   ✅ Controlador instanciado\n";
    
    echo "4. Verificando método home...\n";
    if (method_exists($controller, 'home')) {
        echo "   ✅ Método home() existe\n";
    } else {
        echo "   ❌ Método home() NO existe\n";
        exit;
    }
    
    echo "5. Ejecutando método home()...\n";
    try {
        $controller->home();
        echo "   ✅ Método home() ejecutado sin errores\n";
    } catch (Exception $e) {
        echo "   ❌ Error al ejecutar home(): " . $e->getMessage() . "\n";
        echo "   Trace: " . $e->getTraceAsString() . "\n";
    }
    
    echo "6. Verificando vista...\n";
    $viewPath = __DIR__ . '/app/views/home/index.php';
    if (file_exists($viewPath)) {
        echo "   ✅ Vista home/index.php existe\n";
    } else {
        echo "   ❌ Vista home/index.php NO existe\n";
    }
    
    echo "\n=== TEST COMPLETADO ===\n";
    
} catch (Exception $e) {
    echo "ERROR GENERAL: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
?>
