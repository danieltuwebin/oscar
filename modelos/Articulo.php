<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Articulo
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idcategoria,$codigo,$nombre,$stock,$medida,$presentacion,$tipotela,$descripcion,$imagen)
	{
		$sql="INSERT INTO articulo (idcategoria,codigo,nombre,stock,medida,presentacion,tipotela,descripcion,imagen,condicion)
		VALUES ('$idcategoria','$codigo','$nombre','$stock','$medida','$presentacion','$tipotela,','$descripcion','$imagen','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$medida,$presentacion,$descripcion,$imagen)
	{
		$sql="UPDATE articulo SET idcategoria='$idcategoria',codigo='$codigo',nombre='$nombre',stock='$stock',medida='$medida',presentacion='$presentacion',descripcion='$descripcion',imagen='$imagen' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idarticulo)
	{
		$sql="UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idarticulo)
	{
		$sql="UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idarticulo)
	{
		$sql="SELECT * FROM articulo WHERE idarticulo='$idarticulo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.medida,a.presentacion,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria";
		return ejecutarConsulta($sql);		
	}

	public function listar_articulos_convertidos(){
		$sql="SELECT a.idarticuloproduccion,a.idarticulo,ar.nombre,a.cantidad,a.observacion,a.estado,a.usuario,a.fecha_grabacion FROM articulo_produccion a LEFT JOIN articulo ar ON a.idarticulo = ar.idarticulo";
		return ejecutarConsulta($sql);
	}



	public function listarprecio()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.medida,a.presentacion,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo order by iddetalle_ingreso desc limit 0,1) as precio_venta,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros avtivos
	public function listarActivos()
	{
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.medida,a.presentacion,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
		return ejecutarConsulta($sql);		
	}
	 //Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_ingreso)
    public function listarActivosVenta()
    {
        $sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.medida,a.presentacion,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo order by iddetalle_ingreso desc limit 0,1) as precio_venta,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
        return ejecutarConsulta($sql);      
    }

    public function listarActivosProduccion()
    {
		$sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.medida,a.presentacion,(SELECT precio_venta FROM detalle_ingreso WHERE idarticulo=a.idarticulo order by iddetalle_ingreso desc limit 0,1) as precio_venta,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
		return ejecutarConsulta($sql);  
	}

    public function listarArticulosProduccion_x_idconvertidos($articuloconvertido)
    {
		$sql="SELECT ap.idarticuloproduccion,ap.idarticulo,apd.codarticulo,a.medida,a.nombre,di.precio_venta,apd.cantidad,ap.estado,a.tipotela 
		FROM articulo_produccion ap LEFT JOIN articulo_produccion_detalle apd ON ap.idarticuloproduccion = apd.idarticuloproduccion LEFT JOIN articulo a ON apd.codarticulo = a.idarticulo
		LEFT JOIN detalle_ingreso di ON apd.codarticulo = di.idarticulo WHERE ap.idarticuloproduccion = '$articuloconvertido'";
		return ejecutarConsulta($sql);  
    }
	
    //Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_Guia)
    public function listarActivosGuia()
    {
        $sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.medida,a.presentacion,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
		return ejecutarConsulta($sql);      
	}

	//Implementamos un metodo para listar a los clientes
	public function listar_clientes(){
		$sql="SELECT idpersona, tipo_persona, nombre, tipo_documento, num_documento, contacto, direccion, telefono, email FROM persona
		WHERE tipo_persona LIKE 'Cliente'";
		return ejecutarConsulta($sql);
	}
}

?>