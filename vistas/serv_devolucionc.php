<div class="form_externo" >
  <?php
  if(isset($_SESSION['datos']['nnro_devolucion'])){ 
    $disabledRCdevolucionc='disabled';
    $disabledMDdevolucionc='';
    $estatusdevolucionc=null;
  }else {
    $disabledRCdevolucionc='';
    $disabledMDdevolucionc='disabled';
  }
  $servicios='devolucioncliente';
  if(isset($_SESSION['datos'])){
    @$nid_devolucion=$_SESSION['datos']['nid_devolucion'];
    @$nid_documento=$_SESSION['datos']['nid_documento'];
    @$nnro_devolucion=$_SESSION['datos']['nnro_devolucion'];
    @$nid_tipodocumento=$_SESSION['datos']['nid_tipodocumento'];
    @$dfecha_devolucion=$_SESSION['datos']['dfecha_devolucion'];
    @$cestado_devolucion=$_SESSION['datos']['cestado_devolucion'];
    @$caccion_devolucion=$_SESSION['datos']['caccion_devolucion'];
    @$estatusdevolucionc=$_SESSION['datos']['estatus'];
  }
  else{
    @$nid_documento=null;
    @$nnro_devolucion=null;
    @$nid_tipodocumento=null;
    @$dfecha_devolucion=null;
    @$cestado_devolucion="DR";
    @$caccion_devolucion="CO";
    @$estatusdevolucionc=null;
  }
  if(!isset($_GET['l'])){?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_devolucion.php" method="post" id="form1">
      <table border="0" style="width: 100%">
        <input name="nid_devolucion" id="nid_devolucion" type="hidden" value="<?= $nid_devolucion;?>" />
        <tr>
          <td>
            <span class="texto_form">Nro. Órden</span>
          </td>
          <td>
            <input title="Ingrese el nro. de la devolución" onKeyUp="this.value=this.value.toUpperCase()" name="nnro_devolucion" 
            id="nnro_devolucion" type="text" size="50" value="<?= $nnro_devolucion;?>" required />
          </td>
        </tr>
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
                $sql="SELECT nid_tipodocumento,cdescripcion FROM facturacion.ttipo_documento WHERE ctipo_transaccion = 'V' 
AND dfecha_desactivacion IS NULL AND (LOWER(cdescripcion) LIKE '%orden devolucion cliente%')
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
            <span class="texto_form">Nro. Órden de Venta</span>
          </td>
          <td>
            <select name="nid_documento" id="nid_documento" title="Seleccione un Nro. Órden de Venta" required />
              <option value="0">Seleccione un Nro. Órden de Venta</option>
              <?php
                require_once('../clases/class_bd.php');
                $conexion = new Conexion();
                $sql="SELECT nid_documento, TRIM(nnro_orden) nnro_orden, TRIM(nnro_orden) || '_' || TO_CHAR(dfecha_documento,'DD/MM/YYYY') as orden 
                FROM facturacion.tdocumento 
                WHERE ctipo_transaccion = 'V' 
                AND cestado_documento = 'CO' and nnro_ent_recib is not null
                ORDER BY dfecha_documento,orden ASC";
                $query=$conexion->Ejecutar($sql);
                while($row=$conexion->Respuesta($query)){
                  if($row['nid_documento']==$nid_documento){
                    echo "<option value='".$row['nid_documento']."' selected>".$row['orden']."</option>";
                  }else{
                    echo "<option value='".$row['nid_documento']."'>".$row['orden']."</option>";
                  }
                }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <span class="texto_form">Fecha del Documento</span>
          </td>
          <td>
            <input title="Seleccione la fecha de la devolución" name="dfecha_devolucion" id="dfecha_devolucion" type="text" size="50" readonly value="<?= $dfecha_devolucion;?>" required />
          </td>
        </tr>
        <tr>
          <td>
            <span class="texto_form">Estado del Documento</span>
          </td>
          <td>
            <input type="hidden" name="cestado_devolucion" id="cestado_devolucion" value="<?= $cestado_devolucion;?>"/>
            <input title="Estado actual del documento, puede ser Borrador,Completado,Anulado o Cerrado" name="estado_doc" 
            id="estado_doc" type="text" size="50" readonly 
            value="<? if($cestado_devolucion=="DR"){echo "Borrador";}else if($cestado_devolucion=="CO"){echo "Completado";}else if($cestado_devolucion=="VO"){echo "Anulado";}else if($cestado_devolucion=="CL"){echo "Cerrado";}?>" required />
          </td>
        </tr>
        <tr>
          <td>
            <span class="texto_form">Acción del Documento</span>
          </td>
          <td>
            <input type="hidden" name="caccion_devolucion" id="caccion_devolucion" value="<?= $caccion_devolucion;?>"/>
            <input title="Acción que completa el documento" class="btn btn-default" name="accion_completar" id="accion_completar" type="button" value="Completar" <? if($caccion_devolucion=="CL" || $caccion_devolucion=="--"){echo "disabled";} ?> />
            <input title="Acción que cierra el documento" class="btn btn-default" name="accion_cerrar" id="accion_cerrar" type="button" value="Cerrar" <? if($caccion_devolucion=="CO" || $caccion_devolucion=="--"){echo "disabled";} ?> />
            <input title="Acción que anula el documento" class="btn btn-default" name="accion_anular" id="accion_anular" type="button" value="Anular" <? if($caccion_devolucion=="CO" || $caccion_devolucion=="--"){echo "disabled";} ?> />
          </td>
        </tr>
        <?php echo '<tr><td colspan="2" class="'.$estatusdevolucionc.'" id="estatus_registro">'.$estatusdevolucionc.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
            <?php
              imprimir_boton($disabledRCdevolucionc,$disabledMDdevolucionc,$estatusdevolucionc,$servicios,"devolucionc");
            ?>         
          </td>
        </tr>
      </table>    
    </form>
    <div id="Anular" style="display:none;">
      <center>
        <table>
          <tr>
            <td><span class="texto_form">Motivo devolución</span></td>
            <td>
              <select name="nid_motivodevolucion" id="nid_motivodevolucion" title="Seleccione un motivo de la devolución" required />
                <option value="0">Seleccione un motivo de la devolución</option>
                <?php
                  require_once('../clases/class_bd.php');
                  $conexion = new Conexion();
                  $sql="SELECT * FROM facturacion.tmotivo_devolucion WHERE dfecha_desactivacion IS NULL ORDER BY nid_motivodevolucion ASC";
                  $query=$conexion->Ejecutar($sql);
                  while($row=$conexion->Respuesta($query)){
                      echo "<option value='".$row['nid_motivodevolucion']."'>".$row['cdescripcion']."</option>";
                  }
                ?>
              </select>
            </td>
          </tr>
          <tr>
            <td>
            </td>
            <td>
              <input type="button" class="btn btn-default" value="Continuar">
            </td>
          </tr>
        </table>
      </center>
    </div>
  </fieldset>
  <br>
  <?php }else{  
  $nnro_devolucion = $_GET['nnro_devolucion'];
  ?>
  <script type="text/javascript">
    function reload_tabov(tab){
      nnro_devolucion = document.getElementById('nnro_devolucion').value;
      nnro_devolucion = document.getElementById('nnro_devolucion').value;
      location.href="menu_principal.php?devolucioncliente&l&nnro_devolucion="+nnro_devolucion+tab;
    }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td>
        <span class="texto_form">Nro. Órden</span>
      </td>
      <td>
        <input title="Ingrese el nro. de la órden de devolución" onKeyUp="this.value=this.value.toUpperCase()" name="nnro_devolucion" id="nnro_devolucion" type="text" size="50" value="<?= $nnro_devolucion;?>" />
      </td>
    </tr>
  </table>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabov('#devolucionc')">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?ordenventa#ordenventa" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_ordenventa.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=devolucioncliente';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:20%;">Nro. Órden</td>
      <td align='left'>Tipo de Documento</td>
      <td align='left'>Fecha del Documento</td>
    </tr>
    <?php
    //Conexión a la base de datos 
    require_once("../clases/class_bd.php");
    $pgsql=new Conexion();
    $clausuleWhere="WHERE d.dfecha_desactivacion IS NULL ";
    if($nnro_devolucion!=""){
      $clausuleWhere.="AND nnro_devolucion LIKE '%$nnro_devolucion%'";
    }
    //Sentencia sql (sin limit) 
    $_pagi_sql = "SELECT d.nnro_devolucion, td.cdescripcion tipodocumento, TO_CHAR(d.dfecha_devolucion,'DD/MM/YYYY') dfecha_devolucion
    FROM facturacion.tdevolucion d 
    LEFT JOIN facturacion.tdetalle_devolucion dd ON d.nid_devolucion = dd.nid_devolucion 
    INNER JOIN facturacion.ttipo_documento td ON d.nid_tipodocumento = td.nid_tipodocumento 
    $clausuleWhere 
    GROUP BY d.nnro_devolucion,td.cdescripcion,d.dfecha_devolucion
    ORDER BY d.nnro_devolucion DESC";
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
      echo "<tr><td style='width:20%;'>".$row['nnro_orden']."</td>
        <td align='left'>".$row['tipodocumento']."</td>
        <td align='left'>".$row['dfecha_devolucion']."</td>
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