<?php
/**
 * Crear Nueva Propiedad - Panel de Administración
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
    <title>Crear Nueva Propiedad - InmuYa</title>
    <meta name="description" content="Crear nueva propiedad en el sistema">
    <link rel="icon" type="image/jpeg" href="<?php echo BASE_URL; ?>public/img/logo.jpeg">
    
    <!-- CSS específico para propiedades -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/propiedades.css">
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<!-- Contenido específico de creación de propiedades -->
<div class="main-container">
    <!-- Header de la página -->
    <div class="page-header">
        <div class="header-left">
            <h2>Crear Nueva Propiedad</h2>
            <p>Agregar una nueva propiedad al sistema</p>
        </div>
        <div class="header-right">
            <a href="<?php echo BASE_URL; ?>index.php?route=admin/propiedades" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Volver a Propiedades
            </a>
        </div>
    </div>
    
    <!-- Mostrar mensajes de sesión -->
    <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="mensaje-error">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo htmlspecialchars($_SESSION['error_message']); ?>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="mensaje-exito">
            <i class="fas fa-check-circle"></i>
            <?php echo htmlspecialchars($_SESSION['success_message']); ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <!-- Contenedor para mensajes dinámicos -->
    <div id="messageContainer"></div>

    <!-- Formulario de creación -->
    <div class="form-container">
        <form method="POST" action="<?php echo BASE_URL; ?>index.php?route=admin/crear-propiedad" id="createPropertyForm" class="property-form" enctype="multipart/form-data">
            
            <!-- SECCIÓN 1: INFORMACIÓN BÁSICA -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Información Básica
                </h3>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="titulo">Título de la Propiedad *</label>
                        <input type="text" id="titulo" name="titulo" required maxlength="255" placeholder="Ej: Hermosa casa en zona residencial">
    </div>
    
                    <div class="form-group full-width">
                        <label for="descripcion">Descripción *</label>
                        <textarea id="descripcion" name="descripcion" rows="4" required placeholder="Describe las características principales de la propiedad"></textarea>
                </div>
                
                <div class="form-group">
                        <label for="tipo">Tipo de Transacción *</label>
                    <select id="tipo" name="tipo" required>
                            <option value="">Selecciona el tipo</option>
                            <option value="arriendo">Arriendo</option>
                        <option value="venta">Venta</option>
                    </select>
            </div>
            
                <div class="form-group">
                        <label for="tipo_propiedad">Tipo de Propiedad *</label>
                    <select id="tipo_propiedad" name="tipo_propiedad" required>
                            <option value="">Selecciona el tipo</option>
                        <option value="casa">Casa</option>
                        <option value="apartamento">Apartamento</option>
                            <option value="local">Local</option>
                        <option value="oficina">Oficina</option>
                        <option value="bodega">Bodega</option>
                        <option value="terreno">Terreno</option>
                        <option value="finca">Finca</option>
                    </select>
                </div>
                
                <div class="form-group">
                        <label for="estado">Estado *</label>
                        <select id="estado" name="estado" required>
                            <option value="disponible">Disponible</option>
                            <option value="vendido">Vendido</option>
                            <option value="arrendado">Arrendado</option>
                            <option value="reservado">Reservado</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- SECCIÓN 2: UBICACIÓN -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-map-marker-alt"></i>
                    Ubicación
                </h3>
                <div class="form-grid">
            <div class="form-group">
                        <label for="id_ciudad">Ciudad</label>
                        <select id="id_ciudad" name="id_ciudad">
                            <option value="">Selecciona una ciudad</option>
                            <?php if (!empty($ciudades)): ?>
                                <?php foreach ($ciudades as $ciudad): ?>
                                    <option value="<?php echo $ciudad['id_ciudad']; ?>">
                                        <?php echo htmlspecialchars($ciudad['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
            </div>
            
            <div class="form-group">
                        <label for="id_barrio">Barrio</label>
                        <select id="id_barrio" name="id_barrio">
                            <option value="">Selecciona un barrio</option>
                            <!-- Opciones de barrios cargadas dinámicamente -->
                        </select>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="direccion">Dirección *</label>
                        <input type="text" id="direccion" name="direccion" maxlength="255" required placeholder="Calle 123 #45-67">
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 3: PRECIO Y ÁREA -->
            <div class="form-section price-area-section">
                <h3 class="section-title">
                    <i class="fas fa-dollar-sign"></i>
                    Precio y Área
                </h3>
                <div class="form-grid">
                    <div class="form-group checkbox-group small-checkbox">
                        <input type="checkbox" id="precio_negociable" name="precio_negociable" value="1" checked>
                        <label for="precio_negociable">Negociable</label>
            </div>
            
                <div class="form-group">
                        <label for="precio">Precio *</label>
                        <input type="number" id="precio" name="precio" step="0.01" min="0" required placeholder="0">
                </div>
                
                <div class="form-group">
                        <label for="area">Área (m²) *</label>
                        <input type="number" id="area" name="area" step="0.01" min="0" required placeholder="0.00">
                    </div>
                </div>
            </div>
            
            <!-- SECCIÓN 4: CARACTERÍSTICAS -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-home"></i>
                    Características de la Propiedad
                </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="habitaciones">Habitaciones *</label>
                        <input type="number" id="habitaciones" name="habitaciones" min="0" required placeholder="0">
                    </div>
                    
                <div class="form-group">
                        <label for="banos">Baños *</label>
                        <input type="number" id="banos" name="banos" min="0" required placeholder="0">
                </div>
                
                <div class="form-group">
                        <label for="piso">Piso</label>
                        <input type="number" id="piso" name="piso" min="0" placeholder="0">
                    </div>
                </div>
            </div>
            
            <!-- SECCIÓN 5: EXTRAS -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-star"></i>
                    Extras y Servicios
                </h3>
                <div class="amenities-grid">
                    <div class="amenity-item">
                        <input type="checkbox" id="parqueadero" name="parqueadero" value="1">
                        <label for="parqueadero">
                            <i class="fas fa-car"></i>
                            Parqueadero
                        </label>
                    </div>
                    
                    <div class="amenity-item">
                        <input type="checkbox" id="ascensor" name="ascensor" value="1">
                        <label for="ascensor">
                            <i class="fas fa-elevator"></i>
                            Ascensor
                        </label>
                    </div>
                    
                    <div class="amenity-item">
                        <input type="checkbox" id="balcon" name="balcon" value="1">
                        <label for="balcon">
                            <i class="fas fa-balcony"></i>
                            Balcón
                        </label>
                    </div>
                    
                    <div class="amenity-item">
                        <input type="checkbox" id="terraza" name="terraza" value="1">
                        <label for="terraza">
                            <i class="fas fa-umbrella"></i>
                            Terraza
                        </label>
                    </div>
                    
                    <div class="amenity-item">
                        <input type="checkbox" id="jardin" name="jardin" value="1">
                        <label for="jardin">
                            <i class="fas fa-seedling"></i>
                            Jardín
                        </label>
                    </div>
                    
                    <div class="amenity-item">
                        <input type="checkbox" id="piscina" name="piscina" value="1">
                        <label for="piscina">
                            <i class="fas fa-swimming-pool"></i>
                            Piscina
                        </label>
                    </div>
                    
                    <div class="amenity-item">
                        <input type="checkbox" id="gimnasio" name="gimnasio" value="1">
                        <label for="gimnasio">
                            <i class="fas fa-dumbbell"></i>
                            Gimnasio
                        </label>
                    </div>
                    
                    <div class="amenity-item">
                        <input type="checkbox" id="seguridad_24h" name="seguridad_24h" value="1">
                        <label for="seguridad_24h">
                            <i class="fas fa-shield-alt"></i>
                            Seguridad 24h
                        </label>
                    </div>
                    
                    <div class="amenity-item">
                        <input type="checkbox" id="mascotas_permitidas" name="mascotas_permitidas" value="1">
                        <label for="mascotas_permitidas">
                            <i class="fas fa-paw"></i>
                            Mascotas Permitidas
                        </label>
                    </div>
                </div>
                </div>
                
            <!-- SECCIÓN 6: ADMINISTRACIÓN Y SERVICIOS -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-cogs"></i>
                    Administración y Servicios
                </h3>
                <div class="form-grid">
                <div class="form-group">
                        <label for="valor_administracion">Valor Administración</label>
                        <input type="number" id="valor_administracion" name="valor_administracion" step="0.01" min="0" placeholder="0.00">
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="incluye_administracion" name="incluye_administracion" value="1">
                        <label for="incluye_administracion">Incluye Administración</label>
                    </div>
                    
                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="incluye_servicios" name="incluye_servicios" value="1">
                        <label for="incluye_servicios">Incluye Servicios</label>
                    </div>
                </div>
            </div>
            
            <!-- SECCIÓN 7: INFORMACIÓN DE CONTACTO -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-phone"></i>
                    Información de Contacto
                </h3>
                <div class="form-grid contact-grid">
                <div class="form-group">
                        <label for="nombre_contacto">Nombre del Contacto</label>
                        <input type="text" id="nombre_contacto" name="nombre_contacto" maxlength="100" placeholder="Nombre completo">
                </div>
                
                <div class="form-group">
                        <label for="telefono_contacto">Teléfono de Contacto</label>
                        <input type="tel" id="telefono_contacto" name="telefono_contacto" maxlength="20" placeholder="+57 300 123 4567">
                </div>
                    
            <div class="form-group">
                        <label for="email_contacto">Email de Contacto</label>
                        <input type="email" id="email_contacto" name="email_contacto" maxlength="100" placeholder="contacto@ejemplo.com">
            </div>
            
                    <div class="form-group checkbox-column">
                <div class="checkbox-group">
                            <input type="checkbox" id="mostrar_telefono" name="mostrar_telefono" value="1" checked>
                            <label for="mostrar_telefono">Mostrar Teléfono</label>
                </div>
                
                <div class="checkbox-group">
                            <input type="checkbox" id="mostrar_email" name="mostrar_email" value="1" checked>
                            <label for="mostrar_email">Mostrar Email</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 8: CONFIGURACIÓN -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-sliders-h"></i>
                    Configuración
                </h3>
                <div class="form-grid">
                    <div class="form-group checkbox-group">
                    <input type="checkbox" id="destacado" name="destacado" value="1">
                        <label for="destacado">Propiedad Destacada</label>
                </div>
                </div>
            </div>
            
            <!-- SECCIÓN 8: IMÁGENES DE LA PROPIEDAD -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-images"></i>
                    Imágenes de la Propiedad
                </h3>
                <div class="images-section">
                    <div class="upload-area">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <h4>Subir Imágenes</h4>
                        <p>Arrastra y suelta las imágenes aquí o haz clic para seleccionar</p>
                        <input type="file" id="property-images" name="imagenes[]" multiple accept="image/*" style="display: none;">
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('property-images').click()">
                            <i class="fas fa-plus"></i>
                            Seleccionar Imágenes
                        </button>
                    </div>
                    
                    <div class="images-preview" id="images-preview">
                        <!-- Las imágenes seleccionadas aparecerán aquí -->
                </div>
                
                    <div class="images-info">
                        <p><i class="fas fa-info-circle"></i> Puedes subir hasta 10 imágenes. Formatos permitidos: JPG, PNG, GIF</p>
                    </div>
                </div>
            </div>
            
            <!-- Botones de acción -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Crear Propiedad
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>

<!-- Scripts específicos -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para mostrar mensajes dinámicos
    function showMessage(message, type = 'info') {
        const messageContainer = document.getElementById('messageContainer');
        const messageDiv = document.createElement('div');
        
        let className, icon;
        switch(type) {
            case 'success':
                className = 'mensaje-exito';
                icon = 'fas fa-check-circle';
                break;
            case 'error':
                className = 'mensaje-error';
                icon = 'fas fa-exclamation-circle';
                break;
            default:
                className = 'mensaje-info';
                icon = 'fas fa-info-circle';
        }
        
        messageDiv.className = className;
        messageDiv.innerHTML = `
            <i class="${icon}"></i>
            ${message}
        `;
        
        messageContainer.insertBefore(messageDiv, messageContainer.firstChild);
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
    
    setTimeout(() => {
            messageDiv.style.opacity = '0';
            setTimeout(() => messageDiv.remove(), 300);
    }, 5000);
}

    // Validación y envío AJAX del formulario
    document.getElementById('createPropertyForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevenir envío normal del formulario
        
        const precio = document.getElementById('precio').value;
        const area = document.getElementById('area').value;
        const habitaciones = document.getElementById('habitaciones').value;
        const banos = document.getElementById('banos').value;
        
        // Validaciones
        if (parseFloat(precio) <= 0) {
            showMessage('El precio debe ser mayor a 0', 'error');
            return;
        }
        
        if (parseFloat(area) <= 0) {
            showMessage('El área debe ser mayor a 0', 'error');
            return;
        }
        
        if (parseInt(habitaciones) < 0) {
            showMessage('El número de habitaciones no puede ser negativo', 'error');
            return;
        }
        
        if (parseInt(banos) < 0) {
            showMessage('El número de baños no puede ser negativo', 'error');
            return;
        }
        
        // Mostrar indicador de carga
        const submitBtn = document.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creando...';
        submitBtn.disabled = true;
        
        // Preparar datos del formulario
        const formData = new FormData(this);
        
        // Debug: Verificar que las imágenes estén en FormData
        console.log('FormData entries:');
        for (let [key, value] of formData.entries()) {
            if (key === 'imagenes[]') {
                console.log(`${key}:`, value.name, value.size, value.type);
            } else {
                console.log(`${key}:`, value);
            }
        }
        
        // Enviar petición AJAX
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar mensaje de éxito primero
                showMessage(data.message, 'success');
                
                // Redirigir después de mostrar el mensaje
                setTimeout(() => {
                    window.location.href = '<?php echo BASE_URL; ?>index.php?route=admin/propiedades';
                }, 2000);
            } else {
                showMessage(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Error al crear la propiedad. Inténtalo de nuevo.', 'error');
        })
        .finally(() => {
            // Restaurar botón
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
});

// ===== FUNCIONALIDAD DE SUBIDA DE IMÁGENES =====
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('property-images');
    const previewContainer = document.getElementById('images-preview');
    const maxImages = 10;
    let selectedImages = [];

    // Manejar selección de archivos
    fileInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        
        // Validar número de imágenes
        if (selectedImages.length + files.length > maxImages) {
            showMessage(`Solo puedes subir máximo ${maxImages} imágenes`, 'error');
            return;
        }
        
        // Validar tipos de archivo
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        const invalidFiles = files.filter(file => !validTypes.includes(file.type));
        
        if (invalidFiles.length > 0) {
            showMessage('Solo se permiten archivos JPG, PNG y GIF', 'error');
            return;
        }
        
        // Procesar cada archivo
        files.forEach(file => {
            if (file.size > 5 * 1024 * 1024) { // 5MB
                showMessage(`La imagen ${file.name} es muy grande. Máximo 5MB`, 'error');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const imageData = {
                    file: file,
                    url: e.target.result,
                    id: Date.now() + Math.random()
                };
                
                selectedImages.push(imageData);
                displayImagePreview(imageData);
            };
            reader.readAsDataURL(file);
        });
        
        // Limpiar input
        fileInput.value = '';
    });

    // Mostrar preview de imagen
    function displayImagePreview(imageData) {
        const previewItem = document.createElement('div');
        previewItem.className = 'image-preview-item';
        previewItem.dataset.imageId = imageData.id;
        
        previewItem.innerHTML = `
            <img src="${imageData.url}" alt="Preview">
            <button type="button" class="remove-image" onclick="removeImage('${imageData.id}')">
                <i class="fas fa-times"></i>
            </button>
            <div class="image-info">
                ${imageData.file.name}
            </div>
        `;
        
        previewContainer.appendChild(previewItem);
    }

    // Función global para remover imagen
    window.removeImage = function(imageId) {
        selectedImages = selectedImages.filter(img => img.id != imageId);
        const previewItem = document.querySelector(`[data-image-id="${imageId}"]`);
        if (previewItem) {
            previewItem.remove();
        }
    };

    // Drag and drop
    const uploadArea = document.querySelector('.upload-area');
    
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = 'var(--color-secundario)';
        uploadArea.style.background = 'rgba(12, 97, 136, 0.1)';
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = 'var(--color-principal)';
        uploadArea.style.background = 'rgba(12, 97, 136, 0.05)';
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = 'var(--color-principal)';
        uploadArea.style.background = 'rgba(12, 97, 136, 0.05)';
        
        const files = Array.from(e.dataTransfer.files);
        fileInput.files = e.dataTransfer.files;
        fileInput.dispatchEvent(new Event('change'));
    });
    
    // ===== CARGA DINÁMICA DE BARRIOS =====
    const ciudadSelect = document.getElementById('id_ciudad');
    const barrioSelect = document.getElementById('id_barrio');
    
    ciudadSelect.addEventListener('change', function() {
        const idCiudad = this.value;
        
        // Limpiar barrios existentes
        barrioSelect.innerHTML = '<option value="">Selecciona un barrio</option>';
        
        if (idCiudad) {
            // Mostrar loading
            barrioSelect.innerHTML = '<option value="">Cargando barrios...</option>';
            barrioSelect.disabled = true;
            
            // Realizar petición AJAX
            fetch(`<?php echo BASE_URL; ?>index.php?route=admin/obtener-barrios&id_ciudad=${idCiudad}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        barrioSelect.innerHTML = '<option value="">Selecciona un barrio</option>';
                        
                        data.barrios.forEach(barrio => {
                    const option = document.createElement('option');
                            option.value = barrio.id_barrio;
                    option.textContent = barrio.nombre;
                    barrioSelect.appendChild(option);
                });
                        
                        barrioSelect.disabled = false;
                    } else {
                        barrioSelect.innerHTML = '<option value="">Error al cargar barrios</option>';
                        console.error('Error:', data.error);
                    }
                })
                .catch(error => {
                    barrioSelect.innerHTML = '<option value="">Error al cargar barrios</option>';
                    console.error('Error:', error);
                });
        } else {
            barrioSelect.disabled = false;
        }
    });
});
</script>