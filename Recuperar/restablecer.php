<?php
session_start();
require '../conexion.php';

if(!isset($_GET['token'])){
    die("Token inválido.");
}

$token = $_GET['token'];
$stmt = $conn->prepare("SELECT id_usuario, expira_token FROM usuarios WHERE token_recuperacion = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$resultado = $stmt->get_result();

if($resultado->num_rows !== 1){
    die("Token inválido o ya usado.");
}

$fila = $resultado->fetch_assoc();
$expira = strtotime($fila['expira_token']);
if(time() > $expira){
    die("El token ha expirado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Restablecer Contraseña</title>
<style>
  :root {
    --verde: #10b981;
    --verde-hover: #059669;
    --gris-texto: #374151;
    --gris-borde: #d1d5db;
    --fondo: #f9fafb;
  }

  body {
    margin: 0;
    padding: 0;
    background-color: var(--fondo);
    font-family: 'Poppins', 'Segoe UI', sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .card {
    background: #fff;
    border-radius: 1.8rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 2.5rem;
    width: 90%;
    max-width: 420px;
    text-align: center;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
  }

  .logo {
    width: 140px;
    height: auto;
    margin: 0 auto 1rem auto;
    transition: transform 0.3s ease;
  }

  .logo:hover {
    transform: scale(1.05);
  }

  h1 {
    font-size: 1.9rem;
    font-weight: 700;
    color: var(--gris-texto);
    margin-bottom: 1.5rem;
  }

  label {
    display: block;
    text-align: left;
    font-weight: 600;
    color: var(--gris-texto);
    margin-bottom: 0.4rem;
    font-size: 0.95rem;
  }

  input[type="password"] {
    width: 100%;
    padding: 12px 14px;
    border: 2px solid var(--gris-borde);
    border-radius: 10px;
    font-size: 1rem;
    color: #111827;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    outline: none;
  }

  input[type="password"]:focus {
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

  /* 📱 Responsivo */
  @media (max-width: 768px) {
    .card {
      padding: 2rem;
      border-radius: 2rem;
    }

    .logo {
      width: 160px;
    }

    h1 {
      font-size: 2rem;
    }
  }

  @media (max-width: 640px) {
    body {
      align-items: flex-start;
      padding-top: 2vh;
    }

    .card {
      width: 95%;
      height: 85vh;
      justify-content: center;
      padding: 2rem 1.5rem;
      border-radius: 2rem;
    }

    .logo {
      width: 200px;
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
      height: auto;
      margin-top: 1rem;
      margin-bottom: 1rem;
    }
  }
</style>
</head>
<body>

  <div class="card">
    <img src="../Logo2.png" alt="Logo del Sistema" class="logo">
    <h1>Restablecer Contraseña</h1>

    <form action="guardar_contra.php" method="POST">
      <input type="hidden" name="id_usuario" value="<?= $fila['id_usuario'] ?>">
      <input type="hidden" name="token" value="<?= $token ?>">

      <label for="clave">Nueva contraseña:</label>
      <input type="password" name="clave" id="clave" placeholder="Nueva contraseña" required>

      <button type="submit">Guardar nueva contraseña</button>
    </form>

    <a href="../login.php" class="volver">← Volver al inicio de sesión</a>
  </div>

</body>
</html>
