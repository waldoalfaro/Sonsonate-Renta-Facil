<?php
include '../conexion.php';

$ubicaciones = json_decode($_GET['ubicaciones'], true);
$datos = [];

if($ubicaciones && count($ubicaciones) > 0){
    // Escapar cada valor
    $ubicacionesEscapadas = array_map(function($u) use ($conn){
        return "'" . $conn->real_escape_string($u) . "'";
    }, $ubicaciones);

    $in = implode(",", $ubicacionesEscapadas);

    $res = $conn->query("SELECT ubicacion_dano, tipo_dano FROM categorias_dano WHERE ubicacion_dano IN ($in) ORDER BY tipo_dano");

    while($row = $res->fetch_assoc()){
        $datos[] = $row;
    }
}

echo json_encode($datos);
