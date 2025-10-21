<?php
/**
 * Vista de Recuperación de Contraseña
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Esta vista muestra el formulario para recuperar la contraseña
 */

// Definir variables para el layout
$title = 'Recuperar Contraseña - InmuYa';
$description = 'Recupera tu contraseña de InmuYa';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'InmuYa'; ?></title>
    <meta name="description" content="<?php echo $description ?? 'Plataforma inmobiliaria'; ?>">
    <link rel="icon" type="image/jpeg" href="<?php echo BASE_URL; ?>public/img/logo.jpeg">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/recoverAndRegistration.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Contenido específico de la página de recuperación de contraseña -->
    <section class="recuperar-contrasena">
        <div class="contenedor">
            <h2>Recuperar Contraseña</h2>
            <p>Ingresa tu correo electrónico y tu nueva contraseña para actualizarla directamente.</p>

            <?php if (isset($error)): ?>
                <div class="mensaje-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                <div class="mensaje-exito">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo BASE_URL; ?>auth/procesar-recuperar" method="post">
                <div class="grupo-formulario">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="tu.correo@ejemplo.com" required>
                </div>
                
                <div class="grupo-formulario">
                    <label for="new_password">Nueva Contraseña</label>
                    <input type="password" id="new_password" name="new_password" placeholder="Mínimo 8 caracteres" required>
                </div>
                
                <div class="grupo-formulario">
                    <label for="confirm_password">Confirmar Nueva Contraseña</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Repite tu nueva contraseña" required>
                </div>
                
                <button type="submit" class="boton-enviar">
                    <i class="fas fa-key"></i> Actualizar Contraseña
                </button>
            </form>

            <p class="enlace-volver">
                <a href="<?php echo BASE_URL; ?>index.php?route=auth/login">Volver al inicio de sesión</a>
            </p>
        </div>
    </section>
</body>
</html>