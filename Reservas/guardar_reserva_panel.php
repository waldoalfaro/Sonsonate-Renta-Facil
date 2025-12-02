<?php
include '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_vehiculo     = $_POST['id_vehiculo'];
    $nombre_cliente  = $_POST['nombre_cliente'];
    $dui             = $_POST['dui'];
     $codigo_pais = $_POST['codigo_pais'];
    $telefono = $codigo_pais . ' ' . $_POST['telefono_cliente'];
    $email           = $_POST['email_cliente'];
    $fecha_inicio    = $_POST['fecha_inicio'];
    $fecha_fin       = $_POST['fecha_fin'];
    $dias            = $_POST['dias'];
    $costo           = $_POST['total_pagar'];
    $observaciones   = $_POST['observaciones'];

    // Archivos recibidos
    $foto_dui        = $_FILES['fotos_dui'];
    $foto_licencia   = $_FILES['fotos_licencia'];

    // Validación básica de campos
    if (
        !$id_vehiculo || empty($nombre_cliente) || empty($email) ||
        empty($telefono) || empty($fecha_inicio) || empty($fecha_fin)
    ) {
        die("Todos los campos son obligatorios.");
    }

    // 📁 Carpeta donde se guardarán las fotos
    $carpetaDestino = "../uploads/";

    // Crear carpeta si no existe
    if (!file_exists($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true);
    }

    // ✅ Validaciones de imágenes
    function validarImagen($archivo) {
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/jpg'];
        $tamanoMaximo = 2 * 1024 * 1024; // 2 MB

        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            return "Error al subir el archivo.";
        }

        if (!in_array($archivo['type'], $tiposPermitidos)) {
            return "Solo se permiten imágenes JPG o PNG.";
        }

        if ($archivo['size'] > $tamanoMaximo) {
            return "El tamaño máximo permitido es de 2 MB.";
        }

        return true;
    }

    // Validar cada imagen
    $validacionDui = validarImagen($foto_dui);
    $validacionLic = validarImagen($foto_licencia);

    if ($validacionDui !== true) {
        die("❌ Error en foto del DUI: " . $validacionDui);
    }

    if ($validacionLic !== true) {
        die("❌ Error en foto de la Licencia: " . $validacionLic);
    }

    // Generar nombres únicos
    $nombreFotoDui = uniqid("dui_") . "_" . basename($foto_dui['name']);
    $nombreFotoLic = uniqid("lic_") . "_" . basename($foto_licencia['name']);

    // Rutas completas
    $rutaFotoDui = $carpetaDestino . $nombreFotoDui;
    $rutaFotoLic = $carpetaDestino . $nombreFotoLic;

    // Mover los archivos al servidor
    if (!move_uploaded_file($foto_dui['tmp_name'], $rutaFotoDui)) {
        die("❌ No se pudo guardar la foto del DUI.");
    }
    if (!move_uploaded_file($foto_licencia['tmp_name'], $rutaFotoLic)) {
        die("❌ No se pudo guardar la foto de la Licencia.");
    }

    // 💾 Guardar en base de datos
    $stmt = $conn->prepare("INSERT INTO reservaciones 
        (id_vehiculo, solicitante_nombre, solicitante_dui, solicitante_telefono, solicitante_correo, 
        fecha_inicio_solicitada, fecha_fin_solicitada, dias_solicitados, total_pagar, documentosDui, licencia, observaciones)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "issssssissss",
        $id_vehiculo,
        $nombre_cliente,
        $dui,
        $telefono,
        $email,
        $fecha_inicio,
        $fecha_fin,
        $dias,
        $costo,
        $nombreFotoDui,
        $nombreFotoLic,
        $observaciones
    );

   if ($stmt->execute()) {
    // obtener id de la reservación recién creada
    $id_reserva = $stmt->insert_id; // o $conn->insert_id

    // Crear mensaje de notificación
    $mensaje = "Nueva reservación de $nombre_cliente (DUI: $dui) para vehículo ID $id_vehiculo";
    $tipo = "reservacion";

    // Insertar en tabla notificaciones incluyendo id_reservacion
    $sqlNotif = "INSERT INTO notificaciones (mensaje, tipo, id_reservacion) VALUES (?, ?, ?)";
    $stmtNotif = $conn->prepare($sqlNotif);
    $stmtNotif->bind_param("ssi", $mensaje, $tipo, $id_reserva);
    $stmtNotif->execute();
    $stmtNotif->close();

    // Redirigimos con un parámetro de éxito
    header("Location: Reservas.php?reserva=ok");
    exit;
} else {
    header("Location: Reservas.php?reserva=error");
    exit;
}


} else {
    die("Acceso no permitido");
}
?>
