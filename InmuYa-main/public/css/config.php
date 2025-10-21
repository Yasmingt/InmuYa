<?php
/**
 * Generador de CSS con rutas dinámicas
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Incluir configuración
require_once __DIR__ . '/../../config/config.php';

// Establecer el tipo de contenido
header('Content-Type: text/css');

// Variables CSS para rutas de imágenes
?>
/* ========================================
   InmuYa - Configuración de Rutas CSS
   Sistema de gestión inmobiliaria
   ======================================== */

/* Variables CSS para rutas de imágenes */
:root {
    --img-header: url('<?php echo IMG_URL; ?>header.jpg');
    --img-logo: url('<?php echo IMG_URL; ?>logo.jpeg');
    --img-house: url('<?php echo IMG_URL; ?>house.png');
    --img-edificio: url('<?php echo IMG_URL; ?>edificio.jpg');
    --img-contrato: url('<?php echo IMG_URL; ?>contrato.jpg');
    --img-dinero: url('<?php echo IMG_URL; ?>dinero.png');
    --img-candado: url('<?php echo IMG_URL; ?>candado.png');
    --img-chequeo: url('<?php echo IMG_URL; ?>chequeo-de-tiempo.png');
    --img-aptos: url('<?php echo IMG_URL; ?>aptos_seguros.jpg');
    --img-anuncio7: url('<?php echo IMG_URL; ?>anuncio7.jpg');
    --img-anuncio8: url('<?php echo IMG_URL; ?>anuncio8.jpg');
    --img-login-bg: url('<?php echo IMG_URL; ?>login-bg.jpg');
    
    /* Iconos SVG */
    --icono-dormitorio: url('<?php echo IMG_URL; ?>icono_dormitorio.svg');
    --icono-estacionamiento: url('<?php echo IMG_URL; ?>icono_estacionamiento.svg');
    --icono-wc: url('<?php echo IMG_URL; ?>icono_wc.svg');
    --icono1: url('<?php echo IMG_URL; ?>icono1.svg');
    --icono2: url('<?php echo IMG_URL; ?>icono2.svg');
    --icono3: url('<?php echo IMG_URL; ?>icono3.svg');
}

/* Clases utilitarias para imágenes de fondo */
.bg-header {
    background-image: var(--img-header);
}

.bg-logo {
    background-image: var(--img-logo);
}

.bg-house {
    background-image: var(--img-house);
}

.bg-edificio {
    background-image: var(--img-edificio);
}

.bg-contrato {
    background-image: var(--img-contrato);
}

.bg-dinero {
    background-image: var(--img-dinero);
}

.bg-candado {
    background-image: var(--img-candado);
}

.bg-chequeo {
    background-image: var(--img-chequeo);
}

.bg-aptos {
    background-image: var(--img-aptos);
}

.bg-anuncio7 {
    background-image: var(--img-anuncio7);
}

.bg-anuncio8 {
    background-image: var(--img-anuncio8);
}

.bg-login {
    background-image: var(--img-login-bg);
}

/* Configuración común para imágenes de fondo */
.bg-header,
.bg-logo,
.bg-house,
.bg-edificio,
.bg-contrato,
.bg-dinero,
.bg-candado,
.bg-chequeo,
.bg-aptos,
.bg-anuncio7,
.bg-anuncio8,
.bg-login {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
