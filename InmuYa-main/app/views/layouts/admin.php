<?php
/**
 * Layout Principal del Panel de Administración
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Panel de Admin - InmuYa'; ?></title>
    <meta name="description" content="<?php echo $description ?? 'Panel de administración de InmuYa'; ?>">
    <link rel="icon" type="image/jpeg" href="<?php echo IMG_URL; ?>logo.jpeg">
    
    <!-- CSS específico para admin -->
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>config.php">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>admin.css">
    
    <!-- CSS específico por página -->
    <?php if (isset($currentPage)): ?>
        <link rel="stylesheet" href="<?php echo CSS_URL; ?><?php echo $currentPage; ?>.css">
    <?php endif; ?>
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-body">
    <header class="header admin-header">
        <div class="barra">
            <div class="header-logo-panel">
                <img src="<?php echo IMG_URL; ?>logo.jpeg" alt="Logo InmuYa">
                <span>Panel Admin</span>
            </div>
            <div class="header-menu">
                <nav class="navegacion-principal">
                    <ul class="menu-navegacion">
                        <li><a href="<?php echo BASE_URL; ?>index.php?route=admin/dashboard">Dashboard</a></li>
                        <li><a href="<?php echo BASE_URL; ?>index.php?route=admin/usuarios/usuarios">Usuarios</a></li>
                        <li><a href="<?php echo BASE_URL; ?>index.php?route=admin/propiedades">Propiedades</a></li>
                        <li><a href="<?php echo BASE_URL; ?>index.php?route=admin/contactos">Contactos</a></li>
                    </ul>
                </nav>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <div class="user-avatar">
                         <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="user-details">
                        <span class="user-name">
                            <?php 
                            // Intentar diferentes nombres de variables de sesión
                            $userName = $_SESSION['user_name'] ?? 
                                       $_SESSION['nombre'] ?? 
                                       $_SESSION['nombre_usuario'] ?? 
                                       $_SESSION['usuario'] ?? 
                                       $_SESSION['name'] ?? 
                                       'Usuario';
                            echo htmlspecialchars($userName);
                            ?>
                        </span>
                    </div>
                    <div class="user-menu">
                        <button class="user-menu-toggle">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <ul class="user-dropdown">
                            <li>
                                <a href="<?php echo BASE_URL; ?>index.php?route=auth/cerrar-sesion">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

<script>
// Toggle del dropdown del usuario
document.addEventListener('DOMContentLoaded', function() {
    const userMenuToggle = document.querySelector('.user-menu-toggle');
    const userDropdown = document.querySelector('.user-dropdown');
    
    if (userMenuToggle && userDropdown) {
        userMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });
        
        // Cerrar dropdown al hacer click fuera
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-menu')) {
                userDropdown.classList.remove('show');
            }
        });
    }
});
</script>
</body>
</html>
