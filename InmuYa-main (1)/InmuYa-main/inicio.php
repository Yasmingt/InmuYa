<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio sección</title>
</head>
<body>
     <center><h1>Hola, bienvenid@!</h1></center>
<?php
require_once 'conexion.php';
$result= $conexion->query("SELECT * FROM usuarios");
?>
<h2>Usuarios registrados</h2>
<a href="form_insert.php">Nuevo usuario</a> |
<a href="../index.php">Panel</a>
<table border="1">
<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Telefono</th><th>Tipo de documento</th>
<th>Fecha de nacimiento</th><th>Contraseña</th><th>Tipo de usuario</th>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?php echo $row['id_usuario']; ?></td>
    <td><?php echo $row['nombre']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['telefono']; ?></td>
    <td><?php echo $row['tipodedocumento']; ?></td>
    <td><?php echo $row['fechadenacimiento']; ?></td>
    <td><?php echo $row['contrasena']; ?></td>
    <td><?php echo $row['tipo_usuario']; ?></td>
    <td>
        <a href="update.php">Editar</a>
        <a href="delete.php?id=<?php echo $row['id_usuario']; ?>">Eliminar</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>