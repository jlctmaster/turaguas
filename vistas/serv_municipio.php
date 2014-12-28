<div class="form_externo" >
  <?php
  if(!empty($nid_estado) && !empty($cnombreestado)){
    $_SESSION['cnombreestado']= $cnombreestado;
    $_SESSION['nid_estado']=$nid_estado;
  }
  if(isset($_SESSION['datos']['cnombremunicipio'])){ 
    $disabledRCMun='disabled';
    $disabledMDMun='';
    $estatus_municipio=null;
  }else {
    $disabledRCMun='';
    $disabledMDMun='disabled';
  }
  $servicios='localidad';
  if(isset($_SESSION['datos'])){
    @$cnombremunicipio=$_SESSION['datos']['cnombremunicipio'];
    @$cnombreestado=$_SESSION['datos']['cnombreestado'];
    @$nid_municipio=$_SESSION['datos']['nid_municipio'];
    @$nid_estado=$_SESSION['datos']['nid_estado'];
    @$estatus_municipio=$_SESSION['datos']['estatus_municipio'];             
  }
  else{
    @$cnombremunicipio=null;
    @$cnombreestado=null;
    @$nid_municipio=null;
    @$nid_estado=null;
    @$estatus_municipio=null;
  }
  if(!isset($_GET['l'])){?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_municipio.php" method="post" id="form4">
      <table border="0" style="width: 100%"> 
        <input type="hidden" name="ctabla_municipio" value="tmunicipio" />
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
          <td><input title="El c&oacute;digo del municipio es generado por el sistema" name="nid_municipio" id="nid_municipio" type="text" size="10" readonly value="<?= $nid_municipio;?>" /></td>
        </tr>
        <tr>
          <td><span class="texto_form">Municipio</span></td>
          <td><input title="Ingrese el nombre del municipio" onKeyUp="this.value=this.value.toUpperCase()" name="cnombremunicipio" id="cnombremunicipio" type="text" size="50" value="<?= $cnombremunicipio;?>" required /></td>
        </tr>
        <?php echo '<tr><td colspan="2" class="'.$estatus_municipio.'" id="estatus_registro">'.$estatus_municipio.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
            <?php
              imprimir_boton($disabledRCMun,$disabledMDMun,$estatus_municipio,$servicios,"municipio");
            ?>         
          </td>
        </tr>
      </table>
    </form>
  </fieldset>
  <br>
  <?php }else{
  $cnombremunicipio = $_GET['cnombremunicipio'];
  ?>
  <script type="text/javascript">
  function reload_tabmunicipio(tab){
  cnombremunicipio = document.getElementById('cnombremunicipio').value;
  location.href="menu_principal.php?localidad&l&cnombremunicipio="+cnombremunicipio+tab;
  }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td><span class="texto_form">Municipio</span></td>
    </tr>
    <tr>
      <td><input title="Ingrese el nombre del municipio" onKeyUp="this.value=this.value.toUpperCase()" name="cnombremunicipio" id="cnombremunicipio" type="text" size="50" value="<?= $cnombremunicipio;?>" /></td>
    </tr>
  </table>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabmunicipio('#municipio')">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?localidad#municipio" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_municipio.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=municipio';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:10%;">C&oacute;digo</td>
      <td align='left'>País</td>
      <td align='left'>C&oacute;digo Estado</td>
      <td align='left'>Estado</td>
      <td align='left'>C&oacute;digo Municipio</td>
      <td align='left'>Municipio</td>
      <td align='left'>C&oacute;digo Parroquia</td>
      <td align='left'>Parroquia</td>
    </tr>
    <?php
    //Conexión a la base de datos 
    require_once("../clases/class_bd.php");
    $pgsql=new Conexion();
    $clausuleWhere = "WHERE p.ctabla = 'tpais' AND (p.dfecha_desactivacion IS NULL OR e.dfecha_desactivacion IS NULL OR 
      m.dfecha_desactivacion IS NULL OR pa.dfecha_desactivacion IS NULL) AND m.nid_localidad_padre = '".$_SESSION['nid_estado']."'";
    if($cnombremunicipio!=""){
      $clausuleWhere.="AND m.cdescripcion LIKE '%$cnombremunicipio%' ";
    }
    //Sentencia sql (sin limit) 
    $_pagi_sql = "SELECT p.nid_localidad codpais,p.cdescripcion pais, e.nid_localidad codestado,e.cdescripcion estado, 
      m.nid_localidad codmunicipio,m.cdescripcion municipio, pa.nid_localidad codparroquia,pa.cdescripcion parroquia 
      FROM general.tlocalidad p 
      LEFT JOIN general.tlocalidad e ON p.nid_localidad = e.nid_localidad_padre AND e.ctabla = 'testado'
      LEFT JOIN general.tlocalidad m ON e.nid_localidad = m.nid_localidad_padre AND m.ctabla = 'tmunicipio'
      LEFT JOIN general.tlocalidad pa ON m.nid_localidad = pa.nid_localidad_padre AND pa.ctabla = 'tparroquia' 
      $clausuleWhere
      ORDER BY p.nid_localidad,e.nid_localidad,m.nid_localidad,pa.nid_localidad ASC";
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
      echo "<tr>
        <td style='width:10%; cursor: pointer;' id='tpais|".$row['pais']."' onclick='enviarFormMunicipio(this.id)'>".$row['codpais']."</td>
        <td align='left' style='cursor: pointer;' id='tpais|".$row['pais']."' onclick='enviarFormMunicipio(this.id)'>".$row['pais']."</td>
        <td align='left' style='cursor: pointer;' id='testado|".$row['estado']."' onclick='enviarFormMunicipio(this.id)'>".$row['codestado']."</td>
        <td align='left' style='cursor: pointer;' id='testado|".$row['estado']."' onclick='enviarFormMunicipio(this.id)'>".$row['estado']."</td>
        <td align='left' style='cursor: pointer;' id='tmunicipio|".$row['municipio']."' onclick='enviarFormMunicipio(this.id)'>".$row['codmunicipio']."</td>
        <td align='left' style='cursor: pointer;' id='tmunicipio|".$row['municipio']."' onclick='enviarFormMunicipio(this.id)'>".$row['municipio']."</td>
        <td align='left' style='cursor: pointer;' id='tparroquia|".$row['parroquia']."' onclick='enviarFormMunicipio(this.id)'>".$row['codparroquia']."</td>
        <td align='left' style='cursor: pointer;' id='tparroquia|".$row['parroquia']."' onclick='enviarFormMunicipio(this.id)'>".$row['parroquia']."</td>
      </tr>";
      } 
      //Incluimos la barra de navegación 
    ?>
  </table>
  <script type="text/javascript">
  function enviarFormMunicipio(value){
    var valor=value.split('|');
    if(valor[0]=="tpais"){
      console.log("1")
      document.getElementById('cdescripcion1').value=valor[1];
      document.getElementById('form1').submit();
    }else if(valor[0]=="testado"){
      console.log("2")
      document.getElementById('cdescripcion2').value=valor[1];
      document.getElementById('form2').submit();
    }else if(valor[0]=="tmunicipio"){
      console.log("3")
      document.getElementById('cdescripcion3').value=valor[1];
      document.getElementById('form4').submit();
    }else if(valor[0]=="tparroquia"){
      console.log("4")
      document.getElementById('cdescripcion4').value=valor[1];
      document.getElementById('form5').submit();
    }
  }
  </script>
  <form id="form1" method="POST" action="../controladores/control_pais.php">
    <input type="hidden" name="cnombrepais" id="cdescripcion1" value="" />
    <input type="hidden" name="ctabla_pais" id="ctabla" value="tpais" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <form id="form2" method="POST" action="../controladores/control_estado.php">
    <input type="hidden" name="cnombreestado" id="cdescripcion2" value="" />
    <input type="hidden" name="ctabla_estado" id="ctabla" value="testado" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <form id="form4" method="POST" action="../controladores/control_municipio.php">
    <input type="hidden" name="cnombremunicipio" id="cdescripcion3" value="" />
    <input type="hidden" name="ctabla_municipio" id="ctabla" value="tmunicipio" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <form id="form5" method="POST" action="../controladores/control_parroquia.php">
    <input type="hidden" name="cnombreparroquia" id="cdescripcion4" value="" />
    <input type="hidden" name="ctabla_parroquia" id="ctabla" value="tparroquia" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <div class="pagination">
    <ul>
      <?php echo"<li>".$_pagi_navegacion."</li>";?>
    </ul>
  </div>
  <?php }?>
</div>