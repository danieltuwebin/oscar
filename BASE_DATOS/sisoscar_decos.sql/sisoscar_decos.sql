-- MySQL dump 10.16  Distrib 10.2.36-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: sisoscar_decos
-- ------------------------------------------------------
-- Server version	10.2.36-MariaDB-cll-lve

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `articulo`
--

DROP TABLE IF EXISTS `articulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulo` (
  `idarticulo` int(11) NOT NULL AUTO_INCREMENT,
  `idcategoria` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `stock` float NOT NULL,
  `medida` varchar(10) DEFAULT NULL,
  `presentacion` varchar(10) NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0-desact : 1-activ',
  `condicion_prod` int(11) NOT NULL COMMENT '0: comprado - 1: producido ',
  PRIMARY KEY (`idarticulo`),
  KEY `fk_articulo_categoria_idx` (`idcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulo`
--

LOCK TABLES `articulo` WRITE;
/*!40000 ALTER TABLE `articulo` DISABLE KEYS */;
INSERT INTO `articulo` (`idarticulo`, `idcategoria`, `codigo`, `nombre`, `stock`, `medida`, `presentacion`, `descripcion`, `imagen`, `condicion`, `condicion_prod`) VALUES (1,1,'125','TELA 01',10,'Mt.','01','TELA TEST 01','',1,0),(2,1,'1254','CORTINA 02',100,'M2.','02','CORTINA NUEVA','',1,0),(3,3,'12569','PERNO 2 PULGADAS',50,'Und.','UN','PERNO DE METAL','',1,0),(4,3,'254','PERNO 5 PULGADAS',100,'Und.','PERN 01','NUEVO PERNO','',1,0),(5,1,'147','VARA 2 METROS',25,'Mt.','50','VARA','',1,0),(6,1,'12312','TELA CONVER TIPO 1',100,'M2.','1','CONVERSION 1','',1,0),(7,1,'112','TELA CONVER TIPO 2',100,'Mt.','2','CONVER TIPO 2','',1,0),(8,1,'125','TEST_PERSIANA',0,'Mt.','1','XXX','',1,0);
/*!40000 ALTER TABLE `articulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articulo_bk_030220`
--

DROP TABLE IF EXISTS `articulo_bk_030220`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulo_bk_030220` (
  `idarticulo` int(11) NOT NULL AUTO_INCREMENT,
  `idcategoria` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `stock` float NOT NULL,
  `medida` varchar(10) DEFAULT NULL,
  `presentacion` varchar(10) NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idarticulo`),
  KEY `fk_articulo_categoria_idx` (`idcategoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulo_bk_030220`
--

LOCK TABLES `articulo_bk_030220` WRITE;
/*!40000 ALTER TABLE `articulo_bk_030220` DISABLE KEYS */;
/*!40000 ALTER TABLE `articulo_bk_030220` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articulo_produccion`
--

DROP TABLE IF EXISTS `articulo_produccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulo_produccion` (
  `idarticuloproduccion` int(11) NOT NULL AUTO_INCREMENT,
  `idarticulo` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `observacion` varchar(100) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `fecha_grabacion` date NOT NULL,
  PRIMARY KEY (`idarticuloproduccion`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulo_produccion`
--

LOCK TABLES `articulo_produccion` WRITE;
/*!40000 ALTER TABLE `articulo_produccion` DISABLE KEYS */;
INSERT INTO `articulo_produccion` (`idarticuloproduccion`, `idarticulo`, `cantidad`, `observacion`, `estado`, `usuario`, `fecha_grabacion`) VALUES (1,6,1,'Creado',1,'4','2020-09-24'),(2,7,1,'Creado',1,'4','2020-09-24');
/*!40000 ALTER TABLE `articulo_produccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articulo_produccion_detalle`
--

DROP TABLE IF EXISTS `articulo_produccion_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulo_produccion_detalle` (
  `idarticuloproducciondetalle` int(11) NOT NULL AUTO_INCREMENT,
  `idarticuloproduccion` int(11) NOT NULL,
  `codarticulo` int(11) NOT NULL,
  `cantidad` float NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `fecha_grabacion` date NOT NULL,
  PRIMARY KEY (`idarticuloproducciondetalle`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articulo_produccion_detalle`
--

LOCK TABLES `articulo_produccion_detalle` WRITE;
/*!40000 ALTER TABLE `articulo_produccion_detalle` DISABLE KEYS */;
INSERT INTO `articulo_produccion_detalle` (`idarticuloproducciondetalle`, `idarticuloproduccion`, `codarticulo`, `cantidad`, `usuario`, `fecha_grabacion`) VALUES (1,1,3,2,'4','2020-09-24'),(2,1,1,2,'4','2020-09-24'),(3,1,5,2,'4','2020-09-24'),(4,2,4,3,'4','2020-09-24'),(5,2,1,5,'4','2020-09-24');
/*!40000 ALTER TABLE `articulo_produccion_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idcategoria`),
  UNIQUE KEY `nombre_UNIQUE` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` (`idcategoria`, `nombre`, `condicion`) VALUES (1,'TELAS',1),(2,'CORTINAS',1),(3,'ACCESORIOS',1),(4,'VARA',1);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `web` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config`
--

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_guia`
--

DROP TABLE IF EXISTS `detalle_guia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_guia` (
  `iddetalle_guia` int(11) NOT NULL AUTO_INCREMENT,
  `idguia` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` decimal(11,2) NOT NULL,
  `peso_bulto` decimal(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_guia`),
  KEY `fk_detalle_guia_guia_remision` (`idguia`),
  KEY `fk_detalle_guia_articulo` (`idarticulo`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_guia`
--

LOCK TABLES `detalle_guia` WRITE;
/*!40000 ALTER TABLE `detalle_guia` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_guia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_ingreso`
--

DROP TABLE IF EXISTS `detalle_ingreso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_ingreso` (
  `iddetalle_ingreso` int(11) NOT NULL AUTO_INCREMENT,
  `idingreso` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` decimal(11,2) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_ingreso`),
  KEY `fk_detalle_ingreso_ingreso_idx` (`idingreso`),
  KEY `fk_detalle_ingreso_articulo_idx` (`idarticulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_ingreso`
--

LOCK TABLES `detalle_ingreso` WRITE;
/*!40000 ALTER TABLE `detalle_ingreso` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_ingreso` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `tr_updStockIngreso` AFTER INSERT ON `detalle_ingreso` FOR EACH ROW BEGIN
 UPDATE articulo SET stock = stock + NEW.cantidad 
 WHERE articulo.idarticulo = NEW.idarticulo;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `detalle_produccion`
--

DROP TABLE IF EXISTS `detalle_produccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_produccion` (
  `iddetalle_produccion` int(11) NOT NULL AUTO_INCREMENT,
  `idproduccion` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_produccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_produccion`
--

LOCK TABLES `detalle_produccion` WRITE;
/*!40000 ALTER TABLE `detalle_produccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_produccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_venta`
--

DROP TABLE IF EXISTS `detalle_venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalle_venta` (
  `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT,
  `idventa` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_venta`),
  KEY `fk_detalle_venta_articulo` (`idarticulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_venta`
--

LOCK TABLES `detalle_venta` WRITE;
/*!40000 ALTER TABLE `detalle_venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalle_venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guia_remision`
--

DROP TABLE IF EXISTS `guia_remision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `guia_remision` (
  `idguia` int(11) NOT NULL AUTO_INCREMENT,
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
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idguia`),
  KEY `fk_guia_remision_persona` (`idcliente`),
  KEY `fk_guia_remision_usuario` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guia_remision`
--

LOCK TABLES `guia_remision` WRITE;
/*!40000 ALTER TABLE `guia_remision` DISABLE KEYS */;
/*!40000 ALTER TABLE `guia_remision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingreso`
--

DROP TABLE IF EXISTS `ingreso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ingreso` (
  `idingreso` int(11) NOT NULL AUTO_INCREMENT,
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
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idingreso`),
  KEY `fk_ingreso_persona_idx` (`idproveedor`),
  KEY `fk_ingreso_usuario_idx` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingreso`
--

LOCK TABLES `ingreso` WRITE;
/*!40000 ALTER TABLE `ingreso` DISABLE KEYS */;
/*!40000 ALTER TABLE `ingreso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permiso`
--

DROP TABLE IF EXISTS `permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`idpermiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permiso`
--

LOCK TABLES `permiso` WRITE;
/*!40000 ALTER TABLE `permiso` DISABLE KEYS */;
/*!40000 ALTER TABLE `permiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_persona` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  `num_documento` varchar(20) DEFAULT NULL,
  `contacto` varchar(50) DEFAULT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idpersona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produccion`
--

DROP TABLE IF EXISTS `produccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produccion` (
  `idproduccion` int(11) NOT NULL AUTO_INCREMENT,
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
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idproduccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produccion`
--

LOCK TABLES `produccion` WRITE;
/*!40000 ALTER TABLE `produccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `produccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produccion_bk_010220`
--

DROP TABLE IF EXISTS `produccion_bk_010220`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produccion_bk_010220` (
  `idproduccion` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) NOT NULL,
  `condicionp` varchar(20) NOT NULL,
  `moneda` varchar(20) NOT NULL,
  `nomb_produccion` varchar(150) NOT NULL,
  `num_prod` varchar(15) NOT NULL,
  `fecha_produccion` date NOT NULL,
  `ipu_produccion` decimal(11,2) NOT NULL,
  `total_produccion` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idproduccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produccion_bk_010220`
--

LOCK TABLES `produccion_bk_010220` WRITE;
/*!40000 ALTER TABLE `produccion_bk_010220` DISABLE KEYS */;
/*!40000 ALTER TABLE `produccion_bk_010220` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `login_UNIQUE` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`idusuario`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `cargo`, `login`, `clave`, `imagen`, `condicion`) VALUES (2,'Elber Cruzado Torres','DNI','40107316','Av. Manuel Villaran 965 Surquillolima','981254608','informes@decoshadesperu.com','Gerente General','Elbercruzado','8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918','1558547334.jpg',1),(3,'Marleni Chuquizuta','DNI','73351882','Jr.  La unión sn','918714350','mar.97.ramos@gmail.com','Desarrollador','Mar','72da114b3368e2e2d040e4ada161282e8464a9174c28952e51be5fabc4044c47','1558659277.jpg',1),(4,'Oscar Ramos Chavarri','DNI','70805900','las flores','987087371','ocar@jij.com','Ing. de Sistemas','deco','54ca7b83a424aed496ef5ef4f0ddf94222949e097b7d8683f2bd58165e0823dd','1502689919.jpg',1),(5,'juan cucho','DNI','42888004','av sol 588','921314608','juan.cucho@outlook.com','analista','jcucho','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92','1558888886.jpg',0);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_permiso`
--

DROP TABLE IF EXISTS `usuario_permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL,
  PRIMARY KEY (`idusuario_permiso`),
  KEY `fk_usuario_permiso_permiso_idx` (`idpermiso`),
  KEY `fk_usuario_permiso_usuario_idx` (`idusuario`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_permiso`
--

LOCK TABLES `usuario_permiso` WRITE;
/*!40000 ALTER TABLE `usuario_permiso` DISABLE KEYS */;
INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES (10,4,1),(11,4,2),(12,4,3),(13,4,4),(14,4,5),(15,4,6),(16,4,7),(17,4,8),(18,4,9),(32,6,1),(33,6,2),(34,5,1),(35,5,2),(36,5,3),(37,5,4),(38,5,5),(39,5,6),(40,5,7),(41,5,8),(42,5,9),(44,4,10);
/*!40000 ALTER TABLE `usuario_permiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_permiso_old`
--

DROP TABLE IF EXISTS `usuario_permiso_old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_permiso_old` (
  `idusuario_permiso` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL,
  PRIMARY KEY (`idusuario_permiso`),
  KEY `fk_usuario_permiso_permiso_idx` (`idpermiso`),
  KEY `fk_usuario_permiso_usuario_idx` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_permiso_old`
--

LOCK TABLES `usuario_permiso_old` WRITE;
/*!40000 ALTER TABLE `usuario_permiso_old` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario_permiso_old` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL AUTO_INCREMENT,
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
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idventa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta`
--

LOCK TABLES `venta` WRITE;
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'sisoscar_decos'
--

--
-- Dumping routines for database 'sisoscar_decos'
--
/*!50003 DROP PROCEDURE IF EXISTS `DECO_ACTUALIZAR_STOCK_ARTICULOS` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `DECO_ACTUALIZAR_STOCK_ARTICULOS`(IN `Pint_Articulo` INT, IN `pflo_Cantidad` FLOAT)
BEGIN
UPDATE articulo SET stock = (stock - pflo_Cantidad) WHERE idarticulo = Pint_Articulo;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `DECO_LISTAR_ARTICULOS_PRODUCIDOS` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `DECO_LISTAR_ARTICULOS_PRODUCIDOS`()
BEGIN
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `USP_DECO_ACTUALIZAR_STOCK_ANULAR_INGRESO` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_DECO_ACTUALIZAR_STOCK_ANULAR_INGRESO`(IN `pint_idingreso` INT)
    NO SQL
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `USP_DECO_ACTUALIZAR_STOCK_ANULAR_PRODUCCION` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_DECO_ACTUALIZAR_STOCK_ANULAR_PRODUCCION`(IN `pint_idproduccion` INT)
    NO SQL
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `USP_DECO_ACTUALIZAR_STOCK_ANULAR_VENTA` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = latin1 */ ;
/*!50003 SET character_set_results = latin1 */ ;
/*!50003 SET collation_connection  = latin1_swedish_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `USP_DECO_ACTUALIZAR_STOCK_ANULAR_VENTA`(IN `pint_idventa` INT)
    NO SQL
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-18 11:04:59

---------------- ADD DANIEL 201220
DROP PROCEDURE IF EXISTS USP_DECO_ACTUALIZAR_STOCK_ARTICULO_PRODUCIDO;
DELIMITER $$
CREATE PROCEDURE USP_DECO_ACTUALIZAR_STOCK_ARTICULO_PRODUCIDO(IN pint_nombreArticuloProd VARCHAR(150),
                                                              IN pflo_Stock FLOAT)
BEGIN
SET @idarticulo = (SELECT idarticulo FROM articulo WHERE nombre LIKE pint_nombreArticuloProd);
UPDATE articulo SET stock = pflo_Stock WHERE idarticulo = @idarticulo;
END$$
DELIMITER ;
