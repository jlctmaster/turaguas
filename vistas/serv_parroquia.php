<div class="form_externo" >
  <?php
  if(!empty($nid_municipio) && !empty($cnombremunicipio)){
    $_SESSION['cnombremunicipio']= $cnombremunicipio;
    $_SESSION['nid_municipio']=$nid_municipio;
  }
  if(isset($_SESSION['datos']['cnombreparroquia'])){ 
    $disabledRCParroq='disabled';
    $disabledMDParroq='';
    $estatus_parroquia=null;
  }else {
    $disabledRCParroq='';
    $disabledMDParroq='disabled';
  }
  $servicios='localidad';
  if(isset($_SESSION['datos'])){
    @$cnombreparroquia=$_SESSION['datos']['cnombreparroquia'];
    @$cnombremunicipio=$_SESSION['datos']['cnombremunicipio'];
    @$nid_parroquia=$_SESSION['datos']['nid_parroquia'];
    @$nid_municipio=$_SESSION['datos']['nid_municipio'];
    @$estatus_parroquia=$_SESSION['datos']['estatus_parroquia'];
  }
  else{
    @$cnombreparroquia=null;
    @$nid_parroquia=null;
    @$nid_municipio=null;
    @$estatus_parroquia=null;
  }
  if(!isset($_GET['l'])){?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_parroquia.php" method="post" id="form5">
      <table border="0" style="width: 100%"> 
        <input type="hidden" name="ctabla_parroquia" value="tparroquia" />
        <tr>
          <td><span class="texto_form">Municipio</span></td>
          <td>
          <?php if(!empty($nid_municipio)){?>
            <input type="hidden" id="nid_municipio" name="nid_municipio" value="<?= $nid_municipio; ?>">
            <input title="El código del país proviene de la pestaña anterior" name="nid_municipio" id="nid_municipio" type="text" readonly value="<?= $nid_municipio."_".$cnombremunicipio;?>" /> 
          <?php }else{?>
            <input type="hidden" id="nid_municipio" name="nid_municipio" value="<?= $_SESSION['nid_municipio']; ?>">
            <input title="El código del formulario proviene de la pestaña anterior" name="name_municipio" id="name_municipio" type="text" readonly value="<?= $_SESSION['nid_municipio']."_".$_SESSION['cnombremunicipio'];?>" /> 
          <?php } ?>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">C&oacute;digo</span></td>
          <td><input title="El c&oacute;digo de la parroquia es generado por el sistema" name="nid_parroquia" id="nid_parroquia" type="text" size="10" readonly value="<?= $nid_parroquia;?>" /> </td>
        </tr>
        <tr>
          <td><span class="texto_form">Parroquia</span></td>
          <td><input title="Ingrese el nombre de la parroquia" onKeyUp="this.value=this.value.toUpperCase()" name="cnombreparroquia" id="cnombreparroquia" type="text" size="50" value="<?= $cnombreparroquia;?>" required /></td>
        </tr>
        <?php echo '<tr><td colspan="2" class="'.$estatus_parroquia.'" id="estatus_registro">'.$estatus_parroquia.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
            <?php
              imprimir_boton($disabledRCParroq,$disabledMDParroq,$estatus_parroquia,$servicios,"parroquia");
            ?>         
          </td>
        </tr>
      </table>
    </form>
  </fieldset>
  <br>
  <?php }else{
  $cnombreparroquia = $_GET['cnombreparroquia'];
  ?>
  <script type="text/javascript">
    function reload_tabparroquia(tab){
      cnombreparroquia = document.getElementById('cnombreparroquia').value;
      location.href="menu_principal.php?localidad&l&cnombreparroquia="+cnombreparroquia+tab;
    }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td><span class="texto_form">Parroquia</span></td>
    </tr>
    <tr>
      <td><input title="Ingrese el nombre del municipio" onKeyUp="this.value=this.value.toUpperCase()" name="cnombreparroquia" id="cnombreparroquia" type="text" size="50" value="<?= $cnombreparroquia;?>" /></td>
    </tr>
  </table>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabparroquia('#parroquia')">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?localidad#parroquia" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_parroquia.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=parroquia';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
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
      m.dfecha_desactivacion IS NULL OR pa.dfecha_desactivacion IS NULL) AND pa.nid_localidad_padre = '".$_SESSION['nid_municipio']."'";
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
        <td style='width:10%; cursor: pointer;' id='tpais|".$row['pais']."' onclick='enviarFormParroquia(this.id)'>".$row['codpais']."</td>
        <td align='left' style='cursor: pointer;' id='tpais|".$row['pais']."' onclick='enviarFormParroquia(this.id)'>".$row['pais']."</td>
        <td align='left' style='cursor: pointer;' id='testado|".$row['estado']."' onclick='enviarFormParroquia(this.id)'>".$row['codestado']."</td>
        <td align='left' style='cursor: pointer;' id='testado|".$row['estado']."' onclick='enviarFormParroquia(this.id)'>".$row['estado']."</td>
        <td align='left' style='cursor: pointer;' id='tmunicipio|".$row['municipio']."' onclick='enviarFormParroquia(this.id)'>".$row['codmunicipio']."</td>
        <td align='left' style='cursor: pointer;' id='tmunicipio|".$row['municipio']."' onclick='enviarFormParroquia(this.id)'>".$row['municipio']."</td>
        <td align='left' style='cursor: pointer;' id='tparroquia|".$row['parroquia']."' onclick='enviarFormParroquia(this.id)'>".$row['codparroquia']."</td>
        <td align='left' style='cursor: pointer;' id='tparroquia|".$row['parroquia']."' onclick='enviarFormParroquia(this.id)'>".$row['parroquia']."</td>
      </tr>";
      } 
      //Incluimos la barra de navegación 
    ?>
  </table>
  <script type="text/javascript">
  function enviarFormParroquia(value){
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