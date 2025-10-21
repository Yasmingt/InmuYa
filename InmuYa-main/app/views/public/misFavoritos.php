<?php
/**
 * Vista de Mis Favoritos
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Muestra las propiedades favoritas del usuario logueado
 */

// Definir variables para el layout
$title = 'Mis Favoritos - InmuYa';

// Incluir el layout público
include __DIR__ . '/../layouts/public.php';
?>

<div class="container">
    <div class="page-header">
        <h1>Mis Favoritos</h1>
        <p class="page-description">Tus propiedades guardadas</p>
    </div>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo htmlspecialchars($_SESSION['error_message']); ?>
            <?php unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo htmlspecialchars($_SESSION['success_message']); ?>
            <?php unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($favoritos)): ?>
        <!-- Estadísticas -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number"><?php echo count($favoritos); ?></div>
                    <div class="stat-label">Propiedades Favoritas</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo $stats['propiedades_unicas'] ?? 0; ?></div>
                    <div class="stat-label">Propiedades Únicas</div>
                </div>
            </div>
        </div>
        
        <!-- Grid de propiedades -->
        <div class="properties-grid">
            <?php foreach ($favoritos as $propiedad): ?>
                <div class="property-card" data-property-id="<?php echo $propiedad['id_propiedad']; ?>">
                    <div class="property-image">
                        <img src="<?php echo $propiedad['imagen_principal']; ?>" 
                             alt="<?php echo htmlspecialchars($propiedad['titulo']); ?>"
                             loading="lazy">
                        <div class="property-badges">
                            <span class="badge badge-<?php echo $propiedad['tipo'] === 'venta' ? 'success' : 'primary'; ?>">
                                <?php echo ucfirst($propiedad['tipo']); ?>
                            </span>
                            <?php if ($propiedad['destacado']): ?>
                                <span class="badge badge-warning">Destacado</span>
                            <?php endif; ?>
                        </div>
                        <button class="favorite-btn active" 
                                data-property-id="<?php echo $propiedad['id_propiedad']; ?>"
                                title="Quitar de favoritos">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                    
                    <div class="property-content">
                        <h3 class="property-title">
                            <a href="<?php echo BASE_URL; ?>propiedad/<?php echo $propiedad['id_propiedad']; ?>">
                                <?php echo htmlspecialchars($propiedad['titulo']); ?>
                            </a>
                        </h3>
                        
                        <div class="property-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo htmlspecialchars($propiedad['direccion']); ?>
                            <?php if ($propiedad['ciudad_nombre']): ?>
                                , <?php echo htmlspecialchars($propiedad['ciudad_nombre']); ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="property-features">
                            <span class="feature">
                                <i class="fas fa-bed"></i>
                                <?php echo $propiedad['habitaciones']; ?> hab
                            </span>
                            <span class="feature">
                                <i class="fas fa-bath"></i>
                                <?php echo $propiedad['banos']; ?> baños
                            </span>
                            <span class="feature">
                                <i class="fas fa-ruler-combined"></i>
                                <?php echo number_format($propiedad['area']); ?> m²
                            </span>
                            <?php if ($propiedad['parqueadero']): ?>
                                <span class="feature">
                                    <i class="fas fa-car"></i>
                                    Parqueadero
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="property-price">
                            <span class="price">$<?php echo number_format($propiedad['precio']); ?></span>
                            <?php if ($propiedad['tipo'] === 'arriendo'): ?>
                                <span class="price-period">/mes</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="property-actions">
                            <a href="<?php echo BASE_URL; ?>propiedad/<?php echo $propiedad['id_propiedad']; ?>" 
                               class="btn btn-primary">
                                Ver Detalles
                            </a>
                            <button class="btn btn-outline-danger remove-favorite" 
                                    data-property-id="<?php echo $propiedad['id_propiedad']; ?>">
                                <i class="fas fa-trash"></i>
                                Quitar
                            </button>
                        </div>
                        
                        <div class="property-date">
                            <small class="text-muted">
                                Agregado: <?php echo date('d/m/Y', strtotime($propiedad['fecha_favorito'])); ?>
                            </small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
    <?php else: ?>
        <!-- Estado vacío -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-heart-broken"></i>
            </div>
            <h3>No tienes propiedades favoritas</h3>
            <p>Explora nuestras propiedades y agrega las que más te gusten a tus favoritos.</p>
            <a href="<?php echo BASE_URL; ?>propiedades" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Explorar Propiedades
            </a>
        </div>
    <?php endif; ?>
