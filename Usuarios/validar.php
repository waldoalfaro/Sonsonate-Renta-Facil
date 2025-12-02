<?php
include "../conexion.php";


$sql = "SELECT * FROM tipos_usuario";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT); 
    $correo = $_POST['correo'];
    $tipo_id = $_POST['id_tipo'];

   
    $sql_insert = "INSERT INTO usuarios (nombre, usuario, clave, correo, id_tipo) VALUES ('$nombre', '$usuario', '$clave', '$correo', $tipo_id)";
    
    if ($conn->query($sql_insert) === TRUE) {
        header("Location: Usuarios.php");
        exit;
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}



?>