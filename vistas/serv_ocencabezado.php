<div class="form_externo" >
  <?php
  if(isset($_SESSION['datos']['nnro_orden'])){ 
    $disabledRCOC='disabled';
    $disabledMDOC='';
    $estatusoc=null;
  }else {
    $disabledRCOC='';
    $disabledMDOC='disabled';
  }
  $servicios='ordencompra';
  if(isset($_SESSION['datos'])){
    @$nid_documento=$_SESSION['datos']['nid_documento'];
    @$nnro_orden=$_SESSION['datos']['nnro_orden'];
    @$nid_tipodocumento=$_SESSION['datos']['nid_tipodocumento'];
    @$dfecha_documento=$_SESSION['datos']['dfecha_documento'];
    @$crif_persona=$_SESSION['datos']['crif_persona'];
    @$cnombreproveedor=$_SESSION['datos']['cnombreproveedor'];
    @$cdireccionproveedor=$_SESSION['datos']['cdireccionproveedor'];
    @$nid_condicionpago=$_SESSION['datos']['nid_condicionpago'];
    @$nid_almacen=$_SESSION['datos']['nid_almacen'];
    @$cestado_documento=$_SESSION['datos']['cestado_documento'];
    @$caccion_documento=$_SESSION['datos']['caccion_documento'];
    @$nmonto_base=$_SESSION['datos']['nmonto_base'];
    @$nmonto_total=$_SESSION['datos']['nmonto_total'];
    @$estatusoc=$_SESSION['datos']['estatus'];
  }
  else{
    @$nnro_orden=null;
    @$nid_tipodocumento=null;
    @$dfecha_documento=null;
    @$crif_persona=null;
    @$cnombreproveedor=null;
    @$cdireccionproveedor=null;
    @$nid_condicionpago=null;
    @$nid_almacen=null;
    @$cestado_documento="DR";
    @$caccion_documento="CO";
    @$nmonto_base=null;
    @$nmonto_total=null;
    @$estatusoc=null;
  }
  if(!isset($_GET['l'])){?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_ordencompra.php" method="post" id="form1">
      <table border="0" style="width: 100%">
        <input name="nid_documento" id="nid_documento" type="hidden" value="<?= $nid_documento;?>" />
        <tr>
          <td>
            <span class="texto_form">Tipo de Documento</span>
          </td>
          <td>
            <select name="nid_tipodocumento" id="nid_tipodocumento" title="Seleccione un tipo de documento" required />
              <option value="0">Seleccione un tipo de documento</option>
              <?php
                require_once('../clases/class_bd.php');
                $conexion = new Conexion();
                $sql="SELECT nid_tipodocumento,cdescripcion FROM facturacion.ttipo_documento WHERE ctipo_transaccion = 'C' 
                AND dfecha_desactivacion IS NULL AND (LOWER(cdescripcion) LIKE '%oc%' OR LOWER(cdescripcion) LIKE '%órden de compra%' OR LOWER(cdescripcion) LIKE '%compra%')
                ORDER BY nid_tipodocumento ASC";
                $query=$conexion->Ejecutar($sql);
                while($row=$conexion->Respuesta($query)){
                  if($row['nid_tipodocumento']==$nid_tipodocumento){
                    echo "<option value='".$row['nid_tipodocumento']."' selected>".$row['cdescripcion']."</option>";
                  }else{
                    echo "<option value='".$row['nid_tipodocumento']."'>".$row['cdescripcion']."</option>";
                  }
                }
              ?>
            </select> 
          </td>
        </tr> 
        <tr>
          <td>
            <span class="texto_form">Nro. Órden</span>
          </td>
          <td>
            <?php 
            require_once('../clases/class_bd.php');
            $conexion = new Conexion();
            $sql="SELECT nid_tipodocumento,cdescripcion FROM facturacion.ttipo_documento WHERE ctipo_transaccion = 'C' 
                 AND dfecha_desactivacion IS NULL AND (LOWER(cdescripcion) LIKE '%oc%' OR LOWER(cdescripcion) LIKE '%órden de compra%' OR LOWER(cdescripcion) LIKE '%compra%')
                 ORDER BY nid_tipodocumento ASC";
            $query=$conexion->Ejecutar($sql);
            while($row=$conexion->Respuesta($query)){
              echo "<input type='hidden' id='nid_tipodocumento' name='nid_tipodocumento' value='".$row['nid_tipodocumento']."'/>";
            }
            ?>
            <input title="Ingrese el nro. de la órden de compra" onKeyPress="return isNumberDocKey(event)" name="nnro_orden" 
            id="nnro_orden" type="text" size="50" value="<?= $nnro_orden;?>" maxlength=11 required />
          </td>
        </tr>
        <tr>
          <td>
            <span class="texto_form">Fecha del Documento</span>
          </td>
          <td>
            <input title="Seleccione la fecha de la órden de compra" name="dfecha_documento" id="dfecha_documento" type="text" size="50" readonly value="<?= $dfecha_documento;?>" required />
          </td>
        </tr>
        <tr>
          <td>
            <span class="texto_form">Rif Proveedor</span>
          </td>
          <td>
            <input title="Ingrese el rif o cédula del proveedor" onKeyUp="this.value=this.value.toUpperCase()" name="crif_persona" id="crif_persona" type="text" size="50" value="<?= $crif_persona;?>" required />
          </td>
        </tr>
        <tr>
          <td>
            <span class="texto_form">Nombre Proveedor</span>
          </td>
          <td>
            <input title="Nombre del proveedor" name="cnombreproveedor" id="cnombreproveedor" type="text" size="50" value="<?= $cnombreproveedor;?>" readonly />
          </td>
        </tr>
         <tr>
          <td>
            <span class="texto_form">Dirección Proveedor</span>
          </td>
          <td>
            <textarea title="Dirección del proveedor" name="cdireccionproveedor" id="cdireccionproveedor" rows="5" cols="50"  readonly /><?= $cdireccionproveedor;?> </textarea>
          </td>
        </tr> 
        <tr>
          <td>
            <span class="texto_form">Condición de Pago</span>
          </td>
          <td>
            <select name="nid_condicionpago" id="nid_condicionpago" title="Seleccione una condición de pago" required />
              <option value="0">Seleccione una condición de pago</option>
              <?php
                require_once('../clases/class_bd.php');
                $conexion = new Conexion();
                $sql="SELECT * FROM facturacion.tcondicion_pago WHERE dfecha_desactivacion IS NULL ORDER BY nid_condicionpago ASC";
                $query=$conexion->Ejecutar($sql);
                while($row=$conexion->Respuesta($query)){
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
          <td>
            <span class="texto_form">Almacén</span>
          </td>
          <td>
            <select name="nid_almacen" id="nid_almacen" title="Seleccione un almacén" required />
              <option value="0">Seleccione un almacén</option>
              <?php
                require_once('../clases/class_bd.php');
                $conexion = new Conexion();
                $sql="SELECT * FROM inventario.talmacen WHERE dfecha_desactivacion IS NULL ORDER BY nid_almacen ASC";
                $query=$conexion->Ejecutar($sql);
                while($row=$conexion->Respuesta($query)){
                  if($row['nid_almacen']==$nid_almacen){
                    echo "<option value='".$row['nid_almacen']."' selected>".$row['cdescripcion']."</option>";
                  }else{
                    echo "<option value='".$row['nid_almacen']."'>".$row['cdescripcion']."</option>";
                  }
                }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <span class="texto_form">Monto Base</span>
          </td>
          <td>
            <input title="El monto base es calculado según las líneas del documento" name="nmonto_base" id="nmonto_base" type="text" size="50" readonly value="<? if(empty($nmonto_base)){echo "0";}else{echo $nmonto_base;} ?>" required />
          </td>
        </tr>
        <tr>
          <td>
            <span class="texto_form">Total a Pagar</span>
          </td>
          <td>
            <input title="El monto total a pagar es calculado según las líneas del documento más el impuesto" name="nmonto_total" id="nmonto_total" type="text" size="50" readonly value="<? if(empty($nmonto_total)){echo "0";}else{echo $nmonto_total;}?>" required />
          </td>
        </tr> 
        <tr>
          <td>
            <span class="texto_form">Estado del Documento</span>
          </td>
          <td>
            <input type="hidden" name="cestado_documento" id="cestado_documento" value="<?= $cestado_documento;?>"/>
            <input title="Estado actual del documento, puede ser Borrador,Completado,Anulado o Cerrado" name="estado_doc" 
            id="estado_doc" type="text" size="50" readonly 
            value="<? if($cestado_documento=="DR"){echo "Borrador";}else if($cestado_documento=="CO"){echo "Completado";}else if($cestado_documento=="VO"){echo "Anulado";}else if($cestado_documento=="CL"){echo "Cerrado";}?>" required />
          </td>
        </tr>
        <tr>
          <td>
            <span class="texto_form">Acción del Documento</span>
          </td>
          <td>
            <input type="hidden" name="caccion_documento" id="caccion_documento" value="<?= $caccion_documento;?>"/>
            <input title="Acción que completa el documento" class="btn btn-default" name="accion_completar" id="accion_completar" type="button" value="Completar" <? if($caccion_documento=="CL" || $caccion_documento=="--"){echo "disabled";} ?> />
            <input title="Acción que cierra el documento" class="btn btn-default" name="accion_cerrar" id="accion_cerrar" type="button" value="Cerrar" <? if($caccion_documento=="CO" || $caccion_documento=="--"){echo "disabled";} ?> />
            <input title="Acción que anula el documento" class="btn btn-default" name="accion_anular" id="accion_anular" type="button" value="Anular" <? if($caccion_documento=="CO" || $caccion_documento=="--"){echo "disabled";} ?> />
          </td>
        </tr>
        <?php echo '<tr><td colspan="2" class="'.$estatusoc.'" id="estatus_registro">'.$estatusoc.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
            <?php
              imprimir_boton($disabledRCOC,$disabledMDOC,$estatusoc,$servicios,"ordencompra");
            ?> 
            <input onclick="location='../invoice/ordencv.php?nnro_orden=<?= $nnro_orden;?>&tipo=C'" 
            type="button" name="btimprimir" id="8" value="Imprimir Documento" class="btn btn-default" 
            <? if($nnro_orden==null){ echo "disabled";}?> />
          </td>
        </tr>
      </table>    
    </form>
    <div id="Anular" style="display:none;">
        <span class="texto_form">Seleccione un motivo o razón por el cual desea anular el documento</span>
        <br/><br/>
        <table style="width: 50%; margin-left: 25%;">
          <tr>
            <td><span class="texto_form">Motivo o Razón</span></td>
            <td>
              <select name="nid_motivorazon" id="nid_motivorazon" title="Seleccione un motivo o razón" required />
                <option value="0">Seleccione un motivo o razón</option>
                <?php
                  require_once('../clases/class_bd.php');
                  $conexion = new Conexion();
                  $sql="SELECT * FROM facturacion.tmotivo_razon WHERE dfecha_desactivacion IS NULL ORDER BY nid_motivorazon ASC";
                  $query=$conexion->Ejecutar($sql);
                  while($row=$conexion->Respuesta($query)){
                      echo "<option value='".$row['nid_motivorazon']."'>".$row['cdescripcion']."</option>";
                  }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td>
            </td>
            <td>
              <input type="button" class="btn btn-default" value="Continuar" id="BtnAnular">
            </td>
          </tr>
        </table>
    </div>
  </fieldset>
  <br>
<?php } else{  
  $nnro_orden = $_GET['nnro_orden'];
  $crif_persona = $_GET['crif_persona'];
  ?>
  <script type="text/javascript">
    function reload_taboc(tab){
      nnro_orden = document.getElementById('nnro_orden').value;
      crif_persona = document.getElementById('crif_persona').value;
      location.href="menu_principal.php?ordencompra&l&nnro_orden="+nnro_orden+"&crif_persona="+crif_persona+tab;
    }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td>
        <span class="texto_form">Nro. Órden</span>
      </td>
      <td>
        <input title="Ingrese el nro. de la órden de compra" onKeyUp="this.value=this.value.toUpperCase()" name="nnro_orden" id="nnro_orden" type="text" size="50" value="<?= $nnro_orden;?>" />
      </td>
      <td>
        <span class="texto_form">Proveedor</span>
      </td>
      <td>
        <input title="Ingrese el rif o cédula del proveedor" onKeyUp="this.value=this.value.toUpperCase()" name="crif_persona" id="crif_persona" type="text" size="50" value="<?= $crif_persona;?>" />
      </td>
    </tr>
  </table>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_taboc('#ordencompra')">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?ordencompra#ordencompra" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_ordencompra.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=ordencompra';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:20%;">Nro. Órden</td>
      <td align='left'>Tipo de Documento</td>
      <td align='left'>Fecha del Documento</td>
      <td align='left'>Proveedor</td>
      <td align='left'>Monto Base</td>
      <td align='left'>Total a Pagar</td>
      <td align='left'>Estatus</td>
    </tr>
    <?php
    //Conexión a la base de datos 
    require_once("../clases/class_bd.php");
    $pgsql=new Conexion();
    $clausuleWhere="WHERE d.dfecha_desactivacion IS NULL AND d.ctipo_transaccion = 'C' ";
    if($nnro_orden!="" && $crif_persona!=""){
      $clausuleWhere.="AND nnro_orden LIKE '%$nnro_orden%' AND crif_persona LIKE '%$crif_persona%'";
    }
    else if($nnro_orden!=""){
      $clausuleWhere.="AND nnro_orden LIKE '%$nnro_orden%'";
    }
    else if($crif_persona!=""){
      $clausuleWhere.="AND crif_persona LIKE '%$crif_persona%'";
    }
    //Sentencia sql (sin limit) 
    $_pagi_sql = "SELECT TRIM(d.nnro_orden) nnro_orden, td.cdescripcion tipodocumento, TO_CHAR(d.dfecha_documento,'DD/MM/YYYY') dfecha_documento, 
    p.crif_persona|| ' ' || p.cnombre proveedor, CASE d.cestado_documento WHEN 'CO' THEN 'Completado' WHEN 'CL' THEN 'Cerrado' WHEN 'VO' THEN 'Anulado' ELSE 'Borrador' END estatus,
    SUM(CASE WHEN (d.ncantidad_articulo*d.nprecio) IS NULL THEN 0 ELSE (d.ncantidad_articulo*d.nprecio) END) monto_base, ROUND(SUM(d.nmonto_total),2) monto_total 
    FROM facturacion.vw_orden_compra_venta d 
    INNER JOIN facturacion.ttipo_documento td ON d.nid_tipodocumento = td.nid_tipodocumento 
    INNER JOIN general.tpersona p ON d.crif_persona = p.crif_persona 
    $clausuleWhere 
    GROUP BY d.nnro_orden,td.cdescripcion,d.dfecha_documento,p.crif_persona,p.cnombre,d.cestado_documento  
    ORDER BY d.nnro_orden DESC";
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
      echo "<tr style='cursor: pointer;' id='".$row['nnro_orden']."' onclick='enviarFormOC(this.id)'>
        <td style='width:20%;'>".$row['nnro_orden']."</td>
        <td align='left'>".$row['tipodocumento']."</td>
        <td align='left'>".$row['dfecha_documento']."</td>
        <td align='left'>".$row['proveedor']."</td>
        <td align='left'>".$row['monto_base']."</td>
        <td align='left'>".$row['monto_total']."</td>
        <td align='left'>".$row['estatus']."</td>
        </tr>"; 
    } 
    //Incluimos la barra de navegación 
    ?>
  </table>
  <script type="text/javascript">
  function enviarFormOC(value){
    document.getElementById('nnro_orden_oculto').value=value;
    document.getElementById('form1').submit();
  }
  </script>
  <form id="form1" method="POST" action="../controladores/control_ordencompra.php">
    <input type="hidden" name="nnro_orden" id="nnro_orden_oculto" value="" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <div class="pagination">
    <ul>
      <?php echo"<li>".$_pagi_navegacion."</li>";?>
    </ul>
  </div>
  <?php }?>
</div>