<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'InmuYa'; ?></title>
    <link rel="icon" type="image/jpeg" href="<?php echo BASE_URL; ?>public/img/logo.jpeg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/app.css">
</head>
<body>
    <!-- Header completo para index -->
    <header class="header inicio">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="#" class="logo">InmuYa</a>
                <div>
                    <nav class="navegacion-principal">
                        <ul class="menu-navegacion">
                            <li><a href="#nosotros">Nosotros</a></li>
                            <li><a href="#servicios">Servicios</a></li>
                            <li><a href="#productos">Propiedades</a></li>
                            <li><a href="#contacto">Contacto</a></li>
                            <button class="boton-sesion">
                                <a href="<?php echo BASE_URL; ?>index.php?route=auth/login">Iniciar Sesión</a>
                            </button>
                        </ul>
                    </nav>
                </div>
            </div>
            
            <div class="contenido-hero">
                <h1>Tu hogar perfecto te está esperando</h1>
                <p>Conectamos propietarios y arrendatarios de manera fácil, segura y confiable. Encuentra la propiedad de tus sueños o arrienda la tuya con total tranquilidad.</p>
            </div>
        </div>
    </header>

    <!-- Contenido específico del index -->
    <?php 
    // Aquí se incluirá el contenido específico del index
    ?>
</body>
</html>
