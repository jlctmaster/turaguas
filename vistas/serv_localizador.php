<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#ubicacion" data-toggle="tab" id="tab-ubicacion">Ubicación</a></li>
    <li><a href="#almacen" data-toggle="tab" id="tab-almacen">Almacén</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_localizador.js"> </script>
    <div class="tab-pane active in" id="ubicacion">
      <?php
        include_once('serv_ubicacion.php');
      ?>
    </div>
    <div class="tab-pane" id="almacen">
    	<?php
          include_once('serv_almacen.php');
        ?>
    </div>
  </div>
</div>