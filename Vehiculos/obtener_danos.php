<?php
include '../conexion.php';
$idVehiculo = intval($_GET['id_vehiculo']);
$datos = [];

$result = $conn->query("SELECT ubicacion_dano, tipo_dano FROM vehiculos_danos WHERE id_vehiculo = $idVehiculo");
while($row = $result->fetch_assoc()){
    $datos[] = $row;
}

echo json_encode($datos);
