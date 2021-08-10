<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['produccion']==1)
{
//Incluímos el archivo Factura.php
require('Produccion.php');

//Establecemos los datos de la empresa
$logo = "logo.jpg";
$ext_logo = "jpg";
$empresa = "Decoshades Perú E.I.R.L.";
$documento = "RUC: 20552462204";
$direccion = "Av. Manuel Villaran 965 Surquillo";
$telefono = "(01)2710109 / Cel: 981254608";
$email = "informes@decoshadesperu.com";
$web ="www.decoshadesperu.com";

$moneda="";


//Obtenemos los datos de la cabecera de la venta actual
require_once "../modelos/Produccion.php";
$produccion= new Produccion();
$rsptap = $produccion->producioncabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$regp = $rsptap->fetch_object();

//Establecemos la configuración de la factura
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();

//Enviamos los datos de la empresa al método addSociete de la clase Produccion/cotizacion
$pdf->addSociete(utf8_decode($empresa),
                  $documento."\n" .
                  utf8_decode("Dirección: ").utf8_decode($direccion)."\n".
                  utf8_decode("Teléfono: ").$telefono."\n" .
                  "Email : ".$email."\n"."web: ".$web,$logo,$ext_logo);
$pdf->fact_dev(utf8_decode("$regp->condicionp "), "$regp->num_prod" );
$pdf->temporaire( "" );
$pdf->addDate( $regp->fecha);

//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
//$pdf->addClientAdresse(utf8_decode($regv->cliente),"Domicilio: ".utf8_decode($regv->direccion),$regv->tipo_documento.": ".$regv->num_documento,"Email: ".$regv->email,"Telefono: ".$regv->telefono);
$moneda=$regp->moneda;
//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
$cols=array( "CODIGO"=>23,
             "DESCRIPCION"=>78,
             "CANTIDAD"=>22,
             "U.M"=>10,
             "P.U."=>25,
             "SUBTOTAL"=>22);
$pdf->addCols( $cols);
$cols=array("CODIGO"=>"L",
             "DESCRIPCION"=>"L",
             "CANTIDAD"=>"C",
             "U.M"=>"C",
             "P.U."=>"C",
             "SUBTOTAL"=>"C");
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols);
//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 89;

//Obtenemos todos los detalles de la venta actual
$rsptad = $produccion->producciondetalle($_GET["id"]);

while ($regd=$rsptad->fetch_object()) {
  $line = array("CODIGO"=>"$regd->codigo",
                "DESCRIPCION"=>utf8_decode("$regd->articulo"),
                "CANTIDAD"=>"$regd->cantidad",
                "U.M"=>"$regd->medida",
                "P.U."=>"$regd->precio_venta",
                "SUBTOTAL"=>"$regd->subtotal");
            $size = $pdf->addLine( $y, $line );
            $y += $size + 2;
}

//Convertimos el total en letras
require_once "Letraspres.php";
$P=new EnLetras(); 
$con_letra=strtoupper($P->ValorEnLetras($regp->total_produccion,"CON"));
$pdf->addCadreTVAs("SON: ".$con_letra);




// *** condicion para cambio de moneda
$simbolo="";
if ($moneda == "SOLES") { 
$simbolo="S/:  ";
} else { 
$simbolo="US$:  ";
}
//******************************** by createch

//Mostramos el impuesto
$pdf->addTVAs( $regp->ipu_produccion, $regp->total_produccion,$simbolo);
$pdf->addCadreEurosFrancs("IGV"." $regp->ipu_produccion %");
$pdf->Output('Reporte de Produccion','I');


}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>