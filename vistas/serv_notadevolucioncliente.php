<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#notadevolucioncliente" data-toggle="tab" id="tab-notadevolucioncliente">Nota de Devolución Cliente</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_notadevolucioncliente.js"> </script>
    <div class="tab-pane active in" id="notadevolucioncliente">
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
          $servicios='notadevolucioncliente';
          if(isset($_SESSION['datos'])){
            @$nid_devolucion=$_SESSION['datos']['nid_devolucion'];
            @$nnro_devolucion=$_SESSION['datos']['nnro_devolucion'];
            @$dfecha_devolucion=$_SESSION['datos']['dfecha_devolucion'];
            @$nid_documentoventa=$_SESSION['datos']['nid_documentoventa'];
            @$nnro_entrega=$_SESSION['datos']['nnro_entrega'];
            @$dfecha_documento=$_SESSION['datos']['dfecha_documento'];
            @$estatus=$_SESSION['datos']['estatus'];
          }
          else{
            @$nid_devolucion=null;
            @$nnro_devolucion=null;
            @$dfecha_devolucion=null;
            @$nid_documentoventa=null;
            @$nnro_entrega=null;
            @$dfecha_documento=null;
            @$estatus=null;
          }
          if(!isset($_GET['l'])){ 
        ?>
        <script type="text/javascript">
        $(document).ready(init);
        function init(){
          //Buscar los datos del nro de orden seleccionado.
          $('#nnro_entrega').change(function(){
            Datos = {"operacion":"BuscarDatosNroEntrega","nnro_entrega": $('#nnro_entrega').val()};
            BuscarDatosNroEntrega(Datos);
          })
          //Busca los datos del número de entrega seleccionado.
          function BuscarDatosNroEntrega(value){
            $.ajax({
              url: '../controladores/control_notadevolucioncliente.php',
              type: 'POST',
              async: true,
              data: value,
              dataType: "json",
              success: function(resp){
                $('#nid_documentoventa').val(resp[0].nid_documentoventa);
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
          <form action="../controladores/control_notadevolucioncliente.php" method="post" id="form">
            <table border="0" style="width: 100%">
              <tr>
                <td>
                  <span class="texto_form">Nro. Entrega</span>
                </td>
                <td>
                  <input type="hidden" name="nid_documentoventa" id="nid_documentoventa" value="<?= $nid_documentoventa;?>">
                  <input type="hidden" name="numero_entrega" id="numero_entrega" value="<?= $nnro_entrega;?>">
                  <select name="nnro_entrega" id="nnro_entrega" title="Seleccione una nota de entrega" required />
                    <option value="0">Seleccione una nota de entrega</option>
                    <?php
                      require_once('../clases/class_bd.php');
                      $conexion = new Conexion();
                      $sql="SELECT DISTINCT TRIM(e.nnro_entrega) nnro_entrega 
                      FROM facturacion.vw_entrega e 
                      LEFT JOIN facturacion.vw_devolucion_cliente dc ON e.nid_documentoventa = dc.nid_documentoventa AND e.cid_articulo = dc.cid_articulo 
                      GROUP BY e.nnro_entrega,e.cid_articulo 
                      HAVING MAX(e.ncantidad_articulo) > SUM(CASE WHEN dc.ncantidad_articulo IS NULL THEN 0 ELSE dc.ncantidad_articulo END) 
                      ORDER BY nnro_entrega ASC";
                      $query=$conexion->Ejecutar($sql);
                      while($row=$conexion->Respuesta($query)){
                        if($row['nnro_entrega']==$nnro_entrega){
                          echo "<option value='".$row['nnro_entrega']."' selected>".$row['nnro_entrega']."</option>";
                        }else{
                          echo "<option value='".$row['nnro_entrega']."'>".$row['nnro_entrega']."</option>";
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
                    $sql="SELECT nid_tipodocumento,cdescripcion FROM facturacion.ttipo_documento WHERE ctipo_transaccion = 'V' 
                         AND dfecha_desactivacion IS NULL AND LOWER(cdescripcion) LIKE '%ndc%'
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
                  FROM facturacion.vw_devolucion_cliente dp 
                  INNER JOIN inventario.tarticulo a ON dp.cid_articulo = a.cid_articulo 
                  WHERE dp.nnro_devolucion = '$nnro_devolucion'";
                  $query = $pgsql->Ejecutar($sql);
                  $con=0;
                    while ($row = $pgsql->Respuesta($query)){
                      echo "<tr id='".$con."'>
                              <td>
                              <center>
                                <input type='hidden' name='linea[]' id='linea_".$con."' value='".$row['nlinea']."' />
                                <input type='hidden' name='articulo[]' id='articulo_".$con."' value='".$row['cid_articulo']."' />
                                <input type='text' name='descrip_articulo[]' id='descrip_articulo_".$con."' value='".$row['articulo']."' readonly />
                              </center>
                              </td>
                              <td>
                              <center>
                                <input type='hidden' name='cantidad_vieja[]' id='cantidad_vieja_".$con."' value='".$row['ncantidad_articulo']."' />
                                <input class='campo_tabla' type='text' onKeyPress='return isNumberKey(event)' name='cantidad[]' id='cantidad_".$con."' size='50' value='".$row['ncantidad_articulo']."' />
                              </center>
                              </td>
                              <td>
                              <center>
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
                              <center>
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
                    imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"notadevolucioncliente");
                  ?>
                  <input onclick="location='../invoice/notadevolucioncliente.php?nnro_devolucion=<?= $nnro_devolucion;?>&nameuser=<?= $_SESSION['fullname_user'];?>'" 
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
          $nnro_entrega = $_GET['nnro_entrega'];
          ?>
          <script type="text/javascript">
            function reload_tabndp(tab){
              nnro_devolucion = document.getElementById('nnro_devolucion').value;
              nnro_entrega = document.getElementById('nnro_entrega').value;
              location.href="menu_principal.php?notadevolucioncliente&l&nnro_devolucion="+nnro_devolucion+"&nnro_entrega="+nnro_entrega+tab;
            }
          </script>
          <table border="0" style="width: 100%"> 
            <tr>
              <td>
                <span class="texto_form">Nro. Entrega</span>
              </td>
              <td>
                <input title="Ingrese el nro. de la entrega" onKeyPress="return isNumberDocKey(event)" name="nnro_entrega" id="nnro_entrega" type="text" size="50" value="<?= $nnro_entrega;?>" />
              </td>
              <td>
                <span class="texto_form">Nro. Devolución</span>
              </td>
              <td>
                <input title="Ingrese el nro. de la nota de devolución cliente" onKeyPress="return isNumberDocKey(event)" name="nnro_devolucion" id="nnro_devolucion" type="text" size="50" value="<?= $nnro_devolucion;?>" required />
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
          <a href="?notadevolucioncliente#notadevolucioncliente" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
          <a href="../excel/excel_notadevolucioncliente.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
          <a href="<?php echo  '../pdf/?serv=notadevolucioncliente';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
          <table style="width:100%;" class="tablapaginacion">
            <tr style="background: #000; color:#FFF; width:100%;"> 
              <td style="width:20%;">Nro. Devolución</td>
              <td align='left'>Fecha Devolución</td>
              <td align='left'>Nro. Entrega</td>
              <td align='left'>Fecha Entrega</td>
              <td align='left'>Cliente</td>
              <td align='left'>Cant. Artículos</td>
              <td align='left'>Motivo Devolución</td>
            </tr>
            <?php
            //Conexión a la base de datos 
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            $clausuleWhere="";
            if($nnro_devolucion!="" && $nnro_entrega!=""){
              $clausuleWhere.="WHERE nnro_devolucion LIKE '%$nnro_devolucion%' AND nnro_entrega LIKE '%$nnro_entrega%'";
            }
            else if($nnro_devolucion!=""){
              $clausuleWhere.="WHERE nnro_devolucion LIKE '%$nnro_devolucion%'";
            }
            else if($nnro_entrega!=""){
              $clausuleWhere.="WHERE nnro_entrega LIKE '%$nnro_entrega%'";
            }
            //Sentencia sql (sin limit) 
            $_pagi_sql = "SELECT TRIM(dc.nnro_devolucion) nnro_devolucion, TO_CHAR(dc.dfecha_devolucion,'DD/MM/YYYY') dfecha_devolucion,
            TRIM(e.nnro_entrega) nnro_entrega, TO_CHAR(e.dfecha_documento,'DD/MM/YYYY') dfecha_entrega, 
            p.crif_persona||' '||p.cnombre cliente,md.cdescripcion motivodevolucion,
            COUNT(dc.cid_articulo) cantidad 
            FROM facturacion.vw_devolucion_cliente dc 
            INNER JOIN facturacion.vw_entrega e ON dc.nid_documentoventa = e.nid_documentoventa AND dc.cid_articulo = e.cid_articulo 
            INNER JOIN general.tpersona p ON e.crif_persona = p.crif_persona 
            INNER JOIN facturacion.tmotivo_devolucion md ON dc.nid_motivodevolucion = md.nid_motivodevolucion 
            $clausuleWhere 
            GROUP BY dc.nnro_devolucion,dc.dfecha_devolucion,e.nnro_entrega,e.dfecha_documento,p.crif_persona,p.cnombre,md.cdescripcion
            ORDER BY dc.nnro_devolucion DESC";
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
                <td align='left'>".$row['nnro_entrega']."</td>
                <td align='left'>".$row['dfecha_entrega']."</td>
                <td align='left'>".$row['cliente']."</td>
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
          <form id="form" method="POST" action="../controladores/control_notadevolucioncliente.php">
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