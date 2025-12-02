<?php
include "../../conexion.php";




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_categoria = $_POST['nombre_categoria'];
    $descripcion = $_POST['descripcion'];

   
    $sql_insert = "INSERT INTO categorias (nombre_categoria, descripcion) VALUES ('$nombre_categoria', '$descripcion')";
    
    if ($conn->query($sql_insert) === TRUE) {
        header("Location: categorias_vehiculos.php");
        exit;
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}



?>