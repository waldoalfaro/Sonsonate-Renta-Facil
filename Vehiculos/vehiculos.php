<?php
session_start();

include '../conexion.php';
include '../seguridad.php';

// 🔎 Recibir filtros del formulario (si existen)
$categoria = $_GET['categoria'] ?? '';
$placa = $_GET['placa'] ?? '';

// 🔎 Consulta dinámica de vehículos
$sql = "SELECT v.*, c.nombre_categoria 
        FROM vehiculos v
        INNER JOIN categorias c ON v.id_categoria = c.id_categoria
        WHERE 1=1";

if ($placa !== '') {
    $sql .= " AND v.placa LIKE '%" . $conn->real_escape_string($placa) . "%'";
}

if ($categoria !== '') {
    $sql .= " AND v.id_categoria = " . intval($categoria);
}

$sql .= " ORDER BY v.id_vehiculo DESC";
$resultado = $conn->query($sql);

// 🔎 Consulta de categorías para llenar el select
$sqlTipos = "SELECT * FROM categorias";
$resultadoTipos = $conn->query($sqlTipos);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Vehículos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="vehiculo.css">


    <script>
window.onload = function() {
    if (window.history && window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
};
</script>
</head>
<body>
    <?php include '../menu.php'; ?>


    <div class="p-4 sm:ml-64">
            <div class="h-16 sm:h-20"></div>

        <div class="main-container">
            
            <div class="bg-gradient-to-r from-gray-700 to-gray-700 rounded-lg shadow-lg p-6 mb-6 fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                        <i class="fas fa-calendar-check"></i>
                        Gestión de Vehículos
                    </h1>
                    <p class="text-blue-100 mt-2">Administra y controla todos tus vehículos</p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <p class="text-white text-sm">Total de vehículos</p>
                        <p class="text-3xl font-bold text-white"><?= $resultado->num_rows ?></p>
                    </div>
                </div>
            </div>
        </div>
            
            <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-<?= $_SESSION['tipo_mensaje'] === 'success' ? 'success' : ($_SESSION['tipo_mensaje'] === 'info' ? 'info' : 'danger') ?> alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                <i class="fas fa-<?= $_SESSION['tipo_mensaje'] === 'success' ? 'check-circle' : ($_SESSION['tipo_mensaje'] === 'info' ? 'info-circle' : 'exclamation-triangle') ?>"></i>
                <?= $_SESSION['mensaje'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php 
                unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); 
            endif; 
            ?>

            <form class="max-w-6xl mx-auto mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
    <div class="flex flex-col md:flex-row gap-2 md:gap-4 w-full md:w-auto">
        <!-- Filtro por categoría -->
        <select name="categoria"
            class="py-3 px-4 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="">Todas las categorías</option>
            <?php
            $cats = $conn->query("SELECT id_categoria, nombre_categoria FROM categorias");
            while ($c = $cats->fetch_assoc()) {
                $selected = ($_GET['categoria'] ?? '') == $c['id_categoria'] ? 'selected' : '';
                echo "<option value='".$c['id_categoria']."' $selected>".$c['nombre_categoria']."</option>";
            }
            ?>
        </select>

        <!-- Campo búsqueda por placa -->
        <div class="relative w-full md:w-64">
            <input type="search" name="placa"
                value="<?= htmlspecialchars($_GET['placa'] ?? '') ?>"
                class="block w-full py-3 px-4 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Buscar por placa..." />

            <button type="submit"
                class="absolute right-1 top-1/2 -translate-y-1/2 px-4 py-2 text-base font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                Buscar
            </button>
        </div>
    </div>

    <!-- Botón agregar vehículo -->
    <button type="button"
        class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 text-lg font-medium transition flex items-center gap-2"
        data-bs-toggle="modal" data-bs-target="#ModalRegVehiculo">
        <i class="fas fa-plus-circle"></i> Agregar Vehículo
    </button>
    <a href="vehiculos_eliminados.php"  class="btn-action btn-delete" > 
                                    <i class="fa-solid fa-trash"></i> Vehiculos eliminados 
                                </a>
</form>     
            
            <div class="row g-4">
                <?php 
                $contador = 0;
                while ($row = $resultado->fetch_assoc()): 
                    $contador++;
                ?>
                <div class="col-lg-6 col-xl-4">
                    <div class="vehicle-card fade-in" style="animation-delay: <?= $contador * 0.1 ?>s;">
                        
                        <!-- Header de la tarjeta -->
                        <div class="card-header">
                            <h3 class="vehicle-title">
                                <?= htmlspecialchars($row['marca'] . ' ' . $row['modelo']) ?>
                            </h3>
                            <p class="vehicle-subtitle">
                                <i class="fas fa-id-card"></i> <?= htmlspecialchars($row['placa']) ?> • 
                                <i class="fas fa-calendar-alt"></i> <?= htmlspecialchars($row['anio']) ?>
                            </p>
                            
                            <!-- Badge de estado -->
                            <div class="status-badge status-<?= strtolower(str_replace(' ', '-', $row['estado'])) ?>">
                                <?= $row['estado'] ?>
                            </div>
                        </div>
                        
                        <!-- Imagen del vehículo -->
                        <div class="position-relative overflow-hidden">
                            <?php if (!empty($row['foto'])): ?>
                                <img src="../FotosSubidas/<?= htmlspecialchars($row['foto']) ?>" 
                                     alt="<?= htmlspecialchars($row['marca'] . ' ' . $row['modelo']) ?>" 
                                     class="card-image">
                            <?php else: ?>
                                <div class="no-image-placeholder">
                                    <i class="fas fa-car"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Contenido de la tarjeta -->
                        <div class="card-content">
                            
                            <!-- Precio destacado -->
                            <div class="text-center mb-3">
                                <div class="price-highlight">
                                    <i class="fas fa-dollar-sign"></i> <?= htmlspecialchars($row['precio_dia']) ?> / día
                                </div>
                            </div>
                            
                            <!-- Detalles del vehículo organizados en filas -->
                            <div class="vehicle-details">
                                <!-- Primera fila -->
                                <div class="detail-row">
                                    <div class="detail-item">
                                        <i class="fas fa-palette detail-icon"></i>
                                        <span class="detail-label">Color</span>
                                        <span class="detail-value"><?= htmlspecialchars($row['color']) ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-users detail-icon"></i>
                                        <span class="detail-label">Asientos</span>
                                        <span class="detail-value"><?= htmlspecialchars($row['asientos']) ?></span>
                                    </div>
                                </div>
                                
                                <!-- Segunda fila -->
                                <div class="detail-row">
                                    <div class="detail-item">
                                        <i class="fas fa-gas-pump detail-icon"></i>
                                        <span class="detail-label">Combustible</span>
                                        <span class="detail-value"><?= htmlspecialchars($row['combustible']) ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-snowflake detail-icon"></i>
                                        <span class="detail-label">A/C</span>
                                        <span class="detail-value">
                                            <?= $row['aire_acondicionado'] ? 
                                                '<i class="fas fa-check text-success"></i> Sí' : 
                                                '<i class="fas fa-times text-danger"></i> No' ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Tercera fila -->
                                <div class="detail-row">
                                    <div class="detail-item">
                                        <i class="fas fa-map-marker-alt detail-icon"></i>
                                        <span class="detail-label">GPS</span>
                                        <span class="detail-value"><?= htmlspecialchars($row['gps']) ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="fas fa-shield-alt detail-icon"></i>
                                        <span class="detail-label">Seguro</span>
                                        <span class="detail-value"><?= htmlspecialchars($row['seguro']) ?></span>
                                    </div>
                                </div>
                                
                               
                                
                                <!-- Quinta fila - Daños en ancho completo -->
                               
                            </div>
                            
                            <!-- Botones de acción -->
                            <div class="action-buttons">
                                <a href="#" class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#ModalEditarVehiculo" 
                                        data-id="<?= $row["id_vehiculo"] ?>" data-marca="<?= $row["marca"] ?>" data-modelo="<?= $row["modelo"] ?>" 
                                        data-color="<?= $row["color"] ?>" data-placa="<?= $row["placa"] ?>" data-anio="<?= $row["anio"] ?>"
                                        data-asientos="<?= $row["asientos"] ?>" data-foto="<?= $row["foto"] ?>" data-precio_dia="<?= $row["precio_dia"] ?>"
                                        data-combustible="<?= $row["combustible"] ?>" data-gps="<?= $row["gps"] ?>" data-seguro="<?= $row["seguro"] ?>" data-vin="<?= $row["vin"] ?>">
                                        <i class="fa-solid fa-edit"></i> Editar
                                </a>
                                <a href="#"  class="btn-action btn-delete" onclick="event.preventDefault(); confirmarEliminacion(<?= $row['id_vehiculo'] ?>)"> 
                                    <i class="fa-solid fa-trash"></i> Eliminar
                                </a>
                            </div>
                            
                            <!-- Selector de estado -->
                            <div>
                                <label class="status-label">
                                    <i class="fas fa-cog"></i> Cambiar Estado:
                                </label>
                                <select class="status-selector" 
                                        onchange="cambiarEstado(<?= $row['id_vehiculo'] ?>, this.value)"
                                        data-vehicle-id="<?= $row['id_vehiculo'] ?>">
                                    <option value="Disponible" <?= $row['estado'] == 'Disponible' ? 'selected' : '' ?>>
                                        🟢 Disponible
                                    </option>
                                    <option value="No disponible" <?= $row['estado'] == 'No disponible' ? 'selected' : '' ?>>
                                        🔴 No disponible
                                    </option>
                                    <option value="Mantenimiento" <?= $row['estado'] == 'Mantenimiento' ? 'selected' : '' ?>>
                                        🟡 Mantenimiento
                                    </option>
                                    <option value="De baja" <?= $row['estado'] == 'De baja' ? 'selected' : '' ?>>
                                        ⚫ De baja
                                    </option>
                                </select>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
                
                <?php if ($contador == 0): ?>
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-car-side" style="font-size: 4rem; color: #cbd5e1;"></i>
                        <h3 class="mt-3 text-muted">No hay vehículos registrados</h3>
                        <p class="text-muted">Comienza agregando tu primer vehículo</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
        </div>
    </div>

    <!-- Loading Spinner -->
    <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>

    
    <!-- Modal para agregar vehículo -->
    <div class="modal fade" id="ModalRegVehiculo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i> Agregar Nuevo Vehículo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <form action="ValidarVehiculo.php" method="POST" enctype="multipart/form-data">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-car text-primary"></i> Marca</label>
                            <input type="text" class="form-control" name="marca" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-tag text-success"></i> Modelo</label>
                            <input type="text" class="form-control" name="modelo" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-palette text-info"></i> Color</label>
                            <input type="text" class="form-control" name="color" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-id-card text-warning"></i> Placa</label>
                            <input type="text" class="form-control" name="placa" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-calendar-alt text-primary"></i> Año</label>
                            <input type="number" class="form-control" name="anio" min="1900" max="2099" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-users text-success"></i> Asientos</label>
                            <input type="number" class="form-control" name="asientos" min="1" max="50" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-snowflake text-info"></i> Aire Acondicionado</label>
                            <select class="form-control" name="aire" required>
                                <option value="">Seleccione</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-cog text-warning"></i> Estado</label>
                            <select class="form-control" name="estado" required>
                                <option value="">Seleccione</option>
                                <option value="Disponible">Disponible</option>
                                <option value="No disponible">No disponible</option>
                                <option value="Mantenimiento">Mantenimiento</option>
                                <option value="De baja">De baja</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-cog text-warning"></i> Categoría</label>
                            <select class="form-control" name="id_categoria" required>
                                <option value="">Seleccione un tipo</option>
                                <?php while ($row = $resultadoTipos->fetch_assoc()): ?>
                                    <option value="<?= $row['id_categoria'] ?>"><?= $row['nombre_categoria'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-users text-success"></i> Precio por día</label>
                            <input type="number" class="form-control" name="precio_dia" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-gas-pump text-info"></i> Tipo de Combustible</label>
                            <select class="form-control" name="combustible" required>
                                <option value="">Seleccione</option>
                                <option value="Gasolina">Gasolina</option>
                                <option value="Diesel">Diesel</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-map-marked-alt text-info"></i> GPS</label>
                            <select class="form-control" name="gps" required>
                                <option value="">Seleccione</option>
                                <option value="Si">Sí</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-shield-alt text-info"></i> Seguro</label>
                            <select class="form-control" name="seguro" required>
                                <option value="">Seleccione</option>
                                <option value="Si">Sí</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-hashtag text-success"></i> VIN</label>
                            <input type="number" class="form-control" name="vin" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-camera text-primary"></i> Foto Principal</label>
                            <input type="file" class="form-control" name="foto_principal" accept="image/*" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="fas fa-images text-success"></i> Galería</label>
                            <input type="file" class="form-control" name="galeria[]" accept="image/*" multiple>
                        </div>

                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-save"></i> Guardar Vehículo
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Modal para editar vehículo -->
    <div class="modal fade" id="ModalEditarVehiculo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Vehiculo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="EditarVehiculo.php" method="POST" enctype="multipart/form-data">
                      <div class="row g-3">
                        <input type="hidden" id="edit_idvehiculo" name="id_vehiculo">

                        <div class="col-md-6">
                            <label for="edit_marca" class="form-label">Marca</label>
                            <input type="text" class="form-control" id="edit_marca" name="marca" required>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_modelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="edit_modelo" name="modelo" required>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_color" class="form-label">Color</label>
                            <input type="text" class="form-control" id="edit_color" name="color" required>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_placa" class="form-label">Placa</label>
                            <input type="text" class="form-control" id="edit_placa" name="placa" required>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_anio" class="form-label">Año</label>
                            <input type="number" class="form-control" id="edit_anio" name="anio" required>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_asientos" class="form-label">Asientos</label>
                            <input type="number" class="form-control" id="edit_asientos" name="asientos"  min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_precio_dia" class="form-label">precio por dia </label>
                            <input type="number" class="form-control" id="edit_precio_dia" name="precio_dia" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_combustible" class="form-label">Combustible</label>
                            <select class="form-control" id="edit_combustible"  name="combustible" required>
                                        <option value="">Seleccione</option>
                                        <option value="Gasolina">Gasolina</option>
                                        <option value="Diesel">Diesel</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_gps" class="form-label">Gps</label>
                            <select class="form-control" id="edit_gps" name="gps" required>
                                        <option value="">Seleccione</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_seguro" class="form-label">Seguro</label>
                            <select class="form-control" id="edit_seguro" name="seguro" required>
                                        <option value="">Seleccione</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_vin" class="form-label">Vin</label>
                            <input type="text" class="form-control" id="edit_vin" name="vin" required>
                        </div>
                        

                        <input type="hidden" name="foto_actual" id="edit_foto_actual">

                        <!-- Campo de archivo -->
                        <div class="col-12">
                            <label for="edit_foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="edit_foto" name="foto" accept="image/*">
                            <br>
                            <img id="preview_foto" src="" alt="Vista previa" width="120" style="display:none; border:1px solid #ccc; padding:3px;">
                        </div>

                      <div class="col-12 mt-3">
                        <label class="form-label fw-bold">Galería Actual</label>
                        <div id="galeria_fotos" class="d-flex gap-2 flex-wrap"></div>
                    </div>

                        <!-- Subir nuevas fotos -->
                        <div class="col-12 mt-2">
                            <label class="form-label">Agregar fotos nuevas</label>
                            <input type="file" class="form-control" name="fotos_extra[]" multiple accept="image/*">
                        </div>
                                        
                      </div>
                      <div class="mt-3">
                        <button type="submit" class="btn btn-warning">Guardar cambios</button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if (isset($_GET['eliminado']) && $_GET['eliminado'] == 1): ?>
    <script>
    Swal.fire({
        title: 'Vehiculo eliminado',
        text: 'El vehiculo fue eliminado correctamente.',
        icon: 'success',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Aceptar'
    });
    </script>
    <?php endif; ?>
    
    <script>
        // Función para cambiar estado con efectos visuales
        function cambiarEstado(idVehiculo, nuevoEstado) {
            // Mostrar spinner
            document.querySelector('.loading-spinner').style.display = 'block';
            
            // Encontrar la tarjeta correspondiente
            const selector = document.querySelector(`select[data-vehicle-id="${idVehiculo}"]`);
            const card = selector.closest('.vehicle-card');
            const badge = card.querySelector('.status-badge');
            
            fetch('cambiar_estado.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'id=' + idVehiculo + '&estado=' + nuevoEstado
            })
            .then(response => response.text())
            .then(data => {
                // Ocultar spinner
                document.querySelector('.loading-spinner').style.display = 'none';
                
                // Actualizar badge visualmente
                const statusClass = 'status-' + nuevoEstado.toLowerCase().replace(' ', '-');
                badge.className = 'status-badge ' + statusClass;
                badge.textContent = nuevoEstado;
                
                // Efecto de éxito
                card.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    card.style.transform = '';
                }, 300);
                
                // Notificación de éxito (puedes implementar una función showNotification si la tienes)
                console.log('Estado actualizado correctamente');
            })
            .catch(error => {
                document.querySelector('.loading-spinner').style.display = 'none';
                console.error('Error al actualizar el estado:', error);
            });
        }

        // Event listener para el modal de editar
        var editModal = document.getElementById('ModalEditarVehiculo');

        editModal.addEventListener('show.bs.modal', function (event) {
           
            var button = event.relatedTarget;

            // Tomar atributos del botón
            var id = button.getAttribute('data-id');
            var marca = button.getAttribute('data-marca');
            var modelo = button.getAttribute('data-modelo');
            var color = button.getAttribute('data-color');
            var placa = button.getAttribute('data-placa');
            var anio = button.getAttribute('data-anio');
            var asientos = button.getAttribute('data-asientos');
            var foto = button.getAttribute('data-foto');
            var precio_dia = button.getAttribute('data-precio_dia');
            var combustible = button.getAttribute('data-combustible');
            var gps = button.getAttribute('data-gps');
            var seguro = button.getAttribute('data-seguro');
            var vin = button.getAttribute('data-vin');

            // Referencias a inputs
            var modalId = editModal.querySelector('#edit_idvehiculo');
            var modalmarca = editModal.querySelector('#edit_marca');
            var modalmodelo = editModal.querySelector('#edit_modelo');
            var modalcolor = editModal.querySelector('#edit_color');
            var modalplaca = editModal.querySelector('#edit_placa');
            var modalanio = editModal.querySelector('#edit_anio');
            var modalasientos = editModal.querySelector('#edit_asientos');
            var modalfoto = editModal.querySelector('#edit_foto_actual');
            var modalprecio_dia = editModal.querySelector('#edit_precio_dia');
            var modalcombustible = editModal.querySelector('#edit_combustible');
            var modalgps = editModal.querySelector('#edit_gps');
            var modalseguro = editModal.querySelector('#edit_seguro');
            var modalvin = editModal.querySelector('#edit_vin');

            

                   
            // Mostrar preview de foto
            var preview = document.getElementById('preview_foto');
            if (foto && foto !== '') {
                preview.src = '../FotosSubidas/' + foto;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }

            // Asignar valores
            modalId.value = id;
            modalmarca.value = marca;
            modalmodelo.value = modelo;
            modalcolor.value = color;
            modalplaca.value = placa;
            modalanio.value = anio;
            modalasientos.value = asientos;
            modalfoto.value = foto;
            modalprecio_dia.value = precio_dia;
            modalcombustible.value = combustible;
            modalgps.value = gps;
            modalseguro.value = seguro;
            modalvin.value = vin;

             cargarGaleria(id);
            // -------------- CARGAR GALERÍA ----------------//
            // Cargar galería de fotos adicionales por AJAX



                    });

        
function cargarGaleria(idVehiculo) {
    fetch("obtener_fotos.php?id_vehiculo=" + idVehiculo)
        .then(response => response.json())
        .then(data => {
            let contenedor = document.getElementById("galeria_fotos");
            contenedor.innerHTML = "";

            if (data.length === 0) {
                contenedor.innerHTML = "<p class='text-muted'>No hay fotos adicionales.</p>";
                return;
            }

            data.forEach(f => {
                contenedor.innerHTML += `
                    <div style="position: relative;">
                        <img src="../FotosSubidas/${f.foto}" width="100" class="border rounded">
                        <button type="button" class="btn btn-danger btn-sm" 
                            style="position:absolute; top:0; right:0;"
                            onclick="eliminarFoto(${f.id})">
                            X
                        </button>
                    </div>
                `;
            });
        });
}

function eliminarFoto(idFoto) {
    Swal.fire({
        title: "¿Eliminar esta foto?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {

            fetch("eliminar_foto.php?id=" + idFoto)
                .then(response => response.text())
                .then(data => {

                    Swal.fire({
                        title: "Eliminada",
                        text: "La foto fue eliminada correctamente.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload();
                    });

                });
        }
    });
}


        function confirmarEliminacion(id) {
            Swal.fire({
                title: '¿Eliminar Vehiculo?',
                text: 'Esta acción no se puede deshacer.',
                text: 'Puedes ver el historial de los vehiculos eliminados',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar', 
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'eliminar_vehiculo.php?id_vehiculo=' + id;
                }
            });
        }


        // Script para manejar ubicaciones y tipos de daño en el modal de agregar
        document.getElementById('ubicacion_dano').addEventListener('change', function() {
            var ubicacion = this.value;
            var tipoSelect = document.getElementById('tipo_dano');

            // Limpiamos las opciones anteriores
            tipoSelect.innerHTML = '<option value="">Seleccione tipo de daño</option>';

            if(ubicacion) {
                // Llamada AJAX a PHP que devuelve los tipos de daño según la ubicación
                fetch('get_tipos_dano.php?ubicacion=' + encodeURIComponent(ubicacion))
                .then(response => response.json())
                .then(data => {
                    data.forEach(function(tipo) {
                        var option = document.createElement('option');
                        option.value = tipo;
                        option.text = tipo;
                        tipoSelect.add(option);
                    });
                });
            }
        });

        // Animaciones al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Aplicar animaciones escalonadas a las tarjetas
            const cards = document.querySelectorAll('.vehicle-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
        });




document.getElementById('ubicacion_dano').addEventListener('change', mostrarLista);
document.getElementById('tipo_dano').addEventListener('change', mostrarLista);

function mostrarLista() {
    let ubicaciones = Array.from(document.getElementById('ubicacion_dano').selectedOptions).map(o => o.value);
    let tipos = Array.from(document.getElementById('tipo_dano').selectedOptions).map(o => o.value);

    let lista = document.getElementById('lista_selecciones');
    lista.innerHTML = ''; // limpiar antes de mostrar

    ubicaciones.forEach(u => {
        let li = document.createElement('li');
        li.className = "list-group-item";
        li.textContent = "Ubicación: " + u;
        lista.appendChild(li);
    });

    tipos.forEach(t => {
        let li = document.createElement('li');
        li.className = "list-group-item";
        li.textContent = "Tipo: " + t;
        lista.appendChild(li);
    });
}
    </script>


<?php if (isset($_GET['error']) && $_GET['error'] === 'relacion'): ?>
<script>
Swal.fire({
  icon: 'error',
  title: 'No se puede eliminar',
  text: 'El vehículo tiene categorías, mantenimientos o reservaciones asignadas.',
  confirmButtonColor: '#d33',
  confirmButtonText: 'Entendido'
});
</script>
<?php endif; ?>

<?php if (isset($_GET['eliminado']) && $_GET['eliminado'] == 1): ?>
<script>
Swal.fire({
  icon: 'success',
  title: 'Vehículo eliminado',
  text: 'El vehículo fue eliminado correctamente.',
  timer: 1500,
  showConfirmButton: false
});
</script>

<?php endif; ?>

<script>
if (window.history.replaceState) {
  const url = new URL(window.location);
  url.search = ''; 
  window.history.replaceState({}, document.title, url);
}
</script>


<?php if (isset($_GET['registrado']) && $_GET['registrado'] == 1): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
  icon: 'success',
  title: '¡Vehículo registrado!',
  text: 'El vehículo se guardó correctamente.',
  showConfirmButton: false,
  timer: 1800
});
setTimeout(() => {
  window.location.href = 'vehiculos.php';
}, 1800);
</script>
<?php endif; ?>


<?php if (isset($_GET['duplicado']) && $_GET['duplicado'] == 1): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    icon: 'warning',
    title: 'Vehículo duplicado',
    text: '⚠️ Ya existe un vehículo con la placa <?= htmlspecialchars($_GET["placa"]) ?>.',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Entendido'
}).then(() => {
    window.history.replaceState(null, '', window.location.pathname);
});
</script>
<?php endif; ?>
</body>
</html>

