<?php
/**
 * Propiedades Públicas - Página Principal
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Definir variables para el layout
$title = 'Propiedades Disponibles';
$description = 'Encuentra la propiedad perfecta para ti';
$pageTitle = 'Propiedades Disponibles';
$currentPage = 'propiedades';

// Incluir el layout público
include __DIR__ . '/../layouts/public.php';
?>

<!-- CSS específico para propiedades públicas -->
<style>
.properties-public-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
    padding: 40px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px;
}

.page-header h1 {
    font-size: 2.5rem;
    margin-bottom: 10px;
    font-weight: 700;
}

.page-header p {
    font-size: 1.2rem;
    opacity: 0.9;
}

.filters-section {
    background: white;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.filters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-group label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.filter-group select,
.filter-group input {
    padding: 12px;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.filter-group select:focus,
.filter-group input:focus {
    outline: none;
    border-color: #667eea;
}

.filter-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 20px;
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
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.properties-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

.property-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    cursor: pointer;
}

.property-card:hover {
    transform: translateY(-10px);
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
    top: 15px;
    left: 15px;
    display: flex;
    flex-direction: column;
    gap: 8px;
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

.badge-type {
    background: rgba(0,0,0,0.7);
    color: white;
}

.property-price {
    position: absolute;
    bottom: 15px;
    right: 15px;
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 10px 15px;
    border-radius: 10px;
    font-weight: bold;
    font-size: 1.1rem;
}

.property-content {
    padding: 25px;
}

.property-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
    line-height: 1.3;
}

.property-address {
    color: #666;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.property-details {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-bottom: 20px;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
    font-size: 0.9rem;
}

.detail-item i {
    color: #667eea;
    width: 16px;
}

.property-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid #eee;
    font-size: 0.9rem;
    color: #666;
}

.view-count {
    display: flex;
    align-items: center;
    gap: 5px;
}

.property-date {
    display: flex;
    align-items: center;
    gap: 5px;
}

.no-properties {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.no-properties i {
    font-size: 4rem;
    color: #ccc;
    margin-bottom: 20px;
}

.no-properties h3 {
    color: #666;
    margin-bottom: 10px;
}

.no-properties p {
    color: #999;
}

.stats-section {
    background: white;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.stat-item {
    text-align: center;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: #667eea;
    margin-bottom: 5px;
}

.stat-label {
    color: #666;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .filters-grid {
        grid-template-columns: 1fr;
    }
    
    .properties-grid {
        grid-template-columns: 1fr;
    }
    
    .page-header h1 {
        font-size: 2rem;
    }
    
    .page-header p {
        font-size: 1rem;
    }
}
</style>

<!-- Contenido principal -->
<div class="properties-public-container">
    <!-- Header de la página -->
    <div class="page-header">
        <h1><i class="fas fa-home"></i> Propiedades Disponibles</h1>
        <p>Encuentra tu hogar ideal entre nuestras mejores opciones</p>
    </div>
    
    <!-- Estadísticas -->
    <?php if (isset($stats) && !empty($stats)): ?>
    <div class="stats-section">
        <h3 style="text-align: center; margin-bottom: 20px; color: #333;">Estadísticas</h3>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number"><?php echo $stats['total_properties']; ?></div>
                <div class="stat-label">Propiedades Totales</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $stats['featured']; ?></div>
                <div class="stat-label">Propiedades Destacadas</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $stats['by_status']['disponible'] ?? 0; ?></div>
                <div class="stat-label">Disponibles</div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Filtros -->
    <div class="filters-section">
        <h3 style="margin-bottom: 20px; color: #333; text-align: center;">Filtrar Propiedades</h3>
        <form method="GET" action="<?php echo BASE_URL; ?>propiedades">
            <div class="filters-grid">
                <div class="filter-group">
                    <label for="tipo">Tipo de Transacción</label>
                    <select id="tipo" name="tipo">
                        <option value="">Todos los tipos</option>
                        <option value="venta" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] === 'venta') ? 'selected' : ''; ?>>Venta</option>
                        <option value="arriendo" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] === 'arriendo') ? 'selected' : ''; ?>>Arriendo</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="tipo_propiedad">Tipo de Propiedad</label>
                    <select id="tipo_propiedad" name="tipo_propiedad">
                        <option value="">Todos los tipos</option>
                        <option value="casa" <?php echo (isset($_GET['tipo_propiedad']) && $_GET['tipo_propiedad'] === 'casa') ? 'selected' : ''; ?>>Casa</option>
                        <option value="apartamento" <?php echo (isset($_GET['tipo_propiedad']) && $_GET['tipo_propiedad'] === 'apartamento') ? 'selected' : ''; ?>>Apartamento</option>
                        <option value="local" <?php echo (isset($_GET['tipo_propiedad']) && $_GET['tipo_propiedad'] === 'local') ? 'selected' : ''; ?>>Local Comercial</option>
                        <option value="oficina" <?php echo (isset($_GET['tipo_propiedad']) && $_GET['tipo_propiedad'] === 'oficina') ? 'selected' : ''; ?>>Oficina</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="precio_min">Precio Mínimo</label>
                    <input type="number" id="precio_min" name="precio_min" 
                           placeholder="0" value="<?php echo $_GET['precio_min'] ?? ''; ?>">
                </div>
                
                <div class="filter-group">
                    <label for="precio_max">Precio Máximo</label>
                    <input type="number" id="precio_max" name="precio_max" 
                           placeholder="Sin límite" value="<?php echo $_GET['precio_max'] ?? ''; ?>">
                </div>
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Filtrar Propiedades
                </button>
                <a href="<?php echo BASE_URL; ?>propiedades" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Limpiar Filtros
                </a>
            </div>
        </form>
    </div>
    
    <!-- Grid de propiedades -->
    <?php if (!empty($propiedades)): ?>
        <div class="properties-grid">
            <?php foreach ($propiedades as $propiedad): ?>
                <div class="property-card" onclick="window.location.href='<?php echo BASE_URL; ?>propiedad/<?php echo $propiedad['id_propiedad']; ?>'">
                    <div class="property-image">
                        <img src="<?php echo $propiedad['imagen_principal']; ?>" 
                             alt="<?php echo htmlspecialchars($propiedad['titulo']); ?>">
                        
                        <div class="property-badges">
                            <?php if ($propiedad['destacado']): ?>
                                <span class="badge badge-featured">⭐ Destacado</span>
                            <?php endif; ?>
                            <span class="badge badge-type"><?php echo ucfirst($propiedad['tipo']); ?></span>
                        </div>
                        
                        <div class="property-price">
                            $<?php echo number_format($propiedad['precio']); ?>
                        </div>
                    </div>
                    
                    <div class="property-content">
                        <h3 class="property-title"><?php echo htmlspecialchars($propiedad['titulo']); ?></h3>
                        
                        <p class="property-address">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo htmlspecialchars($propiedad['direccion']); ?>
                            <?php if ($propiedad['ciudad_nombre']): ?>
                                , <?php echo htmlspecialchars($propiedad['ciudad_nombre']); ?>
                            <?php endif; ?>
                        </p>
                        
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
                                    <span>Garaje</span>
                                </div>
                            <?php endif; ?>
                            <div class="detail-item">
                                <i class="fas fa-ruler-combined"></i>
                                <span><?php echo $propiedad['area']; ?> m²</span>
                            </div>
                        </div>
                        
                        <div class="property-meta">
                            <div class="view-count">
                                <i class="fas fa-eye"></i>
                                <span><?php echo $propiedad['vistas']; ?> vistas</span>
                            </div>
                            <div class="property-date">
                                <i class="fas fa-calendar"></i>
                                <span><?php echo date('d/m/Y', strtotime($propiedad['fecha_publicacion'])); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="no-properties">
            <i class="fas fa-home"></i>
            <h3>No se encontraron propiedades</h3>
            <p>No hay propiedades que coincidan con los filtros seleccionados.</p>
            <a href="<?php echo BASE_URL; ?>propiedades" class="btn btn-primary" style="margin-top: 20px;">
                <i class="fas fa-refresh"></i>
                Ver Todas las Propiedades
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar mensajes si existen
    <?php if (isset($_SESSION['error_message'])): ?>
        showMessage('<?php echo $_SESSION['error_message']; ?>', 'error');
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        showMessage('<?php echo $_SESSION['success_message']; ?>', 'success');
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
});

function showMessage(message, type) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `alert alert-${type}`;
    messageDiv.textContent = message;
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 5px;
        color: white;
        font-weight: bold;
        z-index: 1000;
        animation: slideIn 0.3s ease-out;
    `;
    
    if (type === 'success') {
        messageDiv.style.backgroundColor = '#28a745';
    } else if (type === 'error') {
        messageDiv.style.backgroundColor = '#dc3545';
    }
    
    document.body.appendChild(messageDiv);
    
    setTimeout(() => {
        messageDiv.remove();
    }, 5000);
}

// Agregar estilos CSS para la animación
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);
</script>
