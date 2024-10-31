-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 31-10-2024 a las 04:15:56
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `comanda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosPedidos`
--

CREATE TABLE `productosPedidos` (
  `id` int(11) NOT NULL,
  `numeroDePedido` varchar(50) DEFAULT NULL,
  `productoId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productosPedidos`
--

INSERT INTO `productosPedidos` (`id`, `numeroDePedido`, `productoId`) VALUES
(1, 'MXG7F', 1),
(2, 'MXG7F', 2),
(3, 'dYTL6', 1),
(4, 'dYTL6', 4),
(5, 'dYTL6', 3),
(6, 'dYTL6', 4),
(7, 'dYTL6', 4),
(8, 'dYTL6', 4),
(9, 'dYTL6', 4),
(10, 'Hp4Uo', 1),
(11, 'Hp4Uo', 4),
(12, 'Hp4Uo', 3),
(13, 'Hp4Uo', 4),
(15, 'aIhbo', 1),
(16, 'aIhbo', 4),
(17, 'aIhbo', 3),
(18, 'aIhbo', 4),
(19, 'aIhbo', 3),
(20, 'aIhbo', 4),
(21, 'aIhbo', 4),
(22, 'bnuuQ', 1),
(23, 'bnuuQ', 4),
(24, 'bnuuQ', 3),
(25, 'bnuuQ', 4),
(26, 'bnuuQ', 3),
(27, 'bnuuQ', 4),
(28, 'bnuuQ', 4),
(29, 'WlpVw', 1),
(30, 'WlpVw', 4),
(31, 'WlpVw', 3),
(32, 'WlpVw', 4),
(33, 'WlpVw', 3),
(34, 'WlpVw', 4),
(35, 'WlpVw', 4),
(36, 'Sxlnh', 1),
(37, 'Sxlnh', 4),
(38, 'Sxlnh', 3),
(39, 'Sxlnh', 4),
(40, 'Sxlnh', 3),
(41, 'Sxlnh', 4),
(42, 'Sxlnh', 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productosPedidos`
--
ALTER TABLE `productosPedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `numeroDePedido` (`numeroDePedido`),
  ADD KEY `productoId` (`productoId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productosPedidos`
--
ALTER TABLE `productosPedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productosPedidos`
--
ALTER TABLE `productosPedidos`
  ADD CONSTRAINT `productospedidos_ibfk_1` FOREIGN KEY (`numeroDePedido`) REFERENCES `pedidos` (`numeroDePedido`),
  ADD CONSTRAINT `productospedidos_ibfk_2` FOREIGN KEY (`productoId`) REFERENCES `productos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
