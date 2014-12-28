<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#notadevolucionproveedor" data-toggle="tab" id="tab-notadevolucionproveedor">Nota de Devolución Proveedor</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_notadevolucionproveedor.js"> </script>
    <div class="tab-pane active in" id="notadevolucionproveedor">
      <div class="form_externo" >
        <?php
          if(isset($_SESSION['datos']['nnro_devolucion'])){ 
            $disabledRC='disabled';
            $disabledMD='';
            $estatus=null;
          }else {
            $disabledRC='';
            $disabledMD='disabled';
          }
          $servicios='notadevolucionproveedor';
          if(isset($_SESSION['datos'])){
            @$nid_devolucion=$_SESSION['datos']['nid_devolucion'];
            @$nnro_devolucion=$_SESSION['datos']['nnro_devolucion'];
            @$dfecha_devolucion=$_SESSION['datos']['dfecha_devolucion'];
            @$nid_documentocompra=$_SESSION['datos']['nid_documentocompra'];
            @$nnro_recepcion=$_SESSION['datos']['nnro_recepcion'];
            @$dfecha_documento=$_SESSION['datos']['dfecha_documento'];
            @$estatus=$_SESSION['datos']['estatus'];
          }
          else{
            @$nid_devolucion=null;
            @$nnro_devolucion=null;
            @$dfecha_devolucion=null;
            @$nid_documentocompra=null;
            @$nnro_recepcion=null;
            @$dfecha_documento=null;
            @$estatus=null;
          }
          if(!isset($_GET['l'])){ 
        ?>
        <script type="text/javascript">
        $(document).ready(init);
        function init(){
          //Buscar los datos del nro de orden seleccionado.
          $('#nnro_recepcion').change(function(){
            Datos = {"operacion":"BuscarDatosNroRecepcion","nnro_recepcion": $('#nnro_recepcion').val()};
            BuscarDatosNroRecepcion(Datos);
          })
          //Busca los datos del número de recepcion seleccionado.
          function BuscarDatosNroRecepcion(value){
            $.ajax({
              url: '../controladores/control_notadevolucionproveedor.php',
              type: 'POST',
              async: true,
              data: value,
              dataType: "json",
              success: function(resp){
                $('#nid_documentocompra').val(resp[0].nid_documentocompra);
                $('#dfecha_documento_sc').val(resp[0].dfecha_documento);
                $("#dfecha_devolucion").datepicker("option", "minDate", resp[0].dfecha_documento);
                for(var contador=0;contador<99;contador++){
                  $('tr[id="'+contador+'"]').remove();
                }
                for(var contador=0;contador<resp.length;contador++){
                  $("#TablaArticulos").append("<tr id='"+contador+"'>"+
                  "<td>"+
                  "<center>"+
                  "<input type='hidden' name='linea[]' id='linea_"+contador+"' value='"+resp[contador].nlinea+"' />"+
                  "<input type='hidden' name='articulo[]' id='articulo_"+contador+"' value='"+resp[contador].cid_articulo+"' />"+
                  "<input type='text' name='descrip_articulo[]' id='descrip_articulo_"+contador+"' value='"+resp[contador].articulo+"' readonly />"+
                  "</center>"+
                  "</td>"+
                  "<td>"+
                  "<center>"+
                  "<input type='hidden' name='cantidad_vieja[]' id='cantidad_vieja_"+contador+"' value='"+resp[contador].ncantidad_articulo+"' />"+
                  "<input class='campo_tabla' type='text' onKeyPress='return isNumberKey(event)' name='cantidad[]' id='cantidad_"+contador+"' size='50' value='"+resp[contador].ncantidad_articulo+"' />"+
                  "</center>"+
                  "</td>"+
                  "<td>"+
                  "<center>"+
                  "<select name='motivodevolucion[]' id='motivodevolucion_"+contador+"' title='Seleccione un motivo de la devolución'>"+
                  "<option value='0'>Seleccione un motivo de la devolución</option>"+
                  <?php
                  require_once("../clases/class_bd.php");
                  $pgsql=new Conexion();
                  $sql = "SELECT nid_motivodevolucion as motivodevolucion,cdescripcion 
                  FROM facturacion.tmotivo_devolucion WHERE dfecha_desactivacion IS NULL AND nid_motivodevolucion_padre IS NOT NULL 
                  ORDER BY nid_motivodevolucion ASC";
                  $query = $pgsql->Ejecutar($sql);
                  $comillasimple=chr(34);
                  while ($rows = $pgsql->Respuesta($query)){
                    echo $comillasimple."<option value='".$rows['motivodevolucion']."'>".$rows['cdescripcion']."</option>".$comillasimple."+";
                  }
                  ?>
                  "</select>"+
                  "</center>"+
                  "</td>"+
                  "</tr>");
                }
              },
              error: function(resp){
                alert('Error al procesar la petición')
              }
            });
          }
        }
        </script>
        <fieldset style="padding: 30px">
          <form action="../controladores/control_notadevolucionproveedor.php" method="post" id="form">
            <table border="0" style="width: 100%">
              <tr>
                <td>
                  <span class="texto_form">Nro. Recepción</span>
                </td>
                <td>
                  <input type="hidden" name="nid_documentocompra" id="nid_documentocompra" value="<?= $nid_documentocompra;?>">
                  <input type="hidden" name="numero_recepcion" id="numero_recepcion" value="<?= $nnro_recepcion;?>">
                  <select name="nnro_recepcion" id="nnro_recepcion" title="Seleccione una recepción de compra" required />
                    <option value="0">Seleccione una recepcion de compra</option>
                    <?php
                      require_once('../clases/class_bd.php');
                      $conexion = new Conexion();
                      $sql="SELECT DISTINCT TRIM(r.nnro_recepcion) nnro_recepcion 
                      FROM facturacion.vw_recepcion r 
                      LEFT JOIN facturacion.vw_devolucion_proveedor dp ON r.nid_documentocompra = dp.nid_documentocompra AND r.cid_articulo = dp.cid_articulo 
                      GROUP BY r.nnro_recepcion,r.cid_articulo 
                      HAVING MAX(r.ncantidad_articulo) > SUM(CASE WHEN dp.ncantidad_articulo IS NULL THEN 0 ELSE dp.ncantidad_articulo END) 
                      ORDER BY nnro_recepcion ASC";
                      $query=$conexion->Ejecutar($sql);
                      while($row=$conexion->Respuesta($query)){
                        if($row['nnro_recepcion']==$nnro_recepcion){
                          echo "<option value='".$row['nnro_recepcion']."' selected>".$row['nnro_recepcion']."</option>";
                        }else{
                          echo "<option value='".$row['nnro_recepcion']."'>".$row['nnro_recepcion']."</option>";
                        }
                      }
                    ?>
                  </select>
                  <input type="hidden" name="dfecha_documento" id="dfecha_documento_sc" value="<?= $dfecha_documento;?>" />
                </td>
              </tr>
              <tr>
                <td><span class="texto_form">Nro. Devolución</span></td>
                <td>
                  <input type="hidden" name="nid_devolucion" id="nid_devolucion" value="<?= $nid_devolucion;?>" />
                  <?php 
                    require_once('../clases/class_bd.php');
                    $conexion = new Conexion();
                    $sql="SELECT nid_tipodocumento,cdescripcion FROM facturacion.ttipo_documento WHERE ctipo_transaccion = 'C' 
                         AND dfecha_desactivacion IS NULL AND LOWER(cdescripcion) LIKE '%ndp%'
                         ORDER BY nid_tipodocumento ASC";
                    $query=$conexion->Ejecutar($sql);
                    while($row=$conexion->Respuesta($query)){
                      echo "<input type='hidden' id='nid_tipodocumento' name='nid_tipodocumento' value='".$row['nid_tipodocumento']."'/>";
                    }
                  ?>
                  <input onKeyPress="return isNumberDocKey(event)" title="El número de la devolución es generada por el sistema" name="nnro_devolucion" id="nnro_devolucion" type="text" maxlength="10" value="<?= $nnro_devolucion;?>" />
                </td>
              </tr>
              <tr>
                <td>
                  <span class="texto_form">Fecha de Devolución</span>
                </td>
                <td>
                  <input title="Seleccione la fecha de la nota de devolución" name="dfecha_devolucion" id="dfecha_devolucion" type="text" size="50" readonly value="<?= $dfecha_devolucion;?>" required />
                </td>
              </tr>
            </table>
            <br/>
            <div class="table-responsive">
              <table id='TablaArticulos' class="table table-bordered table-striped">
                <tr>
                  <td><center><span class="texto_tabla">Artículo</span></center></td>
                  <td><center><span class="texto_tabla">Cantidad</span></center></td>
                  <td><center><span class="texto_tabla">Motivo Devolución</span></center></td>
                </tr>
                <?php
                  $pgsql=new Conexion();
                  $sql = "SELECT dp.nlinea,TRIM(dp.cid_articulo) cid_articulo,a.cdescripcion articulo, dp.ncantidad_articulo,dp.nid_motivodevolucion
                  FROM facturacion.vw_devolucion_proveedor dp 
                  INNER JOIN inventario.tarticulo a ON dp.cid_articulo = a.cid_articulo 
                  WHERE dp.nnro_devolucion = '$nnro_devolucion'";
                  $query = $pgsql->Ejecutar($sql);
                  $con=0;
                    while ($row = $pgsql->Respuesta($query)){
                      echo "<tr id='".$con."'>
                              <td>
                                <input type='hidden' name='linea[]' id='linea_".$con."' value='".$row['nlinea']."' />
                                <input type='hidden' name='articulo[]' id='articulo_".$con."' value='".$row['cid_articulo']."' />
                                <input type='text' name='descrip_articulo[]' id='descrip_articulo_".$con."' value='".$row['articulo']."' readonly />
                              </td>
                              <td>
                                <input type='hidden' name='cantidad_vieja[]' id='cantidad_vieja_".$con."' value='".$row['ncantidad_articulo']."' />
                                <input class='campo_tabla' type='text' onKeyPress='return isNumberKey(event)' name='cantidad[]' id='cantidad_".$con."' size='50' value='".$row['ncantidad_articulo']."' />
                              </td>
                              <td>
                                <select name='motivodevolucion[]' id='motivodevolucion_".$con."' title='Seleccione el motivo de la devolución' >
                                <option value='0'>Seleccione el motivo de la devolución</option>";
                                $sqlx = "SELECT nid_motivodevolucion as motivodevolucion,cdescripcion 
                                FROM facturacion.tmotivo_devolucion 
                                WHERE dfecha_desactivacion IS NULL 
                                ORDER BY nid_motivodevolucion ASC";
                                $querys = $pgsql->Ejecutar($sqlx);
                                while ($rows = $pgsql->Respuesta($querys)){
                                  if($rows['motivodevolucion']==$row['nid_motivodevolucion']){
                                    echo "<option value='".$rows['motivodevolucion']."' selected>".$rows['cdescripcion']."</option>";
                                  }else{
                                    echo "<option value='".$rows['motivodevolucion']."'>".$rows['cdescripcion']."</option>";
                                  }
                                }
                                echo "</select>
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
                    imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"notadevolucionproveedor");
                  ?>
                  <input onclick="location='../invoice/notadevolucionproveedor.php?nnro_devolucion=<?= $nnro_devolucion;?>&nameuser=<?= $_SESSION['fullname_user'];?>'" 
                  type="button" name="btimprimir" id="8" value="Imprimir Documento" class="btn btn-default" 
                  <? if($nnro_devolucion==null){ echo "disabled";}?> />
                </td>
              </tr>
            </table>
          </form>
        </fieldset>
        <br>
        <?php }else{  
          $nnro_devolucion = $_GET['nnro_devolucion'];
          $nnro_recepcion = $_GET['nnro_recepcion'];
          ?>
          <script type="text/javascript">
            function reload_tabndp(tab){
              nnro_devolucion = document.getElementById('nnro_devolucion').value;
              nnro_recepcion = document.getElementById('nnro_recepcion').value;
              location.href="menu_principal.php?notadevolucionproveedor&l&nnro_devolucion="+nnro_devolucion+"&nnro_recepcion="+nnro_recepcion+tab;
            }
          </script>
          <table border="0" style="width: 100%"> 
            <tr>
              <td>
                <span class="texto_form">Nro. Recepción</span>
              </td>
              <td>
                <input title="Ingrese el nro. de la recepción" onKeyPress="return isNumberDocKey(event)" name="nnro_recepcion" id="nnro_recepcion" type="text" size="50" value="<?= $nnro_recepcion;?>" />
              </td>
              <td>
                <span class="texto_form">Nro. Devolución</span>
              </td>
              <td>
                <input title="Ingrese el nro. de la nota de devolución proveedor" onKeyPress="return isNumberDocKey(event)" name="nnro_devolucion" id="nnro_devolucion" type="text" size="50" value="<?= $nnro_devolucion;?>" required />
              </td>
            </tr>
          </table>
          <table align="center">  
            <tr>
              <td>
                <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabndp('#notadevolucioncliente')">
                <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
              </td>
            </tr>
          </table> 
          <a href="?notadevolucionproveedor#notadevolucionproveedor" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
          <a href="../excel/excel_notadevolucionproveedor.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
          <a href="<?php echo  '../pdf/?serv=notadevolucionproveedor';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
          <table style="width:100%;" class="tablapaginacion">
            <tr style="background: #000; color:#FFF; width:100%;"> 
              <td style="width:20%;">Nro. Devolución</td>
              <td align='left'>Fecha Devolución</td>
              <td align='left'>Nro. Recepción</td>
              <td align='left'>Fecha Recepción</td>
              <td align='left'>Proveedor</td>
              <td align='left'>Cant. Artículos</td>
              <td align='left'>Motivo Devolución</td>
            </tr>
            <?php
            //Conexión a la base de datos 
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            $clausuleWhere="";
            if($nnro_devolucion!="" && $nnro_recepcion!=""){
              $clausuleWhere.="WHERE nnro_devolucion LIKE '%$nnro_devolucion%' AND nnro_recepcion LIKE '%$nnro_recepcion%'";
            }
            else if($nnro_devolucion!=""){
              $clausuleWhere.="WHERE nnro_devolucion LIKE '%$nnro_devolucion%'";
            }
            else if($nnro_recepcion!=""){
              $clausuleWhere.="WHERE nnro_recepcion LIKE '%$nnro_recepcion%'";
            }
            //Sentencia sql (sin limit) 
            $_pagi_sql = "SELECT TRIM(dp.nnro_devolucion) nnro_devolucion, TO_CHAR(dp.dfecha_devolucion,'DD/MM/YYYY') dfecha_devolucion,
            TRIM(r.nnro_recepcion) nnro_recepcion, TO_CHAR(r.dfecha_documento,'DD/MM/YYYY') dfecha_recepcion, 
            p.crif_persona||' '||p.cnombre proveedor,md.cdescripcion motivodevolucion,
            COUNT(dp.cid_articulo) cantidad 
            FROM facturacion.vw_devolucion_proveedor dp 
            INNER JOIN facturacion.vw_recepcion r ON dp.nid_documentocompra = r.nid_documentocompra AND dp.cid_articulo = r.cid_articulo 
            INNER JOIN general.tpersona p ON r.crif_persona = p.crif_persona 
            INNER JOIN facturacion.tmotivo_devolucion md ON dp.nid_motivodevolucion = md.nid_motivodevolucion 
            $clausuleWhere 
            GROUP BY dp.nnro_devolucion,dp.dfecha_devolucion,r.nnro_recepcion,r.dfecha_documento,p.crif_persona,p.cnombre,md.cdescripcion
            ORDER BY dp.nnro_devolucion DESC";
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
              echo "<tr style='cursor: pointer;' id='".$row['nnro_devolucion']."' onclick='enviarForm(this.id)'>
                <td style='width:20%;'>".$row['nnro_devolucion']."</td>
                <td align='left'>".$row['dfecha_devolucion']."</td>
                <td align='left'>".$row['nnro_recepcion']."</td>
                <td align='left'>".$row['dfecha_recepcion']."</td>
                <td align='left'>".$row['proveedor']."</td>
                <td align='left'>".$row['cantidad']."</td>
                <td align='left'>".$row['motivodevolucion']."</td>
                </tr>"; 
            } 
            //Incluimos la barra de navegación 
            ?>
          </table>
          <script type="text/javascript">
          function enviarForm(value){
            document.getElementById('nnro_devolucion_oculto').value=value;
            document.getElementById('form').submit();
          }
          </script>
          <form id="form" method="POST" action="../controladores/control_notadevolucionproveedor.php">
            <input type="hidden" name="nnro_devolucion" id="nnro_devolucion_oculto" value="" />
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