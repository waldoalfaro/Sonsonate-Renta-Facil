<?php include("db.php"); ?>

<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $color = $_POST['color'];
    $asientos = $_POST['asientos'];
    $transmision = $_POST['transmision'];
    $aire = isset($_POST['aire']) ? 1 : 0;
    $precio_alquiler = $_POST['precio_alquiler']; // Nuevo campo
    $disponible = $_POST['disponible']; // Nuevo campo

    $foto = $_FILES['foto']['name'];
    $ruta = "uploads/" . basename($foto);
    move_uploaded_file($_FILES['foto']['tmp_name'], $ruta);

    $sql = "INSERT INTO carros (marca, modelo, anio, color, asientos, transmision, aire, foto, precio_alquiler, disponible) 
            VALUES ('$marca','$modelo','$anio','$color','$asientos','$transmision','$aire','$foto','$precio_alquiler','$disponible')";
    $conn->query($sql);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Carro</title>
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
            background: #FFD700;
            color: #000;
            padding: 20px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }
        
        .form-container {
            padding: 30px;
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
            border-color: #FFD700;
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
            accent-color: #FFD700;
        }
        
        .checkbox-container label {
            margin: 0;
            color: #333;
            font-weight: bold;
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
        
        .btn-guardar {
            background: #FFD700;
            color: #000;
        }
        
        .btn-guardar:hover {
            background: #FFC107;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .btn-volver {
            background: #6c757d;
            color: #fff;
        }
        
        .btn-volver:hover {
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
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <div class="header">
            <h1><i class="fas fa-plus-circle"></i> Agregar Nuevo Carro</h1>
        </div>
        
        <div class="form-container">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-car"></i> Marca:</label>
                        <input type="text" name="marca" required placeholder="Ej: Toyota, Ford, Chevrolet">
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-tag"></i> Modelo:</label>
                        <input type="text" name="modelo" required placeholder="Ej: Corolla, Focus, Aveo">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i> Año:</label>
                        <input type="number" name="anio" required min="1990" max="2025" placeholder="Ej: 2020">
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-palette"></i> Color:</label>
                        <input type="text" name="color" required placeholder="Ej: Blanco, Negro, Rojo">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label><i class="fas fa-chair"></i> Asientos:</label>
                        <select name="asientos" required>
                            <option value="">Seleccionar...</option>
                            <option value="2">2 asientos</option>
                            <option value="4">4 asientos</option>
                            <option value="5">5 asientos</option>
                            <option value="7">7 asientos</option>
                            <option value="8">8 asientos</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-cogs"></i> Transmisión:</label>
                        <select name="transmision" required>
                            <option value="">Seleccionar...</option>
                            <option value="Estandar">Estándar</option>
                            <option value="Automático">Automático</option>
                        </select>
                    </div>
                </div>
                
                <div class="precio-estado">
                    <div class="form-group">
                        <label><i class="fas fa-dollar-sign"></i> Precio por día:</label>
                        <div class="precio-input">
                            <input type="number" name="precio_alquiler" required min="1" step="0.01" placeholder="50.00">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-info-circle"></i> Estado:</label>
                        <div class="estado-selector">
                            <div class="estado-option disponible">
                                <input type="radio" id="disponible" name="disponible" value="1" checked>
                                <label for="disponible">Disponible</label>
                            </div>
                            <div class="estado-option alquilado">
                                <input type="radio" id="alquilado" name="disponible" value="0">
                                <label for="alquilado">Alquilado</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="checkbox-container">
                        <input type="checkbox" id="aire" name="aire">
                        <label for="aire"><i class="fas fa-snowflake"></i> Aire Acondicionado</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-image"></i> Foto del vehículo:</label>
                    <input type="file" name="foto" required accept="image/*">
                </div>
                
                <div class="botones">
                    <button type="submit" class="btn btn-guardar">
                        <i class="fas fa-save"></i> Guardar Carro
                    </button>
                    <a href="index.php" class="btn btn-volver">
                        <i class="fas fa-arrow-left"></i> Volver al Listado
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>