<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['conversion'] == 1) {
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
                <h1 class="box-title">Conversión <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"> <i class="fa fa-plus-circle"></i>Agregar</button></h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th width="120">Opciones</th>
                    <th>Id</th>
                    <th>Codigo Art.</th>
                    <th>Nombre Articulo</th>
                    <th>observacion</th>
                    <th>Usuario</th>
                    <th>Fecha Grabacion</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>
              </div>

              <div class="panel-body table-responsive" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">

                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Nombre de producto(*):</label>
                    <input type="hidden" name="idconversion" id="idconversion">
                    <select id="idarticuloC" name="idarticuloC" class="form-control selectpicker" data-live-search="true" maxlength="50" required="">

                    </select>
                  </div>

                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                    <label>Fecha de producción(*):</label>
                    <input type="date" class="form-control" name="fecha_produccion" id="fecha_produccion" required="">
                  </div>

                  <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <a data-toggle="modal" href="#myModal">
                      <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-search"></span> Agregar Artículos</button>
                    </a>
                  </div>

                  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color:#A9D0F5">
                        <th>Opciones</th>
                        <th>Artículo</th>
                        <th>Medida</th>                        
                        <th>Cantidad</th>
                      </thead>

                      <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>                        
                        <th></th>
                      </tfoot>
                      <tbody>

                      </tbody>
                    </table>
                  </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="guardar">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                    <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 65% !important;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Seleccione un Artículo</h4>
          </div>
          <div class="panel-body table-responsive">
            <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
              <thead>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Precio venta</th>
                <th>Imagen</th>
              </thead>
              <tbody>

              </tbody>
              <tfoot>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Precio venta</th>
                <th>Imagen</th>
              </tfoot>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin modal -->
  <?php
  } else {
    require 'noacceso.php';
  }


  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/conversion.js"></script>
<?php
}
ob_end_flush();
?>