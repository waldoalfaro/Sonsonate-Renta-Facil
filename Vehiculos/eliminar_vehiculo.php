


<?php
session_start();
include '../conexion.php';

if (isset($_GET['id_vehiculo'])) {
    $id = $_GET['id_vehiculo'];

    try {
        // Intentar eliminar el vehículo
        $sql = "DELETE FROM vehiculos WHERE id_vehiculo = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }

        header('Location: vehiculos.php?eliminado=1');
        exit();

    } catch (mysqli_sql_exception $e) {
        // Si falla por llave foránea, redirigir con error
        header('Location: vehiculos.php?error=relacion');
        exit();
    }
}
?>
