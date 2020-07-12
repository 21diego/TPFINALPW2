-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-07-2020 a las 23:08:31
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tpintegradorpw2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpublicacion` int(11) NOT NULL,
  `fechaCompra` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idcompra`, `idusuario`, `idpublicacion`, `fechaCompra`) VALUES
(1, 13, 3, '2020-07-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenidista`
--

CREATE TABLE `contenidista` (
  `idcontenidista` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `editorial` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `contenidista`
--

INSERT INTO `contenidista` (`idcontenidista`, `idUsuario`, `editorial`) VALUES
(18, 13, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editorial`
--

CREATE TABLE `editorial` (
  `ideditorial` int(11) NOT NULL,
  `razonsocial` varchar(30) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `locacion` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `cuit` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `editorial`
--

INSERT INTO `editorial` (`ideditorial`, `razonsocial`, `telefono`, `locacion`, `email`, `cuit`) VALUES
(1, 'clarin', '123', 1, 'clarin@mail.com', '10123456781'),
(2, 'planeta', '1234', 1, 'ta@mail.com', '10123456782');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locacion`
--

CREATE TABLE `locacion` (
  `idLocacion` int(11) NOT NULL,
  `localidad` varchar(45) NOT NULL,
  `provincia` varchar(45) NOT NULL,
  `pais` varchar(45) NOT NULL,
  `calle` varchar(45) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `locacion`
--

INSERT INTO `locacion` (`idLocacion`, `localidad`, `provincia`, `pais`, `calle`, `numero`) VALUES
(1, 'lafe', 'bs as', 'arg', 'luro', 1000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `idnoticia` int(11) NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `cuerpo` varchar(300) NOT NULL,
  `imagenUrl` varchar(100) DEFAULT NULL,
  `enlace` varchar(100) NOT NULL,
  `editor` int(11) DEFAULT NULL,
  `seccion` int(11) DEFAULT NULL,
  `publicacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE `publicacion` (
  `idpublicacion` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `numero` int(11) NOT NULL,
  `categoria` varchar(45) DEFAULT NULL,
  `valor` double NOT NULL,
  `adminPublicador` int(11) NOT NULL,
  `contenidistaEditor` int(11) NOT NULL,
  `editorial` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`idpublicacion`, `nombre`, `numero`, `categoria`, `valor`, `adminPublicador`, `contenidistaEditor`, `editorial`) VALUES
(3, 'la peleona', 1, NULL, 500, 8, 13, 1),
(4, 'tiki tiki', 1, NULL, 500, 8, 13, 1),
(5, 'zero dawn', 1, NULL, 500, 8, 13, 1),
(6, 'gran soldador', 1, '', 300, 8, 13, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibo`
--

CREATE TABLE `recibo` (
  `idrecibo` int(11) NOT NULL,
  `suscripcionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `idseccion` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`idseccion`, `nombre`) VALUES
(1, 'politica'),
(2, 'economia'),
(3, 'videojuegos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `se_suscribe`
--

CREATE TABLE `se_suscribe` (
  `codigo` int(11) NOT NULL,
  `id_suscripcion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_editorial` int(11) NOT NULL,
  `fechaFin` datetime NOT NULL,
  `fechaInicio` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `se_suscribe`
--

INSERT INTO `se_suscribe` (`codigo`, `id_suscripcion`, `id_usuario`, `id_editorial`, `fechaFin`, `fechaInicio`) VALUES
(44, 1, 13, 1, '2020-07-12 17:10:33', '2020-07-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscripcion`
--

CREATE TABLE `suscripcion` (
  `idsuscripcion` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `valor` double NOT NULL,
  `meses` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `suscripcion`
--

INSERT INTO `suscripcion` (`idsuscripcion`, `nombre`, `valor`, `meses`) VALUES
(1, 'trimestral', 300, 3),
(2, 'semestral', 500, 6),
(3, 'anual', 800, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(12) NOT NULL,
  `apellido` varchar(12) NOT NULL,
  `dni` int(8) NOT NULL,
  `mail` varchar(90) NOT NULL,
  `password` varchar(32) NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `dni`, `mail`, `password`, `rol`) VALUES
(8, 'admin', 'admin', 99999999, 'admin@mail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(12, 'usuario', 'user', 1234, 'usuario@mail.com', 'f8032d5cae3de20fcec887f395ec9a6a', 'usuario'),
(13, 'contenidista', 'content', 1234, 'contenidista@mail.com', 'e44c8feaf2e9f09016919a52d9853f68', 'contenidista'),
(14, 'diego', 'mori', 3937, 'mori@mail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`),
  ADD KEY `publicacionCompra` (`idpublicacion`),
  ADD KEY `usuarioCompra` (`idusuario`);

--
-- Indices de la tabla `contenidista`
--
ALTER TABLE `contenidista`
  ADD PRIMARY KEY (`idcontenidista`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `editorial` (`editorial`);

--
-- Indices de la tabla `editorial`
--
ALTER TABLE `editorial`
  ADD PRIMARY KEY (`ideditorial`),
  ADD KEY `locacion` (`locacion`);

--
-- Indices de la tabla `locacion`
--
ALTER TABLE `locacion`
  ADD PRIMARY KEY (`idLocacion`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`idnoticia`),
  ADD KEY `editorNoticia` (`editor`),
  ADD KEY `seccion` (`seccion`),
  ADD KEY `publicacion` (`publicacion`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`idpublicacion`),
  ADD KEY `publicador` (`adminPublicador`),
  ADD KEY `editor` (`contenidistaEditor`),
  ADD KEY `editorial` (`editorial`);

--
-- Indices de la tabla `recibo`
--
ALTER TABLE `recibo`
  ADD PRIMARY KEY (`idrecibo`),
  ADD KEY `susc` (`suscripcionId`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`idseccion`);

--
-- Indices de la tabla `se_suscribe`
--
ALTER TABLE `se_suscribe`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `suscripcion` (`id_suscripcion`),
  ADD KEY `usuarioSuscripcion` (`id_usuario`),
  ADD KEY `editorialSuscripcion` (`id_editorial`);

--
-- Indices de la tabla `suscripcion`
--
ALTER TABLE `suscripcion`
  ADD PRIMARY KEY (`idsuscripcion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `contenidista`
--
ALTER TABLE `contenidista`
  MODIFY `idcontenidista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `editorial`
--
ALTER TABLE `editorial`
  MODIFY `ideditorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `locacion`
--
ALTER TABLE `locacion`
  MODIFY `idLocacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `idnoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `idpublicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `recibo`
--
ALTER TABLE `recibo`
  MODIFY `idrecibo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seccion`
--
ALTER TABLE `seccion`
  MODIFY `idseccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `se_suscribe`
--
ALTER TABLE `se_suscribe`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `suscripcion`
--
ALTER TABLE `suscripcion`
  MODIFY `idsuscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `publicacionCompra` FOREIGN KEY (`idpublicacion`) REFERENCES `publicacion` (`idpublicacion`),
  ADD CONSTRAINT `usuarioCompra` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `contenidista`
--
ALTER TABLE `contenidista`
  ADD CONSTRAINT `contenidista_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `contenidista_ibfk_2` FOREIGN KEY (`editorial`) REFERENCES `editorial` (`ideditorial`);

--
-- Filtros para la tabla `editorial`
--
ALTER TABLE `editorial`
  ADD CONSTRAINT `editorial_ibfk_1` FOREIGN KEY (`locacion`) REFERENCES `locacion` (`idLocacion`);

--
-- Filtros para la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD CONSTRAINT `editorNoticia` FOREIGN KEY (`editor`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `noticia_ibfk_3` FOREIGN KEY (`seccion`) REFERENCES `seccion` (`idseccion`),
  ADD CONSTRAINT `noticia_ibfk_4` FOREIGN KEY (`publicacion`) REFERENCES `publicacion` (`idpublicacion`);

--
-- Filtros para la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD CONSTRAINT `editor` FOREIGN KEY (`contenidistaEditor`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `publicacion_ibfk_1` FOREIGN KEY (`editorial`) REFERENCES `editorial` (`ideditorial`),
  ADD CONSTRAINT `publicador` FOREIGN KEY (`adminPublicador`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `recibo`
--
ALTER TABLE `recibo`
  ADD CONSTRAINT `susc` FOREIGN KEY (`suscripcionId`) REFERENCES `suscripcion` (`idsuscripcion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `se_suscribe`
--
ALTER TABLE `se_suscribe`
  ADD CONSTRAINT `editorialSuscripcion` FOREIGN KEY (`id_editorial`) REFERENCES `editorial` (`ideditorial`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `suscripcion` FOREIGN KEY (`id_suscripcion`) REFERENCES `suscripcion` (`idsuscripcion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuarioSuscripcion` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
