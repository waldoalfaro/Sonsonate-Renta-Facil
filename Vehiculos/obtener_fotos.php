<?php
include "../conexion.php";

$id = $_GET['id_vehiculo'];

$sql = $conn->prepare("SELECT id, foto FROM vehiculos_fotos WHERE id_vehiculo=?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();

$fotos = [];

while ($row = $result->fetch_assoc()) {
    $fotos[] = $row;
}

echo json_encode($fotos);
?>
