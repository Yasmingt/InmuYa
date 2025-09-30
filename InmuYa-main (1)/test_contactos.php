<?php
/**
 * Test de Contactos - Debug
 */

// Incluir configuración
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/routes.php';
require_once __DIR__ . '/config/conexion.php';

// Incluir el controlador
require_once __DIR__ . '/app/controllers/ContactController.php';

echo "<h1>Test de Contactos</h1>";

try {
    // Crear instancia del controlador
    $contactController = new ContactController();
    
    echo "<p>✅ Controlador creado correctamente</p>";
    
    // Simular parámetros GET
    $_GET['pagina'] = 1;
    $_GET['busqueda'] = '';
    $_GET['estado'] = '';
    $_GET['fecha'] = '';
    
    echo "<p>✅ Parámetros GET simulados</p>";
    
    // Llamar al método
    $contactController->showAdminContacts();
    
    echo "<p>✅ Método showAdminContacts ejecutado</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p>Stack trace:</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
