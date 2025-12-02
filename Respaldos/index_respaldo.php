<?php 
$directorio = __DIR__ . "/respaldos/";
$archivos = array_diff(scandir($directorio), ['.', '..']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Respaldo del Sistema</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-gray-50">
    <?php include '../menu.php' ?>
    <div class="h-16 sm:h-20"></div>

<div class="p-4 sm:ml-64">

<h2 class="mb-4">Respaldo del Sistema</h2>

<a href="crear_respaldo.php" class="btn btn-primary">Crear respaldo del sistema</a>
<a href="crear_respaldo_datos.php" class="btn btn-success">Crear respaldo de datos</a>

<hr>

<h4>Archivos disponibles</h4>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Archivo</th>
            <th>Tamaño</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($archivos as $archivo):
            $ruta = $directorio . $archivo;
        ?>
        <tr>
            <td><?= $archivo ?></td>
            <td><?= round(filesize($ruta)/1024, 2) ?> KB</td>
            <td><?= date("d/m/Y H:i:s", filemtime($ruta)) ?></td>
            <td>
                <a href="respaldos/<?= $archivo ?>" download class="btn btn-info btn-sm">Descargar</a>
                <a href="eliminar_respaldo.php?file=<?= $archivo ?>" class="btn btn-danger btn-sm">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<hr>

<h4>Restaurar desde archivo</h4>

<form action="restaurar_respaldo.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="archivo" required class="form-control w-50">
    <button class="btn btn-purple mt-3 btn btn-primary">Restaurar</button>
</form>
</div>
</body>
</html>
