<?php 

include '../../conexion.php';
include '../../seguridad.php';

$sql = "SELECT * FROM categorias";
$resultado = $conn->query($sql);

?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
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
        .category-card {
            transition: all 0.3s ease;
        }
        .category-card:hover {
            transform: translateY(-5px);
        }
        .modal-content {
            border-radius: 1rem;
            border: none;
        }
        .modal-header {
            background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
            color: white;
            border-radius: 1rem 1rem 0 0;
        }
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
    </style>
</head>
<body class="bg-gray-50">

<?php include '../../menu.php'; ?>

<div class="p-4 sm:ml-64">
        <div class="h-16 sm:h-20"></div>

    <div class="max-w-7xl mx-auto">
        <!-- Header mejorado -->
        <div class="bg-gradient-to-r from-orange-500 to-amber-600 rounded-lg shadow-lg p-6 mb-6 fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                        <i class="fas fa-layer-group"></i>
                        Gestión de Categorías de Vehículos
                    </h1>
                    <p class="text-orange-100 mt-2">Administra las categorías y clasificaciones de los vehículos</p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <p class="text-white text-sm">Total de categorías</p>
                        <p class="text-3xl font-bold text-white"><?= $resultado->num_rows ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón agregar categoría -->
        <?php if ($tipo == 'Administrador'): ?>
        <div class="mb-6 fade-in">
            <button class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105" data-bs-toggle="modal" data-bs-target="#ModalRegCategoria">
                <i class="fa-solid fa-layer-group mr-2"></i>
                Agregar Nueva Categoría
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
                                <i class="fas fa-tag mr-2"></i>Nombre de Categoría
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-align-left mr-2"></i>Descripción
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
                        $contador = 1;
                        $colores = [
                            'from-blue-400 to-blue-600',
                            'from-green-400 to-green-600',
                            'from-purple-400 to-purple-600',
                            'from-pink-400 to-pink-600',
                            'from-indigo-400 to-indigo-600',
                            'from-red-400 to-red-600'
                        ];
                        while ($row = $resultado->fetch_assoc()): 
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
                                        <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br <?= $gradiente ?> rounded-lg flex items-center justify-center shadow-md">
                                            <i class="fas fa-layer-group text-white text-lg"></i>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-bold text-gray-900"><?= $row['nombre_categoria'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 max-w-md">
                                        <?= $row['descripcion'] ?>
                                    </div>
                                </td>
                                <?php if ($tipo == 'Administrador'): ?>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:scale-110 shadow-md" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#ModalEditCategoria" 
                                            data-id_categoria="<?= $row["id_categoria"] ?>" 
                                            data-nombre_categoria="<?= $row["nombre_categoria"] ?>" 
                                            data-descripcion="<?= $row["descripcion"] ?>"
                                            title="Editar">
                                            <i class="fa-solid fa-edit mr-1"></i>
                                            Editar
                                        </button>
                                        <button class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:scale-110 shadow-md" 
                                            onclick="event.preventDefault(); confirmarEliminacion(<?= $row['id_categoria'] ?>)"
                                            title="Eliminar">
                                            <i class="fa-solid fa-trash mr-1"></i>
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer info -->
        <div class="mt-6 text-center text-gray-600 text-sm">
            <p><i class="fas fa-info-circle mr-2"></i>Organiza y clasifica los vehículos por categorías para una mejor gestión</p>
        </div>
    </div>
</div>

<!-- Modal Agregar Categoría -->
<div class="modal fade" id="ModalRegCategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title flex items-center gap-2" id="exampleModalLabel">
                    <i class="fas fa-plus-circle"></i>
                    Registrar Nueva Categoría
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="validar_categoria_vehiculo.php" method="POST">
                    <div class="mb-4">
                        <label for="nombre_categoria" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-tag mr-2 text-orange-600"></i>Nombre de la Categoría
                        </label>
                        <input type="text" class="form-control rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200" id="nombre_categoria" name="nombre_categoria" placeholder="Ej: SUV, Sedán, Pickup..." required>
                    </div>
                    <div class="mb-4">
                        <label for="descripcion" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-align-left mr-2 text-orange-600"></i>Descripción
                        </label>
                        <textarea class="form-control rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200" id="descripcion" name="descripcion" rows="3" placeholder="Describe las características de esta categoría..." required></textarea>
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="btn btn-warning flex-1 bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 border-0 rounded-lg py-2 font-semibold text-white">
                            <i class="fas fa-save mr-2"></i>Guardar Categoría
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

<!-- Modal Editar Categoría -->
<div class="modal fade" id="ModalEditCategoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title flex items-center gap-2" id="exampleModalLabel">
                    <i class="fas fa-edit"></i>
                    Editar Categoría
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <form action="Editar_categoria_vehiculo.php" method="POST">
                    <input type="hidden" id="edit_idcategoria" name="id_categoria">

                    <div class="mb-4">
                        <label for="edit_nombre_categoria" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-tag mr-2 text-orange-600"></i>Nombre de la Categoría
                        </label>
                        <input type="text" class="form-control rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200" id="edit_nombre_categoria" name="nombre_categoria" required>
                    </div>

                    <div class="mb-4">
                        <label for="edit_descripcion" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-align-left mr-2 text-orange-600"></i>Descripción
                        </label>
                        <textarea class="form-control rounded-lg border-gray-300 focus:border-orange-500 focus:ring focus:ring-orange-200" id="edit_descripcion" name="descripcion" rows="3" required></textarea>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="btn btn-warning flex-1 bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 border-0 rounded-lg py-2 font-semibold text-white">
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
    title: 'Categoría eliminada',
    text: 'La categoría fue eliminada correctamente.',
    icon: 'success',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Aceptar'
});
</script>
<?php endif; ?>

<script>
var editModal = document.getElementById('ModalEditCategoria');

editModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    
    var id = button.getAttribute('data-id_categoria');
    var nombre_categoria = button.getAttribute('data-nombre_categoria');
    var descripcion = button.getAttribute('data-descripcion');

    var modalId = editModal.querySelector('#edit_idcategoria');
    var modalNombre_categoria = editModal.querySelector('#edit_nombre_categoria');
    var modalDescripcion = editModal.querySelector('#edit_descripcion');

    modalId.value = id;
    modalNombre_categoria.value = nombre_categoria;
    modalDescripcion.value = descripcion;
});

function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Eliminar categoría de vehículos?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('Eliminar_categoria.php?id_cate=' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        Swal.fire('¡Eliminado!', data.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('No se puede eliminar', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'Hubo un problema en la eliminación.', 'error');
                    console.error(error);
                });
        }
    });
}
</script>

</body>
</html>