/**
 * Sistema de Favoritos
 * InmuYa - Sistema de gestión inmobiliaria
 * 
 * Maneja la funcionalidad de favoritos en el frontend
 */

class FavoritosManager {
    constructor() {
        this.baseUrl = window.location.origin + window.location.pathname.replace(/\/[^\/]*$/, '') + '/';
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.loadFavoriteStates();
    }
    
    bindEvents() {
        // Manejar clics en botones de favoritos
        document.addEventListener('click', (e) => {
            if (e.target.closest('.favorite-btn')) {
                e.preventDefault();
                this.handleFavoriteClick(e.target.closest('.favorite-btn'));
            }
        });
    }
    
    async loadFavoriteStates() {
        // Cargar estados de favoritos para todas las propiedades visibles
        const favoriteButtons = document.querySelectorAll('.favorite-btn[data-property-id]');
        
        if (favoriteButtons.length === 0) return;
        
        const propertyIds = Array.from(favoriteButtons).map(btn => btn.dataset.propertyId);
        
        try {
            const promises = propertyIds.map(id => this.checkFavoriteStatus(id));
            const results = await Promise.all(promises);
            
            results.forEach((result, index) => {
                if (result.success) {
                    this.updateFavoriteButton(favoriteButtons[index], result.es_favorito);
                }
            });
        } catch (error) {
            console.error('Error loading favorite states:', error);
        }
    }
    
    async checkFavoriteStatus(propertyId) {
        try {
            const response = await fetch(`${this.baseUrl}favoritos/verificar?id_propiedad=${propertyId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('Error checking favorite status:', error);
            return { success: false, es_favorito: false };
        }
    }
    
    async handleFavoriteClick(button) {
        const propertyId = button.dataset.propertyId;
        
        if (!propertyId) {
            console.error('No property ID found');
            return;
        }
        
        // Verificar autenticación primero
        const authCheck = await this.checkFavoriteStatus(propertyId);
        
        if (!authCheck.success && authCheck.message === 'Usuario no autenticado') {
            this.showLoginPrompt();
            return;
        }
        
        // Mostrar loading
        this.setButtonLoading(button, true);
        
        try {
            const response = await fetch(`${this.baseUrl}favoritos/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    id_propiedad: propertyId
                })
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            
            if (result.success) {
                this.updateFavoriteButton(button, result.es_favorito);
                this.showNotification(result.message, 'success');
                
                // Actualizar contador si existe
                this.updateFavoriteCounter();
                
            } else {
                this.showNotification(result.message || 'Error al actualizar favoritos', 'error');
            }
            
        } catch (error) {
            console.error('Error toggling favorite:', error);
            this.showNotification('Error al actualizar favoritos', 'error');
        } finally {
            this.setButtonLoading(button, false);
        }
    }
    
    updateFavoriteButton(button, isFavorite) {
        const icon = button.querySelector('i');
        const isActive = button.classList.contains('active');
        
        if (isFavorite && !isActive) {
            button.classList.add('active');
            if (icon) icon.className = 'fas fa-heart';
            button.title = 'Quitar de favoritos';
        } else if (!isFavorite && isActive) {
            button.classList.remove('active');
            if (icon) icon.className = 'far fa-heart';
            button.title = 'Agregar a favoritos';
        }
    }
    
    setButtonLoading(button, loading) {
        const icon = button.querySelector('i');
        
        if (loading) {
            button.disabled = true;
            if (icon) {
                icon.className = 'fas fa-spinner fa-spin';
            }
        } else {
            button.disabled = false;
            // Restaurar el icono correcto
            const isActive = button.classList.contains('active');
            if (icon) {
                icon.className = isActive ? 'fas fa-heart' : 'far fa-heart';
            }
        }
    }
    
    showLoginPrompt() {
        const message = 'Debes iniciar sesión para usar favoritos';
        
        if (confirm(message + '\n\n¿Deseas ir a la página de login?')) {
            window.location.href = `${this.baseUrl}auth/login`;
        }
    }
    
    showNotification(message, type = 'info') {
        // Crear notificación
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        
        // Estilos para la notificación
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#d4edda' : type === 'error' ? '#f8d7da' : '#d1ecf1'};
            color: ${type === 'success' ? '#155724' : type === 'error' ? '#721c24' : '#0c5460'};
            border: 1px solid ${type === 'success' ? '#c3e6cb' : type === 'error' ? '#f5c6cb' : '#bee5eb'};
            border-radius: 5px;
            padding: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 10000;
            max-width: 400px;
            animation: slideInRight 0.3s ease;
        `;
        
        // Agregar al DOM
        document.body.appendChild(notification);
        
        // Remover después de 3 segundos
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
    
    updateFavoriteCounter() {
        // Actualizar contador de favoritos si existe
        const counter = document.querySelector('.favorites-counter');
        if (counter) {
            // Hacer una petición para obtener el nuevo conteo
            fetch(`${this.baseUrl}favoritos/verificar`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.count !== undefined) {
                        counter.textContent = data.count;
                    }
                })
                .catch(error => console.error('Error updating counter:', error));
        }
    }
}

// CSS para animaciones
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .favorite-btn {
        transition: all 0.3s ease;
    }
    
    .favorite-btn:hover {
        transform: scale(1.1);
    }
    
    .favorite-btn.active i {
        color: #e74c3c;
    }
    
    .favorite-btn:not(.active) i {
        color: #666;
    }
`;
document.head.appendChild(style);

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    new FavoritosManager();
});

