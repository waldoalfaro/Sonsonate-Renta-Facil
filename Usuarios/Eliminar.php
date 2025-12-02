<?php
session_start(); 
include "../conexion.php";

if (isset($_GET['id_usu'])) {
    $id = $_GET['id_usu'];
    $usuarioActual = $_SESSION['id_usuario'];

    // Evitar que se elimine a sí mismo
    if ($id == $usuarioActual) {
        header('Location: Usuarios.php?error=1');
        exit;
    }

    $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header('Location: Usuarios.php?eliminado=1');
        } else {
            header('Location: Usuarios.php?error=2');
        }
        $stmt->close();
        exit;
    }
}
?>