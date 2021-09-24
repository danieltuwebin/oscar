<?php
if (strlen(session_id()) < 1)
	session_start();

require_once "../modelos/Produccion.php";

$produccion = new Produccion();

$idproduccion = isset($_POST["idproduccion"]) ? limpiarCadena($_POST["idproduccion"]) : "";
$idusuario = $_SESSION["idusuario"];
$condicionp = isset($_POST["condicionp"]) ? limpiarCadena($_POST["condicionp"]) : "";
$moneda = isset($_POST["moneda"]) ? limpiarCadena($_POST["moneda"]) : "";
$nomb_produccion = isset($_POST["nomb_produccion"]) ? limpiarCadena($_POST["nomb_produccion"]) : "";
$cant_produccion = isset($_POST["cant_produccion"]) ? limpiarCadena($_POST["cant_produccion"]) : "";// NO ESTA EN LOCAL OSCAR
$num_prod = isset($_POST["num_prod"]) ? limpiarCadena($_POST["num_prod"]) : "";
$medida_ancho = isset($_POST["medida_ancho"]) ? limpiarCadena($_POST["medida_ancho"]) : "";// NO ESTA EN LOCAL OSCAR
$medida_alto = isset($_POST["medida_alto"]) ? limpiarCadena($_POST["medida_alto"]) : "";// NO ESTA EN LOCAL OSCAR
$fecha_produccion = isset($_POST["fecha_produccion"]) ? limpiarCadena($_POST["fecha_produccion"]) : "";
$ipu_produccion = isset($_POST["ipu_produccion"]) ? limpiarCadena($_POST["ipu_produccion"]) : "";
$total_produccion = isset($_POST["total_produccion"]) ? limpiarCadena($_POST["total_produccion"]) : "";
$idcliente = isset($_POST["idcliente"]) ? limpiarCadena($_POST["idcliente"]) : "";// NO ESTA EN LOCAL OSCAR
$nomb_cliente = isset($_POST["nomb_cliente"]) ? limpiarCadena($_POST["nomb_cliente"]) : "";// NO ESTA EN LOCAL OSCAR


switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idproduccion)) {
			/*
			$rspta = $produccion->insertar($idproduccion, $idusuario, $condicionp, $moneda, $nomb_produccion, $num_prod, $fecha_produccion, $ipu_produccion, $total_produccion, $_POST["idarticulo"], $_POST["cantidad"], $_POST["precio_venta"]);
			echo $rspta ? "Producción Registrada" : "No se pudo registrar todos los datos de la Producción";
			*/
			echo $idproduccion;
		} else {
			//echo $idproduccion;
			$rspta = $produccion->insertar($idproduccion, $idusuario, $condicionp, $moneda, $nomb_produccion, $cant_produccion, $num_prod ,$medida_ancho, $medida_alto, $fecha_produccion, $ipu_produccion, $total_produccion, $_POST["idarticulo"], $_POST["cantidad"], $_POST["precio_venta"], $idcliente);
			echo $rspta ? "Producción Registrada" : "No se pudo registrar todos los datos de la Producción";
		}
		break;

	case 'anular':
		$rspta1 = $produccion->anularActualizarStock($idproduccion);
		$rspta = $produccion->anular($idproduccion);
		echo $rspta ? "Producción anulada" : "Producción no se puede anular";
		break;

	case 'mostrar':
		$rspta = $produccion->mostrar($idproduccion);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id = $_GET['id'];

		$rspta = $produccion->listarDetalle($id);
		$total = 0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio venta.</th>
                                    <th>Subtotal</th>
              </thead>';
		while ($reg = $rspta->fetch_object()) {
			echo '<tr class="filas">
							<td></td>
							<td>' . $reg->nombre . '</td>
							<td>' . $reg->cantidad . '</td>
							<td>' . $reg->precio_venta . '</td>
							<td>' . $reg->precio_venta * $reg->cantidad . '</td>
						</tr>';
			$total = $total + ($reg->precio_venta * $reg->cantidad);
		}
		echo '<tfoot>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th>TOTAL</th>
                      <th>
                      	<h4 id="total"> .' . $total . '</h4>
                      	<input type="hidden" name="total_produccion" id="total_produccion">
                      </th>    
               </tfoot>';
		break;

	case 'listar':
		$rspta = $produccion->listar();
		//Vamos a declarar un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			if($reg->condicionp=='Producción'){
				$url='../reportes/exProduccion.php?id=';
			}
			else{
				$url='../reportes/exPresupuesto.php?id=';
			}
			$data[] = array(
				"0" => (($reg->estado == 'Aceptado') ? '<button class="btn btn-warning" onclick="mostrar(' . $reg->idproduccion . ')"><i class="fa fa-eye"></i></button>' 
				. '<button class="btn btn-danger" onclick="anular(' . $reg->idproduccion . ')"><i class="fa fa-close"></i></button>'
				.'<a target="_blank" href="'.$url.$reg->idproduccion.'"><button class="btn btn-info"> <i class="fa fa-file"> </i></button> </a>'
					: '<button class="btn btn-warning" onclick="mostrar(' . $reg->idproduccion . ')"><i class="fa fa-eye"></i></button>'),
					//.'<a target="_blank" href="'.$url.$reg->idproduccion.'"><button class="btn btn-info"> <i class="fa fa-file"> </i></button> </a>',
				"1" => $reg->condicionp,
				"2" => $reg->nombre,
				"3" => $reg->fecha,
				"4" => $reg->nomb_produccion,
				"5" => $reg->medida,
				"6" => $reg->usuario,
				"7" => $reg->num_prod,
				"8" => $reg->ipu_produccion,
				"9" => $reg->total_produccion,
				"10" => $reg->moneda,
				"11" => ($reg->estado == 'Aceptado') ? '<span class="label bg-green">Aceptado</span>' :
					'<span class="label bg-red">Anulado</span>'
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);

		break;


	case 'listarArticulosProduccion_x_idconvertidos':
		require_once "../modelos/Articulo.php";
		$articulo = new Articulo();
		$rspta = $articulo->listarArticulosProduccion_x_idconvertidos($idproduccion);
		$total = 0;
		$cont = 0;
		echo '<thead style="background-color:#A9D0F5">
									<th>Id</th>
									<th style="display:none">TipoTela</th>
									<th>Artículo</th>
                                    <th>Medida</th>									
                                    <th>Cantidad</th>
                                    <th>Precio venta.</th>
                                    <th>Subtotal</th>
              </thead>';
		while ($reg = $rspta->fetch_object()) {
			echo '<tr class="filas" id="fila' . $cont . '">>
							<td><input type="hidden" name="idarticulo[]" value="' . $reg->codarticulo . '">' . $reg->codarticulo . '</td>
							<td style="display:none"><span name="tdtipotela" id="tdtipotela' . $cont . '">' . $reg->tipotela . '</span></td>
							<td>' . $reg->nombre . '</td>
							<td>' . $reg->medida . '</td>							
							<td><input type="decimal number" name="cantidad[]" id="cantidad[]" value="' . $reg->cantidad . '"></td>
							<td><input type="decimal number" name="precio_venta[]" id="precio_venta[]" value="' . $reg->precio_venta . '"></td>							
							<td><span name="subtotal" id="subtotal' . $cont . '">' . $reg->cantidad * $reg->precio_venta . '</span></td>							
							<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td> 
						</tr>';
			$total = $total + ($reg->cantidad * $reg->precio_venta);
			++$cont;
		}
		echo '<tfoot>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th>TOTAL</th>
                      <th>
                      	<h4 id="total"> .' . $total . '</h4>
                      	<input type="hidden" name="total_produccion" id="total_produccion">
                      </th>      
               </tfoot>';
		break;

	case 'selectArticulo':
		require_once "../modelos/Articulo.php";
		$articulo = new Articulo();

		$rspta = $articulo->listar_articulos_convertidos();

		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idarticuloproduccion . '>' . $reg->nombre . '</option>';
		}
		break;

	case 'listarArticulosInsumosTelas':
		$rspta = $produccion->listarArticulosInsumosTelas();
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
		break;
	case 'selectCliente':
		require_once "../modelos/Articulo.php";
		$articulo = new Articulo();

		$rspta = $articulo->listar_clientes();

		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
		}
		break;
	
}
