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
                <div class="servicio-icono" aria-hidden="true">
                    <i class="fas fa-search-plus"></i>
                </div>
                <h3>Búsqueda Avanzada</h3>
                <p>Encuentra la propiedad perfecta usando nuestros filtros inteligentes por ubicación, precio, características y más.</p>
            </article>
            
            <article class="servicio-card" role="listitem">
                <div class="servicio-icono" aria-hidden="true">
                    <i class="fas fa-camera"></i>
                </div>
                <h3>Publicación Premium</h3>
                <p>Publica tu propiedad con fotos profesionales, tours virtuales y descripciones detalladas.</p>
            </article>
            
            <article class="servicio-card" role="listitem">
                <div class="servicio-icono" aria-hidden="true">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Verificación de Usuarios</h3>
                <p>Sistema completo de verificación de identidad para garantizar la confiabilidad de todos nuestros usuarios.</p>
            </article>
            
            <article class="servicio-card" role="listitem">
                <div class="servicio-icono" aria-hidden="true">
                    <i class="fas fa-calculator"></i>
                </div>
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
        <div class="carousel-container">
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
                                    <div class="meta-propiedad">
                                        <span class="vistas-propiedad">
                                            <i class="fas fa-eye"></i>
                                            <?php echo $propiedad['vistas']; ?> vistas
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
                <div class="carousel-indicators">
                    <?php if (!empty($propiedadesDestacadas)): ?>
                        <?php for ($i = 0; $i < count($propiedadesDestacadas); $i++): ?>
                            <button class="carousel-indicator <?php echo $i === 0 ? 'active' : ''; ?>" 
                                    data-slide="<?php echo $i; ?>" 
                                    aria-label="Ir a la propiedad <?php echo $i + 1; ?>"></button>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Variables CSS del sistema */
:root {
    --color-principal: rgba(12, 97, 136, 0.589);
    --color-secundario: #072638;
    --color-terciario: #4883A5;
    --color-gris: #555;
    --color-blanco: white;
    --color-negro: black;
    --fuente-principal: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    --color-gris-claro: #ecf0f1;
    --color-verde: #27ae60;
    --color-rojo: #e74c3c;
    --sombra-suave: 0 4px 20px rgba(0, 0, 0, 0.1);
    --sombra-hover: 0 8px 30px rgba(0, 0, 0, 0.15);
    --transicion: all 0.3s ease;
    --border-radius: 12px;
    --border-radius-boton: 25px;
}

/* ===== CARRUSEL DE PROPIEDADES ===== */
.carousel-container {
    position: relative;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    overflow: hidden;
    border-radius: 15px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.carousel-wrapper {
    position: relative;
    width: 100%;
    height: 100%;
}

.carousel-track {
    display: flex;
    transition: transform 0.5s ease-in-out;
    width: 100%;
}

.carousel-slide {
    min-width: 33.333%;
    flex-shrink: 0;
    padding: 0 10px;
}

/* ===== TARJETAS DE PROPIEDAD ===== */
.producto-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.producto-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.2);
}

.imagen-producto {
    position: relative;
    height: 200px; /* Reducido de 250px a 200px */
    overflow: hidden;
}

.imagen-producto img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.producto-card:hover .imagen-producto img {
    transform: scale(1.05);
}

.etiqueta-precio {
    position: absolute;
    bottom: 15px;
    right: 15px;
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 10px 12px; /* Aumentado para igualar altura visual con destacado */
    border-radius: 20px;
    font-weight: bold;
    font-size: 0.8rem;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 32px; /* Altura mínima aumentada para coincidir visualmente */
    white-space: nowrap; /* Evitar que el texto se divida en líneas */
}

.badge-destacado {
    position: absolute;
    top: 15px;
    left: 15px;
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    color: #333;
    padding: 10px 12px; /* Aumentado para igualar altura visual con precio */
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 32px; /* Altura mínima aumentada para coincidir visualmente */
    white-space: nowrap; /* Evitar que el texto se divida en líneas */
}

.contenido-producto {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.contenido-producto h3 {
    font-size: 1.3rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
    line-height: 1.3;
}

.direccion-propiedad {
    color: #666;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
}

/* Icono de ubicación con color gris */
.direccion-propiedad i {
    color: #666; /* Gris para ubicación */
    font-size: 14px;
    transition: all 0.3s ease;
}

.direccion-propiedad:hover i {
    color: #333; /* Gris más oscuro al hover */
    transform: scale(1.1);
    text-shadow: 0 0 8px rgba(102, 102, 102, 0.3); /* Resplandor gris */
}

.caracteristicas-propiedad {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-bottom: 20px;
}

.caracteristica {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
    font-size: 0.9rem;
}

.caracteristica i {
    color: #667eea;
    width: 18px; /* Aumentado de 16px a 18px */
    font-size: 16px; /* Aumentado de 14px a 16px */
    margin-right: 8px; /* Aumentado de 6px a 8px */
    transition: all 0.3s ease; /* Transición suave para todos los cambios */
}

/* Iconos específicos con color gris uniforme */
.caracteristica .fa-bed {
    color: #666; /* Gris para habitaciones */
}

.caracteristica .fa-bath {
    color: #666; /* Gris para baños */
}

.caracteristica .fa-car {
    color: #666; /* Gris para parqueadero */
}

.caracteristica .fa-ruler-combined {
    color: #666; /* Gris para área */
}

/* Efectos hover para los iconos */
.caracteristica:hover i {
    transform: scale(1.15); /* Aumentado de 1.1 a 1.15 */
    transition: all 0.3s ease; /* Transición más suave */
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2)); /* Sombra sutil */
}

