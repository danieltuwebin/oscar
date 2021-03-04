-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-03-2020 a las 11:29:07
-- Versión del servidor: 10.2.31-MariaDB-cll-lve
-- Versión de PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `demosistema_demo`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE PROCEDURE `DECO_ACTUALIZAR_STOCK_ARTICULOS` (IN `Pint_Articulo` INT, IN `pflo_Cantidad` FLOAT)  BEGIN
UPDATE articulo SET stock = (stock - pflo_Cantidad) WHERE idarticulo = Pint_Articulo;
END$$

CREATE PROCEDURE `DECO_LISTAR_ARTICULOS_PRODUCIDOS` ()  BEGIN
SELECT tap.idarticuloproduccion,
CASE WHEN LENGTH(tap.idarticuloproduccion) = 1 THEN CONCAT('000' , tap.idarticuloproduccion)
WHEN LENGTH(tap.idarticuloproduccion) = 2 THEN CONCAT('00' , tap.idarticuloproduccion)
WHEN LENGTH(tap.idarticuloproduccion) = 3 THEN CONCAT('0' , tap.idarticuloproduccion)
ELSE tap.idarticuloproduccion END AS codarticuloproduccion,
CASE WHEN LENGTH(tap.idarticulo) = 1 THEN CONCAT('000' , tap.idarticulo)
WHEN LENGTH(tap.idarticulo) = 2 THEN CONCAT('00' , tap.idarticulo)
WHEN LENGTH(tap.idarticulo) = 3 THEN CONCAT('0' , tap.idarticulo)
ELSE tap.idarticulo END AS codidarticulo,
ta.nombre,tap.observacion,usu.nombre as usuario,tap.fecha_grabacion
           FROM articulo_produccion tap LEFT JOIN articulo ta ON tap.idarticulo = ta.idarticulo
           LEFT JOIN usuario usu ON tap.usuario = usu.idusuario
           ORDER BY tap.idarticuloproduccion DESC;
END$$

CREATE PROCEDURE `USP_DECO_ACTUALIZAR_STOCK_ANULAR_INGRESO` (IN `pint_idingreso` INT)  NO SQL
BEGIN
	DECLARE var_idarticulo INT;
	DECLARE var_cantidad DECIMAL(11,2);
	DECLARE done INT DEFAULT FALSE;
	DECLARE cur CURSOR FOR 
	SELECT D.idarticulo, D.cantidad 
	FROM detalle_ingreso D
	WHERE D.idingreso=pint_idingreso;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;	
	SET SQL_SAFE_UPDATES = 0;
	OPEN cur;
		REPEAT
		FETCH cur INTO var_idarticulo, var_cantidad;
			IF NOT done THEN
				UPDATE articulo SET stock = (stock - var_cantidad) WHERE idarticulo = var_idarticulo;			
			END IF;				
		UNTIL DONE END REPEAT; 
	CLOSE cur;			
END$$

CREATE PROCEDURE `USP_DECO_ACTUALIZAR_STOCK_ANULAR_PRODUCCION` (IN `pint_idproduccion` INT)  NO SQL
BEGIN
	DECLARE var_idarticulo INT;
	DECLARE var_cantidad DECIMAL(11,2);
	DECLARE var_condicionp VARCHAR(20);
	DECLARE done INT DEFAULT FALSE;
	DECLARE cur CURSOR FOR 
	SELECT D.idarticulo, D.cantidad, P.condicionp 
	FROM detalle_produccion D 
	INNER JOIN produccion P ON D.idproduccion = P.idproduccion
	WHERE D.idproduccion=pint_idproduccion;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;	
	SET SQL_SAFE_UPDATES = 0;
	OPEN cur;
		REPEAT
		FETCH cur INTO var_idarticulo, var_cantidad, var_condicionp;
			IF NOT done THEN
				IF (SUBSTRING(var_condicionp, 1, 3)="Pro") THEN
					UPDATE articulo SET stock = (stock + var_cantidad) WHERE idarticulo = var_idarticulo;
				END IF;				
			END IF;				
		UNTIL DONE END REPEAT; 
	CLOSE cur;			
END$$

CREATE PROCEDURE `USP_DECO_ACTUALIZAR_STOCK_ANULAR_VENTA` (IN `pint_idventa` INT)  NO SQL
BEGIN
	DECLARE var_idarticulo INT;
	DECLARE var_cantidad DECIMAL(11,2);
	DECLARE done INT DEFAULT FALSE;
	DECLARE cur CURSOR FOR 
	SELECT D.idarticulo, D.cantidad 
	FROM detalle_venta D
	WHERE D.idventa=pint_idventa;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;	
	SET SQL_SAFE_UPDATES = 0;
	OPEN cur;
		REPEAT
		FETCH cur INTO var_idarticulo, var_cantidad;
			IF NOT done THEN
				UPDATE articulo SET stock = (stock + var_cantidad) WHERE idarticulo = var_idarticulo;			
			END IF;				
		UNTIL DONE END REPEAT; 
	CLOSE cur;			
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `idarticulo` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `stock` float NOT NULL,
  `medida` varchar(10) DEFAULT NULL,
  `presentacion` varchar(10) NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0-desact : 1-activ',
  `condicion_prod` int(11) NOT NULL COMMENT '0: comprado - 1: producido '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo_bk_030220`
--

CREATE TABLE `articulo_bk_030220` (
  `idarticulo` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `stock` float NOT NULL,
  `medida` varchar(10) DEFAULT NULL,
  `presentacion` varchar(10) NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo_produccion`
