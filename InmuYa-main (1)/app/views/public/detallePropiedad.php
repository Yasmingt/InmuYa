<?php
/**
 * Detalle de Propiedad - Página Pública
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Definir variables para el layout
$title = $propiedad['titulo'] . ' - InmuYa';
$description = substr(strip_tags($propiedad['descripcion']), 0, 160);
$pageTitle = $propiedad['titulo'];
$currentPage = 'propiedades';

// Incluir el layout público
include __DIR__ . '/../layouts/public.php';
?>

<!-- CSS específico para detalle de propiedad -->
<style>
.property-detail-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.property-header {
    background: white;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.property-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 15px;
    line-height: 1.3;
}

.property-price {
    font-size: 2rem;
    font-weight: bold;
    color: #667eea;
    margin-bottom: 10px;
}

.property-type {
    display: inline-block;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 20px;
}

.property-address {
    color: #666;
    font-size: 1.1rem;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.property-meta {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
}

.meta-item i {
    color: #667eea;
    width: 20px;
}

.property-badges {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-featured {
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    color: #333;
}

.badge-negotiable {
    background: #28a745;
    color: white;
}

.property-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
    margin-bottom: 40px;
}

.property-gallery {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.gallery-main {
    position: relative;
    height: 400px;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 20px;
}

.gallery-main img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.gallery-main img:hover {
    transform: scale(1.02);
}

.gallery-thumbnails {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
    gap: 10px;
}

.thumbnail {
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.3s ease;
}

.thumbnail.active {
    border-color: #667eea;
}

.thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.property-info {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.info-section {
    margin-bottom: 30px;
}

.info-section h3 {
    color: #333;
    margin-bottom: 15px;
    font-size: 1.3rem;
    font-weight: 600;
}

.property-details {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
}

.detail-item i {
    color: #667eea;
    width: 20px;
    text-align: center;
}

.contact-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px;
    border-radius: 10px;
    text-align: center;
}

.contact-section h3 {
    margin-bottom: 15px;
    font-size: 1.2rem;
}

.contact-info {
    margin-bottom: 20px;
}

.contact-info p {
    margin: 8px 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    width: 100%;
    justify-content: center;
}

.btn-white {
    background: white;
    color: #667eea;
}

.btn-white:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
}

.property-description {
    background: white;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.description-text {
    line-height: 1.6;
    color: #666;
    font-size: 1rem;
}

.related-properties {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.related-card {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    cursor: pointer;
}

.related-card:hover {
    transform: translateY(-5px);
}

.related-image {
    height: 150px;
    overflow: hidden;
}

.related-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.related-content {
    padding: 15px;
}

.related-title {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.related-price {
    color: #667eea;
    font-weight: bold;
    font-size: 1rem;
}

.lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.9);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.lightbox-content {
    position: relative;
    max-width: 90%;
    max-height: 90%;
}

.lightbox img {
    max-width: 100%;
    max-height: 100%;
    border-radius: 10px;
}

.lightbox-close {
    position: absolute;
    top: -40px;
    right: 0;
    background: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    cursor: pointer;
    font-size: 1.2rem;
    color: #333;
}

.lightbox-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.8);
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    cursor: pointer;
    font-size: 1.2rem;
    color: #333;
}

.lightbox-prev {
    left: -60px;
}

.lightbox-next {
    right: -60px;
}

@media (max-width: 768px) {
    .property-content {
        grid-template-columns: 1fr;
    }
    
    .property-details {
        grid-template-columns: 1fr;
    }
    
    .property-meta {
        flex-direction: column;
        gap: 15px;
    }
    
    .gallery-thumbnails {
        grid-template-columns: repeat(auto-fit, minmax(60px, 1fr));
    }
    
    .thumbnail {
        height: 60px;
    }
    
    .lightbox-nav {
        display: none;
    }
}
</style>

<!-- Contenido principal -->
<div class="property-detail-container">
    <!-- Header de la propiedad -->
    <div class="property-header">
        <div class="property-badges">
            <?php if ($propiedad['destacado']): ?>
                <span class="badge badge-featured">⭐ Destacado</span>
            <?php endif; ?>
            <?php if ($propiedad['precio_negociable']): ?>
                <span class="badge badge-negotiable">Precio Negociable</span>
            <?php endif; ?>
        </div>
        
        <h1 class="property-title"><?php echo htmlspecialchars($propiedad['titulo']); ?></h1>
        
        <div class="property-price">$<?php echo number_format($propiedad['precio']); ?></div>
        
        <span class="property-type"><?php echo ucfirst($propiedad['tipo']); ?> - <?php echo ucfirst($propiedad['tipo_propiedad']); ?></span>
        
        <p class="property-address">
            <i class="fas fa-map-marker-alt"></i>
            <?php echo htmlspecialchars($propiedad['direccion']); ?>
            <?php if ($propiedad['ciudad_nombre']): ?>
                , <?php echo htmlspecialchars($propiedad['ciudad_nombre']); ?>
            <?php endif; ?>
        </p>
        
        <div class="property-meta">
            <div class="meta-item">
                <i class="fas fa-eye"></i>
                <span><?php echo $propiedad['vistas']; ?> vistas</span>
            </div>
            <div class="meta-item">
                <i class="fas fa-calendar"></i>
                <span>Publicado: <?php echo date('d/m/Y', strtotime($propiedad['fecha_publicacion'])); ?></span>
            </div>
            <div class="meta-item">
                <i class="fas fa-ruler-combined"></i>
                <span><?php echo $propiedad['area']; ?> m²</span>
            </div>
        </div>
    </div>
    
    <!-- Contenido principal -->
    <div class="property-content">
        <!-- Galería de imágenes -->
        <div class="property-gallery">
            <h3><i class="fas fa-images"></i> Galería de Imágenes</h3>
            
            <?php if (!empty($imagenes)): ?>
                <div class="gallery-main">
                    <img id="mainImage" src="<?php echo $imagenes[0]['url_completa']; ?>" 
                         alt="<?php echo htmlspecialchars($imagenes[0]['titulo']); ?>">
                </div>
                
                <div class="gallery-thumbnails">
                    <?php foreach ($imagenes as $index => $imagen): ?>
                        <div class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>" 
                             onclick="changeMainImage(<?php echo $index; ?>)">
                            <img src="<?php echo $imagen['url_completa']; ?>" 
                                 alt="<?php echo htmlspecialchars($imagen['titulo']); ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="gallery-main">
                    <img src="<?php echo BASE_URL; ?>public/img/edificio.jpg" alt="Sin imágenes">
                </div>
                <p style="text-align: center; color: #666; margin-top: 20px;">
                    Esta propiedad no tiene imágenes disponibles
                </p>
            <?php endif; ?>
        </div>
        
        <!-- Información de contacto -->
        <div class="property-info">
            <div class="info-section">
                <h3><i class="fas fa-info-circle"></i> Detalles</h3>
                <div class="property-details">
                    <div class="detail-item">
                        <i class="fas fa-bed"></i>
                        <span><?php echo $propiedad['habitaciones']; ?> Habitaciones</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-bath"></i>
                        <span><?php echo $propiedad['banos']; ?> Baños</span>
                    </div>
                    <?php if ($propiedad['parqueadero']): ?>
                        <div class="detail-item">
                            <i class="fas fa-car"></i>
                            <span>Parqueadero</span>
                        </div>
                    <?php endif; ?>
                    <div class="detail-item">
                        <i class="fas fa-ruler-combined"></i>
                        <span><?php echo $propiedad['area']; ?> m²</span>
                    </div>
                </div>
            </div>
            
            <div class="contact-section">
                <h3><i class="fas fa-phone"></i> ¿Te interesa esta propiedad?</h3>
                <div class="contact-info">
                    <p><i class="fas fa-user"></i> <?php echo htmlspecialchars($propiedad['usuario_nombre'] ?? 'Agente Inmobiliario'); ?></p>
                    <?php if ($propiedad['telefono_contacto']): ?>
                        <p><i class="fas fa-phone"></i> <?php echo htmlspecialchars($propiedad['telefono_contacto']); ?></p>
                    <?php endif; ?>
                    <?php if ($propiedad['email_contacto']): ?>
                        <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($propiedad['email_contacto']); ?></p>
                    <?php endif; ?>
                </div>
                <button class="btn btn-white" onclick="contactarPropietario()">
                    <i class="fas fa-comments"></i>
                    Contactar Propietario
                </button>
            </div>
        </div>
    </div>
    
    <!-- Descripción -->
    <div class="property-description">
        <h3><i class="fas fa-align-left"></i> Descripción</h3>
        <div class="description-text">
            <?php echo nl2br(htmlspecialchars($propiedad['descripcion'])); ?>
        </div>
    </div>
    
    <!-- Propiedades relacionadas -->
    <?php if (!empty($propiedadesRelacionadas)): ?>
        <div class="related-properties">
            <h3><i class="fas fa-home"></i> Propiedades Similares</h3>
            <div class="related-grid">
                <?php foreach ($propiedadesRelacionadas as $relacionada): ?>
                    <div class="related-card" onclick="window.location.href='<?php echo BASE_URL; ?>propiedad/<?php echo $relacionada['id_propiedad']; ?>'">
                        <div class="related-image">
                            <img src="<?php echo $relacionada['imagen_principal']; ?>" 
                                 alt="<?php echo htmlspecialchars($relacionada['titulo']); ?>">
                        </div>
                        <div class="related-content">
                            <h4 class="related-title"><?php echo htmlspecialchars($relacionada['titulo']); ?></h4>
                            <div class="related-price">$<?php echo number_format($relacionada['precio']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Lightbox para imágenes -->
<div class="lightbox" id="lightbox">
    <div class="lightbox-content">
        <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
        <button class="lightbox-nav lightbox-prev" onclick="previousImage()">&larr;</button>
        <img id="lightboxImage" src="" alt="">
        <button class="lightbox-nav lightbox-next" onclick="nextImage()">&rarr;</button>
    </div>
</div>

<!-- Scripts -->
<script>
const images = <?php echo json_encode($imagenes); ?>;
let currentImageIndex = 0;

function changeMainImage(index) {
    if (images && images[index]) {
        const mainImage = document.getElementById('mainImage');
        const thumbnails = document.querySelectorAll('.thumbnail');
        
        mainImage.src = images[index].url_completa;
        mainImage.alt = images[index].titulo;
        
        thumbnails.forEach((thumb, i) => {
            thumb.classList.toggle('active', i === index);
        });
        
        currentImageIndex = index;
    }
}

function openLightbox(index) {
    if (images && images[index]) {
        currentImageIndex = index;
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightboxImage');
        
        lightboxImage.src = images[index].url_completa;
        lightboxImage.alt = images[index].titulo;
        
        lightbox.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.style.display = 'none';
    document.body.style.overflow = 'auto';
}

function previousImage() {
    if (currentImageIndex > 0) {
        currentImageIndex--;
    } else {
        currentImageIndex = images.length - 1;
    }
    openLightbox(currentImageIndex);
}

function nextImage() {
    if (currentImageIndex < images.length - 1) {
        currentImageIndex++;
    } else {
        currentImageIndex = 0;
    }
    openLightbox(currentImageIndex);
}

function contactarPropietario() {
    alert('Función de contacto en desarrollo. Por favor, usa la información de contacto mostrada.');
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('mainImage');
    if (mainImage) {
        mainImage.addEventListener('click', () => openLightbox(currentImageIndex));
    }
    
    // Cerrar lightbox con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
});
</script>
