<?php
/**
 * Gestión de Contactos - Panel de Administración
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Definir variables para el layout
$title = 'Gestión de Contactos';
$description = 'Administrar contactos del sistema';
$pageTitle = 'Gestión de Contactos';
$currentPage = 'contactos';

// Incluir el layout de administrador
include __DIR__ . '/../layouts/admin.php';
?>

<!-- Contenido específico de gestión de contactos -->
<div class="contactos-content">
    <!-- Header de la página -->
    <div class="page-header">
        <div class="header-left">
            <h2>Gestión de Contactos</h2>
            <p>Administra todos los contactos del sistema</p>
        </div>
    </div>

    <!-- Lista de contactos -->
    <div class="contacts-list">
        <?php for ($i = 1; $i <= 8; $i++): ?>
            <div class="contact-item">
                <div class="contact-checkbox">
                    <input type="checkbox" class="contact-check">
                </div>
                <div class="contact-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="contact-info">
                    <h4>Contacto #<?php echo $i; ?></h4>
                    <p class="contact-email">contacto<?php echo $i; ?>@email.com</p>
                    <p class="contact-message">
                        <?php 
                        $messages = [
                            'Interesado en la propiedad de la calle 123',
                            'Necesito información sobre precios',
                            '¿Tienen propiedades en el norte?',
                            'Quiero agendar una visita',
                            'Consulta sobre financiación',
                            '¿Cuál es el proceso de compra?',
                            'Necesito ver más fotos',
                            '¿Tienen opciones de arriendo?'
                        ];
                        echo $messages[($i-1) % count($messages)];
                        ?>
                    </p>
                </div>
                <div class="contact-meta">
                    <div class="contact-status">
                        <span class="status-badge status-<?php echo ['nuevo', 'leido', 'respondido', 'cerrado'][($i-1) % 4]; ?>">
                            <?php echo ucfirst(['nuevo', 'leido', 'respondido', 'cerrado'][($i-1) % 4]); ?>
                        </span>
                    </div>
                    <div class="contact-date">
                        <i class="fas fa-clock"></i>
                        Hace <?php echo $i; ?> horas
                    </div>
                    <div class="contact-actions">
                        <button class="btn-icon" title="Marcar como leído">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-icon" title="Responder">
                            <i class="fas fa-reply"></i>
                        </button>
                        <button class="btn-icon" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php endfor; ?>
    </div>

    <!-- Paginación -->
    <div class="pagination-section">
        <div class="pagination-info">
            <span>Mostrando 1-8 de 150 contactos</span>
        </div>
        <div class="pagination">
            <button class="btn-pagination" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="btn-pagination active">1</button>
            <button class="btn-pagination">2</button>
            <button class="btn-pagination">3</button>
            <button class="btn-pagination">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

