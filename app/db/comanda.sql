-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 07-11-2024 a las 04:56:07
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
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `fechaBaja` datetime DEFAULT NULL,
  `codigoDeIdentificacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `estado`, `fechaBaja`, `codigoDeIdentificacion`) VALUES
(1, 'CambiandoElEstado', '2024-10-30 20:30:45', 'ab123'),
(2, 'con cliente comiendo', '2024-10-30 20:30:50', 'VUD0Q'),
(3, 'con cliente pagando', NULL, 'A0W5S'),
(4, 'cerrada', NULL, '69IJX'),
(5, 'sarasa', NULL, 'N7S1L'),
(6, 'sarasa', NULL, 'KRSGL'),
(7, 'sarasa', NULL, 'BICV5'),
(9, 'sarasa', NULL, '123123'),
(10, 'cerrada', NULL, '777'),
(12, 'cerrada', NULL, '999');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `mesaId` varchar(255) DEFAULT NULL,
  `numeroDePedido` varchar(50) NOT NULL,
  `tiempoEstimado` int(11) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha` datetime NOT NULL,
  `fechaBaja` datetime DEFAULT NULL,
  `total` decimal(10,2) DEFAULT 0.00,
  `cliente` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `mesaId`, `numeroDePedido`, `tiempoEstimado`, `estado`, `foto`, `precio`, `fecha`, `fechaBaja`, `total`, `cliente`) VALUES
