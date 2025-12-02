<?php
session_start();

include "../seguridad.php";
require "../conexion.php";

$sql = " SELECT u.id_usuario, u.nombre, u.usuario, u.clave, u.correo, u.id_tipo, t.nombre_tipo AS tipo_usuario
         From usuarios u
         JOIN tipos_usuario t ON u.id_tipo = t.id_tipo";

$resultado = $conn->query($sql);

$sqlTipos = "SELECT * FROM tipos_usuario";
$resultadoTipos = $conn->query($sqlTipos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
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
        .user-badge {
            transition: all 0.3s ease;
        }
        .user-badge:hover {
            transform: scale(1.05);
        }
        .modal-content {
            border-radius: 1rem;
            border: none;
        }
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 1rem 1rem 0 0;
        }
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php include '../menu.php' ?>

<?php if (isset($_GET['eliminado']) && $_GET['eliminado'] == 1): ?>
<script>
Swal.fire({
    title: 'Usuario eliminado',
    text: 'El usuario fue eliminado correctamente.',
    icon: 'success',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Aceptar'
});
</script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
<script>
Swal.fire({
    title: 'Acción no permitida',
    text: 'No puedes eliminar tu propio usuario mientras estás conectado.',
    icon: 'error',
    confirmButtonColor: '#d33',
    confirmButtonText: 'Aceptar'
});
</script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 2): ?>
<script>
Swal.fire({
    title: 'Error',
    text: 'Hubo un problema al eliminar el usuario.',
    icon: 'error',
    confirmButtonColor: '#d33',
    confirmButtonText: 'Aceptar'
});
</script>
<?php endif; ?>

