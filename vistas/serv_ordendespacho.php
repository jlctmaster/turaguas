<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#ordendespacho" data-toggle="tab" id="tab-ordendespacho">Órden de Despacho</a></li>
    <li><a href="#lineaordendespacho" data-toggle="tab" id="tab-lineaordendespacho">Línea de la Órden</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_ordendespacho.js"> </script>
    <div class="tab-pane active in" id="ordendespacho">
      <?php
        include_once('serv_odencabezado.php');
      ?>
    </div>
    <div class="tab-pane" id="lineaordendespacho">
    	<?php
          include_once('serv_odlinea.php');
        ?>
    </div>
  </div>
</div>