/*
DROP PROCEDURE IF EXISTS DECO_ACTUALIZAR_STOCK_ARTICULOS;
DELIMITER $$
CREATE PROCEDURE DECO_ACTUALIZAR_STOCK_ARTICULOS ( IN Pint_Articulo INT, IN pflo_Cantidad FLOAT)
BEGIN
UPDATE articulo SET stock = (stock - pflo_Cantidad) WHERE idarticulo = Pint_Articulo;
END$$
DELIMITER ;
*/
CALL DECO_ACTUALIZAR_STOCK_ARTICULOS(7,10)


INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES (NULL, '3', '10');


-- show create procedure DECO_LISTAR_ARTICULOS_PRODUCIDOS

DROP PROCEDURE IF EXISTS DECO_LISTAR_ARTICULOS_PRODUCIDOS;
DELIMITER $$
CREATE PROCEDURE `DECO_LISTAR_ARTICULOS_PRODUCIDOS`()
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
END $$
DELIMITER ;




ALTER TABLE `produccion` ADD `med_ancho` INT NOT NULL DEFAULT '0' AFTER `num_prod`, ADD `med_alto` INT NOT NULL DEFAULT '0' AFTER `med_ancho`;