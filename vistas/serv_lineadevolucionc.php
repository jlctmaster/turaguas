<div class="form_externo" >
  <?php
  if(!empty($nid_devolucion) && !empty($nnro_devolucion) && !empty($dfecha_devolucion)){
    $_SESSION['nid_devolucion']=$nid_devolucion;
    $_SESSION['nnro_devolucion']= $nnro_devolucion;
    $_SESSION['dfecha_devolucion']=$dfecha_devolucion;
  }
  if(isset($_SESSION['datos']['nid_detalledevolucion'])){ 
    $disabledRClineadevolucion='disabled';
    $disabledMDlineadevolucion='';
    $estatuslineadevolucion=null;
  }else {
    $disabledRClineadevolucion='';
    $disabledMDlineadevolucion='disabled';
  }
  $servicios='devolucioncliente';
  if(isset($_SESSION['datos'])){
    @$nid_detalledevolucion=$_SESSION['datos']['nid_detalledevolucion'];
    @$nid_devolucion=$_SESSION['datos']['nid_devolucion'];
    @$nnro_devolucion=$_SESSION['datos']['nnro_devolucion'];
    @$nid_motivodevolucion=$_SESSION['datos']['nid_motivodevolucion'];
    @$cid_articulo=$_SESSION['datos']['cid_articulo'];
    @$ncantidad_articulo=$_SESSION['datos']['ncantidad_articulo'];
  }
  else{
    @$nid_devolucion=null;
    @$nnro_devolucion=null;
    @$nid_detalledevolucion=null;
    @$nid_motivodevolucion=null;
    @$cid_articulo=null;
    @$ncantidad_articulo=null;
    @$estatuslineadevolucion=null;
  }
  if(!isset($_GET['l'])){?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_lineadevolucion.php" method="post" id="form2">
      <table border="0" style="width: 100%">
        <tr>
          <td><span class="texto_form">Nro. Órden</span></td>
          <td>
            <?php if(!empty($nid_devolucion)){?>
              <input type="hidden" id="nid_devolucion" name="nid_devolucion" value="<?= $nid_devolucion; ?>">
              <input title="El código del grupo proviene de la pestaña anterior" name="name_orden" id="name_orden" type="text" readonly value="<?= trim($nnro_devolucion)."_".$dfecha_devolucion;?>" /> 
            <?php }else{?>
              <input type="hidden" id="nid_devolucion" name="nid_devolucion" value="<?= $_SESSION['nid_devolucion']; ?>">
              <input title="El nombre de la ubicación proviene de la pestaña anterior" name="name_orden" id="name_orden" type="text" readonly value="<?= $_SESSION['nnro_devolucion']."_".$_SESSION['dfecha_devolucion'];?>" /> 
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Código</span></td>
          <td><input title="El código de la línea es generado por el sistema" name="nid_detalledevolucion" id="nid_detalledevolucion" type="text" size="10" readonly value="<?= $nid_detalledevolucion;?>" /></td>
        </tr>
        <tr>
          <td><span class="texto_form">Motivo devolución</span></td>
          <td>
            <select name="nid_motivodevolucion" id="nid_motivodevolucion" title="Seleccione el motivo devolución">
              <option value="0">Seleccione el motivo devolución</option>
              <?php
                require_once('../clases/class_bd.php');
                $conexion = new Conexion();
                $sql="SELECT nid_motivodevolucion,cdescripcion, cacumulado 
                FROM facturacion.tmotivo_devolucion 
                WHERE cacumulado='N' and dfecha_desactivacion IS NULL  ORDER BY cdescripcion ASC";
                $query=$conexion->Ejecutar($sql);
                while($row=$conexion->Respuesta($query)){
                  if($row['nid_motivodevolucion']==$nid_motivodevolucion){
                    echo "<option value='".$row['nid_motivodevolucion']."' selected>".$row['cdescripcion']."</option>";
                  }else{
                    echo "<option value='".$row['nid_motivodevolucion']."'>".$row['cdescripcion']."</option>";
                  }
                }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Artículo</span></td>
          <td>
            <select name="cid_articulo" id="cid_articulo" title="Seleccione un artículo">
              <option value="0">Seleccione un artículo</option>
              <?php
                require_once('../clases/class_bd.php');
                $conexion = new Conexion();
                $sql="SELECT TRIM(cid_articulo) cid_articulo,cdescripcion FROM inventario.tarticulo WHERE dfecha_desactivacion IS NULL ORDER BY cid_articulo ASC";
                $query=$conexion->Ejecutar($sql);
                while($row=$conexion->Respuesta($query)){
                  if($row['cid_articulo']==$cid_articulo){
                    echo "<option value='".$row['cid_articulo']."' selected>".$row['cid_articulo']."_".$row['cdescripcion']."</option>";
                  }else{
                    echo "<option value='".$row['cid_articulo']."'>".$row['cid_articulo']."_".$row['cdescripcion']."</option>";
                  }
                }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Cantidad</span></td>
          <td><input title="Ingrese la cantidad de artículos" name="ncantidad_articulo" id="ncantidad_articulo" onKeyPress="return isNumberKey(event)"
            type="text" size="10" value="<? if(empty($ncantidad_articulo)){echo "0";}else{echo $ncantidad_articulo;}?>" /></td>
        </tr>
        <?php echo '<tr><td colspan="2" class="'.$estatuslineadevolucion.'" id="estatus_registro">'.$estatuslineadevolucion.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
            <?php
              imprimir_boton($disabledRClineadevolucion,$disabledMDlineadevolucion,$estatuslineadevolucion,$servicios,"lineadevolucionc");
            ?>         
          </td>
        </tr>
      </table>
    </form>
  </fieldset>
  <br>
  <?php }else{ 
  $cid_articulo = $_GET['cid_articulo'];
  ?>
  <script type="text/javascript">
    function reload_tablinea(tab){
      cid_articulo = document.getElementById('cid_articulo').value;
      location.href="menu_principal.php?devolucioncliente&l&cid_articulo="+cid_articulo+tab;
    }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td><span clas="texto_form">Artículos</span></td>
    </tr>
    <tr>
      <td>
        <select name="cid_articulo" id="cid_articulo" title="Seleccione un artículo">
              <option value="0">Seleccione un artículo</option>
              <?php
                require_once('../clases/class_bd.php');
                $conexion = new Conexion();
                $sql="SELECT TRIM(cid_articulo) cid_articulo,cdescripcion FROM inventario.tarticulo WHERE dfecha_desactivacion IS NULL ORDER BY cid_articulo ASC";
                $query=$conexion->Ejecutar($sql);
                while($row=$conexion->Respuesta($query)){
                  if($row['cid_articulo']==$cid_articulo){
                    echo "<option value='".$row['cid_articulo']."' selected>".$row['cid_articulo']."_".$row['cdescripcion']."</option>";
                  }else{
                    echo "<option value='".$row['cid_articulo']."'>".$row['cid_articulo']."_".$row['cdescripcion']."</option>";
                  }
                }
              ?>
            </select>
      </td>
    </tr>
  </table>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tablinea('#lineadevolucionc')">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?devolucioncliente#lineadevolucionc" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_lineadevolucionc.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=lineadevolucionc';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:20%;">Nro. Órden</td>
      <td align='left'>Código</td>
      <td align='left'>Motivo devolución</td>
      <td align='left'>Artículo</td>
      <td align='left'>Cantidad</td>
    </tr>
    <?php
    //Conexión a la base de datos 
    require_once("../clases/class_bd.php");
    $pgsql=new Conexion();
    $clausuleWhere = "WHERE d.nnro_devolucion = '".$_SESSION['nnro_devolucion']."' ";
    if($cid_articulo!=""){
      $clausuleWhere.="AND dd.cid_articulo LIKE '%$cid_articulo%'";
    }
    //Sentencia sql (sin limit) 
    $_pagi_sql = "SELECT TRIM(d.nnro_devolucion) nnro_devolucion,TRIM(dd.cid_articulo || a.cdescripcion) articulo,m.cdescripcion motivodevolucion,
    dd.ncantidad_articulo,
    FROM facturacion.tdevolucion d 
    LEFT JOIN facturacion.tdetalle_devolucion dd ON d.nid_devolucion = dd.nid_devolucion
    LEFT JOIN facturacion.tmotivo_devolucion m ON m.nid_motivodevolucion = dd.nid_motivodevolucion 
    LEFT JOIN inventario.tarticulo a ON dd.cid_articulo = a.cid_articulo
    $clausuleWhere 
    ORDER BY 1,2,3 ASC";
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
      echo "<tr><td style='width:20%;'>".$row['nnro_devolucion']."</td>
        <td align='left'>".$row['motivodevolucion']."</td>
        <td align='left'>".$row['articulo']."</td>
        <td align='left'>".$row['ncantidad_articulo']."</td>
        </tr>"; 
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