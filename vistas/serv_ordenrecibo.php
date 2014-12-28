<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#ordenrecibo" data-toggle="tab" id="tab-ordenrecibo">Órden de Recíbo</a></li>
    <li><a href="#lineaordenrecibo" data-toggle="tab" id="tab-lineaordenrecibo">Línea de la Órden</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_ordenrecibo.js"> </script>
    <div class="tab-pane active in" id="ordenrecibo">
      <?php
        include_once('serv_orencabezado.php');
      ?>
    </div>
    <div class="tab-pane" id="lineaordenrecibo">
    	<?php
          include_once('serv_orlinea.php');
        ?>
    </div>
  </div>
</div>