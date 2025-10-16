<?php
/**
 * Crear Nueva Propiedad - Panel de Administración
 * InmuYa - Sistema de gestión inmobiliaria
 */

// Definir variables para el layout
$title = 'Crear Nueva Propiedad';
$description = 'Agregar una nueva propiedad al sistema';
$pageTitle = 'Crear Nueva Propiedad';
$currentPage = 'propiedades';

// Incluir el layout de administrador
include __DIR__ . '/../layouts/admin.php';
?>

<!-- CSS específico para formularios -->
<style>
.form-container {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.form-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    text-align: center;
}

.form-header h2 {
    margin: 0;
    font-size: 1.5rem;
}

.form-body {
    padding: 30px;
}

.form-row {
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
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #667eea;
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

.checkbox-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.checkbox-group input[type="checkbox"] {
    width: auto;
    margin: 0;
}

.form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e1e5e9;
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

.required {
    color: #dc3545;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>

<!-- Contenido del formulario -->
<div class="form-container">
    <div class="form-header">
        <h2><i class="fas fa-plus"></i> Crear Nueva Propiedad</h2>
        <p>Complete todos los campos requeridos para agregar la propiedad</p>
    </div>
    
    <div class="form-body">
        <form method="POST" action="<?php echo BASE_URL; ?>admin/crear-propiedad">
            <!-- Información básica -->
            <div class="form-row">
                <div class="form-group">
                    <label for="titulo">Título <span class="required">*</span></label>
                    <input type="text" id="titulo" name="titulo" required 
                           placeholder="Ej: Casa moderna en zona residencial">
                </div>
                
                <div class="form-group">
                    <label for="tipo">Tipo de Transacción <span class="required">*</span></label>
                    <select id="tipo" name="tipo" required>
                        <option value="">Seleccionar tipo</option>
                        <option value="venta">Venta</option>
                        <option value="arriendo">Arriendo</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="tipo_propiedad">Tipo de Propiedad <span class="required">*</span></label>
                    <select id="tipo_propiedad" name="tipo_propiedad" required>
                        <option value="">Seleccionar tipo</option>
                        <option value="casa">Casa</option>
                        <option value="apartamento">Apartamento</option>
                        <option value="local">Local Comercial</option>
                        <option value="oficina">Oficina</option>
                        <option value="bodega">Bodega</option>
                        <option value="terreno">Terreno</option>
                        <option value="finca">Finca</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="precio">Precio <span class="required">*</span></label>
                    <input type="number" id="precio" name="precio" required 
                           placeholder="0" min="0" step="0.01">
                </div>
            </div>
            
            <!-- Descripción -->
            <div class="form-group">
                <label for="descripcion">Descripción <span class="required">*</span></label>
                <textarea id="descripcion" name="descripcion" required 
                          placeholder="Describa las características principales de la propiedad..."></textarea>
            </div>
            
            <!-- Características físicas -->
            <div class="form-row">
                <div class="form-group">
                    <label for="area">Área (m²) <span class="required">*</span></label>
                    <input type="number" id="area" name="area" required 
                           placeholder="0" min="0" step="0.01">
                </div>
                
                <div class="form-group">
                    <label for="habitaciones">Habitaciones <span class="required">*</span></label>
                    <input type="number" id="habitaciones" name="habitaciones" required 
                           placeholder="0" min="0">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="banos">Baños <span class="required">*</span></label>
                    <input type="number" id="banos" name="banos" required 
                           placeholder="0" min="0">
                </div>
                
                <div class="form-group">
                    <label for="direccion">Dirección <span class="required">*</span></label>
                    <input type="text" id="direccion" name="direccion" required 
                           placeholder="Ej: Calle 123 #45-67">
                </div>
            </div>
            
            <!-- Ubicación -->
            <div class="form-row">
                <div class="form-group">
                    <label for="id_ciudad">Ciudad</label>
                    <select id="id_ciudad" name="id_ciudad">
                        <option value="">Seleccionar ciudad</option>
                        <!-- Aquí se cargarían las ciudades desde la base de datos -->
                        <option value="1">Bogotá</option>
                        <option value="2">Medellín</option>
                        <option value="3">Cali</option>
                        <option value="4">Barranquilla</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="id_barrio">Barrio</label>
                    <select id="id_barrio" name="id_barrio">
                        <option value="">Seleccionar barrio</option>
                        <!-- Aquí se cargarían los barrios según la ciudad seleccionada -->
                    </select>
                </div>
            </div>
            
            <!-- Opciones adicionales -->
            <div class="form-group">
                <label>Características adicionales</label>
                <div class="checkbox-group">
                    <input type="checkbox" id="parqueadero" name="parqueadero" value="1">
                    <label for="parqueadero">Parqueadero</label>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="destacado" name="destacado" value="1">
                    <label for="destacado">Propiedad destacada</label>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="precio_negociable" name="precio_negociable" value="1" checked>
                    <label for="precio_negociable">Precio negociable</label>
                </div>
            </div>
            
            <!-- Botones de acción -->
            <div class="form-actions">
                <a href="<?php echo BASE_URL; ?>admin/propiedades" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Crear Propiedad
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar mensajes de error si existen
    <?php if (isset($_SESSION['error_message'])): ?>
        showMessage('<?php echo $_SESSION['error_message']; ?>', 'error');
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    // Formatear precio mientras se escribe
    const precioInput = document.getElementById('precio');
    precioInput.addEventListener('input', function() {
        let value = this.value.replace(/[^\d]/g, '');
        if (value) {
            this.value = parseInt(value).toLocaleString();
        }
    });
    
    // Cargar barrios según la ciudad seleccionada
    const ciudadSelect = document.getElementById('id_ciudad');
    const barrioSelect = document.getElementById('id_barrio');
    
    ciudadSelect.addEventListener('change', function() {
        const ciudadId = this.value;
        barrioSelect.innerHTML = '<option value="">Seleccionar barrio</option>';
        
        if (ciudadId) {
            // Aquí se haría una petición AJAX para cargar los barrios
            // Por ahora agregamos algunos ejemplos
            const barrios = {
                '1': [
                    {id: 1, nombre: 'Chapinero'},
                    {id: 2, nombre: 'Usaquén'},
                    {id: 3, nombre: 'Santa Fe'},
                    {id: 4, nombre: 'La Candelaria'}
                ],
                '2': [
                    {id: 5, nombre: 'El Poblado'},
                    {id: 6, nombre: 'Laureles'},
                    {id: 7, nombre: 'Envigado'},
                    {id: 8, nombre: 'Sabaneta'}
                ]
            };
            
            if (barrios[ciudadId]) {
                barrios[ciudadId].forEach(barrio => {
                    const option = document.createElement('option');
                    option.value = barrio.id;
                    option.textContent = barrio.nombre;
                    barrioSelect.appendChild(option);
                });
            }
        }
    });
});

// Función para mostrar mensajes
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
    
    if (type === 'success') {
        messageDiv.style.backgroundColor = '#28a745';
    } else if (type === 'error') {
        messageDiv.style.backgroundColor = '#dc3545';
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
`;
document.head.appendChild(style);
</script>
