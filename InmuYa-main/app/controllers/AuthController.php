<?php
/**
 * Controlador de Autenticación
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja toda la lógica relacionada con login, registro y recuperación de contraseña
 */

class AuthController {
    private $userModel;
    
    public function __construct() {
        // Incluir el modelo de usuario
        require_once __DIR__ . '/../models/UsuarioModel.php';
        $this->usuarioModel = new UsuarioModel();
    }
    
    /** Mostrar login */
    public function mostrarLogin($error = null, $success = null) {
        $title = 'Iniciar Sesión - InmuYa';
        $description = 'Inicia sesión en tu cuenta de InmuYa';
        
        // Verificar si hay un mensaje de éxito en la URL
        if (isset($_GET['success']) && empty($success)) {
            $success = $_GET['success'];
        }
        
        // Incluir la vista de login
        include __DIR__ . '/../views/auth/login.php';
    }
    
    /** Procesar login */
    public function procesarLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Validar datos
            if (empty($email) || empty($password)) {
                $error = 'Por favor, completa todos los campos';
                $this->mostrarLogin($error);
                return;
            }
            
            // Verificar credenciales
            $usuario = $this->usuarioModel->usuarioPorEmail($email);
            
            // Verificar contraseña (compatible con texto plano y hash)
            $passwordValid = false;
            if ($usuario) {
                // Primero intentar con password_verify (para contraseñas hasheadas)
                if (password_verify($password, $usuario['contrasena'])) {
                    $passwordValid = true;
                } 
                // Si falla, verificar como texto plano (para contraseñas existentes)
                elseif ($password === $usuario['contrasena']) {
                    $passwordValid = true;
                    // Actualizar la contraseña a hash para mayor seguridad
                    $this->usuarioModel->cambiarContrasena($usuario['id_usuario'], $password);
                }
            }
            
