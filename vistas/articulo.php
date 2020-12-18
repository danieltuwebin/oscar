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
                    <div class="box-header with-border">
                          <h1 class="box-title">Artículo <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> <a target="_blank" href="../reportes/rptarticulos.php"><button class="btn btn bg-orange" ><i class="fa fa-file"></i> Reporte</button></a> <a target="_blank" href="../reportes/rptlista.php"><button class="btn btn bg-blue" ><i class="fa fa-file"></i> Lista De Precios</button></a>
                          </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Código</th>
                            <th>Stock</th>
                            <th>Presentación</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Código</th>
                            <th>Stock</th>
                            <th>Presentación</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body table-responsive" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre(*):</label>
                            <input type="hidden" name="idarticulo" id="idarticulo">
                            <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Categoría(*):</label>
                            <select id="idcategoria" name="idcategoria" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Stock(*):</label>
                            <input type="number-decimal" class="form-control" name="stock" placeholder="0.00" id="stock" required>
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Unidad de Medida(*):</label>
                            <select name="medida" id="medida" class="form-control selectpicker" required="">
                               <option value=" ">------Seleccione Tipo de Medida------</option>
                               <option value="Kg.">Kilo</option>
                               <option value="BL.">Bolsa</option>
                               <option value="Und.">Unidad</option>
                               <option value="Mt.">Metro</option>
                               <option value="M2.">Metro Cuadrado</option>
                            </select>
                          </div>                         
                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Presentación:</label>
                            <input type="text" class="form-control" name="presentacion" id="presentacion" maxlength="20" placeholder="Presentación">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Tipo Tela:</label>
                            <select name="tipotela" id="tipotela" class="form-control selectpicker" required="">
                               <option value=" ">------Seleccione Tipo tela------</option>
                               <option value="1">Ancho 1.5 mts</option>
                               <option value="2">Ancho 2.0 mts</option>
                            </select>
                          </div>                           
                          
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Descripción:</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="1000" placeholder="Descripción">
                          </div>

                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Imagen:</label>
                            <input type="file" class="form-control" name="imagen" id="imagen">
                            <input type="hidden" name="imagenactual" id="imagenactual">
                            <img src="" width="250px" height="220px" id="imagenmuestra">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Código:</label>
                            <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Código de Barras">
                            <button class="btn btn-success" type="button" onclick="generarbarcode()">Generar</button>
                            <button class="btn btn-info" type="button" onclick="imprimir()">Imprimir</button>
                            <div id="print">
                              <svg id="barcode"></svg>
                            </div>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
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