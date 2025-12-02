<?php
include 'conexion.php';

$sql = "SELECT id, mensaje, leida, DATE_FORMAT(fecha, '%d/%m %H:%i') AS fecha 
        FROM notificaciones ORDER BY fecha DESC LIMIT 10";
$result = $conn->query($sql);

$notificaciones = [];
while ($row = $result->fetch_assoc()) {
  $notificaciones[] = $row;
}

echo json_encode($notificaciones);
?>
