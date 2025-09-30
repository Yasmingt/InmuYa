<?php
require_once 'conexion.php';
$id = $_GET['id_usuario'];

$stmt = $conexion->prepare("DELETE FROM usuarios WHERE id_usuario=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: inicio.php");
?>