<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#articulo" data-toggle="tab" id="tab-articulo">Artículo</a></li>
    <li><a href="#conversion" data-toggle="tab" id="tab-conversion">Conversión</a></li>
    <li><a href="#configuracion_articulo" data-toggle="tab" id="tab-configuracion_articulo">Configuración</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_articulo_conversion_configuracion.js"> </script>
    <div class="tab-pane active in" id="articulo">
      <?php
        include_once('serv_articulo.php');
      ?>
    </div>
    <div class="tab-pane" id="conversion">
    	<?php
        include_once('serv_conversion.php');
      ?>
    </div>
    <div class="tab-pane" id="configuracion_articulo">
      <?php
        include_once('serv_configuracion_articulo.php');
      ?>
    </div>
  </div>
</div>