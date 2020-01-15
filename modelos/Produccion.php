<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Produccion
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($idusuario,$condicionp,$moneda,$nomb_produccion,$num_prod,$fecha_produccion,$ipu_produccion,$total_produccion,$idarticulo,$cantidad,$precio_venta)
    {

        //NUEVO GRABACION
        $sql="INSERT INTO articulo_produccion (idarticuloproduccion, idarticulo, cantidad, cod_articulo, cod_nombre, observacion, estado)
        VALUES (NULL, '1', '2', '3', '5', 'WEB', '1')";
        ejecutarConsulta_retornarID($sql);


        $sql="INSERT INTO produccion (idusuario,condicionp,moneda,nomb_produccion,num_prod,fecha_produccion,ipu_produccion,total_produccion,estado)
        VALUES ('$idusuario','$condicionp','$moneda','$nomb_produccion','$num_prod','$fecha_produccion','$ipu_produccion','$total_produccion','Aceptado')";
        //return ejecutarConsulta($sql);
        $idproduccionnew=ejecutarConsulta_retornarID($sql);
 
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($idarticulo))
        {
            $sql_detalle = "INSERT INTO detalle_produccion (idproduccion,idarticulo,cantidad,precio_venta) VALUES ('$idproduccionnew','$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            if(substr($condicionp,0,3) == "Pro"){
				$sql_stock = "UPDATE articulo SET stock = (stock - $cantidad[$num_elementos]) WHERE idarticulo = $idarticulo[$num_elementos]";
				ejecutarConsulta($sql_stock) or $sw = false;				
			}			
			$num_elementos=$num_elementos + 1;
        }
 
        return $sw;
    }
  
    //Implementamos un método para anular la venta
    public function anular($idproduccion)
    {
        $sql="UPDATE produccion SET estado='Anulado' WHERE idproduccion='$idproduccion'";
        return ejecutarConsulta($sql);	
    }
	
	//Implementamos un método para actualizar stock al anular la produccion
     public function anularActualizarStock($idproduccion)
    {
        $sql="CALL USP_DECO_ACTUALIZAR_STOCK_ANULAR_PRODUCCION($idproduccion)";
        return ejecutarConsulta($sql);	
    }
	
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idproduccion)
    {
        $sql="SELECT p.idproduccion,DATE(p.fecha_produccion) as fecha,p.condicionp,p.moneda,p.nomb_produccion, u.idusuario, u.nombre as usuario, p.num_prod, p.ipu_produccion, p.total_produccion, p.estado FROM produccion p INNER JOIN usuario u ON p.idusuario=u.idusuario WHERE p.idproduccion='$idproduccion'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listarDetalle($idproduccion)
    {
        $sql="SELECT dp.idproduccion,dp.idarticulo,a.nombre,dp.cantidad,dp.precio_venta,(dp.cantidad*dp.precio_venta) as subtotal FROM detalle_produccion dp inner join articulo a on dp.idarticulo=a.idarticulo where dp.idproduccion='$idproduccion'";
            return ejecutarConsulta($sql);
    }
 
    //Implementar un método para listar los registros
    public function listar()
    {
       $sql="SELECT p.idproduccion,DATE(p.fecha_produccion) as fecha,p.condicionp,p.moneda,p.nomb_produccion,u.idusuario,u.nombre as usuario,p.num_prod,p.ipu_produccion,p.total_produccion,p.estado FROM produccion p INNER JOIN usuario u ON p.idusuario=u.idusuario  ORDER by p.idproduccion desc";
           return ejecutarConsulta($sql);

    } 

    public function producioncabecera($idproduccion){
        $sql="SELECT p.idproduccion,p.condicionp,p.moneda,p.nomb_produccion,p.num_prod,p.idusuario,u.nombre as usuario,DATE(p.fecha_produccion) as fecha,p.ipu_produccion,p.total_produccion FROM produccion p  INNER JOIN usuario u ON p.idusuario=u.idusuario WHERE P.idproduccion='$idproduccion'";
        return ejecutarConsulta($sql);
    }


    public function producciondetalle($idproduccion){
        $sql="SELECT a.nombre as articulo,a.codigo,a.medida,dp.cantidad,dp.precio_venta,(dp.cantidad*dp.precio_venta) as subtotal FROM detalle_produccion dp INNER JOIN articulo a ON dp.idarticulo=a.idarticulo WHERE dp.idproduccion='$idproduccion'";
        return ejecutarConsulta($sql);
    }
     
}
?>