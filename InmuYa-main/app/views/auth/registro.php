<?php
/**
 * Vista de Registro
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Esta vista muestra el formulario de registro
 * usando el layout base para otras páginas
 */

// Definir variables para el layout
$title = 'Registrarse - InmuYa';
$description = 'Crea tu cuenta en InmuYa y comienza a buscar tu hogar ideal';

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
    <!-- Contenido específico de la página de registro -->
    <section class="registro">
        <div class="registro-container">
            <h2>Regístrate</h2>
            <p style="text-align: center; color: var(--color-gris); margin-bottom: 2rem;">
                Crea tu cuenta y comienza a buscar tu hogar ideal
            </p>

            <?php if (!empty($mensaje)): ?>
                <div class="mensaje-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?php echo BASE_URL; ?>index.php?route=auth/process-registro">
                <!-- Información personal -->
                <div class="grupo-formulario">
                    <label for="nombre">Nombre completo *</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Ingresa tu nombre completo">
                </div>

                <div class="grupo-formulario">
                    <label for="email">Correo electrónico *</label>
                    <input type="email" id="email" name="email" required placeholder="tu.correo@ejemplo.com">
                </div>

                <div class="grupo-formulario">
                    <label for="telefono">Teléfono *</label>
                    <input type="tel" id="telefono" name="telefono" required placeholder="300 123 4567">
                </div>

                <!-- Documento de identidad -->
                <div class="grid-dos-columnas">
                    <div class="grupo-formulario">
                        <label for="tipodedocumento">Tipo de documento *</label>
                        <select id="tipodedocumento" name="tipodedocumento" required>
                            <option value="">Selecciona tu tipo</option>
                            <option value="cedula">Cédula de ciudadanía</option>
                            <option value="extranjeria">Cédula de extranjería</option>
                            <option value="pasaporte">Pasaporte</option>
                            <option value="ppt">PPT</option>
                            <option value="pep">PEP</option>
                        </select>
                    </div>

                    <div class="grupo-formulario">
                        <label for="identificacion">N° de identificación *</label>
                        <input type="text" id="identificacion" name="identificacion" required placeholder="12345678">
                    </div>
                </div>

                <div class="grupo-formulario">
                    <label for="fechadenacimiento">Fecha de nacimiento *</label>
                    <input type="date" id="fechadenacimiento" name="fechadenacimiento" required>
                </div>

                <!-- Contraseñas -->
                <div class="grid-dos-columnas">
                    <div class="grupo-formulario">
                        <label for="contrasena">Contraseña *</label>
                        <input type="password" id="contrasena" name="contrasena" required placeholder="Mínimo 6 caracteres">
                    </div>

                    <div class="grupo-formulario">
                        <label for="contrasenaverificar">Verificar contraseña *</label>
                        <input type="password" id="contrasenaverificar" name="contrasenaverificar" required placeholder="Repite tu contraseña">
                    </div>
                </div>

                <!-- Tipo de usuario -->
                <div class="grupo-formulario">
                    <label for="tipodeusuario">Tipo de usuario *</label>
                    <select id="tipodeusuario" name="tipodeusuario" required>
                        <option value="">Selecciona tu tipo de usuario</option>
                        <option value="propietario">Propietario - Tengo propiedades para arrendar o vender</option>
                        <option value="cliente">Cliente - Busco propiedades para arrendar o vender</option>
                       
                    </select>
                </div>

                <div class="boton-container">
                    <button type="submit">
                        <i class="fas fa-user-plus"></i>
                        Crear Cuenta
                    </button>
                </div>
            </form>

            <div class="enlaces-navegacion">
                <a href="<?php echo BASE_URL; ?>index.php?route=auth/login">
                    <i class="fas fa-sign-in-alt"></i>
                    ¿Ya tienes cuenta? Inicia sesión
                </a>
                <a href="<?php echo BASE_URL; ?>">
                    <i class="fas fa-home"></i>
                    Volver al inicio
                </a>
            </div>
        </div>
    </section>
</body>
</html>