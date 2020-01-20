<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Conversion.php";

$conversion=new Conversion();

$idproduccion=isset($_POST["idproduccion"])? limpiarCadena($_POST["idproduccion"]):"";
$idusuario=$_SESSION["idusuario"];
$idarticuloC=isset($_POST["idarticuloC"])? limpiarCadena($_POST["idarticuloC"]):"";
$fecha_produccion=isset($_POST["fecha_produccion"])? limpiarCadena($_POST["fecha_produccion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idproduccion)){
			$rspta=$conversion->insertar($idusuario,
										$idarticuloC,
										$fecha_produccion,
										$_POST["idarticulo"],
										$_POST["cantidad"]);
            echo $rspta ? "Producción Registrada" : "No se pudo registrar todos los datos de la Producción";
        }
        else {
        }
	break;

	case 'anular':
		$rspta1=$conversion->anularActualizarStock($idproduccion);		
		$rspta=$conversion->anular($idproduccion);
 		echo $rspta ? "Producción anulada" : "Producción no se puede anular";
	break;

	case 'mostrar':
		$rspta=$conversion->mostrar($idproduccion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $conversion->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
									<th>Artículo</th>
									<th>Medida</th>  
                                    <th>Cantidad</th>
              </thead>';

		while ($reg = $rspta->fetch_object())
				{   
					echo '<tr class="filas">
							<td></td>
							<td>'.$reg->nombre.'</td>
							<td>'.$reg->medida.'</td>							
							<td>'.$reg->cantidad.'</td>
						</tr>';
					//$total=$total+($reg->precio_venta*$reg->cantidad);
   
				}

				echo '<tfoot>
                      <th></th>
                      <th></th>
					  <th></th>
                      <th></th>  					                                    
                                </tfoot>';
	break;

	case 'listar':
        $rspta=$conversion->listar();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg = $rspta->fetch_object())
        {  
            $data[] = array(
                "0"=>($reg->estado=='1')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idarticuloproduccion.')"><i class="fa fa-eye"></i></button>'.'<button class="btn btn-danger" onclick="anular('.$reg->idarticuloproduccion.')"><i class="fa fa-close"></i></button>':'<button class="btn btn-warning" onclick="mostrar('.$reg->idarticuloproduccion.')"><i class="fa fa-eye"></i></button>',
				"1"=>$reg->codarticuloproduccion,				
				"2"=>$reg->codidarticulo,
        		"3"=>$reg->nombre,
 				"4"=>$reg->observacion,
 				"5"=>$reg->usuario,
 				"6"=>$reg->fecha_grabacion,
                "7"=>($reg->estado=='1')?'<span class="label bg-green">Aceptado</span>':
                '<span class="label bg-red">Anulado</span>'
                );
           }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;
 
    case 'listarArticulosConversion':
		     require_once "../modelos/Articulo.php";
		    $articulo=new Articulo();

		$rspta=$articulo->listarActivosProduccion();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 			"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\',\''.$reg->medida.'\',\''.$reg->precio_venta.'\')"><span class="fa fa-plus"></span></button>',
        	"1"=>$reg->nombre,
        	"2"=>$reg->categoria,
        	"3"=>$reg->codigo,
        	"4"=>$reg->stock.'   '.$reg->medida,
        	"5"=>$reg->precio_venta,
        	"6"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
 				);
 		   }
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

	case 'selectArticulo':
		require_once "../modelos/Articulo.php";
		$articulo = new Articulo();

		$rspta = $articulo->listar();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idarticulo . '>' . $reg->nombre . '</option>';
				}
	break;	
}
