<?php

include 'seguridad.php';

$usuario = $_SESSION['usuario'] ?? "Invitado";


$tipo = $_SESSION['tipo']; 

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/themes/bootstrap.min.css"/>
       <script src="https://cdn.tailwindcss.com"></script>


   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>



    <style>
      body {
      margin: 0 !important;
      padding-top: 0 !important;
      overflow-x: hidden;
    }
    nav.fixed, 
    aside#logo-sidebar {
      position: fixed !important;
      z-index: 1055 !important;
    }
/* 🌐 En pantallas menores de 640px (modo móvil) */
@media (max-width: 640px) {
  #notifMenu {
    position: fixed !important;        /* ya no depende del botón */
    top: 30% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    width: 90% !important;
    max-height: 70vh !important;
    z-index: 9999 !important;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
  }
  #detalleReservacion {
  z-index: 10000 !important; /* más alto que el menú */
}
}

/* Fijamos el menú lateral y la barra superior por encima del contenido Bootstrap */
nav.fixed, 
aside#logo-sidebar {
  position: fixed !important;
  z-index: 1050 !important; /* más alto que Bootstrap modals (1040) */
}

body {
  overflow-x: hidden; /* previene que Bootstrap meta scroll lateral */
}
</style>
</head>
<body>

<nav class="fixed top-0 left-0 right-0 sm:left-64 bg-gray-950 border-b border-gray-900 shadow-md z-50">
  <div class="flex justify-between items-center px-4 sm:px-6 py-3">
    
    <!-- IZQUIERDA: Botón menú (solo visible en móviles) + Logo -->
    <div class="flex items-center gap-3">
      <!-- Botón hamburguesa -->
      <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
        aria-controls="logo-sidebar" type="button"
        class="inline-flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 sm:hidden">
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 
            0 010 1.5H2.75A.75.75 0 012 4.75zm0 
            10.5a.75.75 0 01.75-.75h7.5a.75.75 
            0 010 1.5h-7.5a.75.75 0 
            01-.75-.75zM2 10a.75.75 0 
            01.75-.75h14.5a.75.75 0 
            010 1.5H2.75A.75.75 0 
            012 10z"></path>
    </svg>
</button>



      <!-- Logo y título -->
       <img src="/Sistema-Renta-Facil/logo.png" alt="Logo" class="h-8 w-auto">
       <a href="/Sistema-Renta-Facil/dashboard.php">
        
         <h1 class="hidden sm:block text-lg sm:text-xl font-bold text-white">Panel de Control</h1>

       </a>

     

    </div>

    

    <!-- DERECHA: Notificaciones y usuario -->
    <div class="flex items-center gap-4 sm:gap-6">
      <!-- Notificaciones -->

    <div class="relative inline-block">
  <button id="notifButton" class="text-white hover:text-red-600 focus:outline-none relative">
    <i class="fa-solid fa-bell text-xl"></i>
    <span id="notifCount"
      class="absolute -top-1 -right-2 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full hidden"></span>
  </button>

 
  <div id="notifMenu"
    class="hidden absolute right-0 z-50 mt-3 w-72 bg-white shadow-lg rounded-lg border border-gray-200">
    <div class="p-3 border-b font-semibold text-gray-700">Notificaciones</div>
    <ul id="notifList" class="max-h-60 overflow-y-auto"></ul>
  </div>


 
  <div id="detalleReservacion" 
     class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
  <div class="bg-white w-11/12 max-w-md rounded-lg shadow-lg p-4 overflow-y-auto max-h-[90vh]">
    <!-- Aquí se insertará el contenido desde JS -->
  </div>
</div>
</div>





      
      <!-- Usuario -->
      <div class="flex items-center gap-2 bg-gray-100 px-3 py-2 rounded-full">
        <i class="fa-solid fa-user text-gray-700"></i>
        <span class="text-sm font-medium text-gray-700 truncate max-w-[120px] sm:max-w-none">
          <?php echo htmlspecialchars($usuario); ?>
        </span>
      </div>
    </div>
  </div>
</nav>




   <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
   <span class="sr-only">Open sidebar</span>
   <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
   <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
   </svg>
</button>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30"></div>

