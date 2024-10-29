-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 29-10-2024 a las 04:26:46
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
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `mesaId` int(11) NOT NULL,
  `numeroDePedido` varchar(50) NOT NULL,
  `tiempoEstimado` int(11) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha` datetime NOT NULL,
  `fechaBaja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `mesaId`, `numeroDePedido`, `tiempoEstimado`, `estado`, `foto`, `precio`, `fecha`, `fechaBaja`) VALUES
(1, 1, 'abd45', NULL, 'Preparacione', NULL, 100.00, '2024-10-27 22:38:03', '2024-10-28 13:18:37'),
(2, 2, 'dgh43', NULL, 'pendiente', NULL, 150.00, '2024-10-27 22:38:03', '2024-10-28 13:19:06'),
(3, 3, '123rg', NULL, 'pendiente', NULL, 200.00, '2024-10-27 22:38:03', '2024-10-28 13:21:31'),
(4, 432, '11111', NULL, 'pendiente', NULL, 2250.00, '2024-10-28 00:00:00', NULL),
(5, 432, '11111', NULL, 'pendiente', NULL, 2250.00, '2024-10-28 00:00:00', NULL),
(6, 555, '11111', NULL, 'pendiente', NULL, 5000.00, '2024-10-28 00:00:00', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
