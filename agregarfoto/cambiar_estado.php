<?php
include("db.php");

header('Content-Type: application/json');

if (isset($_POST['id']) && isset($_POST['estado'])) {
    $id = intval($_POST['id']);
    $estado = intval($_POST['estado']);
    
    // Validar que el estado sea 0 o 1
    if ($estado === 0 || $estado === 1) {
        $sql = "UPDATE carros SET disponible = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $estado, $id);
        
        if ($stmt->execute()) {
            $textoEstado = $estado ? 'disponible' : 'alquilado';
            echo json_encode(['success' => true, 'mensaje' => "Estado cambiado a $textoEstado"]);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al cambiar el estado']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'mensaje' => 'Estado inválido']);
    }
} else {
    echo json_encode(['success' => false, 'mensaje' => 'Datos incompletos']);
}

$conn->close();
?>