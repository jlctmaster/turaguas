<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#ordencompra" data-toggle="tab" id="tab-ordencompra">Órden de Compra</a></li>
    <li><a href="#lineaordencompra" data-toggle="tab" id="tab-lineaordencompra">Línea de la Órden</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_ordencompra.js"> </script>
    <div class="tab-pane active in" id="ordencompra">
      <?php
        include_once('serv_ocencabezado.php');
      ?>
    </div>
    <div class="tab-pane" id="lineaordencompra">
    	<?php
          include_once('serv_oclinea.php');
        ?>
    </div>
  </div>
</div>