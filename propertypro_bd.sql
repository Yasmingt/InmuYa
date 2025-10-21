-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-10-2025 a las 16:57:10
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `propertypro_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `barrios`
--

CREATE TABLE `barrios` (
  `id_barrio` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_ciudad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `barrios`
--

INSERT INTO `barrios` (`id_barrio`, `nombre`, `id_ciudad`) VALUES
(5, 'Poblado', 2),
(6, 'Laureles', 2),
(7, 'Envigado', 2),
(8, 'Sabaneta', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `id_ciudad` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`id_ciudad`, `nombre`) VALUES
(2, 'Medellín');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactar`
--

CREATE TABLE `contactar` (
  `id` int(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `asunto` varchar(100) NOT NULL,
  `mensaje` text NOT NULL,
  `estado` enum('nuevo','leido','respondido','cerrado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contactar`
--

INSERT INTO `contactar` (`id`, `nombre`, `email`, `asunto`, `mensaje`, `estado`) VALUES
(3, 'jmji', 'camiloez@gmail', 'dreyt6', 'y6uh', 'leido'),
(4, 'mayerly acevedo', 'acevedomaye@gmail.com', 'wrfedgvre', 'jhnaj jhnsiw c', 'leido'),
(5, 'daniel ramirez', 'daniel@gmail.com', 'fedcws', 'edfr4cdf', 'cerrado'),
(7, 'Alejandra', 'alejandra.chancit@gmail.com', 'prueba', 'xxc', 'nuevo'),
(9, 'Alejandra Chanci', 'felipevalencia@gmail.com', 'prueba', '4562', 'nuevo'),
(10, 'Usuario de Prueba', 'prueba@ejemplo.com', 'Prueba del sistema', 'Este es un mensaje de prueba para verificar que el sistema funciona correctamente.', 'nuevo'),
(11, 'maria', 'felipevalencia@gmail.com', 'prueba', '12345', 'nuevo'),
(12, 'Alejandra', 'desarrollo.back@grupocarrera.com.co', 'Compra', 'prueba', 'nuevo'),
(15, 'Alejandra', 'desarrollo.back@grupocarrera.com.co', 'Compra', '65323', 'nuevo'),
(16, 'Alejandra', 'gladistpeque@gmail.com', 'Compra', 'prueba', 'nuevo'),
(17, 'Alejandra', 'alejandra.chancit@gmail.com', 'Compra', 'pruaba 2', 'nuevo'),
(18, 'Alejandra', 'gladistpeque@gmail.com', 'Compra', 'prueba3', 'nuevo'),
(19, 'Felipe', 'alejandra.chancit@gmail.com', 'Compra', 'dfgc', 'nuevo'),
(21, 'Felipe', 'gladistpeque@gmail.com', 'Compra', 'prueba final index', 'nuevo'),
(22, 'Felipe', 'alejandra.chancit@gmail.com', 'Compra', '4215', 'nuevo'),
(24, 'Alejandra', 'gladistpeque@gmail.com', 'Compra', '5602', 'nuevo'),
(25, 'Alejandra', 'gladistpeque@gmail.com', 'Compra', '5602', 'nuevo'),
(26, 'Juan Pérez', 'juan@ejemplo.com', 'Consulta sobre propiedad', 'Hola, me interesa saber más sobre las propiedades disponibles.', 'nuevo'),
(27, 'Test Usuario', 'test@ejemplo.com', 'Prueba de diagnóstico', 'Este es un mensaje de prueba para verificar que el sistema funciona correctamente.', 'nuevo'),
(28, 'Juan Pérez', 'juan@ejemplo.com', 'Consulta sobre propiedad', 'Hola, me interesa saber más sobre las propiedades disponibles en la zona.', 'cerrado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id_imagen` int(11) NOT NULL,
  `id_propiedad` int(11) NOT NULL,
  `url_imagen` varchar(255) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `orden` int(11) DEFAULT 0,
  `es_principal` tinyint(1) DEFAULT 0,
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id_imagen`, `id_propiedad`, `url_imagen`, `titulo`, `descripcion`, `orden`, `es_principal`, `fecha_subida`, `activo`) VALUES
(41, 6, 'propiedades/propiedad_6/anuncio6.jpg', 'Imagen de Oficina ejecutiva en Laureles', 'Imagen migrada automáticamente', 0, 1, '2025-10-16 14:25:38', 1),
(42, 6, 'propiedades/propiedad_6/propiedad_6_1.jpg', 'Imagen de Oficina ejecutiva en Laureles', 'Imagen migrada automáticamente', 1, 0, '2025-10-16 14:25:38', 1),
(43, 6, 'propiedades/propiedad_6/propiedad_6_2.jpg', 'Imagen de Oficina ejecutiva en Laureles', 'Imagen migrada automáticamente', 2, 0, '2025-10-16 14:25:38', 1),
(44, 6, 'propiedades/propiedad_6/propiedad_6_3.jpg', 'Imagen de Oficina ejecutiva en Laureles', 'Imagen migrada automáticamente', 3, 0, '2025-10-16 14:25:38', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedades`
--

CREATE TABLE `propiedades` (
  `id_propiedad` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `tipo` enum('arriendo','venta') NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `area` decimal(10,2) NOT NULL,
  `habitaciones` int(11) NOT NULL,
  `banos` int(11) NOT NULL,
  `parqueadero` tinyint(1) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `id_ciudad` int(11) DEFAULT NULL,
  `id_barrio` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('disponible','vendido','arrendado','reservado','inactivo') DEFAULT 'disponible',
  `tipo_propiedad` enum('casa','apartamento','local','oficina','bodega','terreno','finca') NOT NULL,
  `destacado` tinyint(1) DEFAULT 0,
  `piso` int(11) DEFAULT NULL,
  `ascensor` tinyint(1) DEFAULT 0,
  `balcon` tinyint(1) DEFAULT 0,
  `terraza` tinyint(1) DEFAULT 0,
  `jardin` tinyint(1) DEFAULT 0,
  `piscina` tinyint(1) DEFAULT 0,
  `gimnasio` tinyint(1) DEFAULT 0,
  `seguridad_24h` tinyint(1) DEFAULT 0,
  `mascotas_permitidas` tinyint(1) DEFAULT 0,
  `precio_negociable` tinyint(1) DEFAULT 1,
  `incluye_administracion` tinyint(1) DEFAULT 0,
  `valor_administracion` decimal(10,2) DEFAULT NULL,
  `incluye_servicios` tinyint(1) DEFAULT 0,
  `telefono_contacto` varchar(20) DEFAULT NULL,
  `email_contacto` varchar(100) DEFAULT NULL,
  `nombre_contacto` varchar(100) DEFAULT NULL,
  `mostrar_telefono` tinyint(1) DEFAULT 1,
  `mostrar_email` tinyint(1) DEFAULT 1,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `propiedades`
--

INSERT INTO `propiedades` (`id_propiedad`, `titulo`, `descripcion`, `tipo`, `precio`, `area`, `habitaciones`, `banos`, `parqueadero`, `direccion`, `id_ciudad`, `id_barrio`, `id_usuario`, `fecha_publicacion`, `estado`, `tipo_propiedad`, `destacado`, `piso`, `ascensor`, `balcon`, `terraza`, `jardin`, `piscina`, `gimnasio`, `seguridad_24h`, `mascotas_permitidas`, `precio_negociable`, `incluye_administracion`, `valor_administracion`, `incluye_servicios`, `telefono_contacto`, `email_contacto`, `nombre_contacto`, `mostrar_telefono`, `mostrar_email`, `fecha_actualizacion`) VALUES
(6, 'Oficina ejecutiva ', 'Oficina completamente equipada en edificio corporativo. Ideal para empresas que buscan una ubicación estratégica. Incluye recepción y sala de juntas.', 'arriendo', 3200000, 120.00, 0, 2, 1, 'Carrera 70 #44-23', 2, 6, 3, '2025-10-14 15:51:14', '', 'oficina', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0.00, 0, '3156607670', 'felipevaleciaarcila@gmail.com', 'felpe', 1, 1, '2025-10-21 13:57:49'),
(20, 'Aparta estudio amoblado ', 'Aparta estudio amoblado unifamiliar, habitable de inmediato.', 'arriendo', 1100000, 32.00, 1, 1, 1, 'cll30a 80-12', 2, 6, 2, '2025-10-21 11:45:24', 'disponible', 'apartamento', 1, 3, 1, 0, 0, 0, 0, 0, 1, 1, 0, 0, 200000.00, 1, '3137155912', 'alejandra.chancit@gmail.com', '0', 1, 1, '2025-10-21 11:45:24'),
(21, 'Casa estrato 4', 'Casa estrato cuatro con excelente ambiente para personas que les gusta la tranquilidad y calma, espacios comunes para niños y mascotas', 'venta', 400000000, 70.00, 3, 2, 1, 'calle 33#83', 2, 6, 2, '2025-10-21 11:53:36', 'disponible', 'casa', 1, 3, 0, 1, 0, 1, 0, 0, 1, 1, 1, 0, 200000.00, 0, '3137155912', 'alejandra.chancit@gmail.com', '0', 1, 1, '2025-10-21 13:17:20'),
(26, 'Casa moderna en El Poblado', 'Hermosa casa moderna con excelente ubicación en El Poblado', 'venta', 850000000, 180.50, 4, 3, 1, 'Carrera 43A #15-25', 2, 5, 2, '2025-10-21 12:36:10', 'disponible', 'casa', 0, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 250000.00, 1, '3001234567', 'ventas@inmobiliaria.com', 'María González', 1, 1, '2025-10-21 13:43:35'),
(27, 'Apartamento en Laureles', 'Apartamento cómodo en zona residencial de Laureles', 'arriendo', 2500000, 85.00, 2, 2, 1, 'Calle 70 #45-23', 2, 6, 3, '2025-10-21 12:36:10', 'disponible', 'apartamento', 0, 3, 1, 1, 0, 0, 0, 1, 1, 0, 0, 1, 180000.00, 0, '3009876543', 'arriendos@inmobiliaria.com', 'Carlos López', 1, 1, '2025-10-21 12:41:08'),
(28, 'Oficina ejecutiva en Centro', 'Oficina moderna en el centro de la ciudad', 'venta', 450000000, 120.00, 0, 2, 2, 'Carrera 50 #25-15', 2, 6, 4, '2025-10-21 12:36:10', 'disponible', 'oficina', 0, 8, 1, 0, 0, 0, 0, 1, 1, 0, 1, 1, 320000.00, 1, '3005555555', 'oficinas@inmobiliaria.com', 'Ana Martínez', 1, 1, '2025-10-21 12:41:08'),
(29, 'Casa en Envigado', 'Casa familiar en zona tranquila de Envigado', 'venta', 320000000, 150.00, 3, 2, 1, 'Calle 48 Sur #25-30', 2, 7, 5, '2025-10-21 12:36:10', 'disponible', 'casa', 0, 1, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0.00, 0, '3007777777', 'casas@inmobiliaria.com', 'Roberto Silva', 1, 1, '2025-10-21 14:27:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodocumento`
--

CREATE TABLE `tipodocumento` (
  `id_tipodocumento` int(11) NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipodocumento`
--

INSERT INTO `tipodocumento` (`id_tipodocumento`, `descripcion`) VALUES
(9, 'Cédula de Ciudadanía'),
(14, 'Cédula de Extranjería'),
(15, 'Pasaporte'),
(16, 'PPT'),
(17, 'PEP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `tipodocumento` int(11) NOT NULL,
  `numerodocumento` varchar(30) NOT NULL,
  `fechadenacimiento` date NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `tipo_usuario` enum('cliente','propietario','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `telefono`, `tipodocumento`, `numerodocumento`, `fechadenacimiento`, `contrasena`, `tipo_usuario`) VALUES
(2, 'Alejandra Torres', 'alejandra.chancit@gmail.com', '3137155912', 9, '1001398338', '2001-03-18', '$2y$10$vhC5XVyMpLlRr/xZL5GDtOWqKNIIHFde1RNLUTRLzrexsRttNb8Fy', 'admin'),
(3, 'Felipe Valencia', 'felipevalenciaarcila@gmail.com', '3156607670', 9, '1128271817', '1987-10-04', '$2y$10$0WkOKgkmR7bucsK7VKZg6e4WBSYzbAH5DqQDh8AK/ioGnqZtYojdW', 'propietario'),
(4, 'yasmin Guerra', 'yasminGuerra@gmail.com', '3195515809', 9, '1028141355', '2009-01-07', '$2y$10$MA7izH/UJZY3t8iHtZSDteLg6/H8uhdldI3WikTXmZpZx01oZWtbi', 'admin'),
(5, 'Gladis Torres', 'gladistpeque@gmail.com', '3207639530', 9, '21912460', '1984-03-29', '$2y$10$03x/AkORFRDlvp2JOI2YI.LMrFHdDXqbM2dLySeSHTkOnYpuHOlZi', 'cliente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `barrios`
--
ALTER TABLE `barrios`
  ADD PRIMARY KEY (`id_barrio`),
  ADD KEY `id_ciudad` (`id_ciudad`);

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`id_ciudad`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `contactar`
--
ALTER TABLE `contactar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `id_propiedad` (`id_propiedad`),
  ADD KEY `idx_propiedad` (`id_propiedad`),
  ADD KEY `idx_principal` (`es_principal`),
  ADD KEY `idx_orden` (`orden`),
  ADD KEY `idx_activo` (`activo`);

--
-- Indices de la tabla `propiedades`
--
ALTER TABLE `propiedades`
  ADD PRIMARY KEY (`id_propiedad`),
  ADD KEY `id_ciudad` (`id_ciudad`),
  ADD KEY `id_barrio` (`id_barrio`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tipodocumento`
--
ALTER TABLE `tipodocumento`
  ADD PRIMARY KEY (`id_tipodocumento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `tipodocumento` (`tipodocumento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `barrios`
--
ALTER TABLE `barrios`
  MODIFY `id_barrio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  MODIFY `id_ciudad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `contactar`
--
ALTER TABLE `contactar`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `propiedades`
--
ALTER TABLE `propiedades`
  MODIFY `id_propiedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `barrios`
--
ALTER TABLE `barrios`
  ADD CONSTRAINT `barrios_ibfk_1` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudades` (`id_ciudad`);

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`id_propiedad`) REFERENCES `propiedades` (`id_propiedad`) ON DELETE CASCADE;

--
-- Filtros para la tabla `propiedades`
--
ALTER TABLE `propiedades`
  ADD CONSTRAINT `propiedades_ibfk_1` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudades` (`id_ciudad`),
  ADD CONSTRAINT `propiedades_ibfk_2` FOREIGN KEY (`id_barrio`) REFERENCES `barrios` (`id_barrio`),
  ADD CONSTRAINT `propiedades_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`tipodocumento`) REFERENCES `tipodocumento` (`id_tipodocumento`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
