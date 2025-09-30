<?php
/**
 * Dashboard de Administrador
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Vista principal del panel de administración
 */

// Definir variables para el layout
$title = 'Dashboard - Panel de Administración';
$description = 'Panel de administración de InmuYa';
$pageTitle = 'Dashboard';

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

    <!-- Gráficos y tablas -->
    <div class="dashboard-grid">
        <!-- Gráfico de usuarios por tipo -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Usuarios por Tipo</h3>
                <div class="card-actions">
                    <button class="btn-icon">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>
            <div class="card-content">
                <div class="chart-container">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Usuarios recientes -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Usuarios Recientes</h3>
                <div class="card-actions">
                    <a href="<?php echo BASE_URL; ?>index.php?route=user/usuarios" class="btn-link">Ver todos</a>
                </div>
            </div>
            <div class="card-content">
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
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
                                                    <span class="user-email"><?php echo htmlspecialchars($user['email']); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?php echo strtolower($user['tipo_usuario']); ?>">
                                                <?php echo ucfirst($user['tipo_usuario']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No hay usuarios recientes</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Acciones rápidas -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3>Acciones Rápidas</h3>
            </div>
            <div class="card-content">
                <div class="quick-actions">
                    <a href="<?php echo BASE_URL; ?>index.php?route=user/usuarios" class="quick-action">
                        <i class="fas fa-user-plus"></i>
                        <span>Nuevo Usuario</span>
                    </a>
                    <a href="<?php echo BASE_URL; ?>admin/propiedades/nueva" class="quick-action">
                        <i class="fas fa-plus"></i>
                        <span>Nueva Propiedad</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts específicos del dashboard -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Debug: mostrar datos de estadísticas
    console.log('Stats data:', <?php echo json_encode($stats); ?>);
    
    // Gráfico de usuarios por tipo
    const ctx = document.getElementById('usersChart').getContext('2d');
    const usersChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Clientes', 'Propietarios', 'Administrativos'],
            datasets: [{
                data: [
                    <?php echo $stats['by_type']['cliente'] ?? 0; ?>,
                    <?php echo $stats['by_type']['propietario'] ?? 0; ?>,
                    <?php echo $stats['by_type']['administrativo'] ?? 0; ?>
                ],
                backgroundColor: [
                    '#3B82F6',
                    '#10B981',
                    '#F59E0B'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
</script>
