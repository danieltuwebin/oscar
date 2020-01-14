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
 
if ($_SESSION['almacen']==1)
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
                          <h1 class="box-title"> Guia De Remision <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Generar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Fecha Emision</th>
                            <th>Fecha Traslado</th>
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Numero De Guia</th>
                            <th>Documento de Pago</th>
                            <th>Motivo de Traslado</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Fecha Emision</th>
                            <th>Fecha Traslado</th>
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Numero De Guia</th>
                            <th>Documento de Pago</th>
                            <th>Motivo de Traslado</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                          
                    <div class="panel-body table-responsive"  id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Cliente(*):</label>
                            <input type="hidden" name="idventa" id="idventa">
                            <select id="idcliente" name="idcliente" class="form-control selectpicker" data-live-search="true" required>
                               
                            </select>
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Numero de Guia:</label>
                            <input type="text" class="form-control" name="num_guia" id="num_guia" maxlength="7" placeholder="00000" style="text-align:center;">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Comprobante de Pago(*):</label>
                            <select name="doc_pago" id="doc_pago" class="form-control selectpicker" required="">
                               <option value="Boleta">Boleta</option>
                               <option value="Factura">Factura</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <label>Serie y Número de Doc Pago:</label>
                            <input type="text" class="form-control" name="num_doc_pago" id="num_doc_pago" maxlength="10" placeholder="Número" style="text-align:center;" required="">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Domicilio De Partida</label>
                            <input type="text" class="form-control" name="domi_partida" id="domi_partida" maxlength="100" placeholder="ingresar direccion de partida" style="text-align:center;" required="">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <label>Domicilio De llegada</label>
                            <input type="text" class="form-control" name="domi_llegada" id="domi_llegada" maxlength="100" placeholder="ingresar direccion de llegada" style="text-align:center;" required="">
                          </div>
                          <div class="form-group col-lg-2 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha de Emisión(*):</label>
                            <input type="date" class="form-control" name="fecha_emision" id="fecha_emision" required="">
                          </div>
                          <div class="form-group col-lg-2 col-md-4 col-sm-4 col-xs-12">
                            <label>Fecha de Traslado(*):</label>
                            <input type="date" class="form-control" name="fecha_traslado" id="fecha_traslado" required="">
                          </div>

                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Marca y numero de placa:</label>
                            <input type="text" class="form-control" name="marca_placa" id="marca_placa" maxlength="20" placeholder="guia de remision" style="text-align:center;">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Certificado/inscripcion:</label>
                            <input type="text" class="form-control" name="certi_inscripcion" id="certi_inscripcion" maxlength="10" placeholder="00000000" style="text-align:center;">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-6">
                            <label>Licencia de Conducir N°:</label>
                            <input type="text" class="form-control" name="lic_conducir" id="lic_conducir" maxlength="10" placeholder="00000000" style="text-align:center;">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-6">
                            <label>Nombre o Razon :</label>
                            <input type="text" class="form-control" name="rason_transportista" id="rason_transportista" maxlength="20" placeholder="Nombre del Transportista" style="text-align:center;">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-6">
                            <label>RUC :</label>
                            <input type="text" class="form-control" name="ruc_transportista" id="ruc_transportista" maxlength="11" placeholder="RUC de Transportista" style="text-align:center;">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Motivo De Traslado(*):</label>
                            <select class="form-control select-picker" name="motivo_traslado" id="motivo_traslado" required>
                               <option value="Venta">Venta</option>
                               <option value="Venta Sugeta a Confirmar">Venta Sugeta a Confirmar</option>
                               <option value="Compra">Compra</option>
                               <option value="venta contraentrega a terceros">venta contraentrega a terceros</option>
                               <option value="Traslado">Traslado</option>
                               <option value="Otro">Otro</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <a data-toggle="modal" href="#myModal">           
                              <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-search"></span> Agregar Articulos</button>
                            </a>
                          </div>
                           
                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Descripcion</th>
                                    <th>Cantidad/Bultos</th>
                                    <th>Peso</th>
                                    <th>Peso Total</th>
                                </thead>
                                  <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4></h4> </th> 
                                  </tfoot>
                                <tbody>
                                   
                                </tbody>
                            </table>
                          </div>
 
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="#btnGuardar">
                            <button class="btn btn-primary" type="submit" ><i class="fa fa-save"></i> Guardar</button>
 
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
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
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
}
else
{
  require 'noacceso.php';
}
 
require 'footer.php';
?>
<script type="text/javascript" src="scripts/guia.js"></script>
<?php 
}
ob_end_flush();
?>