<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recuperar Contraseña</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* 🌈 Estilos base */
    :root {
      --verde: #10b981;
      --verde-hover: #059669;
      --gris-texto: #374151;
      --gris-borde: #d1d5db;
      --fondo-general: #f9fafb;
    }

    body {
      margin: 0;
      padding: 0;
      background-color: var(--fondo-general);
      font-family: 'Poppins', 'Segoe UI', Tahoma, sans-serif;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* 🔹 Tarjeta principal */
    .card {
      background: #fff;
      border-radius: 1.8rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      padding: 2.5rem;
      width: 90%;
      max-width: 420px;
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: all 0.3s ease;
    }

    /* Logo */
    .logo {
      width: 140px;
      height: auto;
      margin-bottom: 1rem;
      transition: transform 0.3s ease;
    }

    .logo:hover {
      transform: scale(1.05);
    }

    /* Título */
    h1 {
      font-size: 1.9rem;
      font-weight: 700;
      color: var(--gris-texto);
      margin-bottom: 1.5rem;
      text-align: center;
    }

    /* Campos y botones */
    label {
      width: 100%;
      text-align: left;
      font-weight: 600;
      color: var(--gris-texto);
      margin-bottom: 0.4rem;
      font-size: 0.95rem;
    }

    input[type="email"] {
      width: 100%;
      padding: 12px 14px;
      border: 2px solid var(--gris-borde);
      border-radius: 10px;
      font-size: 1rem;
      color: #111827;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
      outline: none;
    }

    input[type="email"]:focus {
      border-color: var(--verde);
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }

    button {
      width: 100%;
      margin-top: 1.5rem;
      background: var(--verde);
      color: #fff;
      border: none;
      padding: 14px;
      font-size: 1rem;
      font-weight: 600;
      border-radius: 10px;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    button:hover {
      background: var(--verde-hover);
      transform: scale(1.02);
    }

    /* Alertas */
    .alert {
      width: 100%;
      padding: 12px 15px;
      border-radius: 10px;
      font-size: 0.95rem;
      margin-bottom: 1rem;
      line-height: 1.5;
      text-align: left;
    }

    .alert-error {
      background-color: #fee2e2;
      border-left: 5px solid #ef4444;
      color: #b91c1c;
    }

    .alert-success {
      background-color: #dcfce7;
      border-left: 5px solid #22c55e;
      color: #166534;
    }

    /* Enlace */
    .volver {
      display: block;
      margin-top: 1.5rem;
      color: #4b5563;
      font-size: 0.95rem;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .volver:hover {
      color: var(--verde-hover);
    }

    /* 🔸 Responsividad */
    @media (max-width: 768px) {
      .card {
        padding: 2rem;
        border-radius: 2rem;
      }
      .logo {
        width: 160px;
        margin-bottom: 1rem;
      }
      h1 {
        font-size: 2.1rem;
      }
    }

    @media (max-width: 640px) {
      body {
        align-items: flex-start;
        padding-top: 2vh;
      }

      .card {
        width: 95%;
        height: 90vh; /* Más grande en móvil */
        border-radius: 2rem;
        padding: 2rem 1.5rem;
        justify-content: center;
      }

      .logo {
        width: 200px;
        margin-bottom: 1.5rem;
      }

      h1 {
        font-size: 2.3rem;
      }

      input,
      button {
        font-size: 1.1rem;
        padding: 1rem;
      }

      .volver {
        font-size: 1.05rem;
      }
    }

    @media (max-height: 600px) {
      .card {
        height: auto; /* Evita recortes en pantallas muy pequeñas */
        margin-top: 1rem;
        margin-bottom: 1rem;
      }
    }
  </style>
</head>
<body>

  <div class="card">
    <img src="../Logo2.png" alt="Logo del Sistema" class="logo">
    <h1>Recuperar Contraseña</h1>

    <?php if(isset($_SESSION['recuperar_error'])): ?>
      <div class="alert alert-error">
        <?= $_SESSION['recuperar_error']; unset($_SESSION['recuperar_error']); ?>
      </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['recuperar_exito'])): ?>
      <div class="alert alert-success">
        <?= $_SESSION['recuperar_exito']; unset($_SESSION['recuperar_exito']); ?>
      </div>
    <?php endif; ?>

    <form action="enviar_recuperacion.php" method="POST">
      <label>Correo registrado:</label>
      <input type="email" name="email" placeholder="Ingresa tu correo" required>
      <button type="submit">Enviar enlace de recuperación</button>
    </form>

    <a href="../login.php" class="volver">← Volver al inicio de sesión</a>
  </div>

</body>
</html>
