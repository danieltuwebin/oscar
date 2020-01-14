<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Venta
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($idcliente,$idusuario,$condicionv,$tipo_comprobante,$serie_comprobante,$num_comprobante,$guia_remi,$fecha_emision,$fecha_vencimiento,$impuesto,$nroorden,$obra,$total_venta,$moneda,$tipo_cambio,$total_soles,$idarticulo,$cantidad,$precio_venta,$descuento)
    {
        $sql="INSERT INTO venta (idcliente,idusuario,condicionv,tipo_comprobante,serie_comprobante,num_comprobante,guia_remi,fecha_emision,fecha_vencimiento,impuesto,nroorden,obra,total_venta,moneda,tipo_cambio,total_soles,estado)
        VALUES ('$idcliente','$idusuario','$condicionv','$tipo_comprobante','$serie_comprobante','$num_comprobante','$guia_remi','$fecha_emision','$fecha_vencimiento','$impuesto','$nroorden','$obra','$total_venta','$moneda','$tipo_cambio','$total_soles','0')";
        //return ejecutarConsulta($sql);
        $idventanew=ejecutarConsulta_retornarID($sql);
 
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($idarticulo))
        {
            $sql_detalle = "INSERT INTO detalle_venta(idventa, idarticulo,cantidad,precio_venta,descuento) VALUES ('$idventanew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
			
			$sql_stock = "UPDATE articulo SET stock = (stock - $cantidad[$num_elementos]) WHERE idarticulo = $idarticulo[$num_elementos]";
			ejecutarConsulta($sql_stock) or $sw = false;				
            $num_elementos=$num_elementos + 1;
        }
 
        return $sw;
    }
 
     
    //Implementamos un método para anular la venta
    public function anular($idventa)
    {
		$this->anularActualizarStock($idventa);
        $sql="UPDATE venta SET estado='Anulado' WHERE idventa='$idventa'";
        return ejecutarConsulta($sql);
    }
 
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idventa)
    {
        $sql="SELECT v.idventa,v.condicionv,DATE(v.fecha_emision) as emision,DATE(v.fecha_vencimiento) as vencimiento,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.guia_remi,v.num_comprobante,v.total_venta,v.moneda,v.tipo_cambio,v.total_soles,v.impuesto,v.nroorden,v.obra,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
        return ejecutarConsultaSimpleFila($sql);
    }
 
 
    public function listarDetalle($idventa)
    {
        $sql="SELECT dv.idventa,dv.idarticulo,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal FROM detalle_venta dv 
            inner join articulo a on dv.idarticulo=a.idarticulo  where dv.idventa='$idventa'";
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para listar los registros
   public function listar()
    {
        $sql="SELECT v.idventa,v.condicionv,DATE(v.fecha_emision) as emision,DATE(v.fecha_vencimiento) as vencimiento,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.guia_remi,v.total_venta,v.moneda,v.tipo_cambio,v.total_soles,v.impuesto,v.nroorden,v.obra,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario ORDER by v.idventa desc";
        return ejecutarConsulta($sql);      
    }
    
    public function ventacabecera($idventa){
        $sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,DATE(v.fecha_emision) as emision,DATE(v.fecha_vencimiento) as vencimiento,v.condicionv,v.guia_remi,v.moneda,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
        return ejecutarConsulta($sql);
    }

    public function ventadetalle($idventa){
        $sql="SELECT a.nombre as articulo,a.codigo,a.medida,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal FROM detalle_venta dv INNER JOIN articulo a ON dv.idarticulo=a.idarticulo WHERE dv.idventa='$idventa'";
        return ejecutarConsulta($sql);
    }
	
   public function anularActualizarStock($idventa)
    {
        $sql="CALL USP_DECO_ACTUALIZAR_STOCK_ANULAR_VENTA($idventa)";
        return ejecutarConsulta($sql);	
    }
	
   public function listarMaxId($tipo_comprobante)
    {
        $sql="SELECT LPAD(count(*)+1,8, '0')  AS num_comprobante FROM venta WHERE substr(tipo_comprobante,1,1)=substr('$tipo_comprobante',1,1)";
        return ejecutarConsultaSimpleFila($sql);      
    }    
}
?>