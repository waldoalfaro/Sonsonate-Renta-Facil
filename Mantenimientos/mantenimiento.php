<?php
include '../conexion.php';
include '../seguridad.php';
include 'obtener_kilometraje.php';

$sql = "SELECT id_vehiculo, marca,  modelo, placa FROM vehiculos WHERE estado = 'Mantenimiento'";
$result = $conn->query($sql);



$sqlMantenimientoAceite = "SELECT m.*, v.modelo, v.marca, v.placa 
                            FROM Mantenimientos m 
                            INNER JOIN vehiculos v ON m.id_vehiculo = v.id_vehiculo
                            where m.tipo_mantenimiento = 'cambio_aceite'
                            ORDER BY m.fecha_cambio_aceite DESC";
$Resultados = $conn->query($sqlMantenimientoAceite);


$sqlMnatenimientoReparaciones = "SELECT m.*, v.modelo, v.marca, v.placa
                                  FROM Mantenimientos m
                                  INNER JOIN vehiculos v On m.id_vehiculo = v.id_vehiculo
                                  WHERE m.tipo_mantenimiento = 'reparacion'
                                  ORDER BY m.fecha_reparacion DESC";
$ResulReparaciones = $conn->query($sqlMnatenimientoReparaciones);


$sqlcambiobateria = "SELECT b.*, v.modelo, v.marca, v.placa
                    FROM cambio_bateria b
                    INNER JOIN vehiculos v ON b.id_vehiculo = v.id_vehiculo
                    ORDER BY b.fecha DESC";
$resultadobateria = $conn->query($sqlcambiobateria);


$sqlmantenimientollantas = "SELECT l.*, v.modelo, v.marca, v.placa
                            FROM cambio_llantas l
                            INNER JOIN vehiculos v ON l.id_vehiculo = v.id_vehiculo
                            ORDER BY l.fecha DESC";
