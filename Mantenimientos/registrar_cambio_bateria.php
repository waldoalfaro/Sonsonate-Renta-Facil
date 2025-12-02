<?php
include '../conexion.php';
include '../seguridad.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $id_cambio_bateria = (int) $_POST['id_cambio_bateria'];
    $id_vehiculo = (int) $_POST['id_vehiculo'];
    $fecha = $_POST['Fecha_bateria'];
    $marca = $_POST['marca_bateria'];
    $modelo = $_POST['modelo_bateria'];
    $voltaje = $_POST['voltaje_vateria'];
    $garantia = (int) $_POST['garantia_bateria'];
    $costo = (float) $_POST['costo_bateria'];
    $realizado_por = $_POST['realizado_por_bateria'];
    $telefono = $_POST['telefono_bateria'];
    $observaciones = $_POST['observaciones_bateria'];

    // Preparar la consulta
    $sql = "UPDATE cambio_bateria 
            SET fecha = ?, 
                marca_bateria = ?, 
                modelo_bateria = ?, 
                voltaje = ?, 
                garantia_meses = ?, 
                costo = ?, 
                realizado_por = ?, 
                telefono = ?, 
                observaciones = ?
            WHERE id_cambio_bateria = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error en prepare: " . $conn->error);
    }

    // Vincular parámetros
    $stmt->bind_param(
        "ssssidsssi",
        $fecha,
        $marca,
        $modelo,
        $voltaje,
        $garantia,
        $costo,
        $realizado_por,
        $telefono,
        $observaciones,
        $id_cambio_bateria
    );

    // Ejecutar
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "<script>
                alert('✅ Cambio de batería actualizado correctamente.');
                window.location.href = 'mantenimiento.php';
            </script>";
        } else {
            echo "<script>
                alert('⚠️ No se actualizó ningún registro. Verifica el ID del cambio de batería o si los datos son iguales.');
                window.history.back();
            </script>";
        }
    } else {
        echo "<script>
            alert('❌ Error al actualizar: " . $stmt->error . "');
            window.history.back();
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
