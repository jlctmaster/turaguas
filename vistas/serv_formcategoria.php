<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#categoria" data-toggle="tab" id="tab-categoria">Categoría</a></li>
      <li><a href="#subcategoria" data-toggle="tab" id="tab-subcategoria">Sub-Categoría</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
    <script src="../js/eft_categoria.js"> </script>
      <div class="tab-pane active in" id="categoria">
        <?php
          include_once('serv_categoria.php');
        ?>
      </div>
      <div class="tab-pane" id="subcategoria">
    	<?php
          include_once('serv_subcategoria.php');
        ?>
      </div>
  </div>