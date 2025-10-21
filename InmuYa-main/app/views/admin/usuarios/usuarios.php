<?php
/**
 * Gestión de Usuarios - Panel de Administración
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Definir variables para el layout
$title = 'Gestión de Usuarios';
$description = 'Administrar usuarios del sistema';
$pageTitle = 'Gestión de Usuarios';
$currentPage = 'usuarios';

// Incluir el layout de administrador
include __DIR__ . '/../../layouts/admin.php';
?>

<!-- CSS específico para gestión de usuarios ya cargado en admin.php -->

<!-- Contenido específico de gestión de usuarios -->
<div class="usuarios-content">
    <!-- Header de la página -->
    <div class="page-header">
        <div class="header-left">
            <h2>Gestión de Usuarios</h2>
            <p>Administra todos los usuarios del sistema</p>
        </div>
        <div class="header-right">
            <a href="<?php echo BASE_URL; ?>index.php?route=admin/usuarios/nuevo" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Nuevo Usuario
            </a>
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

    <!-- Tabla de usuarios -->
    <div class="table-section">
        <div class="table-container">
            <table class="data-table" id="usersTable">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Teléfono</th>
                        <th>Fecha Nacimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($usuarios)): ?>
                        <?php foreach ($usuarios as $user): ?>
                            <tr data-user-id="<?php echo $user['id_usuario']; ?>">
                                <td>
                                    <div class="user-info">
                                        <span class="user-name"><?php echo htmlspecialchars($user['nombre']); ?></span>
                                        <span class="user-numeroIdentidad"><?php echo $user['numerodocumento']; ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="user-email"><?php echo htmlspecialchars($user['email']); ?></span>
                                </td>
                                <td>
                                    <span class="badge <?php echo strtolower($user['tipo_usuario']); ?>">
                                        <?php echo ucfirst($user['tipo_usuario']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="user-phone"><?php echo htmlspecialchars($user['telefono']); ?></span>
                                </td>
                                <td>
                                    <span class="user-date"><?php echo date('d/m/Y', strtotime($user['fechadenacimiento'] ?? 'now')); ?></span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon btn-edit" title="Editar" data-user-id="<?php echo $user['id_usuario']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-icon btn-delete" title="Eliminar" data-user-id="<?php echo $user['id_usuario']; ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <h3>No hay usuarios</h3>
                                    <p>No se encontraron usuarios en el sistema</p>
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
            <span>Mostrando 1-<?php echo count($usuarios); ?> de <?php echo count($usuarios); ?> usuarios</span>
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
    
    
    // Botones de acción
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            // Redirigir a la página de edición
            window.location.href = `<?php echo BASE_URL; ?>index.php?route=admin/usuarios/editar&id=${userId}`;
        });
    });
    
    // Variables globales para el proceso de eliminación
    let userToDelete = null;
    let deleteButton = null;
    
    // Botones de eliminar
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const userName = this.closest('tr').querySelector('.user-name').textContent;
            const userDocumento = this.closest('tr').querySelector('.user-numeroIdentidad').textContent;
            
            // Guardar referencia al botón y usuario
            userToDelete = userId;
            deleteButton = this;
            
            // Mostrar mensaje de confirmación
            document.getElementById('confirmationMessage').textContent = 
                `¿Estás seguro de que quieres eliminar al usuario "${userName}" (Documento: ${userDocumento})?`;
            document.getElementById('deleteConfirmation').style.display = 'block';
            
            // Scroll hacia arriba para mostrar el mensaje
            document.getElementById('deleteConfirmation').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        });
    });
    
    // Botón de confirmar eliminación
    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (userToDelete && deleteButton) {
            // Petición AJAX para eliminar el usuario
            fetch('<?php echo BASE_URL; ?>index.php?route=admin/usuarios/eliminar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `user_id=${userToDelete}`
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
                showNotification('Error al eliminar el usuario', 'error');
            })
            .finally(() => {
                // Ocultar mensaje de confirmación
                document.getElementById('deleteConfirmation').style.display = 'none';
                userToDelete = null;
                deleteButton = null;
            });
        }
    });
    
    // Botón de cancelar eliminación
    document.getElementById('cancelDelete').addEventListener('click', function() {
        document.getElementById('deleteConfirmation').style.display = 'none';
        userToDelete = null;
        deleteButton = null;
    });
    
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
        showNotification('Usuario creado correctamente', 'success');
    } else if (urlParams.get('success') === 'updated') {
        showNotification('Usuario actualizado correctamente', 'success');
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
