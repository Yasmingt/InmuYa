<?php
/**
 * Crear Nuevo Usuario - Panel de Administración
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Definir variables para el layout
$title = 'Crear Nuevo Usuario - Panel de Administración';
$description = 'Crear nuevo usuario en el sistema';
$pageTitle = 'Crear Nuevo Usuario';
$currentPage = 'usuarios';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Crear Nuevo Usuario - InmuYa'; ?></title>
    <meta name="description" content="<?php echo $description ?? 'Crear nuevo usuario en el sistema'; ?>">
    <link rel="icon" type="image/jpeg" href="<?php echo BASE_URL; ?>public/img/logo.jpeg">
    
    <!-- CSS específico para usuarios -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/usuarios.css">
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<!-- Contenido específico de creación de usuarios -->
<div class="usuarios-content">
    <!-- Header de la página -->
    <div class="section-header">
        <div>
            <h2 class="section-title">Crear Nuevo Usuario</h2>
            <p class="section-subtitle">Agregar un nuevo usuario al sistema</p>
        </div>
        <div class="card-actions">
            <a href="<?php echo BASE_URL; ?>index.php?route=admin/usuarios/usuarios" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Volver a Usuarios
            </a>
        </div>
    </div>

    <!-- Mensajes de error/success -->
    <?php if (!empty($errors)): ?>
        <div class="mensaje-error">
            <i class="fas fa-exclamation-circle"></i>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
        <div class="mensaje-exito">
            <i class="fas fa-check-circle"></i>
            Usuario creado exitosamente
        </div>
    <?php endif; ?>

    <!-- Formulario de creación -->
    <div class="form-section">
        <form method="POST" action="<?php echo BASE_URL; ?>index.php?route=admin/usuarios/crear" id="createUserForm" class="user-form">
            <div class="form-grid">
                <!-- Información Personal -->
                <div class="form-group">
                    <label for="nombre">
                        <i class="fas fa-user"></i>
                        Nombre Completo *
                    </label>
                    <input type="text" id="nombre" name="nombre" class="form-input" 
                           value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" 
                           placeholder="Ingrese el nombre completo" required>
                </div>

                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope"></i>
                        Correo Electrónico *
                    </label>
                    <input type="email" id="email" name="email" class="form-input" 
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" 
                           placeholder="usuario@ejemplo.com" required>
                </div>

                <div class="form-group">
                    <label for="telefono">
                        <i class="fas fa-phone"></i>
                        Teléfono
                    </label>
                    <input type="tel" id="telefono" name="telefono" class="form-input" 
                           value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>" 
                           placeholder="3001234567">
                </div>

                <div class="form-group">
                    <label for="fechadenacimiento">
                        <i class="fas fa-calendar"></i>
                        Fecha de Nacimiento *
                    </label>
                    <input type="date" id="fechadenacimiento" name="fechadenacimiento" class="form-input" 
                           value="<?php echo htmlspecialchars($_POST['fechadenacimiento'] ?? ''); ?>" required>
                </div>

                <!-- Información de Documento -->
                <div class="form-group">
                    <label for="tipodocumento">
                        <i class="fas fa-id-card"></i>
                        Tipo de Documento *
                    </label>
                    <select id="tipodocumento" name="tipodocumento" class="form-select" required>
                        <option value="">Seleccione el tipo</option>
                        <option value="9" <?php echo ($_POST['tipodocumento'] ?? '') == '9' ? 'selected' : ''; ?>>Cédula de Ciudadanía</option>
                        <option value="14" <?php echo ($_POST['tipodocumento'] ?? '') == '14' ? 'selected' : ''; ?>>Cédula de Extranjería</option>
                        <option value="15" <?php echo ($_POST['tipodocumento'] ?? '') == '15' ? 'selected' : ''; ?>>Pasaporte</option>
                        <option value="16" <?php echo ($_POST['tipodocumento'] ?? '') == '16' ? 'selected' : ''; ?>>PPT</option>
                        <option value="17" <?php echo ($_POST['tipodocumento'] ?? '') == '17' ? 'selected' : ''; ?>>PEP</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="numerodocumento">
                        <i class="fas fa-hashtag"></i>
                        Número de Documento *
                    </label>
                    <input type="text" id="numerodocumento" name="numerodocumento" class="form-input" 
                           value="<?php echo htmlspecialchars($_POST['numerodocumento'] ?? ''); ?>" 
                           placeholder="12345678" required>
                </div>

                <!-- Información de Acceso -->
                <div class="form-group">
                    <label for="contrasena">
                        <i class="fas fa-lock"></i>
                        Contraseña *
                    </label>
                    <div class="password-input">
                        <input type="password" id="contrasena" name="contrasena" class="form-input" 
                               placeholder="Mínimo 6 caracteres" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('contrasena')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirmar_contrasena">
                        <i class="fas fa-lock"></i>
                        Confirmar Contraseña *
                    </label>
                    <div class="password-input">
                        <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" class="form-input" 
                               placeholder="Repita la contraseña" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('confirmar_contrasena')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Tipo de Usuario -->
                <div class="form-group">
                    <label for="tipo_usuario">
                        <i class="fas fa-user-tag"></i>
                        Tipo de Usuario *
                    </label>
                    <select id="tipo_usuario" name="tipo_usuario" class="form-select" required>
                        <option value="">Seleccione el tipo</option>
                        <option value="cliente" <?php echo ($_POST['tipo_usuario'] ?? '') == 'cliente' ? 'selected' : ''; ?>>Cliente</option>
                        <option value="propietario" <?php echo ($_POST['tipo_usuario'] ?? '') == 'propietario' ? 'selected' : ''; ?>>Propietario</option>
                        <option value="admin" <?php echo ($_POST['tipo_usuario'] ?? '') == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                    </select>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Crear Usuario
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Función para mostrar/ocultar contraseña
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const button = field.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
</body>
</html>