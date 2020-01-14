<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Venta.php";

$venta=new Venta();

$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idusuario=$_SESSION["idusuario"];
$condicionv=isset($_POST["condicionv"])? limpiarCadena($_POST["condicionv"]):"";
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$guia_remi=isset($_POST["guia_remi"])? limpiarCadena($_POST["guia_remi"]):"";
$fecha_emision=isset($_POST["fecha_emision"])? limpiarCadena($_POST["fecha_emision"]):"";
$fecha_vencimiento=isset($_POST["fecha_vencimiento"])? limpiarCadena($_POST["fecha_vencimiento"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$nroorden=isset($_POST["nroorden"])? limpiarCadena($_POST["nroorden"]):"";
$obra=isset($_POST["obra"])? limpiarCadena($_POST["obra"]):"";
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";
$moneda=isset($_POST["moneda"])? limpiarCadena($_POST["moneda"]):"";
$tipo_cambio=isset($_POST["tipo_cambio"])? limpiarCadena($_POST["tipo_cambio"]):"";
$total_soles=isset($_POST["total_soles"])? limpiarCadena($_POST["total_soles"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idventa)){
			$rspta=$venta->insertar($idcliente,$idusuario,$condicionv,$tipo_comprobante,$serie_comprobante,$num_comprobante,$guia_remi,$fecha_emision,$fecha_vencimiento,$impuesto,$nroorden,$obra,$total_venta,$moneda,$tipo_cambio,$total_soles,$_POST["idarticulo"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"]);
			echo $rspta ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
		}
		else {
		}
	break;

	case 'anular':
		$rspta=$venta->anular($idventa);
 		echo $rspta ? "Venta anulada" : "Venta no se puede anular";
	break;

	case 'mostrar':
		$rspta=$venta->mostrar($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
	case 'selectMaxId':
		$rspta=$venta->listarMaxId($tipo_comprobante);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $venta->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th>Descuento</th>
                                    <th>Stock</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{   
					echo '<tr class="filas"><td></td><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->precio_venta.'</td><td>'.$reg->descuento.'</td><td>'.$reg->stock.'</td><td>'.$reg->subtotal.'</td></tr>';
					$total=$total+($reg->precio_venta*$reg->cantidad-$reg->descuento);
   
				}
        
            
       
		echo '<tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>TOTAL</th>
                                    <th><h4 id="total"> US$'.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th>
                                    
                                </tfoot>';
	break;

	case 'listar':
		$rspta=$venta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			if($reg->tipo_comprobante=='Ticket'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			else{
 				$url='../reportes/exFactura.php?id=';
 			}
	
			$boton='<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button> <a target="_blank" href="'.$url.$reg->idventa.'"> <button class="btn btn-info btn-xs"><i class="fa fa-file"></i></button></a> ';	
			
		if($reg->estado=='0'){ 
			$boton.='<button class="btn btn-danger btn-xs" onclick="enviarsunat(\''.$reg->serie_comprobante.'\', \''.$reg->num_comprobante.'\')"><i class="fa fa-play-circle"></i></button>';
}	

if($reg->estado=='2'){
$boton.='<button class="btn btn-danger btn-xs" onclick="anular('.$reg->idventa.')"><i class="fa fa-close"></i></button>';					 
}
		
if($reg->estado=='0'){ $estadob='<span class="label label-default">Pendiente</span>'; }			
if($reg->estado=='1'){ $estadob='<span class="label bg-orange">Enviado</span>'; }	
if($reg->estado=='2'){ $estadob='<span class="label bg-green">Aceptado</span>'; }
if($reg->estado=='3'){ $estadob='<span class="label bg-red">Rechazo</span>'; }
if($reg->estado=='4'){ $estadob='<span class="label label-default">Anul. pend.</span>'; }
if($reg->estado=='5'){ $estadob='<span class="label bg-orange">Anul. Env.</span>'; }
if($reg->estado=='6'){ $estadob='<span class="label bg-green">An. Acep.</span>'; }
			
			
 			$data[]=array(
 				"0"=>$boton,

 				"1"=>$reg->condicionv,	
 				"2"=>$reg->emision,
 				"3"=>$reg->vencimiento,
 				"4"=>$reg->cliente,
 				"5"=>$reg->usuario,
 				"6"=>$reg->tipo_comprobante,
 				"7"=>$reg->serie_comprobante.'-'.$reg->num_comprobante,
 				"8"=>$reg->total_venta,
 				"9"=>$reg->moneda,
 				"10"=>$reg->tipo_cambio,
 				"11"=>$reg->total_soles,
 				"12"=>$estadob
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
	case 'listarArticulosVenta':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosVenta();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\',\''.$reg->precio_venta.'\',\''.$reg->stock.'\')"><span class="fa fa-plus"></span></button>',
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
}
?>