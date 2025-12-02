<?php 

include '../../conexion.php';
include '../../seguridad.php';

$registros_por_pagina = 2; 
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;

$inicio = ($pagina_actual - 1) * $registros_por_pagina;



$sqlhistorial = "SELECT h.*, v.modelo, v.marca, v.placa FROM historial_cambios_aceite h INNER JOIN vehiculos v ON h.id_vehiculo = v.id_vehiculo  LIMIT $inicio, $registros_por_pagina";
$resultadohistorial = $conn->query($sqlhistorial);

// 🔹 Contar total de registros para saber cuántas páginas hay
$total_resultado = $conn->query("SELECT COUNT(*) AS total FROM historial_cambios_aceite");
$total_fila = $total_resultado->fetch_assoc();
$total_registros = $total_fila['total'];
$total_paginas = ceil($total_registros / $registros_por_pagina);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
<?php include '../../menu.php'; ?>
<div class="p-4 sm:ml-64">
        <div class="h-16 sm:h-20"></div>

    <div class="max-w-7xl mx-auto">
        <div class="bg-gradient-to-r from-grey-900 to-grey-900 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-bold text-Black flex items-center gap-3">
              <i class="fa-regular fa-clipboard"></i>
              Historial de cambios de aceite
            </h1>
          </div>
          <div class="hidden md:block">
                <div class="bg-black/20 backdrop-blur-sm rounded-lg px-4 py-2">
                    <a href="../Reportes/pdf_aceite.php" class="text-white text-sm">PDF</a>
                </div>
            </div>
        </div>
      </div>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden fade-in">
        
            <div class="overflow-x-auto">
                
                <table class="min-w-full divide-y divide-gray-600">
                    <thead class="bg-gradient-to-r from-gray-900 to-gray-900">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">#</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-car mr-2"></i>modelo
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-calendar-alt mr-2"></i>Fecha
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fa-solid fa-clock mr-2"></i>Km actual
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fa-solid fa-clock mr-2"></i>Prox. cambio 
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fa-solid fa-oil-can mr-2"></i>Tipo aceite
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fa-solid fa-user mr-2"></i>Realizado por
                            </th>
                            <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fa-solid fa-phone mr-2"></i>Telefono 
                            </th>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fa-solid fa-money-check-dollar mr-2"></i>Costo
                            </th>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                               <i class="fa-solid fa-book-open-reader mr-2"></i>Observaciones  
                            </th>
                            <th class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                               <i class="fas fa-calendar-alt mr-2"></i>Fecha y hora
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php 
                        $contador = 1;
                        
                        while ($row = $resultadohistorial->fetch_assoc()): 
                            
                        ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 font-semibold text-sm">
                                        <?= $contador++ ?>
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-car text-white"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900"><?= $row['modelo'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= date('d/m/y', strtotime( $row['fecha_cambio_aceite'])) ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600"><?= $row['kilometraje_actual'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600"><?= $row['proximo_cambio_km'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600"><?= $row['tipo_aceite'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= $row['realizado_por_aceite'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= $row['telefono_aceite'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= $row['costo_aceite'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= $row['obs_aceite'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?= $row['fecha_registro'] ?></div>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
    </div>
    </div>
<div class="flex justify-center items-center mt-4 space-x-3">

 
  <a href="<?= ($pagina_actual > 1) ? '?pagina=' . ($pagina_actual - 1) : '#' ?>" 
     class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 
     <?= ($pagina_actual > 1) 
          ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' 
          : 'bg-gray-100 text-gray-400 cursor-not-allowed' ?>">
    <i class="fas fa-arrow-left"></i> Anterior
  </a>

  
  <a href="<?= ($pagina_actual < $total_paginas) ? '?pagina=' . ($pagina_actual + 1) : '#' ?>" 
     class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 
     <?= ($pagina_actual < $total_paginas) 
          ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' 
          : 'bg-gray-100 text-gray-400 cursor-not-allowed' ?>">
    Siguiente <i class="fas fa-arrow-right"></i>
  </a>
</div>

</div>
</body>
</html>