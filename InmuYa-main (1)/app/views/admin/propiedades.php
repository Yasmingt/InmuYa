<?php
/**
 * Gestión de Propiedades - Panel de Administración
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Definir variables para el layout
$title = 'Gestión de Propiedades - Panel de Administración';
$description = 'Administrar propiedades del sistema';
$pageTitle = 'Gestión de Propiedades';

// Incluir el layout de administrador
include __DIR__ . '/../layouts/admin.php';
?>

<!-- CSS específico para gestión de propiedades -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/propiedades.css">

<!-- Contenido específico de gestión de propiedades -->
<div class="propiedades-content">
    <!-- Header de la página -->
    <div class="page-header">
        <div class="header-left">
            <h2>Gestión de Propiedades</h2>
            <p>Administra todas las propiedades del sistema</p>
        </div>
        <div class="header-right">
            <button class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Nueva Propiedad
            </button>
        </div>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="filters-section">
        <div class="filters-row">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar propiedades..." id="propertySearch">
            </div>
            <div class="filter-group">
                <select id="typeFilter">
                    <option value="">Todos los tipos</option>
                    <option value="casa">Casa</option>
                    <option value="apartamento">Apartamento</option>
                    <option value="local">Local</option>
                    <option value="terreno">Terreno</option>
                </select>
            </div>
            <div class="filter-group">
                <select id="statusFilter">
                    <option value="">Todos los estados</option>
                    <option value="disponible">Disponible</option>
                    <option value="vendida">Vendida</option>
                    <option value="alquilada">Alquilada</option>
                </select>
            </div>
            <div class="filter-group">
                <select id="priceFilter">
                    <option value="">Todos los precios</option>
                    <option value="0-100000">$0 - $100,000</option>
                    <option value="100000-300000">$100,000 - $300,000</option>
                    <option value="300000-500000">$300,000 - $500,000</option>
                    <option value="500000+">$500,000+</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Vista de propiedades -->
    <div class="properties-grid">
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <div class="property-card">
                <div class="property-image">
                    <img src="<?php echo BASE_URL; ?>public/img/edificio.jpg" alt="Propiedad <?php echo $i; ?>">
                    <div class="property-status">
                        <span class="status-badge status-available">Disponible</span>
                    </div>
                    <div class="property-actions">
                        <button class="btn-icon" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="property-content">
                    <h3>Casa en Venta #<?php echo $i; ?></h3>
                    <p class="property-address">
                        <i class="fas fa-map-marker-alt"></i>
                        Calle 123 #45-67, Bogotá
                    </p>
                    <div class="property-details">
                        <div class="detail-item">
                            <i class="fas fa-bed"></i>
                            <span>3 Habitaciones</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-bath"></i>
                            <span>2 Baños</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-car"></i>
                            <span>1 Garaje</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-ruler-combined"></i>
                            <span>120 m²</span>
                        </div>
                    </div>
                    <div class="property-price">
                        <span class="price">$<?php echo number_format(150000 + ($i * 50000)); ?></span>
                        <span class="price-type">Venta</span>
                    </div>
                    <div class="property-meta">
                        <span class="property-date">
                            <i class="fas fa-calendar"></i>
                            Publicado hace <?php echo $i; ?> días
                        </span>
                        <span class="property-views">
                            <i class="fas fa-eye"></i>
                            <?php echo rand(10, 100); ?> vistas
                        </span>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>

    <!-- Paginación -->
    <div class="pagination-section">
        <div class="pagination-info">
            <span>Mostrando 1-6 de 25 propiedades</span>
        </div>
        <div class="pagination">
            <button class="btn-pagination" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="btn-pagination active">1</button>
            <button class="btn-pagination">2</button>
            <button class="btn-pagination">3</button>
            <button class="btn-pagination">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<!-- Scripts específicos -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Búsqueda de propiedades
    const searchInput = document.getElementById('propertySearch');
    const propertiesGrid = document.querySelector('.properties-grid');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const propertyCards = propertiesGrid.querySelectorAll('.property-card');
        
        propertyCards.forEach(card => {
            const propertyTitle = card.querySelector('h3').textContent.toLowerCase();
            const propertyAddress = card.querySelector('.property-address').textContent.toLowerCase();
            
            if (propertyTitle.includes(searchTerm) || propertyAddress.includes(searchTerm)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Filtros
    const typeFilter = document.getElementById('typeFilter');
    const statusFilter = document.getElementById('statusFilter');
    const priceFilter = document.getElementById('priceFilter');
    
    function applyFilters() {
        const typeValue = typeFilter.value;
        const statusValue = statusFilter.value;
        const priceValue = priceFilter.value;
        const propertyCards = propertiesGrid.querySelectorAll('.property-card');
        
        propertyCards.forEach(card => {
            let showCard = true;
            
            // Aquí iría la lógica de filtrado basada en los datos reales
            // Por ahora solo mostramos todas las tarjetas
            
            card.style.display = showCard ? '' : 'none';
        });
    }
    
    typeFilter.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);
    priceFilter.addEventListener('change', applyFilters);
});
</script>