$resultadosllantas = $conn->query($sqlmantenimientollantas);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Mantenimiento</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">

  <?php include '../menu.php'; ?>

  <div class="p-4 sm:ml-64">
    <div class="h-16 sm:h-20"></div>

    <div class="max-w-7xl mx-auto">
      <div class="bg-gradient-to-r from-gray-600 to-gray-800 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
              <i class="fas fa-calendar-check"></i>
              Gestión de Mantenimiento
            </h1>
            <p class="text-white mt-2">Administra y controla todos los mantenimientos de tus vehículos</p>
          </div>
          <div class="hidden md:block">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <p class="text-white text-sm">Total de reparaciones</p>
                        <p class="text-3xl font-bold text-white"><?= $ResulReparaciones->num_rows ?></p>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <p class="text-white text-sm">Total de cambios de aceite</p>
                        <p class="text-3xl font-bold text-white"><?= $Resultados->num_rows ?></p>
                    </div>
                </div>
        </div>
      </div>

      <!-- BOTÓN PARA MOSTRAR FORMULARIO -->
      <div class="mb-6">
        <button id="btnMostrarForm" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
          <i class="fa-solid fa-plus mr-2"></i>
          Agregar Nuevo Mantenimiento
        </button>
      </div>

      <!-- FORMULARIO OCULTO -->
      <div id="formContainer" class="hidden transition-all duration-500 ease-in-out">
        <div class="bg-white shadow-xl rounded-lg p-6 mb-6 border-l-4 border-gray-500">
          <h5 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-2">
            <i class="fas fa-plus-circle text-gray-600"></i> Registrar Nuevo Mantenimiento
          </h5>

          <form action="ValidarMantenimiento.php" method="POST" enctype="multipart/form-data" id="vehicleForm">
            <div class="row g-4">
              <!-- Vehículo -->
              <div class="col-md-6">
                <label class="form-label fw-bold text-gray-700">
                  <i class="fas fa-car text-gray-600 mr-1"></i> Vehículo
                </label>
                <select name="id_vehiculo" class="form-select border-2 border-gray-300 focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition" required>
                  <option value="">Seleccione un vehículo...</option>
                  <?php while ($row = $result->fetch_assoc()) { ?>
                  <option value="<?= $row['id_vehiculo'] ?>">
                    <?= $row['marca'] . " - " .$row['modelo']. " - "  . $row['placa'] ?>
                  </option>
                  <?php } ?>
                </select>
              </div>

              <!-- Tipo de Mantenimiento -->
              <div class="col-md-6">
                <label class="form-label fw-bold text-gray-700">
                  <i class="fas fa-wrench text-gray-600 mr-1"></i> Tipo de Mantenimiento
                </label>
                <select id="tipoMantenimiento" name="tipo_mantenimiento" class="form-select border-2 border-gray-300 focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition" required>
                  <option value="">Seleccione el tipo...</option>
                  <option value="cambio_aceite">Cambio de Aceite</option>
                  <option value="reparacion">Reparación / Otro Daño</option>
                </select>
              </div>
            </div>

            <!-- SECCIÓN DE CAMBIO DE ACEITE -->
            <div id="seccionAceite" class="section-mantenimiento hidden mt-4">
              <div class="bg-blue-50 border-2 border-blue-300 rounded-lg p-4">
                <h6 class="font-bold text-blue-800 mb-3 flex items-center gap-2">
                  <i class="fas fa-oil-can"></i> Información de Cambio de Aceite
                </h6>
                <div class="row g-3">
                  <div class="col-md-4">
                    <label class="form-label fw-bold text-gray-700">Fecha de Cambio</label>
                    <input type="date" class="form-control border-2 border-blue-200 focus:border-blue-500" name="fecha_cambio_aceite">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-bold text-gray-700">Kilometraje Actual</label>
                    <input type="number" class="form-control border-2 border-blue-200 focus:border-blue-500" name="kilometraje_actual" placeholder="Ej: 45000">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-bold text-gray-700">Próximo Cambio (Km)</label>
                    <input type="number" class="form-control border-2 border-blue-200 focus:border-blue-500" name="proximo_cambio_km" placeholder="Ej: 50000">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-gray-700">Tipo de Aceite Utilizado</label>
                    <input type="text" class="form-control border-2 border-blue-200 focus:border-blue-500" name="tipo_aceite" placeholder="Ej: 10W-40 Sintético">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-gray-700">Realizado por</label>
                    <input type="text" class="form-control border-2 border-blue-200 focus:border-blue-500" name="realizado_por_aceite" placeholder="Nombre del mecánico o taller">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-gray-700">Teléfono</label>
                    <input type="tel" class="form-control border-2 border-blue-200 focus:border-blue-500" name="telefono_aceite" placeholder="0000-0000">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-gray-700">Costo ($)</label>
                    <input type="number" step="0.01" class="form-control border-2 border-blue-200 focus:border-blue-500" name="costo_aceite" placeholder="0.00">
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-bold text-gray-700">Observaciones</label>
                    <textarea class="form-control border-2 border-blue-200 focus:border-blue-500" name="obs_aceite" rows="2" placeholder="Información adicional sobre el cambio de aceite..."></textarea>
                  </div>
                </div>
              </div>
            </div>

            <!-- SECCIÓN DE REPARACIÓN -->
            <div id="seccionReparacion" class="section-mantenimiento hidden mt-4">
              <div class="bg-red-50 border-2 border-red-300 rounded-lg p-4">
                <h6 class="font-bold text-red-800 mb-3 flex items-center gap-2">
                  <i class="fas fa-tools"></i> Información de Reparación
                </h6>
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-gray-700">Tipo de Daño</label>
                    <input type="text" class="form-control border-2 border-red-200 focus:border-red-500" name="tipo_danio" placeholder="Ej: Daño en transmisión">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-gray-700">Fecha de Reparación</label>
                    <input type="date" class="form-control border-2 border-red-200 focus:border-red-500" name="fecha_reparacion">
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-bold text-gray-700">Descripción del Daño</label>
                    <textarea class="form-control border-2 border-red-200 focus:border-red-500" name="descripcion_danio" rows="3" placeholder="Describe detalladamente el daño encontrado..."></textarea>
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-bold text-gray-700">Reparaciones Realizadas</label>
                    <textarea class="form-control border-2 border-red-200 focus:border-red-500" name="reparaciones_realizadas" rows="3" placeholder="Describe las reparaciones que se llevaron a cabo..."></textarea>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-gray-700">Reparado por</label>
                    <input type="text" class="form-control border-2 border-red-200 focus:border-red-500" name="reparado_por" placeholder="Nombre del mecánico o taller">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-gray-700">Teléfono</label>
                    <input type="tel" class="form-control border-2 border-red-200 focus:border-red-500" name="telefono_reparacion" placeholder="0000-0000">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-bold text-gray-700">Costo de Reparación ($)</label>
                    <input type="number" step="0.01" class="form-control border-2 border-red-200 focus:border-red-500" name="costo_reparacion" placeholder="0.00">
                  </div>
                </div>
              </div>
            </div>


                    

            <div class="mt-5 text-center">
              <button type="submit" class="px-8 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                <i class="fas fa-save mr-2"></i> Guardar Mantenimiento
              </button>
              <button type="button" id="btnCancelar" class="px-8 py-3 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 ml-3">
                <i class="fas fa-times mr-2"></i> Cancelar
              </button>
            </div>
          </form>
        </div>
      </div>

      

      <!-- LISTADO DE MANTENIMIENTOS -->
      
      
    </div>
    <div class="container">
        <div class="content">
          <div class="search-bar mb-3">
            
          </div>

         

          <div class="vehicle-list bg-white rounded-lg p-4 shadow-md">
            <h2 class="text-lg font-bold mb-3 text-gray-700 flex items-center gap-2">
              <i class="fas fa-list"></i> Lista de Mantenimientos de cambio de aceite...
            </h2>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden fade-in">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-700 to-gray-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                              Modelo
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                </i>Placa
                            </th>
                             <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                </i>Tipo de Mantenimiento
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                </i>Fecha cambio de aceite
                            </th>
                             <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                </i>Kilometrahe Actual
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                </i>Proximo cambio
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                </i>Tipo de aceite
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                </i>Realizado por
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                </i>Costo
                            </th>
                             <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                </i>Observaciones
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-cog mr-2"></i>Acciones
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php 
                        $contador = 1;
                        $colores = [
                            'from-blue-400 to-blue-600',
                            'from-green-400 to-green-600',
                            'from-purple-400 to-purple-600',
                            'from-pink-400 to-pink-600',
                            'from-indigo-400 to-indigo-600',
                            'from-red-400 to-red-600'
                        ];
                        while ($row = $Resultados->fetch_assoc()): 
                            $colorIndex = ($contador - 1) % count($colores);
                            $gradiente = $colores[$colorIndex];
                        ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br <?= $gradiente ?> text-white font-bold text-sm shadow-md">
                                        <?= $contador++ ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        
                                        <div class="ml-4">
                                            <p class="text-sm font-bold text-gray-900"><?= $row['modelo'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['placa'] ?></div>
                                </td>
                                 <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['tipo_mantenimiento'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['fecha_cambio_aceite'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['kilometraje_actual'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['proximo_cambio_km'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['tipo_aceite'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['realizado_por_aceite'] ?></div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">$<?= $row['costo_aceite'] ?></div>
                                </td>
                                 <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['obs_aceite'] ?></div>
                                </td> 
                                <td>
                                  <a href="#"
                                    onclick="abrirModalCambioAceite(<?= $row['id_mantenimiento'] ?>)"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-500 hover:bg-blue-600 text-white transition-all duration-200 hover:scale-110 shadow-sm"
                                    title="Registrar nuevo cambio de aceite">
                                    <i class="fas fa-pen-to-square text-sm"></i>
                                  </a>

                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
            
          </div>
        </div>
      </div>

    <div class="container">
        <div class="content">
          <div class="search-bar mb-3">
            
          </div>

          <div class="vehicle-list bg-white rounded-lg p-4 shadow-md">
            <h2 class="text-lg font-bold mb-3 text-gray-700 flex items-center gap-2">
              <i class="fas fa-list"></i> Lista de Mantenimientos de reparaciones...
            </h2>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden fade-in">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-700 to-gray-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-tag mr-2"></i>Modelo
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                placa 
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Tipo de Mantenimiento
                            </th>
                             <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Tipo de daño
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Fecha de reparacion
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                               Descripcion de daño
                            </th>
                             <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                               Reparaciones realizadas 
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                               Reparado por
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                               Costo
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php 
                        $contador = 1;
                        $colores = [
                            'from-blue-400 to-blue-600',
                            'from-green-400 to-green-600',
                            'from-purple-400 to-purple-600',
                            'from-pink-400 to-pink-600',
                            'from-indigo-400 to-indigo-600',
                            'from-red-400 to-red-600'
                        ];
                        while ($row = $ResulReparaciones->fetch_assoc()): 
                            $colorIndex = ($contador - 1) % count($colores);
                            $gradiente = $colores[$colorIndex];
                        ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br <?= $gradiente ?> text-white font-bold text-sm shadow-md">
                                        <?= $contador++ ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        
                                        <div class="ml-4">
                                            <p class="text-sm font-bold text-gray-900"><?= $row['modelo'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                 <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['placa'] ?></div>
                                </td>
                                 <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['tipo_mantenimiento'] ?></div>
                                </td>
                                 <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['tipo_danio'] ?></div>
                                </td>
                                 <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['fecha_reparacion'] ?></div>
                                </td>
                                 <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['descripcion_danio'] ?></div>
                                </td>
                                 <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['reparaciones_realizadas'] ?></div>
                                </td>
                                 <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['reparado_por'] ?></div>
                                </td>
                                 <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?= $row['costo_reparacion'] ?></div>
                                </td>
                                
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
            
          </div>
        </div>
    </div>
  </div>


  
<!-- Modal Registrar Nuevo Cambio de Aceite -->
<div id="modalCambioAceite" 
     class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50 overflow-y-auto">
  <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6 my-10 max-h-[80vh] overflow-y-auto">
    <h2 class="text-xl font-bold mb-4 text-gray-700">Registrar Nuevo Cambio de Aceite</h2>

    <form id="formCambioAceite" method="POST" action="registrar_cambio_aceite.php">
      <input type="hidden" id="id_mantenimiento" name="id_mantenimiento">
      <input type="hidden" id="id_vehiculo" name="id_vehiculo">
      
      <div class="mb-3">
        <label class="block text-gray-600 font-semibold">Fecha de registro:</label>
        <input type="date" id="Fecha" name="Fecha" class="w-full border rounded p-2" required>
      </div>

      <div class="mb-3">
        <label class="block text-gray-600 font-semibold">Kilometraje actual:</label>
        <input type="number" id="kilometraje_actual" name="kilometraje_actual" class="w-full border rounded p-2" required>
      </div>

      <div class="mb-3">
        <label class="block text-gray-600 font-semibold">Próximo cambio (km):</label>
        <input type="number" id="proximo_cambio_km" name="proximo_cambio_km" class="w-full border rounded p-2" required>
      </div>

      <div class="mb-3">
        <label class="block text-gray-600 font-semibold">Tipo de aceite:</label>
        <input type="text" name="tipo_aceite" class="w-full border rounded p-2" required>
      </div>

      <div class="mb-3">
        <label class="block text-gray-600 font-semibold">Realizado por:</label>
        <input type="text" name="Realizado_por" class="w-full border rounded p-2" required>
      </div>

      <div class="mb-3">
        <label class="block text-gray-600 font-semibold">Teléfono:</label>
        <input type="text" name="telefono" class="w-full border rounded p-2" required>
      </div>

      <div class="mb-3">
        <label class="block text-gray-600 font-semibold">Costo del aceite:</label>
        <input type="number" step="0.01" name="costo_aceite" class="w-full border rounded p-2" required>
      </div>

      <div class="mb-3">
        <label class="block text-gray-600 font-semibold">Observaciones:</label>
        <textarea name="observaciones" class="w-full border rounded p-2 resize-none" rows="3" required></textarea>
      </div>

      <div class="flex justify-end space-x-3">
        <button type="button" onclick="cerrarModalCambioAceite()" 
                class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">
          Cancelar
        </button>
        <button type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
          Guardar
        </button>
      </div>
    </form>
  </div>
</div>





<script>
function abrirModalCambioAceite(idMantenimiento, idVehiculo) {
  fetch('obtener_kilometraje.php?id_mantenimiento=' + idMantenimiento)
    .then(res => res.json())
    .then(data => {
      // Asignar valores al formulario
      document.getElementById('id_mantenimiento').value = idMantenimiento;
      document.getElementById('id_vehiculo').value = data.id_vehiculo;
      document.getElementById('kilometraje_actual').value = data.proximo_cambio_km || '';
      document.getElementById('proximo_cambio_km').value = (data.proximo_cambio_km) ? parseInt(data.proximo_cambio_km) + 5000 : '';
      
      // Mostrar modal
      document.getElementById('modalCambioAceite').classList.remove('hidden');
      document.getElementById('modalCambioAceite').classList.add('flex');
    });
}

function cerrarModalCambioAceite() {

      
  document.getElementById('modalCambioAceite').classList.add('hidden');
  document.getElementById('modalCambioAceite').classList.remove('flex');
}



function abrirModalCambioBateria() {
  

    document.getElementById('modalCambioBateria').classList.remove('hidden');
      document.getElementById('modalCambioBateria').classList.add('flex');
 
  
}

function cerrarModalCambioBateria() {
  document.getElementById('modalCambioBateria').classList.add('hidden');
  document.getElementById('modalCambioBateria').classList.remove('flex');
}
</script>




<script>




  // Mostrar/Ocultar formulario
  document.getElementById('btnMostrarForm').addEventListener('click', function() {
    const form = document.getElementById('formContainer');
    form.classList.toggle('hidden');
    form.classList.toggle('animate-fadeIn');
  });

  // Cancelar formulario
  document.getElementById('btnCancelar').addEventListener('click', function() {
    const form = document.getElementById('formContainer');
    form.classList.add('hidden');
    document.getElementById('vehicleForm').reset();
    document.querySelectorAll('.section-mantenimiento').forEach(section => {
      section.classList.add('hidden');
    });
  });

  // Mostrar sección según tipo de mantenimiento
  document.getElementById('tipoMantenimiento').addEventListener('change', function() {
    const seccionAceite = document.getElementById('seccionAceite');
    const seccionReparacion = document.getElementById('seccionReparacion');
    
    // Ocultar todas las secciones
    seccionAceite.classList.add('hidden');
    seccionReparacion.classList.add('hidden');
    
    // Deshabilitar todos los campos
    seccionAceite.querySelectorAll('input, textarea, select').forEach(el => el.removeAttribute('required'));
    seccionReparacion.querySelectorAll('input, textarea, select').forEach(el => el.removeAttribute('required'));
    
    // Mostrar la sección correspondiente
    if (this.value === 'cambio_aceite') {
      seccionAceite.classList.remove('hidden');
      seccionAceite.classList.add('animate-fadeIn');
      // Hacer obligatorios los campos principales
      seccionAceite.querySelector('[name="fecha_cambio_aceite"]').setAttribute('required', 'required');
      seccionAceite.querySelector('[name="kilometraje_actual"]').setAttribute('required', 'required');
    } else if (this.value === 'reparacion') {
      seccionReparacion.classList.remove('hidden');
      seccionReparacion.classList.add('animate-fadeIn');
      // Hacer obligatorios los campos principales
      seccionReparacion.querySelector('[name="tipo_danio"]').setAttribute('required', 'required');
      seccionReparacion.querySelector('[name="fecha_reparacion"]').setAttribute('required', 'required');
      seccionReparacion.querySelector('[name="descripcion_danio"]').setAttribute('required', 'required');
    
    }
  });
</script>

<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .animate-fadeIn {
    animation: fadeIn 0.4s ease-in-out;
  }
  
  .form-control:focus, .form-select:focus {
    outline: none;
  }
  
  .search-bar {
    position: relative;
  }
</style>

</body>
</html>