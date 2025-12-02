<?php
include '../conexion.php';

$id = $_POST['id'];
$estado = $_POST['estado'];

$stmt = $conn->prepare("UPDATE vehiculos SET estado = ? WHERE id_vehiculo = ?");
$stmt->bind_param("si", $estado, $id);
$stmt->execute();
$stmt->close();
?>
