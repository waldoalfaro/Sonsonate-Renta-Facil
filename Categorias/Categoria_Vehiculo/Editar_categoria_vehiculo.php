<?php 

include "../../conexion.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idcategoria = $_POST['id_categoria']; 
    $nombre_categoria = $_POST['nombre_categoria'];
    $descripcion = $_POST['descripcion'];



    if ($conn) {
        $sql = "UPDATE categorias SET nombre_categoria = ?, descripcion = ? WHERE id_categoria = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ssi", $nombre_categoria, $descripcion, $idcategoria);


        if ($stmt->execute()) {
            header('Location: categorias_vehiculos.php');
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