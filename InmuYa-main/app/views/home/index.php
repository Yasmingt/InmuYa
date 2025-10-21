<?php
/**
 * Vista de la Página Principal
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Esta vista muestra el contenido de la página principal
 * usando el layout específico para index
 */

// Definir variables para el layout
$title = 'InmuYa';

// Incluir el layout específico para index
include __DIR__ . '/../layouts/index.php';
?>


<!-- Sección Nosotros -->
<section id="nosotros" class="seccion seccion-nosotros" role="region" aria-labelledby="nosotros-titulo">
    <div class="contenedor-seccion">
        <header>
            <h2 id="nosotros-titulo" class="titulo-seccion">Sobre Nosotros</h2>
            <p class="subtitulo-seccion">Facilitamos conexiones inmobiliarias confiables y transparentes</p>
        </header>
        
        <div class="valores-nosotros iconos-nosotros" role="list">
            <article class="valor-item icono" role="listitem">
                <img src="<?php echo BASE_URL; ?>public/img/candado.png" alt="Icono de seguridad" loading="lazy" width="64" height="64">
                <h3>Seguridad</h3>
                <p>Verificamos la identidad de todos nuestros usuarios para garantizar transacciones seguras.</p>
            </article>
            <article class="valor-item icono" role="listitem">
               <img src="<?php echo BASE_URL; ?>public/img/dinero.png" alt="Icono de precio justo" loading="lazy" width="64" height="64">
               <h3>Precio Justo</h3>
               <p>Ofrecemos precios competitivos y transparentes en el mercado inmobiliario.</p>
            </article>
            <article class="valor-item icono" role="listitem">
                <img src="<?php echo BASE_URL; ?>public/img/chequeo-de-tiempo.png" alt="Icono de puntualidad" loading="lazy" width="64" height="64">
                <h3>A Tiempo</h3>
                <p>Procesos ágiles y eficientes para que encuentres tu hogar rápidamente.</p>
            </article>
        </div>
    </div>
</section>

<!-- Sección Servicios -->
<section id="servicios" class="seccion" role="region" aria-labelledby="servicios-titulo">
    <div class="contenedor-seccion">
        <header>
            <h2 id="servicios-titulo" class="titulo-seccion">Nuestros Servicios</h2>
            <p class="subtitulo-seccion">Soluciones completas para todas tus necesidades inmobiliarias</p>
        </header>
        
        <div class="servicios-grid" role="list">
            <article class="servicio-card" role="listitem">
                <h3>Búsqueda Avanzada</h3>
                <p>Encuentra la propiedad perfecta usando nuestros filtros inteligentes por ubicación, precio, características y más.</p>
            </article>
            
            <article class="servicio-card" role="listitem">
                <h3>Publicación Premium</h3>
                <p>Publica tu propiedad con fotos profesionales, tours virtuales y descripciones detalladas.</p>
            </article>
            
            <article class="servicio-card" role="listitem">
                <h3>Verificación de Usuarios</h3>
                <p>Sistema completo de verificación de identidad para garantizar la confiabilidad de todos nuestros usuarios.</p>
            </article>
            
            <article class="servicio-card" role="listitem">
                <h3>Asesoría Financiera</h3>
                <p>Te ayudamos a calcular costos, evaluar opciones de financiamiento y tomar las mejores decisiones económicas.</p>
            </article>
        </div>
    </div>
</section>

