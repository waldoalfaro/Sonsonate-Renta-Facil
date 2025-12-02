<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carros Disponibles</title>
    <!-- Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f4f4f4;
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #FFD700; /* Amarillo */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        .contenedor {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .card {
            background: #fff;
            border: 2px solid #000; /* Negro */
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
        }
        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }
        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: #eee;
        }
        
        /* Estado de disponibilidad */
        .estado-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .disponible {
            background: #28a745;
            color: white;
        }
        .alquilado {
            background: #dc3545;
            color: white;
        }
        
        /* Precio destacado */
        .precio {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #FFD700;
            color: #000;
            padding: 8px 12px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .card-body {
            padding: 15px;
        }
        .card-body h3 {
            color: #000; /* Negro */
            margin: 0 0 15px;
        }
        
        /* Características con iconos */
        .caracteristicas {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin: 10px 0;
        }
        
        .caracteristica {
            display: flex;
            align-items: center;
            color: #333;
            font-size: 14px;
        }
        
        .caracteristica i {
            margin-right: 8px;
            width: 16px;
            color: #666;
        }
        
        /* Iconos específicos con colores */
        .fa-calendar-alt { color: #17a2b8; }
        .fa-palette { color: #e83e8c; }
        .fa-chair { color: #6f42c1; }
        .fa-cogs { color: #28a745; }
        .fa-snowflake { color: #20c997; }
        .fa-times { color: #dc3545; }
        
        .acciones {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s, transform 0.2s;
        }
        .btn-agregar {
            background: #FFD700; /* Amarillo */
            color: #000; /* Negro */
            margin-bottom: 20px;
            display: inline-block;
        }
        .btn-agregar:hover {
            background: #FFC107; /* Amarillo más claro */
            transform: scale(1.05);
        }
        .btn-editar {
            background: #000; /* Negro */
            color: #fff; /* Blanco */
        }
        .btn-editar:hover {
            background: #333; /* Negro más claro */
        }
        .btn-eliminar {
            background: red; /* Rojo */
            color: #fff; /* Blanco */
        }
        .btn-eliminar:hover {
            background: darkred; /* Rojo más oscuro */
        }
        
        /* Filtro para carros alquilados */
        .card.alquilado-card {
            opacity: 0.8;
        }
        .card.alquilado-card img {
            filter: grayscale(30%);
        }
    </style>
</head>
<body>
    <h1>Carros Disponibles</h1>
    <a href="agregar.php" class="btn btn-agregar">+ Agregar Carro</a>
    <div class="contenedor">
        <?php
        $sql = "SELECT * FROM carros";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()):
            // Asumiendo que tienes campos 'disponible' (1=disponible, 0=alquilado) y 'precio_alquiler'
            // Si no los tienes, puedes agregarlos a tu base de datos
            $disponible = isset($row['disponible']) ? $row['disponible'] : 1; // Por defecto disponible
            $precio = isset($row['precio_alquiler']) ? $row['precio_alquiler'] : 50; // Precio por defecto
        ?>
        <div class="card <?php echo $disponible ? '' : 'alquilado-card'; ?>">
            <!-- Precio -->
            <div class="precio">
                $<?php echo number_format($precio, 0); ?>/día
            </div>
            
            <!-- Estado -->
            <div class="estado-badge <?php echo $disponible ? 'disponible' : 'alquilado'; ?>">
                <?php echo $disponible ? 'Disponible' : 'Alquilado'; ?>
            </div>
            
            <img src="uploads/<?php echo $row['foto']; ?>" alt="<?php echo $row['modelo']; ?>">
            <div class="card-body">
                <h3><?php echo $row['marca']; ?> <?php echo $row['modelo']; ?></h3>
                
                <div class="caracteristicas">
                    <div class="caracteristica">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Año: <?php echo $row['anio']; ?></span>
                    </div>
                    
                    <div class="caracteristica">
                        <i class="fas fa-palette"></i>
                        <span>Color: <?php echo $row['color']; ?></span>
                    </div>
                    
                    <div class="caracteristica">
                        <i class="fas fa-chair"></i>
                        <span>Asientos: <?php echo $row['asientos']; ?></span>
                    </div>
                    
                    <div class="caracteristica">
                        <i class="fas fa-cogs"></i>
                        <span><?php echo $row['transmision']; ?></span>
                    </div>
                    
                    <div class="caracteristica">
                        <?php if($row['aire']): ?>
                            <i class="fas fa-snowflake"></i>
                            <span>Aire Acondicionado</span>
                        <?php else: ?>
                            <i class="fas fa-times"></i>
                            <span>Sin A/C</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="acciones">
                    <a href="editar.php?id=<?php echo $row['id']; ?>" class="btn btn-editar">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="eliminar.php?id=<?php echo $row['id']; ?>" class="btn btn-eliminar" onclick="return confirm('¿Seguro que quieres eliminar este carro?');">
                        <i class="fas fa-trash"></i> Eliminar
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    
    

    <script>
        let carroIdActual = null;
        
        // Función para editar precio
        function editarPrecio(id, precioActual) {
            carroIdActual = id;
            document.getElementById('nuevoPrecio').value = precioActual;
            document.getElementById('modalPrecio').style.display = 'block';
        }
        
        // Función para guardar nuevo precio
        function guardarPrecio() {
            const nuevoPrecio = document.getElementById('nuevoPrecio').value;
            if (nuevoPrecio && nuevoPrecio > 0) {
                // Enviar datos por AJAX
                fetch('actualizar_precio.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${carroIdActual}&precio=${nuevoPrecio}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Recargar la página para ver los cambios
                    } else {
                        alert('Error al actualizar el precio');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al conectar con el servidor');
                });
                
                cerrarModal();
            } else {
                alert('Por favor ingrese un precio válido');
            }
        }
        
        // Función para cambiar estado
        function cambiarEstado(id, estadoActual) {
            const nuevoEstado = estadoActual ? 0 : 1; // Invertir estado
            const textoEstado = nuevoEstado ? 'disponible' : 'alquilado';
            
            if (confirm(`¿Cambiar estado a ${textoEstado}?`)) {
                fetch('cambiar_estado.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}&estado=${nuevoEstado}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Recargar la página para ver los cambios
                    } else {
                        alert('Error al cambiar el estado');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al conectar con el servidor');
                });
            }
        }
        
        // Función para cerrar modal
        function cerrarModal() {
            document.getElementById('modalPrecio').style.display = 'none';
            carroIdActual = null;
        }
        
        // Cerrar modal si se hace click fuera de él
        window.onclick = function(event) {
            const modal = document.getElementById('modalPrecio');
            if (event.target == modal) {
                cerrarModal();
            }
        }
    </script>
    
</body>
</html>