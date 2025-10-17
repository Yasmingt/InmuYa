<?php
/**
 * Vista de Login
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Esta vista muestra el formulario de inicio de sesión
 */

// Definir variables para el layout
$title = 'Iniciar Sesión - InmuYa';
$description = 'Inicia sesión en tu cuenta de InmuYa';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Iniciar Sesión - InmuYa'; ?></title>
    <meta name="description" content="<?php echo $description ?? 'Inicia sesión en tu cuenta de InmuYa'; ?>">
    <link rel="icon" type="image/jpeg" href="<?php echo BASE_URL; ?>public/img/logo.jpeg">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/login.css">
    <script src="https://kit.fontawesome.com/bf528d3bda.js" crossorigin="anonymous"></script>
</head>
<body>
   <!-- Contenido específico de la página de login -->
    <div class="contenedor-login">
        <!-- Lado izquierdo - Imagen -->
        <div class="login-imagen">
            <a href="<?php echo BASE_URL; ?>" class="boton-regresar">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        
        <!-- Lado derecho - Formulario -->
        <div class="modal-contenido">
            <div class="contenido-tab activo" id="tabUsuario">
                <img src="<?php echo BASE_URL; ?>public/img/logo.jpeg" alt="Logo InmuYa" class="logo-login">
                <h3>Iniciar Sesión</h3>
                
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
            
            <form action="<?php echo BASE_URL; ?>index.php?route=auth/procesar-login" method="post">
                <div class="grupo-formulario">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="Ingresa tu correo electrónico" required autocomplete="email">
                </div>
                    
                <div class="grupo-formulario">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required autocomplete="current-password">
                </div>
                    
                <button type="submit" class="boton-enviar">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </button>
            </form>

                <div class="enlaces-login">
                    <a href="<?php echo BASE_URL; ?>index.php?route=auth/recoverPassword">
                        <i class="fas fa-key"></i> ¿Olvidaste tu contraseña?
                    </a>
                    
                    <a href="<?php echo BASE_URL; ?>index.php?route=auth/registration">
                        <i class="fas fa-user-plus"></i> ¿No tienes cuenta? Regístrate aquí
                    </a>
                </div>
        </div>
    </div>
</body>
</html>

