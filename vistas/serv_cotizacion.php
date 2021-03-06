<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#cotizacion" data-toggle="tab" id="tab-cotizacion">Cotización</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_cotizacion.js"> </script>
    <div class="tab-pane active in" id="cotizacion">
      <div class="form_externo" >
        <?php
          if(isset($_SESSION['datos']['nnro_cotizacion'])){ 
            $disabledRC='disabled';
            $disabledMD='';
            $estatus=null;
          }else {
            $disabledRC='';
            $disabledMD='disabled';
          }
          $servicios='cotizacion';
          if(isset($_SESSION['datos'])){
            @$nid_documentoventa=$_SESSION['datos']['nid_documentoventa'];
            @$dfecha_documento=$_SESSION['datos']['dfecha_documento'];
            @$nnro_cotizacion=$_SESSION['datos']['nnro_cotizacion'];
            @$crif_persona=$_SESSION['datos']['crif_persona'];
            @$cnombrecliente=$_SESSION['datos']['cnombrecliente'];
            @$nid_condicionpago=$_SESSION['datos']['nid_condicionpago'];
            @$estatus=$_SESSION['datos']['estatus'];
          }
          else{
            @$nid_documentoventa=null;
            @$dfecha_documento=null;
            @$nnro_cotizacion=null;
            @$crif_persona=null;
            @$cnombrecliente=null;
            @$nid_condicionpago=null;
            @$estatus=null;
          }
          if(!isset($_GET['l'])){ 
        ?>
        <fieldset style="padding: 30px">
          <form action="../controladores/control_cotizacion.php" method="post" id="form">
            <table border="0" style="width: 100%">
              <tr>
                <td><span class="texto_form">Nro. Cotizacion</span></td>
                <td>
                  <input type="hidden" name="nid_documentoventa" id="nid_documentoventa" value="<?= $nid_documentoventa;?>" />
                  <?php 
                    require_once('../clases/class_bd.php');
                    $conexion = new Conexion();
                    $sql="SELECT nid_tipodocumento,cdescripcion FROM facturacion.ttipo_documento WHERE ctipo_transaccion = 'V' 
                         AND dfecha_desactivacion IS NULL AND (LOWER(cdescripcion) LIKE '%(c)%' OR LOWER(cdescripcion) LIKE '%cotización%')
                         ORDER BY nid_tipodocumento ASC";
                    $query=$conexion->Ejecutar($sql);
                    while($row=$conexion->Respuesta($query)){
                      echo "<input type='hidden' id='nid_tipodocumento' name='nid_tipodocumento' value='".$row['nid_tipodocumento']."'/>";
                    }
                  ?>
                  <input onKeyPress="return isNumberDocKey(event)" title="El número de la cotización es generado por el sistema" name="nnro_cotizacion" id="nnro_cotizacion" type="text" maxlength="10" value="<?= $nnro_cotizacion;?>" />
                </td>
              </tr>
              <tr>
                <td>
                  <span class="texto_form">Fecha del Documento</span>
                </td>
                <td>
                  <input title="Seleccione la fecha del número de cotización" name="dfecha_documento" id="dfecha_documento" type="text" size="50" readonly value="<?= $dfecha_documento;?>" required />
                </td>
              </tr>
              <tr>
                <td>
                  <span class="texto_form">RIF Cliente</span>
                </td>
                <td>
                  <input title="Ingrese el RIF del cliente" onKeyUp="this.value=this.value.toUpperCase()" name="crif_persona" 
                  id="crif_persona" type="text" size="50" value="<?= $crif_persona;?>" />
                </td>
              </tr>
              <tr>
                <td>
                  <span class="texto_form">Razón Social</span>
                </td>
                <td>
                  <input title="Nombre de la razón social" name="cnombrecliente" id="cnombrecliente" type="text" size="50" value="<?= $cnombrecliente;?>" readonly />
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
            </table>
            <br/>
            <div class="table-responsive">
              <table id='TablaArticulos' class="table table-bordered table-striped">
                <tr>
                  <td><center><span class="texto_tabla">Artículo</span></center></td>
                  <td><center><span class="texto_tabla">Cantidad</span></center></td>
                  <td><center><span class="texto_tabla">Precio</span></center></td>
                  <td><center><input type="button" onclick="agrega_campos()" value="+" class="btn btn-default" /></center></td>
                </tr>
                <?php
                  $pgsql=new Conexion();
                  $sql = "SELECT ddc.nlinea,TRIM(ddc.cid_articulo) cid_articulo, MAX(ddc.ncantidad_articulo) ncantidad_articulo, 
                  MAX(ddc.nprecio) nprecio 
                  FROM facturacion.tdocumentoventa dc 
                  INNER JOIN facturacion.tdetalle_documentoventa ddc ON dc.nid_documentoventa = ddc.nid_documentoventa 
                  WHERE dc.nnro_cotizacion = '$nnro_cotizacion' 
                  GROUP BY ddc.nlinea,ddc.cid_articulo 
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
                              WHERE dfecha_desactivacion IS NULL AND nid_tipoarticulo IN (SELECT nid_tipoarticulo 
                              FROM inventario.ttipo_articulo WHERE LOWER(cdescripcion) LIKE '%producto terminado%' OR LOWER(cdescripcion) LIKE '%servicio%')
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
                              <input class='campo_tabla' type='text' onKeyPress='return isNumberKey(event)' name='cantidad[]' id='cantidad_".$con."' size='25' value='".$row['ncantidad_articulo']."' />
                            </center>
                            </td>
                            <td>
                            <center>
                              <input class='campo_tabla' type='text' onKeyPress='return isNumberKey(event)' name='precio[]' id='precio_".$con."' size='25' value='".$row['nprecio']."' />
                            </center>
                            </td>
                            <td>
                            <center>
                              <input type='button' class='btn btn-default' onclick='elimina_me('".$con."')' value='-'>
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
                    imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"cotizacion");
                  ?>
                  <input onclick="location='../invoice/cotizacion.php?nnro_cotizacion=<?= $nnro_cotizacion;?>&nameuser=<?= $_SESSION['fullname_user'];?>'" 
                  type="button" name="btimprimir" id="8" value="Imprimir Documento" class="btn btn-default" 
                  <? if($nnro_cotizacion==null){ echo "disabled";}?> />
                </td>
              </tr>
            </table>
          </form>
          <script type="text/javascript">
            var linea = document.getElementsByName('linea[]');
            var articulo = document.getElementsByName('articulo[]');
            var cantidad = document.getElementsByName('cantidad[]');
            var precio = document.getElementsByName('precio[]');
            var cantidad_vieja = document.getElementsByName('cantidad_vieja[]');
            var contador=linea.length;
              function agrega_campos(){
                  $("#TablaArticulos").append("<tr id='"+contador+"'>"+
                    "<td>"+
                    "<center>"+
                      "<input type='hidden' name='linea[]' id='linea_"+contador+"' value='"+parseInt(contador+1)+"' />"+
                      "<select name='articulo[]' id='articulo_"+contador+"' title='Seleccione una artículo'>"+
                      "<option value='0'>Seleccione una artículo</option>"+
                      <?php
                        require_once("../clases/class_bd.php");
                        $pgsql=new Conexion();
                        $sql = "SELECT TRIM(cid_articulo) cid_articulo,cdescripcion 
                        FROM inventario.tarticulo 
                        WHERE dfecha_desactivacion IS NULL AND nid_tipoarticulo IN (SELECT nid_tipoarticulo 
                        FROM inventario.ttipo_articulo WHERE LOWER(cdescripcion) LIKE '%producto terminado%' OR LOWER(cdescripcion) LIKE '%servicio%')
                        ORDER BY cid_articulo ASC";
                        $query = $pgsql->Ejecutar($sql);
                        $comillasimple=chr(34);
                        while ($rows = $pgsql->Respuesta($query)){
                          if($rows['cid_articulo']==$row['cid_articulo']){
                            echo $comillasimple."<option value='".$rows['cid_articulo']."' selected>".$rows['cdescripcion']."</option>".$comillasimple."+";
                          }else{
                            echo $comillasimple."<option value='".$rows['cid_articulo']."'>".$rows['cdescripcion']."</option>".$comillasimple."+";
                          }
                        }
                      ?>
                      "</select>"+
                    "</center>"+
                    "</td>"+
                    "<td>"+
                    "<center>"+
                    "<input type='hidden' name='cantidad_vieja[]' id='cantidad_vieja_"+contador+"' value='0'/>"+
                    "<input class='campo_tabla' type='text' onKeyPress='return isNumberKey(event)' name='cantidad[]' id='cantidad_"+contador+"' size='25' />"+
                    "</center>"+
                    "</td>"+
                    "<td>"+
                    "<center>"+
                    "<input class='campo_tabla' type='text' onKeyPress='return isNumberKey(event)' name='precio[]' id='precio_"+contador+"' size='25' />"+
                    "</center>"+
                    "</td>"+
                    "<td>"+
                    "<center>"+
                    "<input type='button' class='btn btn-default' onclick='elimina_me("+contador+")' value='-'>"+
                    "</center>"+
                    "</td>"+
                    "</tr>");
                  contador++;
              }
          
              function elimina_me(elemento){
                $("#"+elemento).remove();
                for(var i=0;i<linea.length;i++){
                  linea[i].removeAttribute('id');
                  articulo[i].removeAttribute('id');
                  cantidad[i].removeAttribute('id');
                  precio[i].removeAttribute('id');
                  cantidad_vieja[i].removeAttribute('id');
                }
                for(var i=0;i<linea.length;i++){
                  linea[i].setAttribute('id','linea_'+i);
                  articulo[i].setAttribute('id','articulo_'+i);
                  cantidad[i].setAttribute('id','cantidad_'+i);
                  precio[i].setAttribute('id','precio_'+i);
                  cantidad_vieja[i].setAttribute('id','cantidad_vieja_'+i);
                }
              }
          </script>
        </fieldset>
        <br>
        <?php }else{  
          $nnro_cotizacion = $_GET['nnro_cotizacion'];
          $dfecha_documento = $_GET['dfecha_documento'];
          ?>
          <script type="text/javascript">
            function reload_tabc(tab){
              nnro_cotizacion = document.getElementById('nnro_cotizacion').value;
              dfecha_documento = document.getElementById('dfecha_documento').value;
              location.href="menu_principal.php?cotizacion&l&nnro_cotizacion="+nnro_cotizacion+"&dfecha_documento="+dfecha_documento+tab;
            }
          </script>
          <table border="0" style="width: 100%"> 
            <tr>
              <td>
                <span class="texto_form">Nro. Órden</span>
              </td>
              <td>
                <input title="Ingrese el nro. de la órden de compra" onKeyUp="this.value=this.value.toUpperCase()" name="nnro_cotizacion" id="nnro_cotizacion" type="text" size="50" value="<?= $nnro_cotizacion;?>" />
              </td>
              <td>
                <span class="texto_form">Fecha del Documento</span>
              </td>
              <td>
                <input title="Seleccione la fecha de la órden de compra" name="dfecha_documento" id="dfecha_documento" type="text" size="50" readonly value="<?= $dfecha_documento;?>" required />
              </td>
            </tr>
          </table>
          <table align="center">  
            <tr>
              <td>
                <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabc('#cotizacion')">
                <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
              </td>
            </tr>
          </table> 
          <a href="?cotizacion#cotizacion" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
          <a href="../excel/excel_cotizacion.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
          <a href="<?php echo  '../pdf/?serv=cotizacion';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
          <table style="width:100%;" class="tablapaginacion">
            <tr style="background: #000; color:#FFF; width:100%;"> 
              <td style="width:20%;">Nro. Cotizacion</td>
              <td align='left'>Fecha Documento</td>
              <td align='left'>Cantidad de Artículos</td>
            </tr>
            <?php
            //Conexión a la base de datos 
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            $clausuleWhere="";
            if($nnro_cotizacion!="" && $crif_persona!=""){
              $clausuleWhere.="WHERE nnro_cotizacion LIKE '%$nnro_cotizacion%' AND dfecha_documento LIKE '%$dfecha_documento%'";
            }
            else if($nnro_cotizacion!=""){
              $clausuleWhere.="WHERE nnro_cotizacion LIKE '%$nnro_cotizacion%'";
            }
            else if($dfecha_documento!=""){
              $clausuleWhere.="WHERE dfecha_documento LIKE '%$dfecha_documento%'";
            }
            //Sentencia sql (sin limit) 
            $_pagi_sql = "SELECT TRIM(nnro_cotizacion) nnro_cotizacion, TO_CHAR(dfecha_documento,'DD/MM/YYYY') dfecha_documento,
            COUNT(cid_articulo) cantidad 
            FROM facturacion.vw_cotizacion
            $clausuleWhere 
            GROUP BY nnro_cotizacion,dfecha_documento 
            ORDER BY nnro_cotizacion DESC";
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
              echo "<tr style='cursor: pointer;' id='".$row['nnro_cotizacion']."' onclick='enviarForm(this.id)'>
                <td style='width:20%;'>".$row['nnro_cotizacion']."</td>
                <td align='left'>".$row['dfecha_documento']."</td>
                <td align='left'>".$row['cantidad']."</td>
                </tr>"; 
            } 
            //Incluimos la barra de navegación 
            ?>
          </table>
          <script type="text/javascript">
          function enviarForm(value){
            document.getElementById('nnro_cotizacion_oculto').value=value;
            document.getElementById('form').submit();
          }
          </script>
          <form id="form" method="POST" action="../controladores/control_cotizacion.php">
            <input type="hidden" name="nnro_cotizacion" id="nnro_cotizacion_oculto" value="" />
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