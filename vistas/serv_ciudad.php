<div class="form_externo" >
  <?php
  if(!empty($nid_estado) && !empty($cnombreestado)){
    $_SESSION['cnombreestado']= $cnombreestado;
    $_SESSION['nid_estado']=$nid_estado;
  }
  if(isset($_SESSION['datos']['cnombreciudad'])){ 
    $disabledRCCiudad='disabled';
    $disabledMDCiudad='';
    $estatus_ciudad=null;
  }else {
    $disabledRCCiudad='';
    $disabledMDCiudad='disabled';
  }
  $servicios='localidad';
  if(isset($_SESSION['datos'])){
    @$cnombreciudad=$_SESSION['datos']['cnombreciudad'];
    @$cnombreestado=$_SESSION['datos']['cnombreestado'];
    @$nid_ciudad=$_SESSION['datos']['nid_ciudad'];
    @$nid_estado=$_SESSION['datos']['nid_estado'];
    @$estatus_ciudad=$_SESSION['datos']['estatus_ciudad'];
  }
  else{
    @$cnombreciudad=null;
    @$cnombreestado=null;
    @$nid_ciudad=null;
    @$nid_estado=null;
    @$estatus_ciudad=null;
  }
  if(!isset($_GET['l'])){
  ?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_ciudad.php" method="post" id="form3">
      <table border="0" style="width: 100%"> 
      <input type="hidden" name="ctabla_ciudad" value="tciudad" />
      <tr>
        <td><span class="texto_form">Estado</span></td>
        <td>
        <?php if(!empty($nid_estado)){?>
          <input type="hidden" id="nid_estado" name="nid_estado" value="<?= $nid_estado; ?>">
          <input title="El código del país proviene de la pestaña anterior" name="nid_estado" id="nid_estado" type="text" readonly value="<?= $nid_estado."_".$cnombreestado;?>" /> 
        <?php }else{?>
          <input type="hidden" id="nid_estado" name="nid_estado" value="<?= $_SESSION['nid_estado']; ?>">
          <input title="El código del formulario proviene de la pestaña anterior" name="name_estado" id="name_estado" type="text" readonly value="<?= $_SESSION['nid_estado']."_".$_SESSION['cnombreestado'];?>" /> 
        <?php } ?>
        </td>
      </tr>
      <tr>
        <td><span class="texto_form">C&oacute;digo</span></td>
        <td><input title="El c&oacute;digo de la ciudad es generado por el sistema" name="nid_ciudad" id="nid_ciudad" type="text" size="10" readonly value="<?= $nid_ciudad;?>" /> </td>
      </tr>
      <tr>
        <td><span class="texto_form">Ciudad</span></td>
        <td><input title="Ingrese el nombre de la ciudad" onKeyUp="this.value=this.value.toUpperCase()" name="cnombreciudad" id="cnombreciudad" type="text" size="50" value="<?= $cnombreciudad;?>" required /></td>
      </tr>
      <?php echo '<tr><td colspan="2" class="'.$estatus_ciudad.'" id="estatus_registro">'.$estatus_ciudad.'</td></tr>'; ?>
      <tr>
        <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
          <?php
            imprimir_boton($disabledRCCiudad,$disabledMDCiudad,$estatus_ciudad,$servicios,"ciudad");
          ?>         
        </td>
      </tr>
      </table>    
    </form>
  </fieldset>
  <br>
  <?php }else{
  $cnombreciudad = $_GET['cnombreciudad'];
  ?>
  <script type="text/javascript">
  function reload_tabciudad(tab){
    cnombreciudad = document.getElementById('cnombreciudad').value;
    location.href="menu_principal.php?localidad&l&cnombreciudad="+cnombreciudad+tab;
  }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td><span class="texto_form">Ciudad</span></td>
    </tr>
    <tr>
      <td><input title="Ingrese el nombre de la ciudad" onKeyUp="this.value=this.value.toUpperCase()" name="cnombreciudad" id="cnombreciudad" type="text" size="50" value="<?= $cnombreciudad;?>" /></td>
    </tr>
  </table>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabciudad('#ciudad')">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?localidad#ciudad" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_ciudad.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=ciudad';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:25%;"> Código </td>
      <td align='left'>Ciudad</td>
      <td align='left'>Código Estado</td>
      <td align='left'>Estado</td>
    </tr>
    <?php
    //Conexión a la base de datos 
    require_once("../clases/class_bd.php");
    $pgsql=new Conexion();
    $clausuleWhere = "WHERE c.ctabla='tciudad'  AND c.nid_localidad_padre = '".$_SESSION['nid_estado']."' AND c.dfecha_desactivacion IS NULL ";
    if($cnombreciudad!=""){
      $clausuleWhere.="AND c.cdescripcion LIKE '%$cnombreciudad%' ";
    }
    //Sentencia sql (sin limit) 
    $_pagi_sql = "SELECT c.nid_localidad_padre,e.cdescripcion estado,c.nid_localidad,c.cdescripcion ciudad 
    FROM general.tlocalidad c INNER JOIN general.tlocalidad e ON e.nid_localidad = c.nid_localidad_padre 
    $clausuleWhere 
    ORDER BY c.nid_localidad DESC"; 
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
    echo "<tr><td style='width:20%;'>".$row['nid_localidad']."</td>
      <td align='left'>".$row['ciudad']."</td>
      <td align='left'>".$row['nid_localidad_padre']."</td>
      <td align='left'>".$row['estado']."</td></tr>"; 
    } 
    //Incluimos la barra de navegación 
    ?>
  </table>
  <div class="pagination">
    <ul>
      <?php echo"<li>".$_pagi_navegacion."</li>";?>
    </ul>
  </div>
  <?php }?>
</div>