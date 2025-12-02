<?php
include "../conexion.php";

$archivo = $_FILES['archivo'];

if ($archivo['type'] != "application/zip") {
    die("Archivo no válido.");
}

$destino = "uploads/" . $archivo['name'];
move_uploaded_file($archivo['tmp_name'], $destino);

$zip = new ZipArchive;

if ($zip->open($destino) === TRUE) {
    $zip->extractTo("../"); 
    $zip->close();
}

unlink($destino);

header("Location: index_respaldo.php");
?>
