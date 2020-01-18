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