<?php
/**
 * Gestión de Contactos - Panel de Administración
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Definir variables para el layout
$title = 'Gestión de Contactos';
$description = 'Administrar contactos del sistema';
$pageTitle = 'Gestión de Contactos';
$currentPage = 'contactos';

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
    </div>

    <div id="deleteConfirmation" style="display: none; background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 20px; margin: 20px 0; border-radius: 12px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.1); animation: slideDown 0.3s ease;">
        <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 15px;">
            <i class="fas fa-exclamation-triangle" style="font-size: 24px; color: #f39c12;"></i>
            <span id="confirmationMessage" style="font-size: 1.1rem; font-weight: 600;"></span>
        </div>
        <div style="display: flex; gap: 15px; justify-content: center;">
            <button id="confirmDelete" class="btn btn-danger">
                <i class="fas fa-trash"></i> Sí, Eliminar
            </button>
            <button id="cancelDelete" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </button>
        </div>
    </div>

    <!-- Tabla de contactos -->
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Asunto</th>
                    <th>Mensaje</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($contactos)): ?>
                    <?php foreach ($contactos as $contacto): ?>
                        <tr>
                            <td>
                                <span class="contact-id">#<?php echo $contacto['id']; ?></span>
                            </td>
                            <td>
                                <div class="contact-cell">
                                    <div class="contact-avatar-small">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="contact-info">
                                        <span class="contact-name"><?php echo htmlspecialchars($contacto['nombre']); ?></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="contact-email"><?php echo htmlspecialchars($contacto['email']); ?></span>
                            </td>
                            <td>
                                <span class="contact-subject"><?php echo htmlspecialchars($contacto['asunto']); ?></span>
                            </td>
                            <td>
                                <span class="contact-message" title="<?php echo htmlspecialchars($contacto['mensaje']); ?>">
                                    <?php echo htmlspecialchars(substr($contacto['mensaje'], 0, 50)) . (strlen($contacto['mensaje']) > 50 ? '...' : ''); ?>
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-<?php echo !empty($contacto['estado']) ? strtolower($contacto['estado']) : 'nuevo'; ?>">
                                    <?php echo !empty($contacto['estado']) ? ucfirst($contacto['estado']) : 'Nuevo'; ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <select class="status-select" data-contact-id="<?php echo $contacto['id']; ?>">
                                        <option value="nuevo" <?php echo ($contacto['estado'] == 'nuevo' || empty($contacto['estado'])) ? 'selected' : ''; ?>>Nuevo</option>
                                        <option value="leido" <?php echo $contacto['estado'] == 'leido' ? 'selected' : ''; ?>>Leído</option>
                                        <option value="respondido" <?php echo $contacto['estado'] == 'respondido' ? 'selected' : ''; ?>>Respondido</option>
                                        <option value="cerrado" <?php echo $contacto['estado'] == 'cerrado' ? 'selected' : ''; ?>>Cerrado</option>
                                    </select>
                                    <button class="btn-icon btn-delete" title="Eliminar" data-contact-id="<?php echo $contacto['id']; ?>">
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
                                <i class="fas fa-envelope"></i>
                                <h3>No hay contactos</h3>
                                <p>No se encontraron mensajes de contacto</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="pagination-section">
        <div class="pagination-info">
            <span>Mostrando <?php echo count($contactos); ?> contactos</span>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cambiar estado de contacto
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const contactId = this.dataset.contactId;
            const newStatus = this.value;
            
            // Enviar petición AJAX
            fetch('<?php echo BASE_URL; ?>index.php?route=contact/change-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `contact_id=${contactId}&estado=${newStatus}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar el badge de estado en la misma fila
                    const row = this.closest('tr');
                    const statusBadge = row.querySelector('.status-badge');
                    statusBadge.className = `status-badge status-${newStatus}`;
                    statusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                    
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                    // Revertir el select al valor anterior
                    this.value = this.dataset.previousValue || 'nuevo';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error al cambiar el estado', 'error');
                this.value = this.dataset.previousValue || 'nuevo';
            });
        });
        
        // Guardar valor anterior
        select.addEventListener('focus', function() {
            this.dataset.previousValue = this.value;
        });
    });
    
    // Variables globales para el proceso de eliminación
    let contactToDelete = null;
    let deleteButton = null;
    
    // Eliminar contacto
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const contactId = this.dataset.contactId;
            const contactName = this.closest('tr').querySelector('.contact-name').textContent;
            const contactEmail = this.closest('tr').querySelector('.contact-email').textContent;
            
            // Guardar referencia al botón y contacto
            contactToDelete = contactId;
            deleteButton = this;
            
            // Mostrar mensaje de confirmación
            document.getElementById('confirmationMessage').textContent = 
                `¿Estás seguro de que quieres eliminar el contacto de "${contactName}" (${contactEmail})?`;
            document.getElementById('deleteConfirmation').style.display = 'block';
            
            // Scroll hacia arriba para mostrar el mensaje
            setTimeout(() => {
                document.getElementById('deleteConfirmation').scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center',
                    inline: 'nearest'
                });
            }, 100);
        });
    });
    
    // Botón de confirmar eliminación
    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (contactToDelete && deleteButton) {
            // Enviar petición AJAX
            fetch('<?php echo BASE_URL; ?>index.php?route=contact/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `contact_id=${contactToDelete}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Eliminar la fila de la tabla
                    const row = deleteButton.closest('tr');
                    row.style.opacity = '0';
                    row.style.transform = 'translateY(-10px)';
                    
                    setTimeout(() => {
                        row.remove();
                        showNotification(data.message, 'success');
                    }, 300);
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error al eliminar el contacto', 'error');
            })
            .finally(() => {
                // Ocultar mensaje de confirmación con animación
                const confirmationDiv = document.getElementById('deleteConfirmation');
                confirmationDiv.style.animation = 'slideUp 0.3s ease';
                setTimeout(() => {
                    confirmationDiv.style.display = 'none';
                    confirmationDiv.style.animation = 'slideDown 0.3s ease';
                }, 300);
                contactToDelete = null;
                deleteButton = null;
            });
        }
    });
    
    // Botón de cancelar eliminación
    document.getElementById('cancelDelete').addEventListener('click', function() {
        const confirmationDiv = document.getElementById('deleteConfirmation');
        confirmationDiv.style.animation = 'slideUp 0.3s ease';
        setTimeout(() => {
            confirmationDiv.style.display = 'none';
            confirmationDiv.style.animation = 'slideDown 0.3s ease';
        }, 300);
        contactToDelete = null;
        deleteButton = null;
    });
    
    // Sistema de notificaciones
    function showNotification(message, type = 'info') {
        // Crear elemento de notificación
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        `;
        
        // Agregar estilos
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        
        document.body.appendChild(notification);
        
        // Animar entrada
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remover después de 3 segundos
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
});
</script>

