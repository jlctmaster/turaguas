<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#notarecepcion" data-toggle="tab" id="tab-notarecepcion">Nota de Recepción</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_notarecepcion.js"> </script>
    <div class="tab-pane active in" id="notarecepcion">
      <div class="form_externo" >
        <?php
          if(isset($_SESSION['datos']['nnro_recepcion'])){ 
            $disabledRC='disabled';
            $disabledMD='';
            $estatus=null;
          }else {
            $disabledRC='';
            $disabledMD='disabled';
          }
          $servicios='notarecepcion';
          if(isset($_SESSION['datos'])){
            @$nid_documentocompra=$_SESSION['datos']['nid_documentocompra'];
            @$nnro_solicitud=$_SESSION['datos']['nnro_solicitud'];
            @$dfecha_documento=$_SESSION['datos']['dfecha_documento'];
            @$nnro_factura=$_SESSION['datos']['nnro_factura'];
            @$nnro_recepcion=$_SESSION['datos']['nnro_recepcion'];
            @$dfecha_recepcion=$_SESSION['datos']['dfecha_recepcion'];
            @$crif_persona=$_SESSION['datos']['crif_persona'];
            @$cnombreproveedor=$_SESSION['datos']['cnombreproveedor'];
            @$estatus=$_SESSION['datos']['estatus'];
          }
          else{
            @$nid_documentocompra=null;
            @$nnro_solicitud=null;
            @$dfecha_documento=null;
            @$nnro_factura=null;
            @$nnro_recepcion=null;
            @$dfecha_recepcion=null;
            @$crif_persona=null;
            @$cnombreproveedor=null;
            @$estatus=null;
          }
          if(!isset($_GET['l'])){ 
        ?>
        <fieldset style="padding: 30px">
          <form action="../controladores/control_notarecepcion.php" method="post" id="form">
            <table border="0" style="width: 100%">
              <tr>
                <td>
                  <span class="texto_form">Nro. Solicitud</span>
                </td>
                <td>
                  <input type="hidden" name="numero_solicitud" id="numero_solicitud" value="<?= $nnro_solicitud;?>" readonly />
                  <select name="nnro_solicitud" id="nnro_solicitud" title="Seleccione una solicitud de compra" required />
                    <option value="0">Seleccione una solicitud de compra</option>
                    <?php
                      require_once('../clases/class_bd.php');
                      $conexion = new Conexion();
                      $sql="SELECT DISTINCT TRIM(sc.nnro_solicitud) nnro_solicitud 
                      FROM facturacion.vw_solicitudcompra sc 
                      LEFT JOIN facturacion.vw_recepcion r ON sc.nnro_solicitud = r.nnro_solicitud AND sc.cid_articulo = r.cid_articulo 
                      GROUP BY sc.nnro_solicitud,sc.cid_articulo 
                      HAVING MAX(sc.ncantidad_articulo) > SUM(CASE WHEN r.ncantidad_articulo IS NULL THEN 0 ELSE r.ncantidad_articulo END) 
                      ORDER BY nnro_solicitud ASC";
                      $query=$conexion->Ejecutar($sql);
                      while($row=$conexion->Respuesta($query)){
                        if($row['nnro_solicitud']==$nnro_solicitud){
                          echo "<option value='".$row['nnro_solicitud']."' selected>".$row['nnro_solicitud']."</option>";
                        }else{
                          echo "<option value='".$row['nnro_solicitud']."'>".$row['nnro_solicitud']."</option>";
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="dfecha_documento" id="dfecha_documento_sc" value="<?= $dfecha_documento;?>" />
                </td>
              </tr>
              <tr>
                <td><span class="texto_form">Nro. Factura</span></td>
                <td>
                  <input onKeyPress="return isNumberDocKey(event)" title="Ingrese el número de la factura" name="nnro_factura" id="nnro_factura" type="text" maxlength="10" value="<?= $nnro_factura;?>" required />
                </td>
              </tr>
              <tr>
                <td><span class="texto_form">Nro. Recepción</span></td>
                <td>
                  <input type="hidden" name="nid_documentocompra" id="nid_documentocompra" value="<?= $nid_documentocompra;?>" />
                  <?php 
                    require_once('../clases/class_bd.php');
                    $conexion = new Conexion();
                    $sql="SELECT nid_tipodocumento,cdescripcion FROM facturacion.ttipo_documento WHERE ctipo_transaccion = 'C' 
                         AND dfecha_desactivacion IS NULL AND (LOWER(cdescripcion) LIKE '%(nr)%' OR LOWER(cdescripcion) LIKE '%nota de recepción%' OR LOWER(cdescripcion) LIKE '%recepción%')
                         ORDER BY nid_tipodocumento ASC";
                    $query=$conexion->Ejecutar($sql);
                    while($row=$conexion->Respuesta($query)){
                      echo "<input type='hidden' id='nid_tipodocumento' name='nid_tipodocumento' value='".$row['nid_tipodocumento']."'/>";
                    }
                  ?>
                  <input onKeyPress="return isNumberDocKey(event)" title="El número de la recepcion es generada por el sistema" name="nnro_recepcion" id="nnro_recepcion" type="text" maxlength="10" value="<?= $nnro_recepcion;?>" />
                </td>
              </tr>
              <tr>
                <td>
                  <span class="texto_form">Fecha de Recepción</span>
                </td>
                <td>
                  <input title="Seleccione la fecha de la nota de recepción" name="dfecha_recepcion" id="dfecha_recepcion_entrega" type="text" size="50" readonly value="<?= $dfecha_recepcion;?>" required />
                </td>
              </tr>
              <tr>
                <td>
                  <span class="texto_form">RIF Proveedor</span>
                </td>
                <td>
                  <input title="Ingrese el rif del proveedor" onKeyUp="this.value=this.value.toUpperCase()" name="crif_persona" 
                  id="crif_persona" type="text" size="50" value="<?= $crif_persona;?>" />
                </td>
              </tr>
              <tr>
                <td>
                  <span class="texto_form">Razón Social</span>
                </td>
                <td>
                  <input title="Nombre del proveedor" name="cnombreproveedor" id="cnombreproveedor" type="text" size="50" value="<?= $cnombreproveedor;?>" readonly />
                </td>
              </tr>
            </table>
            <br/>
            <div class="table-responsive">
              <table id='TablaArticulos' class="table table-bordered table-striped">
                <tr>
                  <td><center><span class="texto_tabla">Insumo</span></center></td>
                  <td><center><span class="texto_tabla">Cantidad</span></center></td>
                </tr>
                <?php
                  $pgsql=new Conexion();
                  $sql = "SELECT ddc.nlinea,TRIM(ddc.cid_articulo) cid_articulo, ddc.ncantidad_articulo 
                  FROM facturacion.tdocumentocompra dc 
                  INNER JOIN facturacion.tdetalle_documentocompra ddc ON dc.nid_documentocompra = ddc.nid_documentocompra 
                  WHERE dc.nnro_recepcion = '$nnro_recepcion' 
                  ORDER BY ddc.nlinea ASC";
                  $query = $pgsql->Ejecutar($sql);
                  $con=0;
                    while ($row = $pgsql->Respuesta($query)){
                      echo "<tr id='".$con."'>
                              <td>
                              <center>
                                <input type='hidden' name='linea[]' id='linea_".$con."' value='".$row['nlinea']."' />
                                <select name='articulo[]' id='articulo_".$con."' title='Seleccione un artículo' >
                                <option value='0'>Seleccione un artículo</option>";
                                $sqlx = "SELECT TRIM(cid_articulo) cid_articulo,cdescripcion 
                                FROM inventario.tarticulo 
                                WHERE dfecha_desactivacion IS NULL AND nid_tipoarticulo = (SELECT nid_tipoarticulo 
                                FROM inventario.ttipo_articulo WHERE LOWER(cdescripcion) LIKE '%insumo%')
                                ORDER BY cid_articulo ASC";
                                $querys = $pgsql->Ejecutar($sqlx);
                                while ($rows = $pgsql->Respuesta($querys)){
                                  if($rows['cid_articulo']==$row['cid_articulo']){
                                    echo "<option value='".$rows['cid_articulo']."' selected>".$rows['cdescripcion']."</option>";
                                  }else{
                                    echo "<option value='".$rows['cid_articulo']."'>".$rows['cdescripcion']."</option>";
                                  }
                                }
                                echo "</select>
                                </center>
                              </td>
                              <td>
                              <center>
                                <input type='hidden' name='cantidad_vieja[]' id='cantidad_vieja_".$con."' value='".$row['ncantidad_articulo']."' />
                                <input class='campo_tabla' type='text' onKeyPress='return isNumberKey(event)' name='cantidad[]' id='cantidad_".$con."' size='50' value='".$row['ncantidad_articulo']."' />
                             </center>
                              </td>
                            </tr>";
                      $con++;
                    }
                ?>
              </table>
            </div>
            <table>
              <?php echo '<tr><td colspan="2" class="'.$estatus.'" id="estatus_registro">'.$estatus.'</td></tr>'; ?>
              <tr>
                <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                  <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                  <?php
                    imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"notarecepcion");
                  ?>
                  <input onclick="location='../invoice/notarecepcion.php?nnro_recepcion=<?= $nnro_recepcion;?>&nameuser=<?= $_SESSION['fullname_user'];?>'" 
                  type="button" name="btimprimir" id="8" value="Imprimir Documento" class="btn btn-default" 
                  <? if($nnro_recepcion==null){ echo "disabled";}?> />
                </td>
              </tr>
            </table>
          </form>
        </fieldset>
        <br>
        <?php }else{  
          $nnro_recepcion = $_GET['nnro_recepcion'];
          $nnro_solicitud = $_GET['nnro_solicitud'];
          ?>
          <script type="text/javascript">
            function reload_tabnr(tab){
              nnro_recepcion = document.getElementById('nnro_recepcion').value;
              nnro_solicitud = document.getElementById('nnro_solicitud').value;
              location.href="menu_principal.php?notarecepcion&l&nnro_recepcion="+nnro_recepcion+"&nnro_solicitud="+nnro_solicitud+tab;
            }
          </script>
          <table border="0" style="width: 100%"> 
            <tr>
              <td>
                <span class="texto_form">Nro. Solicitud</span>
              </td>
              <td>
                <span class="texto_form">Nro. Recepción</span>
              </td>
            </tr>
            <tr> 
              <td>
                <input title="Ingrese el nro. de la solicitud de compra" onKeyUp="this.value=this.value.toUpperCase()" name="nnro_solicitud" id="nnro_solicitud" type="text" size="50" value="<?= $nnro_solicitud;?>" />
              </td>
              <td>
                <input title="Ingrese el nro. de la nota de recepción" name="nnro_recepcion" id="nnro_recepcion" type="text" size="50" value="<?= $nnro_recepcion;?>" required />
              </td>
            </tr>
          </table>
          <table align="center">  
            <tr>
              <td>
                <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabnr('#notarecepcion')">
                <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
              </td>
            </tr>
          </table> 
          <a href="?notarecepcion#notarecepcion" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
          <a href="../excel/excel_notarecepcion.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
          <a href="<?php echo  '../pdf/?serv=notarecepcion';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
          <table style="width:100%;" class="tablapaginacion">
            <tr style="background: #000; color:#FFF; width:100%;"> 
              <td style="width:20%;">Nro. Solicitud</td>
              <td align='left'>Fecha Solicitud</td>
              <td align='left'>Nro. Recepción</td>
              <td align='left'>Fecha Recepción</td>
              <td align='left'>Cant. Artículos</td>
            </tr>
            <?php
            //Conexión a la base de datos 
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            $clausuleWhere="";
            if($nnro_recepcion!="" && $crif_persona!=""){
              $clausuleWhere.="WHERE nnro_recepcion LIKE '%$nnro_recepcion%' AND nnro_solicitud LIKE '%$nnro_solicitud%'";
            }
            else if($nnro_recepcion!=""){
              $clausuleWhere.="WHERE nnro_recepcion LIKE '%$nnro_recepcion%'";
            }
            else if($nnro_solicitud!=""){
              $clausuleWhere.="WHERE nnro_solicitud LIKE '%$nnro_solicitud%'";
            }
            //Sentencia sql (sin limit) 
            $_pagi_sql = "SELECT TRIM(nnro_solicitud) nnro_solicitud, TO_CHAR(dfecha_documento,'DD/MM/YYYY') dfecha_documento, 
            TRIM(nnro_recepcion) nnro_recepcion, TO_CHAR(dfecha_recepcion,'DD/MM/YYYY') dfecha_recepcion,
            COUNT(cid_articulo) cantidad 
            FROM facturacion.vw_recepcion
            $clausuleWhere 
            GROUP BY nnro_solicitud,dfecha_documento,nnro_recepcion,dfecha_recepcion 
            ORDER BY nnro_solicitud,nnro_recepcion DESC";
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
              echo "<tr style='cursor: pointer;' id='".$row['nnro_recepcion']."' onclick='enviarForm(this.id)'>
                <td style='width:20%;'>".$row['nnro_solicitud']."</td>
                <td align='left'>".$row['dfecha_documento']."</td>
                <td align='left'>".$row['nnro_recepcion']."</td>
                <td align='left'>".$row['dfecha_recepcion']."</td>
                <td align='left'>".$row['cantidad']."</td>
                </tr>"; 
            } 
            //Incluimos la barra de navegación 
            ?>
          </table>
          <script type="text/javascript">
          function enviarForm(value){
            document.getElementById('nnro_recepcion_oculto').value=value;
            document.getElementById('form').submit();
          }
          </script>
          <form id="form" method="POST" action="../controladores/control_notarecepcion.php">
            <input type="hidden" name="nnro_recepcion" id="nnro_recepcion_oculto" value="" />
            <input type="hidden" name="operacion" id="operacion" value="Consultar" />
          </form>
          <div class="pagination">
            <ul>
              <?php echo"<li>".$_pagi_navegacion."</li>";?>
            </ul>
          </div>
          <?php }?>
      </div>
    </div>
  </div>
</div>