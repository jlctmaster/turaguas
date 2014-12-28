<div class="form_externo" >
  <?php
  if(!empty($nid_ubicacionlocalizador) && !empty($cdescripcionlocalizador)){
    $_SESSION['cdescripcionlocalizador']= $cdescripcionlocalizador;
    $_SESSION['nid_ubicacionlocalizador']=$nid_ubicacionlocalizador;
  }
  if(isset($_SESSION['datos']['cdescripcionalmacen'])){ 
    $disabledRCalmacen='disabled';
    $disabledMDalmacen='';
    $estatusalmacen=null;
  }else {
    $disabledRCalmacen='';
    $disabledMDalmacen='disabled';
  }
  $servicios='localizador';
  if(isset($_SESSION['datos'])){
    @$cdescripcionalmacen=$_SESSION['datos']['cdescripcionalmacen'];
    @$nid_almacen=$_SESSION['datos']['nid_almacen'];
    @$nid_ubicacionlocalizador=$_SESSION['datos']['nid_ubicacionlocalizador'];
    @$cdescripcionlocalizador=$_SESSION['datos']['cdescripcionlocalizador'];
    @$estatusalmacen=$_SESSION['datos']['estatusalmacen'];
  }
  else{
    @$cdescripcionalmacen=null;
    @$cdescripcionlocalizador=null;
    @$nid_ubicacionlocalizador=null;
    @$nid_almacen=null;
    @$estatusalmacen=null;
  }
  if(!isset($_GET['l'])){?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_almacen.php" method="post" id="form2">
      <table border="0" style="width: 100%">
        <tr>
          <td><span class="texto_form">Ubicación</span></td>
          <td>
            <?php if(!empty($nid_ubicacionlocalizador)){?>
              <input type="hidden" id="nid_ubicacionlocalizador" name="nid_ubicacionlocalizador" value="<?= $nid_ubicacionlocalizador; ?>">
              <input title="El código de la ubicación proviene de la pestaña anterior" name="nid_ubicacionlocalizador" id="nid_ubicacionlocalizador" type="text" readonly value="<?= $nid_ubicacionlocalizador."_".$cdescripcionlocalizador;?>" /> 
            <?php }else{?>
              <input type="hidden" id="nid_ubicacionlocalizador" name="nid_ubicacionlocalizador" value="<?= $_SESSION['nid_ubicacionlocalizador']; ?>">
              <input title="El nombre de la ubicación proviene de la pestaña anterior" name="cdescripcionlocalizador" id="cdescripcionlocalizador" type="text" readonly value="<?= $_SESSION['nid_ubicacionlocalizador']."_".$_SESSION['cdescripcionlocalizador'];?>" /> 
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Código</span></td>
          <td><input title="el código del almacén es generado por el sistema" name="nid_almacen" id="nid_almacen" type="text" size="10" readonly value="<?= $nid_almacen;?>" /> </td>
        </tr>
        <tr>
          <td><span class="texto_form">Almacén</span></td>
          <td> <input title="Ingrese el nombre del almacén" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcionalmacen" id="cdescripcionalmacen" type="text" size="50" value="<?= $cdescripcionalmacen;?>" required/></td>
        </tr>
        <?php echo '<tr><td colspan="2" class="'.$estatusalmacen.'" id="estatus_registro">'.$estatusalmacen.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
            <?php
              imprimir_boton($disabledRCalmacen,$disabledMDalmacen,$estatusalmacen,$servicios,"almacen");
            ?>         
          </td>
        </tr>
      </table>
    </form>
  </fieldset>
  <br>
  <?php }else{ 
  $cdescripcionalmacen = $_GET['cdescripcionalmacen'];
  ?>
  <script type="text/javascript">
    function reload_tabalmacen(tab){
      cdescripcionalmacen = document.getElementById('cdescripcionalmacen').value;
      location.href="menu_principal.php?localizador&l&cdescripcionalmacen="+cdescripcionalmacen+tab;
    }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td><span clas="texto_form">Nombre del Almacén</span></td>
    </tr>
    <tr>
      <td>
        <input title="Ingrese el nombre del almacén" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcionalmacen" id="cdescripcionalmacen" type="text" size="50" value="<?= $cdescripcionalmacen;?>" />
      </td>
    </tr>
  </table>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabalmacen('#almacen')">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?localizador#almacen" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_almacen.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=almacen';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:20%;">C&oacute;digo </td>
      <td align='left'>Almacén</td>
      <td align='left'>C&oacute;digo Almacén</td>
      <td align='left'>Almacén</td>
    </tr>
    <?php
    //Conexión a la base de datos 
    require_once("../clases/class_bd.php");
    $pgsql=new Conexion();
    $clausuleWhere = "WHERE u.nid_ubicacion = ".$_SESSION['nid_ubicacionlocalizador']."";
    if($cdescripcionalmacen!=""){
      $clausuleWhere.="AND a.cdescripcion LIKE '%$cdescripcionalmacen%'";
    }
    //Sentencia sql (sin limit) 
    $_pagi_sql = "SELECT a.cdescripcion as almacen,a.nid_almacen as aid,a.nid_ubicacion,u.cdescripcion as ubicacion 
    FROM inventario.talmacen a 
    INNER JOIN inventario.tubicacion u ON a.nid_ubicacion = u.nid_ubicacion 
    $clausuleWhere 
    ORDER BY a.cdescripcion DESC";
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
      echo "<tr><td style='width:20%;'>".$row['aid']."</td>
        <td align='left'>".$row['almacen']."</td>
        <td align='left'>".$row['nid_ubicacion']."</td>
        <td align='left'>".$row['ubicacion']."</td></tr>"; 
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