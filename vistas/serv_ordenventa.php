<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#ordenventa" data-toggle="tab" id="tab-ordenventa">Órden de Venta</a></li>
    <li><a href="#lineaordenventa" data-toggle="tab" id="tab-lineaordenventa">Línea de la Órden</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_ordenventa.js"> </script>
    <div class="tab-pane active in" id="ordenventa">
      <?php
        include_once('serv_ovencabezado.php');
      ?>
    </div>
    <div class="tab-pane" id="lineaordenventa">
    	<?php
          include_once('serv_ovlinea.php');
        ?>
    </div>
  </div>
</div>