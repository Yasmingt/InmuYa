<?php
/**
 * Controlador de Usuarios
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja todas las operaciones relacionadas con usuarios
 */

require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    /**
     * Mostrar gestión de usuarios para administradores
     */
    public function showUsers() {
        // Obtener todos los usuarios desde la base de datos
        $usuarios = $this->userModel->getAllUsers();
        
        // Definir variables para el layout
        $title = 'Gestión de Usuarios ';
        $description = 'Administrar usuarios del sistema';
        $pageTitle = 'Gestión de Usuarios';
        
        // Incluir la vista
        include __DIR__ . '/../views/user/usuarios.php';
    }
    
    /**
     * Mostrar formulario de creación de usuario
     */
    public function showCreateUser() {
        // Definir variables para el layout
        $title = 'Crear Nuevo Usuario';
        $description = 'Crear nuevo usuario en el sistema';
        $pageTitle = 'Crear Nuevo Usuario';
        
        // Incluir la vista
        include __DIR__ . '/../views/user/newUsuario.php';
    }
    
    /**
     * Mostrar formulario de edición de usuario
     */
    public function showEditUser() {
        $user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($user_id <= 0) {
            header('Location: ' . BASE_URL . 'index.php?route=user/usuarios');
            exit;
        }
        
        // Obtener datos del usuario
        $usuario = $this->userModel->getUserById($user_id);
        
        if (!$usuario) {
            header('Location: ' . BASE_URL . 'index.php?route=user/usuarios');
            exit;
        }
        
        // Definir variables para el layout
        $title = 'Editar Usuario - Panel de Administración';
        $description = 'Editar información del usuario';
        $pageTitle = 'Editar Usuario';
        
        // Incluir la vista de edición
        include __DIR__ . '/../views/user/updateUsuario.php';
    }
    
    /**
     * Procesar actualización de usuario
     */
    public function updateUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
            
            if ($user_id <= 0) {
                header('Location: ' . BASE_URL . 'index.php?route=user/usuarios');
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
                    $result = $this->userModel->updateUser($user_id, [
                        'nombre' => $nombre,
                        'email' => $email,
                        'telefono' => $telefono,
                        'tipodocumento' => $tipodocumento,
                        'numerodocumento' => $numerodocumento,
                        'fechadenacimiento' => $fechadenacimiento,
                        'tipo_usuario' => $tipo_usuario
                    ]);
                    
                    header('Location: ' . BASE_URL . 'index.php?route=user/usuarios&success=1');
                    exit;
                } catch (Exception $e) {
                    $errors[] = 'Error al actualizar el usuario: ' . $e->getMessage();
                }
            }
            
            // Si hay errores, volver al formulario
            $usuario = $this->userModel->getUserById($user_id);
            $title = 'Editar Usuario - Panel de Administración';
            $description = 'Editar información del usuario';
            $pageTitle = 'Editar Usuario';
            
            include __DIR__ . '/../views/user/updateUsuario.php';
        } else {
            $this->showUsers();
        }
    }
    
    /**
     * Eliminar usuario
     */
    public function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
            $user_id = (int)$_POST['user_id'];
            
            try {
                $result = $this->userModel->deleteUser($user_id);
                
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
    
    /**
     * Crear nuevo usuario usando la lógica de registro
     */
    public function createUser() {
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
            $validation = $this->validateUserData($data);
            
            if ($validation['valid']) {
                try {
                    // Hash de contraseña
                    $data['contrasena'] = password_hash($data['contrasena'], PASSWORD_DEFAULT);
                    
                    // Crear usuario
                    $result = $this->userModel->createUser($data);
                    
                    if ($result) {
                        header('Location: ' . BASE_URL . 'index.php?route=user/usuarios&success=1');
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
            
            include __DIR__ . '/../views/user/newUsuario.php';
        } else {
            $this->showUsers();
        }
    }
    
    /**
     * Validar datos de usuario 
     */
    private function validateUserData($data) {
        // Validar nombre
        if (empty($data['nombre']) || strlen($data['nombre']) < 2) {
            return ['valid' => false, 'message' => 'El nombre debe tener al menos 2 caracteres'];
        }
        
        // Validar email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['valid' => false, 'message' => 'El email no es válido'];
        }
        
        // Verificar si el email ya existe
        if ($this->userModel->emailExists($data['email'])) {
            return ['valid' => false, 'message' => 'Ya existe un usuario con este email'];
        }
        
        // Validar número de documento
        if (empty($data['numerodocumento']) || !is_numeric($data['numerodocumento'])) {
            return ['valid' => false, 'message' => 'El número de documento es requerido y debe ser numérico'];
        }
        
        // Verificar si el número de documento ya existe
        if ($this->userModel->idExists($data['numerodocumento'])) {
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
