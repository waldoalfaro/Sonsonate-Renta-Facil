<?php 
include '../conexion.php';
include '../seguridad.php';

// 🔹 Configuración de paginación
$registros_por_pagina = 2; // cantidad por página
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;

// 🔹 Calcular desde qué registro empezar
$inicio = ($pagina_actual - 1) * $registros_por_pagina;

// 🔹 Consultar las promociones limitadas por página
$sql_promociones = "SELECT * FROM promociones LIMIT $inicio, $registros_por_pagina";
$resultadoxd = $conn->query($sql_promociones);

// 🔹 Contar total de registros para saber cuántas páginas hay
$total_resultado = $conn->query("SELECT COUNT(*) AS total FROM promociones");
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
</head>
<body>
<?php include '../menu.php'; ?>

<div class="p-4 sm:ml-64">
<div class="h-16 sm:h-20"></div>
    <div class="max-w-7xl mx-auto">
        <div class="bg-gradient-to-r from-gray-700 to-gray-700 rounded-lg shadow-lg p-6 mb-6 fade-in">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                        <i class="fas fa-calendar-check"></i>
                        Gestión de promociones
                    </h1>
                    <p class="text-blue-100 mt-2">Administra y controla todas las reservaciones que quieres que aparescan en la pagina web.</p>
                </div>
            </div>
        </div> 
        <div class="mb-6 fade-in">
            <button type="button" onclick="abrirModal()" 
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r rounded-lg shadow-lg bg-gradient-to-r from-gray-600 to-gray-600 ...">
                <i class="fas fa-check-circle"></i>
                Registrar una nueva Promocion
            </button>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden fade-in">
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gradient-to-r from-gray-700 to-gray-900">
        <tr>
          <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">#</th>
          <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Imagen</th>
          <th class="px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Descripción</th>
          <th class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Acciones</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <?php 
        $contador = 1;
        while ($row = $resultadoxd->fetch_assoc()): 
        ?>
          <tr class="hover:bg-gray-50 transition-colors duration-200">
            <td class="px-4 py-4 whitespace-nowrap">
              <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-800 font-semibold text-sm">
                <?= $contador++ ?>
              </span>
            </td>

            <!-- Imagen más pequeña -->
            <td class="px-4 py-4 whitespace-nowrap">
              <div class="flex items-center justify-center">
                <?php if (!empty($row['imagen'])): ?>
                  <img src="../uploads/configuracion/<?= htmlspecialchars($row['imagen']) ?>" 
                       alt="Promo" 
                       class="w-20 h-20 object-cover rounded-lg border border-gray-300 shadow-sm">
                <?php else: ?>
                  <div class="w-20 h-20 flex items-center justify-center bg-gray-100 text-gray-400 rounded-lg border border-gray-300">
                    <i class="fas fa-car text-2xl"></i>
                  </div>
                <?php endif; ?>
              </div>
            </td>

            <td class="px-4 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">
                <?= htmlspecialchars($row['descripcion']) ?>
              </div>
            </td>

            <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium">
                <button onclick="eliminarPromocion(<?= $row['id_promocion'] ?>)" 
                        class="text-red-600 hover:text-red-800 transition flex items-center justify-center gap-1 mx-auto">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>


        <div id="modalPromociones" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 overflow-y-auto">
  <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl p-6 relative my-10 overflow-y-auto max-h-[90vh]">
    <button onclick="cerrarModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
      <i class="fas fa-times text-xl"></i>
    </button>
    
    <h2 class="text-xl font-bold mb-4 text-gray-700">
        <i class="fa-solid fa-plus"></i> Nueva promocion
    </h2>

    <form id="formCliente" method="POST" action="guardar_promocion.php" class="space-y-4" enctype="multipart/form-data">
      

     <div>
  <label class="block text-sm font-semibold text-gray-700 mb-2">
    <i class="fas fa-image text-blue-500 mr-1"></i> Seleccione Imagen
  </label>

  <input 
    type="file" 
    name="imagen" 
    accept="image/*"
    required
    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500 transition-colors">

  <!-- 🔹 Nota informativa -->
  <small class="block mt-2 text-gray-500 text-sm">
    📏 <strong>Dimensiones recomendadas:</strong> 1080 x 1100 px <br>
    🖼️ <strong>Formatos permitidos:</strong> JPG, PNG <br>
    💾 <strong>Tamaño máximo:</strong> 2 MB
  </small>
</div>


      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          Descripcion
        </label>
        <input type="text" name="descripcion" required
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-purple-500">
      </div>

      <button type="submit"
        class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105 flex items-center justify-center gap-2 mt-6">
        <i class="fas fa-check-circle"></i> Guardar Promociones
      </button>
    </form>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function eliminarPromocion(id) {
  Swal.fire({
    title: '¿Eliminar promoción?',
    text: 'Esta acción no se puede deshacer.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('Eliminar.php?id_promocion=' + id)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              icon: 'success',
              title: 'Eliminado',
              text: 'La promoción ha sido eliminada correctamente.',
              showConfirmButton: false,
              timer: 1500
            });
            setTimeout(() => location.reload(), 1500);
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'No se pudo eliminar la promoción.'
            });
          }
        })
        .catch(() => {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error de conexión con el servidor.'
          });
        });
    }
  });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);

  if (params.has('exito')) {
    Swal.fire({
      icon: 'success',
      title: '¡Promoción agregada!',
      text: 'La promoción se ha guardado correctamente.',
      timer: 2000,
      showConfirmButton: false
    });
    // limpiar el parámetro de la URL para evitar repetir la alerta al recargar
    setTimeout(() => {
      window.history.replaceState({}, document.title, window.location.pathname);
    }, 2000);
  }

  if (params.has('error')) {
    let mensaje = '';
    switch (params.get('error')) {
      case 'db': mensaje = 'Error al guardar en la base de datos.'; break;
      case 'subida': mensaje = 'Error al subir la imagen.'; break;
      case 'noimagen': mensaje = 'Debe seleccionar una imagen.'; break;
      default: mensaje = 'Ha ocurrido un error inesperado.'; break;
    }

    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: mensaje,
    });

    setTimeout(() => {
      window.history.replaceState({}, document.title, window.location.pathname);
    }, 2000);
  }
});
</script>


<script>
function abrirModal(){
    document.getElementById("modalPromociones").classList.remove("hidden");
}

function cerrarModal(){
    document.getElementById("modalPromociones").classList.add("hidden");
}
</script>
</body>
</html>