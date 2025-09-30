<?php
/**
 * Actualización de usuarios
 * InmuYa - Sistema de gestión inmobiliaria
 */

session_start();

// Verificar si el usuario está logueado y es administrativo
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'administrativo') {
    header("Location: login.php");
    exit();
}

require_once 'conexion.php';

$mensaje = "";
$mensaje_error = "";
$usuario = null;

// Obtener ID del usuario a editar
$id_usuario = $_GET['id'] ?? '';

if (empty($id_usuario)) {
    header("Location: inicio.php");
    exit();
}

// Obtener datos del usuario
try {
    $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$id_usuario]);
    $usuario = $stmt->fetch();
    
    if (!$usuario) {
        header("Location: inicio.php");
        exit();
    }
} catch (PDOException $e) {
    error_log("Error al obtener usuario: " . $e->getMessage());
    header("Location: inicio.php");
    exit();
}

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nombre = sanitizar_entrada($_POST['nombre'] ?? '');
        $email = sanitizar_entrada($_POST['email'] ?? '');
        $telefono = sanitizar_entrada($_POST['telefono'] ?? '');
        $tipodedocumento = $_POST['tipodedocumento'] ?? '';
        $fechadenacimiento = $_POST['fechadenacimiento'] ?? '';
        $contrasena = $_POST['contrasena'] ?? '';
        $tipo_usuario = $_POST['tipo_usuario'] ?? '';

        // Validaciones
        if (empty($nombre) || empty($email) || empty($telefono) || empty($tipodedocumento) || 
            empty($fechadenacimiento) || empty($tipo_usuario)) {
            throw new Exception("Todos los campos son obligatorios.");
        }

        if (!validar_email($email)) {
            throw new Exception("El formato del email no es válido.");
        }

        if (!validar_telefono($telefono)) {
            throw new Exception("El formato del teléfono no es válido.");
        }

        if (strlen($nombre) < 2 || strlen($nombre) > 100) {
            throw new Exception("El nombre debe tener entre 2 y 100 caracteres.");
        }

        // Verificar si el email ya existe en otro usuario
        $sql_check = "SELECT id_usuario FROM usuarios WHERE email = ? AND id_usuario != ?";
        $stmt_check = $conexion->prepare($sql_check);
        $stmt_check->execute([$email, $id_usuario]);
        
        if ($stmt_check->fetch()) {
            throw new Exception("Ya existe un usuario con ese email.");
        }

        // Preparar consulta de actualización
        if (!empty($contrasena)) {
            if (strlen($contrasena) < 8) {
                throw new Exception("La contraseña debe tener al menos 8 caracteres.");
            }
            $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET nombre=?, email=?, telefono=?, tipodedocumento=?, 
                    fechadenacimiento=?, contrasena=?, tipo_usuario=?, fecha_actualizacion=NOW() 
                    WHERE id_usuario=?";
            $params = [$nombre, $email, $telefono, $tipodedocumento, $fechadenacimiento, $contrasena_hash, $tipo_usuario, $id_usuario];
        } else {
            $sql = "UPDATE usuarios SET nombre=?, email=?, telefono=?, tipodedocumento=?, 
                    fechadenacimiento=?, tipo_usuario=?, fecha_actualizacion=NOW() 
                    WHERE id_usuario=?";
            $params = [$nombre, $email, $telefono, $tipodedocumento, $fechadenacimiento, $tipo_usuario, $id_usuario];
        }

        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta.");
        }

        $resultado = $stmt->execute($params);

        if ($resultado) {
            $mensaje = "Usuario actualizado correctamente.";
            // Recargar datos del usuario actualizado
            $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([$id_usuario]);
            $usuario = $stmt->fetch();
        } else {
            throw new Exception("Error al actualizar el usuario.");
        }

    } catch (Exception $e) {
        $mensaje_error = $e->getMessage();
        error_log("Error en update.php: " . $e->getMessage());
    } catch (PDOException $e) {
        $mensaje_error = "Error de base de datos. Por favor, inténtelo más tarde.";
        error_log("Error PDO en update.php: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/update.css">
    <title>Editar Usuario - InmuYa</title>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Editar Usuario</h1>
            <a href="inicio.php" class="btn">Volver al Panel</a>
        </div>

        <?php if (!empty($mensaje)): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($mensaje_error)): ?>
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                <?php echo htmlspecialchars($mensaje_error); ?>
            </div>
        <?php endif; ?>

        <?php if ($usuario): ?>
        <section class="update">
            <form action="update.php?id=<?php echo $usuario['id_usuario']; ?>" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre completo *</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico *</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono *</label>
                    <input type="text" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="tipodedocumento">Tipo de documento *</label>
                    <select name="tipodedocumento" required>
                        <option value="">Selecciona tu tipo de documento</option>
                        <option value="cedula" <?php echo $usuario['tipodedocumento'] === 'cedula' ? 'selected' : ''; ?>>Cédula de ciudadanía</option>
                        <option value="extranjeria" <?php echo $usuario['tipodedocumento'] === 'extranjeria' ? 'selected' : ''; ?>>Cédula de extranjería</option>
                        <option value="pasaporte" <?php echo $usuario['tipodedocumento'] === 'pasaporte' ? 'selected' : ''; ?>>Pasaporte</option>
                        <option value="ppt" <?php echo $usuario['tipodedocumento'] === 'ppt' ? 'selected' : ''; ?>>PPT</option>
                        <option value="pep" <?php echo $usuario['tipodedocumento'] === 'pep' ? 'selected' : ''; ?>>PEP</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="fechadenacimiento">Fecha de Nacimiento *</label>
                    <input type="date" name="fechadenacimiento" value="<?php echo $usuario['fechadenacimiento']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="identificacion">N° de identificación</label>
                    <input type="text" name="identificacion" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>" readonly>
                    <small>La identificación no se puede modificar</small>
                </div>

                <div class="form-group">
                    <label for="contrasena">Nueva contraseña</label>
                    <input type="password" name="contrasena" placeholder="Dejar vacío para mantener la actual">
                    <small>Dejar vacío si no deseas cambiar la contraseña</small>
                </div>

                <div class="form-group">
                    <label for="tipodeusuario">Tipo de usuario *</label>
                    <select name="tipodeusuario" required>
                        <option value="">Selecciona tu tipo de usuario</option>
                        <option value="propietario" <?php echo $usuario['tipo_usuario'] === 'propietario' ? 'selected' : ''; ?>>Propietario</option>
                        <option value="cliente" <?php echo $usuario['tipo_usuario'] === 'cliente' ? 'selected' : ''; ?>>Cliente</option>
                        <option value="administrativo" <?php echo $usuario['tipo_usuario'] === 'administrativo' ? 'selected' : ''; ?>>Administrativo</option>
                    </select>
                </div>

                <div class="boton-container">
                    <button type="submit" class="btn btn-success">Actualizar Usuario</button>
                    <a href="inicio.php" class="btn">Cancelar</a>
                </div>
            </form>
        </section>
        <?php else: ?>
            <div style="text-align: center; padding: 20px;">
                <p>Usuario no encontrado.</p>
                <a href="inicio.php" class="btn">Volver al Panel</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
