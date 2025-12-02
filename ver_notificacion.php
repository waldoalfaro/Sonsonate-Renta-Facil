<?php
include 'conexion.php';
header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "ID no proporcionado."]);
    exit;
}
$id = intval($_GET['id']);

$conn->query("UPDATE notificaciones SET leida = 1 WHERE id = $id");

$res = $conn->query("SELECT id_reservacion FROM notificaciones WHERE id = $id LIMIT 1");
$row = $res ? $res->fetch_assoc() : null;


$id_reserva = intval($row['id_reservacion']);



$sql = "SELECT r.*, v.modelo, v.marca 
        FROM reservaciones r 
        INNER JOIN vehiculos v ON r.id_vehiculo = v.id_vehiculo
        WHERE id_reservacion = $id_reserva LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $reserva = $result->fetch_assoc();
    echo json_encode(["status" => "ok", "data" => $reserva]);
}
?> 

