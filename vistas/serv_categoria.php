<div class="form_externo" >
  <?php 
    if(isset($_SESSION['datos']['cdescripcionc'])){ 
      $disabledRCcategoria='disabled';
      $disabledMDcategoria='';
      $estatus_categoria=null;
    }else {
         $disabledRCcategoria='';
         $disabledMDcategoria='disabled';
    }
    $servicios='categoria';
    if(isset($_SESSION['datos'])){
      @$cdescripcionc=$_SESSION['datos']['cdescripcionc'];
      @$nid_categoria=$_SESSION['datos']['nid_categoria'];
      @$estatus_categoria=$_SESSION['datos']['estatus_categoria'];
      }
    else{
      @$cdescripcionc=null;
      @$nid_categoria=null;
      @$estatus_categoria=null;
      }
    if(!isset($_GET['l'])){
  ?>
  <fieldset>
    <form action="../controladores/control_categoria.php" method="post" id="form1">
      <table border="0" style="width: 100%">
        <tr>
          <td><span class="texto_form">Código</span></td>
          <td><input title="El código de la categoría es generado por el sistema" name="nid_categoria" id="nid_categoria" type="text" size="10" readonly value="<?= $nid_categoria;?>" /></td>
        </tr>
        <tr>
          <td><span class="texto_form">Categoría</span></td>
          <td> <input title="Ingrese el nombre de la categoría" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcionc" id="cdescripcionc" type="text" size="50" value="<?= $cdescripcionc;?>" required>
          <?php echo '<tr><td colspan="2" class="'.$estatus_categoria.'" id="estatus_registro">'.$estatus_categoria.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
            <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
            <?php
              imprimir_boton($disabledRCcategoria,$disabledMDcategoria,$estatus_categoria,$servicios,"categoria");
            ?>         
          </td>
        </tr>
      </table>    
    </form>
  </fieldset>
  <br>
  <?php }else{ 
    $cdescripcionc = $_GET['cdescripcionc'];
  ?>
  <script type="text/javascript">
    function reload_page(){
    cdescripcionc = document.getElementById('cdescripcionc').value;
    location.href="menu_principal.php?categoria&l&cdescripcionc="+cdescripcionc;
    }
  </script>
  <table border="0" style="width: 100%"> 
     <tr>
      <td><span clas="texto_form">Nombre de la categor&iacute;a</span></td>
    <tr>

    <tr>
      <td>
        <input title="Ingrese el nombre de la categoría" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcionc" id="cdescripcionc" type="text" size="50" value="<?= $cdescripcionc;?>" />
      </td>
    </tr>
  </table>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_page()">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?categoria#categoria" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_categoria.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=categoria';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:20%;">C&oacute;digo </td>
      <td align='left'>Nombre</td>
    </tr>
    <?php
      //Conexión a la base de datos 

require_once("../clases/class_bd.php");
    $pgsql=new Conexion();
    $clausuleWhere = "WHERE c.dfecha_desactivacion IS NULL AND c.nid_categoria_padre IS NULL ";
    if($cnombreestado!=""){
      $clausuleWhere.="AND c.cdescripcion LIKE '%$cdescripcionc%' ";
    }
    //Sentencia sql (sin limit)  
      $_pagi_sql = "SELECT c.cdescripcion as cdescripcionc,c.nid_categoria as id, c.nid_categoria_padre
      FROM inventario.tcategoria c 
      $clausuleWhere 
      ORDER BY cdescripcion DESC";
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
          echo "<tr  style='cursor: pointer;' id='".$row['cdescripcionc']."' onclick='enviarForm(this.id)'>
                <td style='width:20%;'>".$row['id']."</td>
                <td align='left'>".$row['cdescripcionc']."</td></tr>"; 
      } 
      //Incluimos la barra de navegación 
    ?>
  </table>
  <script type="text/javascript">
  function enviarForm(value){
    document.getElementById('cdescripcion_oculto').value=value;
    document.getElementById('form1').submit();
  }
  </script>
  <form id="form1" method="POST" action="../controladores/control_categoria.php">
    <input type="hidden" name="cdescripcionc" id="cdescripcion_oculto" value="" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <div class="pagination">
    <ul>
      <?php echo"<li>".$_pagi_navegacion."</li>";?>
    </ul>
  </div>
  <?php }?>
</div>