.caracteristica:hover .fa-bed {
    color: #333; /* Gris más oscuro al hover */
    text-shadow: 0 0 8px rgba(102, 102, 102, 0.3); /* Resplandor gris */
}

.caracteristica:hover .fa-bath {
    color: #333; /* Gris más oscuro al hover */
    text-shadow: 0 0 8px rgba(102, 102, 102, 0.3); /* Resplandor gris */
}

.caracteristica:hover .fa-car {
    color: #333; /* Gris más oscuro al hover */
    text-shadow: 0 0 8px rgba(102, 102, 102, 0.3); /* Resplandor gris */
}

.caracteristica:hover .fa-ruler-combined {
    color: #333; /* Gris más oscuro al hover */
    text-shadow: 0 0 8px rgba(102, 102, 102, 0.3); /* Resplandor gris */
}

.meta-propiedad {
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.vistas-propiedad {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.9rem;
    color: #666;
}

.botones-producto {
    display: flex;
    gap: 10px;
    margin-top: auto;
}

.boton-producto {
    flex: 1;
    padding: 10px 15px;
    border: none;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
}

/* Cuando solo hay un botón, que ocupe todo el ancho */
.botones-producto:has(.boton-producto:only-child) .boton-producto {
    flex: 1;
    width: 100%;
}

.boton-detalles {
    background: var(--color-principal);
    color: white;
    border: 2px solid var(--color-principal);
}

.boton-detalles:hover {
    background: var(--color-secundario);
    border-color: var(--color-secundario);
    transform: translateY(-2px);
}

/* ===== CONTROLES DEL CARRUSEL ===== */
.carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.9);
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: #333;
    transition: all 0.3s ease;
    z-index: 10;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.carousel-btn:hover {
    background: white;
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

.carousel-prev {
    left: 20px;
}

.carousel-next {
    right: 20px;
}

/* ===== INDICADORES DEL CARRUSEL ===== */
.carousel-indicators {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 30px;
    padding: 0 20px;
}

.carousel-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: none;
    background: #ccc;
    cursor: pointer;
    transition: all 0.3s ease;
}

.carousel-indicator.active {
    background: #667eea;
    transform: scale(1.2);
}

.carousel-indicator:hover {
    background: #999;
}

/* ===== ESTADO VACÍO ===== */
.no-properties {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.no-properties p {
    margin-bottom: 20px;
    font-size: 1.1rem;
}

.btn-principal {
    background: linear-gradient(135deg, var(--color-principal), var(--color-secundario));
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 1rem;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 20px;
}

.btn-principal:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(12, 97, 136, 0.4);
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 1024px) {
    .carousel-slide {
        min-width: 50%; /* 2 propiedades en tablet */
    }
}

