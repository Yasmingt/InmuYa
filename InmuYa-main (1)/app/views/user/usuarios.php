<?php
/**
 * Gestión de Usuarios - Panel de Administración
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Definir variables para el layout
$title = 'Gestión de Usuarios - Panel de Administración';
$description = 'Administrar usuarios del sistema';
$pageTitle = 'Gestión de Usuarios';

// Incluir el layout de administrador
include __DIR__ . '/../layouts/admin.php';
?>

<!-- Contenido específico de gestión de usuarios -->
<div class="usuarios-content">
    <!-- Header de la página -->
    <div class="page-header">
        <div class="header-left">
            <h2>Gestión de Usuarios</h2>
            <p>Administra todos los usuarios del sistema</p>
        </div>
        <div class="header-right">
            <button class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Nuevo Usuario
            </button>
        </div>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="filters-section">
        <div class="filters-row">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Buscar usuarios..." id="userSearch">
            </div>
            <div class="filter-group">
                <select id="typeFilter">
                    <option value="">Todos los tipos</option>
                    <option value="cliente">Cliente</option>
                    <option value="propietario">Propietario</option>
                    <option value="admistrativo">Administrativo</option>
                </select>
            </div>
            <div class="filter-group">
                <select id="statusFilter">
                    <option value="">Todos los estados</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="table-section">
        <div class="table-container">
            <table class="data-table" id="usersTable">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Teléfono</th>
                        <th>Fecha Registro</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr data-user-id="<?php echo $user['id_usuario']; ?>">
                                <td>
                                    <input type="checkbox" class="user-checkbox" value="<?php echo $user['id_usuario']; ?>">
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar-small">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="user-info">
                                            <span class="user-name"><?php echo htmlspecialchars($user['nombre']); ?></span>
                                            <span class="user-id">ID: <?php echo $user['id_usuario']; ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="user-email"><?php echo htmlspecialchars($user['email']); ?></span>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo strtolower($user['tipo_usuario']); ?>">
                                        <?php echo ucfirst($user['tipo_usuario']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="user-phone"><?php echo htmlspecialchars($user['telefono']); ?></span>
                                </td>
                                <td>
                                    <span class="user-date"><?php echo date('d/m/Y', strtotime($user['fecha_creacion'] ?? 'now')); ?></span>
                                </td>
                                <td>
                                    <span class="status status-active">Activo</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon btn-edit" title="Editar" data-user-id="<?php echo $user['id_usuario']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-icon btn-view" title="Ver detalles" data-user-id="<?php echo $user['id_usuario']; ?>">
                                            <i class="fas fa-eye"></i>
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
                            <td colspan="8" class="text-center">
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
            <span>Mostrando 1-<?php echo count($users); ?> de <?php echo count($users); ?> usuarios</span>
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

<!-- Modal de edición de usuario -->
<div class="modal" id="editUserModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Editar Usuario</h3>
            <button class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="editUserForm">
                <div class="form-group">
                    <label for="editNombre">Nombre</label>
                    <input type="text" id="editNombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="editEmail">Email</label>
                    <input type="email" id="editEmail" name="email" required>
                </div>
                <div class="form-group">
                    <label for="editTelefono">Teléfono</label>
                    <input type="tel" id="editTelefono" name="telefono">
                </div>
                <div class="form-group">
                    <label for="editTipo">Tipo de Usuario</label>
                    <select id="editTipo" name="tipo_usuario" required>
                        <option value="cliente">Cliente</option>
                        <option value="propietario">Propietario</option>
                        <option value="admistrativo">Administrativo</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary modal-cancel">Cancelar</button>
            <button class="btn btn-primary modal-save">Guardar Cambios</button>
        </div>
    </div>
</div>

<!-- Scripts específicos -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Búsqueda de usuarios
    const searchInput = document.getElementById('userSearch');
    const usersTable = document.getElementById('usersTable');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = usersTable.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const userName = row.querySelector('.user-name').textContent.toLowerCase();
            const userEmail = row.querySelector('.user-email').textContent.toLowerCase();
            
            if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Filtros
    const typeFilter = document.getElementById('typeFilter');
    const statusFilter = document.getElementById('statusFilter');
    
    function applyFilters() {
        const typeValue = typeFilter.value;
        const statusValue = statusFilter.value;
        const rows = usersTable.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            let showRow = true;
            
            if (typeValue) {
                const userType = row.querySelector('.badge').textContent.toLowerCase();
                if (userType !== typeValue) {
                    showRow = false;
                }
            }
            
            if (statusValue) {
                const userStatus = row.querySelector('.status').textContent.toLowerCase();
                if (userStatus !== statusValue) {
                    showRow = false;
                }
            }
            
            row.style.display = showRow ? '' : 'none';
        });
    }
    
    typeFilter.addEventListener('change', applyFilters);
    statusFilter.addEventListener('change', applyFilters);
    
    // Select all checkbox
    const selectAllCheckbox = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    
    selectAllCheckbox.addEventListener('change', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    
    // Botones de acción
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            // Aquí iría la lógica para cargar los datos del usuario en el modal
            document.getElementById('editUserModal').classList.add('show');
        });
    });
    
    // Cerrar modal
    document.querySelector('.modal-close').addEventListener('click', function() {
        document.getElementById('editUserModal').classList.remove('show');
    });
    
    document.querySelector('.modal-cancel').addEventListener('click', function() {
        document.getElementById('editUserModal').classList.remove('show');
    });
});
</script>
