<?php
// Permite la conexion desde cualquier origen
header("Access-Control-Allow-Origin: *");
// Permite la ejecucion de los metodos
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
date_default_timezone_set('America/Lima');
if (strlen(session_id()) < 1) 
  session_start();

header("HTTP/1.1");
header("Content-Type: application/json; charset=UTF-8");

require "resumen.php";
require "numeros-letras.php";
require "facturacion-electronica.php";

$jsondata = array();

$jsondata['estado'] = '0';
$jsondata['mensaje'] = 'ERROR';


//$array = explode("/", $_SERVER['REQUEST_URI']);
$bodyRequest = file_get_contents("php://input");

$resumen=new Resumen();
$new = new api_sunat();

// Decodifica el cuerpo de la solicitud y lo guarda en un array de PHP
$cab = json_decode($bodyRequest, true);

$serie=(isset($cab['serie'])) ? $cab['serie'] : "0";
$numero=(isset($cab['numero'])) ? $cab['numero'] : "0";

$sql="SELECT *FROM venta WHERE serie_comprobante='$serie' AND num_comprobante='$numero' ";
$mostrar= ejecutarConsultaSimpleFila($sql);

$sql2="SELECT *FROM persona WHERE idpersona='$mostrar[idcliente]' ";
$mcliente= ejecutarConsultaSimpleFila($sql2);

$sql3="SELECT *FROM config WHERE estado='1' ";
$fa= ejecutarConsultaSimpleFila($sql3);

$tipodoc=substr($serie,0,1);
	
$detalle = array();
$json = array();

$ndoc='';
if($mcliente['tipo_documento']=='RUC'){ $ndoc='6'; }else if($mcliente['tipo_documento']=='DNI'){ $ndoc='1'; }

$n=0;
$rspta = $resumen->detfactura($mostrar['idventa']);
while ($reg = $rspta->fetch_object()){
	
	
$sqlar="SELECT *FROM articulo WHERE idarticulo='$reg->idarticulo' ";
$art= ejecutarConsultaSimpleFila($sqlar);

$n=$n+1;
$preciod=($reg->precio_venta*$reg->cantidad);
$preciod=round($preciod, 2);
	
$igv=$preciod * 0.18;
$igv=round($igv, 2);

$json['txtITEM']=$n;
$json["txtUNIDAD_MEDIDA_DET"] ="NIU";
$json["txtCANTIDAD_DET"] = $reg->cantidad;
$json["txtPRECIO_DET"] = $reg->precio_venta;	
$json["txtSUB_TOTAL_DET"] = $preciod; //PRECIO * CANTIDAD                       
$json["txtPRECIO_TIPO_CODIGO"] = "01";
$json["txtIGV"] = $igv;
$json["txtISC"] = "0";
$json["txtIMPORTE_DET"] = $preciod; //rowData.IMPORTE; //SUB_TOTAL + IGV
$json["txtCOD_TIPO_OPERACION"] = "10";
$json["txtCODIGO_DET"] = $art['codigo'];
$json["txtDESCRIPCION_DET"] = $art['nombre'];
$json["txtPRECIO_SIN_IGV_DET"] = $reg->precio_venta;
$detalle[]=$json;	

}
	
$igv=$mostrar['total_venta'] * 0.18;
$subtot=$mostrar['total_venta']-$igv;
$igv=round($igv, 2);
$subtot=round($subtot, 2);

$tipodoc='';
$moneda='';
$ndoc='';
if($mostrar['total_venta']=='Factura'){ $tipodoc='01'; }else{ $tipodoc='03'; }
if($mostrar['moneda']=='Dolar'){ $moneda='USD'; }else{ $moneda='PEN'; }
if($mcliente['tipo_documento']=='RUC'){ $ndoc='6'; }else if($mcliente['tipo_documento']=='DNI'){ $ndoc='1'; }

