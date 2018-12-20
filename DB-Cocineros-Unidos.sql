-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2018 a las 13:41:12
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdcocina` Creada por profesor Cristhian Andrés Moya Bascur
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion`
--

CREATE TABLE `calificacion` (
  `usuario_nombre` varchar(100) NOT NULL,
  `receta_nombre` varchar(100) NOT NULL,
  `valor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `composicion`
--

CREATE TABLE `composicion` (
  `ingrediente_nombre` varchar(40) NOT NULL,
  `receta_nombre` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente`
--

CREATE TABLE `ingrediente` (
  `nombre` varchar(40) NOT NULL,
  `unidad_medida` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta`
--

CREATE TABLE `receta` (
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `creador` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `nombre` varchar(100) NOT NULL,
  `clave` varchar(40) NOT NULL,
  `rol` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD PRIMARY KEY (`usuario_nombre`,`receta_nombre`),
  ADD KEY `fk_usuario_has_receta_receta1_idx` (`receta_nombre`),
  ADD KEY `fk_usuario_has_receta_usuario1_idx` (`usuario_nombre`);

--
-- Indices de la tabla `composicion`
--
ALTER TABLE `composicion`
  ADD PRIMARY KEY (`ingrediente_nombre`,`receta_nombre`),
  ADD KEY `fk_ingrediente_has_receta_receta1_idx` (`receta_nombre`),
  ADD KEY `fk_ingrediente_has_receta_ingrediente_idx` (`ingrediente_nombre`);

--
-- Indices de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`nombre`);

--
-- Indices de la tabla `receta`
--
ALTER TABLE `receta`
  ADD PRIMARY KEY (`nombre`),
  ADD KEY `fk_receta_usuario1_idx` (`creador`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`nombre`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD CONSTRAINT `fk_usuario_has_receta_receta1` FOREIGN KEY (`receta_nombre`) REFERENCES `receta` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_has_receta_usuario1` FOREIGN KEY (`usuario_nombre`) REFERENCES `usuario` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `composicion`
--
ALTER TABLE `composicion`
  ADD CONSTRAINT `fk_ingrediente_has_receta_ingrediente` FOREIGN KEY (`ingrediente_nombre`) REFERENCES `ingrediente` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingrediente_has_receta_receta1` FOREIGN KEY (`receta_nombre`) REFERENCES `receta` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `receta`
--
ALTER TABLE `receta`
  ADD CONSTRAINT `fk_receta_usuario1` FOREIGN KEY (`creador`) REFERENCES `usuario` (`nombre`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;