<!-- Sección Propiedades -->
<section id="productos" class="seccion seccion-productos" role="region" aria-labelledby="productos-titulo">
    <div class="contenedor-seccion">
        <header>
            <h2 id="productos-titulo" class="titulo-seccion">Propiedades Destacadas</h2>
            <p class="subtitulo-seccion">Descubre las mejores opciones disponibles en nuestra plataforma</p>
        </header>
        
        <!-- Carrusel de Propiedades Destacadas -->
        <div class="carousel-container" data-properties="<?php echo count($propiedadesDestacadas); ?>">
            <div class="carousel-wrapper">
                <div class="carousel-track" id="carouselTrack">
                    <?php if (!empty($propiedadesDestacadas)): ?>
                        <?php foreach ($propiedadesDestacadas as $propiedad): ?>
                        <div class="carousel-slide">
                            <article class="producto-card" role="listitem">
                                <div class="imagen-producto">
                                    <img src="<?php echo $propiedad['imagen_principal']; ?>" 
                                         alt="<?php echo htmlspecialchars($propiedad['titulo']); ?>" 
                                         loading="lazy">
                                    <div class="etiqueta-precio">
                                        $<?php echo number_format($propiedad['precio']); ?>
                                        <?php if ($propiedad['tipo'] === 'arriendo'): ?>
                                            /mes
                                        <?php endif; ?>
                                    </div>
                                    <div class="badge-destacado">⭐ Destacado</div>
                                </div>
                                <div class="contenido-producto">
                                    <h3><?php echo htmlspecialchars($propiedad['titulo']); ?></h3>
                                    <p class="direccion-propiedad">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?php echo htmlspecialchars($propiedad['direccion']); ?>
                                        <?php if ($propiedad['ciudad_nombre']): ?>
                                            , <?php echo htmlspecialchars($propiedad['ciudad_nombre']); ?>
                                        <?php endif; ?>
                                    </p>
                                    <div class="caracteristicas-propiedad">
                                        <span class="caracteristica">
                                            <i class="fas fa-bed" aria-hidden="true"></i>
                                            <span><?php echo $propiedad['habitaciones']; ?> Hab</span>
                                        </span>
                                        <span class="caracteristica">
                                            <i class="fas fa-bath" aria-hidden="true"></i>
                                            <span><?php echo $propiedad['banos']; ?> Baños</span>
                                        </span>
                                        <?php if ($propiedad['parqueadero']): ?>
                                            <span class="caracteristica">
                                                <i class="fas fa-car" aria-hidden="true"></i>
                                                <span>Garaje</span>
                                            </span>
                                        <?php endif; ?>
                                        <span class="caracteristica">
                                            <i class="fas fa-ruler-combined" aria-hidden="true"></i>
                                            <span><?php echo $propiedad['area']; ?> m²</span>
                                        </span>
                                    </div>
                                    <div class="botones-producto">
                                        <a href="<?php echo BASE_URL; ?>auth/login" 
                                           class="boton-producto boton-detalles" aria-label="Iniciar sesión para ver detalles">
                                            <i class="fas fa-sign-in-alt" aria-hidden="true"></i> Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-properties">
                            <p>No hay propiedades destacadas disponibles en este momento.</p>
                            <a href="<?php echo BASE_URL; ?>propiedades" class="btn btn-principal">
                                <i class="fas fa-home"></i>
                                Ver Todas las Propiedades
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Controles del carrusel -->
                <button class="carousel-btn carousel-prev" aria-label="Propiedad anterior">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="carousel-btn carousel-next" aria-label="Siguiente propiedad">
                    <i class="fas fa-chevron-right"></i>
                </button>
                
                <!-- Indicadores del carrusel -->
                <div class="carousel-indicators" style="display: <?php echo count($propiedadesDestacadas) > 3 ? 'flex' : 'none'; ?>;">
                    <?php if (!empty($propiedadesDestacadas) && count($propiedadesDestacadas) > 3): ?>
                        <?php 
                        $totalPages = ceil(count($propiedadesDestacadas) / 3);
                        for ($i = 0; $i < $totalPages; $i++): 
                        ?>
                            <button class="carousel-indicator <?php echo $i === 0 ? 'active' : ''; ?>" 
                                    data-slide="<?php echo $i; ?>" 
                                    aria-label="Ir a página <?php echo $i + 1; ?>"></button>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección Contacto -->