<aside id="logo-sidebar"
   class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
   aria-label="Sidebar">

   <div class="h-full flex flex-col justify-between px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-950">
      <!-- Sección superior -->
      <div>
         <a href="/Sistema-Renta-Facil/dashboard.php" class="flex items-center ps-2.5 mb-5">
            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Renta Facil</span>
         </a>

         <ul class="space-y-2 font-medium">
            <li>
               <a href="/Sistema-Renta-Facil/dashboard.php"
                  class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <span class="flex-1 ms-3 whitespace-nowrap">DASHBOARD</span>
               </a>
            </li>

            <?php if ($tipo == 'Administrador'): ?>
            <li>
               <a href="/Sistema-Renta-Facil/Usuarios/Usuarios.php"
                  class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <i class="fa-solid fa-users"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Usuarios</span>
               </a>
            </li>
            <?php endif; ?>

            <li>
               <a href="/Sistema-Renta-Facil/Vehiculos/Vehiculos.php"
                  class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <i class="fa-solid fa-car-side"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Vehículos</span>
               </a>
            </li>

            <li>
               <a href="/Sistema-Renta-Facil/Reservas/Reservas.php"
                  class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <i class="fa-solid fa-book-open"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Reservaciones</span>
               </a>
            </li>

            <li>
               <a href="/Sistema-Renta-Facil/Contratos/contratos.php"
                  class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <i class="fa-solid fa-file-signature"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Contratos</span>
               </a>
            </li>

            <!-- Submenú Categorías -->
            <li class="relative">
               <button id="btn-categorias" type="button"
                  class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                  aria-expanded="false" aria-controls="submenu-categorias">
                  <i class="fa-solid fa-layer-group"></i>
                  <span class="flex-1 ms-3 text-left whitespace-nowrap">Categorías</span>
                  <svg id="arrow-categorias" class="w-3 h-3 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 10 6">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                  </svg>
               </button>
               <ul id="submenu-categorias" class="hidden py-2 space-y-1 pl-6">
                  <li>
                     <a href="/Sistema-Renta-Facil/Categorias/Categoria_Vehiculo/categorias_vehiculos.php"
                        class="block p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                        Categorías de Vehículos
                     </a>
                  </li>
                  
               </ul>

                
            </li>

            <li>
               <a href="/Sistema-Renta-Facil/Mantenimientos/mantenimiento.php"
                  class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <i class="fa-solid fa-screwdriver-wrench"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Mantenimientos</span>
               </a>
            </li>
             
            <!-- Submenú Historial -->
            <li class="relative">
               <button id="btn-Historial" type="button"
                  class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                  aria-expanded="false" aria-controls="submenu-Historial">
                  <i class="fa-solid fa-layer-group"></i>
                  <span class="flex-1 ms-3 text-left whitespace-nowrap">Historial</span>
                  <svg id="arrow-Historial" class="w-3 h-3 transition-transform" xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 10 6">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                  </svg>
               </button>
               <ul id="submenu-Historial" class="hidden py-2 space-y-1 pl-6">
                  <li>
                     <a href="/Sistema-Renta-Facil/Historial/Cambio_Aceite/historialaceite.php"
                        class="block p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                        Cambios de aceite
                     </a>
                  </li>
               </ul>
               <li>
               <a href="/Sistema-Renta-Facil/Promociones/promociones.php"
                  class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                  <i class="fa-solid fa-laptop-code"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Administrar pagina web</span>
               </a>
            </li>

            </li>
         </ul>
      </div>

      <!-- 🔻 Sección inferior (fijada al fondo) -->
      <div class="border-t border-gray-300 dark:border-gray-700 pt-3 space-y-1">
         <a href="/Sistema-Renta-Facil/ayuda/Ayuda.php"
            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <i class="fa-solid fa-circle-exclamation"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Ayudas</span>
         </a>

         <a href="/Sistema-Renta-Facil/Creditos/creditos.php"
            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <i class="fa-solid fa-star"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Créditos</span>
         </a>

         <a href="/Sistema-Renta-Facil/Respaldos/index_respaldo.php"
            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <i class="fa-solid fa-star"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Respaldos</span>
         </a>

         <a href="#" id="logout-btn"
            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <span class="flex-1 ms-3 whitespace-nowrap">Salir</span>
         </a>
      </div>

      <form id="logout-form" action="/Sistema-Renta-Facil/salir.php" method="POST" style="display: none;"></form>
   </div>
</aside>

