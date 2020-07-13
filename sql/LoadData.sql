-- --------------------------------------------------------
--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`idcompra`, `idusuario`, `idpublicacion`, `fechaCompra`) VALUES
(1, 13, 3, '2020-07-12');
-- --------------------------------------------------------
--
-- Dumping data for table `locacion`
--

INSERT INTO `locacion` (`idLocacion`, `localidad`, `provincia`, `pais`, `calle`, `numero`) VALUES
(1, 'laferrere', 'bs as', 'argentina', 'av. luro', 1000),
(2, 'san justo', 'bs as', 'argentina', 'j d peron', 2500),
(3, 'moron', 'bs as', 'argentina', 'gallard', 3100);

-- --------------------------------------------------------
--
-- Dumping data for table `editorial`
--

INSERT INTO `editorial` (`ideditorial`, `razonsocial`, `telefono`, `locacion`, `email`, `cuit`) VALUES
(1, 'clarin', '2056-3250', 1, 'clarin@mail.com', '10123456781'),
(2, 'GamesStudio', '6433-5786', 2, 'game@studio.com', '10123456782'),
(3, 'billiken', '8080-3252', 3, 'revista@billiken.com', '10123456783');

-- --------------------------------------------------------
--
-- Dumping data for table `seccion`
--

INSERT INTO `seccion` (`idseccion`, `nombre`) VALUES
(1, 'politica'),
(2, 'economia'),
(3, 'videojuegos'),
(4, 'salud'),
(5, 'cultura');

-- --------------------------------------------------------
--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `dni`, `mail`, `password`, `rol`) VALUES
-- admin@mail.com admin
(1, 'Admin', 'Master', 99999999, 'admin@mail.com', '21232f297a57a5a743894a0e4a801fc3', 'administrador'),
-- usuario@mail.com user
(2, 'Usuario', 'Nivel1', 11111111, 'usuario@mail.com', 'ee11cbb19052e40b07aac0ca060c23ee', 'usuario'),
-- premium@mail.com premium
(3, 'Premium', 'Nivel2', 22222222, 'premium@mail.com', 'a288195832f8717bca4671416014a464', 'usuario'),
-- contenidista@mail.com conte
(4, 'Contenidista', 'Nivel3', 33333333, 'contenidista@mail.com', 'e44c8feaf2e9f09016919a52d9853f68', 'contenidista'),
-- editor1@mail.com editor1
(5, 'Editor', 'deClarin', 33111111, 'editor1@mail.com', '4d9f37cdfda3cf69f8d9f2d03edca2cd', 'contenidista'),
-- editor2@mail.com editor2
(6, 'Editor', 'deGamesStudi', 33222222, 'editor2@mail.com', '0a96c5e164b4f259b4b8f6f565b55fe2', 'contenidista'),
-- editor3@mail.com editor3
(7, 'Editor', 'deBilliken', 33333334, 'editor3@mail.com', '8ae4e8e6f68f3f6cb50817e40111abd6', 'contenidista');

-- --------------------------------------------------------
--
-- Dumping data for table `contenidista`
--

INSERT INTO `contenidista` (`idcontenidista`, `idUsuario`, `editorial`) VALUES
(1, 4, 1),
(2, 5, 1),
(3, 6, 2),
(4, 7, 3);

-- --------------------------------------------------------
--
-- Volcado de datos para la tabla `se_suscribe`
--

INSERT INTO `se_suscribe` (`codigo`, `id_suscripcion`, `id_usuario`, `id_editorial`, `fechaFin`, `fechaInicio`) VALUES
(44, 1, 13, 1, '2020-07-12 17:10:33', '2020-07-12');