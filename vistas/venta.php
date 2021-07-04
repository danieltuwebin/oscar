<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['ventas'] == 1) {
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
                <h1 class="box-title">Venta Materia Prima <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true);selectMaxId('Boleta Electrónica');"> <i class="fa fa-plus-circle"></i> Agregar</button></h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>-Opciones-</th>
                    <th width="66">Condición</th>
                    <th width="110">F/Emi</th>
                    <th width="114">F/Venc</th>
                    <th width="48">Cliente</th>
                    <th width="52">Usuario</th>
                    <th width="76">Documento</th>
                    <th width="54">Número</th>
                    <th width="79">T/Venta</th>
                    <th width="56">Moneda</th>
                    <th width="85">T/Cambio</th>
                    <th width="60">Total</th>
                    <th width="46">Estado</th>
                  </thead>
                  <tbody>
                  </tbody>

                </table>
              </div>

              <div class="panel-body table-responsive" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Cliente(*):</label>
                    <input type="hidden" name="idventa" id="idventa">
                    <select id="idcliente" name="idcliente" class="form-control selectpicker" data-live-search="true" required>

                    </select>
                  </div>

                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Tipo Comprobante(*):</label>
                    <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required>
                      <option value="Boleta Electrónica">Boleta</option>
                      <option value="Factura Electrónica">Factura</option>
                      <option value="Contrato">Contrato</option>
                      <option value="Ticket">Ticket</option>
                    </select>
                  </div>

                  <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <label>Condicion de Venta(*):</label>
                    <select class="form-control select-picker" name="condicionv" id="condicionv" required>
                      <option value="Contado">Contado</option>
                      <option value="Credito">Credito</option>

                    </select>
                  </div>

                  <div class="form-group col-lg-2 col-md-4 col-sm-4 col-xs-12">
                    <label>Fecha de Emisión(*):</label>
                    <input type="date" class="form-control" name="fecha_emision" id="fecha_emision" required="">
                  </div>
                  <div class="form-group col-lg-2 col-md-4 col-sm-4 col-xs-12">
                    <label>Fecha de Vencimiento(*):</label>
                    <input type="date" class="form-control" name="fecha_vencimiento" id="fecha_vencimiento" required="">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Serie:</label>
                    <input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie" style="text-align:center;">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Número:</label>
                    <input type="text" class="form-control" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Número" style="text-align:center;" required="">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label for=imputPlaca>Impuesto:</label>
                    <div class="input-group has-success">
                      <input type="text" class="form-control" name="impuesto" id="impuesto" style="text-align:center;" required="">
                      <div class="input-group-addon">%</div>
                    </div>
                  </div>

                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Nº de orden:</label>
                    <input type="text" class="form-control" name="nroorden" id="nroorden" maxlength="10" placeholder="Nº orden" style="text-align:center;">
                  </div>

                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Obra:</label>
                    <input type="text" class="form-control" name="obra" id="obra" maxlength="10" placeholder="Obra" style="text-align:center;">
                  </div>




                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Guia de Remision:</label>
                    <input type="text" class="form-control" name="guia_remi" id="guia_remi" maxlength="10" placeholder="guia de remision" style="text-align:center;">
                  </div>



                  <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <label>Moneda(*):</label>
                    <select name="moneda" id="moneda" class="form-control selectpicker" required>
                      <option value="SOLES">Soles</option>
                      <option value="DOLARES AMERICANOS">Dolares</option>
                    </select>
                  </div>


                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label for=imputPlaca>Tipo de Cambio:</label>
                    <div class="input-group has-success">
                      <input type="text" class="form-control" name="tipo_cambio" id="tipo_cambio" maxlength="10" placeholder="0.00" style="text-align:center;">
                      <div class="input-group-addon">T.C</div>
                    </div>
                  </div>

                  <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <label for=imputPlaca>Total en Soles:</label>
                    <div class="input-group has-success">
                      <input type="text" class="form-control" name="total_soles" id="total_soles" maxlength="10" placeholder="0.00" style="text-align:center;">
                      <div class="input-group-addon">Soles</div>
                    </div>
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
                        <th>Cantidad</th>
                        <th>Precio Venta</th>
                        <th>Descuento</th>
                        <th>Stock</th>
                        <th>Subtotal</th>
                      </thead>
                      <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>TOTAL</th>
                        <th>
                          <h4 id="total">US$. 0.00</h4><input type="hidden" name="total_venta" id="total_venta">
                        </th>
                      </tfoot>
                      <tbody>

                      </tbody>
                    </table>
                  </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                <th>Precio Venta</th>
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
                <th>Precio Venta</th>
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
  <script type="text/javascript" src="scripts/venta.js"></script>
<?php
}
ob_end_flush();
?>