<section id="contacto" class="seccion seccion-contacto" role="region" aria-labelledby="contacto-titulo">
    <div class="contenedor-seccion">
        <h2 id="contacto-titulo" class="titulo-seccion">Contáctanos</h2>
        <p class="subtitulo-seccion">Estamos aquí para ayudarte en cada paso del proceso</p>
        
        <div class="contenido-contacto">
            <div class="info-contacto">
                <h3>¿Tienes alguna pregunta?</h3>
                <p>Nuestro equipo de expertos está listo para asistirte con cualquier consulta sobre propiedades, servicios o procesos.</p>
                
                <div class="item-contacto">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <strong>Dirección</strong><br>
                        Calle 123 #45-67, Medellín, Antioquia<br>
                        Colombia
                    </div>
                </div>
                
                <div class="item-contacto">
                    <i class="fas fa-phone"></i>
                    <div>
                        <strong>Teléfonos</strong><br>
                        +57 (4) 123-4567<br>
                        Línea Nacional: 01 8000 123 456
                    </div>
                </div>
                
                <div class="item-contacto">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <strong>Email</strong><br>
                        inmuyavpt@gmail.com<br>
                        soporte@inmuya.com
                    </div>
                </div>
            </div>
            
            <form class="formulario-contacto" action="<?php echo BASE_URL; ?>contactar-propiedad" method="POST" role="form">
                <?php if (isset($_GET['contact_error'])): ?>
                    <div class="mensaje-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo htmlspecialchars($_GET['contact_error']); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['contact_success']) && $_GET['contact_success'] == '1'): ?>
                    <!-- Notificación de éxito simple -->
                    <div class="notification-success" id="notification-success">
                        <i class="fas fa-check-circle"></i>
                        <div class="notification-message">
                            <strong>¡Mensaje enviado correctamente!</strong>
                            <span>En breve nos pondremos en contacto contigo.</span>
                        </div>
                    </div>
                    <script>
                        // Mostrar notificación automáticamente sin mover la vista
                        setTimeout(function() {
                            const notification = document.getElementById('notification-success');
                            if (notification) {
                                notification.classList.add('show');
                            }
                        }, 200);
                        
                        // Auto-cerrar después de 4 segundos
                        setTimeout(function() {
                            const notification = document.getElementById('notification-success');
                            if (notification) {
                                notification.classList.remove('show');
                                setTimeout(function() {
                                    notification.remove();
                                }, 300);
                            }
                        }, 4000);
                        
                        // Limpiar URL sin mover la vista
                        setTimeout(function() {
                            if (window.history.replaceState) {
                                window.history.replaceState({}, document.title, window.location.pathname);
                            }
                        }, 3000);
                    </script>
                <?php endif; ?>
                
                <fieldset>
                    <legend>Información de Contacto</legend>
                    
                    <div class="grupo-formulario">
                        <label for="nombre">Nombre Completo *</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>
                    
                    <div class="grupo-formulario">
                        <label for="email">Correo Electrónico *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="grupo-formulario">
                        <label for="asunto">Asunto *</label>
                        <input type="text" id="asunto" name="asunto" required>
                    </div>
                    
                    <div class="grupo-formulario">
                        <label for="mensaje">Mensaje *</label>
                        <textarea id="mensaje" name="mensaje" required></textarea>
                    </div>
                </fieldset>
                
                <button type="submit" class="boton-enviar">
                    <i class="fas fa-paper-plane"></i> Enviar Mensaje
                </button>
            </form>
        </div>
    </div>
</section>

