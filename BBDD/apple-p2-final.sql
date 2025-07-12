-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2025 at 11:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apple-p2`
--
CREATE DATABASE IF NOT EXISTS `apple-p2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `apple-p2`;

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `imagen_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `activo`, `imagen_categoria`) VALUES
(1, 'iPhone', 1, 'iphone-categoria.png'),
(2, 'iPad', 1, 'ipad-categoria.png'),
(3, 'Mac', 1, 'mac-categoria.png'),
(4, 'Apple Watch', 1, 'apple-watch-categoria.png'),
(5, 'AirPods', 1, 'airpods-categoria.png'),
(6, 'Accesorios', 1, 'airtag.png'),
(7, 'Apple TV', 1, 'apple-tv-categoria.png'),
(8, 'HomePod', 1, 'homepod-categoria.png'),
(9, 'Perifericos', 1, 'perifericos-categoria.png');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `activo`) VALUES
(1, 'iPhone 15', 'Última generación de iPhone con cámara mejorada.', 1460000.00, 'iphone15.png', 1),
(2, 'iPad Air', 'Ideal para estudiar y trabajar.', 850000.00, 'ipadAir.jpg', 1),
(3, 'MacBook Pro', 'Rendimiento extremo para creativos.', 3100000.00, 'macbookPro.png', 1),
(4, 'Apple Watch - Series 8', 'Controla tu salud desde tu muñeca.', 650000.00, 'apple-watch.jpg', 1),
(5, 'Airpods Pro 2', 'Auriculares con cancelación activa de ruido.', 380000.00, 'airpods-pro.jpg', 1),
(6, 'iPhone 16e', 'Compacto, potente y asequible.', 720000.00, 'iphone16e.jpg', 1),
(7, 'MacBook Air', 'Ligera, potente y silenciosa.', 1750000.00, 'macbook_air.png', 1),
(8, 'iMac 24\'', 'Todo en uno con pantalla Retina.', 2500000.00, 'imac.png', 1),
(9, 'Mac Mini', 'Pequeño tamaño, gran rendimiento.', 990000.00, 'mac-mini.png', 1),
(10, 'iPad Mini', 'Pantalla compacta, alto rendimiento.', 790000.00, 'ipadmini.png', 1),
(11, 'Apple TV 4K', 'Entretenimiento en su máxima expresión.', 560000.00, 'apple-tv.png', 1),
(12, 'HomePod', 'Sonido sorprendente.', 320000.00, 'homepod.jpg', 1),
(13, 'Magic Keyboard', 'Teclado cómodo y elegante.', 210000.00, 'magic-keyboard.png', 1),
(14, 'Magic Mouse', 'Precisión y diseño.', 180000.00, 'magic-mouse.png', 1),
(15, 'AirTag', 'Localiza todo fácilmente.', 45000.00, 'airtag.png', 1),
(16, 'Apple Pencil 2', 'Precisión para tus ideas.', 290000.00, 'apple-pencil.webp', 1),
(17, 'Mac Studio', 'Diseñado para profesionales creativos.', 4500000.00, 'mac-studio.png', 1),
(18, 'Studio Display', 'Pantalla Retina profesional.', 3900000.00, 'studio-display.png', 1),
(19, 'iPhone 16', 'Equilibrio entre potencia y precio.', 1350000.00, 'iphone16.jpg', 1),
(20, 'PopSocket Blueberry', 'popsocket magnetico para iPhone.', 175000.00, 'popsocket.jpg', 1),
(26, 'AirPods 4', 'con cancelación de ruido.', 300000.00, 'airpods4.jpg', 1),
(27, 'AirPods Max', 'Disfrutá el sonido en todo su esplendor', 500000.00, 'airpodsMax.jpg', 1),
(28, 'iPad', 'nuestro clásico modelo, se adapta a cualquier necesidad.', 876000.00, 'ipad.png', 1),
(31, 'iPad Pro 13\'', 'Nuestro iPad, mejorado.', 905000.00, 'ipadPro13.png', 1),
(33, 'iPhone 16 Pro', 'El iPhone 16, mejorado.', 1500600.00, 'iphone16pro.jpg', 1),
(34, 'HomePod mini', 'El hermano menor del clásico HomePod', 100000.00, 'homepod-mini.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `producto_categoria`
--

CREATE TABLE `producto_categoria` (
  `producto_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `producto_categoria`
--

INSERT INTO `producto_categoria` (`producto_id`, `categoria_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 1),
(7, 3),
(8, 3),
(9, 3),
(10, 2),
(11, 7),
(12, 8),
(13, 6),
(14, 9),
(15, 6),
(16, 6),
(17, 3),
(18, 7),
(19, 1),
(20, 6),
(26, 5),
(27, 5),
(28, 2),
(31, 2),
(33, 1),
(34, 8);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_rol`, `rol`) VALUES
(1, 'admin'),
(2, 'cliente');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `clave` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `email`, `clave`) VALUES
(1, 'pepe', 'pepe@pepe.com', '$2y$10$5m73Z9VKBizBEcMuCH2KfeduiVWNHlbUfcFaP6/ZMJQi79rhJcuLS'),
(2, 'elu suario', 'elu@suario.com', '$2y$10$ArZk8dLj.FQxv4PI3AM00uZumLbxNZShE1QXfVnbCmMpw/P.oZnKC');

-- --------------------------------------------------------

--
-- Table structure for table `usuario_rol`
--

CREATE TABLE `usuario_rol` (
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario_rol`
--

INSERT INTO `usuario_rol` (`id_usuario`, `id_rol`) VALUES
(1, 1),
(2, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `producto_categoria`
--
ALTER TABLE `producto_categoria`
  ADD PRIMARY KEY (`producto_id`,`categoria_id`),
  ADD KEY `fk_categoria` (`categoria_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indexes for table `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`id_usuario`,`id_rol`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `producto_categoria`
--
ALTER TABLE `producto_categoria`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `usuario_rol_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `usuario_rol_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
