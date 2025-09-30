<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Panel de Admin - InmuYa'; ?></title>
    <meta name="description" content="<?php echo $description ?? 'Panel de administración de InmuYa'; ?>">
    <link rel="icon" type="image/jpeg" href="<?php echo BASE_URL; ?>public/img/logo.jpeg">
    
    <!-- CSS específico para admin -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/app.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/admin.css">
    
    <!-- CSS específico por página -->
    <?php if (isset($pageTitle) && strpos($pageTitle, 'Contactos') !== false): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/contactos.css">
    <?php elseif (isset($pageTitle) && strpos($pageTitle, 'Dashboard') !== false): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/dashboard.css">
    <?php endif; ?>
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="admin-body">
    <header class="header admin-header">
        <div class="barra">
            <div class="header-logo-panel">
                <img src="<?php echo BASE_URL; ?>public/img/logo.jpeg" alt="Logo InmuYa">
                <span>Panel Admin</span>
            </div>
            <div class="header-menu">
                <nav class="navegacion-principal">
                    <ul class="menu-navegacion">
                        <li><a href="<?php echo BASE_URL; ?>index.php?route=admin/dashboard">Dashboard</a></li>
                        <li><a href="<?php echo BASE_URL; ?>index.php?route=user/usuarios">Usuarios</a></li>
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
                            <span class="user-name"><?php echo $_SESSION['user_name'] ?? 'Usuario'; ?></span>
                        </div>
                        <div class="user-menu" style="position:relative;">
                            <button class="user-menu-toggle" style="background:none; border:none; cursor:pointer;" onclick="var dd=this.nextElementSibling; dd.classList.toggle('show'); event.stopPropagation();">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <ul class="user-dropdown" style="display:none; position:absolute; right:0; top:100%; background:var(--color-blanco); border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.08); padding:0.5rem 0; min-width:180px; z-index:200;">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>auth/logout">
                                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                            <script>
                            document.addEventListener('click', function(e) {
                                document.querySelectorAll('.user-dropdown.show').forEach(function(dd){
                                    dd.classList.remove('show');
                                });
                            });
                            </script>
                            <style>
                            .user-dropdown.show { display: block !important; }
                            </style>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</body>
</html>
