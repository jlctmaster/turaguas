<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#cliente" data-toggle="tab" id="tab-cliente">Cliente</a></li>
    <li><a href="#contacto" data-toggle="tab" id="tab-contacto">Contacto</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_cliente.js"> </script>
    <div class="tab-pane active" id="cliente">
      <?php include_once('serv_cliente.php');?>
    </div>
    <div class="tab-pane" id="contacto">
      <?php include_once('serv_contactocliente.php');?>
    </div>
  </div>
</div>