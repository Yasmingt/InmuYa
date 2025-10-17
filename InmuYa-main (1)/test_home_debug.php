<?php
/**
 * Test específico del método home() con debug
 */

// Configurar para mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "=== TEST ESPECÍFICO DEL MÉTODO HOME() ===\n";

try {
    // Simular variables de servidor
    $_SERVER['HTTP_HOST'] = 'localhost';
    $_SERVER['HTTPS'] = 'off';
    $_SERVER['SCRIPT_NAME'] = '/InmuYa/InmuYa-main%20(1)/index.php';
    
    echo "1. Cargando configuración...\n";
    require_once __DIR__ . '/config/config.php';
    echo "   BASE_URL: " . BASE_URL . "\n";
    
    require_once __DIR__ . '/config/conexion.php';
    echo "   ✅ Conexión cargada\n";
    
    require_once __DIR__ . '/config/routes.php';
    echo "   ✅ Rutas cargadas\n";
    
    echo "2. Cargando modelos...\n";
    require_once __DIR__ . '/app/models/PropertyModel.php';
    echo "   ✅ PropertyModel cargado\n";
    
    require_once __DIR__ . '/app/models/ImageModel.php';
    echo "   ✅ ImageModel cargado\n";
    
    echo "3. Instanciando modelos...\n";
    $propertyModel = new PropertyModel();
    echo "   ✅ PropertyModel instanciado\n";
    
    $imageModel = new ImageModel();
    echo "   ✅ ImageModel instanciado\n";
    
    echo "4. Probando métodos de los modelos...\n";
    try {
        $propiedadesDestacadas = $propertyModel->getFeaturedProperties(6);
        echo "   ✅ getFeaturedProperties() ejecutado - " . count($propiedadesDestacadas) . " propiedades\n";
        
        $stats = $propertyModel->getPropertyStats();
        echo "   ✅ getPropertyStats() ejecutado\n";
        
    } catch (Exception $e) {
        echo "   ❌ Error en modelos: " . $e->getMessage() . "\n";
        exit;
    }
    
    echo "5. Cargando PropiedadController...\n";
    require_once __DIR__ . '/app/controllers/PropiedadController.php';
    echo "   ✅ PropiedadController cargado\n";
    
    echo "6. Instanciando controlador...\n";
    $controller = new PropiedadController();
    echo "   ✅ Controlador instanciado\n";
    
    echo "7. Ejecutando método home()...\n";
    try {
        $controller->home();
        echo "   ✅ Método home() ejecutado sin errores\n";
    } catch (Exception $e) {
        echo "   ❌ Error al ejecutar home(): " . $e->getMessage() . "\n";
        echo "   Trace: " . $e->getTraceAsString() . "\n";
    }
    
    echo "\n=== TEST COMPLETADO ===\n";
    
} catch (Exception $e) {
    echo "ERROR GENERAL: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
?>
