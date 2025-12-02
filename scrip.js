document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.querySelector("[data-drawer-toggle='logo-sidebar']");
  const sidebar = document.getElementById("logo-sidebar");
  const overlay = document.getElementById("overlay");

  // Abrir / Cerrar con botón
  toggleBtn.addEventListener("click", () => {
    const isHidden = sidebar.classList.contains("-translate-x-full");

    if (isHidden) {
      sidebar.classList.remove("-translate-x-full");
      overlay.classList.remove("hidden"); // mostrar fondo
    } else {
      sidebar.classList.add("-translate-x-full");
      overlay.classList.add("hidden"); // ocultar fondo
    }
  });

  // Cerrar al hacer clic en el overlay
  overlay.addEventListener("click", () => {
    sidebar.classList.add("-translate-x-full");
    overlay.classList.add("hidden");
  });
});
