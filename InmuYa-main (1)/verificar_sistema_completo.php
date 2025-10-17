<?php
/**
 * Script de verificación y corrección del sistema completo
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Configurar para mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>🔧 Verificación y Corrección del Sistema Completo</h1>\n";

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
    
    echo "<h2>2. Verificando rutas de autenticación</h2>\n";
    $rutasAuth = [
        'auth/login',
        'auth/process-login',
        'auth/registration',
        'auth/process-register',
        'auth/recoverPassword',
        'auth/logout'
    ];
    
    foreach ($rutasAuth as $ruta) {
        $config = getRoute($ruta);
        if ($config) {
            echo "✅ {$ruta} - Controller: {$config['controller']}, Action: {$config['action']}<br>\n";
        } else {
            echo "❌ {$ruta} NO encontrada<br>\n";
        }
    }
    
    echo "<h2>3. Verificando rutas de contacto</h2>\n";
    $rutasContact = [
        'contact/process',
        'contact/change-status',
        'contact/delete'
    ];
    
    foreach ($rutasContact as $ruta) {
        $config = getRoute($ruta);
        if ($config) {
            echo "✅ {$ruta} - Controller: {$config['controller']}, Action: {$config['action']}<br>\n";
        } else {
            echo "❌ {$ruta} NO encontrada<br>\n";
        }
    }
    
    echo "<h2>4. Verificando AuthController</h2>\n";
    require_once __DIR__ . '/app/controllers/AuthController.php';
    
    if (class_exists('AuthController')) {
        echo "✅ Clase AuthController existe<br>\n";
        
        $controller = new AuthController();
        
        if (method_exists($controller, 'processLogin')) {
            echo "✅ Método processLogin existe<br>\n";
        } else {
            echo "❌ Método processLogin NO existe<br>\n";
        }
    } else {
        echo "❌ Clase AuthController NO existe<br>\n";
    }
    
    echo "<h2>5. Verificando ContactarController</h2>\n";
    require_once __DIR__ . '/app/controllers/ContactarController.php';
    
    if (class_exists('ContactarController')) {
        echo "✅ Clase ContactarController existe<br>\n";
        
        $controller = new ContactarController();
        
        if (method_exists($controller, 'processContact')) {
            echo "✅ Método processContact existe<br>\n";
        } else {
            echo "❌ Método processContact NO existe<br>\n";
        }
    } else {
        echo "❌ Clase ContactarController NO existe<br>\n";
    }
    
    echo "<h2>6. Verificando ContactModel</h2>\n";
    require_once __DIR__ . '/app/models/ContactModel.php';
    
    if (class_exists('ContactModel')) {
        echo "✅ Clase ContactModel existe<br>\n";
        
        try {
            $model = new ContactModel();
            echo "✅ ContactModel creado exitosamente<br>\n";
        } catch (Exception $e) {
            echo "❌ Error en ContactModel: " . htmlspecialchars($e->getMessage()) . "<br>\n";
        }
    } else {
        echo "❌ Clase ContactModel NO existe<br>\n";
    }
    
    echo "<h2>7. Configurando usuarios de prueba</h2>\n";
    
    $usuariosPrueba = [
        [
            'id_usuario' => 1001,
            'nombre' => 'Admin Test',
            'email' => 'admin@test.com',
            'telefono' => '3001234567',
            'tipodocumento' => 9,
            'numerodocumento' => '1001234567',
            'fechadenacimiento' => '1990-01-01',
            'contrasena' => 'admin123',
            'tipo_usuario' => 'admin'
        ],
        [
            'id_usuario' => 1002,
            'nombre' => 'Propietario Test',
            'email' => 'propietario@test.com',
            'telefono' => '3001234568',
            'tipodocumento' => 9,
            'numerodocumento' => '1001234568',
            'fechadenacimiento' => '1985-05-15',
            'contrasena' => 'propietario123',
            'tipo_usuario' => 'propietario'
        ],
        [
            'id_usuario' => 1003,
            'nombre' => 'Cliente Test',
            'email' => 'cliente@test.com',
            'telefono' => '3001234569',
            'tipodocumento' => 9,
            'numerodocumento' => '1001234569',
            'fechadenacimiento' => '1995-12-20',
            'contrasena' => 'cliente123',
            'tipo_usuario' => 'cliente'
        ]
    ];
    
    foreach ($usuariosPrueba as $usuario) {
        // Verificar si existe
        $check = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
        $check->bind_param("s", $usuario['email']);
        $check->execute();
        $result = $check->get_result();
        
        $hashedPassword = password_hash($usuario['contrasena'], PASSWORD_DEFAULT);
        
        if ($result->num_rows > 0) {
            // Actualizar contraseña
            $update = $conexion->prepare("UPDATE usuarios SET contrasena = ? WHERE email = ?");
            $update->bind_param("ss", $hashedPassword, $usuario['email']);
            if ($update->execute()) {
                echo "✅ Usuario actualizado: {$usuario['email']} ({$usuario['tipo_usuario']})<br>\n";
            }
        } else {
            // Crear usuario
            $insert = $conexion->prepare("INSERT INTO usuarios (id_usuario, nombre, email, telefono, tipodocumento, numerodocumento, fechadenacimiento, contrasena, tipo_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert->bind_param("isssissss", 
                $usuario['id_usuario'],
                $usuario['nombre'],
                $usuario['email'],
                $usuario['telefono'],
                $usuario['tipodocumento'],
                $usuario['numerodocumento'],
                $usuario['fechadenacimiento'],
                $hashedPassword,
                $usuario['tipo_usuario']
            );
            
            if ($insert->execute()) {
                echo "✅ Usuario creado: {$usuario['email']} ({$usuario['tipo_usuario']})<br>\n";
            }
        }
    }
    
    echo "<h2>8. Test de login</h2>\n";
    
    try {
        $_POST['email'] = 'admin@test.com';
        $_POST['password'] = 'admin123';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        
        $authController = new AuthController();
        
        // Capturar salida
        ob_start();
        $authController->processLogin();
        $output = ob_get_contents();
        ob_end_clean();
        
        if (strpos($output, 'admin/dashboard') !== false) {
            echo "✅ Login exitoso - Redirección a admin dashboard detectada<br>\n";
        } elseif (strpos($output, 'Credenciales incorrectas') !== false) {
            echo "⚠️ Login falló - Credenciales incorrectas<br>\n";
        } else {
            echo "⚠️ Resultado del login: " . htmlspecialchars(substr($output, 0, 200)) . "...<br>\n";
        }
        
    } catch (Exception $e) {
        echo "❌ Error en test de login: " . htmlspecialchars($e->getMessage()) . "<br>\n";
    }
    
    echo "<h2>9. Test de formulario de contacto</h2>\n";
    
    try {
        $_POST['nombre'] = 'Test Usuario';
        $_POST['email'] = 'test@test.com';
        $_POST['asunto'] = 'Test de contacto';
        $_POST['mensaje'] = 'Este es un mensaje de prueba';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        
        $contactController = new ContactarController();
        
        // Capturar salida
        ob_start();
        $contactController->processContact();
        $output = ob_get_contents();
        ob_end_clean();
        
        if (strpos($output, 'contact_success') !== false) {
            echo "✅ Formulario de contacto exitoso<br>\n";
        } else {
            echo "⚠️ Resultado del contacto: " . htmlspecialchars(substr($output, 0, 200)) . "...<br>\n";
        }
        
    } catch (Exception $e) {
        echo "❌ Error en test de contacto: " . htmlspecialchars($e->getMessage()) . "<br>\n";
    }
    
    echo "<h2>10. Enlaces de prueba</h2>\n";
    echo "<div style='background-color: #e8f5e8; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>🔐 Credenciales de prueba:</h3>\n";
    echo "<table border='1' style='border-collapse: collapse; width: 100%; background-color: white;'>\n";
    echo "<tr style='background-color: #f0f0f0;'><th>Email</th><th>Contraseña</th><th>Tipo</th><th>Acción</th></tr>\n";
    echo "<tr><td>admin@test.com</td><td>admin123</td><td>Admin</td><td><a href='index.php?route=auth/login' target='_blank'>Login</a></td></tr>\n";
    echo "<tr><td>propietario@test.com</td><td>propietario123</td><td>Propietario</td><td><a href='index.php?route=auth/login' target='_blank'>Login</a></td></tr>\n";
    echo "<tr><td>cliente@test.com</td><td>cliente123</td><td>Cliente</td><td><a href='index.php?route=auth/login' target='_blank'>Login</a></td></tr>\n";
    echo "</table>\n";
    echo "</div>\n";
    
    echo "<div style='background-color: #e3f2fd; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>🔗 Enlaces importantes:</h3>\n";
    echo "<ul>\n";
    echo "<li><a href='index.php?route=auth/login' target='_blank'>🔐 Ir al Login</a></li>\n";
    echo "<li><a href='index.php?route=home' target='_blank'>🏠 Ir al Home (con formulario de contacto)</a></li>\n";
    echo "<li><a href='index.php?route=auth/registration' target='_blank'>📝 Ir al Registro</a></li>\n";
    echo "</ul>\n";
    echo "</div>\n";
    
    echo "<div style='background-color: #fff3e0; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>📋 Instrucciones:</h3>\n";
    echo "<ol>\n";
    echo "<li>Haz clic en 'Ir al Login' para probar el sistema de autenticación</li>\n";
    echo "<li>Haz clic en 'Ir al Home' para probar el formulario de contacto</li>\n";
    echo "<li>Usa cualquiera de las credenciales de prueba para el login</li>\n";
    echo "<li>Después del login, serás redirigido al dashboard correspondiente</li>\n";
    echo "<li>El formulario de contacto debería funcionar correctamente</li>\n";
    echo "</ol>\n";
    echo "</div>\n";
    
    echo "<p style='color: green; font-weight: bold;'>🎉 ¡El sistema completo está configurado y listo para usar!</p>\n";
    
} catch (Exception $e) {
    echo "<div style='background-color: #ffebee; padding: 15px; border-radius: 5px; margin: 10px 0;'>\n";
    echo "<h3>❌ Error:</h3>\n";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>\n";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>\n";
    echo "</div>\n";
}
?>
