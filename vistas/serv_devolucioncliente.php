<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#devolucionc" data-toggle="tab" id="tab-devolucionc">Devolución Cliente</a></li>
    <li><a href="#lineadevolucionc" data-toggle="tab" id="tab-lineadevolucionc">Línea de la Devolución</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_devolucioncliente.js"> </script>
    <div class="tab-pane active in" id="devolucionc">
      <?php
        include_once('serv_devolucionc.php');
      ?>
    </div>
    <div class="tab-pane" id="lineadevolucionc">
    	<?php
          include_once('serv_lineadevolucionc.php');
        ?>
    </div>
  </div>
</div>