<?php 
include "../conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idvehiculo   = $_POST['id_vehiculo']; 
    $marca        = $_POST['marca'];
    $modelo       = $_POST['modelo'];
    $color        = $_POST['color'];
    $placa        = $_POST['placa'];
    $anio         = $_POST['anio'];
    $asientos     = $_POST['asientos'];
    $foto_actual  = $_POST['foto_actual']; 

    $precio_dia   = $_POST['precio_dia'];
    $combustible  = $_POST['combustible'];
    $gps          = $_POST['gps'];
    $seguro       = $_POST['seguro'];
    $vin          = $_POST['vin'];

    
    // Manejo de la foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $nombreFoto = uniqid() . "_" . $_FILES['foto']['name'];
        $rutaTemp   = $_FILES['foto']['tmp_name'];
        move_uploaded_file($rutaTemp, "../FotosSubidas/" . $nombreFoto);
        $foto = $nombreFoto;
    } else {
        $foto = $foto_actual;
    }

    // 1️⃣ Actualizar datos del vehículo
    if($conn){
        $sql = "UPDATE vehiculos 
                   SET marca=?, modelo=?, color=?, placa=?, anio=?, asientos=?, foto=?, 
                       precio_dia=?, combustible=?, gps=?, seguro=?, vin=? 
                 WHERE id_vehiculo=?"; 

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssiisssssii", 
            $marca, $modelo, $color, $placa, $anio, $asientos, $foto, 
            $precio_dia, $combustible, $gps, $seguro, $vin, $idvehiculo
        );
        $stmt->execute();
        $stmt->close();

        // Subir nuevas fotos adicionales
if (!empty($_FILES['fotos_extra']['name'][0])) {
    foreach ($_FILES['fotos_extra']['name'] as $i => $nombre) {
        $nuevoNombre = uniqid() . "_" . $nombre;
        move_uploaded_file($_FILES['fotos_extra']['tmp_name'][$i], "../FotosSubidas/" . $nuevoNombre);

        $stmtFoto = $conn->prepare("INSERT INTO fotos (id_vehiculo, foto) VALUES (?, ?)");
        $stmtFoto->bind_param("is", $idvehiculo, $nuevoNombre);
        $stmtFoto->execute();
    }
}

        header('Location: vehiculos.php?msg=editado'); 
        exit(); 
    } else {
        echo "❌ Error en la conexión a la base de datos.";
    }
}
?>
