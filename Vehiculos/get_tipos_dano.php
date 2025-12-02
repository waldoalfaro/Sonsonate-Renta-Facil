<?php
include '../conexion.php';

$ubicacion = $_GET['ubicacion'] ?? '';
$tipos = [];

if($ubicacion){
    $stmt = $conn->prepare("SELECT tipo_dano FROM categorias_dano WHERE ubicacion_dano = ? ORDER BY tipo_dano");
    $stmt->bind_param("s", $ubicacion);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        $tipos[] = $row['tipo_dano'];
    }
}
echo json_encode($tipos);
