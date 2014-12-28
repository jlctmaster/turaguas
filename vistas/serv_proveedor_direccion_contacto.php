<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#proveedor" data-toggle="tab" id="tab-proveedor">Proveedor</a></li>
    <li><a href="#contacto" data-toggle="tab" id="tab-contacto">Contacto</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_proveedor.js"> </script>
    <div class="tab-pane active" id="proveedor">
      <?php include_once('serv_proveedor.php');?>
    </div>
    <div class="tab-pane" id="contacto">
      <?php include_once('serv_contactoproveedor.php');?>
    </div>
  </div>
</div>