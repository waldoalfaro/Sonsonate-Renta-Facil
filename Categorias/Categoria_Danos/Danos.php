<?php
include '../../conexion.php';
include '../../seguridad.php';

// Número de registros por página
$registros_por_pagina = 5;

// Página actual (si no existe en GET, se pone en 1)
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;

// Calcular el OFFSET
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Contar el total de registros
$total_result = $conn->query("SELECT COUNT(*) AS total FROM categorias_dano");
$total_fila = $total_result->fetch_assoc();
$total_registros = $total_fila['total'];

// Calcular total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Obtener los registros de la página actual
$sql = "SELECT * FROM categorias_dano ORDER BY id_categoria_dano DESC LIMIT $registros_por_pagina OFFSET $offset";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Daños</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        .damage-badge {
            transition: all 0.3s ease;
        }
        .damage-badge:hover {
            transform: scale(1.05);
        }
        .modal-content {
            border-radius: 1rem;
            border: none;
        }
        .modal-header {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            border-radius: 1rem 1rem 0 0;
        }
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
        .pagination .page-link {
            border-radius: 0.5rem;
            margin: 0 0.25rem;
            border: 2px solid #e5e7eb;
            color: #374151;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .pagination .page-link:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            border-color: #dc2626;
            transform: translateY(-2px);
        }
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            border-color: #dc2626;
        }
    </style>
</head>
<body class="bg-gray-50">

<?php include '../../menu.php'; ?>

