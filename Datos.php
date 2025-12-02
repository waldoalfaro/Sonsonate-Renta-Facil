<?php
include 'conexion.php';

// Consulta: contar reservaciones por estado
$sql = "SELECT estado, COUNT(*) as total FROM reservaciones GROUP BY estado";
$result = $conn->query($sql);

$labels = [];
$data = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = ucfirst($row['estado']);
    $data[] = (int)$row['total'];
}

echo json_encode([
    'labels' => $labels,
    'data' => $data
]);
?>
