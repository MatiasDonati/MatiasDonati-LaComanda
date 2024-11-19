-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 19-11-2024 a las 05:21:11
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
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id` int(11) NOT NULL,
  `numeroDePedido` varchar(5) NOT NULL,
  `puntuacionMozo` int(11) NOT NULL CHECK (`puntuacionMozo` between 1 and 10),
  `puntuacionRestaurante` int(11) NOT NULL CHECK (`puntuacionRestaurante` between 1 and 10),
  `puntuacionMesa` int(11) NOT NULL CHECK (`puntuacionMesa` between 1 and 10),
  `puntuacionCocinero` int(11) NOT NULL CHECK (`puntuacionCocinero` between 1 and 10),
  `comentarios` varchar(66) DEFAULT NULL,
  `fechaCreacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`id`, `numeroDePedido`, `puntuacionMozo`, `puntuacionRestaurante`, `puntuacionMesa`, `puntuacionCocinero`, `comentarios`, `fechaCreacion`) VALUES
(1, 'MXG7F', 5, 7, 6, 8, 'bueno', '2024-11-17 18:17:02'),
(2, 'MXG7F', 5, 7, 6, 8, 'bueno', '2024-11-17 18:22:59'),
(3, '21O35', 10, 10, 10, 10, 'bueno', '2024-11-17 18:28:59'),
(4, '21O35', 10, 10, 10, 10, 'bueno', '2024-11-18 15:09:42'),
(5, 'FyYyv', 10, 10, 10, 10, 'bueno', '2024-11-19 04:04:49');

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
(1, 'con cliente comiendo', '2024-10-30 20:30:45', 'ab123'),
(2, 'con cliente comiendo', '2024-10-30 20:30:50', 'VUD0Q'),
(3, 'con cliente pagando', '2024-11-12 11:40:01', 'A0W5S'),
(4, 'cerrada', NULL, '69IJX'),
(5, 'cerrada', NULL, 'N7S1L'),
(6, 'sarasa', NULL, 'KRSGL'),
(7, 'sarasa', NULL, 'BICV5'),
(9, 'sarasa', NULL, '123123'),
(10, 'cerrada', NULL, '777'),
(12, 'cerrada', NULL, '999'),
(254, 'con gente morfando', NULL, 'PXUZK'),
(255, 'con cliente comiendo', NULL, 'JK1zv'),
(256, 'con cliente pagando', NULL, 'pUzXG'),
(257, 'cerrada', NULL, 'rqIPA'),
(258, 'sarasa', NULL, 'JlHsU'),
(259, 'sarasa', NULL, '9dOOA'),
(260, 'sarasa', NULL, 'Lg8hq'),
(261, 'sarasa', NULL, 'so9Cl'),
(262, 'cerrada', NULL, 'WbKWc'),
(263, 'cerrada', NULL, 'qHuIM');

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
(1, '69IJX', 'MXG7F', NULL, 'en preparacion', 'db/fotos/MXG7F.jpg', 100.00, '2024-10-27 22:38:03', '2024-10-28 13:18:37', 0.00, 'Romina'),
(2, 'A0W5S', '9QKF6', NULL, 'pidfpi', NULL, 150.00, '2024-10-27 22:38:03', '2024-10-28 13:19:06', 0.00, 'Pepe'),
(3, 'ab123', '9HCZN', NULL, 'en preparacion', NULL, 200.00, '2024-10-27 22:38:03', '2024-11-19 01:43:59', 0.00, 'Carlos'),
(4, 'BICV5', '21O35', NULL, 'en preparacion', NULL, 2250.00, '2024-10-28 00:00:00', NULL, 0.00, 'Carlos'),
(5, 'KRSGL', '65Y3B', NULL, 'en preparacion', NULL, 2250.00, '2024-10-28 00:00:00', NULL, 0.00, 'Carlos'),
(6, 'N7S1L', 'YN22W', NULL, 'en preparacion', NULL, 5000.00, '2024-10-28 00:00:00', NULL, 0.00, 'Carlos'),
(7, 'VUD0Q', 'YV5WT', NULL, 'en preparacion', NULL, 5000.00, '2024-10-30 00:00:00', NULL, 0.00, 'Carlos'),
(17, 'VUD0Q', 'YN22M', NULL, 'en preparacion', NULL, 5000.00, '2024-10-30 00:00:00', NULL, 0.00, 'Carlos'),
(21, 'ab123', 'AAA22', NULL, 'en preparacion', NULL, 5000.00, '2024-10-30 00:00:00', NULL, 0.00, 'Carlos'),
(22, 'ab123', 'BBB12', NULL, 'en preparacion', NULL, 5000.00, '2024-10-30 00:00:00', NULL, 0.00, 'Carlos'),
(23, 'ab123', 'Bfw43', NULL, 'en preparacion', NULL, 5000.00, '2024-10-30 00:00:00', NULL, 0.00, 'Carlos'),
(41, 'ab123', 'taKuv', NULL, 'en preparacion', NULL, 5000.00, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(42, 'ab123', 'r8hcn', NULL, 'en preparacion', NULL, 5000.00, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(43, 'ab123', 'v206G', NULL, 'en preparacion', NULL, 5000.00, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(44, 'ab123', 'BZ39Z', NULL, 'en preparacion', NULL, 5000.00, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(46, 'A0W5S', 'BLxQK', NULL, 'en preparacion', NULL, 5000.00, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(47, 'A0W5S', 'Swl7U', NULL, 'en preparacion', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(48, 'A0W5S', '2gik5', NULL, 'cancelado', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(49, 'A0W5S', 'RBJxY', NULL, 'en preparacion', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(50, 'A0W5S', 'w3E9h', NULL, 'en preparacion', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(51, 'A0W5S', 'jZQr8', NULL, 'en preparacion', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(52, 'A0W5S', '3pc4G', NULL, 'qwe', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(53, 'A0W5S', 'lSezU', NULL, 'en preparacion', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(54, 'A0W5S', 'uv5aq', NULL, 'cancelado', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(55, 'A0W5S', 'VBINy', NULL, 'cancelado', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(56, 'A0W5S', 'dYTL6', NULL, 'en preparacion', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(57, 'A0W5S', 'Hp4Uo', NULL, 'cancelado', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(58, 'A0W5S', 'aIhbo', NULL, 'en preparacion', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(59, 'A0W5S', 'bnuuQ', 30, 'en preparacion', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(60, 'A0W5S', 'WlpVw', 30, 'en preparacion', NULL, 150.50, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(61, 'A0W5S', 'Sxlnh', 30, 'en preparacion', NULL, 99999.00, '2024-10-31 00:00:00', NULL, 0.00, 'Carlos'),
(62, '123123', 'bwDJR', 12, 'en preparacion', NULL, 20000.00, '2024-11-03 00:00:00', NULL, 0.00, 'Carlos'),
(63, '777', 'VVXpk', 12, 'en preparacion', NULL, 20000.00, '2024-11-03 00:00:00', NULL, 0.00, 'Carlos'),
(64, '777', 'eAjaU', 12, 'en preparacion', NULL, 20000.00, '2024-11-04 00:00:00', NULL, 0.00, 'Carlos'),
(65, '777', 'j43ck', 12, 'en preparacion', NULL, 20000.00, '2024-11-04 00:00:00', NULL, 0.00, 'Robenson'),
(66, '777', 'UiIs6', 12, 'en preparacion', NULL, 20000.00, '2024-11-05 00:00:00', NULL, 0.00, 'Robenson'),
(67, '777', 'fDQyU', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(68, '777', '5dGb4', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(69, '777', 'kozxc', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(70, '777', '2BfqX', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(71, '777', '9uMh0', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(72, '777', 'n9wR9', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(73, '777', 'xk1eO', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(74, '777', '7ZJzj', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(75, 'KRSGL', 'ntaDz', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(76, 'KRSGL', 'GNwFJ', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(77, 'KRSGL', '2CT4J', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(78, 'KRSGL', 'mcWii', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(79, 'KRSGL', 'R5S2d', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(80, 'KRSGL', 'orbgg', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(81, 'KRSGL', 'DTKPo', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(82, 'KRSGL', 'ZKw6g', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(83, 'KRSGL', 'aXqE2', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(84, 'KRSGL', 'hTDFj', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(85, 'KRSGL', 'sUiLe', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(86, 'KRSGL', '72DXX', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(87, 'KRSGL', 'eUqQQ', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(88, 'KRSGL', 'r984G', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(89, 'KRSGL', 'g5RNp', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(90, 'KRSGL', 'oSMPt', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(91, 'KRSGL', 'vAF0k', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(92, 'KRSGL', '42ZPT', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(93, 'KRSGL', 'BGfxp', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(94, 'KRSGL', 'aseyN', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(95, 'KRSGL', 'mu6Jw', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(96, 'KRSGL', 'Oqy6m', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(97, 'KRSGL', 'FIJF0', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(98, 'KRSGL', '8dQOc', 12, 'en preparacion', NULL, 20000.00, '2024-11-06 00:00:00', NULL, 0.00, 'Robenson'),
(99, '777', '9ELCd', 12, 'en preparacion', NULL, 20000.00, '2024-11-11 00:00:00', NULL, 0.00, 'Robenson'),
(100, 'KRSGL', 'CLBl5', 12, 'en preparacion', NULL, 20000.00, '2024-11-11 00:00:00', NULL, 0.00, 'Robenson'),
(101, 'KRSGL', 'EFn34', 12, 'en preparacion', NULL, 20000.00, '2024-11-11 00:00:00', NULL, 0.00, 'Robenson'),
(102, 'KRSGL', 'e7Cds', 12, 'en preparacion', NULL, 20000.00, '2024-11-11 00:00:00', NULL, 0.00, 'Robenson'),
(103, 'KRSGL', 'GdJcx', 12, 'en preparacion', NULL, 20000.00, '2024-11-11 00:00:00', NULL, 0.00, 'Robenson'),
(104, 'KRSGL', 'xrdpY', 12, 'en preparacion', NULL, 20000.00, '2024-11-11 00:00:00', NULL, 0.00, 'Robenson'),
(105, 'KRSGL', 'hsogO', 12, 'en preparacion', NULL, 20000.00, '2024-11-11 00:00:00', NULL, 0.00, 'Robenson'),
(106, 'KRSGL', 'xzUIQ', 12, 'en preparacion', NULL, 20000.00, '2024-11-11 00:00:00', NULL, 0.00, 'Robenson'),
(107, 'KRSGL', 'rlPhs', 12, 'en preparacion', NULL, 20000.00, '2024-11-11 00:00:00', NULL, 0.00, 'Robenson'),
(108, 'KRSGL', 'gSnRw', 12, 'en preparacion', NULL, 20000.00, '2024-11-11 00:00:00', NULL, 0.00, 'Robenson'),
(109, '69IJX', 'eWBS9', 5, 'en preparacion', NULL, 4000.00, '2024-11-13 00:00:00', NULL, 0.00, 'Gustavo'),
(110, '69IJX', '2zmKA', 5, 'en preparacion', NULL, 4000.00, '2024-11-14 00:00:00', NULL, 0.00, 'Pepe'),
(111, '69IJX', 'LOmFu', 5, 'pendiente', NULL, 4000.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(112, '69IJX', 'plLpB', 5, 'pendiente', NULL, 4000.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(113, '69IJX', 'lMYph', 5, 'pendiente', NULL, 4000.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(114, '69IJX', 'Bjtgu', 5, 'pendiente', NULL, 4000.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(115, '69IJX', 'CpLjF', 5, 'pendiente', NULL, 4000.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(116, '69IJX', 'HMrwz', 5, 'pendiente', NULL, 4000.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(117, '69IJX', '7pgiy', 5, 'pendiente', NULL, 4000.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(118, '69IJX', 'u2Krn', 5, 'pendiente', NULL, 22.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(119, '69IJX', 'gvqTW', 5, 'pendiente', NULL, 22.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(120, '69IJX', 'uxCf6', 5, 'pendiente', NULL, 22.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(121, '69IJX', 'y7Bi4', 5, 'pendiente', NULL, 22.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(122, '69IJX', '7Zgpo', 5, 'pendiente', NULL, 22.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(123, '69IJX', 'HDfo3', 5, 'pendiente', NULL, 22.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(124, '69IJX', 'zSgus', 5, 'pendiente', NULL, 22.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(125, '69IJX', 'u8ZdB', 5, 'pendiente', NULL, 22.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(126, '69IJX', 'NdZrE', 5, 'pendiente', NULL, 22.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(127, '69IJX', 'mscKI', 5, 'pendiente', NULL, 22.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(128, '69IJX', 'NO16Q', 5, 'pendiente', NULL, 22.00, '2024-11-16 00:00:00', NULL, 0.00, 'Pepe'),
(129, '69IJX', 'JvwvE', 5, 'pendiente', NULL, 22.00, '2024-11-18 00:00:00', NULL, 0.00, 'Pepe'),
(130, '69IJX', 'ZVEQZ', 5, 'pendiente', NULL, 22.00, '2024-11-18 00:00:00', NULL, 0.00, 'Pepe'),
(131, '69IJX', 'ZZFFZ', 5, 'pendiente', NULL, 22.00, '2024-11-18 00:00:00', NULL, 0.00, 'Pepe'),
(132, '69IJX', 'FyYyv', 5, 'pendiente', 'db/fotos/FyYyv.jpg', 22.00, '2024-11-19 00:00:00', NULL, 0.00, 'ClienteDePrueba');

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
(1, 'carne', 'comida', 232.00, '2024-10-28 01:41:57', 'zbd89'),
(2, 'ravioles', 'comida', 1500.00, '2024-10-27 22:57:00', 'STIT7'),
(3, 'vino', 'trago', 1250.00, NULL, 'BO6K1'),
(4, 'fideos', 'comida', 5000.00, NULL, '7MA95'),
(5, 'cerveza', 'cerveza', 5000.00, NULL, 'QYCH6'),
(6, 'hamburguesa', 'comida', 5000.00, NULL, '62J62'),
(7, 'campari', 'trago', 5000.00, NULL, 'FP0O1'),
(8, 'fernet', 'trago', 5000.00, '2024-11-18 14:17:39', NULL),
(9, 'fernet', 'trago', 5000.00, NULL, NULL),
(10, 'fernet', 'trago', 5000.00, NULL, NULL),
(11, 'ipa', 'cerveza', 5000.00, NULL, NULL),
(12, 'redipa', 'cerveza', 5000.00, NULL, NULL),
(13, 'ipas', 'cerveza', 5000.00, NULL, NULL),
(14, 'ipad', 'cerveza', 5000.00, NULL, NULL),
(15, 'ipar', 'cerveza', 5000.00, NULL, NULL),
(16, 'milanesa a caballo', 'comida', 5000.00, NULL, NULL),
(17, 'hamburguesa de garbanzo', 'comida', 5000.00, NULL, NULL),
(18, 'corona', 'cerveza', 4000.00, NULL, NULL),
(19, 'daikiri', 'trago', 4000.00, NULL, NULL);

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
  `tiempoInicial` datetime DEFAULT NULL,
  `tiempoFinal` datetime DEFAULT NULL,
  `tiempoEstimado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productosPedidos`
--

INSERT INTO `productosPedidos` (`id`, `numeroDePedido`, `productoId`, `precio`, `empleadoACargo`, `estado`, `tiempoInicial`, `tiempoFinal`, `tiempoEstimado`) VALUES
(1, 'MXG7F', 1, NULL, NULL, 'listo para servir', '2024-11-18 20:42:00', '2024-11-18 21:01:12', 20),
(2, 'MXG7F', 2, NULL, NULL, 'listo para servir', '2024-11-18 20:42:00', '2024-11-18 21:01:12', 24),
(3, 'dYTL6', 1, NULL, NULL, 'listo para servir', '2024-11-06 13:10:37', '2024-11-18 21:01:12', 12),
(4, 'dYTL6', 4, NULL, NULL, 'listo para servir', '2024-11-06 13:10:37', '2024-11-18 21:01:12', 10),
(5, 'dYTL6', 3, NULL, NULL, 'listo para servir', '2024-11-06 13:10:37', '2024-11-19 00:26:52', 9),
(6, 'dYTL6', 4, NULL, NULL, 'listo para servir', '2024-11-06 13:10:37', '2024-11-18 21:01:12', 12),
(7, 'dYTL6', 4, NULL, NULL, 'listo para servir', '2024-11-06 13:10:37', '2024-11-18 21:01:12', 15),
(8, 'dYTL6', 4, NULL, NULL, 'listo para servir', '2024-11-06 13:10:37', '2024-11-18 21:01:12', 10),
(9, 'dYTL6', 4, NULL, NULL, 'listo para servir', '2024-11-06 13:10:37', '2024-11-18 21:01:12', 8),
(10, 'Hp4Uo', 1, NULL, NULL, 'cancelado', '2024-11-06 11:43:37', NULL, NULL),
(11, 'Hp4Uo', 4, NULL, NULL, 'cancelado', '2024-11-06 11:43:37', NULL, NULL),
(12, 'Hp4Uo', 3, NULL, NULL, 'cancelado', '2024-11-06 11:43:37', NULL, 7),
(13, 'Hp4Uo', 4, NULL, NULL, 'cancelado', '2024-11-06 11:43:37', NULL, NULL),
(15, 'aIhbo', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(16, 'aIhbo', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(17, 'aIhbo', 3, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', NULL, 7),
(18, 'aIhbo', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(19, 'aIhbo', 3, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 16:08:07', 4),
(20, 'aIhbo', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(21, 'aIhbo', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(22, 'bnuuQ', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(23, 'bnuuQ', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(24, 'bnuuQ', 3, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:28', 10),
(25, 'bnuuQ', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(26, 'bnuuQ', 3, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:28', 10),
(27, 'bnuuQ', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(28, 'bnuuQ', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(29, 'WlpVw', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(30, 'WlpVw', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(31, 'WlpVw', 3, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:28', 10),
(32, 'WlpVw', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(33, 'WlpVw', 3, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:28', 10),
(34, 'WlpVw', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(35, 'WlpVw', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(36, 'Sxlnh', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(37, 'Sxlnh', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(38, 'Sxlnh', 3, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:28', 10),
(39, 'Sxlnh', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(40, 'Sxlnh', 3, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:28', 10),
(41, 'Sxlnh', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(42, 'Sxlnh', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(43, 'bwDJR', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(44, 'bwDJR', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(45, 'bwDJR', 3, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:28', 10),
(46, 'bwDJR', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(47, 'bwDJR', 3, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:28', 10),
(48, 'bwDJR', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(49, 'bwDJR', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(50, 'VVXpk', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(51, 'VVXpk', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(52, 'eAjaU', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(53, 'eAjaU', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(54, 'j43ck', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(55, 'j43ck', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', NULL, NULL),
(56, 'UiIs6', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', NULL, NULL),
(57, 'UiIs6', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(58, 'fDQyU', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', NULL, NULL),
(59, 'fDQyU', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(60, '5dGb4', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(61, '5dGb4', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(62, 'kozxc', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(63, 'kozxc', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(64, '2BfqX', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(65, '2BfqX', 4, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(66, 'ntaDz', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(67, 'ntaDz', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(68, 'GNwFJ', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(69, 'GNwFJ', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(70, '2CT4J', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(71, '2CT4J', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(72, 'mcWii', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(73, 'mcWii', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(74, 'R5S2d', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(75, 'R5S2d', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(76, 'orbgg', 1, NULL, NULL, 'cancelado', '2024-11-06 11:43:37', NULL, NULL),
(77, 'orbgg', 2, NULL, NULL, 'cancelado', '2024-11-06 11:43:37', NULL, NULL),
(78, 'ZKw6g', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(79, 'ZKw6g', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(80, '72DXX', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(81, '72DXX', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(82, 'eUqQQ', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(83, 'eUqQQ', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(84, 'r984G', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(85, 'r984G', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(86, 'g5RNp', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(87, 'g5RNp', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(88, 'oSMPt', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(89, 'oSMPt', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(90, 'vAF0k', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(91, 'vAF0k', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(92, '42ZPT', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(93, '42ZPT', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(94, 'BGfxp', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(95, 'BGfxp', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(96, 'aseyN', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(97, 'aseyN', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(98, 'mu6Jw', 1, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(99, 'mu6Jw', 2, NULL, NULL, 'listo para servir', '2024-11-06 11:43:37', '2024-11-18 23:55:10', 10),
(100, 'Oqy6m', 1, 23.00, 14, 'listo para servir', '2024-11-06 15:47:33', '2024-11-18 23:55:10', 10),
(101, 'Oqy6m', 2, 1500.00, 14, 'listo para servir', '2024-11-06 15:47:33', '2024-11-18 23:55:10', 10),
(102, 'FIJF0', 3, 1250.00, 18, 'listo para servir', '2024-11-06 15:48:20', '2024-11-18 23:55:28', 10),
(103, 'FIJF0', 4, 5000.00, 16, 'listo para servir', '2024-11-06 15:48:20', '2024-11-18 23:55:10', 10),
(104, '8dQOc', 3, 1250.00, 3, 'listo para servir', '2024-11-06 20:31:09', '2024-11-18 23:55:28', 10),
(105, '8dQOc', 4, 5000.00, 2, 'listo para servir', '2024-11-06 20:31:09', '2024-11-18 23:55:10', 10),
(106, '9ELCd', NULL, NULL, NULL, 'pendiente', '2024-11-11 00:14:56', NULL, NULL),
(107, '9ELCd', NULL, NULL, NULL, 'pendiente', '2024-11-11 00:14:56', NULL, NULL),
(108, 'CLBl5', 3, 1250.00, 5, 'listo para servir', '2024-11-11 00:15:03', '2024-11-18 23:55:28', 10),
(109, 'CLBl5', 4, 5000.00, 12, 'listo para servir', '2024-11-11 00:15:03', '2024-11-18 23:55:10', 10),
(110, 'EFn34', 3, 1250.00, 3, 'listo para servir', '2024-11-11 00:18:02', '2024-11-18 23:55:28', 10),
(111, 'EFn34', 4, 5000.00, 16, 'listo para servir', '2024-11-11 00:18:02', '2024-11-18 23:55:10', 10),
(112, 'e7Cds', 3, 1250.00, 5, 'listo para servir', '2024-11-11 00:24:21', '2024-11-18 23:55:28', 10),
(113, 'e7Cds', 4, 5000.00, 16, 'listo para servir', '2024-11-11 00:24:21', '2024-11-18 23:55:10', 10),
(114, 'GdJcx', 3, 1250.00, 21, 'listo para servir', '2024-11-11 00:24:28', '2024-11-18 23:55:28', 10),
(115, 'GdJcx', 4, 5000.00, 8, 'listo para servir', '2024-11-11 00:24:28', '2024-11-18 23:55:10', 10),
(116, 'xrdpY', 3, 1250.00, 21, 'listo para servir', '2024-11-11 00:27:15', '2024-11-18 23:55:28', 10),
(117, 'xrdpY', 4, 5000.00, 14, 'listo para servir', '2024-11-11 00:27:15', '2024-11-18 23:55:10', 10),
(118, 'hsogO', 3, 1250.00, 19, 'listo para servir', '2024-11-11 00:27:57', '2024-11-18 23:55:28', 10),
(119, 'hsogO', 4, 5000.00, 2, 'listo para servir', '2024-11-11 00:27:57', '2024-11-18 23:55:10', 10),
(120, 'xzUIQ', 3, 1250.00, 3, 'listo para servir', '2024-11-11 00:28:33', '2024-11-18 23:55:28', 10),
(121, 'xzUIQ', 4, 5000.00, 15, 'listo para servir', '2024-11-11 00:28:33', '2024-11-18 23:55:10', 10),
(122, 'rlPhs', 3, 1250.00, 9, 'listo para servir', '2024-11-11 00:28:48', '2024-11-18 23:55:28', 10),
(123, 'rlPhs', 4, 5000.00, 7, 'listo para servir', '2024-11-11 00:28:48', '2024-11-18 23:55:10', 10),
(124, 'gSnRw', 3, 1250.00, 5, 'listo para servir', '2024-11-11 13:12:08', '2024-11-18 23:55:28', 10),
(125, 'gSnRw', 4, 5000.00, 15, 'listo para servir', '2024-11-11 13:12:08', '2024-11-18 23:55:10', 10),
(126, 'eWBS9', 5, 5000.00, 11, 'listo para servir', '2024-11-13 04:37:16', '2024-11-18 23:55:16', 10),
(127, '2zmKA', 5, 5000.00, 11, 'cancelado', '2024-11-14 03:30:17', NULL, NULL),
(128, 'LOmFu', 5, 5000.00, 11, 'listo para servir', '2024-11-16 15:46:34', '2024-11-18 23:55:16', 10),
(129, 'CpLjF', 5, 5000.00, 1, 'listo para servir', '2024-11-16 15:48:40', '2024-11-18 23:55:16', 10),
(130, '7pgiy', 5, 5000.00, 1, 'listo para servir', '2024-11-16 15:51:27', '2024-11-18 23:55:16', 10),
(131, 'u2Krn', 5, 5000.00, 11, 'listo para servir', '2024-11-16 15:51:38', NULL, NULL),
(132, 'gvqTW', 5, 5000.00, 1, 'listo para servir', '2024-11-16 16:31:54', '2024-11-18 23:55:16', 10),
(133, 'uxCf6', NULL, NULL, NULL, 'pendiente', '2024-11-16 16:32:18', NULL, NULL),
(134, 'y7Bi4', 1, 23.00, 12, 'listo para servir', '2024-11-16 16:32:21', '2024-11-18 23:55:10', 10),
(135, '7Zgpo', 1, 23.00, 14, 'listo para servir', '2024-11-16 16:33:34', '2024-11-18 23:55:10', 10),
(136, 'HDfo3', 5, 5000.00, 11, 'listo para servir', '2024-11-16 16:33:40', '2024-11-18 23:55:16', 10),
(137, 'zSgus', NULL, NULL, NULL, 'pendiente', '2024-11-16 16:33:43', NULL, NULL),
(138, 'u8ZdB', 5, 5000.00, 1, 'listo para servir', '2024-11-16 16:33:45', '2024-11-18 23:55:16', 10),
(139, 'NdZrE', 5, 5000.00, 11, 'listo para servir', '2024-11-16 16:34:13', '2024-11-18 23:55:16', 10),
(140, 'mscKI', 5, 5000.00, 1, 'listo para servir', '2024-11-16 16:37:17', NULL, NULL),
(141, 'NO16Q', 5, 5000.00, 1, 'listo para servir', '2024-11-16 16:37:57', NULL, 12),
(142, 'JvwvE', 5, 5000.00, 11, 'listo para servir', '2024-11-18 16:54:28', '2024-11-18 23:55:16', 10),
(143, 'ZVEQZ', 5, 5000.00, 11, 'listo para servir', '2024-11-18 16:55:36', NULL, NULL),
(144, 'ZZFFZ', 5, 5000.00, 11, 'listo para servir', '2024-11-18 22:11:53', '2024-11-18 23:55:16', 10),
(145, 'FyYyv', 16, 5000.00, 15, 'listo para servir', '2024-11-18 23:40:58', '2024-11-18 23:55:10', 10),
(146, 'FyYyv', 17, 5000.00, 15, 'listo para servir', '2024-11-18 23:40:58', '2024-11-18 23:55:10', 10),
(147, 'FyYyv', 17, 5000.00, 2, 'listo para servir', '2024-11-18 23:40:58', '2024-11-18 23:55:10', 10),
(148, 'FyYyv', 18, 4000.00, 25, 'listo para servir', '2024-11-18 23:40:58', '2024-11-18 23:55:16', 10),
(149, 'FyYyv', 19, 4000.00, 21, 'listo para servir', '2024-11-18 23:40:58', '2024-11-18 23:55:28', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(250) NOT NULL,
  `clave` varchar(250) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `fechaBaja` date DEFAULT NULL,
  `suspendido` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `clave`, `rol`, `fechaBaja`, `suspendido`) VALUES
(1, 'Juan Carlos', '$2y$10$htJa2rUzznC8wEfnldQgMuo.gBcKGgISD4o3eNfTtWnZ8L1fxK/HC', 'bartender', '2024-11-11', 1),
(2, 'pedro', 'dasdqsdw2sd23', 'cocinero', NULL, 1),
(3, 'jorge', 'sda2s2f332f2', 'bartender', '2024-11-05', 0),
(4, 'Pedro', '$2y$10$9da9Jxtr7hWyiFjOB38Lo.w1pEVdsfxqPz1rx5tNX6Na4IZIyXzHi', 'socio', NULL, 0),
(5, 'Martinete', '$2y$10$aUH6/IIMltUEo02DO53U5OpcX3E.9P8vs9s/XYoa5.OEeF6VRBN3q', 'bartender', '2024-10-26', 0),
(6, 'MozoPepe', '$2y$10$0b2JWuJSOQTuVC04ejQpYulfmZVwFS.4pG69.2yoLxbLOUSvHBimi', 'socio', '2024-10-26', 0),
(7, 'Juan Carlos', '$2y$10$AGl.4EmzCydnzBFVXAkNEuKnucLy1/7YqJab7CIJGciDllfrD7LLa', 'cocinero', '2024-10-27', 0),
(8, 'Ruben Patagonia', '$2y$10$Vuu9KRJN/yveY8W5bzAmG.uITrNbrvduF9NDEZT1hPf7DO4HGSoC2', 'cocinero', NULL, 0),
(9, 'Ruben Patagonia', '$2y$10$iTVupn9FvpftYcdJsvVc1uLaX.QXxpjX1WmukJb9OjwnjgiEmlJr6', 'bartender', NULL, 0),
(10, 'Ruben Patagonia', '$2y$10$blR0wLbXnZdOGcaZaDOqUOOazza06XziScC/OXOH9rWkuU3lqETHi', 'mozo', NULL, 0),
(11, 'Ruben Patagonia', '$2y$10$D8h3CX2g92ydL4BzWZrrVOILGFtGDjPfV/g4VU5sKViPCmqbv1AsC', 'cervecero', NULL, 0),
(12, 'Ruben Patagonia', '$2y$10$voRe/275/RxjfYfsX3PUs.TiX5RWIKjAB3aeSkc8DSfixXvsiHOtC', 'cocinero', NULL, 0),
(13, 'Ruben Patagonia', '$2y$10$zL1O2mVeCR/zHBos15Miie9HLubKBgutgyMKlRNxApD3GX1slO65a', 'socio', NULL, 0),
(14, 'Ruben Patagonia', '$2y$10$Htm29cSTcDF14ZF.R5pOau.qWXqfHp3VpF7xcykGao4qSPNpKUNFC', 'cocinero', NULL, 0),
(15, 'Juanete', '$2y$10$BtQMsEc1TM/7hlwI8SZ8VOdy995AIM18bY6cNmXpdG/H76AR5Fk6y', 'cocinero', NULL, 0),
(16, 'Juanete', '$2y$10$7bs88Pu6JVKs9etNmC1fVOGy9n1hmJtCE9UCXUWNKofPAAnC1AZW2', 'cocinero', NULL, 0),
(18, 'Rubencho', '$2y$10$uQDJtocm9ESZ3awHlnEP0e7Fhz8/fFpB13SkgAO5A4AZhsN51IUVi', 'bartender', NULL, 0),
(19, 'Rubencho', '$2y$10$jsgMmeKxK3HX87lRYW0SkOlkdtSizdVv4v6OXzDH4s8W4cxhc9.Qi', 'bartender', NULL, 0),
(20, 'Rubencho', '$2y$10$zItTxGy73bGz5BGaxMYshe0xx4TxKYKExjHyPPxjLBWihxOfCGS.6', 'bartender', NULL, 0),
(21, 'Rubencho', '$2y$10$GliilonMj3qbrQkQbsa6AeFb7DeuqE0Duxo8/0kDzo2gigGXGCqu6', 'bartender', NULL, 0),
(22, 'Rubencho', '$2y$10$gwGi7Nfx0tM0CR6hvBnx0.TeJxnNEdsjesk7lJNGGN5cSMrZUaLoC', 'bartender', NULL, 0),
(23, 'Matias', '$2y$10$8mn0lBiIDwZ0o1KlzCIPounG3QsJVZpvGtUTxId7Uh7K/GuYmqbcm', 'cocinero', NULL, 0),
(24, 'Matias', '$2y$10$bcA4m4o6AncISpHbyPJB3.7TP7w86gBgf9FqbDFdsrU9e4YJ32Uhe', 'cocinero', NULL, 0),
(25, 'MikeArgerich', '$2y$10$s5eSIz6YV/Ew1rB.P7TRmOsEP51h1IlChOfAJITP53Ry.04NkXJj2', 'cervecero', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariosLogs`
--

CREATE TABLE `usuariosLogs` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuariosLogs`
--

INSERT INTO `usuariosLogs` (`id`, `idUsuario`, `timestamp`) VALUES
(1, 1, '2024-11-15 20:00:21'),
(2, 2, '2024-11-17 20:00:21'),
(3, 3, '2024-11-16 20:00:21'),
(4, 4, '2024-11-14 20:00:21'),
(5, 5, '2024-11-13 20:00:21'),
(6, 23, '2024-11-17 20:41:31'),
(7, 24, '2024-11-18 12:48:59'),
(8, 25, '2024-11-18 19:17:13');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_numeroDePedido` (`numeroDePedido`);

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
-- Indices de la tabla `usuariosLogs`
--
ALTER TABLE `usuariosLogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `productosPedidos`
--
ALTER TABLE `productosPedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `usuariosLogs`
--
ALTER TABLE `usuariosLogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD CONSTRAINT `fk_numeroDePedido` FOREIGN KEY (`numeroDePedido`) REFERENCES `pedidos` (`numeroDePedido`);

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

--
-- Filtros para la tabla `usuariosLogs`
--
ALTER TABLE `usuariosLogs`
  ADD CONSTRAINT `usuarioslogs_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
