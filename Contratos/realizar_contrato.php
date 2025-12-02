<?php
include '../conexion.php';

// 1️⃣ Verificar ID
if (!isset($_GET['id_reservacion'])) {
    die("ID de reservación no proporcionado.");
}

$id_reservacion = intval($_GET['id_reservacion']);

// 2️⃣ Obtener datos de reservación + vehículo
$sql = "SELECT 
            r.*, 
            v.marca, v.modelo, v.anio, v.color, v.placa, v.precio_dia 
        FROM reservaciones r
        INNER JOIN vehiculos v ON r.id_vehiculo = v.id_vehiculo
        WHERE r.id_reservacion = $id_reservacion";
$res = $conn->query($sql);
if ($res->num_rows === 0) {
    die("Reservación no encontrada.");
}
$data = $res->fetch_assoc();

// 3️⃣ Guardar contrato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deposito = $_POST['deposito_garantia'] ?? 0;
    $observaciones = $_POST['observaciones'] ?? '';

    $stmt = $conn->prepare("INSERT INTO contratos 
        (id_vehiculo, cliente_nombre, cliente_dui, cliente_telefono, cliente_correo,
         fecha_inicio, fecha_fin, dias_renta, precio_dia, total_contrato, deposito_garantia, observaciones)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "ississsiddss",
        $data['id_vehiculo'],
        $data['solicitante_nombre'],
        $data['solicitante_dui'],
        $data['solicitante_telefono'],
        $data['solicitante_correo'],
        $data['fecha_inicio_solicitada'],
        $data['fecha_fin_solicitada'],
        $data['dias_solicitados'],
        $data['precio_dia'],
        $data['total_pagar'],
        $deposito,
        $observaciones
    );

    if ($stmt->execute()) {
        header("Location: contratos.php?exito=1");
        exit;
    } else {
        echo "❌ Error al guardar contrato: " . $conn->error;
    }
}
?>


<!-- 🧾 FORMULARIO DE CONFIRMACIÓN -->
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Realizar Contrato</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 p-6">
        <div class="h-16 sm:h-20"></div>

    <?php include '../menu.php'; ?> 

<div class="max-w-3xl mx-auto bg-white p-6 rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Generar Contrato</h2>

    <p class="mb-2"><strong>Cliente:</strong> <?= $data['solicitante_nombre'] ?></p>
    <p class="mb-2"><strong>DUI:</strong> <?= $data['solicitante_dui'] ?></p>
    <p class="mb-2"><strong>Vehículo:</strong> <?= $data['marca'] . ' ' . $data['modelo'] . ' (' . $data['anio'] . ')' ?></p>
    <p class="mb-2"><strong>Placa:</strong> <?= $data['placa'] ?></p>
    <p class="mb-2"><strong>Fechas:</strong> <?= $data['fecha_inicio_solicitada'] ?> → <?= $data['fecha_fin_solicitada'] ?></p>
    <p class="mb-4"><strong>Total a pagar:</strong> $<?= number_format($data['total_pagar'], 2) ?></p>

    <form method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Depósito de garantía ($):</label>
            <input type="number" name="deposito_garantia" step="0.01" class="border rounded-lg w-full p-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Observaciones:</label>
            <textarea name="observaciones" class="border rounded-lg w-full p-2" rows="3"></textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Guardar Contrato</button>
    </form>
</div>

</body>
</html>
