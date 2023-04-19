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

if ($_SESSION['consultav']==1)
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
                          <h1 class="box-title">Consulta de Entrega de Insumos por fecha y articulo</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                          <label>Fecha Inicio</label>
                          <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                          <label>Fecha Fin</label>
                          <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-inline col-lg-4 col-md-4 col-sm-6 col-xs-12">
                          <label>Articulo</label>
                          <select name="idarticulo" id="idarticulo" class="form-control selectpicker" data-live-search="true" required>                         	
                          </select> 
                        </div>
                        <div class="form-inline col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label style="color:white;">..................</label>
                             <button class="btn btn-success"  onclick="listar()">Mostrar Seleccion</button>
                        </div>
                        <div class="form-inline col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label style="color:white;">..................</label>
                             <button class="btn btn-success" whith="30" onclick="listartodo()">Mostrar Todos</button>
                        </div>

                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th width="10%">Fecha</th>
                            <th width="4%">Remito</th>
                            <th width="20%">Cliente</th>
                            <th width="20%">Articulo</th>
                            <th width="18%">Descripcion</th>
                            <th class="sum" width="4%">Cantidad</th>
                            <th width="20%">Usuario</th>
                            <th width="4%">Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th width="10%"></th>
                            <th width="4%"></th>
                            <th width="20%"></th>
                            <th width="20%"></th>
                            <th width="18%"></th>
                            <th width="4%"></th>
                            <th width="20%"></th>
                            <th width="4%"></th>
                          </tfoot>
                        </table>
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
<script type="text/javascript" src="scripts/ventasfechaarticulo.js"></script>
<?php 
}
ob_end_flush();
?>



