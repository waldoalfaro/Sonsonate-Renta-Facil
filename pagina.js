
// Variables para el carrusel
let slideIndex = 1;
let heroSlideIndex = 1;


// Función para el menú hamburguesa
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
        
        // Cerrar menú al hacer click en un enlace
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
            });
        });
    }
    
    // Inicializar carruseles
    showSlide(slideIndex);
    showHeroSlide(heroSlideIndex);
    
    // Auto-play del carrusel de promociones
    setInterval(function() {
        changeSlide(1);
    }, 5000);
    
    // Auto-play del carrusel del hero
    setInterval(function() {
        changeHeroSlide(1);
    }, 4000);
});

// Función para cambiar slide del carrusel
function changeSlide(n) {
    showSlide(slideIndex += n);
}

// Función para ir a un slide específico
function currentSlide(n) {
    showSlide(slideIndex = n);
}

// Función para mostrar slide
function showSlide(n) {
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.dot');
    
    if (slides.length === 0) return;
    
    if (n > slides.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length;
    }
    
    // Ocultar todos los slides
    slides.forEach(slide => {
        slide.classList.remove('active');
    });
    
    // Remover clase active de todos los dots
    dots.forEach(dot => {
        dot.classList.remove('active');
    });
    
    // Mostrar slide actual
    if (slides[slideIndex - 1]) {
        slides[slideIndex - 1].classList.add('active');
    }
    
    // Activar dot correspondiente
    if (dots[slideIndex - 1]) {
        dots[slideIndex - 1].classList.add('active');
    }
}

// Smooth scrolling para los enlaces de navegación
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Función para los botones de "Ver Vehículos" y "Rentar Ahora"
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-primary') || e.target.classList.contains('btn-secondary')) {
        if (e.target.textContent.includes('Ver Vehículos')) {
            document.querySelector('#vehiculos').scrollIntoView({
                behavior: 'smooth'
            });
        } else if (e.target.textContent.includes('Rentar') || e.target.textContent.includes('Reserva') || e.target.textContent.includes('Cotizar') || e.target.textContent.includes('Aprovecha')) {
            window.open('https://wa.me/50378678421?text=Hola%2C%20quiero%20rentar%20un%20veh%C3%ADculo%20con%20Renta%20F%C3%A1cil', '_blank');
        }
    }
});

// Animación al hacer scroll
window.addEventListener('scroll', function() {
    const header = document.querySelector('.header');
    if (window.scrollY > 100) {
        header.style.background = 'rgba(0, 0, 0, 0.95)';
    } else {
        header.style.background = '#000';
    }
});

// Animación de entrada para las tarjetas
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
});

// Observar elementos para animación
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.vehicle-card, .about-card');
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(50px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});

// Función para validar formularios (para futuras implementaciones)
function validateForm(form) {
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.style.borderColor = '#ff0000';
        } else {
            input.style.borderColor = '#FFD700';
        }
    });
    
    return isValid;
}

// Funciones adicionales para mejorar la experiencia del usuario
function showLoading() {
    const loader = document.createElement('div');
    loader.className = 'loader';
    loader.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando...';
    loader.style.cssText = `
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.8);
        color: #FFD700;
        padding: 20px;
        border-radius: 10px;
        z-index: 9999;
        font-size: 1.2rem;
    `;
    document.body.appendChild(loader);
    
    setTimeout(() => {
        if (document.body.contains(loader)) {
            document.body.removeChild(loader);
        }
    }, 2000);
}

// Funciones para el carrusel del hero
function changeHeroSlide(n) {
    showHeroSlide(heroSlideIndex += n);
}

function currentHeroSlide(n) {
    showHeroSlide(heroSlideIndex = n);
}

function showHeroSlide(n) {
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-dot');
    
    if (slides.length === 0) return;
    
    if (n > slides.length) {
        heroSlideIndex = 1;
    }
    if (n < 1) {
        heroSlideIndex = slides.length;
    }
    
    // Ocultar todos los slides del hero
    slides.forEach(slide => {
        slide.classList.remove('active');
    });
    
    // Remover clase active de todos los dots del hero
    dots.forEach(dot => {
        dot.classList.remove('active');
    });
    
    // Mostrar slide actual del hero
    if (slides[heroSlideIndex - 1]) {
        slides[heroSlideIndex - 1].classList.add('active');
    }
    
    // Activar dot correspondiente del hero
    if (dots[heroSlideIndex - 1]) {
        dots[heroSlideIndex - 1].classList.add('active');
    }
}

// Efecto parallax suave para el hero
window.addEventListener('scroll', function() {
    const scrolled = window.pageYOffset;
    const heroSlides = document.querySelectorAll('.hero-slide img');
    heroSlides.forEach(slide => {
        const rate = scrolled * -0.3;
        slide.style.transform = `translateY(${rate}px)`;
    });
});

//para el area de promociones//
function copyCode(code) {
  navigator.clipboard.writeText(code).then(function() {
    // Mostrar feedback visual
    alert('¡Código copiado: ' + code + '!');
  }).catch(function(err) {
    console.error('Error al copiar: ', err);
  });
}