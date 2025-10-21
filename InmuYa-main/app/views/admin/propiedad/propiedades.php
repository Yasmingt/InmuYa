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
include __DIR__ . '/../../layouts/admin.php';
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

    <!-- Contenedor para mensajes dinámicos -->
    <div id="messageContainer"></div>


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
                        <th class="text-left">Título</th>
                        <th class="text-left">Dirección</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Área (m²)</th>
                        <th class="text-right">Precio</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Usuario</th>
                        <th class="text-center">Destacado</th>
                        <th class="text-center">Publicado</th>
                        <th class="text-center">Actualizado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($propiedades)): ?>
                        <?php foreach ($propiedades as $propiedad): ?>
                            <tr data-property-id="<?php echo $propiedad['id_propiedad']; ?>">
                                <td class="text-left">
                                    <div class="property-info">
                                        <div class="property-details">
                                            <div class="property-title-compact">
                                                <?php 
                                                $titulo = htmlspecialchars($propiedad['titulo']);
                                                $palabras = explode(' ', $titulo);
                                                if (count($palabras) > 4) {
                                                    $primeraParte = implode(' ', array_slice($palabras, 0, 4));
                                                    $segundaParte = implode(' ', array_slice($palabras, 4));
                                                    echo '<span class="title-line-1">' . $primeraParte . '</span><br>';
                                                    echo '<span class="title-line-2">' . $segundaParte . '</span>';
                                                } else {
                                                    echo '<span class="title-single">' . $titulo . '</span>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-left">
                                    <div class="location-info">
                                        <span class="property-address"><?php echo htmlspecialchars($propiedad['direccion']); ?></span>
                                        <?php if ($propiedad['ciudad_nombre'] || $propiedad['barrio_nombre']): ?>
                                            <span class="property-location">
                                        <?php if ($propiedad['ciudad_nombre']): ?>
                                                    <?php echo htmlspecialchars($propiedad['ciudad_nombre']); ?>
                                                <?php endif; ?>
                                                <?php if ($propiedad['ciudad_nombre'] && $propiedad['barrio_nombre']): ?>
                                                    - 
                                                <?php endif; ?>
                                                <?php if ($propiedad['barrio_nombre']): ?>
                                                    <?php echo htmlspecialchars($propiedad['barrio_nombre']); ?>
                                                <?php endif; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $tipoClass = '';
                                    switch($propiedad['tipo_propiedad']) {
                                        case 'casa':
                                            $tipoClass = 'type-casa';
                                            break;
                                        case 'apartamento':
                                            $tipoClass = 'type-apartamento';
                                            break;
                                        case 'local':
                                            $tipoClass = 'type-local';
                                            break;
                                        case 'oficina':
                                            $tipoClass = 'type-oficina';
                                            break;
                                        case 'bodega':
                                            $tipoClass = 'type-bodega';
                                            break;
                                        case 'terreno':
                                            $tipoClass = 'type-terreno';
                                            break;
                                        case 'finca':
                                            $tipoClass = 'type-finca';
                                            break;
                                        default:
                                            $tipoClass = 'type-default';
                                    }
                                    ?>
                                    <span class="badge property-type <?php echo $tipoClass; ?>">
                                        <?php echo ucfirst($propiedad['tipo_propiedad']); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="property-area"><?php echo number_format($propiedad['area']); ?> m²</span>
                                </td>
                                <td class="text-right">
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
                                    // Asegurar que el estado no esté vacío
                                    $estado = trim($propiedad['estado']);
                                    if (empty($estado)) {
                                        $estado = 'disponible'; // Estado por defecto
                                    }
                                    
                                    switch($estado) {
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
                                        case 'reservado':
                                            $statusClass = 'status-reserved';
                                            $statusText = 'Reservado';
                                            break;
                                        case 'inactivo':
                                            $statusClass = 'status-inactive';
                                            $statusText = 'Inactivo';
                                            break;
                                        default:
                                            $statusClass = 'status-unknown';
                                            $statusText = ucfirst($estado);
                                    }
                                    ?>
                                    <span class="badge <?php echo $statusClass; ?>">
                                        <?php echo $statusText; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="user-name-multiline">
                                        <?php 
                                        $nombreUsuario = $propiedad['usuario_nombre'] ?? 'Sin asignar';
                                        $partesNombre = explode(' ', $nombreUsuario);
                                        if (count($partesNombre) >= 2) {
                                            echo '<span class="user-first-name">' . htmlspecialchars($partesNombre[0]) . '</span><br>';
                                            echo '<span class="user-last-name">' . htmlspecialchars(implode(' ', array_slice($partesNombre, 1))) . '</span>';
                                        } else {
                                            echo '<span class="user-single-name">' . htmlspecialchars($nombreUsuario) . '</span>';
                                        }
                                        ?>
                                    </div>
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
                                <td class="text-center">
                                    <span class="date-info">
                                        <?php echo date('d/m/Y', strtotime($propiedad['fecha_publicacion'])); ?>
                                        <br>
                                        <small class="text-muted"><?php echo date('H:i', strtotime($propiedad['fecha_publicacion'])); ?></small>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="date-info">
                                        <?php echo date('d/m/Y', strtotime($propiedad['fecha_actualizacion'])); ?>
                                        <br>
                                        <small class="text-muted"><?php echo date('H:i', strtotime($propiedad['fecha_actualizacion'])); ?></small>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon btn-edit" title="Editar" data-property-id="<?php echo $propiedad['id_propiedad']; ?>">
                                            <i class="fas fa-edit"></i>
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
                            <td colspan="11" class="text-center">
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
    console.log('✅ JavaScript de propiedades cargado correctamente');
    
    // Botones de acción
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const propertyId = this.dataset.propertyId;
            // Redirigir a la página de edición
            window.location.href = `<?php echo BASE_URL; ?>index.php?route=admin/propiedades/editar&id=${propertyId}`;
        });
    });
    
    // Variables globales para el proceso de eliminación
    let propertyToDelete = null;
    let deleteButton = null;
    
    // Botones de eliminar
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const propertyId = this.dataset.propertyId;
            const propertyTitle = this.closest('tr').querySelector('.property-title').textContent;
            
            // Guardar referencia al botón y propiedad
            propertyToDelete = propertyId;
            deleteButton = this;
            
            // Mostrar mensaje de confirmación
            document.getElementById('confirmationMessage').textContent = 
                `¿Estás seguro de que quieres eliminar la propiedad "${propertyTitle}"? Esta acción no se puede deshacer.`;
            document.getElementById('deleteConfirmation').style.display = 'block';
            
            // Scroll hacia arriba para mostrar el mensaje
            document.getElementById('deleteConfirmation').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        });
    });
    
    // Botones de acción
    // Event listeners para botones de editar
    document.querySelectorAll('.btn-icon.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const propertyId = this.dataset.propertyId;
            window.location.href = `<?php echo BASE_URL; ?>index.php?route=admin/editar-propiedad&id=${propertyId}`;
        });
    });
    
    // Toggle destacado
    document.querySelectorAll('.toggle-destacado').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const propertyId = this.dataset.propertyId;
            const isFeatured = this.checked ? 1 : 0;
            
            console.log('Toggle destacado clicked:', { propertyId, isFeatured });
            
            fetch(`<?php echo BASE_URL; ?>index.php?route=admin/toggle-destacado`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ 
                    destacado: isFeatured,
                    id_propiedad: propertyId 
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    // Opcional: mostrar notificación de éxito
                    console.log('Estado destacado actualizado');
                } else {
                    // Revertir el toggle si hay error
                    this.checked = !this.checked;
                    alert('Error al actualizar el estado destacado: ' + (data.error || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error completo:', error);
                this.checked = !this.checked;
                alert('Error al actualizar el estado destacado: ' + error.message);
            });
        });
    });
    // Eliminación de propiedades
    console.log('🔍 Configurando botones de eliminar...');
    
    // Test de todos los botones
    const allButtons = document.querySelectorAll('button');
    console.log('🔍 Todos los botones:', allButtons.length);
    
    const btnIconButtons = document.querySelectorAll('.btn-icon');
    console.log('🔍 Botones con clase btn-icon:', btnIconButtons.length);
    
    const deleteButtons = document.querySelectorAll('.btn-delete');
    console.log('🔍 Botones con clase btn-delete:', deleteButtons.length);
    
    // Test específico de botones de eliminar
    const btnIconDeleteButtons = document.querySelectorAll('.btn-icon.btn-delete');
    console.log('🔍 Botones con clases btn-icon btn-delete:', btnIconDeleteButtons.length);
    
    btnIconDeleteButtons.forEach((button, index) => {
        console.log(`🔍 Botón ${index}:`, button);
        console.log(`🔍 Botón ${index} data-property-id:`, button.dataset.propertyId);
        
        button.addEventListener('click', function() {
            console.log('🚨 CLIC EN BOTÓN ELIMINAR DETECTADO');
            console.log('🚨 currentPropertyId:', this.dataset.propertyId);
            
            currentPropertyId = this.dataset.propertyId;
            const propertyTitle = this.closest('tr').querySelector('.property-title').textContent;
            console.log('🚨 Título de propiedad:', propertyTitle);
            
            const confirmationMessage = document.getElementById('confirmationMessage');
            const deleteConfirmation = document.getElementById('deleteConfirmation');
            
            console.log('🚨 confirmationMessage:', confirmationMessage);
            console.log('🚨 deleteConfirmation:', deleteConfirmation);
            
            if (confirmationMessage && deleteConfirmation) {
                confirmationMessage.textContent = 
                    `¿Estás seguro de que quieres eliminar la propiedad "${propertyTitle}"? Esta acción no se puede deshacer.`;
                deleteConfirmation.style.display = 'block';
                console.log('✅ Modal mostrado');
            } else {
                console.error('❌ Elementos del modal no encontrados');
            }
        });
    });
    
    // Confirmar eliminación
    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (currentPropertyId) {
            window.location.href = `<?php echo BASE_URL; ?>index.php?route=admin/eliminar-propiedad&id=${currentPropertyId}`;
        }
    });
    
    // Cancelar eliminación
    document.getElementById('cancelDelete').addEventListener('click', function() {
        document.getElementById('deleteConfirmation').style.display = 'none';
        currentPropertyId = null;
    });
});
</script>
    
    // Sistema de notificaciones
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.textContent = message;
        
        const colors = {
            success: '#28a745',
            error: '#dc3545',
            info: '#17a2b8',
            warning: '#ffc107'
        };
        
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            border-radius: 6px;
            color: white;
            font-weight: 500;
            z-index: 1000;
            background-color: ${colors[type] || colors.info};
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            animation: slideInRight 0.3s ease-out;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    // Mostrar notificación de éxito si viene de una actualización
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'created') {
        showNotification('Propiedad creada correctamente', 'success');
    } else if (urlParams.get('success') === 'updated') {
        showNotification('Propiedad actualizada correctamente', 'success');
    }
    
    // Añadir estilos para animaciones
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
});
</script>