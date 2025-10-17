<?php
/**
 * Dashboard de Administrador
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Vista principal del panel de administración
 */

// Definir variables para el layout
$title = 'Dashboard ';
$description = 'Panel de administración de InmuYa';
$pageTitle = 'Dashboard';
$currentPage = 'dashboard';

// Incluir el layout de administrador
include __DIR__ . '/../layouts/admin.php';
?>

<!-- Contenido específico del dashboard -->
<div class="dashboard-content">
    
    <!-- Tarjetas de estadísticas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['total_users'] ?? '0'; ?></h3>
                <p>Total Usuarios</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['total_properties'] ?? '0'; ?></h3>
                <p>Propiedades</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo $stats['total_contacts'] ?? '0'; ?></h3>
                <p>Contactos</p>
            </div>
        </div>
    </div>

    <!-- Layout principal del dashboard -->
    <div class="dashboard-layout">
        <!-- Columna izquierda: Tabla de usuarios -->
        <div class="dashboard-left">
            <!-- Usuarios recientes -->
            <div class="activity-section">
                <div class="section-header">
                    <div>
                        <h3 class="section-title">Usuarios Recientes</h3>
                        <p class="section-subtitle">Últimos usuarios registrados</p>
                    </div>
                    <div class="card-actions">
                        <a href="<?php echo BASE_URL; ?>index.php?route=admin/usuarios/usuarios" class="btn btn-primary">
                            <i class="fas fa-eye"></i>
                            Ver todos
                        </a>
                    </div>
                </div>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_users)): ?>
                                <?php foreach ($recent_users as $user): ?>
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <div class="user-info">
                                                    <span class="user-name"><?php echo htmlspecialchars($user['nombre']); ?></span>
                                                </div>
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
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center">No hay usuarios recientes</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Columna derecha: Acciones rápidas -->
        <div class="dashboard-right">
            <div class="quick-actions">
                <div class="section-header">
                    <h3 class="section-title">Acciones Rápidas</h3>
                </div>
                <a href="<?php echo BASE_URL; ?>index.php?route=admin/usuarios/nuevo" class="quick-action-item">
                    <div class="quick-action-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="quick-action-content">
                        <h4>Nuevo Usuario</h4>
                        <p>Crear un nuevo usuario</p>
                    </div>
                </a>
                <a href="<?php echo BASE_URL; ?>index.php?route=admin/propiedades" class="quick-action-item">
                    <div class="quick-action-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="quick-action-content">
                        <h4>Nueva Propiedad</h4>
                        <p>Agregar nueva propiedad</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>