<script>
window.onload = function() {
    if (window.history && window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
};
</script>



<div class="p-4 sm:ml-64">
    <div class="h-16 sm:h-20"></div>

    <div class="max-w-7xl mx-auto">
        <!-- Header mejorado -->
        <div class="bg-gradient-to-r from-gray-700 to-gray-700 rounded-lg shadow-lg p-6 mb-6 fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                        <i class="fas fa-users"></i>
                        Gestión de Usuarios
                    </h1>
                    <p class="text-purple-100 mt-2">Administra y controla todos los usuarios del sistema</p>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <p class="text-white text-sm">Total de usuarios</p>
                        <p class="text-3xl font-bold text-white"><?= $resultado->num_rows ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón agregar usuario -->
        <div class="mb-6 fade-in">
            <button class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105" data-bs-toggle="modal" data-bs-target="#ModalRegUsuario">
                <i class="fa-solid fa-user-plus mr-2"></i>
                Agregar Nuevo Usuario
            </button>
        </div>

        <!-- Tabla mejorada -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden fade-in">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-700 to-gray-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-user mr-2"></i>Nombre
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-at mr-2"></i>Usuario
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-envelope mr-2"></i>Email
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-shield-alt mr-2"></i>Tipo de Usuario
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-cog mr-2"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php 
                        $contador = 1;
                        while ($row = $resultado->fetch_assoc()): 
                            // Colores para tipos de usuario
                            $tipoClasses = 'bg-blue-100 text-blue-800';
                            if ($row['tipo_usuario'] == 'Administrador') {
                                $tipoClasses = 'bg-purple-100 text-purple-800';
                            } elseif ($row['tipo_usuario'] == 'Usuario') {
                                $tipoClasses = 'bg-green-100 text-green-800';
                            }
                        ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 text-white font-bold text-sm shadow-md">
                                        <?= $contador++ ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center shadow-md">
                                            <i class="fas fa-user text-white text-lg"></i>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-bold text-gray-900"><?= $row['nombre'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-at text-gray-400 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-900"><?= $row['usuario'] ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                        <span class="text-sm text-gray-600"><?= $row['correo'] ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="user-badge inline-flex items-center px-4 py-2 rounded-full text-xs font-bold <?= $tipoClasses ?> shadow-sm">
                                        <i class="fas fa-shield-alt mr-2"></i>
                                        <?= $row['tipo_usuario'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:scale-110 shadow-md" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#ModalEditarUsuario" 
                                            data-id="<?= $row["id_usuario"] ?>" 
                                            data-nombre="<?= $row["nombre"] ?>" 
                                            data-usuario="<?= $row["usuario"] ?>" 
                                            data-email="<?= $row["correo"] ?>" 
                                            data-tipo="<?= $row["id_tipo"] ?>"
                                            title="Editar">
                                            <i class="fa-solid fa-edit mr-1"></i>
                                            Editar
                                        </button>
                                        <button class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white text-sm font-semibold rounded-lg transition-all duration-200 hover:scale-110 shadow-md" 
                                            onclick="event.preventDefault(); confirmarEliminacion(<?= $row['id_usuario'] ?>)"
                                            title="Eliminar">
                                            <i class="fa-solid fa-trash mr-1"></i>
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer info -->
        <div class="mt-6 text-center text-gray-600 text-sm">
            <p><i class="fas fa-info-circle mr-2"></i>Gestiona los permisos y accesos de cada usuario del sistema</p>
        </div>
    </div>
</div>

<!-- Modal Agregar Usuario -->
<div class="modal fade" id="ModalRegUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title flex items-center gap-2" id="exampleModalLabel">
                    <i class="fas fa-user-plus"></i>
                    Agregar Nuevo Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="validar.php" method="POST">
                    <div class="mb-4">
                        <label for="nombre" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-user mr-2 text-purple-600"></i>Nombre Completo
                        </label>
                        <input type="text" class="form-control rounded-lg border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-4">
                        <label for="usuario" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-at mr-2 text-purple-600"></i>Usuario
                        </label>
                        <input type="text" class="form-control rounded-lg border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-4">
                        <label for="correo" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-envelope mr-2 text-purple-600"></i>Correo Electrónico
                        </label>
                        <input type="email" class="form-control rounded-lg border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200" id="correo" name="correo" required>
                    </div>
                    <div class="mb-4">
                        <label for="clave" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-lock mr-2 text-purple-600"></i>Contraseña
                        </label>
                        <input type="password" class="form-control rounded-lg border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200" id="clave" name="clave" required>
                    </div>
                    <div class="mb-4">
                        <label for="nombre_tipo" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-shield-alt mr-2 text-purple-600"></i>Tipo de Usuario
                        </label>
                        <select class="form-control rounded-lg border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200" name="id_tipo" id="nombre_tipo" required>
                            <option value="">Seleccione un tipo</option>
                            <?php 
                            $resultadoTipos->data_seek(0);
                            while ($row = $resultadoTipos->fetch_assoc()): ?>
                                <option value="<?= $row['id_tipo'] ?>"><?= $row['nombre_tipo'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn btn-primary flex-1 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 border-0 rounded-lg py-2 font-semibold">
                            <i class="fas fa-save mr-2"></i>Guardar Usuario
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

<!-- Modal Editar Usuario -->
<?php
$sqlTipos = "SELECT id_tipo, nombre_tipo FROM tipos_usuario";
$resultadoTipos = $conn->query($sqlTipos);
?>

<div class="modal fade" id="ModalEditarUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title flex items-center gap-2" id="exampleModalLabel">
                    <i class="fas fa-edit"></i>
                    Editar Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-4">
                <form action="Editar.php" method="POST">
                    <input type="hidden" id="edit_idusuario" name="id_usuario">

                    <div class="mb-4">
                        <label for="edit_nombre" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-user mr-2 text-purple-600"></i>Nombre Completo
                        </label>
                        <input type="text" class="form-control rounded-lg border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200" id="edit_nombre" name="nombre" required>
                    </div>

                    <div class="mb-4">
                        <label for="edit_usuario" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-at mr-2 text-purple-600"></i>Usuario
                        </label>
                        <input type="text" class="form-control rounded-lg border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200" id="edit_usuario" name="usuario" required>
                    </div>

                    <div class="mb-4">
                        <label for="edit_email" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-envelope mr-2 text-purple-600"></i>Correo Electrónico
                        </label>
                        <input type="email" class="form-control rounded-lg border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200" id="edit_email" name="correo" required>
                    </div>

                    <div class="mb-4">
                        <label for="edit_tipo_usuario" class="form-label font-semibold text-gray-700">
                            <i class="fas fa-shield-alt mr-2 text-purple-600"></i>Tipo de Usuario
                        </label>
                        <select class="form-control rounded-lg border-gray-300 focus:border-purple-500 focus:ring focus:ring-purple-200" name="id_tipo" id="edit_tipo_usuario" required>
                            <option value="">Seleccione un tipo</option>
                            <?php while ($row = $resultadoTipos->fetch_assoc()): ?>
                                <option value="<?= $row['id_tipo'] ?>"><?= $row['nombre_tipo'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="btn btn-primary flex-1 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 border-0 rounded-lg py-2 font-semibold">
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

<script>
var editModal = document.getElementById('ModalEditarUsuario');

editModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    
    var id = button.getAttribute('data-id');
    var nombre = button.getAttribute('data-nombre');
    var usuario = button.getAttribute('data-usuario');
    var email = button.getAttribute('data-email');
    var tipo = button.getAttribute('data-tipo');

    var modalId = editModal.querySelector('#edit_idusuario');
    var modalNombre = editModal.querySelector('#edit_nombre');
    var modalUsuario = editModal.querySelector('#edit_usuario');
    var modalEmail = editModal.querySelector('#edit_email');
    var modalTipo = editModal.querySelector('#edit_tipo_usuario');

    modalId.value = id;
    modalNombre.value = nombre;
    modalUsuario.value = usuario;
    modalEmail.value = email;
    modalTipo.value = tipo;
});

function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Eliminar usuario?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'eliminar.php?id_usu=' + id;
        }
    });
}
</script>

</body>
</html>



