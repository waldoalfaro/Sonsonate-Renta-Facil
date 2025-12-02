<?php
include("db.php");

header('Content-Type: application/json');

if ($_POST['id'] && $_POST['precio']) {
    $id = intval($_POST['id']);
    $precio = floatval($_POST['precio']);
    
    // Validar que el precio sea positivo
    if ($precio > 0) {
        $sql = "UPDATE carros SET precio_alquiler = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $precio, $id);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'mensaje' => 'Precio actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'Error al actualizar el precio']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'mensaje' => 'Precio inválido']);
    }
} else {
    echo json_encode(['success' => false, 'mensaje' => 'Datos incompletos']);
}

$conn->close();
?>