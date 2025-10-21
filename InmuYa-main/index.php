<?php
/**
 * Punto de Entrada Principal
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Este archivo maneja todas las rutas del sistema
 * y carga las vistas correspondientes
 */

// Iniciar buffer de salida para mejor manejo de errores
ob_start();

try {
    // Incluir configuración
    require_once __DIR__ . '/config/config.php';
    require_once __DIR__ . '/config/routes.php';
    require_once __DIR__ . '/config/conexion.php';

    // Obtener la ruta solicitada (sanitizada)
    $route = isset($_GET['route']) ? htmlspecialchars($_GET['route'], ENT_QUOTES, 'UTF-8') : 'home';

    // Obtener la configuración de la ruta
    $routeConfig = getRoute($route);

    if ($routeConfig) {
        // Si tiene controlador y acción, ejecutarlos
        if (isset($routeConfig['controller']) && isset($routeConfig['action'])) {
            $controllerName = $routeConfig['controller'];
            $actionName = $routeConfig['action'];
            
            // Incluir el controlador
            $controllerPath = __DIR__ . '/app/controllers/' . $controllerName . '.php';
            if (file_exists($controllerPath)) {
                require_once $controllerPath;
                
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    
                    if (method_exists($controller, $actionName)) {
                        // Limpiar buffer antes de ejecutar controlador (para permitir redirecciones)
                        ob_end_clean();
                        $controller->$actionName();
                    } else {
                        http_response_code(404);
                        echo "Acción no encontrada: " . htmlspecialchars($actionName);
                    }
                } else {
                    http_response_code(500);
                    echo "Error: Clase del controlador no encontrada: " . htmlspecialchars($controllerName);
                }
            } else {
                http_response_code(404);
                echo "Controlador no encontrado: " . htmlspecialchars($controllerName);
            }
        } 
        // Si solo tiene vista, cargarla directamente
        elseif (isset($routeConfig['view'])) {
            $viewPath = __DIR__ . '/app/views/' . $routeConfig['view'];
            
            if (file_exists($viewPath)) {
                // Incluir la vista (la vista se encarga de incluir su layout y CSS)
                include $viewPath;
            } else {
                http_response_code(404);
                echo "Vista no encontrada: " . htmlspecialchars($routeConfig['view']);
            }
        }
    } else {
        // Ruta no encontrada
        http_response_code(404);
        echo "Ruta no encontrada: " . htmlspecialchars($route);
    }

} catch (Exception $e) {
    // Log del error
    error_log("Error en index.php: " . $e->getMessage());
    
    // Limpiar buffer de salida
    ob_clean();
    
    // Mostrar error apropiado
    http_response_code(500);
    echo "Error interno del servidor. Por favor, inténtalo más tarde.";
    
    // En desarrollo, mostrar el error real
    if (defined('DEBUG') && DEBUG) {
        echo "<br><br>Error: " . htmlspecialchars($e->getMessage());
    }
}

// Enviar buffer de salida
ob_end_flush();
?>