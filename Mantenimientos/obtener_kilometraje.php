<?php
include '../conexion.php';

if (isset($_GET['id_mantenimiento'])) {
    $id = $_GET['id_mantenimiento'];

    $sql = "SELECT id_vehiculo, proximo_cambio_km FROM mantenimientos WHERE id_mantenimiento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($id_vehiculo, $proximo_cambio_km);
    $stmt->fetch();

    echo json_encode([
        'id_vehiculo' => $id_vehiculo,
        'proximo_cambio_km' => $proximo_cambio_km
    ]);
}
?>
