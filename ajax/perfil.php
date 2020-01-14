<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/perfil.php";

$perfil=new Perfil();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$rsocial=isset($_POST["rsocial"])? limpiarCadena($_POST["rsocial"]):"";
$ncomercial=isset($_POST["ncomercial"])? limpiarCadena($_POST["ncomercial"]):"";
$ruc=isset($_POST["ruc"])? limpiarCadena($_POST["ruc"]):"";
$dir=isset($_POST["dir"])? limpiarCadena($_POST["dir"]):"";
$departamento=isset($_POST["departamento"])? limpiarCadena($_POST["departamento"]):"";
$provincia=isset($_POST["provincia"])? limpiarCadena($_POST["provincia"]):"";
$distrito=isset($_POST["distrito"])? limpiarCadena($_POST["distrito"]):"";
$codpais=isset($_POST["codpais"])? limpiarCadena($_POST["codpais"]):"";
$ubigeo=isset($_POST["ubigeo"])? limpiarCadena($_POST["ubigeo"]):"";
$fono=isset($_POST["fono"])? limpiarCadena($_POST["fono"]):"";
$usuario=isset($_POST["usuario"])? limpiarCadena($_POST["usuario"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$firma=isset($_POST["firma"])? limpiarCadena($_POST["firma"]):"";
$correo=isset($_POST["correo"])? limpiarCadena($_POST["correo"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		
$sql="SELECT *FROM config WHERE id='$id' ";
$mostrar= ejecutarConsultaSimpleFila($sql);
	
$rspta=$perfil->editar($id, $rsocial, $ncomercial, $ruc, $dir, $departamento, $provincia, $distrito, $codpais, $ubigeo, $fono, $usuario, $clave, $firma, $correo);
echo $rspta ? "Perfil registrado" : "No se pudieron registrar todos los datos del perfil";


	break;

	case 'listar':
		$rspta=$perfil->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
			
 			$data[]=array(
"0"=>(($reg->estado=='1')?'<button class="btn btn-warning" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>':
'<button class="btn btn-warning" onclick="mostrar('.$reg->id.')"><i class="fa fa-pencil"></i></button>'.
' <button class="btn btn-danger" onclick="activar('.$reg->id.')"><i class="fa fa-play-circle"></i></button>'),
 				"1"=>$reg->razon_social,
 				"2"=>$reg->ruc,
 				"3"=>($reg->tipo=='01')?'<span class="label bg-green">PRODUCCIÓN</span>':
 				'<span class="label bg-green">BETA</span>',
 				"4"=>($reg->estado=='1')?'<span class="label bg-green">Activo</span>':
 				'<span class="label bg-red">Inactivo</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el txtTOTAL registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el txtTOTAL registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'selectCliente':
		require_once "../modelos/Persona.php";
		$persona = new Persona();
$tipodoc=$_GET['tipodoc'];
		$rspta = $persona->listarC($tipodoc);

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
				}
	break;
	
	case 'activar':
header("HTTP/1.1");
header("Content-Type: application/json; charset=UTF-8");
$jsondata = array();

$jsondata['estado'] = '0';
$jsondata['mensaje'] = 'ERROR';	
$rspta=$perfil->activar($id);

$jsondata['estado'] = '1';
$jsondata['mensaje'] = "ACTUALIZADO";
		
echo json_encode($jsondata);
exit();		
	break;
		
case 'mostrar':
		$rspta=$perfil->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
		
}
?>