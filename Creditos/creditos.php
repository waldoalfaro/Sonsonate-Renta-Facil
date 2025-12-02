<?php include '../seguridad.php';  ?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="styles1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
</head>

<body>

<?php include "../menu.php";?>

<div class="p-4 sm:ml-64">
         <div class="h-16 sm:h-20"></div>



    <section class="credits-section">
        <div class="container">
            <div class="section-header">
                <h2 class="subtitle">Derechos y Créditos del Equipo</h2>
                <p class="description">Conoce al equipo de profesionales que hicieron posible este sistema</p>
            </div>

            <div class="team-grid">
                <!-- Integrante 1 - Scrum Master -->
                <div class="team-card"
                    data-name="Nelson Stanley Venis"
                    data-role="Scrum Master"
                    data-email="nvenimora@gmail.com"
                    data-description="Responsable de facilitar el proceso Scrum y remover impedimentos del equipo."
                    data-photo="images/stanley.jpeg">

                    <div class="card-image">
                        <img src="images/stanley.jpeg" alt="">
                    </div>
                    <div class="card-content">
                        <h3 class="member-name">Nelson Stanley Venis</h3>
                        <p class="member-role">Scrum Master</p>
                        <p><i class="fas fa-briefcase" aria-hidden="true"></i> Lider del equipo</p>
                    </div>
                </div>


                 <div class="team-card"
                    data-name="José Elias Majano"
                    data-role="Team Scrum"
                    data-email="Joselovato020@gmail.com"
                    data-description="Define la visión del producto y prioriza las funcionalidades del
                            sistema"
                    data-photo="images/majano.jpg">

                    <div class="card-image">
                        <img src="images/majano.jpg" alt="">
                    </div>
                    <div class="card-content">
                        <h3 class="member-name">José Elías Majano</h3>
                        <p class="member-role">Team Scrum</p>
                        <p><i class="fas fa-briefcase" aria-hidden="true"></i> Visión del producto</p>
                    </div>
                </div>

                 <div class="team-card"
                    data-name="José Oswaldo Alfaro"
                    data-role="Team Scrum"
                    data-email="waldoalfa011@gmail.com"
                    data-description="Desarrollo de base de datos y lógica de negocio del
                            sistema"
                    data-photo="images/waldo.png">

                    <div class="card-image">
                        <img src="images/waldo.png" alt="">
                    </div>
                    <div class="card-content">
                        <h3 class="member-name">José Oswaldo Alfaro</h3>
                        <p class="member-role">Team Scrum</p>
                        <p><i class="fas fa-briefcase" aria-hidden="true"></i> Lógica del negocio</p>
                    </div>
                </div>

                 <div class="team-card"
                    data-name="Dennis Steven Zaldaña"
                    data-role="Team Scrum"
                    data-email="sanchezdennis114@gmail.com"
                    data-description="Aseguramiento de calidad, pruebas y validación del sistema."
                    data-photo="images/dennis.jpg">

                    <div class="card-image">
                        <img src="images/dennis.jpg" alt="">
                    </div>
                    <div class="card-content">
                        <h3 class="member-name">Dennis Steven Zaldaña</h3>
                        <p class="member-role">Team Scrum</p>
                        <p><i class="fas fa-briefcase" aria-hidden="true"></i> Control de calidad</p>
                    </div>
                </div>
            </div>

            <div class="footer-credits">
                <p>&copy; 2025 Sistema-Renta-Fácil. Todos los derechos reservados.</p>
                <p>Desarrollado con dedicación por nuestro equipo Scrum</p>
            </div>
        </div>
    </section>

    <div id="teamModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>

            <img id="modal-photo" class="modal-photo" src="" alt="">
            <h2 id="modal-name"></h2>
            <h4 id="modal-role"></h4>
            <p><strong>Correo: </strong><span id="modal-email"></span></p>
            <p id="modal-description"></p>
        </div>
    </div>
</div>

<style>

    /* ===== Grid general ===== */
.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
    padding: 20px;
}

/* ===== Tarjetas del equipo ===== */
.team-card {
    background: #ffffff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 18px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
}

.team-card:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 12px 25px rgba(0,0,0,0.20);
}

/* Imagen */
.card-image img {
    width: 100%;
    height: 240px;
    object-fit: cover;
    transition: transform .3s ease;
}

.team-card:hover .card-image img {
    transform: scale(1.05);
}

/* Contenido */
.card-content {
    padding: 18px;
    text-align: center;
}

.member-name {
    font-size: 1.4rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 5px;
}

.member-role {
    font-size: 1rem;
    color: #666;
    margin-bottom: 12px;
}

.card-content i {
    color: #0059ff;
}

.card-content p {
    margin: 4px 0;
}

/* ===== Modal personalizado ===== */
.modal {
    display: none;
    position: fixed;
    z-index: 3000;
    inset: 0;
    background: rgba(0,0,0,0.7);
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(4px);
}

/* Caja del modal */
.modal-content {
    background: linear-gradient(135deg, #ffffff, #f2f4ff);
    padding: 30px;
    width: 90%;
    max-width: 480px;
    border-radius: 22px;
    box-shadow: 0 10px 35px rgba(0,0,0,0.2);
    text-align: center;
    position: relative;
    animation: fadeIn .3s ease;
}

/* Foto circular más elegante */
.modal-photo {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    border: 5px solid #ffffff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    margin-bottom: 15px;
}

/* Títulos */
#modal-name {
    font-size: 1.8rem;
    color: #2b2b2b;
    margin-bottom: 5px;
    font-weight: 800;
}

#modal-role {
    font-size: 1.2rem;
    color: #555;
    margin-bottom: 15px;
}

/* Descripción */
#modal-description {
    font-size: 1rem;
    color: #444;
    margin-top: 10px;
    line-height: 1.5;
}

/* Botón cerrar */
.close {
    position: absolute;
    top: 12px;
    right: 16px;
    font-size: 28px;
    color: #444;
    cursor: pointer;
    transition: color .3s;
}

.close:hover {
    color: #e60000;
}



/* Animación */
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(-10px) scale(0.95);}
    to {opacity: 1; transform: translateY(0) scale(1);}
}

</style>

<script>
document.querySelectorAll(".team-card").forEach(card => {
    card.addEventListener("click", () => {
        document.getElementById("modal-name").textContent = card.dataset.name;
        document.getElementById("modal-role").textContent = card.dataset.role;
        document.getElementById("modal-email").textContent = card.dataset.email;
        document.getElementById("modal-description").textContent = card.dataset.description;
        document.getElementById("modal-photo").src = card.dataset.photo;

        document.getElementById("teamModal").style.display = "flex";
    });
});

// Cerrar modal
document.querySelector(".close").onclick = () => {
    document.getElementById("teamModal").style.display = "none";
};

window.onclick = (e) => {
    if (e.target == document.getElementById("teamModal")) {
        document.getElementById("teamModal").style.display = "none";
    }
};
</script>

</body>

</html>