@media (max-width: 768px) {
    .carousel-container {
        margin: 0 10px;
    }
    
    .carousel-slide {
        min-width: 100%; /* 1 propiedad en móvil */
    }
    
    .carousel-btn {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .carousel-prev {
        left: 10px;
    }
    
    .carousel-next {
        right: 10px;
    }
    
    .caracteristicas-propiedad {
        grid-template-columns: 1fr;
    }
    
    .botones-producto {
        flex-direction: column;
    }
    
    .imagen-producto {
        height: 180px; /* Reducido de 200px a 180px en tablet */
    }
    
    .contenido-producto {
        padding: 20px;
    }
}

@media (max-width: 480px) {
    .carousel-slide {
        padding: 0 5px;
    }
    
    .carousel-btn {
        width: 35px;
        height: 35px;
        font-size: 0.9rem;
    }
    
    .carousel-prev {
        left: 5px;
    }
    
    .carousel-next {
        right: 5px;
    }
    
    .imagen-producto {
        height: 160px; /* Reducido de 180px a 160px en móvil */
    }
    
    .contenido-producto {
        padding: 15px;
    }
    
    .contenido-producto h3 {
        font-size: 1.1rem;
    }
}
</style>

<!-- Sección Contacto -->
<section id="contacto" class="seccion seccion-contacto" role="region" aria-labelledby="contacto-titulo">
    <div class="contenedor-seccion">
        <h2 id="contacto-titulo" class="titulo-seccion" style="color: var(--color-blanco);">Contáctanos</h2>
        <p class="subtitulo-seccion" style="color: rgba(255,255,255,0.9);">Estamos aquí para ayudarte en cada paso del proceso</p>
        
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
            
            <form class="formulario-contacto" action="<?php echo BASE_URL; ?>contact/process" method="POST" role="form">
                <?php if (isset($_GET['contact_error'])): ?>
                    <div class="mensaje-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo htmlspecialchars($_GET['contact_error']); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['contact_success']) && $_GET['contact_success'] == '1'): ?>
                    <div class="mensaje-exito" id="mensaje-exito">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong style="font-size: 1.3rem; color: #0f5132;">¡GRACIAS POR CONTACTARNOS!</strong><br><br>
                            <strong>Tu mensaje ha sido recibido correctamente.</strong><br>
                            <strong>En breve nos pondremos en contacto contigo.</strong>
                        </div>
                    </div>
                    <script>
                        // Scroll automático al mensaje
                        setTimeout(function() {
                            document.getElementById('mensaje-exito').scrollIntoView({ 
                                behavior: 'smooth', 
                                block: 'center' 
                            });
                        }, 200);
                        
                        // Limpiar URL después de 10 segundos (aumentado de 5 a 10)
                        setTimeout(function() {
                            if (window.history.replaceState) {
                                window.history.replaceState({}, document.title, window.location.pathname + window.location.hash);
                            }
                        }, 10000);
                        
                        // Hacer el mensaje más visible con efectos adicionales
                        setTimeout(function() {
                            const mensaje = document.getElementById('mensaje-exito');
                            if (mensaje) {
                                mensaje.style.border = '3px solid #28a745';
                                mensaje.style.boxShadow = '0 0 20px rgba(40, 167, 69, 0.5)';
                                mensaje.style.transform = 'scale(1.02)';
                            }
                        }, 500);
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
    
    // Función para obtener el número de propiedades visibles según el tamaño de pantalla
    function getVisibleSlides() {
        if (window.innerWidth <= 768) {
            return 1; // 1 propiedad en móvil
        } else if (window.innerWidth <= 1024) {
            return 2; // 2 propiedades en tablet
        } else {
            return 3; // 3 propiedades en desktop
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
        prevBtn.style.display = currentSlide === 0 ? 'none' : 'flex';
        nextBtn.style.display = currentSlide >= maxSlides * visibleSlidesCount ? 'none' : 'flex';
    }
    
    // Botón anterior
    prevBtn.addEventListener('click', function() {
        const visibleSlides = getVisibleSlides();
        if (currentSlide > 0) {
            currentSlide = Math.max(0, currentSlide - visibleSlides);
            updateCarousel();
        }
    });
    
    // Botón siguiente
    nextBtn.addEventListener('click', function() {
        const visibleSlides = getVisibleSlides();
        const maxSlides = Math.ceil(totalSlides / visibleSlides) - 1;
        if (currentSlide < maxSlides * visibleSlides) {
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
    
    // Auto-play del carrusel (opcional)
    let autoPlayInterval;
    
    function startAutoPlay() {
        autoPlayInterval = setInterval(() => {
            const visibleSlides = getVisibleSlides();
            const maxSlides = Math.ceil(totalSlides / visibleSlides) - 1;
            if (currentSlide < maxSlides * visibleSlides) {
                currentSlide += visibleSlides;
            } else {
                currentSlide = 0;
            }
            updateCarousel();
        }, 5000); // Cambiar cada 5 segundos
    }
    
    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }
    
    // Iniciar auto-play
    startAutoPlay();
    
    // Pausar auto-play al hacer hover
    carouselTrack.addEventListener('mouseenter', stopAutoPlay);
    carouselTrack.addEventListener('mouseleave', startAutoPlay);
    
    // Pausar auto-play al usar controles
    prevBtn.addEventListener('click', stopAutoPlay);
    nextBtn.addEventListener('click', stopAutoPlay);
    indicators.forEach(indicator => {
        indicator.addEventListener('click', stopAutoPlay);
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
            stopAutoPlay();
        } else if (e.key === 'ArrowRight' && currentSlide < maxSlides * visibleSlides) {
            currentSlide = Math.min(maxSlides * visibleSlides, currentSlide + visibleSlides);
            updateCarousel();
            stopAutoPlay();
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
                stopAutoPlay();
            } else if (diffX < 0 && currentSlide > 0) {
                // Swipe derecha - grupo anterior
                currentSlide = Math.max(0, currentSlide - visibleSlides);
                updateCarousel();
                stopAutoPlay();
            }
        }
    });
});
</script>

<?php
// Incluir el footer
include __DIR__ . '/../layouts/footer.php';
?>