<div class="p-4 sm:ml-64">
    <div class="max-w-7xl mx-auto">
        <!-- Header mejorado -->
        <div class="bg-gradient-to-r from-red-600 to-red-800 rounded-lg shadow-lg p-6 mb-6 fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                        <i class="fas fa-exclamation-triangle"></i>
                        Gestión de Daños en Vehículos
                    </h1>
                    <p class="text-red-100 mt-2">Administra y registra los diferentes tipos de daños según ubicación</p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <p class="text-white text-sm">Total de daños</p>
                        <p class="text-3xl font-bold text-white"><?= $total_registros ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón agregar daño -->
        <?php if ($tipo == 'Administrador'): ?>
        <div class="mb-6 fade-in">
            <button class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105" data-bs-toggle="modal" data-bs-target="#ModalRegDano">
                <i class="fa-solid fa-plus mr-2"></i>
                Agregar Nuevo Daño
            </button>
        </div>
        <?php endif; ?>

        <!-- Tabla mejorada -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden fade-in">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-700 to-gray-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-map-marker-alt mr-2"></i>Ubicación del Daño
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-tools mr-2"></i>Tipo de Daño
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-toggle-on mr-2"></i>Estado
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-calendar mr-2"></i>Fecha Registro
                            </th>
                            <?php if ($tipo == 'Administrador'): ?>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-cog mr-2"></i>Acciones
                            </th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php 
                        $contador = $offset + 1;
                        $iconos = [
                            'fas fa-car-crash',
                            'fas fa-wrench',
                            'fas fa-paint-roller',
                            'fas fa-wind',
                            'fas fa-bolt'
                        ];
                        while ($row = $resultado->fetch_assoc()): 
                            $iconIndex = ($contador - 1) % count($iconos);
                            $icono = $iconos[$iconIndex];
                        ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-red-400 to-red-600 text-white font-bold text-sm shadow-md">
                                        <?= $contador++ ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-red-400 to-red-600 rounded-lg flex items-center justify-center shadow-md">
                                            <i class="<?= $icono ?> text-white text-lg"></i>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-bold text-gray-900"><?= htmlspecialchars($row['ubicacion_dano']) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-tools text-gray-400 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-900"><?= htmlspecialchars($row['tipo_dano']) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <?php if ($row['estado'] == 1): ?>
                                        <span class="damage-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 shadow-sm">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Activo
                                        </span>
                                    <?php else: ?>
                                        <span class="damage-badge inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800 shadow-sm">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Inactivo
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm text-gray-600">
                                        <i class="fas fa-calendar-alt mr-1 text-gray-400"></i>
                                        <?= date('d/m/Y', strtotime($row['fecha_registro'])) ?>
                                    </div>
                                </td>
                                <?php if ($tipo == 'Administrador'): ?>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <button class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:scale-110 shadow-md" 
                                        onclick="event.preventDefault(); confirmarEliminacion(<?= $row['id_categoria_dano'] ?>)"
                                        title="Eliminar">
                                        <i class="fa-solid fa-trash mr-1"></i>
                                        Eliminar
                                    </button>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación mejorada -->
        <div class="mt-6 fade-in">
            <nav aria-label="Navegación de página">
                <ul class="pagination justify-content-center">
                    <?php if ($pagina_actual > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $pagina_actual - 1 ?>">
                                <i class="fas fa-chevron-left mr-1"></i>Anterior
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <li class="page-item <?= $i == $pagina_actual ? 'active' : '' ?>">
                            <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($pagina_actual < $total_paginas): ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $pagina_actual + 1 ?>">
                                Siguiente<i class="fas fa-chevron-right ml-1"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

        <!-- Footer info -->
        <div class="mt-6 text-center text-gray-600 text-sm">
            <p><i class="fas fa-info-circle mr-2"></i>Página <?= $pagina_actual ?> de <?= $total_paginas ?> - Mostrando <?= $resultado->num_rows ?> de <?= $total_registros ?> registros</p>
        </div>
    </div>
</div>

<!-- Modal Agregar Daño -->
<div class="modal fade" id="ModalRegDano" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    Registrar Nuevo Daño
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="insertar_dano.php" method="POST">
                    <div class="mb-4">
                        <label for="ubicacion_dano" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-map-marker-alt mr-2 text-red-600"></i>Ubicación del Daño
                        </label>
                        <input type="text" class="form-control rounded-lg border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200" name="ubicacion_dano" placeholder="Ej: Puerta delantera derecha, capó..." required>
                    </div>
                    <div class="mb-4">
                        <label for="tipo_dano" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-tools mr-2 text-red-600"></i>Tipo de Daño
                        </label>
                        <input type="text" class="form-control rounded-lg border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200" name="tipo_dano" placeholder="Ej: Rayón, abolladura, rotura..." required>
                    </div>
                    <div class="mb-4">
                        <label for="estado" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-toggle-on mr-2 text-red-600"></i>Estado
                        </label>
                        <select name="estado" class="form-control rounded-lg border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 border-0 rounded-lg py-2 font-semibold text-white">
                            <i class="fas fa-save mr-2"></i>Guardar Daño
                        </button>
                        <button type="button" class="btn btn-secondary flex-1 rounded-lg py-2" data-bs-dismiss="modal">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Daño -->
<div class="modal fade" id="ModalEditDano" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Editar Daño
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="editar_dano.php" method="POST">
                    <input type="hidden" name="id_categoria_dano" id="edit_id">
                    <div class="mb-4">
                        <label for="edit_ubicacion" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-map-marker-alt mr-2 text-red-600"></i>Ubicación del Daño
                        </label>
                        <input type="text" class="form-control rounded-lg border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200" name="ubicacion_dano" id="edit_ubicacion" required>
                    </div>
                    <div class="mb-4">
                        <label for="edit_tipo" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-tools mr-2 text-red-600"></i>Tipo de Daño
                        </label>
                        <input type="text" class="form-control rounded-lg border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200" name="tipo_dano" id="edit_tipo" required>
                    </div>
                    <div class="mb-4">
                        <label for="edit_estado" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-toggle-on mr-2 text-red-600"></i>Estado
                        </label>
                        <select name="estado" class="form-control rounded-lg border-gray-300 focus:border-red-500 focus:ring focus:ring-red-200" id="edit_estado">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 border-0 rounded-lg py-2 font-semibold text-white">
                            <i class="fas fa-save mr-2"></i>Guardar Cambios
                        </button>
                        <button type="button" class="btn btn-secondary flex-1 rounded-lg py-2" data-bs-dismiss="modal">
                            <i class="fas fa-times mr-2"></i>Cancelar
                        </button>
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
    title: 'Daño eliminado',
    text: 'El registro fue eliminado correctamente.',
    icon: 'success',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Aceptar'
});
</script>
<?php endif; ?>

<script>
var editModal = document.getElementById('ModalEditDano');
editModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;

    document.getElementById('edit_id').value = button.getAttribute('data-id');
    document.getElementById('edit_ubicacion').value = button.getAttribute('data-ubicacion');
    document.getElementById('edit_tipo').value = button.getAttribute('data-tipo');
    document.getElementById('edit_estado').value = button.getAttribute('data-estado');
});

function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Eliminar categoría de daños?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'eliminar_danos.php?id=' + id;
        }
    });
}
</script>

</body>
</html>