$data = array(
"txtTIPO_OPERACION"=>"0101",
"txtTOTAL_GRAVADAS"=> $subtot,
"txtSUB_TOTAL"=>$subtot,
"txtPOR_IGV"=> "18.00", 
"txtTOTAL_IGV"=> $igv,
"txtTOTAL_GRATUITAS"=>'0.00',
"txtTOTAL_EXONERADAS"=>'0.00',
"txtTOTAL"=> $mostrar['total_venta'],
"txtTOTAL_LETRAS"=> numtoletras($mostrar['total_venta']), 
"txtNRO_COMPROBANTE"=> $mostrar['serie_comprobante']."-".$mostrar['num_comprobante'],
"txtFECHA_DOCUMENTO"=> date("Y-m-d", strtotime($mostrar['fecha_emision'])),
"txtFECHA_VTO"=> date("Y-m-d", strtotime($mostrar['fecha_vencimiento'])),
"txtCOD_TIPO_DOCUMENTO"=> $tipodoc, //01=factura,03=boleta
"txtCOD_MONEDA"=> $moneda, //PEN=SOL USD= DOLAR EUR=EURO
//==========documentos de referencia(nota credito, debito)=============
"txtTIPO_COMPROBANTE_MODIFICA"=> '',//$mostrar['docmodifica_tipo'],
"txtNRO_DOCUMENTO_MODIFICA"=> '',//$mostrar['docmodifica'],
"txtCOD_TIPO_MOTIVO"=> '',//$mostrar['modifica_motivo'],
"txtDESCRIPCION_MOTIVO"=> '',//$mostrar['modifica_motivod'], //$("[name='txtID_MOTIVO']
//=================datos del cliente=================
 "txtNRO_DOCUMENTO_CLIENTE"=>$mcliente['num_documento'],
 "txtRAZON_SOCIAL_CLIENTE"=>$mcliente['nombre'],
 "txtTIPO_DOCUMENTO_CLIENTE"=>$ndoc,
 "txtDIRECCION_CLIENTE"=>$mcliente['direccion'],
 "txtCIUDAD_CLIENTE"=>"",
 "txtCOD_PAIS_CLIENTE"=>"PE",
//=================datos de LA EMPRESA=================	
 "txtNRO_DOCUMENTO_EMPRESA"=>$fa['ruc'],
 "txtTIPO_DOCUMENTO_EMPRESA"=>"6",
 "txtNOMBRE_COMERCIAL_EMPRESA"=>$fa['nombre_comercial'],
 "txtCODIGO_UBIGEO_EMPRESA"=>$fa['ubigeo'],
 "txtDIRECCION_EMPRESA"=>$fa['direccion'],
 "txtDEPARTAMENTO_EMPRESA"=>$fa['departamento'],
 "txtPROVINCIA_EMPRESA"=>$fa['provincia'],
 "txtDISTRITO_EMPRESA"=>$fa['distrito'],
 "txtCODIGO_PAIS_EMPRESA"=>$fa['codpais'],
 "txtRAZON_SOCIAL_EMPRESA"=>$fa['razon_social'],
 "txtUSUARIO_SOL_EMPRESA"=>$fa['usuario'],
 "txtPASS_SOL_EMPRESA"=>$fa['clave'],
 "txtTIPO_PROCESO"=> $fa['tipo'],
 "PIN"=> $fa['firma'],
"detalle"=>$detalle,
);
//echo json_encode($data);

//AQUI SE LLAMA A UNA FUNCIONA QUE SE ENCAGR DE ENVIAR ALA WEBSERVICES

$resultado = $new->sendPostCPE(json_encode($data), RUTA);
//var_dump($resultado);
//RECUPERAMOS DATOS RESPUESTA SUNAT
$me = json_decode($resultado, true);

if($me['cod_sunat']=='0'){

//ACTUALIZAMOS LA BASE DE DATOS SEGUN RESPUESTA
$sql="UPDATE venta SET estado='2', hash_cpe='$me[hash_cpe]', hash_cdr='$me[hash_cdr]', mensaje='$me[msj_sunat]' WHERE idventa='$mostrar[idventa]' ";
ejecutarConsulta($sql);
	
$jsondata['estado'] = '1';
$jsondata['mensaje'] = $me['msj_sunat'];

}else{

$sql="UPDATE venta SET estado='1', hash_cpe='$me[hash_cpe]', hash_cdr='$me[hash_cdr]', mensaje='$me[msj_sunat]' WHERE idventa='$mostrar[idventa]' ";
ejecutarConsulta($sql);
$jsondata['estado'] = '1';
$jsondata['mensaje'] = 'El documento fue enviado a la sunat';
	
}

$new->creaPDF($mostrar['idventa'], RUTA);

//creaPDF('F001', '00010', 'venta-graba.php');
echo json_encode($jsondata);
exit();	

?>
