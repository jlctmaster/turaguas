<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#grupo" data-toggle="tab" id="tab-grupo">Grupo de Motivos</a></li>
    <li><a href="#motivodev" data-toggle="tab" id="tab-motivo">Motivos</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_motivodevolucion.js"> </script>
    <div class="tab-pane active in" id="grupo">
      <?php
        include_once('serv_grupo.php');
      ?>
    </div>
    <div class="tab-pane" id="motivodev">
    	<?php
          include_once('serv_motivodev.php');
        ?>
    </div>
  </div>
</div>