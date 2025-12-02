<?php
// archivo categorias.php
// Lista de categorías disponibles
$categorias = [
    "sedan" => "Sedán",
    "pickup" => "Pick Up",
    "camiones" => "Camiones",
    "motos" => "Motos",
    "microbuses" => "Micro Buses"
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías de Vehículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="text-center mb-4">Categorías de Vehículos</h1>
    
    <div class="row justify-content-center">
        <?php foreach ($categorias as $key => $nombre): ?>
            <div class="col-md-3 col-sm-6 mb-3">
                <a href="vehiculos.php?categoria=<?= $key ?>" class="btn btn-primary w-100">
                    <?= $nombre ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
