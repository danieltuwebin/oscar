<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
 
if (!isset($_SESSION["nombre"]))
{
 header("Location: login.html");
}
else
{
require 'header.php';

if($_SESSION['escritorio']==1)
{
  require_once "../modelos/Consultas.php";
  $consulta = new Consultas();
  $rsptac = $consulta->totalcomprahoy();
  $regc=$rsptac->fetch_object();
  $totalc=$regc->total_compra;

  $rsptacd = $consulta->totalcomprahoydol();
  $regcd=$rsptacd->fetch_object();
  $totalcd=$regcd->total_compra;
   
  $rsptav = $consulta->totalventahoy();
  $regv=$rsptav->fetch_object();
  $totalv=$regv->total_venta;

  $rsptavd = $consulta->totalventahoydol();
  $regvd=$rsptavd->fetch_object();
  $totalvd=$regvd->total_venta;

  //Datos para mostrar el gráfico de barras de las compras
  $compras10 = $consulta->comprasultimos_10dias();
  $fechasc='';
  $totalesc='';
  while ($regfechac= $compras10->fetch_object()) {
    $fechasc=$fechasc.'"'.$regfechac->emision .'",';
    $totalesc=$totalesc.$regfechac->total .','; 
  }

  $compras10d = $consulta->comprasultimos_10dias_dol();
  $fechascd='';
  $totalescd='';
  while ($regfechacd = $compras10d->fetch_object()) {
    $fechascd=$fechascd.'"'.$regfechacd->emision .'",';
    $totalescd=$totalescd.$regfechacd->total .','; 
  }

  //Quitamos la última coma
  $fechasc=substr($fechasc, 0, -1);
  $totalesc=substr($totalesc, 0, -1);

  $fechascd=substr($fechascd, 0, -1);
  $totalescd=substr($totalescd, 0, -1);

  //Datos para mostrar el gráfico de barras de las ventas
  $ventas12 = $consulta->ventasultimos_12meses();
  $fechasv='';
  $totalesv='';
  while ($regfechav= $ventas12->fetch_object()) {
    $fechasv=$fechasv.'"'.$regfechav->fecha .'",';
    $totalesv=$totalesv.$regfechav->total .','; 
  }
  //Quitamos la última coma
  $fechasv=substr($fechasv, 0, -1);
  $totalesv=substr($totalesv, 0, -1);


  $ventas12d = $consulta->ventasultimos_12meses_dol();
  $fechasvd='';
  $totalesvd='';
  while ($regfechavd= $ventas12d->fetch_object()) {
    $fechasvd=$fechasvd.'"'.$regfechavd->fecha .'",';
    $totalesvd=$totalesvd.$regfechavd->total .','; 
  }
  //Quitamos la última coma
  $fechasvd=substr($fechasvd, 0, -1);
  $totalesvd=substr($totalesvd, 0, -1);

?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Escritorio </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body ">
                       <div class="col-lg-6 col-md-6 col-ms-6 col-xs-6">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                              <h4 style="font-size:17px;">
                                  <strong>   S/: <?php echo $totalc; ?> </strong>
                                </h4>
                               <h4 style="font-size:17px;">
                                  <strong>US$: <?php echo $totalcd; ?> </strong>
                                </h4> 
                                <p>Compras Del Dia</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                              </div>
                              <a href="ingreso.php" class="small-box-footer"> Ir al Modulo de Compras<i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                       </div>
                       <div class="col-lg-6 col-md-6 col-ms-6 col-xs-6">
                        <div class="small-box bg-green">
                            <div class="inner">
                              <h4 style="font-size:17px;">
                                  <strong>S/ : <?php echo $totalv; ?></strong>
                                </h4>
                                <h4 style="font-size:17px;">
                                  <strong>US$: <?php echo $totalvd; ?></strong>
                                </h4>
                                <p>Ventas Del Dia</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                              </div>
                              <a href="venta.php" class="small-box-footer">Ir al Modulo de Ventas <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                       </div> 

                    </div>

                    <div class="panel-body">
               
                       <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                                Compras de los últimos 10 días SOLES
                            </div>
                            <div class="box-body">
                              <canvas id="compras" width="400" height="300"></canvas>
                            </div>
                          </div>
                        </div>


                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                                Compras de los últimos 10 días DOLARES
                            </div>
                            <div class="box-body">
                              <canvas id="comprasd" width="400" height="300"></canvas>
                            </div>
                          </div>
                          
                    </div>
                       
                    <div class="panel-body">
                       <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                                Ventas de los últimos 12 meses en soles
                            </div>
                            <div class="box-body">
                              <canvas id="ventas" width="400" height="300"></canvas>
                            </div>
                          </div>
                        </div>     

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                                Ventas de los últimos 12 meses en dolares
                            </div>
                            <div class="box-body">
                              <canvas id="ventasd" width="400" height="300"></canvas>
                            </div>
                          </div>
                        </div>                       
                    </div>                     
                    
                    <!--Fin centro -->
              <iframe id="widgetMataf" src="https://www.mataf.net/es/widget/conversiontab-PEN-USD?list=CAD|CHF|GBP|IDR|JPY|MYR|USD|&amp;a=1" style="border: none; overflow:hidden; background-color: transparent; height: 350px; width: 300px"></iframe>
                  </div><!-- /.box -->
              </div><!-- /.col -->


              
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

<?php
}
else
{
  require 'noacceso.php';
}
require 'footer.php';
?>
<script src="../public/js/chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script>
<script type="text/javascript">
var ctx = document.getElementById("compras").getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasc; ?>],
        datasets: [{
            label: 'Compras en S/. de los últimos 10 días',
            data: [<?php echo $totalesc; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


var ctxd = document.getElementById("comprasd").getContext('2d');
var comprasd = new Chart(ctxd, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechascd; ?>],
        datasets: [{
            label: 'Compras en US$. de los últimos 10 días',
            data: [<?php echo $totalescd; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
 
 
 
var ctx = document.getElementById("ventas").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasv; ?>],
        datasets: [{
            label: 'Ventas en S/. de los últimos 12 meses',
            data: [<?php echo $totalesv; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


var ctxd = document.getElementById("ventasd").getContext('2d');
var ventasd = new Chart(ctxd, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasvd; ?>],
        datasets: [{
            label: 'Ventas en US$. de los últimos 12 meses',
            data: [<?php echo $totalesvd; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
</script> 
<?php
}
ob_end_flush();
?>