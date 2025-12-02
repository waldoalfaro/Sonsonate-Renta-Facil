<?php
include '../conexion.php';
include '../seguridad.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_vehiculo = $_POST['id_vehiculo'];
    $fecha = $_POST['Fecha'];
    $kilometraje_actual = $_POST['kilometraje_actual'];
    $proximo_cambio_km = $_POST['proximo_cambio_km'];
    $tipo_aceite = $_POST['tipo_aceite'];
    $realisado = $_POST['Realizado_por'];
    $telefono = $_POST['telefono'];
    $costo_aceite = $_POST['costo_aceite'];
    $observaciones = $_POST['observaciones'];



    $sql = "UPDATE mantenimientos SET tipo_mantenimiento = 'cambio_aceite', fecha_cambio_aceite = ?, kilometraje_actual = ?, proximo_cambio_km = ?, tipo_aceite = ?, realizado_por_aceite = ?, telefono_aceite = ?, costo_aceite = ?, obs_aceite = ? WHERE id_vehiculo = ? AND tipo_mantenimiento = 'cambio_aceite'";
   
   
    $stmt = $conn->prepare($sql);


    $stmt->bind_param("siissiisi", $fecha, $kilometraje_actual, $proximo_cambio_km, $tipo_aceite, $realisado, $telefono, $costo_aceite, $observaciones, $id_vehiculo);


   if ($stmt->execute()) {
        echo "<script>
            alert('✅ Cambio de aceite actualizado correctamente.');
            window.location.href = 'mantenimiento.php';
        </script>";
    } else {
        echo "<script>
            alert('❌ Error al actualizar el cambio de aceite: " . $stmt->error . "');
            window.history.back();
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
