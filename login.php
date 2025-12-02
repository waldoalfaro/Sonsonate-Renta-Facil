<?php
session_start(); // <- necesario para leer $_SESSION['error']
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"> 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="login.css">
  <!-- SweetAlert2 (alertas bonitas) -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- FontAwesome para el ícono del ojo -->
  <script src="https://kit.fontawesome.com/a2d9d6b33a.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-company">
    
  <!-- Elementos decorativos flotantes -->
  <div class="floating-decoration floating-animation decoration-1"></div>
  <div class="floating-decoration floating-animation decoration-2"></div>
  <div class="floating-decoration floating-animation decoration-3"></div>

  <!-- Contenedor principal -->
  <div class="glass-effect">

    <!-- Header con logo y título -->
    <div class="login-header">
      <div class="logo-circle">
        <svg class="logo-icon" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
        </svg>
      </div>
      <h1 class="login-title">Bienvenido</h1>
      <p class="login-subtitle">Accede a tu cuenta para continuar</p>
    </div>

    <!-- Mensaje de error (si existe) -->
    <div class="error-message hidden" id="error-message">
      <div class="error-content">
        <div class="error-icon-wrapper">
          <svg class="error-icon" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="error-text-wrapper">
          <p class="error-text" id="error-text">Error en las credenciales</p>
        </div>
      </div>
    </div>

    <!-- Formulario -->
    <form action="verificar.php" method="POST" class="login-form">
      
      <!-- Campo Usuario -->
      <div class="form-group">
        <label for="usuario" class="form-label">
          <span class="label-content">
            <svg class="label-icon icon-green" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
            Nombre de Usuario
          </span>
        </label>
        <input 
          type="text" 
          name="usuario" 
          id="usuario"
          placeholder="Ingresa tu nombre de usuario"
          class="form-input"
          required
        >
        <p class="form-hint">💡 Usa el usuario que te proporcionó el administrador</p>
      </div>

      <!-- Campo Contraseña -->
      <div class="form-group">
        <label for="clave" class="form-label">
          <span class="label-content">
            <svg class="label-icon icon-yellow" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
            Contraseña
          </span>
        </label>

        <!-- Campo de entrada -->
        <div class="password-wrapper">
          <input 
            type="password" 
            name="clave" 
            id="clave"
            placeholder="Ingresa tu contraseña segura"
            class="form-input password-input"
            required
          >
    
          <button type="button" id="togglePassword" class="toggle-password">
            <i class="fas fa-eye" id="icono_ojo"></i>
          </button>
        </div>
        <p class="form-hint">🔐 Mantén tu contraseña segura</p>
      </div>

      <!-- Botón de acceso -->
      <div class="button-wrapper">
        <button type="submit" class="btn-submit">
          <span class="button-content">
            <svg class="button-icon" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l5-5z" clip-rule="evenodd" />
            </svg>
            INICIAR SESIÓN
          </span>
        </button>
      </div>
    </form>

    <!-- Información adicional -->
    <div class="login-footer">
      <div class="footer-content">
        <p class="footer-text">
          ¿Olvidaste tu contraseña? 
          <a href="Recuperar/recuperar.php" class="footer-link">Recupera tu contraseña</a>
        </p>
        <div class="footer-icon-wrapper">
          <svg class="footer-icon" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
          </svg>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Mostrar/ocultar contraseña + cambiar icono
    const toggle = document.getElementById('togglePassword');
    const input = document.getElementById('clave');
    const icon = document.getElementById('icono_ojo');

    toggle.addEventListener('click', function() {
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });

    // Mostrar alerta con SweetAlert2 si hay error en sesión (desde PHP)
    document.addEventListener('DOMContentLoaded', function() {
      <?php if (!empty($_SESSION['error'])): 
          $err = json_encode($_SESSION['error']);
      ?>
        Swal.fire({
          icon: 'error',
          title: 'Error de inicio de sesión',
          text: <?= $err ?>,
          confirmButtonText: 'OK'
        });
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>
    });

    // Efectos adicionales de interactividad
    document.querySelectorAll('.form-input').forEach(input => {
      input.addEventListener('focus', function() {
        this.parentNode.classList.add('input-focused');
      });
      
      input.addEventListener('blur', function() {
        this.parentNode.classList.remove('input-focused');
      });
    });
  </script>
</body>
</html>