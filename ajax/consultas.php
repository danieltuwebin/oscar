<?php 
require_once "../modelos/Consultas.php";

$consultas=new Consultas();


switch ($_GET["op"]){
	case 'comprasfecha':
	$fecha_inicio=$_REQUEST["fecha_inicio"];
	$fecha_fin=$_REQUEST["fecha_fin"];
		$rspta=$consultas->comprasfecha($fecha_inicio,$fecha_fin);
 		//Vamos a declarar un array
 		$data= Array();

 		 while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>$reg->condicioni,
                "1"=>$reg->emision,
                "2"=>$reg->vencimiento,
                "3"=>$reg->usuario,
                "4"=>$reg->proveedor,
                "5"=>$reg->tipo_comprobante,
                "6"=>$reg->serie_comprobante.' '.$reg->num_comprobante,
                "7"=>$reg->total_compra,
                "8"=>$reg->impuesto,
                "9"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
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
    case 'ventasfechacliente':
    $fecha_inicio=$_REQUEST["fecha_inicio"];
    $fecha_fin=$_REQUEST["fecha_fin"];
    $idcliente=$_REQUEST["idcliente"];
        $rspta=$consultas->ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente);
        //Vamos a declarar un array
        $data= Array();

         while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>$reg->condicionv,
                "1"=>$reg->emision,
                "2"=>$reg->vencimiento,
                "3"=>$reg->usuario,
                "4"=>$reg->cliente,
                "5"=>$reg->tipo_comprobante,
                "6"=>$reg->serie_comprobante.' '.$reg->num_comprobante,
                "7"=>$reg->total_venta,
                "8"=>$reg->impuesto,
                "9"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
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
    
}

?>