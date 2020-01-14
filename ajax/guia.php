<?php
 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Guia.php";

$guia=new Guia();

$idguia=isset($_POST["idguia"])? limpiarCadena($_POST["idguia"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idusuario=$_SESSION["idusuario"];
$num_guia=isset($_POST["num_guia"])? limpiarCadena($_POST["num_guia"]):"";
$fecha_emision=isset($_POST["fecha_emision"])? limpiarCadena($_POST["fecha_emision"]):"";
$fecha_traslado=isset($_POST["fecha_traslado"])? limpiarCadena($_POST["fecha_traslado"]):"";
$domi_partida=isset($_POST["domi_partida"])? limpiarCadena($_POST["domi_partida"]):"";
$domi_llegada=isset($_POST["domi_llegada"])? limpiarCadena($_POST["domi_llegada"]):"";
$ruc_dni=isset($_POST["ruc_dni"])? limpiarCadena($_POST["ruc_dni"]):"";
$marca_placa=isset($_POST["marca_placa"])? limpiarCadena($_POST["marca_placa"]):"";
$certi_inscripcion=isset($_POST["certi_inscripcion"])? limpiarCadena($_POST["certi_inscripcion"]):"";
$lic_conducir=isset($_POST["lic_conducir"])? limpiarCadena($_POST["lic_conducir"]):"";
$rason_transportista=isset($_POST["rason_transportista"])? limpiarCadena($_POST["rason_transportista"]):"";
$ruc_transportista=isset($_POST["ruc_transportista"])? limpiarCadena($_POST["ruc_transportista"]):"";
$doc_pago=isset($_POST["doc_pago"])? limpiarCadena($_POST["doc_pago"]):"";
$num_doc_pago=isset($_POST["num_doc_pago"])? limpiarCadena($_POST["num_doc_pago"]):"";
$motivo_traslado=isset($_POST["motivo_traslado"])? limpiarCadena($_POST["motivo_traslado"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idguia)){
			$rspta=$guia->insertar($idcliente,$idusuario,$num_guia,$fecha_emision,$fecha_traslado,$domi_partida,$domi_llegada,$marca_placa,$certi_inscripcion,$lic_conducir,$rason_transportista,$ruc_transportista,$doc_pago,$num_doc_pago,$motivo_traslado,$_POST["idarticulo"],$_POST["cantidad"],$_POST["peso_bulto"]);
			//echo $rspta ? "No se pudo generar la guia Ocurrio algun error" : "Guia Generada Correctamente";
			echo $rspta ? "Guia Generada Correctamente" : "No se pudo generar la guia Ocurrio algun error";
		}
		else {
		}
	break;

	case 'anular':
		$rspta=$guia->anular($idguia);
 		echo $rspta ? "Guia anulada" : "La Guia no se puede anular";
	break;

	case 'mostrar':
		$rspta=$guia->mostrar($idguia);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;


	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $guia->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Decripcion</th>
                                    <th>Cantidad/Bultos</th>
                                    <th>Peso bulto</th>
                                    <th>Peso total</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas">
						<td></td>
						<td>'.$reg->nombre.'</td>
						<td>'.$reg->cantidad.'</td>
						<td>'.$reg->peso_bulto.'</td>
						<td>'.$reg->peso_total.'</td>
					</tr>';
					$peso_total=$peso_total+($reg->peso_bulto*$reg->cantidad);
				}
		echo '<tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    
                                </tfoot>';
	break;

	case 'listar':
		$rspta=$guia->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado=='Generado')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idguia.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="anular('.$reg->idguia.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idguia.')"><i class="fa fa-eye"></i></button>',
 				"1"=>$reg->emision,
 				"2"=>$reg->traslado,
 				"3"=>$reg->cliente,
 				"4"=>$reg->usuario,
 				"5"=>$reg->num_guia,
 				"6"=>$reg->doc_pago.':         '.$reg->num_doc_pago,
 				"7"=>$reg->motivo_traslado,
 				"8"=>($reg->estado=='Generado')?'<span class="label bg-green">Generado</span>':
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

	case 'selectCliente':
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listarC();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
				}
	break;

	case 'listarArticulos':
		require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
 
        $rspta=$articulo->listarActivosGuia();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\',\''.$reg->categoria.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->categoria,
                "3"=>$reg->codigo,
                "4"=>$reg->stock.'   '.$reg->medida,
                "5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >"
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
}
?>