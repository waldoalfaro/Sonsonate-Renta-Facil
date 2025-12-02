<?php
include "../conexion.php";

$id = $_GET['id'];

// obtener foto
$stmt = $conn->prepare("SELECT foto FROM vehiculos_fotos WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

if ($res) {
    unlink("../FotosSubidas/" . $res['foto']);
}

// eliminar registro
$stmt2 = $conn->prepare("DELETE FROM vehiculos_fotos WHERE id=?");
$stmt2->bind_param("i", $id);
$stmt2->execute();

echo "ok";
?>