<script>
// ===== CARRUSEL DE PROPIEDADES =====
document.addEventListener('DOMContentLoaded', function() {
    const carouselTrack = document.getElementById('carouselTrack');
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');
    const indicators = document.querySelectorAll('.carousel-indicator');
    
    if (!carouselTrack || !prevBtn || !nextBtn) return;
    
    let currentSlide = 0;
    const totalSlides = document.querySelectorAll('.carousel-slide').length;
    
    // Función para obtener el número de propiedades visibles según el tamaño de pantalla y número de propiedades
    function getVisibleSlides() {
        const totalProperties = parseInt(carouselTrack.parentElement.parentElement.getAttribute('data-properties'));
        
        if (window.innerWidth <= 768) {
            return 1; // 1 propiedad en móvil
        } else if (window.innerWidth <= 1024) {
            return Math.min(2, totalProperties); // 2 propiedades en tablet, máximo las disponibles
        } else {
            return Math.min(3, totalProperties); // 3 propiedades en desktop, máximo las disponibles
        }
    }
    
    // Función para obtener el porcentaje de movimiento según el número de propiedades visibles
    function getSlidePercentage() {
        const visibleSlides = getVisibleSlides();
        return 100 / visibleSlides;
    }
    
    // Función para actualizar el carrusel
    function updateCarousel() {
        const slidePercentage = getSlidePercentage();
        const translateX = -currentSlide * slidePercentage;
        carouselTrack.style.transform = `translateX(${translateX}%)`;
        
        // Actualizar indicadores
        const visibleSlides = getVisibleSlides();
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === Math.floor(currentSlide / visibleSlides));
        });
        
        // Ocultar/mostrar botones según la posición
        const visibleSlidesCount = getVisibleSlides();
        const maxSlides = Math.ceil(totalSlides / visibleSlidesCount) - 1;
        
        // Solo mostrar botones si hay más propiedades que las visibles
        if (totalSlides <= visibleSlidesCount) {
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
        } else {
            prevBtn.style.display = currentSlide === 0 ? 'none' : 'flex';
            nextBtn.style.display = currentSlide >= maxSlides * visibleSlidesCount ? 'none' : 'flex';
        }
    }
    
    // Botón anterior
    prevBtn.addEventListener('click', function() {
        const visibleSlides = getVisibleSlides();
        if (totalSlides > visibleSlides && currentSlide > 0) {
            currentSlide = Math.max(0, currentSlide - visibleSlides);
            updateCarousel();
        }
    });
    
    // Botón siguiente
    nextBtn.addEventListener('click', function() {
        const visibleSlides = getVisibleSlides();
        const maxSlides = Math.ceil(totalSlides / visibleSlides) - 1;
        if (totalSlides > visibleSlides && currentSlide < maxSlides * visibleSlides) {
            currentSlide = Math.min(maxSlides * visibleSlides, currentSlide + visibleSlides);
            updateCarousel();
        }
    });
    
    // Indicadores
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', function() {
            const visibleSlides = getVisibleSlides();
            currentSlide = index * visibleSlides;
            updateCarousel();
        });
    });
    
    // Inicializar carrusel
    updateCarousel();
    
    // Ajustar carrusel al cambiar el tamaño de la ventana
    window.addEventListener('resize', function() {
        updateCarousel();
    });
    
    // Soporte para teclado
    document.addEventListener('keydown', function(e) {
        const visibleSlides = getVisibleSlides();
        const maxSlides = Math.ceil(totalSlides / visibleSlides) - 1;
        if (e.key === 'ArrowLeft' && currentSlide > 0) {
            currentSlide = Math.max(0, currentSlide - visibleSlides);
            updateCarousel();
        } else if (e.key === 'ArrowRight' && currentSlide < maxSlides * visibleSlides) {
            currentSlide = Math.min(maxSlides * visibleSlides, currentSlide + visibleSlides);
            updateCarousel();
        }
    });
    
    // Soporte para touch/swipe en móviles
    let startX = 0;
    let endX = 0;
    
    carouselTrack.addEventListener('touchstart', function(e) {
        startX = e.touches[0].clientX;
    });
    
    carouselTrack.addEventListener('touchend', function(e) {
        endX = e.changedTouches[0].clientX;
        const diffX = startX - endX;
        
        if (Math.abs(diffX) > 50) { // Mínimo de 50px para considerar swipe
            const visibleSlides = getVisibleSlides();
            const maxSlides = Math.ceil(totalSlides / visibleSlides) - 1;
            if (diffX > 0 && currentSlide < maxSlides * visibleSlides) {
                // Swipe izquierda - siguiente grupo
                currentSlide = Math.min(maxSlides * visibleSlides, currentSlide + visibleSlides);
                updateCarousel();
            } else if (diffX < 0 && currentSlide > 0) {
                // Swipe derecha - grupo anterior
                currentSlide = Math.max(0, currentSlide - visibleSlides);
                updateCarousel();
            }
        }
    });
});
</script>

<?php
// Incluir el footer
include __DIR__ . '/../layouts/footer.php';
?>
