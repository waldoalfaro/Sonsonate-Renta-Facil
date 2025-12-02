<?php
include '../../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ubicacion = $_POST['ubicacion_dano'] ?? '';
    $tipo = $_POST['tipo_dano'] ?? '';
    $estado = $_POST['estado'] ?? 1;

    // Si seleccionaron "nueva", usamos el valor ingresado
    if ($ubicacion === "nueva" && !empty($_POST['nueva_ubicacion'])) {
        $ubicacion = $_POST['nueva_ubicacion'];
    }

    // Evitar valores vacíos
    if (empty($ubicacion) || empty($tipo)) {
        die("⚠️ Debe completar todos los campos.");
    }

    $stmt = $conn->prepare("INSERT INTO categorias_dano (ubicacion_dano, tipo_dano, estado) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $ubicacion, $tipo, $estado);

    if ($stmt->execute()) {
        // Redirigir de nuevo con mensaje
        header("Location: Danos.php?success=1");
        exit;
    } else {
        echo "❌ Error al insertar: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no válido.";
}
