<?php
include '../conexion.php'; // Ajusta la ruta según tu estructura
$upload_dir = '../uploads/configuracion/';

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['imagen']['tmp_name'];
        $file_name = time() . '_' . basename($_FILES['imagen']['name']);
        $file_path = $upload_dir . $file_name;

        if (move_uploaded_file($file_tmp, $file_path)) {
            $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
            $sql = "INSERT INTO promociones (imagen, descripcion) VALUES ('$file_name', '$descripcion')";

            if (mysqli_query($conn, $sql)) {
                // 🔹 Redirigir con mensaje de éxito
                header("Location: promociones.php?exito=1");
                exit;
            } else {
                header("Location: promociones.php?error=db");
                exit;
            }
        } else {
            header("Location: promociones.php?error=subida");
            exit;
        }
    } else {
        header("Location: promociones.php?error=noimagen");
        exit;
    }
}
?>
