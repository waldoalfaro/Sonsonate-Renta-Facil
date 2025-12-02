<?php

include "../../conexion.php";

if (isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM categorias_dano WHERE id_categoria_dano = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id); 
        $stmt->execute();
        $stmt->close();
    }

    // Redirigir a la lista de usuarios
    header('Location: Danos.php?eliminado=1');
    exit();

}

?>