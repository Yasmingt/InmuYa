<?php
/**
 * Gestión de Propiedades - Panel de Administración
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Definir variables para el layout
$title = 'Gestión de Propiedades';
$description = 'Administrar propiedades del sistema';
$pageTitle = 'Gestión de Propiedades';
$currentPage = 'propiedades';

// Incluir el layout de administrador
include __DIR__ . '/../layouts/admin.php';
?>

<!-- CSS específico para gestión de propiedades ya cargado en admin.php -->

<!-- Contenido específico de gestión de propiedades -->
<div class="propiedades-content">
    <!-- Header de la página -->
    <div class="page-header">
        <div class="header-left">
            <h2>Gestión de Propiedades</h2>
            <p>Administra todas las propiedades del sistema</p>
        </div>
        <div class="header-right">
            <button class="btn btn-primary" onclick="window.location.href='<?php echo BASE_URL; ?>admin/crear-propiedad'">
                <i class="fas fa-plus"></i>
                Nueva Propiedad
            </button>
        </div>
    </div>


    <div id="deleteConfirmation" style="display: none; background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; margin: 10px 0; border-radius: 8px; text-align: center;">
        <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
            <i class="fas fa-exclamation-triangle" style="font-size: 20px;"></i>
            <span id="confirmationMessage"></span>
        </div>
        <div style="margin-top: 10px;">
            <button id="confirmDelete" class="btn btn-danger" style="margin-right: 10px;">
                <i class="fas fa-trash"></i> Sí, Eliminar
            </button>
            <button id="cancelDelete" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </button>
        </div>
    </div>

    <!-- Tabla de propiedades -->
    <div class="table-section">
        <div class="table-container">
            <table class="data-table" id="propertiesTable">
                <thead>
                    <tr>
                        <th>Propiedad</th>
                        <th>Ubicación</th>
                        <th>Tipo</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Destacado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($propiedades)): ?>
                        <?php foreach ($propiedades as $propiedad): ?>
                            <tr data-property-id="<?php echo $propiedad['id_propiedad']; ?>">
                                <td>
                                    <div class="property-info">
                                        <div class="property-details">
                                            <span class="property-title"><?php echo htmlspecialchars($propiedad['titulo']); ?></span>
                                            <span class="property-id">ID: <?php echo $propiedad['id_propiedad']; ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="location-info">
                                        <span class="property-address"><?php echo htmlspecialchars($propiedad['direccion']); ?></span>
                                        <?php if ($propiedad['ciudad_nombre']): ?>
                                            <span class="property-city"><?php echo htmlspecialchars($propiedad['ciudad_nombre']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge property-type">
                                        <?php echo ucfirst($propiedad['tipo_propiedad']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="price-info">
                                        <span class="property-price">$<?php echo number_format($propiedad['precio']); ?></span>
                                        <?php if ($propiedad['tipo'] === 'arriendo'): ?>
                                            <span class="price-period">/mes</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php
                                    $statusClass = '';
                                    $statusText = '';
                                    switch($propiedad['estado']) {
                                        case 'disponible':
                                            $statusClass = 'status-available';
                                            $statusText = 'Disponible';
                                            break;
                                        case 'arrendado':
                                            $statusClass = 'status-rented';
                                            $statusText = 'Arrendado';
                                            break;
                                        case 'vendido':
                                            $statusClass = 'status-sold';
                                            $statusText = 'Vendido';
                                            break;
                                        case 'mantenimiento':
                                            $statusClass = 'status-maintenance';
                                            $statusText = 'Mantenimiento';
                                            break;
                                        default:
                                            $statusClass = 'status-unknown';
                                            $statusText = ucfirst($propiedad['estado']);
                                    }
                                    ?>
                                    <span class="badge <?php echo $statusClass; ?>">
                                        <?php echo $statusText; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="featured-toggle">
                                        <label class="toggle-switch">
                                            <input type="checkbox" 
                                                   class="toggle-destacado" 
                                                   data-property-id="<?php echo $propiedad['id_propiedad']; ?>"
                                                   <?php echo $propiedad['destacado'] ? 'checked' : ''; ?>>
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon btn-images" title="Gestionar Imágenes" data-property-id="<?php echo $propiedad['id_propiedad']; ?>">
                                            <i class="fas fa-images"></i>
                                        </button>
                                        <button class="btn-icon btn-edit" title="Editar" data-property-id="<?php echo $propiedad['id_propiedad']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-icon btn-status" title="Cambiar Estado" data-property-id="<?php echo $propiedad['id_propiedad']; ?>">
                                            <i class="fas fa-toggle-on"></i>
                                        </button>
                                        <button class="btn-icon btn-delete" title="Eliminar" data-property-id="<?php echo $propiedad['id_propiedad']; ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="empty-state">
                                    <i class="fas fa-home"></i>
                                    <h3>No hay propiedades</h3>
                                    <p>No se encontraron propiedades en el sistema</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación -->
    <div class="pagination-section">
        <div class="pagination-info">
            <span>Mostrando 1-<?php echo count($propiedades); ?> de <?php echo count($propiedades); ?> propiedades</span>
        </div>
        <div class="pagination">
            <button class="btn-pagination" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="btn-pagination active">1</button>
            <button class="btn-pagination">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>


<!-- Scripts específicos -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPropertyId = null;
    
    // Botones de acción
    document.querySelectorAll('.btn-images').forEach(button => {
        button.addEventListener('click', function() {
            const propertyId = this.dataset.propertyId;
            window.location.href = `<?php echo BASE_URL; ?>admin/gestionar-imagenes/${propertyId}`;
        });
    });
    
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const propertyId = this.dataset.propertyId;
            window.location.href = `<?php echo BASE_URL; ?>admin/editar-propiedad/${propertyId}`;
        });
    });
    
    document.querySelectorAll('.btn-status').forEach(button => {
        button.addEventListener('click', function() {
            const propertyId = this.dataset.propertyId;
            if (confirm('¿Estás seguro de que quieres cambiar el estado de esta propiedad?')) {
                window.location.href = `<?php echo BASE_URL; ?>admin/cambiar-estado-propiedad/${propertyId}`;
            }
        });
    });
    
    // Toggle destacado
    document.querySelectorAll('.toggle-destacado').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const propertyId = this.dataset.propertyId;
            const isFeatured = this.checked ? 1 : 0;
            
            fetch(`<?php echo BASE_URL; ?>admin/toggle-destacado/${propertyId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ destacado: isFeatured })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Opcional: mostrar notificación de éxito
                    console.log('Estado destacado actualizado');
                } else {
                    // Revertir el toggle si hay error
                    this.checked = !this.checked;
                    alert('Error al actualizar el estado destacado');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = !this.checked;
                alert('Error al actualizar el estado destacado');
            });
        });
    });
    
    // Eliminación de propiedades
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            currentPropertyId = this.dataset.propertyId;
            const propertyTitle = this.closest('tr').querySelector('.property-title').textContent;
            
            document.getElementById('confirmationMessage').textContent = 
                `¿Estás seguro de que quieres eliminar la propiedad "${propertyTitle}"? Esta acción no se puede deshacer.`;
            document.getElementById('deleteConfirmation').style.display = 'block';
        });
    });
    
    // Confirmar eliminación
    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (currentPropertyId) {
            window.location.href = `<?php echo BASE_URL; ?>admin/eliminar-propiedad/${currentPropertyId}`;
        }
    });
    
    // Cancelar eliminación
    document.getElementById('cancelDelete').addEventListener('click', function() {
        document.getElementById('deleteConfirmation').style.display = 'none';
        currentPropertyId = null;
    });
});
</script>