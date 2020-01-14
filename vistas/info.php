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
if($_SESSION['almacen']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                  <div class="box">
                      <h1 class="box-title" style="font-size:40px;"> Para Mayor Informacion Comunicate o Escribenos </h1>
                    <div class="box-header with-border">
                            
                            <h1>Celular: </h1><p style="font-size:20px;">987087371</p>
                            <h1>Correo: </h1> <p style="font-size:20px;">pumasoftperu@gmail.com </p>
                        <div class="box-tools pull-right">
                        </div>
                    </div> 
                    <!-- /.box-header -->
                    <!-- centro -->                                     

                    <!--Fin centro -->
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
<script type="text/javascript" src="../public/js/JsBarcode.all.min.js"></script>
<script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
<script type="text/javascript" src="scripts/articulo.js"></script>
<?php
}
ob_end_flush();
?>