<div class="form_externo" >
  <?php
  //Comprobamos si la variable de busqueda esta construida, si es asi deshabilitamos los botones registrar,consultar 
  //y habilitamos los botones modificar,desactivar.
  if(isset($_SESSION['datos']['crif_personaproveedor'])){ 
    $disabledRCproveedor='disabled';
    $disabledMDproveedor='';
    $estatusproveedor=null;
  }else {
    $disabledRCproveedor='';
    $disabledMDproveedor='disabled';
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
  $servicios='proveedor';
  if(isset($_SESSION['datos'])){
    @$crif_personaproveedor=$_SESSION['datos']['crif_personaproveedor'];
    @$cnombreproveedor=$_SESSION['datos']['cnombreproveedor'];
    @$ctelefhabproveedor=$_SESSION['datos']['ctelefhabproveedor'];
    @$ctelefmovproveedor=$_SESSION['datos']['ctelefmovproveedor'];
    @$cemailproveedor=$_SESSION['datos']['cemailproveedor'];
    @$nid_condicionpago=$_SESSION['datos']['nid_condicionpago'];
    @$nid_localidadproveedor=$_SESSION['datos']['nid_localidadproveedor'];
    @$cdireccionproveedor=$_SESSION['datos']['cdireccionproveedor'];
    @$estatusproveedor=$_SESSION['datos']['estatusproveedor'];
  }
  else{
    @$crif_personaproveedor=$_GET['crif_personaproveedor'];
    @$cnombreproveedor=$_GET['cnombreproveedor'];
    @$ctelefhabproveedor=$_GET['ctelefhabproveedor'];
    @$ctelefmovproveedor=$_GET['ctelefmovproveedor'];
    @$cemailproveedor=$_GET['cemailproveedor'];
    @$nid_condicionpago=$_GET['nid_condicionpago'];
    @$nid_localidadproveedor=$_GET['nid_localidadproveedor'];
    @$cdireccionproveedor=$_GET['cdireccionproveedor'];
    @$estatusproveedor=$_GET['estatusproveedor'];
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
  if(!isset($_GET['l'])){ ?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_proveedor.php" method="post" id="form">
      <table border="0" style="width: 100%"> 
      <tr>
        <td><span class="texto_form">RIF</span></td>
        <td><input onKeyPress="return isRif(event,this.value)" onKeyUp="this.value=this.value.toUpperCase()" title="Ingrese el RIF del proveedor" name="crif_personaproveedor" id="crif_personaproveedor" type="text" maxlength="10" value="<?= $crif_personaproveedor;?>" required /></td>
      </tr>
      <tr>
        <td><span class="texto_form">Razón Social</span></td>
        <td><input title="Ingrese el nombre del proveedor" onKeyUp="this.value=this.value.toUpperCase()" name="cnombreproveedor" id="cnombreproveedor" type="text" size="50" value="<?= $cnombreproveedor;?>" required /></td>
      </tr>
      <tr>
        <td><span class="texto_form">Teléfono de Habitaci&oacute;n</span></td>
        <td><input maxlength=11 title="Ingrese el n&uacute;mero de habitaci&oacute;n" onKeyPress="return isNumberKey(event)" name="ctelefhabproveedor" id="ctelefhabproveedor" type="text" size="50" value="<?= $ctelefhabproveedor;?>" required /></td>
      </tr>
      <tr>
        <td><span class="texto_form">Teléfono M&oacute;vil</span></td>
        <td><input maxlength=11 title="Ingrese el n&uacute;mero de celular" onKeyPress="return isNumberKey(event)" name="ctelefmovproveedor" id="ctelefmovproveedor" type="text" size="50" value="<?= $ctelefmovproveedor;?>" /></td>
      </tr>
      <tr>
        <td><span class="texto_form">Correo Electr&oacute;nico</span></td>
        <td><input title="Ingrese el correo electr&oacute;nico del proveedor" onKeyUp="this.value=this.value.toUpperCase()" name="cemailproveedor" id="cemailproveedor" type="text" size="50" value="<?= $cemailproveedor;?>" /></td>
      </tr>
      <tr>
        <td><span class="texto_form">Condición de Pago</span></td>
        <td>
          <select name="nid_condicionpago" id="nid_condicionpago" title="Seleccione una condición de pago" required />
            <option value='0'>Seleccione una condición de pago</option>
            <?php
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            $sql = "SELECT nid_condicionpago,cdescripcion FROM facturacion.tcondicion_pago WHERE dfecha_desactivacion IS NULL ORDER BY nid_condicionpago ASC";
            $query = $pgsql->Ejecutar($sql);
            while ($row = $pgsql->Respuesta($query)){
              if($row['nid_condicionpago']==$nid_condicionpago){
                echo "<option value='".$row['nid_condicionpago']."' selected>".$row['cdescripcion']."</option>";
              }else{
                echo "<option value='".$row['nid_condicionpago']."'>".$row['cdescripcion']."</option>";
              }
            }
            ?>
          </select>
        </td>
      </tr>
      <tr>
        <td><span class="texto_form">Parroquia</span></td>
        <td>
          <select name="nid_localidadproveedor" id="nid_localidadproveedor" title="Seleccione una parroquia" required />
            <option value='0'>Seleccione una parroquia</option>
            <?php
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            $sql = "SELECT nid_localidad,cdescripcion FROM general.tlocalidad WHERE ctabla='tparroquia' AND dfecha_desactivacion IS NULL ORDER BY nid_localidad ASC";
            $query = $pgsql->Ejecutar($sql);
            while ($row = $pgsql->Respuesta($query)){
              if($row['nid_localidad']==$nid_localidadproveedor){
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
        <td><textarea onKeyUp="this.value=this.value.toUpperCase()" title="Ingrese la direcci&oacute;n del persona" name="cdireccionproveedor" id="cdireccionproveedor" required /><?= $cdireccionproveedor?></textarea></td>
      </tr>
      <tr>
        <td>
          <span class="texto_form">Agregar Direcciones de Sucursal</span>
        </td>
        <td>
          <input type="button" onclick="agrega_campos()" value="+" class="btn btn-default" />
        </td>
      </tr>
      </table>
      <br/>
      <div id="TablaDirecciones">
        <?php
        $pgsql=new Conexion();
        $sql = "SELECT * FROM general.tdireccion_despacho  
        WHERE crif_persona = '$crif_personaproveedor' 
        ORDER BY nid_direcciondespacho ASC";
        $query = $pgsql->Ejecutar($sql);
        $con=0;
        while ($row = $pgsql->Respuesta($query)){
        echo '<table id="'.$con.'" border="0" style="width: 100%">
          <tr>
            <td><span class="texto_form">C&oacute;digo</span></td>
            <td><input title="El c&oacute;digo es generado por el sistema" name="nid_direcciondespacho[]" id="nid_direcciondespacho_'.$con.'" type="text" size="10" readonly value="'.$row['nid_direcciondespacho'].'" /></td>
          </tr>
          <tr>
            <td><span class="texto_form">Tel&eacute;fono</span></td>
            <td><input maxlength=11 title="Ingrese el n&uacute;mero de tel&eacute;fono" onKeyPress="return isNumberKey(event)" name="ctelefonodireccion[]" id="ctelefonodireccion_'.$con.'" type="text" size="50" value="'.$row['ctelefono'].'" /></td>
          </tr>
          <tr>
            <td><span class="texto_form">Sede Principal</span></td>
            <td>
              <select name="csede_principaldireccion[]" id="csede_principaldireccion_'.$con.'" title="Seleccione una opción">
                <option value="0">Seleccione una opción</option>';
                echo '<option value="Y"'; if($row['csede_principal']=="Y"){ echo "selected";} echo '>SI</option>';
                echo '<option value="N"'; if($row['csede_principal']=="N"){ echo "selected";} echo '>NO</option>';
              echo '</select>
            </td>
          </tr>
          <tr>
            <td><span class="texto_form">Parroquia</span></td>
            <td>
              <select name="nid_localidaddireccion[]" id="nid_localidaddireccion_'.$con.'" title="Seleccione una parroquia" >
              <option value="0">Seleccione una parroquia</option>';
              $sqlx = "SELECT nid_localidad,cdescripcion FROM general.tlocalidad WHERE ctabla='tparroquia' AND dfecha_desactivacion IS NULL ORDER BY nid_localidad ASC";
              $querys = $pgsql->Ejecutar($sqlx);
              while ($rows = $pgsql->Respuesta($querys)){
                if($rows['nid_localidad']==$row['nid_localidad']){
                  echo "<option value='".$rows['nid_localidad']."' selected>".$rows['cdescripcion']."</option>";
                }else{
                  echo "<option value='".$rows['nid_localidad']."'>".$rows['cdescripcion']."</option>";
                }
              }
              echo '</select>
            </td>
          </tr>
          <tr>
            <td><span class="texto_form">Direcci&oacute;n</span></td>
            <td><textarea onKeyUp="this.value=this.value.toUpperCase()" title="Ingrese la direcci&oacute;n del proveedor" name="cdirecciondespaho[]" id="cdirecciondespacho_'.$con.'" required />'.$row['cdireccion'].'</textarea></td>
          </tr>
          <tr>
            <td><span class="texto_form">Remover Dirección de Sucursal</span></td>
            <td>
              <input type="button" class="btn btn-default" onclick="elimina_me('.$con.')" value="-">
            </td>
          </tr>
        </table>
        <br />';
        $con++;
      } 
      ?>
      </div>
      <table>
        <?php echo '<tr><td colspan="2" class="'.$estatusproveedor.'" id="estatus_registro">'.$estatusproveedor.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
            <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
            <?php
              imprimir_boton($disabledRCproveedor,$disabledMDproveedor,$estatusproveedor,$servicios,"proveedor");
            ?>       
          </td>
        </tr>
      </table>
    </form>
  <script type="text/javascript">
    var nid_direcciondespacho = document.getElementsByName('nid_direcciondespacho[]');
    var ctelefonodireccion = document.getElementsByName('ctelefonodireccion[]');
    var csede_principaldireccion = document.getElementsByName('csede_principaldireccion[]');
    var nid_localidaddireccion = document.getElementsByName('nid_localidaddireccion[]');
    var cdirecciondespacho = document.getElementsByName('cdirecciondespacho[]');
    var contador=nid_direcciondespacho.length;
      function agrega_campos(){
          $("#TablaDirecciones").append("<table id='"+contador+"' border='0' style='width: 100%'>"+
            "<tr>"+
            "<td><span class='texto_form'>C&oacute;digo</span></td>"+
            "<td><input title='El c&oacute;digo es generado por el sistema' name='nid_direcciondespacho[]' id='nid_direcciondespacho_"+contador+"' type='text' size='10' readonly /></td>"+
            "</tr>"+
            "<tr>"+
            "<td><span class='texto_form'>Tel&eacute;fono</span></td>"+
            "<td><input maxlength=11 title='Ingrese el n&uacute;mero de tel&eacute;fono' onKeyPress='return isNumberKey(event)' name='ctelefonodireccion[]' id='ctelefonodireccion_"+contador+"' type='text' size='50' /></td>"+
            "</tr>"+
            "<tr>"+
            "<td><span class='texto_form'>Sede Principal</span></td>"+
            "<td>"+
              "<select name='csede_principaldireccion[]' id='csede_principaldireccion_"+contador+"' title='Seleccione una opción' >"+
                "<option value='0'>Seleccione una opción</option>"+
                "<option value='Y'>SI</option>"+
                "<option value='N'>NO</option>"+
              "</select>"+
            "</td>"+
            "</tr>"+
            "<tr>"+
            "<td><span class='texto_form'>Parroquia</span></td>"+
            "<td>"+
              "<select name='nid_localidaddireccion[]' id='nid_localidaddireccion_"+contador+"' title='Seleccione una parroquia'>"+
              "<option value='0'>Seleccione una parroquia</option>"+
              <?php
              require_once("../clases/class_bd.php");
              $pgsql=new Conexion();
              $sql = "SELECT nid_localidad,cdescripcion FROM general.tlocalidad WHERE ctabla='tparroquia' AND dfecha_desactivacion IS NULL ORDER BY nid_localidad ASC";
              $query = $pgsql->Ejecutar($sql);
              $comillasimple=chr(34);
              while ($rows = $pgsql->Respuesta($query)){
                if($rows['nid_localidad']==$row['nid_localidad']){
                  echo $comillasimple."<option value='".$rows['nid_localidad']."' selected>".$rows['cdescripcion']."</option>".$comillasimple."+";
                }else{
                  echo $comillasimple."<option value='".$rows['nid_localidad']."'>".$rows['cdescripcion']."</option>".$comillasimple."+";
                }
              }
              ?>
              "</select>"+
            "</td>"+
            "</tr>"+
            "<tr>"+
            "<td><span class='texto_form'>Direcci&oacute;n</span></td>"+
            "<td><textarea onKeyUp='this.value=this.value.toUpperCase()' title='Ingrese la direcci&oacute;n del proveedor' name='cdirecciondespaho[]' id='cdirecciondespacho_"+contador+"' /></textarea>"+
            "</td>"+
            "</tr>"+
            "<tr>"+
            "<td><span class='texto_form'>Remover Dirección de Sucursal</span></td>"+
            "<td>"+
            "<input type='button'  class='btn btn-default' onclick='elimina_me("+contador+")' value='-'>"+
            "</td>"+
            "</tr>"+
        "</table><br />");
          contador++;
      }
  
      function elimina_me(elemento){
        $("#"+elemento).remove();
        for(var i=0;i<nid_direcciondespacho.length;i++){
          nid_direcciondespacho[i].removeAttribute('id');
          ctelefonodireccion[i].removeAttribute('id');
          csede_principaldireccion[i].removeAttribute('id');
          nid_localidaddireccion[i].removeAttribute('id');
          cdirecciondespacho[i].removeAttribute('id');
        }
        for(var i=0;i<nid_direcciondespacho.length;i++){
          nid_direcciondespacho[i].setAttribute('id','nid_direcciondespacho_'+i);
          ctelefonodireccion[i].setAttribute('id','ctelefonodireccion_'+i);
          csede_principaldireccion[i].setAttribute('id','csede_principaldireccion_'+i);
          nid_localidaddireccion[i].setAttribute('id','nid_localidaddireccion_'+i);
          cdirecciondespacho[i].setAttribute('id','cdirecciondespacho_'+i);
        }
      }
  </script>
  </fieldset>
  <br>
  <?php } else{ 
  $crif_personaproveedor = $_GET['crif_personaproveedor'];
  $cnombreproveedor = $_GET['cnombreproveedor'];
  ?>
  <script type="text/javascript">
    function reload_tabproveedor(tab){
      //en esta sección mostramos el listar.
      //recibimos los valores de filtro para mostrar los registros paginados. = document.getElementById('crif_persona').value;
      crif_personaproveedor = document.getElementById('crif_personaproveedor').value;
      cnombreproveedor = document.getElementById('cnombreproveedor').value;
      location.href="menu_principal.php?proveedor&l&crif_personaproveedor="+crif_personaproveedor+"&cnombreproveedor="+cnombreproveedor+tab;
    }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td><span class="texto_form">RIF o C&eacute;dula</span></td>
      <td>
        <input onKeyPress="return isRif(event)" onKeyUp="this.value=this.value.toUpperCase()" title="Ingrese la c&eacute;dula del proveedor" name="crif_personaproveedor" id="crif_personaproveedor" type="text" size="10" value="<?= $crif_personaproveedor;?>" />
      </td>
      <td><span class="texto_form">Nombre</span></td>
      <td>
        <input title="Ingrese el nombre del proveedor" onKeyUp="this.value=this.value.toUpperCase()" name="cnombreproveedor" id="cnombreproveedor" type="text" size="50" value="<?= $cnombreproveedor;?>" />
      </td>
    </tr>
  </table>
  <table align="center">  
    <tr>
    <td>
      <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabproveedor('#proveedor')">
      <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
    </td>
    </tr>
  </table> 
  <a href="?proveedor#proveedor" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_proveedor.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=proveedor';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:20%;"> RIF o C&eacute;dula del Proveedor </td>
      <td align='left'>Nombre del proveedor</td>
      <td align='left'>Tlf. Habitaci&oacute;n del Proveedor</td>
      <td align='left'>Email del Proveedor</td>
      <td align='left'>Dirección</td>
    </tr>
    <?php
    //Conexión a la base de datos 
    require_once("../clases/class_bd.php");
    $pgsql=new Conexion();
    $clausuleWhere = "WHERE LOWER(v.cdescripcion) LIKE '%proveedor%'";
    if($crif_personaproveedor!="" && $cnombreproveedor!=""){
      $clausuleWhere.="AND p.crif_persona LIKE '%$crif_personaproveedor%' AND p.cnombre LIKE '%$cnombreproveedor%'";
    }
    else if($crif_personaproveedor!=""){
        $clausuleWhere.="AND p.crif_persona LIKE '%$crif_personaproveedor%'";
    }
    else if($cnombreproveedor!=""){
        $clausuleWhere.="AND p.cnombre LIKE '%$cnombreproveedor%'";
    }
    //Sentencia sql (sin limit) 
    $_pagi_sql = "SELECT p.crif_persona,p.cnombre,p.ctelefhab,p.cemail,p.cdireccion,v.cdescripcion 
    FROM general.tpersona p
    INNER JOIN general.tcombo_valor v on p.ntipo_persona=v.nid_combovalor AND v.ctabla='tpersona' 
    $clausuleWhere
    ORDER BY crif_persona DESC";
    //Booleano. Define si se utiliza pg_num_rows() (true) o COUNT(*) (false).
    $_pagi_conteo_alternativo = true; 
    //cantidad de resultados por página (opcional, por defecto 20) 
    $_pagi_cuantos = 15; 
    //Cadena que separa los enlaces numéricos en la barra de navegación entre páginas.
    $_pagi_separador = " ";
    //Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
    $_pagi_nav_num_enlaces=5;
    //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente 
    @include("../librerias/paginador/paginator.inc.php"); 
    //Leemos y escribimos los registros de la página actual 
    while($row = pg_fetch_array($_pagi_result)){
      echo "<tr  style='cursor: pointer;' id='".$row['crif_persona']."' onclick='enviarForm(this.id)'>
			  <td style='width:20%;'>".$row['crif_persona']."</td>
			  <td align='left'>".$row['cnombre']."</td>
			  <td align='left'>".$row['ctelefhab']."</td>
			  <td align='left'>".$row['cemail']."</td>
			  <td align='left'>".$row['cdireccion']."</td>
			</tr>"; 
    } 
    //Incluimos la barra de navegación 
    ?>
  </table>
  <script type="text/javascript">
  function enviarForm(value){
    document.getElementById('crif_persona_oculto').value=value;
    document.getElementById('form1').submit();
  }
  </script>
  <form id="form1" method="POST" action="../controladores/control_proveedor.php">
    <input type="hidden" name="crif_personaproveedor" id="crif_persona_oculto" value="" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <div class="pagination">
    <ul>
      <?php echo"<li>".$_pagi_navegacion."</li>";?>
    </ul>
  </div>
  <?php } ?>
</div>
