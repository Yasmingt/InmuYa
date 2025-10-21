<?php
/**
 * Controlador de Usuarios
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja todas las operaciones relacionadas con usuarios
 */

require_once __DIR__ . '/../models/UsuarioModel.php';

class UsuarioController {
    private $usuarioModel;
    
    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }
    
    /** Verificar acceso de administrador */
    private function verificarAccesoAdministrador() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verificar si el usuario está logueado
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'index.php?route=auth/login');
            exit();
        }
        
        // Verificar si es administrador
        if ($_SESSION['user_type'] !== 'admin' && $_SESSION['user_type'] !== 'administrativo') {
            header('Location: ' . BASE_URL . 'index.php?route=auth/login');
            exit();
        }
    }
    
    /** Mostrar gestión de usuarios para administradores */
    public function mostrarGestionUsuarios() {
        $this->verificarAccesoAdministrador();
        
        // Obtener todos los usuarios desde la base de datos
        $usuarios = $this->usuarioModel->obtenerTodosLosUsuarios();
        
        // Definir variables para el layout
        $title = 'Gestión de Usuarios ';
        $description = 'Administrar usuarios del sistema';
        $pageTitle = 'Gestión de Usuarios';
        
        // Incluir la vista
        include __DIR__ . '/../views/admin/usuarios/usuarios.php';
    }
    
    /** Mostrar formulario de creación de usuario */
    public function mostrarFormularioCreacionUsuario() {
        $this->verificarAccesoAdministrador();
        
        // Definir variables para el layout
        $title = 'Crear Nuevo Usuario';
        $description = 'Crear nuevo usuario en el sistema';
        $pageTitle = 'Crear Nuevo Usuario';
        
        // Incluir la vista
        include __DIR__ . '/../views/admin/usuarios/crearUsuario.php';
    }
    
    /** Mostrar formulario de actualización de usuario*/
    public function mostrarFormularioActualizacionUsuario() {
        $this->verificarAccesoAdministrador();
        
        $user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($user_id <= 0) {
            header('Location: ' . BASE_URL . 'index.php?route=admin/usuarios/usuarios');
            exit;
        }
        
        // Obtener datos del usuario
        $usuario = $this->usuarioModel->usuarioPorId($user_id);
        
        if (!$usuario) {
            header('Location: ' . BASE_URL . 'index.php?route=admin/usuarios/usuarios');
            exit;
        }
        
        // Definir variables para el layout
        $title = 'Editar Usuario - Panel de Administración';
        $description = 'Editar información del usuario';
        $pageTitle = 'Editar Usuario';
        
        // Incluir la vista de edición
        include __DIR__ . '/../views/admin/usuarios/actualizarUsuario.php';
    }
    
    /** Procesar actualización de usuario */
    public function procesarActualizacionUsuario() {
        $this->verificarAccesoAdministrador();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            
            if ($user_id <= 0) {
                header('Location: ' . BASE_URL . 'index.php?route=admin/usuarios/usuarios');
                exit;
            }
            
            // Obtener datos del formulario
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $tipodocumento = (int)($_POST['tipodocumento'] ?? 0);
            $numerodocumento = trim($_POST['numerodocumento'] ?? '');
            $fechadenacimiento = $_POST['fechadenacimiento'] ?? '';
            $tipo_usuario = trim($_POST['tipo_usuario'] ?? '');
            
            // Validar datos
            $errors = [];
            
            if (empty($nombre)) {
                $errors[] = 'El nombre es obligatorio';
            }
            
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'El email es obligatorio y debe ser válido';
            }
            
            if (empty($numerodocumento)) {
                $errors[] = 'El número de documento es obligatorio';
            }
            
            if (empty($fechadenacimiento)) {
                $errors[] = 'La fecha de nacimiento es obligatoria';
            }
            
            if (!in_array($tipo_usuario, ['cliente', 'propietario', 'admin'])) {
                $errors[] = 'El tipo de usuario no es válido';
            }
            
            if (empty($errors)) {
                try {
                    // Actualizar usuario
                    $result = $this->usuarioModel->actualizarUsuario($user_id, [
                        'nombre' => $nombre,
                        'email' => $email,
                        'telefono' => $telefono,
                        'tipodocumento' => $tipodocumento,
                        'numerodocumento' => $numerodocumento,
                        'fechadenacimiento' => $fechadenacimiento,
                        'tipo_usuario' => $tipo_usuario
                    ]);
                    
                    header('Location: ' . BASE_URL . 'index.php?route=admin/usuarios/usuarios&success=updated');
                    exit;
                } catch (Exception $e) {
                    $errors[] = 'Error al actualizar el usuario: ' . $e->getMessage();
                }
            }
            
            // Si hay errores, volver al formulario
            $usuario = $this->usuarioModel->usuarioPorId($user_id);
            $title = 'Editar Usuario - Panel de Administración';
            $description = 'Editar información del usuario';
            $pageTitle = 'Editar Usuario';
            
            include __DIR__ . '/../views/admin/usuarios/actualizarUsuario.php';
        } else {
            $this->mostrarGestionUsuarios();
        }
    }
    
    /** Eliminar usuario */
    public function eliminarUsuario() {
        $this->verificarAccesoAdministrador();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
            $user_id = (int)$_POST['user_id'];
            
            try {
                $result = $this->usuarioModel->eliminarUsuario($user_id);
                
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Usuario eliminado correctamente'
                ]);
                exit;
            } catch (Exception $e) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al eliminar el usuario: ' . $e->getMessage()
                ]);
                exit;
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Método no permitido'
        ]);
        exit;
    }
    
    /** Crear nuevo usuario usando la lógica de registro */
    public function crearUsuario() {
        $this->verificarAccesoAdministrador();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Preparar datos del formulario usando la misma estructura que el registro
            $data = [
                'id_usuario' => null, // Se generará automáticamente
                'nombre' => trim($_POST['nombre'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'telefono' => trim($_POST['telefono'] ?? ''),
                'tipodocumento' => (int)($_POST['tipodocumento'] ?? 9),
                'numerodocumento' => trim($_POST['numerodocumento'] ?? ''),
                'fechadenacimiento' => $_POST['fechadenacimiento'] ?? '',
                'contrasena' => trim($_POST['contrasena'] ?? ''),
                'contrasenaverificar' => trim($_POST['confirmar_contrasena'] ?? ''),
                'tipo_usuario' => trim($_POST['tipo_usuario'] ?? 'cliente')
            ];
            
            // Validar datos usando la misma lógica del registro
            $validation = $this->validarDatosUsuario($data);
            
            if ($validation['valid']) {
                try {
                    // Hash de contraseña
                    $data['contrasena'] = password_hash($data['contrasena'], PASSWORD_DEFAULT);
                    
                    // Crear usuario
                    $result = $this->usuarioModel->crearUsuario($data);
                    
                    if ($result) {
                        header('Location: ' . BASE_URL . 'index.php?route=admin/usuarios/usuarios&success=created');
                        exit;
                    } else {
                        $errors[] = 'Error al crear el usuario. Inténtalo de nuevo.';
                    }
                } catch (Exception $e) {
                    $errors[] = 'Error al crear el usuario: ' . $e->getMessage();
                }
            } else {
                $errors[] = $validation['message'];
            }
            
            // Si hay errores, mostrar formulario con errores
            $title = 'Nuevo Usuario - Panel de Administración';
            $description = 'Crear nuevo usuario';
            $pageTitle = 'Nuevo Usuario';
            
            include __DIR__ . '/../views/admin/usuarios/crearUsuario.php';
        } else {
            $this->mostrarGestionUsuarios();
        }
    }
    
    /** Validar datos de usuario */
    private function validarDatosUsuario($data) {
        // Validar nombre
        if (empty($data['nombre']) || strlen($data['nombre']) < 2) {
            return ['valid' => false, 'message' => 'El nombre debe tener al menos 2 caracteres'];
        }
        
        // Validar email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['valid' => false, 'message' => 'El email no es válido'];
        }
        
        // Verificar si el email ya existe
        if ($this->usuarioModel->emailExiste($data['email'])) {
            return ['valid' => false, 'message' => 'Ya existe un usuario con este email'];
        }
        
        // Validar número de documento
        if (empty($data['numerodocumento']) || !is_numeric($data['numerodocumento'])) {
            return ['valid' => false, 'message' => 'El número de documento es requerido y debe ser numérico'];
        }
        
        // Verificar si el número de documento ya existe
        if ($this->usuarioModel->idExiste($data['numerodocumento'])) {
            return ['valid' => false, 'message' => 'Ya existe un usuario con este número de documento'];
        }
        
        // Validar fecha de nacimiento
        if (empty($data['fechadenacimiento'])) {
            return ['valid' => false, 'message' => 'La fecha de nacimiento es requerida'];
        }
        
        // Validar contraseña
        if (empty($data['contrasena']) || strlen($data['contrasena']) < 6) {
            return ['valid' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres'];
        }
        
        // Validar confirmación de contraseña
        if ($data['contrasena'] !== $data['contrasenaverificar']) {
            return ['valid' => false, 'message' => 'Las contraseñas no coinciden'];
        }
        
        // Validar tipo de usuario
        if (!in_array($data['tipo_usuario'], ['cliente', 'propietario', 'admin'])) {
            return ['valid' => false, 'message' => 'El tipo de usuario no es válido'];
        }
        
        return ['valid' => true, 'message' => 'Datos válidos'];
    }
}
?>