            if ($usuario && $passwordValid) {
                // Iniciar sesión
                session_start();
                $_SESSION['user_id'] = $usuario['id_usuario'];
                $_SESSION['user_name'] = $usuario['nombre'];
                $_SESSION['user_email'] = $usuario['email'];
                $_SESSION['user_type'] = $usuario['tipo_usuario'];
                
                // Regenerar ID de sesión por seguridad
                session_regenerate_id(true);
                
                // Redirigir según tipo de usuario
                $this->redirigirDespuesDelLogin($usuario['tipo_usuario']);
            } else {
                $error = 'Credenciales incorrectas';
                $this->mostrarLogin($error);
            }
        } else {
            $this->mostrarLogin();
        }
    }
    
    /** Mostrar formulario de registro */
    public function mostrarFormularioRegistro($error = null, $success = null) {
        $title = 'Registrarse - InmuYa';
        $description = 'Crea tu cuenta en InmuYa y comienza a buscar tu hogar ideal';
        
        // Incluir la vista de registro
        include __DIR__ . '/../views/auth/registro.php';
    }
    
    /** Procesar registro */
    public function procesarRegistro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Mapear tipos de documento de texto a números
            $tiposDocumento = [
                'cedula' => 9,
                'extranjeria' => 14,
                'pasaporte' => 15, 
                'ppt' => 16,       
                'pep' => 17       
            ];
            
            $data = [
                'id_usuario' => (int)$_POST['identificacion'] ?? 0,
                'nombre' => $_POST['nombre'] ?? '',
                'email' => $_POST['email'] ?? '',
                'telefono' => $_POST['telefono'] ?? '',
                'tipodocumento' => $tiposDocumento[$_POST['tipodedocumento']] ?? 9,
                'numerodocumento' => $_POST['identificacion'] ?? '',
                'fechadenacimiento' => $_POST['fechadenacimiento'] ?? '',
                'contrasena' => $_POST['contrasena'] ?? '',
                'contrasenaverificar' => $_POST['contrasenaverificar'] ?? '',
                'tipo_usuario' => $_POST['tipodeusuario'] ?? ''
            ];
            
            // Validar datos
            $validation = $this->validarDatosRegistro($data);
            
            if ($validation['valid']) {
                // Hash de contraseña
                $data['contrasena'] = password_hash($data['contrasena'], PASSWORD_DEFAULT);
                // Crear usuario
                if ($this->usuarioModel->crearUsuario($data)) {
                    header('Location: ' . BASE_URL . 'index.php?route=auth/login&success=Cuenta creada exitosamente. Ya puedes iniciar sesión.');
                    exit;
                } else {
                    $error = 'Error al crear la cuenta. Inténtalo de nuevo.';
                    $this->mostrarFormularioRegistro($error);
                }
            } else {
                $error = $validation['message'];
                $this->mostrarFormularioRegistro($error);
            }
        } else {
            $this->mostrarFormularioRegistro();
        }
    }
    
    /** Mostrar formulario de recuperación de contraseña */
    public function mostrarFormularioRecuperacionContrasena($error = null, $success = null) {
        $title = 'Recuperar Contraseña - InmuYa';
        $description = 'Recupera el acceso a tu cuenta de InmuYa';
        
        // Incluir la vista de recuperación
        include __DIR__ . '/../views/auth/recuperarContrasena.php';
    }
    
    /**Procesar recuperación de contraseña */
    public function procesarRecuperacionContrasena() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            $error = null;
            $success = null;
            
            if (empty($email) || empty($newPassword) || empty($confirmPassword)) {
                $error = 'Todos los campos son obligatorios';
                $this->mostrarFormularioRecuperacionContrasena($error);
                return;
            }
            
            if ($newPassword !== $confirmPassword) {
                $error = 'Las contraseñas no coinciden';
                $this->mostrarFormularioRecuperacionContrasena($error);
                return;
            }
            
            if (strlen($newPassword) < 8) {
                $error = 'La contraseña debe tener al menos 8 caracteres';
                $this->mostrarFormularioRecuperacionContrasena($error);
                return;
            }
            
            // Verificar si el email existe
            $usuario = $this->usuarioModel->usuarioPorEmail($email);
            
            if ($usuario) {
                // Actualizar contraseña directamente
                if ($this->usuarioModel->cambiarContrasena($usuario['id_usuario'], $newPassword)) {
                    $success = 'Contraseña actualizada exitosamente. Ya puedes iniciar sesión con tu nueva contraseña.';
                } else {
                    $error = 'Error al actualizar la contraseña. Inténtalo de nuevo.';
                }
            } else {
                $error = 'No se encontró un usuario con ese correo electrónico.';
            }
            
            $this->mostrarFormularioRecuperacionContrasena($error, $success);
        } else {
            $this->mostrarFormularioRecuperacionContrasena();
        }
    }
    
    
    /** Cerrar sesión */
    public function cerrarSesion() {
    session_start();
    session_destroy();
    header('Location: ' . BASE_URL . 'index.php');
    exit;
    }
    
    /** Validar datos de registro */
    private function validarDatosRegistro($data) {
        // Validar ID de usuario
        if (empty($data['id_usuario']) || $data['id_usuario'] <= 0) {
            return ['valid' => false, 'message' => 'La identificación es requerida y debe ser un número válido'];
        }
        
        // Verificar si el ID ya existe
        if ($this->usuarioModel->idExiste($data['id_usuario'])) {
            return ['valid' => false, 'message' => 'Ya existe un usuario con esta identificación'];
        }
        
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
        
        // Validar contraseñas
        if ($data['contrasena'] !== $data['contrasenaverificar']) {
            return ['valid' => false, 'message' => 'Las contraseñas no coinciden'];
        }
        
        if (strlen($data['contrasena']) < 6) {
            return ['valid' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres'];
        }
        
        // Validar teléfono
        if (empty($data['telefono']) || !preg_match('/^[0-9+\-\s()]+$/', $data['telefono'])) {
            return ['valid' => false, 'message' => 'El teléfono no es válido'];
        }
        
        return ['valid' => true, 'message' => ''];
    }
    
    /** Redirigir después del login según tipo de usuario */
    private function redirigirDespuesDelLogin($userType) {
        switch ($userType) {
            case 'admin':
                header('Location: ' . BASE_URL . 'index.php?route=admin/dashboard');
                break;
            case 'propietario':
                header('Location: ' . BASE_URL . 'index.php?route=propietario/dashboard');
                break;
            case 'cliente':
                header('Location: ' . BASE_URL . 'index.php?route=cliente/dashboard');
                break;
            default:
                header('Location: ' . BASE_URL);
        }
        exit;
    }
}
?>
