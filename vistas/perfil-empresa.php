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

if ($_SESSION['ventas']==1)
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
                          <h1 class="box-title">PERFIL BETA/PRODUCCION</h1>

                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Razón social</th>
                            <th>Ruc</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
<th>Opciones</th>
                            <th>Razón social</th>
                            <th>Ruc</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>

<div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                         
                         
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Razón social:</label>
                            <input type="hidden" name="id" id="id">
<input type="text" class="form-control" name="rsocial" id="rsocial" maxlength="50" placeholder="Nombre" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre comercial:</label>
<input type="text" class="form-control" name="ncomercial" id="ncomercial" maxlength="256" placeholder="Descripción">
                          </div>
                          
                          
<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
<label>RUC:</label>
<input type="text" class="form-control" name="ruc" id="ruc" maxlength="50" placeholder="Nombre" readonly >
</div>
<div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
<label>Direccion:</label>
<input type="text" class="form-control" name="dir" id="dir" maxlength="256" placeholder="Descripción">
</div>
                         
<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
<label>Departamento:</label>
<input type="text" class="form-control" name="departamento" id="departamento" maxlength="50" placeholder="Nombre" required>
</div>
<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-6">
<label>Provincia:</label>
<input type="text" class="form-control" name="provincia" id="provincia" maxlength="256" placeholder="Descripción">
</div>
                         
<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-6">
<label>Distrito:</label>
<input type="text" class="form-control" name="distrito" id="distrito" maxlength="50" placeholder="Nombre" required>
</div>
<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-6">
<label>COD.PAIS:</label>
<input type="text" class="form-control" name="codpais" id="codpais" maxlength="256" placeholder="Descripción">
</div>

<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-6">
<label>Ubigeo:</label>
<input type="text" class="form-control" name="ubigeo" id="ubigeo" maxlength="256" placeholder="Descripción">
</div>
                         
                         
<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
<label>Teléfono:</label>
<input type="text" class="form-control" name="fono" id="fono" maxlength="256" placeholder="Descripción">
</div>
<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-6">
<label>Usuario SOL:</label>
<input type="text" class="form-control" name="usuario" id="usuario" maxlength="256" placeholder="Descripción">
</div>
<div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-6">
<label>Clave SOL:</label>
<input type="text" class="form-control" name="clave" id="clave" maxlength="256" placeholder="Descripción">
</div>
<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-6">
<label>Contraseña Cert.:</label>
<input type="text" class="form-control" name="firma" id="firma" maxlength="256" placeholder="Descripción">
</div>
                         
<div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
<label>Correo:</label>
<input type="text" class="form-control" name="correo" id="correo" maxlength="256" placeholder="Correo">

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
<script type="text/javascript" src="scripts/perfil.js"></script>
 <script src="../css_js/bootstrap.min.js" type="text/javascript"></script>    

    
<?php 
}
ob_end_flush();
?>


