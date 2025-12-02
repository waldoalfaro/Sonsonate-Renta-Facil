<?php
header('Content-Type: application/json');
require_once "../conexion.php";

if (!isset($_GET['id_reservacion'])) {
  echo json_encode(["error" => "Falta el parámetro id_reservacion"]);
  exit;
}

$id_reservacion = intval($_GET['id_reservacion']);

// 🔹 1. Obtenemos los datos de la reservación
$sql_res = "SELECT id_vehiculo, fecha_inicio_solicitada, fecha_fin_solicitada 
            FROM reservaciones 
            WHERE id_reservacion = ?";
$stmt_res = $conn->prepare($sql_res);
$stmt_res->bind_param("i", $id_reservacion);
$stmt_res->execute();
$res = $stmt_res->get_result();

if ($res->num_rows === 0) {
  echo json_encode(["error" => "Reservación no encontrada"]);
  exit;
}

$datos = $res->fetch_assoc();
$id_vehiculo = $datos['id_vehiculo'];
$inicio = $datos['fecha_inicio_solicitada'];
$fin = $datos['fecha_fin_solicitada'];

// 🔹 2. Verificamos si ya existe un contrato ACTIVO para el mismo vehículo y fechas que se crucen
$sql_check = "SELECT id_contrato, estado 
              FROM contratos 
              WHERE id_vehiculo = ?
              AND (
                (fecha_inicio <= ? AND fecha_fin >= ?) OR
                (fecha_inicio <= ? AND fecha_fin >= ?) OR
                (? BETWEEN fecha_inicio AND fecha_fin) OR
                (? BETWEEN fecha_inicio AND fecha_fin)
              )";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("issssss", $id_vehiculo, $fin, $inicio, $inicio, $fin, $inicio, $fin);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
  $contrato = $result->fetch_assoc();
  echo json_encode([
    "existe" => true,
    "estado" => $contrato['estado']
  ]);
} else {
  echo json_encode(["existe" => false]);
}
