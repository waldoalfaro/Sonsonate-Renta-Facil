<?php
include '../conexion.php';
include '../seguridad.php';

$sql = "SELECT * FROM vehiculos_eliminados ORDER BY fecha_eliminacion DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vehículos Eliminados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../menu.php' ?>

    <div class="p-4 sm:ml-64">
        <div class="container mt-4">
        <h2 class="mb-3">Historial de Vehículos Eliminados</h2>
        <table class="table table-bordered table-hover text-center">
            <thead class="table-danger">
                <tr>
                    <th>ID Vehículo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Placa</th>
                    <th>Color</th>
                    <th>Año</th>
                    <th>Estado</th>
                    <th>Fecha Registro</th>
                    <th>Fecha Eliminación</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_vehiculo'] ?></td>
                    <td><?= htmlspecialchars($row['marca']) ?></td>
                    <td><?= htmlspecialchars($row['modelo']) ?></td>
                    <td><?= htmlspecialchars($row['placa']) ?></td>
                    <td><?= htmlspecialchars($row['color']) ?></td>
                    <td><?= $row['anio'] ?></td>
                    <td><?= $row['estado'] ?></td>
                    <td><?= $row['fecha_registro'] ?></td>
                    <td><?= $row['fecha_eliminacion'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    </div>

    
</body>
</html>
