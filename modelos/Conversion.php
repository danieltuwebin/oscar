<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Conversion
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($idusuario,$idarticuloC,$fecha_produccion,$idarticulo,$cantidad)
    {

        $sql="INSERT INTO articulo_produccion (idarticulo,cantidad,observacion,estado,usuario,fecha_grabacion) 
        VALUES ('$idarticuloC',1,'Creado',1,'$idusuario',NOW())";
        $idproduccionnew=ejecutarConsulta_retornarID($sql);

        $num_elementos=0;
        $sw=true;

         while ($num_elementos < count($idarticulo))
        {
            $sql_detalle = "INSERT INTO articulo_produccion_detalle (idarticuloproduccion, codarticulo, cantidad, usuario, fecha_grabacion)
            VALUES ('$idproduccionnew','$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$idusuario',NOW())";
            ejecutarConsulta($sql_detalle) or $sw = false;			
					
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
        $sql="SELECT p.idarticuloproduccion,DATE(p.fecha_grabacion) as fecha,a.idarticulo,a.nombre, u.idusuario, u.nombre as usuario,p.estado 
        FROM articulo_produccion p LEFT JOIN usuario u ON p.usuario=u.idusuario
        LEFT JOIN articulo a ON a.idarticulo = p.idarticulo
        WHERE p.idarticuloproduccion='$idproduccion'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listarDetalle($idproduccion)
    {
        $sql="SELECT dp.idarticuloproduccion,dp.codarticulo,a.medida,a.nombre,dp.cantidad
        FROM articulo_produccion_detalle dp inner join articulo a on dp.codarticulo=a.idarticulo where dp.idarticuloproduccion='$idproduccion'";
            return ejecutarConsulta($sql);
    }
 
    //Implementar un método para listar los registros
    public function listar()
    {
        
           $sql="CALL DECO_LISTAR_ARTICULOS_PRODUCIDOS()";
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
