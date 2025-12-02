<?php
include 'conexion.php';

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $conn->query("UPDATE notificaciones SET leida = 1 WHERE id = $id");
  echo "ok";
}
?>
