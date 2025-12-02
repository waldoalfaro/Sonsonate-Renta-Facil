<?php
include '../conexion.php';


$registros_por_pagina = 1; // cantidad por página
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;

$inicio = ($pagina_actual - 1) * $registros_por_pagina;


$sql = "SELECT c.*, v.marca, v.modelo, v.placa 
        FROM contratos c
        INNER JOIN vehiculos v ON c.id_vehiculo = v.id_vehiculo
        ORDER BY c.fecha_creacion DESC LIMIT $inicio, $registros_por_pagina";
$result = $conn->query($sql);

$total_resultado = $conn->query("SELECT COUNT(*) AS total FROM contratos");
$total_fila = $total_resultado->fetch_assoc();
$total_registros = $total_fila['total'];
$total_paginas = ceil($total_registros / $registros_por_pagina);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Contratos Registrados</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body class="bg-gray-100 p-6">

<?php include '../menu.php'; ?>


<div class="p-4 sm:ml-64">
    <div class="h-16 sm:h-20"></div>

 <div class="max-w-7xl mx-auto">
        <div class="bg-gradient-to-r from-gray-700 to-gray-700 rounded-lg shadow-lg p-6 mb-6 fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                        <i class="fas fa-users"></i>
                        Gestión de Contratos 
                    </h1>
                    <p class="text-purple-100 mt-2">Administra y controla todos tus contratos</p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <p class="text-white text-sm">Total de contratos</p>
                    </div>
                </div>
            </div>
        </div>

        

        
        <div class="bg-white rounded-lg shadow-lg overflow-hidden fade-in">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-700 to-gray-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Cliente
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Vehiculo
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Fechas
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                Dias
                            </th>
                             <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                Total
                            </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Estado</th>

                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php 
                        $contador = 1;
                        while ($row = $result->fetch_assoc()): 
                            // Colores para tipos de usuario
                        ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 text-white font-bold text-sm shadow-md">
                                        <?= $contador++ ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                            
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-bold text-gray-900"><?= $row['cliente_nombre'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900"><?= $row['marca'].' '.$row['modelo'].' ('.$row['placa'].')' ?></span>
                
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-600"><?= $row['fecha_inicio'] ?> → <?= $row['fecha_fin'] ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                        
                                        <?= $row['dias_renta'] ?>
                                    </span>
                                </td>
                                 <td class="px-6 py-4 whitespace-nowrap text-center">
                                        
                                        <?= $row['total_contrato'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php
                                        $estado = $row['estado'];
                                        $color = match ($estado) {
                                        'Activo' => 'bg-green-100 text-green-800',
                                        'Finalizado' => 'bg-blue-100 text-blue-800',
                                        'Cancelado' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-700'
                                        };
                                    ?>
                                    <select 
                                        onchange="cambiarEstado(<?= $row['id_contrato'] ?>, this.value)" 
                                        class="px-2 py-1 rounded-lg text-sm font-semibold <?= $color ?> border border-gray-300 focus:ring-2 focus:ring-indigo-400 transition"
                                    >
                                        <option value="Activo" <?= ($estado == 'Activo') ? 'selected' : '' ?>>Activo</option>
                                        <option value="Finalizado" <?= ($estado == 'Finalizado') ? 'selected' : '' ?>>Finalizado</option>
                                        <option value="Cancelado" <?= ($estado == 'Cancelado') ? 'selected' : '' ?>>Cancelado</option>
                                    </select>
                                </td>
                                <td>
                                     <a href="generar_contrato_pdf.php?id_contrato=<?= $row['id_contrato'] ?>" 
                               class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">
                               Descargar PDF
                            </a>
                                </td>
                               
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
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

        <!-- Footer info -->
        <div class="mt-6 text-center text-gray-600 text-sm">
            <p><i class="fas fa-info-circle mr-2"></i>Gestiona los permisos y accesos de cada usuario del sistema</p>
        </div>
    </div>
   
</div>

<script>
function cambiarEstado(id, nuevoEstado) {
  Swal.fire({
    title: '¿Cambiar estado?',
    text: `El contrato #${id} pasará a estado "${nuevoEstado}".`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, cambiar',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33'
  }).then(result => {
    if (result.isConfirmed) {
      fetch('actualizar_estado_contrato.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id_contrato=${id}&estado=${encodeURIComponent(nuevoEstado)}`
      })
      .then(res => res.json())
      .then(data => {
        if (data.ok) {
          Swal.fire({
            icon: 'success',
            title: 'Estado actualizado',
            text: 'El estado del contrato fue modificado correctamente.',
            timer: 1500,
            showConfirmButton: false
          }).then(() => location.reload());
        } else {
          Swal.fire('Error', data.msg || 'No se pudo actualizar el estado', 'error');
        }
      })
      .catch(err => {
        console.error(err);
        Swal.fire('Error', 'Hubo un problema al conectar con el servidor.', 'error');
      });
    } else {
      // Si cancela, restauramos el valor original del select
      location.reload();
    }
  });
}
</script>

</body>
</html>





