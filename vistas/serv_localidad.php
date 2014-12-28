<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#pais" data-toggle="tab" id="tab-pais">País</a></li>
    <li><a href="#estado" data-toggle="tab" id="tab-estado">Estado</a></li>
    <!-- <li><a href="#ciudad" data-toggle="tab" id="tab-ciudad">Ciudad</a></li> -->
    <li><a href="#municipio" data-toggle="tab" id="tab-municipio">Municipio</a></li>
    <li><a href="#parroquia" data-toggle="tab" id="tab-parroquia">Parroquia</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_localidad.js"> </script>
    <div class="tab-pane active" id="pais">
      <?php include_once('serv_pais.php');?>
    </div>
    <div class="tab-pane" id="estado">
      <?php include_once('serv_estado.php');?>
    </div>
    <!-- <div class="tab-pane" id="ciudad">
      <?php include_once('serv_ciudad.php');?>
    </div> -->
    <div class="tab-pane" id="municipio">
      <?php include_once('serv_municipio.php');?>
    </div>
    <div class="tab-pane" id="parroquia">
      <?php include_once('serv_parroquia.php');?>
    </div>
  </div>
</div>