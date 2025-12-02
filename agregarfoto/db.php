<?php
$host = "localhost";
$user = "root"; 
$pass = "";
$db   = "sistema_renta_facil"; // cambia al nombre de tu BD

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

