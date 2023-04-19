<?php

require 'header.php';

?>

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <!--<div class="content-wrapper">        
         Main content 
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Acerca de</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                     /.box-header
                     centro 
                    <div class="panel-body table-responsive" id="listadoregistros">

                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">

                    </div>
                    Fin centro 
                  </div>/.box 
              </div> /.col
          </div> /.row 
      </section /.content

    </div /.content-wrapper 
  Fin-Contenido-->
  <html>
<head>
   <meta charset="utf-8">
   <title>Mostrar Ventane Modal de forma Automático</title>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
   <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
   <script>
      $(document).ready(function()
      {
         $("#mostrarmodal").modal("show");
      });
    </script>
</head>
<body>
   <div class="modal fade" id="mostrarmodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <div class="modal-dialog" style="width: 30% !important;">
        <div class="modal-content">
           <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h3 align="center">Sistema de Gestión de Insumos</h3>
           </div>
           <div class="modal-body">
              <h4>MR Sistemas</h4>
             Versión 1.0 </br>
             El sistema fue diseñado por Miguel Angel Rios para la Dirección de Soporte Técnico
             de AGIP para ser utilizado dentro de la red interna del organismo.   
       </div>
           <div class="modal-footer">
           <a href="#" onclick="goBack()" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
           </div>
      </div>
   </div>
</div>
</body>

<script>
function goBack() {
  window.history.back();
}
</script>
</html>