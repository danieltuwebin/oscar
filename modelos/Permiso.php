<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Permiso
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	//Implementamos un método para insertar registros
	public function insertar($nombre)
	{
		$sql="INSERT INTO permiso (nombre)
		VALUES ('$nombre')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registSros
	public function editar($idpermiso,$nombre)
	{
		$sql="UPDATE permiso SET nombre='$nombre' WHERE idpermiso='$idpermiso'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar reguistros
	public function eliminar($idpermiso)
    {
        $sql="DELETE FROM permiso WHERE idpermiso='$idpermiso'";
        return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM permiso";
		return ejecutarConsulta($sql);		
	}
	
}

?>