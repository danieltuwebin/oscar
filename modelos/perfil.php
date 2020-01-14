<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Perfil
{
	//Implementamos nuestro constructor
	public function __construct(){}

public function editar($id, $rsocial, $ncomercial, $ruc, $dir, $departamento, $provincia, $distrito, $codpais, $ubigeo, $fono, $usuario, $clave, $firma, $correo){
$sql="UPDATE config SET ruc='$ruc', razon_social='$rsocial', nombre_comercial='$ncomercial', direccion='$dir', departamento='$departamento', provincia='$provincia', distrito='$distrito', codpais='$codpais', ubigeo='$ubigeo', telefono='$fono', usuario='$usuario', clave='$clave', firma='$firma', correo='$correo' WHERE id='$id'";
return ejecutarConsulta($sql);
}
	
	
	//Implementamos un método para anular la venta
	public function activar($id)	{
		$sql="UPDATE config SET estado='0' ";
		ejecutarConsulta($sql);
		
		$sql2="UPDATE config SET estado='1' WHERE id='$id'";
		return ejecutarConsulta($sql2);
	}


//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id)
	{
		$sql="SELECT * FROM config WHERE id='$id'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idventa)
	{
		$sql="SELECT dv.idventa,dv.txtCOD_ARTICULO,a.txtDESCRIPCION_ARTICULO,dv.txtCANTIDAD_ARTICULO,dv.txtPRECIO_ARTICULO,(dv.txtCANTIDAD_ARTICULO*dv.txtPRECIO_ARTICULO) as txtSUB_TOTAL FROM detalle_venta dv inner join articulo a on dv.txtCOD_ARTICULO=a.txtCOD_ARTICULO where dv.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar(){
$sql="SELECT *FROM config ORDER by id desc";
		return ejecutarConsulta($sql);		
	}

	public function ventacabecera($idventa){
		$sql="SELECT v.idventa,v.txtID_CLIENTE,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.txtID_TIPO_DOCUMENTO,v.txtSERIE,v.txtNUMERO,date(v.txtFECHA_DOCUMENTO) as fecha,v.txtIGV,v.txtTOTAL FROM venta v INNER JOIN persona p ON v.txtID_CLIENTE=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	public function ventadetalle($idventa){
		$sql="SELECT a.nombre as articulo,a.txtCOD_ARTICULO,d.txtCANTIDAD_ARTICULO,d.txtPRECIO_ARTICULO,(d.txtCANTIDAD_ARTICULO*d.txtPRECIO_ARTICULO) as txtSUB_TOTAL FROM detalle_venta d INNER JOIN articulo a ON d.txtCOD_ARTICULO=a.txtCOD_ARTICULO WHERE d.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}
	
}
?>