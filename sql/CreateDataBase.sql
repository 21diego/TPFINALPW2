-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2020 at 05:55 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `editorial`
--

CREATE TABLE `editorial` (
                             `ideditorial` int(11) NOT NULL,
                             `razonsocial` varchar(50) NOT NULL,
                             `telefono` varchar(10) NOT NULL,
                             `locacion` int(11) NOT NULL,
                             `email` varchar(50) NOT NULL,
                             `cuit` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `noticia`
--

CREATE TABLE `noticia` (
                           `idnoticia` int(11) NOT NULL,
                           `titulo` varchar(45) NOT NULL,
                           `cuerpo` varchar(1500) NOT NULL,
                           `imagenUrl` varchar(100) DEFAULT NULL,
                           `enlace` varchar(100) DEFAULT NULL,
                           `editor` int(11) DEFAULT NULL,
                           `seccion` int(11) DEFAULT NULL,
                           `publicacion` int(11) DEFAULT NULL,
                           `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `publicacion`
--

CREATE TABLE `publicacion` (
                               `idpublicacion` int(11) NOT NULL,
                               `nombre` varchar(45) NOT NULL,
                               `numero` int(11) DEFAULT NULL,
                               `categoria` varchar(45) DEFAULT NULL,
                               `valor` double DEFAULT NULL,
                               `adminPublicador` int(11) DEFAULT NULL,
                               `contenidistaEditor` int(11) DEFAULT NULL,
                               `editorial` int(11) DEFAULT NULL,
                               `portada` varchar(45) DEFAULT NULL,
                               `estado` varchar(16) DEFAULT NULL
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

-- --------------------------------------------------------
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contenidista`
--
ALTER TABLE `contenidista`
    MODIFY `idcontenidista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `noticia`
--
ALTER TABLE `noticia`
    MODIFY `idnoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `publicacion`
--
ALTER TABLE `publicacion`
    MODIFY `idpublicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `suscripcion`
--
ALTER TABLE `suscripcion`
    MODIFY `idsuscripcion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
    MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

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
    ADD CONSTRAINT `noticia_ibfk_3` FOREIGN KEY (`seccion`) REFERENCES `seccion` (`idseccion`),
    ADD CONSTRAINT `noticia_ibfk_4` FOREIGN KEY (`publicacion`) REFERENCES `publicacion` (`idpublicacion`);

--
-- Constraints for table `publicacion`
--
ALTER TABLE `publicacion`
    ADD CONSTRAINT `editor` FOREIGN KEY (`contenidistaEditor`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    ADD CONSTRAINT `publicacion_ibfk_1` FOREIGN KEY (`editorial`) REFERENCES `editorial` (`ideditorial`),
    ADD CONSTRAINT `publicador` FOREIGN KEY (`adminPublicador`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
