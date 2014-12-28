<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#reembolsocliente" data-toggle="tab" id="tab-reembolsocliente">Reembolso a Cliente</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_reembolsocliente.js"> </script>
    <div class="tab-pane active in" id="reembolsocliente">
      <div class="form_externo" >
        <?php
          if(isset($_SESSION['datos']['nnro_reembolso'])){ 
            $disabledRC='disabled';
            $disabledMD='';
            $estatus=null;
          }else {
            $disabledRC='';
            $disabledMD='disabled';
          }
          $servicios='reembolsocliente';
          if(isset($_SESSION['datos'])){
            @$nid_reembolso=$_SESSION['datos']['nid_reembolso'];
            @$nnro_reembolso=$_SESSION['datos']['nnro_reembolso'];
            @$dfecha_documento=$_SESSION['datos']['dfecha_documento'];
            @$nid_devolucion=$_SESSION['datos']['nid_devolucion'];
            @$nnro_devolucion=$_SESSION['datos']['nnro_devolucion'];
            @$dfecha_devolucion=$_SESSION['datos']['dfecha_devolucion'];
            @$crif_persona=$_SESSION['datos']['crif_persona'];
            @$cnombrecliente=$_SESSION['datos']['cnombrecliente'];
            @$estatus=$_SESSION['datos']['estatus'];
          }
          else{
            @$nid_reembolso=null;
            @$nnro_reembolso=null;
            @$dfecha_documento=null;
            @$nid_devolucion=null;
            @$nnro_devolucion=null;
            @$dfecha_devolucion=null;
            @$crif_persona=null;
            @$cnombrecliente=null;
            @$estatus=null;
          }
          if(!isset($_GET['l'])){ 
        ?>
        <fieldset style="padding: 30px">
          <form action="../controladores/control_reembolsocliente.php" method="post" id="form">
            <table border="0" style="width: 100%">
              <tr>
                <td>
                  <span class="texto_form">Nro. Devolución</span>
                </td>
                <td>
                  <input type="hidden" name="nid_devolucion" id="nid_devolucion" value="<?= $nid_devolucion;?>" />
                  <input type="hidden" name="numero_devolucion" id="numero_devolucion" value="<?= $nnro_devolucion;?>" readonly >
                  <select name="nnro_devolucion" id="nnro_devolucion" title="Seleccione una devolución de venta" required />
                    <option value="0">Seleccione una devolución de venta</option>
                    <?php
                      require_once('../clases/class_bd.php');
                      $conexion = new Conexion();
                      $sql="SELECT DISTINCT TRIM(sc.nnro_devolucion) nnro_devolucion 
                      FROM facturacion.vw_devolucion_cliente sc 
                      LEFT JOIN facturacion.vw_reembolso_cliente r ON sc.nid_devolucion = r.nid_devolucion AND sc.cid_articulo = r.cid_articulo 
                      GROUP BY sc.nnro_devolucion,sc.cid_articulo 
                      HAVING MAX(sc.ncantidad_articulo) > SUM(CASE WHEN r.ncantidad_articulo IS NULL THEN 0 ELSE r.ncantidad_articulo END) 
                      ORDER BY nnro_devolucion ASC";
                      $query=$conexion->Ejecutar($sql);
                      while($row=$conexion->Respuesta($query)){
                        if($row['nnro_devolucion']==$nnro_devolucion){
                          echo "<option value='".$row['nnro_devolucion']."' selected>".$row['nnro_devolucion']."</option>";
                        }else{
                          echo "<option value='".$row['nnro_devolucion']."'>".$row['nnro_devolucion']."</option>";
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="dfecha_devolucion" id="dfecha_documento_sc" value="<?= $dfecha_devolucion;?>" />
                </td>
              </tr>
              <tr>
                <td><span class="texto_form">Nro. Entrega por Reembolso</span></td>
                <td>
                  <input type="hidden" name="nid_reembolso" id="nid_reembolso" value="<?= $nid_reembolso;?>" />
                  <?php 
                    require_once('../clases/class_bd.php');
                    $conexion = new Conexion();
                    $sql="SELECT nid_tipodocumento,cdescripcion FROM facturacion.ttipo_documento WHERE ctipo_transaccion = 'V' 
                         AND dfecha_desactivacion IS NULL AND LOWER(cdescripcion) LIKE '%nrc%' 
                         ORDER BY nid_tipodocumento ASC";
                    $query=$conexion->Ejecutar($sql);
                    while($row=$conexion->Respuesta($query)){
                      echo "<input type='hidden' id='nid_tipodocumento' name='nid_tipodocumento' value='".$row['nid_tipodocumento']."'/>";
                    }
                  ?>
                  <input onKeyPress="return isNumberDocKey(event)" title="El número del reembolso es generado por el sistema" name="nnro_reembolso" id="nnro_reembolso" type="text" maxlength="10" value="<?= $nnro_reembolso;?>" />
                </td>
              </tr>
              <tr>
                <td>
                  <span class="texto_form">Fecha de Entrega</span>
                </td>
                <td>
                  <input title="Seleccione la fecha de la nota de recepción" name="dfecha_documento" id="dfecha_documento" type="text" size="50" readonly value="<?= $dfecha_documento;?>" required />
                </td>
              </tr>
              <tr>
                <td>
                  <span class="texto_form">RIF Cliente</span>
                </td>
                <td>
                  <input title="Ingrese el rif del cliente" onKeyUp="this.value=this.value.toUpperCase()" name="crif_persona" 
                  id="crif_persona" type="text" size="50" value="<?= $crif_persona;?>" readonly />
                </td>
              </tr>
              <tr>
                <td>
                  <span class="texto_form">Razón Social</span>
                </td>
                <td>
                  <input title="Nombre del cliente" name="cnombrecliente" id="cnombrecliente" type="text" size="50" value="<?= $cnombrecliente;?>" readonly />
                </td>
              </tr>
            </table>
            <br/>
            <div class="table-responsive">
              <table id='TablaArticulos' class="table table-bordered table-striped">
                <tr>
                  <td><center><span class="texto_tabla">Artículo</span></center></td>
                  <td><center><span class="texto_tabla">Cantidad</span></center></td>
                </tr>
                <?php
                  $pgsql=new Conexion();
                  $sql = "SELECT ddc.nlinea,TRIM(ddc.cid_articulo) cid_articulo, ddc.ncantidad_articulo 
                  FROM facturacion.treembolso dc 
                  INNER JOIN facturacion.tdetalle_reembolso ddc ON dc.nid_reembolso = ddc.nid_reembolso 
                  WHERE dc.nnro_reembolso = '$nnro_reembolso' AND ctipo_transaccion = 'V'
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
                                FROM inventario.ttipo_articulo WHERE LOWER(cdescripcion) LIKE '%terminado%')
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
                    imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"reembolsocliente");
                  ?>
                  <input onclick="location='../invoice/reembolsocliente.php?nnro_reembolso=<?= $nnro_reembolso;?>&nameuser=<?= $_SESSION['fullname_user'];?>'" 
                  type="button" name="btimprimir" id="8" value="Imprimir Documento" class="btn btn-default" 
                  <? if($nnro_reembolso==null){ echo "disabled";}?> />
                </td>
              </tr>
            </table>
          </form>
        </fieldset>
        <br>
        <?php }else{  
          $nnro_reembolso = $_GET['nnro_reembolso'];
          $nnro_devolucion = $_GET['nnro_devolucion'];
          ?>
          <script type="text/javascript">
            function reload_tabnrc(tab){
              nnro_reembolso = document.getElementById('nnro_reembolso').value;
              nnro_devolucion = document.getElementById('nnro_devolucion').value;
              location.href="menu_principal.php?reembolsocliente&l&nnro_reembolso="+nnro_reembolso+"&nnro_devolucion="+nnro_devolucion+tab;
            }
          </script>
          <table border="0" style="width: 100%"> 
            <tr>
              <td>
                <span class="texto_form">Nro. Reembolso</span>
              </td>
              <td>
                <input title="Ingrese el nro. de la nota de reembolso" name="nnro_reembolso" id="nnro_reembolso" type="text" size="50" value="<?= $nnro_reembolso;?>" required />
              </td>
              <td>
                <span class="texto_form">Nro. Devolución</span>
              </td>
              <td>
                <input title="Ingrese el nro. de la devolución de compra" onKeyUp="this.value=this.value.toUpperCase()" name="nnro_devolucion" id="nnro_devolucion" type="text" size="50" value="<?= $nnro_devolucion;?>" />
              </td>
            </tr>
          </table>
          <table align="center">  
            <tr>
              <td>
                <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabnrc('#reembolsocliente')">
                <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
              </td>
            </tr>
          </table> 
          <a href="?reembolsocliente#reembolsocliente" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
          <a href="../excel/excel_reembolsocliente.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
          <a href="<?php echo  '../pdf/?serv=reembolsocliente';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
          <table style="width:100%;" class="tablapaginacion">
            <tr style="background: #000; color:#FFF; width:100%;"> 
              <td style="width:20%;">Nro. Reembolso</td>
              <td align='left'>Fecha Reembolso</td>
              <td align='left'>Nro. Devolución</td>
              <td align='left'>Fecha Devolución</td>
              <td align='left'>Cant. Artículos</td>
            </tr>
            <?php
            //Conexión a la base de datos 
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            $clausuleWhere="";
            if($nnro_reembolso!="" && $crif_persona!=""){
              $clausuleWhere.="WHERE nnro_reembolso LIKE '%$nnro_reembolso%' AND nnro_devolucion LIKE '%$nnro_devolucion%'";
            }
            else if($nnro_reembolso!=""){
              $clausuleWhere.="WHERE nnro_reembolso LIKE '%$nnro_reembolso%'";
            }
            else if($nnro_devolucion!=""){
              $clausuleWhere.="WHERE nnro_devolucion LIKE '%$nnro_devolucion%'";
            }
            //Sentencia sql (sin limit) 
            $_pagi_sql = "SELECT TRIM(dp.nnro_devolucion) nnro_devolucion, TO_CHAR(dp.dfecha_devolucion,'DD/MM/YYYY') dfecha_devolucion, 
            TRIM(rp.nnro_reembolso) nnro_reembolso, TO_CHAR(rp.dfecha_documento,'DD/MM/YYYY') dfecha_documento,
            COUNT(rp.cid_articulo) cantidad 
            FROM facturacion.vw_reembolso_cliente rp 
            INNER JOIN facturacion.vw_devolucion_cliente dp ON rp.nid_devolucion = dp.nid_devolucion 
          
            GROUP BY dp.nnro_devolucion,dp.dfecha_devolucion,rp.nnro_reembolso,rp.dfecha_documento 
            ORDER BY rp.nnro_reembolso,dp.nnro_devolucion DESC";
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
              echo "<tr style='cursor: pointer;' id='".$row['nnro_reembolso']."' onclick='enviarForm(this.id)'>
                <td style='width:20%;'>".$row['nnro_reembolso']."</td>
                <td align='left'>".$row['dfecha_documento']."</td>
                <td align='left'>".$row['nnro_devolucion']."</td>
                <td align='left'>".$row['dfecha_devolucion']."</td>
                <td align='left'>".$row['cantidad']."</td>
                </tr>"; 
            } 
            //Incluimos la barra de navegación 
            ?>
          </table>
          <script type="text/javascript">
          function enviarForm(value){
            document.getElementById('nnro_reembolso_oculto').value=value;
            document.getElementById('form').submit();
          }
          </script>
          <form id="form" method="POST" action="../controladores/control_reembolsocliente.php">
            <input type="hidden" name="nnro_reembolso" id="nnro_reembolso_oculto" value="" />
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