<script src="/Sistema-Renta-Facil/scrip.js"></script>
<script>
  (function(){
    const btn = document.getElementById('btn-categorias');
    const submenu = document.getElementById('submenu-categorias');
    const arrow = document.getElementById('arrow-categorias');

    // Toggle al hacer click
    btn.addEventListener('click', function (e) {
      const isHidden = submenu.classList.toggle('hidden'); 
      btn.setAttribute('aria-expanded', String(!isHidden));
      arrow.classList.toggle('rotate-180'); 
    });

    const links = Array.from(submenu.querySelectorAll('a'));
    const currentPath = window.location.pathname; 
    let opened = false;
    for (const a of links) {
      if (currentPath.endsWith(a.getAttribute('href')) || currentPath === new URL(a.href, location.origin).pathname) {
        
        submenu.classList.remove('hidden');
        btn.setAttribute('aria-expanded', 'true');
        arrow.classList.add('rotate-180');
        a.classList.add('bg-gray-200', 'dark:bg-gray-700'); 
        opened = true;
        break;
      }
    }

  })();



  (function(){
    const btn = document.getElementById('btn-Historial');
    const submenu = document.getElementById('submenu-Historial');
    const arrow = document.getElementById('arrow-Historial');

    // Toggle al hacer click
    btn.addEventListener('click', function (e) {
      const isHidden = submenu.classList.toggle('hidden'); 
      btn.setAttribute('aria-expanded', String(!isHidden));
      arrow.classList.toggle('rotate-180'); 
    });

    const links = Array.from(submenu.querySelectorAll('a'));
    const currentPath = window.location.pathname; 
    let opened = false;
    for (const a of links) {
      if (currentPath.endsWith(a.getAttribute('href')) || currentPath === new URL(a.href, location.origin).pathname) {
        
        submenu.classList.remove('hidden');
        btn.setAttribute('aria-expanded', 'true');
        arrow.classList.add('rotate-180');
        a.classList.add('bg-gray-200', 'dark:bg-gray-700'); 
        opened = true;
        break;
      }
    }

  })();
</script>



<script>
(function() {
    function hacerLogout() {
        const form = document.getElementById('logout-form');
        if (form) form.submit();
    }

    function mostrarAlerta() {
        // evita múltiples alertas simultáneas
        if (window.alertaMostrada) return;
        window.alertaMostrada = true;

        alertify.confirm(
            '⚠️ Seguridad del sistema',
            'Por seguridad, no puedes usar el botón "Atrás". Si deseas salir, se cerrará tu sesión.',
            function() {
                hacerLogout();
            },
            function() {
                alertify.success('Por favor, usa solo los botones del sistema.');
                // volvemos a bloquear y permitimos futuras alertas
                bloquearRetroceso();
                window.alertaMostrada = false;
            }
        )
        .set('labels', { ok: 'Cerrar sesión', cancel: 'Cancelar' })
        .set('transition', 'pulse')
        .set('closable', false);
    }

    function bloquearRetroceso() {
        // agregamos un estado de bloqueo en el historial
        history.pushState({ bloqueado: true }, null, location.href);
        window.onpopstate = function(event) {
            // si viene del botón atrás (no de una navegación interna)
            if (event.state && event.state.bloqueado) {
                history.pushState({ bloqueado: true }, null, location.href);
                mostrarAlerta();
            }
        };
    }

    bloquearRetroceso();

    // si el usuario intenta volver desde caché, cerrar sesión directamente
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            mostrarAlerta();
        }
    });
})();
</script>








