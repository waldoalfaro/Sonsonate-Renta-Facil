<?php
include '../conexion.php';
include '../seguridad.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id_vehiculo = $_POST['id_vehiculo'];
    $tipo_mantenimiento = $_POST['tipo_mantenimiento'];

    if ($tipo_mantenimiento == 'cambio_aceite' || $tipo_mantenimiento == 'reparacion') {

        // Datos de cambio de aceite
        $fecha_cambio_aceite = $_POST['fecha_cambio_aceite'] ?? null;
        $kilometraje_actual = $_POST['kilometraje_actual'] ?? null;
        $proximo_cambio_km = $_POST['proximo_cambio_km'] ?? null;
        $tipo_aceite = $_POST['tipo_aceite'] ?? null;
        $realizado_por_aceite = $_POST['realizado_por_aceite'] ?? null;
        $telefono_aceite = $_POST['telefono_aceite'] ?? null;
        $costo_aceite = $_POST['costo_aceite'] ?? null;
        $obs_aceite = $_POST['obs_aceite'] ?? null;

        // Datos de reparación
        $tipo_danio = $_POST['tipo_danio'] ?? null;
        $fecha_reparacion = $_POST['fecha_reparacion'] ?? null;
        $descripcion_danio = $_POST['descripcion_danio'] ?? null;
        $reparaciones_realizadas = $_POST['reparaciones_realizadas'] ?? null;
        $reparado_por = $_POST['reparado_por'] ?? null;
        $telefono_reparacion = $_POST['telefono_reparacion'] ?? null;
        $costo_reparacion = $_POST['costo_reparacion'] ?? null;

        // Evitar error de fecha vacía
        if (empty($fecha_cambio_aceite)) $fecha_cambio_aceite = null;
        if (empty($fecha_reparacion)) $fecha_reparacion = null;

         // ✅ Convertir campos numéricos vacíos a NULL o 0
            $kilometraje_actual = ($kilometraje_actual === '' || !is_numeric($kilometraje_actual)) ? null : (int)$kilometraje_actual;
            $proximo_cambio_km = ($proximo_cambio_km === '' || !is_numeric($proximo_cambio_km)) ? null : (int)$proximo_cambio_km;
            $costo_aceite = ($costo_aceite === '' || !is_numeric($costo_aceite)) ? null : (float)$costo_aceite;
            $costo_reparacion = ($costo_reparacion === '' || !is_numeric($costo_reparacion)) ? null : (float)$costo_reparacion;

        $sql = "INSERT INTO mantenimientos (
            id_vehiculo, tipo_mantenimiento, fecha_cambio_aceite, kilometraje_actual, proximo_cambio_km,
            tipo_aceite, realizado_por_aceite, telefono_aceite, costo_aceite, obs_aceite,
            tipo_danio, fecha_reparacion, descripcion_danio, reparaciones_realizadas,
            reparado_por, telefono_reparacion, costo_reparacion
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "isssissdssssssssd",
            $id_vehiculo,
            $tipo_mantenimiento,
            $fecha_cambio_aceite,
            $kilometraje_actual,
            $proximo_cambio_km,
            $tipo_aceite,
            $realizado_por_aceite,
            $telefono_aceite,
            $costo_aceite,
            $obs_aceite,
            $tipo_danio,
            $fecha_reparacion,
            $descripcion_danio,
            $reparaciones_realizadas,
            $reparado_por,
            $telefono_reparacion,
            $costo_reparacion
        );

    } elseif ($tipo_mantenimiento == 'cambio_bateria') {
        $fecha_bateria = !empty($_POST['fecha']) ? $_POST['fecha'] : date('Y-m-d');
        $marca_bateria = $_POST['marca_bateria'] ?? null;
        $modelo_bateria = $_POST['modelo'] ?? null;
        $voltaje = $_POST['voltaje'] ?? null;
        $garantia = $_POST['garantia'] ?? null;
        $costo = $_POST['costo'] ?? null;
        $realizado_por = $_POST['realizados'] ?? null;
        $telefono = $_POST['cell'] ?? null;
        $observaciones = $_POST['observa'] ?? null;

        $sql = "INSERT INTO cambio_bateria (id_vehiculo, fecha, marca_bateria, modelo_bateria, voltaje, garantia_meses, costo, realizado_por, telefono, observaciones)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "isssdidsss",
            $id_vehiculo,
            $fecha_bateria,
            $marca_bateria,
            $modelo_bateria,
            $voltaje,
            $garantia,
            $costo,
            $realizado_por,
            $telefono,
            $observaciones
        );

    } elseif ($tipo_mantenimiento == 'cambio_llantas') {
        $fecha = !empty($_POST['fecha']) ? $_POST['fecha'] : date('Y-m-d');
        $marca = $_POST['marca_llantas'] ?? null;
        $posicion = $_POST['posicion'] ?? null;
        $kilometraje = $_POST['kilometraje'] ?? null;
        $costo = $_POST['costo_llantas'] ?? null;
        $realizado_por = $_POST['realizado_por'] ?? null;
        $telefono = $_POST['telefono'] ?? null;
        $observaciones = $_POST['observaciones'] ?? null;

        $sql = "INSERT INTO cambio_llantas (id_vehiculo, fecha, marca_llanta, posicion, kilometraje_cambio, costo, realizado_por, telefono, observaciones)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "issssdsss",
            $id_vehiculo,
            $fecha,
            $marca,
            $posicion,
            $kilometraje,
            $costo,
            $realizado_por,
            $telefono,
            $observaciones
        );
    }

    // Ejecutar y manejar resultado
    if ($stmt && $stmt->execute()) {
        echo "<script>
            alert('✅ Mantenimiento registrado correctamente.');
            window.location.href = 'mantenimiento.php';
        </script>";
    } else {
        echo "<script>
            alert('❌ Error al registrar el mantenimiento: " . ($stmt ? $stmt->error : $conn->error) . "');
            window.history.back();
        </script>";
    }

    if ($stmt) $stmt->close();
    $conn->close();

} else {
    header("Location: mantenimiento.php");
    exit();
}
?>
