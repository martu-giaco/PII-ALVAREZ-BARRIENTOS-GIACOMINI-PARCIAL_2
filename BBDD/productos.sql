-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-06-2025 a las 02:48:47
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `apple-p2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`) VALUES
(1, 'iPhone 14', 'Última generación de iPhone con cámara mejorada.', 1450000.00, ''),
(2, 'iPad Air', 'Ideal para estudiar y trabajar.', 850000.00, ''),
(3, 'MacBook Pro', 'Rendimiento extremo para creativos.', 3100000.00, ''),
(4, 'Apple Watch Series 8', 'Controla tu salud desde tu muñeca.', 650000.00, ''),
(5, 'AirPods Pro 2', 'Auriculares con cancelación activa de ruido.', 380000.00, ''),
(6, 'iPhone SE', 'Compacto, potente y asequible.', 720000.00, ''),
(7, 'MacBook Air M2', 'Ligera, potente y silenciosa.', 1750000.00, ''),
(8, 'iMac 24\"', 'Todo en uno con pantalla Retina.', 2500000.00, ''),
(9, 'Mac Mini', 'Pequeño tamaño, gran rendimiento.', 990000.00, ''),
(10, 'iPad Mini', 'Pantalla compacta, alto rendimiento.', 790000.00, ''),
(11, 'Apple TV 4K', 'Entretenimiento en su máxima expresión.', 560000.00, ''),
(12, 'HomePod Mini', 'Sonido sorprendente para su tamaño.', 320000.00, ''),
(13, 'Magic Keyboard', 'Teclado cómodo y elegante.', 210000.00, ''),
(14, 'Magic Mouse', 'Precisión y diseño.', 180000.00, ''),
(15, 'AirTag', 'Localiza todo fácilmente.', 45000.00, ''),
(16, 'Apple Pencil 2', 'Precisión para tus ideas.', 290000.00, ''),
(17, 'Mac Studio', 'Diseñado para profesionales creativos.', 4500000.00, ''),
(18, 'Studio Display', 'Pantalla Retina profesional.', 3900000.00, ''),
(19, 'iPhone 13', 'Equilibrio entre potencia y precio.', 1350000.00, ''),
(20, 'Smart Battery Case', 'Batería extra para iPhone.', 175000.00, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
