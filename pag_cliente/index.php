<?php
require "../config/Conexion.php";

$sql3="SELECT *FROM config WHERE estado='1' ";
$conf= ejecutarConsultaSimpleFila($sql3);
		
if($conf['tipo']==3){ $tipoc='BETA'; }else{ $tipoc='PRODUCCION'; }

$ruta='../api_cpe/'.$tipoc.'/'.$conf['ruc'].'/';
$archivo = (isset($_GET["archivo"])) ? $_GET["archivo"] : "";
if (file_exists($ruta.$archivo . ".XML")) {
    $validacion = "1";
} else {
    $validacion = "0";
}
?>

<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="favicon.ico">
        <title>CONSULTA DOCUMENTO ELECTRÓNICO</title>
        <link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="./css/theme.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-2">
                        <div class="col-md-6">	    
<img src="../images/tulogo.png" alt="" class="img-responsive"  />
                        </div>
                        <div class="col-md-6">	    
<img src="./img/cuadro01.jpg" alt="" class="img-responsive" />
                        </div>
                        <div class="col-md-12">  	    
                            <div class="col-md-12 form">
                                <form action="#" class="form-horizontal" id="login-form">
                                    <div class="form-group">
                                        <label class="col-lg-5 control-label">Tipo documento</label>
                                        <div class="col-lg-7">
                                            <select id="txtTipoDte" name="txtTipoDte" class="form-control">
                                                <option value="01" selected="selected">Factura</option>
                                                <option value="07">Nota Credito</option>
                                                <option value="08">Nota Debito</option>
                                                <option value="03">Boleta</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-5 control-label">Folio del Documento<br>(Serie-Correlativo)</label>
                                        <div class="col-lg-7"><input id="txtNroComprobante" name="txtNroComprobante"  type="text" class="form-control" ></div>
                                    </div>
                                    <!-- 
                                    <div class="form-group">
                                        <label class="col-lg-5 control-label">Fecha Emisión<br>(Ej: DD-MM-AAAA)</label>
                                        <div class="col-lg-7"><input type="text" class="form-control" ></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-5 control-label">Monto Total S/.</label>
                                        <div class="col-lg-7"><input type="text" class="form-control" ></div>
                                    </div>
                                    -->
                                    <div class="form-group">
                                        <div class="col-lg-5"></div>
                                        <div class="col-lg-7">
                                            <button type="button" onclick="BuscarComprobante()" class="btn btn-danger">Ver documento</button>
                                        </div>
                                    </div>                                    
                                    <div id="xmlComprobantes">

                                    </div>
                                </form>
                            </div></div>
                    </div> 
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </section>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="../css_js/jquery.min.js" type="text/javascript"></script>
    </body>
    
	
	
<script type='text/javascript'>

function BuscarComprobante() {
	
$("#xmlComprobantes").html('');
	
var ruc = "<?php echo $conf['ruc']; ?>";
var fichero = ruc + "-" + $('#txtTipoDte').val() + "-" + $('#txtNroComprobante').val();
var ndoc = $('#txtNroComprobante').val();
var ruta = "<?=$ruta?>";

$.ajax({
type: 'GET',
dataType: "json",
url: '../funcionesGlobales/valida-archivo.php', 
data: {	act:'1', ruta:ruta, ndoc:ndoc, fichero:fichero, ruc:ruc },
})
.done(function(data) { console.log(data);
if(data.error==0){ alert(data.mensaje); 
}else{
boton(ruta, fichero);	
}


 })
.fail(function(data) { console.log(data); });
	
}

function boton(ruta, archivo) {

var html;	

html='<div class="text-center"><h4>DESCARGA TU DOCUMENTO</h4><a href="../funcionesGlobales/descargaArchivo.php?archivo='+archivo+'.XML&ruta='+ruta+archivo+'.XML" ><button type="button" class="btn btn-primary btn-xs">CPE</button></a> <a href="../funcionesGlobales/descargaArchivo.php?archivo=R-'+archivo+'.XML&ruta='+ruta+'R-'+archivo+'.XML" ><button type="button" class="btn btn-primary btn-xs">CDR</button></a>  <a href="../funcionesGlobales/descargaArchivo.php?archivo=R-'+archivo+'.pdf&ruta='+ruta+archivo+'.pdf" ><button type="button" class="btn btn-primary btn-xs">PDF</button></a></div>';	
	
$("#xmlComprobantes").html(html);

//document.location = "facturacion/funcionesGlobales/descargaArchivo.php?archivo=" + archivo + "&ruta=" + ruta;
}


    </script>
	
	
	
</html>

