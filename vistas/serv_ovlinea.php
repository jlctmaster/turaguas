<div class="form_externo" >
  <?php
  if(!empty($nid_documento) && !empty($nnro_orden) && !empty($dfecha_documento) && !empty($nid_almacen)){
    $_SESSION['nid_documento']=$nid_documento;
    $_SESSION['nnro_orden']= $nnro_orden;
    $_SESSION['dfecha_documento']=$dfecha_documento;
    $_SESSION['almacen']=$nid_almacen;
  }
  if(isset($_SESSION['datos']['nlinea'])){ 
    $disabledRCOVL='disabled';
    $disabledMDOVL='';
    $estatusovl=null;
  }else {
    $disabledRCOVL='';
    $disabledMDOVL='disabled';
  }
  $servicios='ordenventa';
  if(isset($_SESSION['datos'])){
    @$nid_detalledocumento=$_SESSION['datos']['nid_detalledocumento'];
    @$nid_documento=$_SESSION['datos']['nid_documento'];
    @$nnro_orden=$_SESSION['datos']['nnro_orden'];
    @$dfecha_documento=$_SESSION['datos']['dfecha_documento'];
    @$nlinea=$_SESSION['datos']['nlinea'];
    @$cid_articulo=$_SESSION['datos']['cid_articulo'];
    @$ncantidad_articulo=$_SESSION['datos']['ncantidad_articulo'];
    @$nid_impuesto=$_SESSION['datos']['nid_impuesto'];
    @$nprecio=$_SESSION['datos']['nprecio'];
    @$nid_almaceninventario=$_SESSION['datos']['nid_almaceninventario'];
    @$npreciolista=$_SESSION['datos']['npreciolista'];
    @$npreciolimite=$_SESSION['datos']['npreciolimite'];
    @$ndescuento=$_SESSION['datos']['ndescuento'];
    @$nimpuesto=$_SESSION['datos']['nimpuesto'];
    @$nmontoneto=$_SESSION['datos']['nmontoneto'];
    @$nmontoimpuesto=$_SESSION['datos']['nmontoimpuesto'];
    @$nmontodescuento=$_SESSION['datos']['nmontodescuento'];
  }
  else{
    @$nid_documento=null;
    @$nnro_orden=null;
    @$nid_detalledocumento=null;
    @$nlinea=null;
    @$cid_articulo=null;
    @$ncantidad_articulo=null;
    @$nid_impuesto=null;
    @$nid_almaceninventario=null;
    @$nprecio=null;
    @$npreciolista=null;
    @$npreciolimite=null;
    @$ndescuento=null;
    @$nimpuesto=null;
    @$nmontoneto=null;
    @$nmontoimpuesto=null;
    @$nmontodescuento=null;
    @$estatusovl=null;
  }
  if(!isset($_GET['l'])){?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_lineaordenventa.php" method="post" id="form2">
      <table border="0" style="width: 100%">
        <tr>
          <td><span class="texto_form">Nro. Órden</span></td>
          <td>
            <?php if(!empty($nid_documento)){?>
              <input type="hidden" id="nid_documento" name="nid_documento" value="<?= $nid_documento; ?>">
              <input title="El código del grupo proviene de la pestaña anterior" name="name_orden" id="name_orden" type="text" readonly value="<?= $nnro_orden."_".$dfecha_documento;?>" /> 
            <?php }else{?>
              <input type="hidden" id="nid_documento" name="nid_documento" value="<?= $_SESSION['nid_documento']; ?>">
              <input title="El nombre de la ubicación proviene de la pestaña anterior" name="name_orden" id="name_orden" type="text" readonly value="<?= $_SESSION['nnro_orden']."_".$_SESSION['dfecha_documento'];?>" /> 
            <?php } ?>
          </td>
        </tr>
        <tr>
          <input type="hidden" name="nid_detalledocumento" id="nid_detalledocumento" value="<?= $nid_detalledocumento;?>"/>
          <td><span class="texto_form">Línea</span></td>
          <td><input title="Correlativo para las líneas de la orden de venta" name="nlinea" id="nlinea" type="text" size="10" value="<? if(empty($nlinea)){echo "1";}else{echo $nlinea;}?>" /></td>
        </tr>
        <tr>
          <?php
            if(isset($_SESSION['almacen'])){
              echo "<input type='hidden' name='almacen' id='almacen' value='".$_SESSION['almacen']."'/>";
            }else{
              echo "<input type='hidden' name='almacen' id='almacen' value='".$nid_almaceninventario."'/>";
            }
          ?>
          <td><span class="texto_form">Artículo</span></td>
          <td>
            <select name="cid_articulo" id="cid_articulo" title="Seleccione un artículo">
              <option value="0">Seleccione un artículo</option>
              <?php
                require_once('../clases/class_bd.php');
                $conexion = new Conexion();
                $sql="SELECT TRIM(cid_articulo) cid_articulo,cdescripcion 
                FROM inventario.tarticulo 
                WHERE dfecha_desactivacion IS NULL AND nid_tipoarticulo <> (SELECT nid_tipoarticulo 
                  FROM inventario.ttipo_articulo WHERE LOWER(cdescripcion) LIKE '%insumo%')
                ORDER BY cid_articulo ASC";
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
          <td><span class="texto_form">Impuesto</span></td>
          <td>
            <select name="nid_impuesto" id="nid_impuesto" title="Seleccione un impuesto">
              <option value="0">Seleccione un impuesto</option>
              <?php
                require_once('../clases/class_bd.php');
                $conexion = new Conexion();
                $sql="SELECT * FROM facturacion.timpuesto WHERE dfecha_desactivacion IS NULL ORDER BY nid_impuesto ASC";
                $query=$conexion->Ejecutar($sql);
                while($row=$conexion->Respuesta($query)){
                  if($row['nid_impuesto']==$nid_impuesto){
                    echo "<option value='".$row['nid_impuesto']."' selected>".$row['cdescripcion']."</option>";
                  }else{
                    echo "<option value='".$row['nid_impuesto']."'>".$row['cdescripcion']."</option>";
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
        <tr>
          <td><span class="texto_form">Precio</span></td>
          <td><input title="Ingrese el precio de venta del artículo" name="nprecio" id="nprecio" type="text" size="10" onKeyPress="return isNumberKey(event)"
            value="<? if(empty($nprecio)){echo "0";}else{echo $nprecio;}?>" /></td>
        </tr>
        <tr>
          <td><span class="texto_form">Precio Lista</span></td>
          <td><input title="Precio del artículo de la lista de precios" name="npreciolista" id="npreciolista" type="text" size="10" readonly value="<? if(empty($npreciolista)){echo "0";}else{echo $npreciolista;}?>" /></td>
          <input type="hidden" name="npreciolimite" id="npreciolimite" value="<?=$npreciolimite?>">
        </tr> 
        <tr>
          <td><span class="texto_form">Porcentaje de Descuento</span></td>
          <td><input title="Porcentaje de descuento según precio lista" name="ndescuento" id="ndescuento" type="text" size="10" readonly value="<? if(empty($ndescuento)){echo "0";}else{echo $ndescuento;}?>" />%</td>
        </tr>
        <tr>
          <td><span class="texto_form">Impuesto de la Línea</span></td>
          <td><input title="Monto del impuesto de la línea" name="nmontoimpuesto" id="nmontoimpuesto" type="text" size="10" readonly value="<? if(empty($nmontoimpuesto)){echo "0";}else{echo $nmontoimpuesto;}?>" /></td>
          <input type="hidden" name="nimpuesto" id="nimpuesto" value="<?=$nimpuesto?>">
        </tr>
        <tr>
          <td><span class="texto_form">Descuento de la Línea</span></td>
          <td><input title="Monto del descuento de la línea" name="nmontodescuento" id="nmontodescuento" type="text" size="10" readonly value="<? if(empty($nmontodescuento)){echo "0";}else{echo $nmontodescuento;}?>" /></td>
        </tr>      
        <tr>
          <td><span class="texto_form">Neto Línea</span></td>
          <td><input title="Monto neto de la línea sin impuesto" name="nmontoneto" id="nmontoneto" type="text" size="10" readonly value="<? if(empty($nmontoneto)){echo "0";}else{echo $nmontoneto;}?>" /></td>
        </tr>
        <?php echo '<tr><td colspan="2" class="'.$estatusovl.'" id="estatus_registro">'.$estatusovl.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
            <?php
              imprimir_boton($disabledRCOVL,$disabledMDOVL,$estatusovl,$servicios,"lineaordenventa");
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
      location.href="menu_principal.php?ordenventa&l&cid_articulo="+cid_articulo+tab;
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
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tablinea('#lineaordenventa')">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?ordenventa#lineaordenventa" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_lineaordenventa.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=lineaordenventa';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:20%;">Nro. Órden</td>
      <td align='left'>Nro. Línea</td>
      <td align='left'>Artículo</td>
      <td align='left'>Cantidad</td>
      <td align='left'>Precio</td>
      <td align='left'>Decuento</td>
      <td align='left'>Alicuota</td>
      <td align='left'>Total Línea</td>
    </tr>
    <?php
    //Conexión a la base de datos 
    require_once("../clases/class_bd.php");
    $pgsql=new Conexion();
    $clausuleWhere = "WHERE d.nnro_orden = '".$_SESSION['nnro_orden']."' AND d.ctipo_transaccion = 'V'";
    if($cid_articulo!=""){
      $clausuleWhere.="AND dd.cid_articulo LIKE '%$cid_articulo%'";
    }
    //Sentencia sql (sin limit) 
    $_pagi_sql = "SELECT d.nid_documento, TRIM(d.nnro_orden) nnro_orden,d.nlinea,TRIM(d.cid_articulo || ' ' || a.cdescripcion) articulo,
    d.ncantidad_articulo,d.nprecio,CASE WHEN dlp.ndescuento IS NULL THEN 0 ELSE dlp.ndescuento END descuento,
    CASE WHEN i.nporcentaje IS NULL THEN 0 ELSE i.nporcentaje END alicuota,
    ROUND((d.ncantidad_articulo*d.nprecio)+((d.ncantidad_articulo*d.nprecio)* CASE WHEN i.nporcentaje IS NULL THEN 0 ELSE i.nporcentaje END / 100)-((d.ncantidad_articulo*d.nprecio)* CASE WHEN dlp.ndescuento IS NULL THEN 0 ELSE dlp.ndescuento END / 100),2) total_linea 
    FROM facturacion.vw_orden_compra_venta d  
    LEFT JOIN facturacion.tdetalle_lista_precio dlp ON d.cid_articulo = dlp.cid_articulo 
    LEFT JOIN facturacion.timpuesto i ON d.nid_impuesto = i.nid_impuesto 
    LEFT JOIN inventario.tarticulo a ON d.cid_articulo = a.cid_articulo
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
      echo "<tr style='cursor: pointer;' id='".$row['nid_documento']."|".$row['nlinea']."' onclick='enviarFormLOV(this.id)'>
        <td style='width:20%;'>".$row['nnro_orden']."</td>
        <td align='left'>".$row['nlinea']."</td>
        <td align='left'>".$row['articulo']."</td>
        <td align='left'>".$row['ncantidad_articulo']."</td>
        <td align='left'>".$row['nprecio']."</td>
        <td align='left'>".$row['descuento']."%</td>
        <td align='left'>".$row['alicuota']."%</td>
        <td align='left'>".$row['total_linea']." BsF</td>
        </tr>"; 
    } 
    //Incluimos la barra de navegación 
    ?>
  </table>
  <script type="text/javascript">
  function enviarFormLOV(value){
    var valor=value.split('|');
    document.getElementById('nid_documento').value=valor[0];
    document.getElementById('nlinea').value=valor[1];
    document.getElementById('form2').submit();
  }
  </script>
  <form id="form2" method="POST" action="../controladores/control_lineaordenventa.php">
    <input type="hidden" name="nid_documento" id="nid_documento" value="" />
    <input type="hidden" name="nlinea" id="nlinea" value="" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <div class="pagination">
    <ul>
      <?php echo"<li>".$_pagi_navegacion."</li>";?>
    </ul>
  </div>
  <?php }?>
</div>