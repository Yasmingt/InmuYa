-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-10-2025 a las 19:38:34
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
(1, 'Chapinero', 1),
(2, 'Usaqu?n', 1),
(3, 'Santa Fe', 1),
(4, 'La Candelaria', 1),
(5, 'El Poblado', 2),
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
(4, 'Barranquilla'),
(1, 'Bogot?'),
(3, 'Cali'),
(2, 'Medell?n');

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
(6, 'hgthrbrft', 'vaccajuan@gmail.com', 'efdwsef', 'dwsfce34wf', 'nuevo');

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
(17, 1, 'propiedad_1_1.jpg', 'Fachada Principal', 'Vista frontal de la casa moderna con dise?o contempor?neo', 1, 1, '2025-10-14 16:21:05', 1),
(18, 1, 'propiedad_1_2.jpg', 'Jard?n Privado', 'Espacio verde privado ideal para relajaci?n', 2, 0, '2025-10-14 16:21:05', 1),
(19, 1, 'propiedad_1_3.jpg', 'Sala Principal', 'Amplia sala de estar con dise?o moderno', 3, 0, '2025-10-14 16:21:05', 1),
(20, 2, 'propiedad_2_1.jpg', 'Vista del Valle', 'Hermosa vista panor?mica del valle de Aburr?', 1, 1, '2025-10-14 16:21:05', 1),
(21, 2, 'propiedad_2_2.jpg', 'Cocina Moderna', 'Cocina completamente equipada con electrodom?sticos de ?ltima generaci?n', 2, 0, '2025-10-14 16:21:05', 1),
(22, 2, 'propiedad_2_3.jpg', 'Piscina', 'Piscina comunal con vista panor?mica', 3, 0, '2025-10-14 16:21:05', 1),
(23, 3, 'propiedad_3_1.jpg', 'Fachada Comercial', 'Local comercial con excelente ubicaci?n', 1, 1, '2025-10-14 16:21:05', 1),
(24, 3, 'propiedad_3_2.jpg', 'Interior del Local', 'Espacio amplio y vers?til para cualquier negocio', 2, 0, '2025-10-14 16:21:05', 1),
(25, 4, 'propiedad_4_1.jpg', 'Casa Campestre', 'Hermosa casa campestre con amplios espacios', 1, 1, '2025-10-14 16:21:05', 1),
(26, 4, 'propiedad_4_2.jpg', 'Jard?n y Huerta', 'Extenso jard?n con ?rea de huerta', 2, 0, '2025-10-14 16:21:05', 1),
(27, 4, 'propiedad_4_3.jpg', 'Zona de Parrilla', '?rea de parrilla perfecta para reuniones familiares', 3, 0, '2025-10-14 16:21:05', 1),
(28, 5, 'propiedad_5_1.jpg', 'Apartamento Moderno', 'Apartamento con dise?o contempor?neo y excelente ubicaci?n', 1, 1, '2025-10-14 16:21:05', 1),
(29, 5, 'propiedad_5_2.jpg', 'Parqueadero', 'Parqueadero cubierto y seguro', 2, 0, '2025-10-14 16:21:05', 1),
(30, 6, 'propiedad_6_1.jpg', 'Oficina Principal', 'Espaciosa oficina ejecutiva con excelente iluminaci?n', 1, 1, '2025-10-14 16:21:05', 1),
(31, 6, 'propiedad_6_2.jpg', 'Sala de Juntas', 'Sala de juntas equipada para reuniones ejecutivas', 2, 0, '2025-10-14 16:21:05', 1),
(32, 6, 'propiedad_6_3.jpg', 'Recepci?n', '?rea de recepci?n profesional y acogedora', 3, 0, '2025-10-14 16:21:05', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id_mensaje` int(11) NOT NULL,
  `id_remitente` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `id_propiedad` int(11) DEFAULT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propiedades`
--

CREATE TABLE `propiedades` (
  `id_propiedad` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `tipo` enum('arriendo','venta') NOT NULL,
  `precio` decimal(10,2) NOT NULL,
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
  `activo` tinyint(1) DEFAULT 1,
  `fecha_disponible` date DEFAULT NULL,
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
  `antiguedad` int(11) DEFAULT NULL,
  `estado_conservacion` enum('excelente','bueno','regular','requiere_remodelacion') DEFAULT 'bueno',
  `orientacion` enum('norte','sur','este','oeste','noreste','noroeste','sureste','suroeste') DEFAULT NULL,
  `telefono_contacto` varchar(20) DEFAULT NULL,
  `email_contacto` varchar(100) DEFAULT NULL,
  `nombre_contacto` varchar(100) DEFAULT NULL,
  `mostrar_telefono` tinyint(1) DEFAULT 1,
  `mostrar_email` tinyint(1) DEFAULT 1,
  `vistas` int(11) DEFAULT 0,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `propiedades`
--

INSERT INTO `propiedades` (`id_propiedad`, `titulo`, `descripcion`, `tipo`, `precio`, `area`, `habitaciones`, `banos`, `parqueadero`, `direccion`, `id_ciudad`, `id_barrio`, `id_usuario`, `fecha_publicacion`, `estado`, `tipo_propiedad`, `destacado`, `activo`, `fecha_disponible`, `piso`, `ascensor`, `balcon`, `terraza`, `jardin`, `piscina`, `gimnasio`, `seguridad_24h`, `mascotas_permitidas`, `precio_negociable`, `incluye_administracion`, `valor_administracion`, `incluye_servicios`, `antiguedad`, `estado_conservacion`, `orientacion`, `telefono_contacto`, `email_contacto`, `nombre_contacto`, `mostrar_telefono`, `mostrar_email`, `vistas`, `fecha_actualizacion`) VALUES
(1, 'Casa moderna en Chapinero', 'Hermosa casa de 3 pisos con acabados de lujo, ubicada en una de las mejores zonas de Chapinero. Cuenta con jard?n privado, terraza y vista panor?mica de la ciudad.', 'venta', 99999999.99, 180.50, 4, 3, 1, 'Carrera 7 #93-45', 1, 1, 3, '2025-10-14 15:51:14', 'disponible', 'casa', 1, 1, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, NULL, 'bueno', NULL, NULL, NULL, NULL, 1, 1, 25, '2025-10-14 15:51:14'),
(2, 'Apartamento en El Poblado', 'Moderno apartamento en torre de lujo con vista al valle de Aburr?. Incluye todas las amenidades: gimnasio, piscina, zona de juegos infantiles y seguridad 24/7.', 'arriendo', 2500000.00, 95.00, 2, 2, 1, 'Calle 10 #43-89', 2, 5, 3, '2025-10-14 15:51:14', 'disponible', 'apartamento', 1, 1, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, NULL, 'bueno', NULL, NULL, NULL, NULL, 1, 1, 18, '2025-10-14 15:51:14'),
(3, 'Local comercial en Santa Fe', 'Excelente local comercial en zona de alto tr?fico peatonal. Ideal para restaurante, caf? o tienda de ropa. Cuenta con ba?o privado y ?rea de almac?n.', 'venta', 99999999.99, 45.00, 0, 1, 0, 'Calle 19 #7-23', 1, 3, 3, '2025-10-14 15:51:14', 'disponible', 'local', 1, 1, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, NULL, 'bueno', NULL, NULL, NULL, NULL, 1, 1, 12, '2025-10-14 16:21:41'),
(4, 'Casa campestre en Envigado', 'Casa campestre con amplio jard?n, ideal para familias que buscan tranquilidad. Cuenta con huerta, zona de parrilla y espacio para mascotas.', 'venta', 99999999.99, 220.00, 3, 2, 1, 'Carrera 48 #32 Sur - 89', 2, 7, 3, '2025-10-14 15:51:14', 'disponible', 'casa', 1, 1, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, NULL, 'bueno', NULL, NULL, NULL, NULL, 1, 1, 8, '2025-10-14 16:21:41'),
(5, 'Apartamento en Usaqu?n', 'C?modo apartamento en conjunto cerrado con seguridad las 24 horas. Incluye parqueadero cubierto y dep?sito. Cerca a centros comerciales y transporte p?blico.', 'arriendo', 1800000.00, 75.00, 2, 2, 1, 'Calle 127 #15-67', 1, 2, 3, '2025-10-14 15:51:14', 'disponible', 'apartamento', 1, 1, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, NULL, 'bueno', NULL, NULL, NULL, NULL, 1, 1, 15, '2025-10-14 16:21:41'),
(6, 'Oficina ejecutiva en Laureles', 'Oficina completamente equipada en edificio corporativo. Ideal para empresas que buscan una ubicaci?n estrat?gica. Incluye recepci?n y sala de juntas.', 'arriendo', 3200000.00, 120.00, 0, 2, 1, 'Carrera 70 #44-23', 2, 6, 3, '2025-10-14 15:51:14', 'disponible', 'oficina', 1, 1, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, NULL, 0, NULL, 'bueno', NULL, NULL, NULL, NULL, 1, 1, 22, '2025-10-14 16:21:41');

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
(2, 'Alejandra Torres', 'alejandra.chancit@gmail.com', '3137155912', 9, '1001398338', '2001-03-18', '$2y$10$V6PKwZS4Skc/nO2f5Nrp9O94iiLNFg6PZtgtTfcY96uv1m729/n4S', 'admin'),
(3, 'Felipe Valencia', 'felipevalenciaarcila@gmail.com', '3156607670', 9, '1128271817', '1987-10-04', '$2y$10$0WkOKgkmR7bucsK7VKZg6e4WBSYzbAH5DqQDh8AK/ioGnqZtYojdW', 'propietario'),
(4, 'yasmin', 'yasmin@gmail.com', '3195515809', 9, '1028141355', '2001-01-07', '$2y$10$UkHkrZNsiU0UFQajdQxp7.pF8aSBSr/VjUtQFqlI7lN1AeahjImU2', 'cliente');

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
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `id_remitente` (`id_remitente`),
  ADD KEY `id_destinatario` (`id_destinatario`),
  ADD KEY `id_propiedad` (`id_propiedad`);

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
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `propiedades`
--
ALTER TABLE `propiedades`
  MODIFY `id_propiedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_remitente`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `mensajes_ibfk_3` FOREIGN KEY (`id_propiedad`) REFERENCES `propiedades` (`id_propiedad`);

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
