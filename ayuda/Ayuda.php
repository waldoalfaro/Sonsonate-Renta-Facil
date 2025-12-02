<?php include '../seguridad.php'; ?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include "../menu.php";?>

<div class="p-4 sm:ml-64">
    <div class="h-16 sm:h-20"></div>



   

    <section id="manuales" class="section manuales-section">
        <div class="container">
            <h2 class="section-title">
                <i class="fas fa-book"></i>
                Manuales de uso
            </h2>
            <p class="section-description">Consulta y descarga los manuales</p>
            
            <div class="manuales-grid">
                <div class="manual-card">
                    <div class="manual-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3 class="manual-title">Documentación</h3>
                    <p class="manual-description">Documentación completa del sistema.</p>
                    <div class="manual-buttons">
                        <button class="btn btn-primary" onclick="openManual('cliente')">
                            <i class="fas fa-eye"></i> Visualizar
                        </button>
                        <a href="manuales/" download class="btn btn-secondary">
                            <i class="fas fa-download"></i> Descargar
                        </a>
                    </div>
                </div>

                <div class="manual-card">
                    <div class="manual-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="manual-title">Manual de Administrador</h3>
                    <p class="manual-description">Instrucciones detalladas para administradores.</p>
                    <div class="manual-buttons">
                        <button class="btn btn-primary" onclick="openManual('administrador')">
                            <i class="fas fa-eye"></i> Visualizar
                        </button>
                        <a href="manuales/" download class="btn btn-secondary">
                            <i class="fas fa-download"></i> Descargar
                        </a>
                    </div>
                </div>

                <div class="manual-card">
                    <div class="manual-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="manual-title">Manual de Usuarios</h3>
                    <p class="manual-description">Guía para sobre las funcionalidades del sistema.</p>
                    <div class="manual-buttons">
                        <button class="btn btn-primary" onclick="openManual('empleado')">
                            <i class="fas fa-eye"></i> Visualizar
                        </button>
                        <a href="manuales/Manualusuario.pdf" download class="btn btn-secondary">
                            <i class="fas fa-download"></i> Descargar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="videos" class="section videos-section">
    <div class="container">
        <h2 class="section-title">
            <i class="fas fa-video"></i> Videos Tutoriales
        </h2>

        <p class="section-description">
            A continuación encontrarás una serie de videos tutoriales correspondientes a cada módulo del sistema.
        </p>
        <p class="section-description">
            También puedes verlos en nuestra lista de reproducción en YouTube:
            <a href="https://youtube.com/playlist?list=PLlbrpDF6S-G9t7li1pe5BtWh6nbHCjepz&si=rap5QcY8OhKe6aJF" target="_blank">
                Ver PlayList
            </a>
        </p>

        <div class="videos-grid">

            <div class="video-card">
                <div class="video-container">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/M8g2MGvM0ac?si=Or9pii2eGdnXKUke" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <div class="video-info">
                    <h3 class="video-title">Gestión de Usuarios</h3>
                    <p class="video-description">Aprende a crear, editar, asignar roles y administrar usuarios dentro del sistema.</p>
                </div>
            </div>

            <div class="video-card">
                <div class="video-container">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/R9Fse93MrXw?si=PT1M_wDTtR7EuB7-" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <div class="video-info">
                    <h3 class="video-title">Gestión de Vehículos</h3>
                    <p class="video-description">Descubre cómo registrar vehículos, administrar su información y controlar su disponibilidad.</p>
                </div>
            </div>

            <div class="video-card">
                <div class="video-container">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/dsIs7l-WYO0?si=S3vuHOnitCyE9imd" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <div class="video-info">
                    <h3 class="video-title">Gestión de Categorías</h3>
                    <p class="video-description">Aprende a crear nuevas categorías y organizar adecuadamente el inventario de vehículos.</p>
                </div>
            </div>

            <div class="video-card">
                <div class="video-container">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/qM1qXePwUGw?si=yBlmtO05pZKWMBe-" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <div class="video-info">
                    <h3 class="video-title">Gestión de Contratos</h3>
                    <p class="video-description">Guía completa para gestionar contratos, y descargar contrto en PDF.</p>
                </div>
            </div>

            <div class="video-card">
                <div class="video-container">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/YudAr3yeZBQ?si=FrrTw0sD4wG0OCDf" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <div class="video-info">
                    <h3 class="video-title">Gestión de Promociones</h3>
                    <p class="video-description">Aprende a crear y administrar.</p>
                </div>
            </div>

            <div class="video-card">
                <div class="video-container">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/XfKThZ1Ji9Y?si=BW09GyW56EJwIZN-" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <div class="video-info">
                    <h3 class="video-title">Gestión de Mantenimientos</h3>
                    <p class="video-description">Aprende a registrar mantenimientos, así como su historial.</p>
                </div>
            </div>

            <div class="video-card">
                <div class="video-container">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/U-4sUQqdbmU?si=qcw2USq2CO3LKIaR" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
                <div class="video-info">
                    <h3 class="video-title">Gestión de Reservaciones</h3>
                    <p class="video-description">Aprende a registrar reservaciones, verificar disponibilidad y administrar el proceso de alquiler.</p>
                </div>
            </div>
        </div>
    </div>
</section>

    <div id="pdfModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle" class="modal-title"></h2>
                <div class="modal-actions">
                    <a id="downloadBtn" href="#" download class="btn btn-download">
                        <i class="fas fa-download"></i> Descargar PDF
                    </a>
                    <button class="close-btn" onclick="closeModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <iframe id="pdfViewer" src="" frameborder="0"></iframe>
            </div>
        </div>
    </div>

    

</div>

    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="script.js"></script>
</body>
</html>
