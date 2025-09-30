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
        
        <div class="contenedor-productos" id="contenedorProductos" role="list">
            <?php if (!empty($properties)): ?>
                <?php foreach ($properties as $property): ?>
                <article class="producto-card" role="listitem">
                    <div class="imagen-producto" style="background-image: url('<?php echo BASE_URL; ?>public/img/anuncio1.jpg');">
                        <div class="etiqueta-precio">$<?php echo number_format($property['precio']); ?>/mes</div>
                    </div>
                    <div class="contenido-producto">
                        <h3><?php echo htmlspecialchars($property['titulo']); ?></h3>
                        <p><?php echo htmlspecialchars($property['descripcion']); ?></p>
                        <div class="caracteristicas-propiedad">
                            <span class="caracteristica">
                                <i class="fas fa-bed" aria-hidden="true"></i>
                                <span><?php echo $property['habitaciones']; ?> Habitaciones</span>
                            </span>
                            <span class="caracteristica">
                                <i class="fas fa-bath" aria-hidden="true"></i>
                                <span><?php echo $property['banos']; ?> Baños</span>
                            </span>
                            <span class="caracteristica">
                                <i class="fas fa-car" aria-hidden="true"></i>
                                <span><?php echo $property['garajes']; ?> Garajes</span>
                            </span>
                        </div>
                        <div class="botones-producto">
                            <button class="boton-producto boton-contactar" aria-label="Contactar sobre esta propiedad">
                                <i class="fas fa-phone" aria-hidden="true"></i> Contactar
                            </button>
                            <button class="boton-producto boton-detalles" aria-label="Ver detalles de esta propiedad">
                                <i class="fas fa-eye" aria-hidden="true"></i> Ver Detalles
                            </button>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-properties">
                    <p>No hay propiedades disponibles en este momento.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

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
<?php
// Incluir el footer
include __DIR__ . '/../layouts/footer.php';
?>
