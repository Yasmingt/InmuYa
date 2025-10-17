<?php
/**
 * Debug de Configuración
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Este archivo ayuda a diagnosticar problemas de configuración
 * Accede desde: tu-sitio.com/debug.php
 */

// Incluir configuración
require_once __DIR__ . '/config.php';

// Solo permitir acceso en modo desarrollo
if (!defined('DEBUG') || !DEBUG) {
    http_response_code(403);
    die('Acceso denegado. Solo disponible en modo desarrollo.');
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug - InmuYa</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .success { background: #d4edda; border-color: #c3e6cb; color: #155724; }
        .error { background: #f8d7da; border-color: #f5c6cb; color: #721c24; }
        .warning { background: #fff3cd; border-color: #ffeaa7; color: #856404; }
        .info { background: #d1ecf1; border-color: #bee5eb; color: #0c5460; }
        h1, h2 { color: #333; }
        pre { background: #f8f9fa; padding: 10px; border-radius: 4px; overflow-x: auto; }
        .status { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .status.ok { background: #28a745; color: white; }
        .status.error { background: #dc3545; color: white; }
        .status.warning { background: #ffc107; color: #212529; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Debug de Configuración - InmuYa</h1>
        
        <!-- Información del Sistema -->
        <div class="section info">
            <h2>📊 Información del Sistema</h2>
            <p><strong>PHP Version:</strong> <?php echo PHP_VERSION; ?></p>
            <p><strong>Servidor:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Desconocido'; ?></p>
            <p><strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT'] ?? 'Desconocido'; ?></p>
            <p><strong>Script Name:</strong> <?php echo $_SERVER['SCRIPT_NAME'] ?? 'Desconocido'; ?></p>
            <p><strong>Request URI:</strong> <?php echo $_SERVER['REQUEST_URI'] ?? 'Desconocido'; ?></p>
        </div>

        <!-- Configuración de Rutas -->
        <div class="section">
            <h2>🛣️ Configuración de Rutas</h2>
            <p><strong>BASE_URL:</strong> <code><?php echo BASE_URL; ?></code></p>
            <p><strong>Protocolo:</strong> <?php echo isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'HTTPS' : 'HTTP'; ?></p>
            <p><strong>Host:</strong> <?php echo $_SERVER['HTTP_HOST'] ?? 'Desconocido'; ?></p>
            <p><strong>Puerto:</strong> <?php echo $_SERVER['SERVER_PORT'] ?? 'Desconocido'; ?></p>
            <p><strong>Script Directory:</strong> <?php echo dirname($_SERVER['SCRIPT_NAME']); ?></p>
        </div>

        <!-- Verificación de Archivos -->
        <div class="section">
            <h2>📁 Verificación de Archivos</h2>
            <?php
            $files = [
                'config/config.php' => 'Archivo de configuración principal',
                'config/routes.php' => 'Archivo de rutas',
                'config/conexion.php' => 'Archivo de conexión a BD',
                'index.php' => 'Punto de entrada principal',
                '.htaccess' => 'Archivo de configuración Apache'
            ];
            
            foreach ($files as $file => $description) {
                $exists = file_exists(__DIR__ . '/' . $file);
                $status = $exists ? 'ok' : 'error';
                echo "<p><span class='status {$status}'>" . ($exists ? '✓' : '✗') . "</span> <strong>{$file}</strong> - {$description}</p>";
            }
            ?>
        </div>

        <!-- Verificación de Directorios -->
        <div class="section">
            <h2>📂 Verificación de Directorios</h2>
            <?php
            $directories = [
                'public/css' => 'Estilos CSS',
                'public/img' => 'Imágenes',
                'app/controllers' => 'Controladores',
                'app/models' => 'Modelos',
                'app/views' => 'Vistas'
            ];
            
            foreach ($directories as $dir => $description) {
                $exists = is_dir(__DIR__ . '/' . $dir);
                $readable = $exists && is_readable(__DIR__ . '/' . $dir);
                $status = $exists && $readable ? 'ok' : ($exists ? 'warning' : 'error');
                echo "<p><span class='status {$status}'>" . ($exists && $readable ? '✓' : ($exists ? '⚠' : '✗')) . "</span> <strong>{$dir}</strong> - {$description}</p>";
            }
            ?>
        </div>

        <!-- Verificación de Base de Datos -->
        <div class="section">
            <h2>🗄️ Verificación de Base de Datos</h2>
            <?php
            try {
                $pdo = new PDO(
                    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, 
                    DB_USER, 
                    DB_PASS
                );
                echo "<p><span class='status ok'>✓</span> <strong>Conexión exitosa</strong> a la base de datos</p>";
                echo "<p><strong>Host:</strong> " . DB_HOST . "</p>";
                echo "<p><strong>Base de datos:</strong> " . DB_NAME . "</p>";
                echo "<p><strong>Usuario:</strong> " . DB_USER . "</p>";
                
                // Verificar tablas principales
                $tables = ['usuarios', 'tipodocumento', 'contactos'];
                foreach ($tables as $table) {
                    $stmt = $pdo->query("SHOW TABLES LIKE '{$table}'");
                    $exists = $stmt->rowCount() > 0;
                    $status = $exists ? 'ok' : 'error';
                    echo "<p><span class='status {$status}'>" . ($exists ? '✓' : '✗') . "</span> <strong>Tabla {$table}</strong></p>";
                }
                
            } catch (PDOException $e) {
                echo "<p><span class='status error'>✗</span> <strong>Error de conexión:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            ?>
        </div>

        <!-- Verificación de CSS -->
        <div class="section">
            <h2>🎨 Verificación de Archivos CSS</h2>
            <?php
            $cssFiles = ['app.css', 'admin.css', 'login.css', 'dashboard.css', 'usuarios.css'];
            foreach ($cssFiles as $css) {
                $exists = file_exists(__DIR__ . '/public/css/' . $css);
                $status = $exists ? 'ok' : 'error';
                echo "<p><span class='status {$status}'>" . ($exists ? '✓' : '✗') . "</span> <strong>{$css}</strong></p>";
            }
            ?>
        </div>

        <!-- URLs de Prueba -->
        <div class="section">
            <h2>🔗 URLs de Prueba</h2>
            <p>Prueba estas URLs para verificar que las rutas funcionan:</p>
            <ul>
                <li><a href="<?php echo BASE_URL; ?>" target="_blank">Página Principal</a></li>
                <li><a href="<?php echo BASE_URL; ?>index.php?route=auth/login" target="_blank">Login</a></li>
                <li><a href="<?php echo BASE_URL; ?>index.php?route=auth/registration" target="_blank">Registro</a></li>
                <li><a href="<?php echo BASE_URL; ?>public/css/app.css" target="_blank">CSS Principal</a></li>
                <li><a href="<?php echo BASE_URL; ?>public/img/logo.jpeg" target="_blank">Logo</a></li>
            </ul>
        </div>

        <!-- Información de Debug -->
        <div class="section warning">
            <h2>⚠️ Información Importante</h2>
            <p><strong>Este archivo solo debe estar disponible en modo desarrollo.</strong></p>
            <p>En producción, asegúrate de:</p>
            <ul>
                <li>Cambiar <code>DEBUG</code> a <code>false</code> en <code>config/config.php</code></li>
                <li>Eliminar este archivo de debug</li>
                <li>Configurar permisos apropiados</li>
            </ul>
        </div>
    </div>
</body>
</html>
