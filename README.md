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
- **Base de Datos:** MySQL 5.7+
- **Frontend:** HTML5, CSS3
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

### Instalación desde ZIP (Recomendado)

Si descargaste el proyecto como archivo ZIP desde GitHub:

1. **Extraer el archivo ZIP:**
   - Extrae el contenido en tu directorio web (ej: `htdocs`, `www`, etc.)
   - **Importante:** Renombra la carpeta para evitar espacios (ej: `InmuYa-main` → `InmuYa`)

2. **Configurar la base de datos:**
   ```sql
   -- Crear la base de datos
   CREATE DATABASE propertypro_bd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   
   -- Importar la estructura
   -- Usa el archivo propertypro_bd.sql incluido en el proyecto
   ```

3. **Configurar credenciales de base de datos:**
   - Edita `config/conexion.php` con tus credenciales de MySQL
   - Por defecto usa: host=localhost, user=root, password='', database=propertypro_bd

4. **Configuración automática de rutas:**
   - El sistema detecta automáticamente la URL base
   - No necesitas modificar archivos de configuración manualmente
   - Las rutas se ajustan según el entorno (desarrollo/producción)

### Instalación desde Git

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/Yasmingt/InmuYa.git
   cd InmuYa
   ```

2. **Seguir los pasos 2-4 de la instalación desde ZIP**

### Verificación de Instalación

1. **Acceder al sistema:**
   - Abre tu navegador
   - Ve a `http://localhost/tu-carpeta-del-proyecto/`
   - Deberías ver la página principal de InmuYa

2. **Probar funcionalidades:**
   - Registro de usuario
   - Inicio de sesión
   - Panel de administración

### Solución de Problemas Comunes

**❌ Los estilos CSS no se cargan:**
- Verifica que la carpeta `public/css/` existe
- Asegúrate de que el servidor web puede leer archivos CSS
- Revisa la consola del navegador para errores 404

**❌ Las imágenes no se muestran:**
- Verifica que la carpeta `public/img/` existe
- Comprueba permisos de lectura en la carpeta de imágenes

**❌ Error de conexión a base de datos:**
- Verifica credenciales en `config/conexion.php`
- Asegúrate de que MySQL está ejecutándose
- Confirma que la base de datos `propertypro_bd` existe

**❌ Rutas no funcionan:**
- El sistema detecta automáticamente las rutas
- Si persiste el problema, verifica que `mod_rewrite` está habilitado en Apache

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