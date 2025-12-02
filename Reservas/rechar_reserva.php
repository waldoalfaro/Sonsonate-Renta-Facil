<?php 

include '../conexion.php';
 
$id_reservacion = $_GET['id'] ?? null ;
if ($id_reservacion){
    $sql = "UPDATE reservaciones SET estado='rechazada' WHERE id_reservacion = $id_reservacion";
    if ($conn->query($sql) === TRUE){
        header("location: Reservas.php");
        exit;
    }else {
        echo "error: " . $conn->error;
    }
}

?>