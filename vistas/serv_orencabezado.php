<div class="form_externo" >
  <?php
  if(isset($_SESSION['datos']['nnro_ent_recib'])){ 
    $disabledRCOC='disabled';
    $disabledMDOC='';
    $estatusoc=null;
  }else {
    $disabledRCOC='';
    $disabledMDOC='disabled';
  }
  $servicios='ordenrecibo';
  if(isset($_SESSION['datos'])){
    @$nid_documento=$_SESSION['datos']['nid_documento'];
    @$nnro_orden=$_SESSION['datos']['nnro_orden'];
    @$nnro_ent_recib=$_SESSION['datos']['nnro_ent_recib'];
    @$nid_tipodocumento=$_SESSION['datos']['nid_tipodocumento'];
    @$dfecha_documento=$_SESSION['datos']['dfecha_documento'];
    @$dfecha_ent_recib=$_SESSION['datos']['dfecha_ent_recib'];
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
    @$nid_documento=null;
    @$nnro_orden=null;
    @$nnro_ent_recib=null;
    @$nid_tipodocumento=null;
    @$dfecha_documento=null;
    @$dfecha_ent_recib=null;
    @$crif_persona=null;
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
    <form action="../controladores/control_ordenrecibo.php" method="post" id="form1">
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
                $sql="SELECT * FROM facturacion.ttipo_documento WHERE ctipo_transaccion = 'C' 
                AND dfecha_desactivacion IS NULL AND (LOWER(cdescripcion) LIKE '%or%' OR LOWER(cdescripcion) LIKE '%órden de recíbo%' OR LOWER(cdescripcion) LIKE '%recíbo%')
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
            <select name="nnro_orden" id="b_nnro_orden" title="Seleccione una órden de compra" required />
              <option value="0">Seleccione una órden de compra</option>
              <?php
                require_once('../clases/class_bd.php');
                $conexion = new Conexion();
                $sql="SELECT DISTINCT TRIM(oc.nnro_orden) nnro_orden,TRIM(oc.nnro_orden) || '_' || TO_CHAR(oc.dfecha_documento,'DD/MM/YYYY') as orden 
                FROM facturacion.vw_orden_compra_venta oc 
                LEFT JOIN facturacion.vw_orden_entrega_recibo oer on oc.nnro_orden = oer.nnro_orden and oc.cid_articulo = oer.cid_articulo 
                WHERE oc.ctipo_transaccion = 'C' 
                AND oc.cestado_documento = 'CO' 
                GROUP BY 1,2,oc.cid_articulo  
                HAVING MAX(oc.ncantidad_articulo) > SUM(CASE WHEN oer.ncantidad_articulo IS NULL THEN 0 ELSE oer.ncantidad_articulo END)";
                $query=$conexion->Ejecutar($sql);
                while($row=$conexion->Respuesta($query)){
                  if($row['nnro_orden']==$nnro_orden){
                    echo "<option value='".$row['nnro_orden']."' selected>".$row['orden']."</option>";
                  }else{
                    echo "<option value='".$row['nnro_orden']."'>".$row['orden']."</option>";
                  }
                }
              ?>
            </select>
            <input type="hidden" name="dfecha_documento" id="dfecha_documento" value="<?= $dfecha_documento;?>" />
          </td>
        </tr>
        <tr>
          <td>
            <span class="texto_form">Nro. Órden Recíbo</span>
          </td>
          <td>
            <input title="Ingrese el nro. de la órden de recíbo" onKeyPress="return isNumberDocKey(event)" name="nnro_ent_recib" 
            id="nnro_ent_recib" type="text" size="50" value="<?= $nnro_ent_recib;?>" maxlength=11 required />
          </td>
        </tr>
        <tr>
          <td>
            <span class="texto_form">Fecha de Recíbo</span>
          </td>
          <td>
            <input title="Seleccione la fecha de la órden de recíbo" name="dfecha_ent_recib" id="dfecha_ent_recib" type="text" size="50" value="<?= $dfecha_ent_recib;?>" required />
          </td>
        </tr>
        <tr>
          <td>
            <span class="texto_form">Rif Proveedor</span>
          </td>
          <td>
            <input title="Ingrese el rif o cédula del proveedor" onKeyUp="this.value=this.value.toUpperCase()" name="crif_persona" 
            id="crif_persona" type="text" size="50" value="<?= $crif_persona;?>" readonly />
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
            <select name="nid_condicionpago" id="nid_condicionpago" title="Seleccione una condición de pago" readonly />
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
              imprimir_boton($disabledRCOC,$disabledMDOC,$estatusoc,$servicios,"ordenrecibo");
            ?>
            <input onclick="location='../invoice/ordenrd.php?nnro_ent_recib=<?= $nnro_ent_recib;?>&tipo=C'" 
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
  <?php }else{  
  $nnro_ent_recib = $_GET['nnro_ent_recib'];
  $crif_persona = $_GET['crif_persona'];
  ?>
  <script type="text/javascript">
    function reload_tabor(tab){
      nnro_ent_recib = document.getElementById('nnro_ent_recib').value;
      crif_persona = document.getElementById('crif_persona').value;
      location.href="menu_principal.php?ordenrecibo&l&nnro_ent_recib="+nnro_ent_recib+"&crif_persona="+crif_persona+tab;
    }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td>
        <span class="texto_form">Nro. Órden Recíbo</span>
      </td>
      <td>
        <input title="Ingrese el nro. de la órden de recíbo" onKeyUp="this.value=this.value.toUpperCase()" name="nnro_ent_recib" id="nnro_ent_recib" type="text" size="50" value="<?= $nnro_ent_recib;?>" />
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
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabor('#ordenrecibo')">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?ordenrecibo#ordenrecibo" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_ordenrecibo.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=ordenrecibo';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:15%;">Nro. Órden</td>
      <td align='left'>Nro. Órden Recíbo</td>
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
    $clausuleWhere="WHERE d.dfecha_desactivacion IS NULL AND d.ctipo_transaccion = 'C' AND d.nnro_ent_recib IS NOT NULL ";
    if($nnro_ent_recib!="" && $crif_persona!=""){
      $clausuleWhere.="AND nnro_ent_recib LIKE '%$nnro_ent_recib%' AND crif_persona LIKE '%$crif_persona%'";
    }
    else if($nnro_ent_recib!=""){
      $clausuleWhere.="AND nnro_ent_recib LIKE '%$nnro_ent_recib%'";
    }
    else if($crif_persona!=""){
      $clausuleWhere.="AND crif_persona LIKE '%$crif_persona%'";
    }
    //Sentencia sql (sin limit) 
    $_pagi_sql = "SELECT d.nnro_orden,d.nnro_ent_recib,td.cdescripcion tipodocumento, TO_CHAR(d.dfecha_ent_recib,'DD/MM/YYYY') dfecha_documento, 
    p.crif_persona|| ' ' || p.cnombre proveedor, CASE d.cestado_documento WHEN 'CO' THEN 'Completado' WHEN 'CL' THEN 'Cerrado' WHEN 'VO' THEN 'Anulado' ELSE 'Borrador' END estatus,
    SUM(CASE WHEN (dd.ncantidad_articulo*dd.nprecio) IS NULL THEN 0 ELSE (dd.ncantidad_articulo*dd.nprecio) END) monto_base, MAX(d.nmonto_total) monto_total 
    FROM facturacion.tdocumento d 
    LEFT JOIN facturacion.tdetalle_documento dd ON d.nid_documento = dd.nid_documento 
    INNER JOIN facturacion.ttipo_documento td ON d.nid_tipodocumento = td.nid_tipodocumento 
    INNER JOIN general.tpersona p ON d.crif_persona = p.crif_persona 
    $clausuleWhere 
    GROUP BY d.nnro_orden,d.nnro_ent_recib,td.cdescripcion,d.dfecha_ent_recib,p.crif_persona,p.cnombre,d.cestado_documento  
    ORDER BY d.nnro_ent_recib DESC";
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
      echo "<tr style='cursor: pointer;' id='".$row['nnro_ent_recib']."' onclick='enviarFormOR(this.id)'>
        <td style='width:15%;'>".$row['nnro_orden']."</td>
        <td align='left'>".$row['nnro_ent_recib']."</td>
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
  function enviarFormOR(value){
    document.getElementById('nnro_ent_recib_oculto').value=value;
    document.getElementById('form1').submit();
  }
  </script>
  <form id="form1" method="POST" action="../controladores/control_ordenrecibo.php">
    <input type="hidden" name="nnro_ent_recib" id="nnro_ent_recib_oculto" value="" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <div class="pagination">
    <ul>
      <?php echo"<li>".$_pagi_navegacion."</li>";?>
    </ul>
  </div>
  <?php }?>
</div>