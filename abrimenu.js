document.addEventListener("DOMContentLoaded", () => {
  const toggleBtns = document.querySelectorAll("[data-drawer-toggle='logo-sidebar']");
  const sidebar = document.getElementById("logo-sidebar");
  const overlay = document.getElementById("overlay");

  toggleBtns.forEach(toggleBtn => {
    toggleBtn.addEventListener("click", () => {
      const isHidden = sidebar.classList.contains("-translate-x-full");
      if (isHidden) {
        sidebar.classList.remove("-translate-x-full");
        overlay.classList.remove("hidden");
      } else {
        sidebar.classList.add("-translate-x-full");
        overlay.classList.add("hidden");
      }
    });
  });

  overlay.addEventListener("click", () => {
    sidebar.classList.add("-translate-x-full");
    overlay.classList.add("hidden");
  });
});
