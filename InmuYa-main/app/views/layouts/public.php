<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'InmuYa - Sistema Inmobiliario'; ?></title>
    <meta name="description" content="<?php echo isset($description) ? $description : 'Sistema de gestión inmobiliaria'; ?>">
    
    <!-- CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/css/app.css" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_URL; ?>public/img/logo.jpeg">
    
    <style>
        /* Estilos globales para páginas públicas */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }
        
        .public-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #333;
        }
        
        .logo img {
            height: 40px;
            width: auto;
        }
        
        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 30px;
        }
        
        .nav-menu a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .nav-menu a:hover {
            color: #667eea;
        }
        
        .nav-menu a.active {
            color: #667eea;
            font-weight: 600;
        }
        
        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-outline {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
        }
        
        .btn-outline:hover {
            background: #667eea;
            color: white;
        }
        
        .public-footer {
            background: #333;
            color: white;
            padding: 40px 0;
            margin-top: 60px;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .footer-section h3 {
            margin-bottom: 15px;
            color: #667eea;
        }
        
        .footer-section p,
        .footer-section a {
            color: #ccc;
            text-decoration: none;
            margin-bottom: 8px;
            display: block;
        }
        
        .footer-section a:hover {
            color: white;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            margin-top: 20px;
            border-top: 1px solid #555;
            color: #999;
        }
        
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #333;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            
            .nav-menu.active {
                display: flex;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .header-actions {
                gap: 10px;
            }
            
            .btn {
                padding: 8px 16px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Header Público -->
    <header class="public-header">
        <div class="header-content">
            <a href="<?php echo BASE_URL; ?>" class="logo">
                <img src="<?php echo BASE_URL; ?>public/img/logo.jpeg" alt="InmuYa Logo">
                <h1>InmuYa</h1>
            </a>
            
            <nav>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="<?php echo BASE_URL; ?>" class="<?php echo ($currentPage === 'home') ? 'active' : ''; ?>">Inicio</a></li>
                    <li><a href="<?php echo BASE_URL; ?>propiedades" class="<?php echo ($currentPage === 'propiedades') ? 'active' : ''; ?>">Propiedades</a></li>
                    <li><a href="<?php echo BASE_URL; ?>contacto" class="<?php echo ($currentPage === 'contacto') ? 'active' : ''; ?>">Contacto</a></li>
                    <li><a href="<?php echo BASE_URL; ?>nosotros" class="<?php echo ($currentPage === 'nosotros') ? 'active' : ''; ?>">Nosotros</a></li>
                </ul>
            </nav>
            
            <div class="header-actions">
                <a href="<?php echo BASE_URL; ?>auth/login" class="btn btn-outline">
                    <i class="fas fa-sign-in-alt"></i>
                    Iniciar Sesión
                </a>
                <a href="<?php echo BASE_URL; ?>auth/registration" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Registrarse
                </a>
                <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>
    
    <!-- Contenido Principal -->
    <main>
        <?php 
        // Aquí se incluye el contenido específico de cada página
        // El contenido se define en las vistas individuales
        ?>
    </main>
    
    <!-- Footer Público -->
    <footer class="public-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3><i class="fas fa-home"></i> InmuYa</h3>
                <p>Tu plataforma inmobiliaria de confianza. Encuentra la propiedad perfecta para ti.</p>
            </div>
            
            <div class="footer-section">
                <h3><i class="fas fa-link"></i> Enlaces Rápidos</h3>
                <a href="<?php echo BASE_URL; ?>propiedades">Propiedades</a>
                <a href="<?php echo BASE_URL; ?>propiedades?tipo=venta">Casas en Venta</a>
                <a href="<?php echo BASE_URL; ?>propiedades?tipo=arriendo">Casas en Arriendo</a>
                <a href="<?php echo BASE_URL; ?>contacto">Contacto</a>
            </div>
            
            <div class="footer-section">
                <h3><i class="fas fa-info-circle"></i> Información</h3>
                <a href="<?php echo BASE_URL; ?>nosotros">Sobre Nosotros</a>
                <a href="<?php echo BASE_URL; ?>terminos">Términos y Condiciones</a>
                <a href="<?php echo BASE_URL; ?>privacidad">Política de Privacidad</a>
                <a href="<?php echo BASE_URL; ?>ayuda">Ayuda</a>
            </div>
            
            <div class="footer-section">
                <h3><i class="fas fa-envelope"></i> Contacto</h3>
                <p><i class="fas fa-phone"></i> +57 (1) 234-5678</p>
                <p><i class="fas fa-envelope"></i> info@inmuya.com</p>
                <p><i class="fas fa-map-marker-alt"></i> Bogotá, Colombia</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> InmuYa. Todos los derechos reservados.</p>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script>
        function toggleMobileMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('active');
        }
        
        // Cerrar menú móvil al hacer clic en un enlace
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('navMenu').classList.remove('active');
            });
        });
        
        // Cerrar menú móvil al hacer clic fuera
        document.addEventListener('click', (e) => {
            const navMenu = document.getElementById('navMenu');
            const mobileToggle = document.querySelector('.mobile-menu-toggle');
            
            if (!navMenu.contains(e.target) && !mobileToggle.contains(e.target)) {
                navMenu.classList.remove('active');
            }
        });
    </script>
</body>
</html>
