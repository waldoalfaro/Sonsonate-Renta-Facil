<?php
include '../conexion.php';

$idcategoria = $_POST['id_categoria'];
$marca       = $_POST['marca'];
$modelo      = $_POST['modelo'];
$color       = $_POST['color'];
$placa       = $_POST['placa'];
$año         = $_POST['anio'];
$asientos    = $_POST['asientos'];
$aire        = $_POST['aire'];
$estado      = $_POST['estado'];
$precio      = $_POST['precio_dia'];
$combustible = $_POST['combustible'];   
$gps         = $_POST['gps'];
$seguro      = $_POST['seguro'];
$vin         = $_POST['vin'];

$ubicaciones = $_POST['ubicacion_dano'] ?? [];
$tipos       = $_POST['tipo_dano'] ?? [];

$revisar = $conn->query("SELECT id_vehiculo FROM vehiculos WHERE placa = '$placa'");
if ($revisar->num_rows > 0) {
    header("Location: vehiculos.php?duplicado=1&placa=" . urlencode($placa));
    exit;
}

// 🔹 Crear carpeta si no existe
$carpeta = "../FotosSubidas/";
if (!is_dir($carpeta)) {
    mkdir($carpeta, 0777, true);
}

// ---------------------- FOTO PRINCIPAL ----------------------
$fotoPrincipalNombre = null;
if (isset($_FILES['foto_principal']) && $_FILES['foto_principal']['error'] === UPLOAD_ERR_OK) {
    $nombrePrincipal = uniqid() . "_" . basename($_FILES['foto_principal']['name']);
    $rutaPrincipal = $carpeta . $nombrePrincipal;
    if (move_uploaded_file($_FILES['foto_principal']['tmp_name'], $rutaPrincipal)) {
        $fotoPrincipalNombre = $nombrePrincipal;
    }
}

// ---------------------- GALERÍA ----------------------
$fotosGaleria = [];
if (!empty($_FILES['galeria']['name'][0])) {
    for ($i = 0; $i < count($_FILES['galeria']['name']); $i++) {
        if ($_FILES['galeria']['error'][$i] === UPLOAD_ERR_OK) {
            $nombreFoto = uniqid() . "_" . basename($_FILES['galeria']['name'][$i]);
            $rutaTemp = $_FILES['galeria']['tmp_name'][$i];
            $destino = $carpeta . $nombreFoto;
            if (move_uploaded_file($rutaTemp, $destino)) {
                $fotosGaleria[] = $nombreFoto;
            }
        }
    }
}

// ---------------------- INSERTAR VEHÍCULO ----------------------
$sql_insert = "INSERT INTO vehiculos 
(id_categoria, marca, modelo, color, placa, anio, asientos, aire_acondicionado, foto, estado, precio_dia, combustible, gps, seguro, vin)
VALUES 
('$idcategoria', '$marca', '$modelo', '$color', '$placa', '$año', '$asientos', '$aire', '$fotoPrincipalNombre', '$estado', '$precio', '$combustible', '$gps', '$seguro', '$vin')";

if ($conn->query($sql_insert) === TRUE) {
    $idVehiculo = $conn->insert_id;

    // 🔹 Guardar fotos adicionales en vehiculos_fotos
    foreach ($fotosGaleria as $foto) {
        $conn->query("INSERT INTO vehiculos_fotos (id_vehiculo, foto) VALUES ('$idVehiculo', '$foto')");
    }

    // 🔹 Guardar daños si existen
    if (!empty($ubicaciones) && !empty($tipos)) {
        $count = min(count($ubicaciones), count($tipos));
        for ($i = 0; $i < $count; $i++) {
            $ubi  = $conn->real_escape_string($ubicaciones[$i]);
            $tipo = $conn->real_escape_string($tipos[$i]);
            $conn->query("INSERT INTO vehiculos_danos (id_vehiculo, ubicacion_dano, tipo_dano) 
                          VALUES ('$idVehiculo', '$ubi', '$tipo')");
        }
    }

   header("Location: vehiculos.php?registrado=1");
exit;
}
?>
