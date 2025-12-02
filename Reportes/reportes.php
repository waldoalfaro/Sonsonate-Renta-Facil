<?php
include '../conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Finanzas</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<?php include '../menu.php'; ?>

<div class="p-4 sm:ml-64">
  <div class="h-16 sm:h-20"></div>

  <div class="p-6">
    <h2 class="text-3xl font-bold text-center text-blue-600 mb-8">Ingresos vs Egresos Mensuales</h2>

    <!-- Selector de mes -->
    <form method="GET" class="flex flex-col md:flex-row justify-center items-center gap-3 mb-8">
      <label for="mes" class="font-semibold text-gray-700">Seleccionar mes:</label>
      <input 
        type="month" 
        id="mes" 
        name="mes" 
        value="<?php echo isset($_GET['mes']) ? $_GET['mes'] : date('Y-m'); ?>" 
        class="border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
      >
      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow-md transition">
        <i class="fas fa-chart-line mr-1"></i> Ver gráfico
      </button>
    </form>

<?php
$mesSeleccionado = $_GET['mes'] ?? date('Y-m');
$inicioMes = $mesSeleccionado . '-01';
$finMes = date('Y-m-t', strtotime($inicioMes));

$sqlIngresos = "SELECT DATE(fecha_creacion) AS fecha, IFNULL(SUM(total_contrato), 0) AS total
                FROM contratos
                WHERE fecha_creacion BETWEEN '$inicioMes' AND '$finMes'
                GROUP BY DATE(fecha_creacion)
                ORDER BY fecha";
$resIngresos = $conn->query($sqlIngresos);

$ingresos = [];
$totalIngresos = 0;
if ($resIngresos && $resIngresos->num_rows > 0) {
    while ($row = $resIngresos->fetch_assoc()) {
        $ingresos[$row['fecha']] = $row['total'];
        $totalIngresos += $row['total'];
    }
}

$sqlEgresos = "SELECT DATE(fecha_cambio_aceite) AS fecha, IFNULL(SUM(costo_aceite), 0) AS total
               FROM mantenimientos
               WHERE fecha_cambio_aceite BETWEEN '$inicioMes' AND '$finMes'
               GROUP BY DATE(fecha_cambio_aceite)
               ORDER BY fecha";
$resEgresos = $conn->query($sqlEgresos);

$egresos = [];
$totalEgresos = 0;
if ($resEgresos && $resEgresos->num_rows > 0) {
    while ($row = $resEgresos->fetch_assoc()) {
        $egresos[$row['fecha']] = $row['total'];
        $totalEgresos += $row['total'];
    }
}

$fechas = [];
$valoresIngresos = [];
$valoresEgresos = [];
$diaInicio = new DateTime($inicioMes);
$diaFin = new DateTime($finMes);
while ($diaInicio <= $diaFin) {
    $fecha = $diaInicio->format('Y-m-d');
    $fechas[] = $fecha;
    $valoresIngresos[] = $ingresos[$fecha] ?? 0;
    $valoresEgresos[] = $egresos[$fecha] ?? 0;
    $diaInicio->modify('+1 day');
}

$totalNeto = $totalIngresos - $totalEgresos;
?>

    <!-- Tarjetas resumen -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
      <div class="bg-gradient-to-r from-green-400 to-green-600 text-white rounded-2xl p-5 shadow-lg text-center transform hover:scale-105 transition">
        <h5 class="text-lg font-semibold mb-1">💰 Total Ingresos</h5>
        <h3 class="text-3xl font-bold">$<?php echo number_format($totalIngresos, 2); ?></h3>
      </div>

      <div class="bg-gradient-to-r from-red-400 to-red-600 text-white rounded-2xl p-5 shadow-lg text-center transform hover:scale-105 transition">
        <h5 class="text-lg font-semibold mb-1">💸 Total Egresos</h5>
        <h3 class="text-3xl font-bold">$<?php echo number_format($totalEgresos, 2); ?></h3>
      </div>

      <div class="bg-gradient-to-r <?php echo ($totalNeto >= 0) ? 'from-blue-400 to-blue-600' : 'from-yellow-400 to-yellow-600'; ?> text-white rounded-2xl p-5 shadow-lg text-center transform hover:scale-105 transition">
        <h5 class="text-lg font-semibold mb-1">📈 Resultado Neto</h5>
        <h3 class="text-3xl font-bold">$<?php echo number_format($totalNeto, 2); ?></h3>
      </div>
    </div>

    <!-- Gráfico (solo visible en pantallas grandes) -->
    <div class="hidden md:block bg-white shadow-xl rounded-2xl p-6 border border-gray-100">
      <canvas id="graficaFinanzas" class="w-full h-96"></canvas>
    </div>

    <!-- Mensaje para pantallas pequeñas -->
    <div class="md:hidden text-center bg-yellow-100 border border-yellow-300 text-yellow-700 p-4 rounded-xl shadow-md">
      📊 La gráfica solo está disponible en pantallas grandes.
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('graficaFinanzas');
if (ctx) {
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($fechas); ?>,
      datasets: [
        {
          label: 'Ingresos (Contratos)',
          data: <?php echo json_encode($valoresIngresos); ?>,
          borderColor: '#22c55e',
          backgroundColor: 'rgba(34,197,94,0.2)',
          borderWidth: 3,
          tension: 0.4,
          pointRadius: 4,
          pointBackgroundColor: '#16a34a',
          fill: true
        },
        {
          label: 'Egresos (Mantenimientos)',
          data: <?php echo json_encode($valoresEgresos); ?>,
          borderColor: '#ef4444',
          backgroundColor: 'rgba(239,68,68,0.2)',
          borderWidth: 3,
          tension: 0.4,
          pointRadius: 4,
          pointBackgroundColor: '#dc2626',
          fill: true
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'top', labels: { font: { weight: 'bold' } } },
        title: {
          display: true,
          text: '📅 Ingresos y Egresos - <?php echo strtoupper(date("F Y", strtotime($inicioMes))); ?>',
          color: '#1e3a8a',
          font: { size: 18, weight: 'bold' }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: { color: 'rgba(0,0,0,0.05)' },
          title: { display: true, text: 'Monto (USD)', font: { weight: 'bold' } }
        },
        x: {
          grid: { color: 'rgba(0,0,0,0.03)' },
          title: { display: true, text: 'Días del Mes', font: { weight: 'bold' } }
        }
      }
    }
  });
}
</script>
</body>
</html>
