<?php
require '../conexion.php';
header('Content-Type: application/json');

if (!isset($_POST['id_contrato'], $_POST['estado'])) {
  echo json_encode(['ok' => false, 'msg' => 'Datos incompletos']);
  exit;
}

$id_contrato = intval($_POST['id_contrato']);
$estado = $_POST['estado'];

$permitidos = ['Activo', 'Finalizado', 'Cancelado'];
if (!in_array($estado, $permitidos)) {
  echo json_encode(['ok' => false, 'msg' => 'Estado inválido']);
  exit;
}

$sql = "UPDATE contratos SET estado = ? WHERE id_contrato = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $estado, $id_contrato);
$ok = $stmt->execute();

echo json_encode(['ok' => $ok]);
