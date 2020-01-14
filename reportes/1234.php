<?php
require('../fpdf181/fpdf.php');


require_once "../modelos/Venta.php";
$venta= new Venta();
$rsptav = $venta->ventacabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',9);

$pdf->SetXY(170,50);
$pdf->Cell(0,0,utf8_decode($regv->serie_comprobante." - ".$regv->num_comprobante));

$pdf->SetFont('Arial','',9);

$pdf->SetXY(20,46);
$pdf->Cell(0,0,utf8_decode($regv->cliente));

$pdf->SetXY(20,54);
$pdf->Cell(0,0,utf8_decode($regv->direccion));
//***Parte de la derecha
$pdf->SetXY(20,65);
$pdf->Cell(0,0,utf8_decode($regv->guia_remi));

$pdf->SetXY(100,65);
$pdf->Cell(0,0,utf8_decode($regv->emision));

$pdf->SetXY(132,65);
$pdf->Cell(0,0,utf8_decode($regv->vencimiento));

$pdf->SetXY(170,65);
$pdf->Cell(0,0,utf8_decode($regv->impuesto));

$pdf->SetXY(190,65);
$pdf->Cell(0,0,utf8_decode($regv->condicionv));

$pdf->SetXY(20,50);
$pdf->Cell(0,0,utf8_decode($regv->num_documento));

$total=0;
//***Detalles de la factura
$rsptad = $venta->ventadetalle($_GET["id"]);

$y=78;
while ($regd = $rsptad->fetch_object()) {

$pdf->SetXY(6,$y);
$pdf->MultiCell(30,0,$regd->codigo);

$pdf->SetXY(22,$y);
$pdf->MultiCell(120,0,$regd->articulo);

$pdf->SetXY(114,$y);
$pdf->MultiCell(20,0,utf8_decode($regd->cantidad." ".$regd->medida));

$pdf->SetXY(134,$y);
$pdf->MultiCell(25,0,$regd->precio_venta);

$pdf->SetXY(155,$y);
$pdf->MultiCell(25,0,$regd->subtotal);

$pdf->SetXY(197,$y);
$pdf->MultiCell(25,0,$regd->subtotal);

$pdf->SetXY(180,$y);
$pdf->MultiCell(25,0,$regd->descuento);

$total=$total+$regd->subtotal;
$y=$y+7;
 
}
require_once "Letras.php";
 
$V=new EnLetras(); 
$con_letra=strtoupper($V->ValorEnLetras($regv->total_venta,"CON"));
//$pdf->addCadreTVAs("SON:".$con_letra); 
$pdf->SetXY(27,177);
$pdf->MultiCell(120,0,$con_letra);

//calculamos totales
/*$pdf->addTVAs( $regv->impuesto, $regv->total_venta,"US$ ");
$pdf->addCadreEurosFrancs("IGV"." $regv->impuesto %");
$pdf->Output('Reporte de Venta','I');

$pdf->SetXY(187,153);
$pdf->MultiCell(20,0,$regv->total_venta." ".sprintf("%0.2F",total_venta-(total_venta*ipursto/(impuesto+100)));
//$pdf->MultiCell(20,0,sprintf("%0.2F", $total_venta-($total_venta*$igv/($igv+100))));
$pdf->SetXY(187,160);
$pdf->MultiCell(20,0,sprintf("%0.2F", ($total_venta*$igv/($igv+100))));
$pdf->SetXY(187,167);
$pdf->MultiCell(20,0,sprintf("%0.2F", $total_venta));*/


$pdf->Output();
?>