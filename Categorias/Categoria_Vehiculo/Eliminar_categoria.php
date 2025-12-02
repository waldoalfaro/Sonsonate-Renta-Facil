<?php
include "../../conexion.php";

if (isset($_GET['id_cate'])) {
    $id = $_GET['id_cate'];

    // Verificar si hay vehículos asociados a la categoría
    $sqlCheck = "SELECT COUNT(*) AS total FROM vehiculos WHERE id_categoria = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("i", $id);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result()->fetch_assoc();
    $stmtCheck->close();

    if ($result['total'] > 0) {
        // Si tiene vehículos asociados, no eliminar
        echo json_encode([
            "status" => "error",
            "message" => "No se puede eliminar. Esta categoría tiene vehículos asignados."
        ]);
        exit;
    }

    // Si no tiene vehículos asociados → eliminar
    $sql = "DELETE FROM categorias WHERE id_categoria = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "Categoría eliminada correctamente."
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Error al eliminar la categoría: " . $conn->error
            ]);
        }
        $stmt->close();
    }
}
