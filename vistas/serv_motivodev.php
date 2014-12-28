<div class="form_externo" >
  <?php
  if(!empty($nid_motivodevoluciongrupo) && !empty($cdescripciongrupo)){
    $_SESSION['cdescripciongrupo']= $cdescripciongrupo;
    $_SESSION['nid_motivodevoluciongrupo']=$nid_motivodevoluciongrupo;
  }
  if(isset($_SESSION['datos']['cdescripcionmotivo'])){ 
    $disabledRCmotivodev='disabled';
    $disabledMDmotivodev='';
    $estatusmotivodev=null;
  }else {
    $disabledRCmotivodev='';
    $disabledMDmotivodev='disabled';
  }
  if ($estatus=="Activo"){
         $disabledRC='disabled';
         $disabledMD='';
  }
       else if ($estatus=="Desactivado") {
         $disabledRC='disabled';
         $disabledMD='disabled';
       }
       else {
         $disabledRC='';
         $disabledMD='disabled';
       }
  $servicios='motivodevolucion';
  if(isset($_SESSION['datos'])){
    @$cdescripcionmotivo=$_SESSION['datos']['cdescripcionmotivo'];
    @$nid_motivodevolucion_padre=$_SESSION['datos']['nid_motivodevolucion_padre'];
    @$nid_motivodevolucion=$_SESSION['datos']['nid_motivodevolucion'];
    @$cdescripciongrupo=$_SESSION['datos']['cdescripciongrupo'];
    @$estatusmotivodev=$_SESSION['datos']['estatusmotivodev'];
  }
  else{
    @$cdescripcionmotivo=$_GET['cdescripcionmotivo'];
    @$cdescripciongrupo=$_GET['cdescripciongrupo'];
    @$nid_motivodevoluciong=$_GET['nid_motivodevolucion'];
    @$nid_motivodevolucion_padre=$_GET['nid_motivodevolucion_padre'];
    @$estatusmotivodev=$_GET['estatusmotivodev'];
  if ($estatus=="Activo"){
	$disabledRC='disabled';
	$disabledMD='';
  }
  else if ($estatus=="Desactivado") {
	 $disabledRC='disabled';
	 $disabledMD='disabled';
  }
  else {
	 $disabledRC='';
	 $disabledMD='disabled';
  }
 }
  if(!isset($_GET['l'])){?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_motivodevolucion.php" method="post" id="form2">
      <table border="0" style="width: 100%">
        <tr>
          <td><span class="texto_form">Grupo</span></td>
          <td>
            <?php if(!empty($nid_motivodevoluciongrupo)){?>
              <input type="hidden" id="nid_motivodevolucion_padre" name="nid_motivodevolucion_padre" value="<?= $nid_motivodevolucion_padre; ?>">
              <input title="El código del grupo proviene de la pestaña anterior" name="name_grupomotivos" id="name_grupomotivos" type="text" readonly value="<?= $nid_motivodevolucion_padre."_".$cdescripciongrupo;?>" /> 
            <?php }else{?>
              <input type="hidden" id="nid_motivodevolucion_padre" name="nid_motivodevolucion_padre" value="<?= $_SESSION['nid_motivodevoluciongrupo']; ?>">
              <input title="El código del grupo proviene de la pestaña anterior" name="name_grupomotivos" id="name_grupomotivos" type="text" readonly value="<?= $_SESSION['nid_motivodevoluciongrupo']."_".$_SESSION['cdescripciongrupo'];?>" /> 
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Código</span></td>
          <td><input title="El código del motivo es generado por el sistema" name="nid_motivodevolucion" id="nid_motivodevolucion" type="text" size="10" readonly value="<?= $nid_motivodevolucion;?>" /> </td>
        </tr>
        <tr>
          <td><span class="texto_form">Motivo</span></td>
          <td> <input title="Ingrese la descripción del motivo" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcionmotivo" id="cdescripcionmotivo" type="text" size="50" value="<?= $cdescripcionmotivo;?>" required/></td>
        </tr>
        <?php echo '<tr><td colspan="2" class="'.$estatusmotivodev.'" id="estatus_registro">'.$estatusmotivodev.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
            <?php
              imprimir_boton($disabledRCmotivodev,$disabledMDmotivodev,$estatusmotivodev,$servicios,"motivodev");
            ?>         
          </td>
        </tr>
      </table>
    </form>
  </fieldset>
  <br>
  <?php }else{ 
  $cdescripcionmotivo = $_GET['cdescripcionmotivo'];
  ?>
  <script type="text/javascript">
    function reload_tabmotivodev(tab){
      cdescripcionmotivo = document.getElementById('cdescripcionmotivo').value;
      location.href="menu_principal.php?motivodevolucion&l&cdescripcionmotivo="+cdescripcionmotivo+tab;
    }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td><span clas="texto_form">Motivos</span></td>
    </tr>
    <tr>
      <td>
        <input title="Ingrese la descripcion del motivo de devolución" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcionmotivo" id="cdescripcionmotivo" type="text" size="50" value="<?= $cdescripcionmotivo;?>" />
      </td>
    </tr>
  </table>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabmotivodev('#motivodev')">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?motivodevolucion#motivodev" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_motivodev.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=motivodev';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:20%;">C&oacute;digo Motivo</td>
      <td align='left'>Motivos</td>
      <td align='left'>C&oacute;digo Grupo</td>
      <td align='left'>Grupo de Motivos</td>
    </tr>
    <?php
    //Conexión a la base de datos 
    require_once("../clases/class_bd.php");
    $pgsql=new Conexion();
    $clausuleWhere = "WHERE m.dfecha_desactivacion IS NULL ";
    if($cdescripcionmotivo!=""){
      $clausuleWhere.="AND m.cdescripcion LIKE '%$cdescripcionmotivo%'";
    }
    //Sentencia sql (sin limit) 
    $_pagi_sql = "SELECT m.cdescripcion cdescripcionmotivo, m.nid_motivodevolucion, m.nid_motivodevolucion_padre, g.cdescripcion grupo 
    FROM facturacion.tmotivo_devolucion m 
    INNER JOIN facturacion.tmotivo_devolucion g on m.nid_motivodevolucion_padre = g.nid_motivodevolucion 
    $clausuleWhere
    ORDER BY m.nid_motivodevolucion DESC";
    //Booleano. Define si se utiliza pg_num_rows() (true) o COUNT(*) (false).
    $_pagi_conteo_alternativo = true; 
    //cantidad de resultados por página (opcional, por defecto 20) 
    $_pagi_cuantos = 10; 
    //Cadena que separa los enlaces numéricos en la barra de navegación entre páginas.
    $_pagi_separador = " ";
    //Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
    $_pagi_nav_num_enlaces=5;
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente 
    @include("../librerias/paginador/paginator.inc.php"); 
    //Leemos y escribimos los registros de la página actual 
    while($row = pg_fetch_array($_pagi_result)){ 
      echo "<tr  style='cursor: pointer;' id='".$row['cdescripcionmotivo']."' onclick='enviarFormM(this.id)'>
	        <td style='width:20%;'>".$row['nid_motivodevolucion']."</td>
            <td align='left'>".$row['cdescripcionmotivo']."</td>
            <td align='left'>".$row['nid_motivodevolucion_padre']."</td>
            <td align='left'>".$row['grupo']."</td></tr>"; 
    } 
    //Incluimos la barra de navegación 
    ?>
  </table>
  <script type="text/javascript">
  function enviarFormM(value){
    document.getElementById('cdescripcionmotivo_oculto').value=value;
    document.getElementById('form2').submit();
  }
  </script>
  <form id="form2" method="POST" action="../controladores/control_motivodevolucion.php">
    <input type="hidden" name="cdescripcionmotivo" id="cdescripcionmotivo_oculto" value="" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <div class="pagination">
    <ul>
      <?php echo"<li>".$_pagi_navegacion."</li>";?>
    </ul>
  </div>
  <?php }?>
</div>