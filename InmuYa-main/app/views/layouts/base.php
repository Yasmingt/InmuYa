<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'InmuYa'; ?></title>
    <meta name="description" content="<?php echo $description ?? 'Plataforma inmobiliaria'; ?>">
    <link rel="icon" type="image/jpeg" href="<?php echo IMG_URL; ?>logo.jpeg">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>config.php">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>app.css">
</head>
<body>
    <!-- Header básico para otras páginas -->
    <header class="header header-simple">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="<?php echo BASE_URL; ?>" class="logo">InmuYa</a>
                <nav class="navegacion-principal">
                    <ul class="menu-navegacion">
                        <li><a href="<?php echo BASE_URL; ?>">Inicio</a></li>
                        <li><a href="<?php echo BASE_URL; ?>login.php">Iniciar Sesión</a></li>
                        <li><a href="<?php echo BASE_URL; ?>registro.php">Registrarse</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="main-content">
        <?php 
        // Aquí se incluirá el contenido específico de cada página
        ?>
    </main>

    <!-- Footer común -->
    <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
