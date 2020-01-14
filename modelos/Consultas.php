<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	
	//Implementar un método para listar los registros
	public function comprasfecha($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT i.condicioni,DATE(i.fecha_emision) as emision,DATE(i.fecha_vencimiento) as vencimiento,u.nombre as usuario,p.nombre as proveedor,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE DATE(i.fecha_emision)>='$fecha_inicio' AND DATE(i.fecha_emision)<='$fecha_fin'";
		
		return ejecutarConsulta($sql);		
	}

	public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente)
    {
        $sql="SELECT v.condicionv,DATE(v.fecha_emision) as emision,DATE(v.fecha_vencimiento) as vencimiento,u.nombre as usuario, p.nombre as cliente,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE DATE(v.fecha_emision)>='$fecha_inicio' AND DATE(v.fecha_emision)<='$fecha_fin' AND v.idcliente='$idcliente'";
        return ejecutarConsulta($sql);      
    }

	public function totalcomprahoy()
	{
		$sql="SELECT IFNULL(SUM(total_compra),0) as total_compra FROM ingreso WHERE moneda='SOLES' AND DATE(fecha_emision)=curdate()";
		return ejecutarConsulta($sql);

	}

	public function totalcomprahoydol()
	{
		$sql="SELECT IFNULL(SUM(total_compra),0) as total_compra FROM ingreso WHERE moneda='DOLARES AMERICANOS' AND DATE(fecha_emision)=curdate()";
		return ejecutarConsulta($sql);

	}
	
	public function totalventahoy()
	{
		$sql="SELECT IFNULL(SUM(total_venta),0) as total_venta FROM venta WHERE moneda='SOLES' AND DATE(fecha_emision)=curdate()";
		return ejecutarConsulta($sql);

	}

	public function totalventahoydol()
	{
		$sql="SELECT IFNULL(SUM(total_venta),0) as total_venta FROM venta WHERE moneda='DOLARES AMERICANOS' AND DATE(fecha_emision)=curdate()";
		return ejecutarConsulta($sql);

	}


	public function comprasultimos_10dias()
	{
		$sql="SELECT CONCAT(DAY(fecha_emision),'-',MONTH(fecha_emision)) as emision,SUM(total_compra) as total FROM ingreso WHERE moneda='SOLES' GROUP by fecha_emision ORDER BY fecha_emision DESC limit 0,10";
        return ejecutarConsulta($sql);
	}

	public function comprasultimos_10dias_dol()
	{
		$sql="SELECT CONCAT(DAY(fecha_emision),'-',MONTH(fecha_emision)) as emision,SUM(total_compra) as total FROM ingreso WHERE moneda='DOLARES AMERICANOS' GROUP by fecha_emision ORDER BY fecha_emision DESC limit 0,10";
        return ejecutarConsulta($sql);
	}


	public function ventasultimos_12meses()
    {
        $sql="SELECT DATE_FORMAT(fecha_emision,'%M') as fecha,SUM(total_venta) as total FROM venta where moneda='SOLES' GROUP by MONTH(fecha_emision) ORDER BY fecha_emision DESC limit 0,10";
        return ejecutarConsulta($sql);
    }
    public function ventasultimos_12meses_dol()
    {
        $sql="SELECT DATE_FORMAT(fecha_emision,'%M') as fecha,SUM(total_venta) as total FROM venta where moneda='DOLARES AMERICANOS' GROUP by MONTH(fecha_emision) ORDER BY fecha_emision DESC limit 0,10";
        return ejecutarConsulta($sql);
    }
}

?>