<script>
document.addEventListener("DOMContentLoaded", () => {
  const notifButton = document.getElementById("notifButton");
  const notifMenu = document.getElementById("notifMenu");
  const notifCount = document.getElementById("notifCount");
  const notifList = document.getElementById("notifList");
  const detalleReservacion = document.getElementById("detalleReservacion");

  notifButton.addEventListener("click", (e) => {
    e.stopPropagation();
    notifMenu.classList.toggle("hidden");
    detalleReservacion.classList.add("hidden");
  });

  document.addEventListener("click", (e) => {
    if (!notifMenu.contains(e.target) && !notifButton.contains(e.target) && !detalleReservacion.contains(e.target)) {
      notifMenu.classList.add("hidden");
      detalleReservacion.classList.add("hidden");
    }
  });

  function cargarNotificaciones() {
    fetch("/Sistema-Renta-Facil/obtener_notificaciones.php")
      .then(res => res.json())
      .then(data => {
        notifList.innerHTML = "";
        let noLeidas = 0;

        if (data.length === 0) {
          notifList.innerHTML = `<li class="px-4 py-2 text-gray-500 text-sm">Sin notificaciones</li>`;
        } else {
          data.forEach(n => {
            if (n.leida == 0) noLeidas++;
            
            // 💡 Diferenciamos visualmente las nuevas
            const fondo = n.leida == 0 ? "bg-yellow-50 border-l-4 border-yellow-400" : "bg-white";
            const texto = n.leida == 0 ? "text-gray-800 font-semibold" : "text-gray-600";

            notifList.innerHTML += `
              <li data-id="${n.id}" 
                  class="notif-item ${fondo} px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm border-b border-gray-200 transition-all duration-200">
                <div class="${texto}">${n.mensaje}</div>
                <span class="text-xs text-gray-400">${n.fecha}</span>
              </li>`;
          });
        }

        notifCount.textContent = noLeidas > 0 ? noLeidas : "";
        notifCount.classList.toggle("hidden", noLeidas === 0);
      });
  }

  cargarNotificaciones();
  setInterval(cargarNotificaciones, 15000);

  notifList.addEventListener("click", (e) => {
    const item = e.target.closest("li[data-id]");
    if (!item) return;

    const id = item.dataset.id;

    // 🟢 Visualmente marcar como leída al instante
    item.classList.remove("bg-yellow-50", "border-yellow-400");
    item.classList.add("bg-white", "opacity-80");
    
    fetch("/Sistema-Renta-Facil/marcar_leida.php?id=" + id)
      .then(() => cargarNotificaciones());

    fetch("/Sistema-Renta-Facil/ver_notificacion.php?id=" + id)
      .then(res => {
        if (!res.ok) throw new Error("Respuesta HTTP " + res.status);
        return res.json();
      })
      .then(data => {
        if (data.status === "ok") {
          const r = data.data;
          const modal = document.getElementById("detalleReservacion");
          const content = modal.querySelector("div");

          content.innerHTML = `
            <div class="p-5">
              <h2 class="text-lg font-bold text-gray-800 mb-3">Reservación #${r.id_reservacion}</h2>
              <p><strong>Vehículo:</strong> ${r.marca} ${r.modelo}</p>
              <p><strong>Cliente:</strong> ${r.solicitante_nombre}</p>
              <p><strong>DUI:</strong> ${r.solicitante_dui}</p>
              <p><strong>Teléfono:</strong> ${r.solicitante_telefono}</p>
              <p><strong>Correo:</strong> ${r.solicitante_correo ?? '—'}</p>
              <p><strong>Desde:</strong> ${r.fecha_inicio_solicitada}</p>
              <p><strong>Hasta:</strong> ${r.fecha_fin_solicitada}</p>
              <p><strong>Días:</strong> ${r.dias_solicitados}</p>
              <p><strong>Total a pagar:</strong> $${parseFloat(r.total_pagar).toFixed(2)}</p>

              <p><strong>Estado:</strong> 
                <span class="px-2 py-1 rounded text-white ${
                  r.estado === 'pendiente' ? 'bg-yellow-500' :
                  r.estado === 'aceptada' ? 'bg-green-600' : 'bg-red-600'
                }">${r.estado}</span>
              </p>
              <button id="cerrarDetalle" class="mt-4 bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700 w-full sm:w-auto">
                Cerrar
              </button>
            </div>
          `;

          modal.classList.remove("hidden");
          document.getElementById("cerrarDetalle").addEventListener("click", () => modal.classList.add("hidden"));
        } else {
          alert(data.message || "Error al obtener detalle");
        }
      })
      .catch(err => {
        console.error("Error fetch ver_notificacion:", err);
        alert("Error al cargar detalle. Revisa la consola (F12).");
      });
  });
});
</script>






</body>
</html>


<script>
document.getElementById('logout-btn').addEventListener('click', function(e) {
    e.preventDefault();
    
    alertify.confirm('Confirmar Cierre de Sesión', 
        '¿Estás seguro de que deseas cerrar sesión?', 
        function() {
            alertify.success('Cerrando sesión...');
            setTimeout(() => {
                window.location.href = '/Sistema-Renta-Facil/salir.php';
            }, 1000);
        }, 
        function() {
            alertify.error('Operación cancelada');
        }
    );
});
</script>