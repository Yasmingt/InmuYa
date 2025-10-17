<?php
/**
 * Configuración de Instalación
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Este archivo ayuda a configurar el proyecto en diferentes entornos
 */

// Función para detectar automáticamente la configuración del entorno
function detectEnvironment() {
    $environments = [
        'development' => [
            'hosts' => ['localhost', '127.0.0.1', '::1'],
            'ports' => ['80', '8080', '8000', '3000']
        ],
        'production' => [
            'hosts' => ['tu-dominio.com', 'www.tu-dominio.com'],
            'ports' => ['80', '443']
        ]
    ];
    
    $currentHost = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $currentPort = $_SERVER['SERVER_PORT'] ?? '80';
    
    foreach ($environments as $env => $config) {
        if (in_array($currentHost, $config['hosts']) || in_array($currentPort, $config['ports'])) {
            return $env;
        }
    }
    
    return 'development'; // Por defecto
}

// Función para generar la URL base automáticamente
function generateBaseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
    
    // Limpiar el directorio del script
    $scriptDir = rtrim($scriptDir, '/');
    
    if ($scriptDir === '' || $scriptDir === '.') {
        return $protocol . '://' . $host . '/';
    }
    
    return $protocol . '://' . $host . $scriptDir . '/';
}

// Función para verificar la configuración de la base de datos
function checkDatabaseConfig() {
    $config = [
        'host' => DB_HOST,
        'database' => DB_NAME,
        'username' => DB_USER,
        'password' => DB_PASS
    ];
    
    try {
        $pdo = new PDO(
            "mysql:host={$config['host']};dbname={$config['database']}", 
            $config['username'], 
            $config['password']
        );
        return ['status' => 'success', 'message' => 'Conexión exitosa'];
    } catch (PDOException $e) {
        return ['status' => 'error', 'message' => $e->getMessage()];
    }
}

// Función para verificar permisos de archivos
function checkFilePermissions() {
    $directories = [
        'public/img' => 'Lectura y escritura para imágenes',
        'config' => 'Lectura para archivos de configuración'
    ];
    
    $results = [];
    
    foreach ($directories as $dir => $description) {
        $fullPath = __DIR__ . '/' . $dir;
        if (is_dir($fullPath)) {
            $results[$dir] = [
                'readable' => is_readable($fullPath),
                'writable' => is_writable($fullPath),
                'description' => $description
            ];
        } else {
            $results[$dir] = [
                'readable' => false,
                'writable' => false,
                'description' => $description,
                'error' => 'Directorio no encontrado'
            ];
        }
    }
    
    return $results;
}

// Función para mostrar información del sistema
function getSystemInfo() {
    return [
        'php_version' => PHP_VERSION,
        'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Desconocido',
        'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'Desconocido',
        'script_name' => $_SERVER['SCRIPT_NAME'] ?? 'Desconocido',
        'current_url' => generateBaseUrl(),
        'environment' => detectEnvironment()
    ];
}

// Función para crear un archivo de configuración personalizado
function createCustomConfig($customSettings = []) {
    $defaultSettings = [
        'BASE_URL' => generateBaseUrl(),
        'DB_HOST' => 'localhost',
        'DB_NAME' => 'propertypro_bd',
        'DB_USER' => 'root',
        'DB_PASS' => '',
        'DEBUG' => detectEnvironment() === 'development'
    ];
    
    $settings = array_merge($defaultSettings, $customSettings);
    
    $configContent = "<?php\n";
    $configContent .= "/**\n";
    $configContent .= " * Configuración Personalizada\n";
    $configContent .= " * Generada automáticamente el " . date('Y-m-d H:i:s') . "\n";
    $configContent .= " */\n\n";
    
    foreach ($settings as $key => $value) {
        if (is_string($value)) {
            $configContent .= "define('{$key}', '{$value}');\n";
        } elseif (is_bool($value)) {
            $configContent .= "define('{$key}', " . ($value ? 'true' : 'false') . ");\n";
        } else {
            $configContent .= "define('{$key}', {$value});\n";
        }
    }
    
    return $configContent;
}

// Función para validar la instalación
function validateInstallation() {
    $checks = [
        'database' => checkDatabaseConfig(),
        'permissions' => checkFilePermissions(),
        'system' => getSystemInfo()
    ];
    
    $allGood = true;
    
    if ($checks['database']['status'] !== 'success') {
        $allGood = false;
    }
    
    foreach ($checks['permissions'] as $dir => $perm) {
        if (!$perm['readable']) {
            $allGood = false;
            break;
        }
    }
    
    return [
        'valid' => $allGood,
        'checks' => $checks
    ];
}
?>
