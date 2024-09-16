-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-09-2024 a las 04:37:03
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
-- Base de datos: `vehiculos-db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `ID_Marca` int(11) NOT NULL,
  `Marca` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`ID_Marca`, `Marca`) VALUES
(1, 'Volkswagen'),
(2, 'Ford'),
(3, 'Fiat'),
(4, 'Honda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `ID_Marca` int(11) NOT NULL,
  `ID_Auto` int(11) NOT NULL,
  `Modelo` varchar(20) NOT NULL,
  `Motor` varchar(20) NOT NULL,
  `Combustible` varchar(20) NOT NULL,
  `Transmisión` varchar(20) NOT NULL,
  `Tipo de Vehiculo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`ID_Marca`, `ID_Auto`, `Modelo`, `Motor`, `Combustible`, `Transmisión`, `Tipo de Vehiculo`) VALUES
(1, 1, 'Bora', '1.8t (ROJA)', 'Nafta', 'Manual', 'Sedan'),
(1, 2, 'Golf MK4', 'VR6', 'Nafta', 'Manual', 'Sedan'),
(2, 3, 'Focus', '2.0 Zetec', 'Nafta', 'Manual', 'Sedan'),
(2, 4, 'Escort', '2.0 Zetec', 'Nafta', 'Manual', 'Coupe'),
(3, 5, 'Uno', '1.6', 'Nafta', 'Manual', 'Hatchback'),
(3, 6, 'Duna', '1.7', 'Diesel', 'Manual', 'Hatchback'),
(4, 7, 'Civic VTI', '1.6 Vtec', 'Nafta', 'Manual', 'Coupe'),
(4, 8, 'CR-V', '2.4', 'Diesel', 'Automatica', '4x4');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`ID_Marca`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`ID_Auto`),
  ADD KEY `ID_Marca` (`ID_Marca`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `modelos`
--
ALTER TABLE `modelos`
  MODIFY `ID_Auto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD CONSTRAINT `modelos_ibfk_1` FOREIGN KEY (`ID_Marca`) REFERENCES `marcas` (`ID_Marca`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
