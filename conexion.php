<?php
$conn = new mysqli("localhost", "root", "", "Sistema_Renta_Facil_original");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
