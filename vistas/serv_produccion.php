<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#produccion" data-toggle="tab" id="tab-produccion">Producción de Artículos</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_produccion.js"> </script>
    <div class="tab-pane active in" id="produccion">
      <div class="form_externo" >
        <?php
          if(isset($_SESSION['datos']['nnro_produccion'])){ 
            $disabledRC='disabled';
            $disabledMD='';
            $estatus=null;
          }else {
            $disabledRC='';
            $disabledMD='disabled';
          }
          $servicios='produccion';
          if(isset($_SESSION['datos'])){
            @$nid_produccion=$_SESSION['datos']['nid_produccion'];
            @$dfecha_documento=$_SESSION['datos']['dfecha_documento'];
            @$nnro_produccion=$_SESSION['datos']['nnro_produccion'];
            @$cid_articulo=$_SESSION['datos']['cid_articulo'];
            @$ncantidad_a_producir=$_SESSION['datos']['ncantidad_a_producir'];
            @$estatus=$_SESSION['datos']['estatus'];
          }
          else{
            @$nid_produccion=null;
            @$dfecha_documento=null;
            @$nnro_produccion=null;
            @$cid_articulo=null;
            @$ncantidad_a_producir=null;
            @$estatus=null;
          }
          if(!isset($_GET['l'])){ 
        ?>
        <fieldset style="padding: 30px">
          <form action="../controladores/control_produccion.php" method="post" id="form">
            <table border="0" style="width: 100%">
              <tr>
                <td><span class="texto_form">Nro. Producción</span></td>
                <td>
                  <input type="hidden" name="nid_produccion" id="nid_produccion" value="<?= $nid_produccion;?>" />
                  <?php 
                    require_once('../clases/class_bd.php');
                    $conexion = new Conexion();
                    $sql="SELECT nid_tipodocumento,cdescripcion FROM facturacion.ttipo_documento WHERE ctipo_transaccion = 'V' 
                         AND dfecha_desactivacion IS NULL AND (LOWER(cdescripcion) LIKE '%np%' OR LOWER(cdescripcion) LIKE '%producción%')
                         ORDER BY nid_tipodocumento ASC";
                    $query=$conexion->Ejecutar($sql);
                    while($row=$conexion->Respuesta($query)){
                      echo "<input type='hidden' id='nid_tipodocumento' name='nid_tipodocumento' value='".$row['nid_tipodocumento']."'/>";
                    }
                  ?>
                  <input onKeyPress="return isNumberDocKey(event)" title="El número de la producción es generada por el sistema" name="nnro_produccion" id="nnro_produccion" type="text" maxlength="10" value="<?= $nnro_produccion;?>" />
                </td>
              </tr>
              <tr>
                <td>
                  <span class="texto_form">Fecha del Documento</span>
                </td>
                <td>
                  <input title="Seleccione la fecha de la producción" name="dfecha_documento" id="dfecha_documento" type="text" size="50" readonly value="<?= $dfecha_documento;?>" required />
                </td>
              </tr>
              <tr>
                <td>
                  <span class="texto_form">Artículo a Producir</span>
                </td>
                <td>
                  <select name="cid_articulo" id="cid_articulo" title="Seleccione un artículo a producir" required >
                    <option value="0">Seleccione un artículo</option>
                    <?php
                      require_once('../clases/class_bd.php');
                      $pgsql = new Conexion();
                      $sqlx = "SELECT TRIM(cid_articulo) cid_articulo,cdescripcion 
                      FROM inventario.tarticulo 
                      WHERE dfecha_desactivacion IS NULL AND nid_tipoarticulo IN (SELECT nid_tipoarticulo 
                      FROM inventario.ttipo_articulo WHERE LOWER(cdescripcion) LIKE '%producto terminado%' OR LOWER(cdescripcion) LIKE '%servicio%')
                      ORDER BY cid_articulo ASC";
                      $querys = $pgsql->Ejecutar($sqlx);
                      while ($row = $pgsql->Respuesta($querys)){
                        if($row['cid_articulo']==$cid_articulo)
                          echo "<option value='".$row['cid_articulo']."' selected >".$row['cdescripcion']."</option>";
                        else
                          echo "<option value='".$row['cid_articulo']."' >".$row['cdescripcion']."</option>";
                      }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td>
                  <span class="texto_form">Cantidad a Producir</span>
                </td>
                <td>
                  <input type="hidden" id="ncantidad_max" value="<?= $ncantidad_a_producir;?>"/>
                  <input title="Ingrese la cantidad a producir, según disponibilidad" name="ncantidad_a_producir" id="ncantidad_a_producir" type="text" size="50" value="<?= $ncantidad_a_producir;?>" required />
                </td>
              </tr>
            </table>
            <br/>
            <div class="table-responsive">
              <table id='TablaInsumos' class="table table-bordered table-striped">
                <tr>
                  <td><center><span class="texto_tabla">Insumo</span></center></td>
                  <td><center><span class="texto_tabla">Cantidad</span></center></td>
                  <td><center><span class="texto_tabla">Total a Usar</span></center></td>
                </tr>
                <?php
                  $pgsql=new Conexion();
                  $sql = "SELECT p.nlinea,p.materiaprima,p.cantidad_usada*umc.nfactor_multiplicador cant_kg,um.csimbolo,
                  p.cantidad_usada total,CASE WHEN p.cantidad_usada > 1 THEN pre.cdescripcion||'S' ELSE pre.cdescripcion END presentacion
                  FROM inventario.vw_produccion p 
                  INNER JOIN inventario.tarticulo a ON p.materiaprima = a.cid_articulo 
                  INNER JOIN inventario.tpresentacion pre ON a.nid_presentacion = pre.nid_presentacion 
                  INNER JOIN inventario.tum_conversion umc ON p.materiaprima = umc.cid_articulo AND pre.nid_unidadmedida = umc.nid_um_hasta 
                  INNER JOIN inventario.tunidad_medida um ON pre.nid_unidadmedida = um.nid_unidadmedida 
                  WHERE nnro_produccion='$nnro_produccion' 
                  ORDER BY p.nlinea ASC";
                  $query = $pgsql->Ejecutar($sql);
                  $con=0;
                    while ($row = $pgsql->Respuesta($query)){
                      echo "<tr id='".$con."'>
                              <td>
                              <center>
                                <input type='hidden' name='linea[]' id='linea_".$con."' value='".$row['nlinea']."' />
                                <input type='text' name='insumo[]' id='insumo_".$con."' title='Insumo necesario para producir el artículo seleccionado' value='".$row['materiaprima']."' readonly />
                              </center>
                              </td>
                              <td>
                              <center>
                                <input class='campo_tabla' type='text' name='cantidad[]' id='cantidad_".$con."' size='50' value='".$row['cant_kg']."' readonly />&nbsp;<span>".$row['csimbolo']."</span>
                              </center>
                              </td>
                              <td>
                              <center>
                                <input class='campo_tabla' type='text' name='total[]' id='total_".$con."' size='50' value='".$row['total']."' readonly />&nbsp;<span>".$row['presentacion']."</span>
                              </center>
                              </td>
                            </tr>";
                      $con++;
                    }
                ?>
            </div>
            <table>
              <?php echo '<tr><td colspan="2" class="'.$estatus.'" id="estatus_registro">'.$estatus.'</td></tr>'; ?>
              <tr>
                <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                  <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                  <?php
                    imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"produccion");
                  ?>
                  <input onclick="location='../invoice/produccion.php?nnro_produccion=<?= $nnro_produccion;?>&nameuser=<?= $_SESSION['fullname_user'];?>'" 
                  type="button" name="btimprimir" id="8" value="Imprimir Documento" class="btn btn-default" 
                  <? if($nnro_produccion==null){ echo "disabled";}?> />
                </td>
              </tr>
            </table>
          </form>
        </fieldset>
        <br>
        <?php }else{  
          $nnro_produccion = $_GET['nnro_produccion'];
          $dfecha_documento = $_GET['dfecha_documento'];
          ?>
          <script type="text/javascript">
            function reload_tabop(tab){
              nnro_produccion = document.getElementById('nnro_produccion').value;
              dfecha_documento = document.getElementById('dfecha_documento').value;
              location.href="menu_principal.php?produccion&l&nnro_produccion="+nnro_produccion+"&dfecha_documento="+dfecha_documento+tab;
            }
          </script>
          <table border="0" style="width: 100%"> 
            <tr>
              <td>
                <span class="texto_form">Nro. Producción</span>
              </td>
              <td>
                <input title="Ingrese el nro. de la producción" onKeyUp="this.value=this.value.toUpperCase()" name="nnro_produccion" id="nnro_produccion" type="text" size="50" value="<?= $nnro_produccion;?>" />
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
                <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabsc('#produccion')">
                <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
              </td>
            </tr>
          </table> 
          <a href="?produccion#produccion" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
          <a href="../excel/excel_produccion.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
          <a href="<?php echo  '../pdf/?serv=produccion';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
          <table style="width:100%;" class="tablapaginacion">
            <tr style="background: #000; color:#FFF; width:100%;"> 
              <td style="width:20%;">Nro. Producción</td>
              <td align='left'>Fecha Documento</td>
              <td align='left'>Artículo</td>
              <td align='left'>Cant. a Produccir</td>
            </tr>
            <?php
            //Conexión a la base de datos 
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            $clausuleWhere="";
            if($nnro_produccion!="" && $crif_persona!=""){
              $clausuleWhere.="WHERE nnro_produccion LIKE '%$nnro_produccion%' AND dfecha_documento LIKE '%$dfecha_documento%'";
            }
            else if($nnro_produccion!=""){
              $clausuleWhere.="WHERE nnro_produccion LIKE '%$nnro_produccion%'";
            }
            else if($dfecha_documento!=""){
              $clausuleWhere.="WHERE dfecha_documento LIKE '%$dfecha_documento%'";
            }
            //Sentencia sql (sin limit) 
            $_pagi_sql = "SELECT DISTINCT TRIM(nnro_produccion) nnro_produccion, TO_CHAR(dfecha_documento,'DD/MM/YYYY') dfecha_documento,
            productoterminado,cantidad_a_producir 
            FROM inventario.vw_produccion
            $clausuleWhere 
            ORDER BY nnro_produccion DESC";
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
              echo "<tr style='cursor: pointer;' id='".$row['nnro_produccion']."' onclick='enviarForm(this.id)'>
                <td style='width:20%;'>".$row['nnro_produccion']."</td>
                <td align='left'>".$row['dfecha_documento']."</td>
                <td align='left'>".$row['productoterminado']."</td>
                <td align='left'>".$row['cantidad_a_producir']."</td>
                </tr>"; 
            } 
            //Incluimos la barra de navegación 
            ?>
          </table>
          <script type="text/javascript">
          function enviarForm(value){
            document.getElementById('nnro_produccion_oculto').value=value;
            document.getElementById('form').submit();
          }
          </script>
          <form id="form" method="POST" action="../controladores/control_produccion.php">
            <input type="hidden" name="nnro_produccion" id="nnro_produccion_oculto" value="" />
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