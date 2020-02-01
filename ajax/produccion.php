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
$num_prod = isset($_POST["num_prod"]) ? limpiarCadena($_POST["num_prod"]) : "";
$fecha_produccion = isset($_POST["fecha_produccion"]) ? limpiarCadena($_POST["fecha_produccion"]) : "";
$ipu_produccion = isset($_POST["ipu_produccion"]) ? limpiarCadena($_POST["ipu_produccion"]) : "";
$total_produccion = isset($_POST["total_produccion"]) ? limpiarCadena($_POST["total_produccion"]) : "";


switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idproduccion)) {
			$rspta = $produccion->insertar($idusuario, $condicionp, $moneda, $nomb_produccion, $num_prod, $fecha_produccion, $ipu_produccion, $total_produccion, $_POST["idarticulo"], $_POST["cantidad"], $_POST["precio_venta"]);
			echo $rspta ? "Producción Registrada" : "No se pudo registrar todos los datos de la Producción";
		} else {
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
			$data[] = array(
				"0" => ($reg->estado == 'Aceptado') ? '<button class="btn btn-warning" onclick="mostrar(' . $reg->idproduccion . ')"><i class="fa fa-eye"></i></button>' . '<button class="btn btn-danger" onclick="anular(' . $reg->idproduccion . ')"><i class="fa fa-close"></i></button>' : '<button class="btn btn-warning" onclick="mostrar(' . $reg->idproduccion . ')"><i class="fa fa-eye"></i></button>',
				"1" => $reg->condicionp,
				"2" => $reg->fecha,
				"3" => $reg->nomb_produccion,
				"4" => $reg->medida,				
				"5" => $reg->usuario,
				"6" => $reg->num_prod,
				"7" => $reg->ipu_produccion,
				"8" => $reg->total_produccion,
				"9" => $reg->moneda,
				"10" => ($reg->estado == 'Aceptado') ? '<span class="label bg-green">Aceptado</span>' :
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






	case 'listarArticulosProduccion':
		require_once "../modelos/Articulo.php";
		$articulo = new Articulo();

		$rspta = $articulo->listarActivosProduccion();
		//Vamos a declarar un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => '<button class="btn btn-warning" onclick="agregarDetalle(' . $reg->idarticulo . ',\'' . $reg->nombre . '\',\'' . $reg->precio_venta . '\')"><span class="fa fa-plus"></span></button>',
				"1" => $reg->nombre,
				"2" => $reg->categoria,
				"3" => $reg->codigo,
				"4" => $reg->stock . '   ' . $reg->medida,
				"5" => $reg->precio_venta,
				"6" => "<img src='../files/articulos/" . $reg->imagen . "' height='50px' width='50px' >"
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

		case 'selectArticulo':
			require_once "../modelos/Articulo.php";
			$articulo = new Articulo();
	
			$rspta = $articulo->listar_articulos_convertidos();
	
			while ($reg = $rspta->fetch_object())
					{
					echo '<option value=' . $reg->idarticuloproduccion . '>' . $reg->nombre . '</option>';
					}
		break;			
}



