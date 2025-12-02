<?php
session_start();
require '../conexion.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id_usuario = $_POST['id_usuario'];
    $token = $_POST['token'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE usuarios SET clave = ?, token_recuperacion = NULL, expira_token = NULL WHERE id_usuario = ? AND token_recuperacion = ?");
    $stmt->bind_param("sis", $clave, $id_usuario, $token);
    if($stmt->execute()){
        $_SESSION['recuperar_exito'] = "Contraseña restablecida correctamente. Ahora puedes iniciar sesión.";
        header("Location: /Sistema-Renta-Facil/Login.php");
        exit;
    } else {
        die("Error al actualizar la contraseña.");
    }
}
?>
