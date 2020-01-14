<?php 
require_once "../modelos/Permiso.php";

$permiso=new Permiso();
$idpermiso=isset($_POST["idpermiso"])? limpiarCadena($_POST["idpermiso"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
        if (empty($idpermiso)){
            $rspta=$permiso->insertar($nombre);
            echo $rspta ? "Permiso registrada" : "Permiso no se pudo registrar";
        }
        else {
            $rspta=$permiso->editar($idpermiso,$nombre);
            echo $rspta ? "Permiso actualizada" : "Permiso no se pudo actualizar";
        }
    break;
 
    case 'eliminar':
        $rspta=$permiso->eliminar($idpermiso);
        echo $rspta ? "Permiso eliminad" : "El Permiso no se puede eliminar";
    break;
 
    case 'mostrar':
        $rspta=$permiso->mostrar($idpermiso);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;

	case 'listar':
		$rspta=$permiso->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idpermiso.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-danger" onclick="eliminar('.$reg->idpermiso.')"><i class="fa fa-trash"></i></button>',
                "1"=>$reg->nombre
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