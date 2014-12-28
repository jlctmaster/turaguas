<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#listaprecio" data-toggle="tab" id="tab-listaprecio">Lista de Precio</a></li>
      <li><a href="#linea" data-toggle="tab" id="tab-linea">Línea</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
      <script src="../js/eft_lista_precio.js"> </script>
      <div class="tab-pane active in" id="listaprecio">
        <?php
          include_once('serv_listaprecio.php');
        ?>
      </div>
      <div class="tab-pane" id="linea">
    	<?php
          include_once('serv_linea.php');
        ?>
      </div>
    </div>
  </div>