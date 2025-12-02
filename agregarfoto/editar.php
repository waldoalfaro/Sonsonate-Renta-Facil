<?php include("db.php"); ?>

<?php 
// Obtener el ID del carro a editar
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

// Obtener datos del carro
$sql = "SELECT * FROM carros WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: index.php");
    exit();
}

$carro = $result->fetch_assoc();

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $color = $_POST['color'];
    $asientos = $_POST['asientos'];
    $transmision = $_POST['transmision'];
    $aire = isset($_POST['aire']) ? 1 : 0;
    $precio_alquiler = $_POST['precio_alquiler'];
    $disponible = $_POST['disponible'];

    // Manejar la foto
    if (!empty($_FILES['foto']['name'])) {
        // Si se sube una nueva foto
        $foto = $_FILES['foto']['name'];
        $ruta = "uploads/" . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $ruta);
        
        // Eliminar foto anterior si existe
        if (!empty($carro['foto']) && file_exists("uploads/" . $carro['foto'])) {
            unlink("uploads/" . $carro['foto']);
        }
    } else {
        // Mantener la foto actual
        $foto = $carro['foto'];
    }

    $sql = "UPDATE carros SET 
                marca = '$marca',
                modelo = '$modelo', 
                anio = '$anio',
                color = '$color',
                asientos = '$asientos',
                transmision = '$transmision',
                aire = '$aire',
                foto = '$foto',
                precio_alquiler = '$precio_alquiler',
                disponible = '$disponible'
            WHERE id = $id";
    
    if ($conn->query($sql)) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Error al actualizar el carro: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Carro - <?php echo $carro['marca'] . ' ' . $carro['modelo']; ?></title>
    <!-- Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f4f4f4;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        .contenedor {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border: 2px solid #000;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        
        .header {
            background: #FFC107; /* Amarillo más oscuro para edición */
            color: #000;
            padding: 20px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }
        
        .foto-actual {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-bottom: 1px solid #ddd;
        }
        
        .foto-actual img {
            max-width: 200px;
            max-height: 150px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .foto-actual p {
            margin: 10px 0 5px;
            font-weight: bold;
            color: #666;
        }
        
        .form-container {
            padding: 30px;
        }
        
        .alert {
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid;
        }
        
        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        
        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }
        
        .form-group label i {
            margin-right: 10px;
            width: 20px;
            color: #666;
        }
        
        .form-group input,
        .form-group select {
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #FFC107;
        }
        
        .form-group input[type="file"] {
            padding: 8px;
        }
        
        /* Grupos especiales */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .precio-estado {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 15px;
            align-items: end;
        }
        
        .precio-input {
            position: relative;
        }
        
        .precio-input::before {
            content: '$';
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-weight: bold;
            z-index: 1;
        }
        
        .precio-input input {
            padding-left: 25px;
        }
        
        .estado-selector {
            display: flex;
            gap: 10px;
        }
        
        .estado-option {
            flex: 1;
            position: relative;
        }
        
        .estado-option input[type="radio"] {
            display: none;
        }
        
        .estado-option label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: bold;
            margin-bottom: 0;
        }
        
        .estado-option.disponible label {
            color: #28a745;
            border-color: #28a745;
        }
        
        .estado-option.alquilado label {
            color: #dc3545;
            border-color: #dc3545;
        }
        
        .estado-option input[type="radio"]:checked + label {
            color: #fff;
        }
        
        .estado-option.disponible input[type="radio"]:checked + label {
            background: #28a745;
        }
        
        .estado-option.alquilado input[type="radio"]:checked + label {
            background: #dc3545;
        }
        
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .checkbox-container input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #FFC107;
        }
        
        .checkbox-container label {
            margin: 0;
            color: #333;
            font-weight: bold;
        }
        
        .foto-info {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        
        .botones {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 15px;
        }
        
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex: 1;
        }
        
        .btn-actualizar {
            background: #FFC107;
            color: #000;
        }
        
        .btn-actualizar:hover {
            background: #e0a800;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .btn-cancelar {
            background: #6c757d;
            color: #fff;
        }
        
        .btn-cancelar:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        /* Iconos con colores específicos */
        .fa-car { color: #007bff; }
        .fa-tag { color: #28a745; }
        .fa-calendar-alt { color: #17a2b8; }
        .fa-palette { color: #e83e8c; }
        .fa-chair { color: #6f42c1; }
        .fa-cogs { color: #fd7e14; }
        .fa-snowflake { color: #20c997; }
        .fa-image { color: #6c757d; }
        .fa-dollar-sign { color: #28a745; }
        .fa-info-circle { color: #17a2b8; }
        
        /* Responsivo */
        @media (max-width: 600px) {
            .form-row,
            .precio-estado {
                grid-template-columns: 1fr;
            }
            
            .botones {
                flex-direction: column;
            }
            
            .foto-actual img {
                max-width: 150px;
                max-height: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <div class="header">
            <h1><i class="fas fa-edit"></i> Editar Carro</h1>
        </div>
        
        <!-- Mostrar foto actual -->
        <div class="foto-actual">
            <p>Foto Actual:</p>
            <?php if (!empty($carro['foto']) && file_exists("uploads/" . $carro['foto'])): ?>
                <img src="uploads/<?php echo $carro['foto']; ?>" alt="Foto actual">
            <?php else: ?>
                <div style="padding: 50px; background: #eee; border-radius: 8px; color: #666;">
                    <i class="fas fa-image" style="font-size: 48px;"></i><br>
                    Sin foto
                </div>
            <?php endif; ?>
        </div>
        
        <div class="form-container">
            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-car"></i> Marca:</label>
                        <input type="text" name="marca" required placeholder="Ej: Toyota, Ford, Chevrolet" value="<?php echo htmlspecialchars($carro['marca']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-tag"></i> Modelo:</label>
                        <input type="text" name="modelo" required placeholder="Ej: Corolla, Focus, Aveo" value="<?php echo htmlspecialchars($carro['modelo']); ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i> Año:</label>
                        <input type="number" name="anio" required min="1990" max="2025" placeholder="Ej: 2020" value="<?php echo $carro['anio']; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-palette"></i> Color:</label>
                        <input type="text" name="color" required placeholder="Ej: Blanco, Negro, Rojo" value="<?php echo htmlspecialchars($carro['color']); ?>">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-chair"></i> Asientos:</label>
                        <select name="asientos" required>
                            <option value="">Seleccionar...</option>
                            <option value="2" <?php echo ($carro['asientos'] == 2) ? 'selected' : ''; ?>>2 asientos</option>
                            <option value="4" <?php echo ($carro['asientos'] == 4) ? 'selected' : ''; ?>>4 asientos</option>
                            <option value="5" <?php echo ($carro['asientos'] == 5) ? 'selected' : ''; ?>>5 asientos</option>
                            <option value="7" <?php echo ($carro['asientos'] == 7) ? 'selected' : ''; ?>>7 asientos</option>
                            <option value="8" <?php echo ($carro['asientos'] == 8) ? 'selected' : ''; ?>>8 asientos</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-cogs"></i> Transmisión:</label>
                        <select name="transmision" required>
                            <option value="">Seleccionar...</option>
                            <option value="Estandar" <?php echo ($carro['transmision'] == 'Estandar') ? 'selected' : ''; ?>>Estándar</option>
                            <option value="Automático" <?php echo ($carro['transmision'] == 'Automático') ? 'selected' : ''; ?>>Automático</option>
                        </select>
                    </div>
                </div>
                
                <div class="precio-estado">
                    <div class="form-group">
                        <label><i class="fas fa-dollar-sign"></i> Precio por día:</label>
                        <div class="precio-input">
                            <input type="number" name="precio_alquiler" required min="1" step="0.01" placeholder="50.00" value="<?php echo $carro['precio_alquiler']; ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-info-circle"></i> Estado:</label>
                        <div class="estado-selector">
                            <div class="estado-option disponible">
                                <input type="radio" id="disponible" name="disponible" value="1" <?php echo ($carro['disponible'] == 1) ? 'checked' : ''; ?>>
                                <label for="disponible">Disponible</label>
                            </div>
                            <div class="estado-option alquilado">
                                <input type="radio" id="alquilado" name="disponible" value="0" <?php echo ($carro['disponible'] == 0) ? 'checked' : ''; ?>>
                                <label for="alquilado">Alquilado</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="checkbox-container">
                        <input type="checkbox" id="aire" name="aire" <?php echo ($carro['aire'] == 1) ? 'checked' : ''; ?>>
                        <label for="aire"><i class="fas fa-snowflake"></i> Aire Acondicionado</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-image"></i> Cambiar foto del vehículo:</label>
                    <input type="file" name="foto" accept="image/*">
                    <div class="foto-info">
                        <i class="fas fa-info-circle"></i> Deja este campo vacío si no quieres cambiar la foto actual
                    </div>
                </div>
                
                <div class="botones">
                    <button type="submit" class="btn btn-actualizar">
                        <i class="fas fa-save"></i> Actualizar Carro
                    </button>
                    <a href="index.php" class="btn btn-cancelar">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>