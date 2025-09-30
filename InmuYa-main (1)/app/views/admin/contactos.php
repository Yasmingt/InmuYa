<?php
/**
 * Gestión de Contactos - Panel de Administración
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Definir variables para el layout
$title = 'Gestión de Contactos - Panel de Administración';
$description = 'Administrar contactos del sistema';
$pageTitle = 'Gestión de Contactos';

// Incluir el layout de administrador
include __DIR__ . '/../layouts/admin.php';
?>

<!-- Contenido específico de gestión de contactos -->
<div class="contactos-content">
    <!-- Header de la página -->
    <div class="page-header">
        <div class="header-left">
            <h2>Gestión de Contactos</h2>
            <p>Administra todos los contactos del sistema</p>
        </div>
        <div class="header-right">
            <button class="btn btn-secondary">
                <i class="fas fa-download"></i>
                Exportar
            </button>
        </div>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="filters-section">
        <div class="filters-row">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar contactos..." id="contactSearch">
            </div>
            <div class="filter-group">
                <select id="statusFilter">
                    <option value="">Todos los estados</option>
                    <option value="nuevo">Nuevo</option>
                    <option value="leido">Leído</option>
                    <option value="respondido">Respondido</option>
                    <option value="cerrado">Cerrado</option>
                </select>
            </div>
            <div class="filter-group">
                <select id="dateFilter">
                    <option value="">Todas las fechas</option>
                    <option value="today">Hoy</option>
                    <option value="week">Esta semana</option>
                    <option value="month">Este mes</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Lista de contactos -->
    <div class="contacts-list">
        <?php for ($i = 1; $i <= 8; $i++): ?>
            <div class="contact-item">
                <div class="contact-checkbox">
                    <input type="checkbox" class="contact-check">
                </div>
                <div class="contact-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="contact-info">
                    <h4>Contacto #<?php echo $i; ?></h4>
                    <p class="contact-email">contacto<?php echo $i; ?>@email.com</p>
                    <p class="contact-message">
                        <?php 
                        $messages = [
                            'Interesado en la propiedad de la calle 123',
                            'Necesito información sobre precios',
                            '¿Tienen propiedades en el norte?',
                            'Quiero agendar una visita',
                            'Consulta sobre financiación',
                            '¿Cuál es el proceso de compra?',
                            'Necesito ver más fotos',
                            '¿Tienen opciones de arriendo?'
                        ];
                        echo $messages[($i-1) % count($messages)];
                        ?>
                    </p>
                </div>
                <div class="contact-meta">
                    <div class="contact-status">
                        <span class="status-badge status-<?php echo ['nuevo', 'leido', 'respondido', 'cerrado'][($i-1) % 4]; ?>">
                            <?php echo ucfirst(['nuevo', 'leido', 'respondido', 'cerrado'][($i-1) % 4]); ?>
                        </span>
                    </div>
                    <div class="contact-date">
                        <i class="fas fa-clock"></i>
                        Hace <?php echo $i; ?> horas
                    </div>
                    <div class="contact-actions">
                        <button class="btn-icon" title="Marcar como leído">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-icon" title="Responder">
                            <i class="fas fa-reply"></i>
                        </button>
                        <button class="btn-icon" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>

    <!-- Paginación -->
    <div class="pagination-section">
        <div class="pagination-info">
            <span>Mostrando 1-8 de 150 contactos</span>
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
    // Búsqueda de contactos
    const searchInput = document.getElementById('contactSearch');
    const contactsList = document.querySelector('.contacts-list');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const contactItems = contactsList.querySelectorAll('.contact-item');
        
        contactItems.forEach(item => {
            const contactName = item.querySelector('h4').textContent.toLowerCase();
            const contactEmail = item.querySelector('.contact-email').textContent.toLowerCase();
            const contactMessage = item.querySelector('.contact-message').textContent.toLowerCase();
            
            if (contactName.includes(searchTerm) || 
                contactEmail.includes(searchTerm) || 
                contactMessage.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
    
    // Filtros
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    
    function applyFilters() {
        const statusValue = statusFilter.value;
        const dateValue = dateFilter.value;
        const contactItems = contactsList.querySelectorAll('.contact-item');
        
        contactItems.forEach(item => {
            let showItem = true;
            
            if (statusValue) {
                const itemStatus = item.querySelector('.status-badge').textContent.toLowerCase();
                if (itemStatus !== statusValue) {
                    showItem = false;
                }
            }
            
            // Aquí iría la lógica de filtrado por fecha
            
            item.style.display = showItem ? '' : 'none';
        });
    }
    
    statusFilter.addEventListener('change', applyFilters);
    dateFilter.addEventListener('change', applyFilters);
    
    // Select all checkbox
    const selectAllCheckbox = document.querySelector('.contact-check');
    const contactCheckboxes = document.querySelectorAll('.contact-check');
    
    // Aquí iría la lógica para el checkbox de seleccionar todos
});
</script>
