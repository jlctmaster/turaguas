<div class="form_externo" >
  <?php
  if(isset($_SESSION['datos']['cdescripcionlocalizador'])){ 
    $disabledRClocalizador='disabled';
    $disabledMDlocalizador='';
    $estatuslocalizador=null;
  }else {
    $disabledRClocalizador='';
    $disabledMDlocalizador='disabled';
  }
  $servicios='localizador';
  if(isset($_SESSION['datos'])){
    @$cdescripcionlocalizador=$_SESSION['datos']['cdescripcionlocalizador'];
    @$nid_ubicacionlocalizador=$_SESSION['datos']['nid_ubicacionlocalizador'];
    @$cpunto_referencialocalizador=$_SESSION['datos']['cpunto_referencialocalizador'];
    @$estatuslocalizador=$_SESSION['datos']['estatuslocalizador'];
  }
  else{
    @$cdescripcionlocalizador=null;
    @$nid_ubicacionlocalizador=null;
    @$cpunto_referencialocalizador=null;
    @$estatuslocalizador=null;
  }
  if(!isset($_GET['l'])){?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_ubicacion.php" method="post" id="form1">
      <table border="0" style="width: 100%">
        <input type="hidden" name="ctabla" value="tubicacion" />
        <tr><td><span class="texto_form">Código</span></td><td><input title="el código del ubicación es generado por el sistema" name="nid_ubicacion" id="nid_ubicacion" type="text" size="10" readonly value="<?= $nid_ubicacionlocalizador;?>" /></td><tr>
        <tr><td><span class="texto_form">Ubicación</span></td><td><input title="Ingrese el nombre del ubicación" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripcionlocalizador;?>" required/></td><tr>
        <tr><td><span class="texto_form">Punto de Referencia</span></td><td> <textarea title="Ingrese un punto de referencia" onKeyUp="this.value=this.value.toUpperCase()" name="cpunto_referencia" id="cpunto_referencia" size="50" required/><?= $cpunto_referencialocalizador;?></textarea></td><tr>
        <?php echo '<tr><td colspan="2" class="'.$estatuslocalizador.'" id="estatus_registro">'.$estatuslocalizador.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
            <?php
              imprimir_boton($disabledRClocalizador,$disabledMDlocalizador,$estatuslocalizador,$servicios,"ubicacion");
            ?>         
          </td>
        </tr>
      </table>    
    </form>
  </fieldset>
  <br>
  <?php }else{  
  $cdescripcionlocalizador = $_GET['cdescripcion'];
  ?>
  <script type="text/javascript">
    function reload_tablocalizador(tab){
      cdescripcion = document.getElementById('cdescripcion').value;
      location.href="menu_principal.php?localizador&l&cdescripcion="+cdescripcion+tab;
    }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td><span class="texto_form">Ubicación</span></td>
    </tr>
    <tr>
      <td><input title="Ingrese el nombre del ubicación" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripcionlocalizador;?>" required/></td>
    </tr>
  </table>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tablocalizador('#ubicacion')">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?localizador#ubicacion" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_ubicacion.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=ubicacion';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:25%;"> Codigo </td>
      <td align='left'>Ubicación</td>
      <td align='left'>Punto de Referencia</td>
    </tr>
    <?php
    //Conexión a la base de datos 
    require_once("../clases/class_bd.php");
    $pgsql=new Conexion();
    $clausuleWhere="WHERE dfecha_desactivacion IS NULL ";
    if($cdescripcionlocalizador!=""){
      $clausuleWhere.="AND cdescripcion LIKE '%$cdescripcionlocalizador%'";
    }
    //Sentencia sql (sin limit) 
    $_pagi_sql = "SELECT * FROM inventario.tubicacion 
    $clausuleWhere 
    ORDER BY nid_ubicacion DESC";
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
      echo "<tr><td style='width:20%;'>".$row['nid_ubicacion']."</td>
        <td align='left'>".$row['cdescripcion']."</td>
        <td align='left'>".$row['cpunto_referencia']."</td></tr>"; 
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