-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 29-10-2024 a las 04:27:06
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
(1, 'AhoraSeLlamaCoco', '1234', '', '2024-10-26'),
(2, 'pedro', 'dasdqsdw2sd23', '', NULL),
(3, 'jorge', 'sda2s2f332f2', '', NULL),
(4, 'Pertine', '$2y$10$9da9Jxtr7hWyiFjOB38Lo.w1pEVdsfxqPz1rx5tNX6Na4IZIyXzHi', '', NULL),
(5, 'Martinete', '$2y$10$aUH6/IIMltUEo02DO53U5OpcX3E.9P8vs9s/XYoa5.OEeF6VRBN3q', '', '2024-10-26'),
(6, 'MozoPepe', '$2y$10$0b2JWuJSOQTuVC04ejQpYulfmZVwFS.4pG69.2yoLxbLOUSvHBimi', 'Mozo', '2024-10-26'),
(7, 'PepitoPepiton', '$2y$10$SYXI17ZwoI9BAzAwrsmbZO5P.X.PEwqEZfcGW1o7fJxY/n/r/v2eq', 'Mozo', '2024-10-27');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
