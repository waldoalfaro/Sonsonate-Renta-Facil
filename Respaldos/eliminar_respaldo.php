<?php
$file = $_GET['file'];
$ruta = "respaldos/" . $file;

if (file_exists($ruta)) {
    unlink($ruta);
}

header("Location: index_respaldo.php");
?>