--

CREATE TABLE `articulo_produccion` (
  `idarticuloproduccion` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `observacion` varchar(100) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `fecha_grabacion` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo_produccion_detalle`
--

CREATE TABLE `articulo_produccion_detalle` (
  `idarticuloproducciondetalle` int(11) NOT NULL,
  `idarticuloproduccion` int(11) NOT NULL,
  `codarticulo` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `fecha_grabacion` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `ruc` varchar(12) NOT NULL,
  `razon_social` varchar(300) NOT NULL,
  `nombre_comercial` varchar(300) NOT NULL,
  `direccion` varchar(300) NOT NULL,
  `departamento` varchar(300) NOT NULL,
  `provincia` varchar(300) NOT NULL,
  `distrito` varchar(300) NOT NULL,
  `codpais` varchar(100) NOT NULL,
  `ubigeo` varchar(100) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `correo` varchar(300) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `firma` varchar(200) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL,
  `web` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_guia`
--

CREATE TABLE `detalle_guia` (
  `iddetalle_guia` int(11) NOT NULL,
  `idguia` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` decimal(11,2) NOT NULL,
  `peso_bulto` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingreso`
--

CREATE TABLE `detalle_ingreso` (
  `iddetalle_ingreso` int(11) NOT NULL,
  `idingreso` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` decimal(11,2) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Disparadores `detalle_ingreso`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockIngreso` AFTER INSERT ON `detalle_ingreso` FOR EACH ROW BEGIN
 UPDATE articulo SET stock = stock + NEW.cantidad 
 WHERE articulo.idarticulo = NEW.idarticulo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_produccion`
--

CREATE TABLE `detalle_produccion` (
  `iddetalle_produccion` int(11) NOT NULL,
  `idproduccion` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `iddetalle_venta` int(11) NOT NULL,
  `idventa` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guia_remision`
--

CREATE TABLE `guia_remision` (
  `idguia` int(11) NOT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `num_guia` varchar(15) DEFAULT NULL,
  `fecha_emision` datetime DEFAULT NULL,
  `fecha_traslado` datetime DEFAULT NULL,
  `domi_partida` varchar(100) DEFAULT NULL,
  `domi_llegada` varchar(100) DEFAULT NULL,
  `marca_placa` varchar(25) NOT NULL,
  `certi_inscripcion` varchar(20) NOT NULL,
  `lic_conducir` varchar(20) NOT NULL,
  `rason_transportista` varchar(50) NOT NULL,
  `ruc_transportista` varchar(11) NOT NULL,
  `doc_pago` varchar(25) NOT NULL,
  `num_doc_pago` varchar(15) NOT NULL,
  `motivo_traslado` varchar(20) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

CREATE TABLE `ingreso` (
  `idingreso` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `condicioni` varchar(20) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_emision` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `moneda` varchar(20) NOT NULL,
  `fecha_vencimiento` datetime NOT NULL,
  `total_compra` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL,
  `tipo_persona` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  `num_documento` varchar(20) DEFAULT NULL,
  `contacto` varchar(50) DEFAULT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion`
--

CREATE TABLE `produccion` (
  `idproduccion` int(11) NOT NULL,
  `idarticuloproduccion` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `condicionp` varchar(20) NOT NULL,
  `moneda` varchar(20) NOT NULL,
  `nomb_produccion` varchar(150) NOT NULL,
  `num_prod` varchar(15) NOT NULL,
  `med_ancho` int(11) NOT NULL DEFAULT 0,
  `med_alto` int(11) NOT NULL DEFAULT 0,
  `fecha_produccion` date NOT NULL,
  `ipu_produccion` decimal(11,2) NOT NULL,
  `total_produccion` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion_bk_010220`
--

CREATE TABLE `produccion_bk_010220` (
  `idproduccion` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `condicionp` varchar(20) NOT NULL,
  `moneda` varchar(20) NOT NULL,
  `nomb_produccion` varchar(150) NOT NULL,
  `num_prod` varchar(15) NOT NULL,
  `fecha_produccion` date NOT NULL,
  `ipu_produccion` decimal(11,2) NOT NULL,
  `total_produccion` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `num_documento` varchar(20) NOT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cargo` varchar(20) DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `clave` varchar(64) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `cargo`, `login`, `clave`, `imagen`, `condicion`) VALUES
(1, 'User Demo', 'DNI', '12345678', 'xxx', '956055656', 'micorreo@tuwebin.com', 'Ing. de Sistemas', 'demosistema', '09c127817641d09a70ef573b3092fb9126a2a1ab0afafe25e429fabe3f8f0b55', 'user.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(10, 4, 1),
(11, 4, 2),
(12, 4, 3),
(13, 4, 4),
(14, 4, 5),
(15, 4, 6),
(16, 4, 7),
(17, 4, 8),
(18, 4, 9),
(32, 6, 1),
(33, 6, 2),
(34, 5, 1),
(35, 5, 2),
(36, 5, 3),
(37, 5, 4),
(38, 5, 5),
(39, 5, 6),
(40, 5, 7),
(41, 5, 8),
(42, 5, 9),
(44, 4, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_permiso_old`
--

CREATE TABLE `usuario_permiso_old` (
  `idusuario_permiso` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `condicionv` varchar(10) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `guia_remi` varchar(15) NOT NULL,
  `fecha_emision` datetime NOT NULL,
  `fecha_vencimiento` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `nroorden` varchar(100) NOT NULL,
  `obra` varchar(100) NOT NULL,
  `total_venta` decimal(11,2) NOT NULL,
  `moneda` varchar(20) NOT NULL,
  `tipo_cambio` decimal(11,2) NOT NULL,
  `total_soles` decimal(11,2) NOT NULL,
  `hash_cpe` varchar(300) NOT NULL,
  `hash_cdr` varchar(300) NOT NULL,
  `mensaje` text NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`idarticulo`),
  ADD KEY `fk_articulo_categoria_idx` (`idcategoria`);

--
-- Indices de la tabla `articulo_bk_030220`
--
ALTER TABLE `articulo_bk_030220`
  ADD PRIMARY KEY (`idarticulo`),
  ADD KEY `fk_articulo_categoria_idx` (`idcategoria`);

--
-- Indices de la tabla `articulo_produccion`
--
ALTER TABLE `articulo_produccion`
  ADD PRIMARY KEY (`idarticuloproduccion`);

--
-- Indices de la tabla `articulo_produccion_detalle`
--
ALTER TABLE `articulo_produccion_detalle`
  ADD PRIMARY KEY (`idarticuloproducciondetalle`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indices de la tabla `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_guia`
--
ALTER TABLE `detalle_guia`
  ADD PRIMARY KEY (`iddetalle_guia`),
  ADD KEY `fk_detalle_guia_guia_remision` (`idguia`),
  ADD KEY `fk_detalle_guia_articulo` (`idarticulo`) USING BTREE;

--
-- Indices de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD PRIMARY KEY (`iddetalle_ingreso`),
  ADD KEY `fk_detalle_ingreso_ingreso_idx` (`idingreso`),
  ADD KEY `fk_detalle_ingreso_articulo_idx` (`idarticulo`);

--
-- Indices de la tabla `detalle_produccion`
--
ALTER TABLE `detalle_produccion`
  ADD PRIMARY KEY (`iddetalle_produccion`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`iddetalle_venta`),
  ADD KEY `fk_detalle_venta_articulo` (`idarticulo`);

--
-- Indices de la tabla `guia_remision`
--
ALTER TABLE `guia_remision`
  ADD PRIMARY KEY (`idguia`),
  ADD KEY `fk_guia_remision_persona` (`idcliente`),
  ADD KEY `fk_guia_remision_usuario` (`idusuario`);

--
-- Indices de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`idingreso`),
  ADD KEY `fk_ingreso_persona_idx` (`idproveedor`),
  ADD KEY `fk_ingreso_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indices de la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD PRIMARY KEY (`idproduccion`);

--
-- Indices de la tabla `produccion_bk_010220`
--
ALTER TABLE `produccion_bk_010220`
  ADD PRIMARY KEY (`idproduccion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `login_UNIQUE` (`login`);

--
-- Indices de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`idusuario_permiso`),
  ADD KEY `fk_usuario_permiso_permiso_idx` (`idpermiso`),
  ADD KEY `fk_usuario_permiso_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `usuario_permiso_old`
--
ALTER TABLE `usuario_permiso_old`
  ADD PRIMARY KEY (`idusuario_permiso`),
  ADD KEY `fk_usuario_permiso_permiso_idx` (`idpermiso`),
  ADD KEY `fk_usuario_permiso_usuario_idx` (`idusuario`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `idarticulo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `articulo_bk_030220`
--
ALTER TABLE `articulo_bk_030220`
  MODIFY `idarticulo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `articulo_produccion`
--
ALTER TABLE `articulo_produccion`
  MODIFY `idarticuloproduccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `articulo_produccion_detalle`
--
ALTER TABLE `articulo_produccion_detalle`
  MODIFY `idarticuloproducciondetalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_guia`
--
ALTER TABLE `detalle_guia`
  MODIFY `iddetalle_guia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  MODIFY `iddetalle_ingreso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_produccion`
--
ALTER TABLE `detalle_produccion`
  MODIFY `iddetalle_produccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `guia_remision`
--
ALTER TABLE `guia_remision`
  MODIFY `idguia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `idingreso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `produccion`
--
ALTER TABLE `produccion`
  MODIFY `idproduccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `produccion_bk_010220`
--
ALTER TABLE `produccion_bk_010220`
  MODIFY `idproduccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