(1, '69IJX', 'MXG7F', NULL, 'Preparacione', NULL, 100.00, '2024-10-27 22:38:03', '2024-10-28 13:18:37', 0.00, 'Romina'),
(2, 'A0W5S', '9QKF6', NULL, 'pendiente', NULL, 150.00, '2024-10-27 22:38:03', '2024-10-28 13:19:06', 0.00, 'Pepe'),
(3, 'ab123', '9HCZN', NULL, 'Preparacione', NULL, 200.00, '2024-10-27 22:38:03', '2024-10-28 13:21:31', 0.00, 'Carlos'),
(4, 'BICV5', '21O35', NULL, 'Preparacione', NULL, 2250.00, '2024-10-28 00:00:00', NULL, 0.00, 'Carlos'),
(5, 'KRSGL', '65Y3B', NULL, 'pendiente', NULL, 2250.00, '2024-10-28 00:00:00', NULL, 0.00, 'Carlos'),
(6, 'N7S1L', 'YN22W', NULL, 'pendiente', NULL, 5000.00, '2024-10-28 00:00:00', NULL, 0.00, 'Carlos'),
(7, 'VUD0Q', 'YV5WT', NULL, 'pendiente', NULL, 5000.00, '2024-10-30 00:00:00', NULL, 0.00, 'Carlos'),
(17, 'VUD0Q', 'YN22M', NULL, 'pendiente', NULL, 5000.00, '2024-10-30 00:00:00', NULL, 0.00, 'Carlos'),
(21, 'ab123', 'AAA22', NULL, 'pendiente', NULL, 5000.00, '2024-10-30 00:00:00', NULL, 0.00, 'Carlos'),
(22, 'ab123', 'BBB12', NULL, 'pendiente', NULL, 5000.00, '2024-10-30 00:00:00', NULL, 0.00, 'Carlos'),
(23, 'ab123', 'Bfw43', NULL, 'pendiente', NULL, 5000.00, '2024-10-30 00:00:00', NULL, 0.00, 'Carlos'),
(41, 'ab123', 'taKuv', NULL, 'pendiente', NULL, 5000.00, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(42, 'ab123', 'r8hcn', NULL, 'pendiente', NULL, 5000.00, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(43, 'ab123', 'v206G', NULL, 'pendiente', NULL, 5000.00, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(44, 'ab123', 'BZ39Z', NULL, 'pendiente', NULL, 5000.00, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(46, 'A0W5S', 'BLxQK', NULL, 'pendiente', NULL, 5000.00, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(47, 'A0W5S', 'Swl7U', NULL, 'pendiente', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(48, 'A0W5S', '2gik5', NULL, 'pendiente', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(49, 'A0W5S', 'RBJxY', NULL, 'pendiente', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(50, 'A0W5S', 'w3E9h', NULL, 'pendiente', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(51, 'A0W5S', 'jZQr8', NULL, 'pendiente', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(52, 'A0W5S', '3pc4G', NULL, 'pendiente', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(53, 'A0W5S', 'lSezU', NULL, 'pendiente', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(54, 'A0W5S', 'uv5aq', NULL, 'pendiente', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(55, 'A0W5S', 'VBINy', NULL, 'pendiente', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(56, 'A0W5S', 'dYTL6', NULL, 'pendiente', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(57, 'A0W5S', 'Hp4Uo', NULL, 'pendiente', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(58, 'A0W5S', 'aIhbo', NULL, 'pendiente', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(59, 'A0W5S', 'bnuuQ', 30, 'pendiente', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(60, 'A0W5S', 'WlpVw', 30, 'pendiente', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(61, 'A0W5S', 'Sxlnh', 30, 'pendiente', NULL, 99999.00, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(62, '123123', 'bwDJR', 12, 'pendiente', NULL, 20000.00, '2024-11-03 00:00:00', NULL, 0.00, 'Carlos'),
(63, '777', 'VVXpk', 12, 'pendiente', NULL, 20000.00, '2024-11-03 00:00:00', NULL, 0.00, 'Carlos'),
(64, '777', 'eAjaU', 12, 'pendiente', NULL, 20000.00, '2024-11-04 00:00:00', NULL, 0.00, 'Carlos'),
(65, '777', 'j43ck', 12, 'pendiente', NULL, 20000.00, '2024-11-04 00:00:00', NULL, 0.00, 'Robenson'),
(66, '777', 'UiIs6', 12, 'pendiente', NULL, 20000.00, '2024-11-05 00:00:00', NULL, 0.00, 'Robenson'),
(67, '777', 'fDQyU', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(68, '777', '5dGb4', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(69, '777', 'kozxc', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(70, '777', '2BfqX', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(71, '777', '9uMh0', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(72, '777', 'n9wR9', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(73, '777', 'xk1eO', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(74, '777', '7ZJzj', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(75, 'KRSGL', 'ntaDz', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(76, 'KRSGL', 'GNwFJ', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(77, 'KRSGL', '2CT4J', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(78, 'KRSGL', 'mcWii', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(79, 'KRSGL', 'R5S2d', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(80, 'KRSGL', 'orbgg', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(81, 'KRSGL', 'DTKPo', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(82, 'KRSGL', 'ZKw6g', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(83, 'KRSGL', 'aXqE2', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(84, 'KRSGL', 'hTDFj', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(85, 'KRSGL', 'sUiLe', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(86, 'KRSGL', '72DXX', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(87, 'KRSGL', 'eUqQQ', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(88, 'KRSGL', 'r984G', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(89, 'KRSGL', 'g5RNp', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(90, 'KRSGL', 'oSMPt', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(91, 'KRSGL', 'vAF0k', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(92, 'KRSGL', '42ZPT', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(93, 'KRSGL', 'BGfxp', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(94, 'KRSGL', 'aseyN', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(95, 'KRSGL', 'mu6Jw', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(96, 'KRSGL', 'Oqy6m', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(97, 'KRSGL', 'FIJF0', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(98, 'KRSGL', '8dQOc', 12, 'pendiente', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fechaBaja` datetime DEFAULT NULL,
  `numeroDePedido` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `tipo`, `precio`, `fechaBaja`, `numeroDePedido`) VALUES
(1, 'pizza', 'comida', 23.00, '2024-10-28 01:41:57', 'BZN3A'),
(2, 'ravioles', 'comida', 1500.00, '2024-10-27 22:57:00', 'STIT7'),
(3, 'vino', 'trago', 1250.00, NULL, 'BO6K1'),
(4, 'fideos', 'comida', 5000.00, NULL, '7MA95'),
(5, 'cerveza', 'cerveza', 5000.00, NULL, 'QYCH6'),
(6, 'hamburguesa', 'comida', 5000.00, NULL, '62J62'),
(7, 'empanada', 'comida', 5000.00, NULL, 'FP0O1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosPedidos`
--

CREATE TABLE `productosPedidos` (
  `id` int(11) NOT NULL,
  `numeroDePedido` varchar(50) DEFAULT NULL,
  `productoId` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `empleadoACargo` int(11) DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'preparacion',
  `timpoInicial` datetime DEFAULT current_timestamp(),
  `timpoFinal` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productosPedidos`
--

INSERT INTO `productosPedidos` (`id`, `numeroDePedido`, `productoId`, `precio`, `empleadoACargo`, `estado`, `timpoInicial`, `timpoFinal`) VALUES
(1, 'MXG7F', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(2, 'MXG7F', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(3, 'dYTL6', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(4, 'dYTL6', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(5, 'dYTL6', 3, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(6, 'dYTL6', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(7, 'dYTL6', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(8, 'dYTL6', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(9, 'dYTL6', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(10, 'Hp4Uo', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(11, 'Hp4Uo', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(12, 'Hp4Uo', 3, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(13, 'Hp4Uo', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(15, 'aIhbo', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(16, 'aIhbo', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(17, 'aIhbo', 3, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(18, 'aIhbo', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(19, 'aIhbo', 3, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(20, 'aIhbo', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(21, 'aIhbo', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(22, 'bnuuQ', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(23, 'bnuuQ', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(24, 'bnuuQ', 3, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(25, 'bnuuQ', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(26, 'bnuuQ', 3, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(27, 'bnuuQ', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(28, 'bnuuQ', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(29, 'WlpVw', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(30, 'WlpVw', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(31, 'WlpVw', 3, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(32, 'WlpVw', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(33, 'WlpVw', 3, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(34, 'WlpVw', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(35, 'WlpVw', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(36, 'Sxlnh', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(37, 'Sxlnh', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(38, 'Sxlnh', 3, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(39, 'Sxlnh', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(40, 'Sxlnh', 3, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(41, 'Sxlnh', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(42, 'Sxlnh', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(43, 'bwDJR', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(44, 'bwDJR', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(45, 'bwDJR', 3, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(46, 'bwDJR', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(47, 'bwDJR', 3, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(48, 'bwDJR', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(49, 'bwDJR', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(50, 'VVXpk', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(51, 'VVXpk', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(52, 'eAjaU', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(53, 'eAjaU', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(54, 'j43ck', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(55, 'j43ck', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(56, 'UiIs6', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(57, 'UiIs6', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(58, 'fDQyU', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(59, 'fDQyU', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(60, '5dGb4', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(61, '5dGb4', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(62, 'kozxc', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(63, 'kozxc', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(64, '2BfqX', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(65, '2BfqX', 4, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(66, 'ntaDz', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(67, 'ntaDz', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(68, 'GNwFJ', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(69, 'GNwFJ', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(70, '2CT4J', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(71, '2CT4J', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(72, 'mcWii', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(73, 'mcWii', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(74, 'R5S2d', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(75, 'R5S2d', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(76, 'orbgg', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(77, 'orbgg', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(78, 'ZKw6g', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(79, 'ZKw6g', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(80, '72DXX', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(81, '72DXX', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(82, 'eUqQQ', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(83, 'eUqQQ', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(84, 'r984G', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(85, 'r984G', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(86, 'g5RNp', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(87, 'g5RNp', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(88, 'oSMPt', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(89, 'oSMPt', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(90, 'vAF0k', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(91, 'vAF0k', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(92, '42ZPT', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(93, '42ZPT', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(94, 'BGfxp', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(95, 'BGfxp', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(96, 'aseyN', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(97, 'aseyN', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(98, 'mu6Jw', 1, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(99, 'mu6Jw', 2, NULL, NULL, 'preparacion', '2024-11-06 11:43:37', NULL),
(100, 'Oqy6m', 1, 23.00, 14, 'preparacion', '2024-11-06 15:47:33', NULL),
(101, 'Oqy6m', 2, 1500.00, 14, 'preparacion', '2024-11-06 15:47:33', NULL),
(102, 'FIJF0', 3, 1250.00, 18, 'preparacion', '2024-11-06 15:48:20', NULL),
(103, 'FIJF0', 4, 5000.00, 16, 'preparacion', '2024-11-06 15:48:20', NULL),
(104, '8dQOc', 3, 1250.00, 3, 'preparacion', '2024-11-06 20:31:09', NULL),
(105, '8dQOc', 4, 5000.00, 2, 'preparacion', '2024-11-06 20:31:09', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(250) NOT NULL,
  `clave` varchar(250) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `fechaBaja` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `clave`, `rol`, `fechaBaja`) VALUES
(1, 'AhoraSeLlamaCoco', '1234', 'cervecero', '2024-11-06'),
(2, 'pedro', 'dasdqsdw2sd23', 'cocinero', NULL),
(3, 'jorge', 'sda2s2f332f2', 'bartender', '2024-11-05'),
(4, 'Pertine', '$2y$10$9da9Jxtr7hWyiFjOB38Lo.w1pEVdsfxqPz1rx5tNX6Na4IZIyXzHi', 'socio', NULL),
(5, 'Martinete', '$2y$10$aUH6/IIMltUEo02DO53U5OpcX3E.9P8vs9s/XYoa5.OEeF6VRBN3q', 'bartender', '2024-10-26'),
(6, 'MozoPepe', '$2y$10$0b2JWuJSOQTuVC04ejQpYulfmZVwFS.4pG69.2yoLxbLOUSvHBimi', 'socio', '2024-10-26'),
(7, 'Juan Carlos', '$2y$10$AGl.4EmzCydnzBFVXAkNEuKnucLy1/7YqJab7CIJGciDllfrD7LLa', 'cocinero', '2024-10-27'),
(8, 'Ruben Patagonia', '$2y$10$Vuu9KRJN/yveY8W5bzAmG.uITrNbrvduF9NDEZT1hPf7DO4HGSoC2', 'cocinero', NULL),
(9, 'Ruben Patagonia', '$2y$10$iTVupn9FvpftYcdJsvVc1uLaX.QXxpjX1WmukJb9OjwnjgiEmlJr6', 'bartender', NULL),
(10, 'Ruben Patagonia', '$2y$10$blR0wLbXnZdOGcaZaDOqUOOazza06XziScC/OXOH9rWkuU3lqETHi', 'mozo', NULL),
(11, 'Ruben Patagonia', '$2y$10$D8h3CX2g92ydL4BzWZrrVOILGFtGDjPfV/g4VU5sKViPCmqbv1AsC', 'cervecero', NULL),
(12, 'Ruben Patagonia', '$2y$10$voRe/275/RxjfYfsX3PUs.TiX5RWIKjAB3aeSkc8DSfixXvsiHOtC', 'cocinero', NULL),
(13, 'Ruben Patagonia', '$2y$10$zL1O2mVeCR/zHBos15Miie9HLubKBgutgyMKlRNxApD3GX1slO65a', 'socio', NULL),
(14, 'Ruben Patagonia', '$2y$10$Htm29cSTcDF14ZF.R5pOau.qWXqfHp3VpF7xcykGao4qSPNpKUNFC', 'cocinero', NULL),
(15, 'Juanete', '$2y$10$BtQMsEc1TM/7hlwI8SZ8VOdy995AIM18bY6cNmXpdG/H76AR5Fk6y', 'cocinero', NULL),
(16, 'Juanete', '$2y$10$7bs88Pu6JVKs9etNmC1fVOGy9n1hmJtCE9UCXUWNKofPAAnC1AZW2', 'cocinero', NULL),
(18, 'Rubencho', '$2y$10$uQDJtocm9ESZ3awHlnEP0e7Fhz8/fFpB13SkgAO5A4AZhsN51IUVi', 'bartender', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_codigo_de_identificacion` (`codigoDeIdentificacion`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_numero_de_pedido` (`numeroDePedido`),
  ADD KEY `fk_codigo_identificacion` (`mesaId`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productosPedidos`
--
ALTER TABLE `productosPedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `numeroDePedido` (`numeroDePedido`),
  ADD KEY `productoId` (`productoId`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `productosPedidos`
--
ALTER TABLE `productosPedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_codigo_identificacion` FOREIGN KEY (`mesaId`) REFERENCES `mesas` (`codigoDeIdentificacion`);

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
