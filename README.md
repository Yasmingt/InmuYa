# InmuYa - Sistema de Gestión Inmobiliaria

## 📋 Descripción

InmuYa es un sistema web desarrollado en PHP para la gestión inmobiliaria, que permite a usuarios registrarse como propietarios o clientes para gestionar propiedades, contactos y transacciones inmobiliarias.

## 🚀 Características Principales

- **Sistema de Autenticación** completo (login, registro, recuperación de contraseña)
- **Gestión de Usuarios** con diferentes tipos (cliente, propietario, admin)
- **Panel de Administración** para gestión del sistema
- **Sistema de Contactos** para comunicación
- **Interfaz Responsiva** y moderna
- **Base de Datos Normalizada** con relaciones optimizadas

## 🛠️ Tecnologías Utilizadas

- **Backend:** PHP 7.4+
- **Base de Datos:** MySQL 5.7+ / MariaDB 10.2+
- **Frontend:** HTML5, CSS3, JavaScript
- **Iconos:** Font Awesome

## 📁 Estructura del Proyecto

```
InmuYa/
├── app/
│   ├── controllers/          # Controladores MVC
│   │   ├── AdminController.php
│   │   ├── AuthController.php
│   │   └── ContactController.php
│   ├── models/              # Modelos de datos
│   │   ├── ContactModel.php
│   │   └── UserModel.php
│   └── views/               # Vistas del sistema
│       ├── admin/           # Vistas de administración
│       ├── auth/            # Vistas de autenticación
│       ├── home/            # Vistas principales
│       ├── layouts/         # Layouts base
│       └── user/            # Vistas de usuario
├── config/                  # Configuración
│   ├── conexion.php         # Conexión a base de datos
│   ├── config.php           # Configuración general
│   └── routes.php           # Rutas del sistema
├── public/                  # Archivos públicos
│   ├── css/                 # Estilos CSS
│   ├── img/                 # Imágenes
│   └── js/                  # JavaScript
└── index.php               # Punto de entrada principal
```

## 🗄️ Base de Datos

### Tablas Principales

- **`usuarios`** - Información de usuarios del sistema
- **`tipodocumento`** - Tipos de documento de identidad
- **`contactos`** - Mensajes y consultas de contacto

## ⚙️ Instalación

### Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 5.7+ o MariaDB 10.2+
- Servidor web (Apache/Nginx)
- Extensiones PHP: PDO, PDO_MySQL

### Pasos de Instalación

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/tu-usuario/InmuYa-Sistema-Inmobiliario.git
   cd InmuYa-Sistema-Inmobiliario
   ```

2. **Configurar la base de datos:**
   - Crear base de datos MySQL
   - Importar estructura inicial desde `propertypro_bd.sql`
   - Configurar credenciales en `config/conexion.php`

3. **Configurar servidor web:**
   - Apuntar document root al directorio del proyecto
   - Configurar URL base en `config/config.php`

## 🚀 Uso del Sistema

### Tipos de Usuario

- **Cliente:** Busca propiedades para arrendar o comprar
- **Propietario:** Ofrece propiedades para arrendar o vender
- **Administrador:** Gestiona usuarios y configuración del sistema

### Funcionalidades

- Registro e inicio de sesión
- Gestión de perfil de usuario
- Panel de administración
- Sistema de contactos
- Gestión de propiedades (en desarrollo)

## 🔧 Desarrollo

### Estructura MVC

El proyecto sigue el patrón Modelo-Vista-Controlador:

- **Modelos:** Lógica de datos y acceso a BD
- **Vistas:** Interfaz de usuario (HTML/CSS)
- **Controladores:** Lógica de negocio y coordinación

## 📝 Contribuir

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT.

## 👥 Autor

- **Yasmin** - *Desarrollo inicial* - [Yasmingt](https://github.com/Yasmingt)

## 📞 Contacto

- **GitHub:** [Yasmingt](https://github.com/Yasmingt)
- **Proyecto:** [InmuYa](https://github.com/Yasmingt/InmuYa-Sistema-Inmobiliario)

---

**Desarrollado con ❤️ para la gestión inmobiliaria**