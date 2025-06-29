-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2025 at 10:23 PM
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
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'iphone'),
(2, 'ipad'),
(3, 'mac'),
(4, 'apple watch'),
(5, 'airpods'),
(6, 'accesorios'),
(7, 'apple tv'),
(8, 'homepod'),
(9, 'perifericos');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`) VALUES
(1, 'iPhone 14', 'Última generación de iPhone con cámara mejorada.', 1450000.00, ''),
(2, 'iPad Air', 'Ideal para estudiar y trabajar.', 850000.00, ''),
(3, 'MacBook Pro', 'Rendimiento extremo para creativos.', 3100000.00, ''),
(4, 'Apple Watch Series 8', 'Controla tu salud desde tu muñeca.', 650000.00, ''),
(5, 'Airpods Pro 2', 'Auriculares con cancelación activa de ruido.', 380000.00, ''),
(6, 'iPhone SE', 'Compacto, potente y asequible.', 720000.00, ''),
(7, 'MacBook Air M2', 'Ligera, potente y silenciosa.', 1750000.00, ''),
(8, 'iMac 24', 'Todo en uno con pantalla Retina.', 2500000.00, ''),
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
(19, 'iPhone 13', 'Equilibrio entre potencia y precio.', 1350000.00, '');

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
(20, 6);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
