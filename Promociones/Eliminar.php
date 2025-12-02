<?php
include '../conexion.php'; // Ajusta la ruta según tu estructura
header('Content-Type: application/json');

if (!isset($_GET['id_promocion'])) {
    echo json_encode(['success' => false, 'error' => 'ID no especificado']);
    exit;
}

$id = intval($_GET['id_promocion']);

// 🔹 Buscar imagen para eliminar del servidor
$consulta = $conn->query("SELECT imagen FROM promociones WHERE id_promocion = $id");
if ($consulta && $fila = $consulta->fetch_assoc()) {
    $ruta = "../uploads/configuracion/" . $fila['imagen'];
    if (file_exists($ruta)) {
        unlink($ruta); // Eliminar archivo físico
    }
}

// 🔹 Eliminar registro de la base de datos
$sql = "DELETE FROM promociones WHERE id_promocion = $id";
if ($conn->query($sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
?>
