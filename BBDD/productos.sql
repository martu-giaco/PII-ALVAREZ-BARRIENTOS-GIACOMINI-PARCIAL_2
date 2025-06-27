-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2025 at 03:27 AM
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
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `categoria`) VALUES
(1, 'MacBook Air 13', 'La MacBook Air con chip M4 te da la velocidad que necesitas para volar en todo lo que hagas. Tiene una batería que dura hasta 18 horas. Está diseñada para Apple Intelligence, que te ayuda a hacer de todo con mucha facilidad. Estrena un hermoso color azul cielo. Y como es superportátil, te sigue adonde vayas y está lista para enfrentarse a lo que sea. ', 1179304.00, 'macs/macbook_air-1.png', 2),
(2, 'MacBook Pro 14', 'Los chips M4, M4 Pro y M4 Max convierten la MacBook Pro en una verdadera superpotencia. Con el descomunal rendimiento monohilo y multihilo del CPU, una memoria unificada más rápida y aceleradores de aprendizaje mejorados, la línea de chips M4 ofrece una velocidad y un desempeño casi imposibles. Y el Neural Engine usa toda su potencia para acelerar a fondo las tareas de inteligencia artificial como la optimización de imágenes y la creación de subtítulos.', 1887595.00, 'macs/macbookPro-1.png', 2),
(3, 'iMac', 'Con el chip M4, la iMac da un salto enorme en rendimiento y capacidades de IA. El CPU es más rápido para que hagas de todo volando, y el avanzado GPU con trazado de rayos acelerado por hardware brinda un realismo increíble a los gráficos. El motor multimedia mejorado te permite editar múltiples secuencias de video 4K con total fluidez. Con hasta 32 GB de memoria unificada más veloz, puedes jugar al máximo nivel y usar varias apps a la vez como si nada. Y nuestro potente Neural Engine puede ejecutar tareas de IA, como optimizar imágenes automáticamente y eliminar el ruido de fondo en un video.\r', 1533450.00, 'macs/iMac-1.png', 2),
(4, 'Pantalla de estudio', 'El monitor Studio Display es el compañero ideal para la superpoderosa e increíblemente compacta Mac Studio. Además, trabaja a la perfección con las computadoras de escritorio y notebooks Mac, desde la MacBook Pro y la MacBook Air hasta la Mac Pro y la Mac mini.\r\n', 1887595.00, 'macs/sd-1.png', 2),
(5, 'iPhone 15', 'Disponible en los colores negro, azul, verde, amarillo y rosa.\r\n', 825159.00, 'iphones/iphone15-1.png', 1),
(6, 'iPhone 16', 'El iPhone 16 está diseñado para disfrutar Apple Intelligence, el sistema de inteligencia personal que te ayuda a escribir, expresarte y hacer de todo con mucha facilidad. Y las avanzadas protecciones de privacidad te brindan la tranquilidad de saber que nadie más podrá acceder a tus datos. Ni siquiera Apple.', 943207.00, 'iphones/iphone16-1.jpg', 1),
(7, 'iPhone 16e', 'El iPhone 16e es el nuevo modelo de entrada dentro de la línea iPhone 16, lanzado el 28 de febrero de 2025 como sucesor natural del iPhone SE. Está pensado para quienes desean un iPhone moderno: potente, funcional y más accesible que los modelos Pro.', 707110.00, 'iphones/iphone16e-1.jpg', 1),
(8, 'iPhone 16 Pro', 'El iPhone 16 Pro es el modelo más avanzado de Apple, con un diseño premium de titanio, pantalla de alta calidad, gran potencia gracias al A18 Pro y capacidades fotográficas y de vídeo de nivel profesional. Perfecto para quienes buscan lo último en tecnología y experiencia Pro.', 1179304.00, 'iphones/iphone16pro-1.jpg', 1),
(9, 'iPad', 'El iPad de 10.ª generación ofrece una experiencia versátil y potente en un diseño todo pantalla de 10,9 pulgadas. Con el chip A14 Bionic, cámara frontal ultra gran angular con Encuadre Centrado, conectividad USB‑C y compatibilidad con Apple Pencil (1.ª generación) y el Magic Keyboard Folio, es ideal para trabajar, crear y conectarte desde cualquier lugar.', 411989.00, 'ipads/ipad-1.png', 5),
(10, 'iPad Air 11', 'El nuevo iPad Air de 11 pulgadas con chip M2 ofrece potencia y versatilidad en un diseño ultrafino y liviano. Con una espectacular pantalla Liquid Retina, cámara frontal ultra gran angular en orientación horizontal, compatibilidad con Apple Pencil Pro y Magic Keyboard, y conectividad Wi‑Fi 6E, es perfecto para estudiar, trabajar, crear y mucho más, estés donde estés.', 707110.00, 'ipads/ipadAir-1.jpg', 5),
(11, 'iPad Pro 13', 'El iPad Pro de 13 pulgadas con chip M4 redefine lo que es posible en un iPad. Con una increíble pantalla Ultra Retina XDR, potencia de nivel profesional, un diseño ultrafino de titanio y compatibilidad con el Apple Pencil Pro y el nuevo Magic Keyboard, es la herramienta definitiva para los creadores más exigentes. Ligero, potente y espectacular en todo sentido.', 1179304.00, 'ipads/ipadPro13-1.png', 5),
(12, 'iPad mini', 'El iPad mini combina potencia y portabilidad en un diseño compacto de 8,3 pulgadas. Con el chip A15 Bionic, compatibilidad con Apple Pencil (2.ª generación), conectividad USB‑C y 5G en modelos celulares, es perfecto para tomar notas, leer, dibujar o trabajar desde cualquier lugar. Pequeño, pero increíblemente poderoso.', 589062.00, 'ipads/ipadmini-1.png', 5),
(13, 'Airpods 4', 'Los nuevos AirPods 4 redefinen el confort y la experiencia de audio. Con diseño tipo AirPods sin puntas, chip H2, Bluetooth 5.3 y caja USB‑C compacta, ofrecen hasta 5 h de escucha (4 h con ANC) y 30 h totales. Disponibles en versión estándar o con Active Noise Cancellation (ANC), ésta última suma carga inalámbrica, ANC avanzado, Modo Transparencia y audio espacial personalizado con seguimiento dinámico de cabeza. Además, tienen certificación IP54 y control por toque, integrándose a la perfección con el ecosistema Apple.', 152282.00, 'airpods/airpods4-1.jpg', 3),
(14, 'Airpods Pro 2', 'Los AirPods Pro (2.ª generación) ofrecen una experiencia sonora envolvente con cancelación activa de ruido avanzada, modo Ambiente adaptable y audio espacial personalizado. Gracias al chip H2, brindan un sonido de alta fidelidad, mayor autonomía y un rendimiento más inteligente. Incluyen controles táctiles, resistencia al agua y al sudor, y una caja de carga MagSafe con altavoz integrado y conector USB‑C. Todo lo que te gusta de los AirPods, llevado al nivel Pro.', 293940.00, 'airpods/airpodsPro2.jpg', 3),
(15, 'Airpods Max', 'Los AirPods Max combinan un diseño premium con un sonido de calidad extraordinaria. Con drivers personalizados, cancelación activa de ruido avanzada y modo Transparencia, ofrecen una experiencia auditiva inmersiva y detallada. Su estructura de aluminio anodizado y almohadillas de espuma viscoelástica garantizan comodidad para largas sesiones. Equipados con el chip H1 en cada auricular, proporcionan conexión ultraestable, audio espacial y una integración perfecta con todo el ecosistema Apple.', 648086.00, 'airpods/airpodsMax-1.jpg', 3),
(16, 'HomePod', 'El HomePod ofrece un sonido potente y envolvente en un diseño elegante que se adapta a cualquier espacio. Con tecnología de audio avanzada, reconoce la acústica de la habitación para optimizar la reproducción, integra Siri para controlar tu hogar inteligente y gestionar tu música con solo tu voz. Es el altavoz inteligente ideal para quienes buscan calidad sonora y conectividad profunda con el ecosistema Apple.', 205833.00, 'homepod/homepod-1.jpg', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
