-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2020 at 09:59 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tpintegradorpw2`
--

-- --------------------------------------------------------

--
-- Table structure for table `contenidista`
--

CREATE TABLE `contenidista` (
  `idcontenidista` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `editorial` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contenidista`
--

INSERT INTO `contenidista` (`idcontenidista`, `idUsuario`, `editorial`) VALUES
(16, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `editorial`
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
-- Dumping data for table `editorial`
--

INSERT INTO `editorial` (`ideditorial`, `razonsocial`, `telefono`, `locacion`, `email`, `cuit`) VALUES
(1, 'clarin', '123', 1, 'clarin@mail.com', '10123456781');

-- --------------------------------------------------------

--
-- Table structure for table `locacion`
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
-- Dumping data for table `locacion`
--

INSERT INTO `locacion` (`idLocacion`, `localidad`, `provincia`, `pais`, `calle`, `numero`) VALUES
(1, 'lafe', 'bs as', 'arg', 'luro', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `noticia`
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

--
-- Dumping data for table `noticia`
--

INSERT INTO `noticia` (`idnoticia`, `titulo`, `cuerpo`, `imagenUrl`, `enlace`, `editor`, `seccion`, `publicacion`) VALUES
(2, 'titulo', 'cuepo de la noticia', 'img-WGrawYK1ExXjLQ3oUvdg.jpeg', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `publicacion`
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

-- --------------------------------------------------------

--
-- Table structure for table `recibo`
--

CREATE TABLE `recibo` (
  `idrecibo` int(11) NOT NULL,
  `suscripcionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `seccion`
--

CREATE TABLE `seccion` (
  `idseccion` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `suscripcion`
--

CREATE TABLE `suscripcion` (
  `idsuscripcion` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `valor` double NOT NULL,
  `fechaFin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
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
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `dni`, `mail`, `password`, `rol`) VALUES
(8, 'admin', 'admin', 99999999, 'admin@mail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(12, 'usuario', 'user', 1234, 'usuario@mail.com', 'f8032d5cae3de20fcec887f395ec9a6a', 'usuario'),
(13, 'contenidista', 'content', 1234, 'contenidista@mail.com', 'e44c8feaf2e9f09016919a52d9853f68', 'contenidista'),
(14, 'diego', 'mori', 3937, 'mori@mail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'usuario');

-- --------------------------------------------------------

--
-- Table structure for table `vive_en`
--

CREATE TABLE `vive_en` (
  `idvive_en` int(11) NOT NULL,
  `locacionId` int(11) NOT NULL,
  `usuarioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contenidista`
--
ALTER TABLE `contenidista`
  ADD PRIMARY KEY (`idcontenidista`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `editorial` (`editorial`);

--
-- Indexes for table `editorial`
--
ALTER TABLE `editorial`
  ADD PRIMARY KEY (`ideditorial`),
  ADD KEY `locacion` (`locacion`);

--
-- Indexes for table `locacion`
--
ALTER TABLE `locacion`
  ADD PRIMARY KEY (`idLocacion`);

--
-- Indexes for table `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`idnoticia`),
  ADD KEY `editorNoticia` (`editor`),
  ADD KEY `seccion` (`seccion`),
  ADD KEY `publicacion` (`publicacion`);

--
-- Indexes for table `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`idpublicacion`),
  ADD KEY `publicador` (`adminPublicador`),
  ADD KEY `editor` (`contenidistaEditor`),
  ADD KEY `editorial` (`editorial`);

--
-- Indexes for table `recibo`
--
ALTER TABLE `recibo`
  ADD PRIMARY KEY (`idrecibo`),
  ADD KEY `susc` (`suscripcionId`);

--
-- Indexes for table `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`idseccion`);

--
-- Indexes for table `suscripcion`
--
ALTER TABLE `suscripcion`
  ADD PRIMARY KEY (`idsuscripcion`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indexes for table `vive_en`
--
ALTER TABLE `vive_en`
  ADD PRIMARY KEY (`idvive_en`),
  ADD KEY `locacion` (`locacionId`),
  ADD KEY `usuario` (`usuarioId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contenidista`
--
ALTER TABLE `contenidista`
  MODIFY `idcontenidista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `editorial`
--
ALTER TABLE `editorial`
  MODIFY `ideditorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `locacion`
--
ALTER TABLE `locacion`
  MODIFY `idLocacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `noticia`
--
ALTER TABLE `noticia`
  MODIFY `idnoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suscripcion`
--
ALTER TABLE `suscripcion`
  MODIFY `idsuscripcion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contenidista`
--
ALTER TABLE `contenidista`
  ADD CONSTRAINT `contenidista_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `contenidista_ibfk_2` FOREIGN KEY (`editorial`) REFERENCES `editorial` (`ideditorial`);

--
-- Constraints for table `editorial`
--
ALTER TABLE `editorial`
  ADD CONSTRAINT `editorial_ibfk_1` FOREIGN KEY (`locacion`) REFERENCES `locacion` (`idLocacion`);

--
-- Constraints for table `noticia`
--
ALTER TABLE `noticia`
  ADD CONSTRAINT `editorNoticia` FOREIGN KEY (`editor`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `noticia_ibfk_1` FOREIGN KEY (`seccion`) REFERENCES `seccion` (`idseccion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `noticia_ibfk_2` FOREIGN KEY (`publicacion`) REFERENCES `publicacion` (`idpublicacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `publicacion`
--
ALTER TABLE `publicacion`
  ADD CONSTRAINT `editor` FOREIGN KEY (`contenidistaEditor`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `publicacion_ibfk_1` FOREIGN KEY (`editorial`) REFERENCES `editorial` (`ideditorial`),
  ADD CONSTRAINT `publicador` FOREIGN KEY (`adminPublicador`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `recibo`
--
ALTER TABLE `recibo`
  ADD CONSTRAINT `susc` FOREIGN KEY (`suscripcionId`) REFERENCES `suscripcion` (`idsuscripcion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `vive_en`
--
ALTER TABLE `vive_en`
  ADD CONSTRAINT `locacion` FOREIGN KEY (`locacionId`) REFERENCES `locacion` (`idLocacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
