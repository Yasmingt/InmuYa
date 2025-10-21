<?php
/**
 * Configuración de Rutas
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Define las rutas del sistema y sus controladores correspondientes
 */

// Definir la URL base del proyecto (solo si no está definida)
if (!defined('BASE_URL')) {
    // Detectar automáticamente la URL base del proyecto
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    
    // Obtener el directorio del script actual
    $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
    
    // Si estamos en el directorio raíz del proyecto
    if ($scriptDir === '/' || $scriptDir === '') {
        $baseUrl = $protocol . '://' . $host . '/';
    } else {
        // Construir la URL base con el directorio del script
        $baseUrl = $protocol . '://' . $host . $scriptDir . '/';
    }
    
    define('BASE_URL', $baseUrl);
}

// Definir rutas del sistema
$routes = [

    // Propiedades Públicas
    'home' => [
        'controller' => 'PropiedadController',
        'action' => 'index',
        'view' => 'home/index.php',
        'layout' => 'index'
    ],
    
    // Autenticación
    'auth/login' => [
        'controller' => 'AuthController',
        'action' => 'mostrarLogin',
        'view' => 'auth/login.php',
        'layout' => 'login'
    ],

    // Recuperación de contraseña
    'auth/recuperar-contrasena' => [
        'controller' => 'AuthController',
        'action' => 'mostrarFormularioRecuperacionContrasena',
        'view' => 'auth/recuperarContrasena.php',
        'layout' => 'main'
    ],

    // Registro de usuario
    'auth/registro' => [
        'controller' => 'AuthController',
        'action' => 'mostrarFormularioRegistro',
        'view' => 'auth/registro.php',
        'layout' => 'main'
    ],
    
    'auth/procesar-login' => [
        'controller' => 'AuthController',
        'action' => 'procesarLogin',
        'view' => null,
        'layout' => null
    ],
    
    'auth/procesar-registro' => [
        'controller' => 'AuthController',
        'action' => 'procesarRegistro',
        'view' => null,
        'layout' => null
    ],
    
    'auth/procesar-recuperar' => [
        'controller' => 'AuthController',
        'action' => 'procesarRecuperacionContrasena',
        'view' => null,
        'layout' => null
    ],
    
    'auth/cerrar-sesion' => [
        'controller' => 'AuthController',
        'action' => 'cerrarSesion',
        'view' => null,
        'layout' => null
    ],
    
    // Panel de Administración
    'admin/dashboard' => [
        'controller' => 'AdminController',
        'action' => 'dashboard',
        'view' => 'admin/dashboard.php',
        'layout' => 'admin'
    ],
    

    // Gestión de Usuarios
    'admin/usuarios/usuarios' => [
        'controller' => 'UsuarioController',
        'action' => 'mostrarGestionUsuarios',
        'view' => 'admin/usuarios/usuarios.php',
        'layout' => 'admin'
    ],
    
    'admin/usuarios/nuevo' => [
        'controller' => 'UsuarioController',
        'action' => 'mostrarFormularioCreacionUsuario',
        'view' => 'admin/usuarios/crearUsuario.php',
        'layout' => 'admin'
    ],
    
    'admin/usuarios/crear' => [
        'controller' => 'UsuarioController',
        'action' => 'crearUsuario',
        'view' => null,
        'layout' => null
    ],

    'admin/usuarios/editar' => [
        'controller' => 'UsuarioController',
        'action' => 'mostrarFormularioActualizacionUsuario',
        'view' => 'admin/usuarios/actualizarUsuario.php',
        'layout' => 'admin'
    ],
    
    'admin/usuarios/actualizar' => [
        'controller' => 'UsuarioController',
        'action' => 'procesarActualizacionUsuario',
        'view' => null,
        'layout' => null
    ],
    
    'admin/usuarios/eliminar' => [
        'controller' => 'UsuarioController',
        'action' => 'eliminarUsuario',
        'view' => null,
        'layout' => null
    ],

    //Gestión de Propiedades
    
    'admin/propiedades' => [
        'controller' => 'PropiedadController',
        'action' => 'adminPropiedades',
        'view' => 'admin/propiedad/propiedades.php',
        'layout' => 'admin'
    ],
    
    'admin/crear-propiedad' => [
        'controller' => 'PropiedadController',
        'action' => 'crearPropiedad',
        'view' => 'admin/propiedad/crearPropiedad.php',
        'layout' => 'admin'
    ],
    
    'admin/editar-propiedad' => [
        'controller' => 'PropiedadController',
        'action' => 'editarPropiedad',
        'view' => 'admin/propiedad/editarPropiedad.php',
        'layout' => 'admin'
    ],
    
    'admin/eliminar-propiedad' => [
        'controller' => 'PropiedadController',
        'action' => 'eliminarPropiedad',
        'view' => null,
        'layout' => null
    ],
    
    'admin/toggle-destacado' => [
        'controller' => 'PropiedadController',
        'action' => 'toggleDestacado',
        'view' => null,
        'layout' => null
    ],
    
    // Gestión de Imágenes
    'admin/gestionar-imagenes' => [
        'controller' => 'ImageController',
        'action' => 'gestionarImagenes',
        'view' => 'admin/propiedad/gestionarImagenes.php',
        'layout' => 'admin'
    ],
    
    'admin/subir-imagenes' => [
        'controller' => 'ImageController',
        'action' => 'subirImagenes',
        'view' => null,
        'layout' => null
    ],
    
    'admin/eliminar-imagen' => [
        'controller' => 'ImageController',
        'action' => 'eliminarImagen',
        'view' => null,
        'layout' => null
    ],
    
    'admin/guardar-imagenes' => [
        'controller' => 'ImageController',
        'action' => 'guardarImagenes',
        'view' => null,
        'layout' => null
    ],
    
    'admin/marcar-principal' => [
        'controller' => 'ImageController',
        'action' => 'marcarPrincipal',
        'view' => null,
        'layout' => null
    ],
    
    'admin/actualizar-orden-imagenes' => [
        'controller' => 'ImageController',
        'action' => 'actualizarOrden',
        'view' => null,
        'layout' => null
    ],
    
    'admin/obtener-imagenes' => [
        'controller' => 'ImageController',
        'action' => 'obtenerImagenes',
        'view' => null,
        'layout' => null
    ],
    
    'admin/vista-previa-imagen' => [
        'controller' => 'ImageController',
        'action' => 'vistaPrevia',
        'view' => 'admin/propiedad/vistaPreviaImagen.php',
        'layout' => 'admin'
    ],
    
    'admin/obtener-barrios' => [
        'controller' => 'PropiedadController',
        'action' => 'obtenerBarriosPorCiudad',
        'view' => null,
        'layout' => null
    ],

    // Gestión de Contactos
    'admin/contactos' => [
        'controller' => 'AdminController',
        'action' => 'contactos',
        'view' => 'admin/contactos/contactos.php',
        'layout' => 'admin'
    ],
    
    'contact/change-status' => [
        'controller' => 'ContactoController',
        'action' => 'cambiarEstado',
        'view' => null,
        'layout' => null
    ],
    
    'admin/contactos/eliminar' => [
        'controller' => 'ContactoController',
        'action' => 'eliminarContacto',
        'view' => null,
        'layout' => null
    ],
        
    'contactar-propiedad' => [
        'controller' => 'ContactoController',
        'action' => 'procesarFormularioContacto',
        'view' => null,
        'layout' => null
    ],
    
    
];

// Función para obtener la ruta
function getRoute($route) {
    global $routes;
    return isset($routes[$route]) ? $routes[$route] : null;
}

// Función para obtener la URL base
function getBaseUrl() {
    return BASE_URL;
}
?>
