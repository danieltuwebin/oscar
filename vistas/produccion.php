<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['produccion'] == 1) {
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
                <h1 class="box-title">Producción <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"> <i class="fa fa-plus-circle"></i>Agregar</button></h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th width="120">Opciones</th>
                    <th>Condicion</th>
                    <th>Fecha de producción</th>
                    <th>Nombre de producto</th>
                    <th>Medidas</th>
                    <th>Usuario</th>
                    <th>Nº de produccion</th>
                    <th>Ipu prod</th>
                    <th>Total Producción </th>
                    <th>Moneda</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>

                  </tfoot>
                </table>
              </div>

              <div class="panel-body table-responsive" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">

                  <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <label>Condición(*):</label>
                    <select class="form-control selectpicker" name="condicionp" id="condicionp" required>
                      <option value="Producción">Producción</option>
                      <option value="Presupuesto">Presupuesto</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <label>Moneda(*):</label>
                    <select name="moneda" id="moneda" class="form-control selectpicker" required>
                      <option value="SOLES">Soles</option>
                      <option value="DOLARES AMERICANOS">Dolares</option>
                    </select>
                  </div>
                  <!--
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Nombre de producto(*):</label>
                    <input type="hidden" name="idproduccion" id="idproduccion">
                    <input type="text" class="form-control" name="nomb_produccion" id="nomb_produccion" maxlength="50" placeholder="nombre de producto" style="text-align:center;" required="">
                  </div>
                  -->
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Nombre de producto(*):</label>
                    <input type="hidden" name="idproduccion" id="idproduccion">
                    <input type="hidden" name="nomb_produccion" id="nomb_produccion" >
                    <select id="idarticuloC" name="idarticuloC" class="form-control selectpicker" data-live-search="true" maxlength="50" required="">
                    </select>
                  </div>

                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                    <label>Fecha de producción(*):</label>
                    <input type="date" class="form-control" name="fecha_produccion" id="fecha_produccion" required="">
                  </div>

                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                    <label>Med. ancho(*):</label>
                    <input type="number" class="form-control" name="medida_ancho" id="medida_ancho" min="0" max="100" step="0.50" required="">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-3 col-xs-12">
                    <label>Med. alto(*):</label>
                    <input type="number" class="form-control" name="medida_alto" id="medida_alto" min="0" max="100" step="0.50" required="">
                  </div>

                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Nº de prod.</label>
                    <input type="text" class="form-control" name="num_prod" id="num_prod" maxlength="10" placeholder="0000000" style="text-align:center;" required="">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label for=imputPlaca>Impuesto:</label>
                    <div class="input-group has-success">
                      <input type="text" class="form-control" maxlength="10" placeholder="18" name="ipu_produccion" id="ipu_produccion" style="text-align:center;" required="">
                      <div class="input-group-addon">%</div>
                    </div>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <div class="input-group has-success"><br>
                    <button id="btnCalcular" type="button" class="btn btn-success"> <span class="fa fa-money"></span>&nbsp;Calcular</button>
                    </div>
                  </div>                  


                  <!--                   <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                  <label for=imputPlaca style="color:#FFFFFF";>x</label>
                    <a data-toggle="modal" href="#myModal">
                      <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-search"></span> Agregar Artículos</button>
                    </a>
                  </div>
                    -->
                  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color:#A9D0F5">
                        <th>Id</th>
                        <th style="display:none">TipoTela</th>
                        <th>Artículo</th>
                        <th>Medida</th>
                        <th>Cantidad</th>
                        <th>Precio Prod</th>
                        <th>Subtotal</th>
                      </thead>

                      <tfoot>
                        <th></th>
                        <th style="display:none"></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>TOTAL</th>
                        <th>
                          <h4 id="total"> 0.00</h4><input type="hidden" name="total_produccion" id="total_produccion">
                        </th>
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
  <script type="text/javascript" src="scripts/produccion.js?1.0"></script>
<?php
}
ob_end_flush();
?>