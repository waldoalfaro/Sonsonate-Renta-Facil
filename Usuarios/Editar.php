<?php 

include "../conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idusuario = $_POST['id_usuario']; 
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $id_tipo = $_POST['id_tipo'];



    if ($conn) {
        $sql = "UPDATE usuarios SET nombre = ?, usuario = ?, correo = ?, id_tipo = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("sssii", $nombre, $usuario, $correo, $id_tipo, $idusuario);


        if ($stmt->execute()) {
            header('Location: Usuarios.php'); // tu listado de usuarios
            exit(); 
        } else {
            echo "❌ Error al actualizar el usuario: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "❌ Error en la conexión a la base de datos.";
    }
}
?>


