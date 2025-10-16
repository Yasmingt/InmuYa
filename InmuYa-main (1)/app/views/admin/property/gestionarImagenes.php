<?php
/**
 * Gestión de Imágenes - Panel de Administración
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Definir variables para el layout
$title = 'Gestión de Imágenes - ' . $propiedad['titulo'];
$description = 'Administrar imágenes de la propiedad';
$pageTitle = 'Gestión de Imágenes';
$currentPage = 'propiedades';

// Incluir el layout de administrador
include __DIR__ . '/../layouts/admin.php';
?>

<!-- CSS específico para gestión de imágenes -->
<style>
.image-management-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.property-info {
    background: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.property-info h2 {
    color: #333;
    margin-bottom: 10px;
}

.property-info p {
    color: #666;
    margin: 5px 0;
}

.upload-section {
    background: white;
    border-radius: 10px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.upload-form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: #333;
}

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 12px;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    outline: none;
    border-color: #667eea;
}

.file-upload-area {
    border: 2px dashed #ccc;
    border-radius: 10px;
    padding: 40px;
    text-align: center;
    background: #f9f9f9;
    transition: all 0.3s ease;
    cursor: pointer;
}

.file-upload-area:hover {
    border-color: #667eea;
    background: #f0f4ff;
}

.file-upload-area.dragover {
    border-color: #667eea;
    background: #e8f0fe;
}

.file-upload-area i {
    font-size: 3rem;
    color: #ccc;
    margin-bottom: 15px;
}

.file-upload-area p {
    color: #666;
    margin: 10px 0;
}

.file-upload-area input[type="file"] {
    display: none;
}

.images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 30px;
}

.image-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.image-card:hover {
    transform: translateY(-5px);
}

.image-preview {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-badges {
    position: absolute;
    top: 10px;
    left: 10px;
    display: flex;
    gap: 5px;
}

.badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: bold;
}

.badge-primary {
    background: #667eea;
    color: white;
}

.badge-success {
    background: #28a745;
    color: white;
}

.image-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    gap: 5px;
}

.btn-icon {
    width: 35px;
    height: 35px;
    border: none;
    border-radius: 50%;
    background: rgba(0,0,0,0.7);
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s ease;
}

.btn-icon:hover {
    background: rgba(0,0,0,0.9);
}

.image-info {
    padding: 15px;
}

.image-info h4 {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 1rem;
}

.image-info p {
    margin: 5px 0;
    color: #666;
    font-size: 0.9rem;
}

.no-images {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.no-images i {
    font-size: 4rem;
    color: #ccc;
    margin-bottom: 20px;
}

.btn {
    padding: 12px 24px;
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

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
}

.btn-success {
    background: #28a745;
    color: white;
}

.btn-success:hover {
    background: #218838;
}

@media (max-width: 768px) {
    .upload-form {
        grid-template-columns: 1fr;
    }
    
    .images-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }
}
</style>

<!-- Contenido principal -->
<div class="image-management-container">
    <!-- Información de la propiedad -->
    <div class="property-info">
        <h2><i class="fas fa-home"></i> <?php echo htmlspecialchars($propiedad['titulo']); ?></h2>
        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($propiedad['direccion']); ?></p>
        <p><strong>Tipo:</strong> <?php echo ucfirst($propiedad['tipo']); ?> - <?php echo ucfirst($propiedad['tipo_propiedad']); ?></p>
        <p><strong>Precio:</strong> $<?php echo number_format($propiedad['precio']); ?></p>
    </div>
    
    <!-- Sección de subida -->
    <div class="upload-section">
        <h3><i class="fas fa-cloud-upload-alt"></i> Subir Nuevas Imágenes</h3>
        
        <form method="POST" action="<?php echo BASE_URL; ?>admin/subir-imagenes/<?php echo $propiedad['id_propiedad']; ?>" enctype="multipart/form-data">
            <div class="upload-form">
                <div class="form-group">
                    <label for="titulo">Título de las imágenes</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Ej: Fachada principal">
                </div>
                
                <div class="form-group">
                    <label for="orden">Orden de visualización</label>
                    <input type="number" id="orden" name="orden" value="0" min="0">
                </div>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3" placeholder="Descripción opcional de las imágenes..."></textarea>
            </div>
            
            <div class="file-upload-area" onclick="document.getElementById('imagenes').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <h4>Seleccionar Imágenes</h4>
                <p>Haz clic aquí o arrastra las imágenes</p>
                <p><small>Formatos permitidos: JPG, PNG, GIF, WEBP (máximo 5MB cada una)</small></p>
                <input type="file" id="imagenes" name="imagenes[]" multiple accept="image/*" required>
            </div>
            
            <div class="form-group">
                <label class="checkbox-group">
                    <input type="checkbox" name="es_principal" value="1">
                    <span>Marcar como imagen principal</span>
                </label>
            </div>
            
            <div style="display: flex; gap: 15px; justify-content: flex-end; margin-top: 20px;">
                <a href="<?php echo BASE_URL; ?>admin/propiedades" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Volver a Propiedades
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload"></i>
                    Subir Imágenes
                </button>
            </div>
        </form>
    </div>
    
    <!-- Galería de imágenes -->
    <div class="images-section">
        <h3><i class="fas fa-images"></i> Imágenes de la Propiedad</h3>
        
        <?php if (!empty($imagenes)): ?>
            <div class="images-grid" id="imagesGrid">
                <?php foreach ($imagenes as $imagen): ?>
                    <div class="image-card" data-image-id="<?php echo $imagen['id_imagen']; ?>">
                        <div class="image-preview">
                            <img src="<?php echo BASE_URL; ?>public/img/<?php echo $imagen['url_imagen']; ?>" 
                                 alt="<?php echo htmlspecialchars($imagen['titulo']); ?>">
                            
                            <div class="image-badges">
                                <?php if ($imagen['es_principal']): ?>
                                    <span class="badge badge-primary">Principal</span>
                                <?php endif; ?>
                                <span class="badge badge-success">Orden: <?php echo $imagen['orden']; ?></span>
                            </div>
                            
                            <div class="image-actions">
                                <button class="btn-icon" title="Marcar como principal" 
                                        onclick="setMainImage(<?php echo $imagen['id_imagen']; ?>)">
                                    <i class="fas fa-star"></i>
                                </button>
                                <button class="btn-icon" title="Eliminar" 
                                        onclick="deleteImage(<?php echo $imagen['id_imagen']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="image-info">
                            <h4><?php echo htmlspecialchars($imagen['titulo']); ?></h4>
                            <?php if ($imagen['descripcion']): ?>
                                <p><?php echo htmlspecialchars($imagen['descripcion']); ?></p>
                            <?php endif; ?>
                            <p><small>Subida: <?php echo date('d/m/Y H:i', strtotime($imagen['fecha_subida'])); ?></small></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-images">
                <i class="fas fa-image"></i>
                <h3>No hay imágenes</h3>
                <p>Esta propiedad aún no tiene imágenes. Sube algunas para mostrar la propiedad.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar mensajes
    <?php if (isset($_SESSION['success_message'])): ?>
        showMessage('<?php echo $_SESSION['success_message']; ?>', 'success');
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        showMessage('<?php echo $_SESSION['error_message']; ?>', 'error');
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['warning_message'])): ?>
        showMessage('<?php echo $_SESSION['warning_message']; ?>', 'warning');
        <?php unset($_SESSION['warning_message']); ?>
    <?php endif; ?>
    
    // Configurar drag and drop
    const uploadArea = document.querySelector('.file-upload-area');
    const fileInput = document.getElementById('imagenes');
    
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        fileInput.files = files;
        
        // Mostrar información de archivos seleccionados
        showSelectedFiles(files);
    });
    
    fileInput.addEventListener('change', function() {
        showSelectedFiles(this.files);
    });
});

function showSelectedFiles(files) {
    const uploadArea = document.querySelector('.file-upload-area');
    
    if (files.length > 0) {
        uploadArea.innerHTML = `
            <i class="fas fa-check-circle" style="color: #28a745;"></i>
            <h4>${files.length} archivo(s) seleccionado(s)</h4>
            <p>Listo para subir</p>
            <p><small>Haz clic para cambiar los archivos</small></p>
        `;
    }
}

function setMainImage(imageId) {
    if (confirm('¿Marcar esta imagen como principal?')) {
        window.location.href = '<?php echo BASE_URL; ?>admin/marcar-principal/' + imageId;
    }
}

function deleteImage(imageId) {
    if (confirm('¿Estás seguro de que deseas eliminar esta imagen? Esta acción no se puede deshacer.')) {
        window.location.href = '<?php echo BASE_URL; ?>admin/eliminar-imagen/' + imageId;
    }
}

function showMessage(message, type) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `alert alert-${type}`;
    messageDiv.textContent = message;
    messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 5px;
        color: white;
        font-weight: bold;
        z-index: 1000;
        animation: slideIn 0.3s ease-out;
    `;
    
    switch(type) {
        case 'success':
            messageDiv.style.backgroundColor = '#28a745';
            break;
        case 'error':
            messageDiv.style.backgroundColor = '#dc3545';
            break;
        case 'warning':
            messageDiv.style.backgroundColor = '#ffc107';
            messageDiv.style.color = '#333';
            break;
    }
    
    document.body.appendChild(messageDiv);
    
    setTimeout(() => {
        messageDiv.remove();
    }, 5000);
}

// Agregar estilos CSS para la animación
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }
    
    .checkbox-group input[type="checkbox"] {
        width: auto;
        margin: 0;
    }
`;
document.head.appendChild(style);
</script>
