<div class="form_externo" >
  <?php
  if(!empty($crif_personacliente) && !empty($cnombrecliente)){
    $_SESSION['cnombrecliente']= $cnombrecliente;
    $_SESSION['crif_personacliente']=$crif_personacliente;
  }
  if(isset($_SESSION['datos']['cdireccion'])){ 
    $disabledRCdireccion='disabled';
    $disabledMDdireccion='';
    $estatusdireccion=null;
  }else {
    $disabledRCdireccion='';
    $disabledMDdireccion='disabled';
  }
  $servicios='cliente';
  if(isset($_SESSION['datos'])){
    @$nid_direcciondespacho=$_SESSION['datos']['nid_direcciondespacho'];
    @$crif_personacliente=$_SESSION['datos']['crif_personacliente'];
    @$cnombrecliente=$_SESSION['datos']['cnombrecliente'];
    @$ctelefonodireccion=$_SESSION['datos']['ctelefonodireccion'];
    @$csede_principaldireccion=$_SESSION['datos']['csede_principaldireccion'];
    @$nid_localidaddireccion=$_SESSION['datos']['nid_localidaddireccion'];
    @$cdireccion=$_SESSION['datos']['cdireccion'];
    @$estatusdireccion=$_SESSION['datos']['estatusdireccion'];
  }
  else{
    @$nid_direcciondespacho=null;
    @$crif_personacliente=null;
    @$cnombrecliente=null;
    @$ctelefonodireccion=null;
    @$csede_principaldireccion=null;
    @$nid_localidaddireccion=null;
    @$cdireccion=null;
    @$estatusdireccion=null;
  }
  if(!isset($_GET['l'])) { ?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_direccioncliente.php" method="post" id="form2">
      <table border="0" style="width: 100%">
        <input type="hidden" name="cdireccion" value="cdireccion" />
        <tr>
          <td><span class="texto_form">Cliente</span></td>
          <td>
          <?php if(!empty($crif_personacliente)){?>
            <input type="hidden" id="crif_personacliente" name="crif_personacliente" value="<?= $crif_personacliente; ?>">
            <input title="El RIF del Cliente proviene de la pestaña anterior" name="cnombrecliente" id="cnombrecliente" type="text" readonly value="<?= $crif_personacliente."_".$cnombrecliente;?>" /> 
          <?php }else{?>
            <input type="hidden" id="crif_personacliente" name="crif_personacliente" value="<?= $_SESSION['crif_personacliente']; ?>">
            <input title="El código del formulario proviene de la pestaña anterior" name="cnombrecliente" id="cnombrecliente" type="text" readonly value="<?= $_SESSION['crif_personacliente']."_".$_SESSION['cnombrecliente'];?>" /> 
          <?php } ?>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">C&oacute;digo</span></td>
          <td><input title="El c&oacute;digo es generado por el sistema" name="nid_direcciondespacho" id="nid_direcciondespacho" type="text" size="10" readonly value="<?= $nid_direcciondespacho;?>" /></td>
        </tr>
        <tr>
          <td><span class="texto_form">Tel&eacute;fono</span></td>
          <td><input maxlength=11 title="Ingrese el n&uacute;mero de tel&eacute;fono" onKeyPress="return isNumberKey(event)" name="ctelefonodireccion" id="ctelefonodireccion" type="text" size="50" value="<?= $ctelefonodireccion;?>" required /></td>
        </tr>
        <tr>
          <td><span class="texto_form">Sede Principal</span></td>
          <td>
            <input title="Seleccione si la dirección es la sede principal" name="csede_principaldireccion" id="csede_principaldireccion" type="radio" value="Y" <? if($csede_principaldireccion=="Y"){echo "checked='checked'";}?> required /> SI 
            <input title="Seleccione si la dirección es la sede principal" name="csede_principaldireccion" id="csede_principaldireccion" type="radio" value="N" <? if($csede_principaldireccion=="N"){echo "checked='checked'";}?> required /> NO 
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Parroquia</span></td>
          <td>
            <select name="nid_localidaddireccion" id="nid_localidaddireccion" title="Seleccione una parroquia" required>
            <?php
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            $sql = "SELECT nid_localidad,cdescripcion FROM general.tlocalidad WHERE ctabla='tparroquia' AND dfecha_desactivacion IS NULL ORDER BY nid_localidad ASC";
            $query = $pgsql->Ejecutar($sql);
            while ($row = $pgsql->Respuesta($query)){
              if($row['nid_localidad']==$nid_localidaddireccion){
                echo "<option value='".$row['nid_localidad']."' selected>".$row['cdescripcion']."</option>";
              }else{
                echo "<option value='".$row['nid_localidad']."'>".$row['cdescripcion']."</option>";
              }
            }
            ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Direcci&oacute;n</span></td>
          <td><textarea onKeyUp="this.value=this.value.toUpperCase()" title="Ingrese la direcci&oacute;n del cliente" name="cdireccion" id="cdireccion" required /><?= $cdireccion?></textarea></td>
        </tr>
        <?php echo '<tr><td colspan="2" class="'.$estatusdireccion.'" id="estatus_registro">'.$estatusdireccion.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
            <?php
              imprimir_boton($disabledRCdireccion,$disabledMDdireccion,$estatusdireccion,$servicios,"direccion");
            ?>        
          </td>
        </tr>
      </table>    
    </form>
  </fieldset>
  <br>
  <?php }else{ 
  $cdireccion = $_GET['cdireccion'];
  ?>
  <script type="text/javascript">
    function reload_tabdireccion(tab){
      cdireccion= document.getElementById('cdireccion').value;
      location.href="menu_principal.php?cliente&l&cdireccion="+cdireccion+tab;
    }
  </script>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabdireccion()">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?cliente#direccion" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_direccioncliente.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=direccioncliente';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;">
      <td align='left'> Cliente</td>
      <td align='left'>Tel&eacute;fono</td>
      <td align='left'>Sede Principal</td>
      <td align='left'>Parroquia</td>
      <td align='left'>Direcci&oacute;n</td>
    </tr>
    <?php
    //Conexión a la base de datos 
    require_once("../clases/class_bd.php");
    $pgsql=new Conexion();
    $clausuleWhere = "";
    if($cdireccion!=""){
      $clausuleWhere.="WHERE d.cdireccion = '$cdireccion'";
    }
    //Sentencia sql (sin limit) 
    $_pagi_sql = "SELECT d.crif_persona,d.cdireccion,d.ctelefono,d.csede_principal,l.cdescripcion 
    FROM general.tdireccion_despacho d 
    INNER JOIN general.tpersona p ON p.crif_persona = d.crif_persona 
    INNER JOIN general.tlocalidad l ON d.nid_localidad = l.nid_localidad AND l.ctabla = 'tparroquia' 
    $clausuleWhere 
    ORDER BY d.crif_persona DESC";
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
      echo "<tr><td style='width:20%;'>".$row['crif_persona']."</td>
        <td align='left'>".$row['ctelefono']."</td>
        <td align='left'>".$row['csede_principal']."</td>
        <td align='left'>".$row['cdescripcion']."</td>
        <td align='left'>".$row['cdireccion']."</td>"; 
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