</div>

<style>
.page-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
}

.page-header h1 {
    margin: 0;
    font-size: 2.5rem;
    font-weight: 700;
}

.page-description {
    margin: 0.5rem 0 0 0;
    font-size: 1.1rem;
    opacity: 0.9;
}

.stats-section {
    margin-bottom: 2rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-item {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: #667eea;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #666;
    font-size: 0.9rem;
}

.properties-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.property-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.property-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.property-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.property-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.property-card:hover .property-image img {
    transform: scale(1.05);
}

.property-badges {
    position: absolute;
    top: 1rem;
    left: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-success {
    background: #28a745;
    color: white;
}

.badge-primary {
    background: #007bff;
    color: white;
}

.badge-warning {
    background: #ffc107;
    color: #212529;
}

.favorite-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1.2rem;
}

.favorite-btn:hover {
    background: white;
    transform: scale(1.1);
}

.favorite-btn.active i {
    color: #e74c3c;
}

.property-content {
    padding: 1.5rem;
}

.property-title {
    margin: 0 0 0.5rem 0;
    font-size: 1.2rem;
    font-weight: 600;
}

.property-title a {
    color: #333;
    text-decoration: none;
}

.property-title a:hover {
    color: #667eea;
}

.property-location {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.property-features {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
}

.feature {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.9rem;
    color: #666;
}

.property-price {
    margin-bottom: 1rem;
}

.price {
    font-size: 1.5rem;
    font-weight: bold;
    color: #28a745;
}

.price-period {
    color: #666;
    font-size: 0.9rem;
}

.property-actions {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 5px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: #667eea;
    color: white;
}

.btn-primary:hover {
    background: #5a6fd8;
}

.btn-outline-danger {
    background: transparent;
    color: #dc3545;
    border: 1px solid #dc3545;
}

.btn-outline-danger:hover {
    background: #dc3545;
    color: white;
}

.property-date {
    text-align: center;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.empty-icon {
    font-size: 4rem;
    color: #ccc;
    margin-bottom: 1rem;
}

.empty-state h3 {
    margin: 0 0 1rem 0;
    color: #333;
}

.empty-state p {
    color: #666;
    margin-bottom: 2rem;
}

.alert {
    padding: 1rem;
    border-radius: 5px;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

@media (max-width: 768px) {
    .properties-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejar botones de favoritos
    document.querySelectorAll('.favorite-btn, .remove-favorite').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const propertyId = this.dataset.propertyId;
            const isRemove = this.classList.contains('remove-favorite');
            
            // Verificar si el usuario está logueado
            fetch('<?php echo BASE_URL; ?>favoritos/verificar?id_propiedad=' + propertyId)
                .then(response => response.json())
                .then(data => {
                    if (!data.success && data.message === 'Usuario no autenticado') {
                        alert('Debes iniciar sesión para usar favoritos');
                        window.location.href = '<?php echo BASE_URL; ?>auth/login';
                        return;
                    }
                    
                    // Toggle favorito
                    return fetch('<?php echo BASE_URL; ?>favoritos/toggle', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            id_propiedad: propertyId
                        })
                    });
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (isRemove || !data.es_favorito) {
                            // Remover de la vista
                            const propertyCard = document.querySelector(`[data-property-id="${propertyId}"]`);
                            if (propertyCard) {
                                propertyCard.style.transition = 'opacity 0.3s ease';
                                propertyCard.style.opacity = '0';
                                setTimeout(() => {
                                    propertyCard.remove();
                                    
                                    // Verificar si no hay más propiedades
                                    const remainingCards = document.querySelectorAll('.property-card');
                                    if (remainingCards.length === 0) {
                                        location.reload();
                                    }
                                }, 300);
                            }
                        }
                    } else {
                        alert(data.message || 'Error al actualizar favoritos');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al actualizar favoritos');
                });
        });
    });
});
</script>

