<div class="form_externo" >
  <?php
    if(!empty($cid_articulo) && !empty($cdescripcionarticulo)){
      $_SESSION['cdescripcionarticulo']= $cdescripcionarticulo;
      $_SESSION['cid_articulo']=$cid_articulo;
    }
    if(isset($_SESSION['datos']['cid_articulo']) && isset($_SESSION['datos']['nid_unidadmedida']) && isset($_SESSION['datos']['nid_um_conversion'])){ 
      $disabledRCconversion='disabled';
      $disabledMDconversion='';
      $estatusconversion=null;
    }else {
      $disabledRCconversion='';
      $disabledMDconversion='disabled';
    }
    $servicios='articulo_conversion_configuracion';
    if(isset($_SESSION['datos'])){
      @$cid_articulo=$_SESSION['datos']['cid_articulo'];
      @$cdescripcionarticulo=$_SESSION['datos']['cdescripcionarticulo'];
      @$nid_um_conversion=$_SESSION['datos']['nid_um_conversion'];
      @$nid_unidadmedida=$_SESSION['datos']['nid_unidadmedida'];
      @$nid_um_hasta=$_SESSION['datos']['nid_um_hasta'];
      @$nfactor_multiplicador=$_SESSION['datos']['nfactor_multiplicador'];
      @$nfactor_divisor=$_SESSION['datos']['nfactor_divisor'];
      @$estatusconversion=$_SESSION['datos']['estatusconversion'];
    }else{
      @$cid_articulo=null;
      @$nid_um_conversion=null;
      @$nid_unidadmedida=null;
      @$nid_um_hasta=null;
      @$nfactor_multiplicador=null;
      @$nfactor_divisor=null;
      @$estatusconversion=null;
    }
  ?>
  <?php if(!isset($_GET['l'])){?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_conversion.php" method="post" id="form2">
      <table border="0" style="width: 100%">
        <tr>
          <td><span class="texto_form">Artículo</span></td>
          <td>
            <?php if(!empty($cid_articulo)){?>
              <input type="hidden" id="cid_articulo" name="cid_articulo" value="<?= $cid_articulo; ?>">
              <input title="El código del artículo proviene de la pestaña anterior" name="name_cid_articulo" id="name_cid_articulo" type="text" readonly value="<?= $cid_articulo."_".$cdescripcionarticulo;?>" /> 
            <?php }else{?>
              <input type="hidden" id="cid_articulo" name="cid_articulo" value="<?= $_SESSION['cid_articulo']; ?>">
              <input title="El código del formulario proviene de la pestaña anterior" name="name_articulo" id="name_articulo" type="text" readonly value="<?= $_SESSION['cid_articulo']."_".$_SESSION['cdescripcionarticulo'];?>" />
            <?php } ?>  
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">C&oacute;digo</span></td>
          <td><input title="El c&oacute;digo de la conversión de la unidad de medida es generado por el sistema" name="nid_um_conversion" id="nid_um_conversion" type="text" size="10" readonly value="<?= $nid_um_conversion;?>" /> </td>
        </tr>
        <tr>
          <td><span class="texto_form">Unidad de medida desde</span></td>
          <td>
              <select name="nid_unidadmedida" id="nid_unidadmedida" title="Seleccione la unidad de medida desde" required />
              <option value='0'>Seleccione la unidad de medida desde</option>
              <?php
                require_once("../clases/class_bd.php");
                $pgsql=new Conexion();
                $sql = "SELECT nid_unidadmedida, cdescripcion FROM inventario.tunidad_medida WHERE dfecha_desactivacion IS NULL ORDER BY nid_unidadmedida";
                $query = $pgsql->Ejecutar($sql);
                while ($row = $pgsql->Respuesta($query)){
                  $sql1 = "SELECT p.nid_unidadmedida FROM inventario.tarticulo a 
                  INNER JOIN inventario.tpresentacion p ON a.nid_presentacion = p.nid_presentacion 
                  WHERE a.cid_articulo = '$cid_articulo'";
                  $query1 = $pgsql->Ejecutar($sql1);
                  if($pgsql->Total_Filas($query1)!=null){
                    $articulo=$pgsql->Respuesta($query1);
                    if($row['nid_unidadmedida']==$articulo['nid_unidadmedida'])
                      echo "<option value='".$row['nid_unidadmedida']."' selected >".$row['cdescripcion']."</option>";
                    else
                      echo "<option value='".$row['nid_unidadmedida']."' >".$row['cdescripcion']."</option>";
                  }
                }
              ?>
            </select>
           </td>
        </tr>
        <tr>
          <td><span class="texto_form">Unidad de medida hasta</span></td>
          <td>
            <select name="nid_um_hasta" id="nid_um_hasta" title="Seleccione la unidad de medida hasta" required />
              <option value='0'>Seleccione la unidad de medida hasta</option>
              <?php
                require_once("../clases/class_bd.php");
                $pgsql=new Conexion();
                $sql = "SELECT nid_unidadmedida, cdescripcion FROM inventario.tunidad_medida WHERE dfecha_desactivacion IS NULL ORDER BY nid_unidadmedida";
                $query = $pgsql->Ejecutar($sql);
                while ($row = $pgsql->Respuesta($query)){
                  if($row['nid_unidadmedida']==$nid_um_hasta){
                    echo "<option value='".$row['nid_unidadmedida']."' selected>".$row['cdescripcion']."</option>";
                  }else{
                    echo "<option value='".$row['nid_unidadmedida']."'>".$row['cdescripcion']."</option>";
                  }
                }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Factor multiplicador</span></td>
          <td><input title="Ingrese el factor multiplicador del artículo" name="nfactor_multiplicador" id="nfactor_multiplicador" type="text" size="10" required value="<?= $nfactor_multiplicador;?>" /> </td>
        </tr>
        <tr>
          <td><span class="texto_form">Factor divisor</span></td>
          <td><input title="Ingrese el factor divisor del artículo" name="nfactor_divisor" id="nfactor_divisor" type="text" size="10" required value="<?= $nfactor_divisor;?>" /> </td>
        </tr>
        <?php echo '<tr><td colspan="2" class="'.$estatusconversion.'" id="estatus_registro">'.$estatusconversion.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
          <?php
            imprimir_boton($disabledRCconversion,$disabledMDconversion,$estatusconversion,$servicios,"conversion");
          ?>         
          </td>
        </tr>
      </table>
    </form>
  </fieldset>
<?php }else{ 
    $nid_unidadmedidab = $_GET['nid_unidadmedidab'];
    $nid_unidadmedidad = $_GET['nid_unidadmedidad'];
  ?>
  <script type="text/javascript">
    function reload_page(){
      nid_unidadmedidab = document.getElementById('nid_unidadmedidab').value;
      nid_unidadmedidad = document.getElementById('nid_unidadmedidad').value;
      location.href="menu_principal.php?articulo_conversion_configuracion&l&nid_unidadmedidab="+nid_unidadmedidab+"&nid_unidadmedidad="+nid_unidadmedidad;
    }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td><span class="texto_form">U.M. Base</span></td>
      <td>
        <select name="nid_unidadmedidab" id="nid_unidadmedidab" title="Seleccione la unidad de medida base" required />
          <option value=''>Seleccione la unidad de medida base</option>
          <?php
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            $sql = "SELECT nid_unidadmedida,cdescripcion
            FROM inventario.tunidad_medida WHERE dfecha_desactivacion IS NULL ORDER BY nid_unidadmedida ASC";
            $query = $pgsql->Ejecutar($sql);
            while ($row = $pgsql->Respuesta($query)){
              if($row['nid_unidadmedida']==$nid_unidadmedidab){
                echo "<option value='".$row['nid_unidadmedida']."' selected>".$row['cdescripcion']."</option>";
              }else{
                echo "<option value='".$row['nid_unidadmedida']."'>".$row['cdescripcion']."</option>";
              }
            }
          ?>
        </select>
      </td>
      <td><span class="texto_form">U.M. Destino</span></td>
      <td>
        <select name="nid_unidadmedidad" id="nid_unidadmedidad" title="Seleccione la unidad de medida destino" required />
          <option value=''>Seleccione la unidad de medida destino</option>
          <?php
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            $sql = "SELECT nid_unidadmedida,cdescripcion
            FROM inventario.tunidad_medida WHERE dfecha_desactivacion IS NULL ORDER BY nid_unidadmedida ASC";
            $query = $pgsql->Ejecutar($sql);
            while ($row = $pgsql->Respuesta($query)){
              if($row['nid_unidadmedida']==$nid_unidadmedidad){
                echo "<option value='".$row['nid_unidadmedida']."' selected>".$row['cdescripcion']."</option>";
              }else{
                echo "<option value='".$row['nid_unidadmedida']."'>".$row['cdescripcion']."</option>";
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
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_page()">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?articulo_conversion_configuracion#conversion" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_articulo.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=articulo';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:20%;"> Código Conversión</td>
      <td align='left'>Código Artículo</td>
      <td align='left'>Artículo</td>
      <td align='left'>U.M. Base</td>
      <td align='left'>U.M. Destino</td>
      <td align='left'>Factor Multiplo</td>
      <td align='left'>Factor Divisor</td>
    </tr>
    <?php
      //Conexión a la base de datos 
      require_once("../clases/class_bd.php");
      $pgsql=new Conexion();
      $clausuleWhere = "WHERE uc.cid_articulo = '".$_SESSION['cid_articulo']."' ";
      //Sentencia sql (sin limit) 
      $_pagi_sql = "SELECT uc.nid_um_conversion,TRIM(uc.cid_articulo) cid_articulo,a.cdescripcion articulo, 
      uc.nid_um_desde,umb.cdescripcion um_base,uc.nid_um_hasta,umd.cdescripcion um_destino, 
      uc.nfactor_multiplicador,uc.nfactor_divisor 
      FROM inventario.tum_conversion uc 
      INNER JOIN inventario.tarticulo a ON uc.cid_articulo = a.cid_articulo 
      INNER JOIN inventario.tunidad_medida umb ON uc.nid_um_desde = umb.nid_unidadmedida 
      INNER JOIN inventario.tunidad_medida umd ON uc.nid_um_hasta = umd.nid_unidadmedida 
      $clausuleWhere
      ORDER BY uc.nid_um_conversion DESC";
      //Booleano. Define si se utiliza pg_num_rows() (true) o COUNT(*) (false).
      $_pagi_conteo_alternativo = true;
      $_pagi_cuantos = 10; 
      //Cadena que separa los enlaces numéricos en la barra de navegación entre páginas.
      $_pagi_separador = " ";
      //Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
      $_pagi_nav_num_enlaces=5;
      //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente 
      @include("../librerias/paginador/paginator.inc.php"); 
      //Leemos y escribimos los registros de la página actual 
      while($row = pg_fetch_array($_pagi_result)){ 
      echo "<tr style='cursor: pointer;' id='".$row['cid_articulo']."|".$row['nid_um_desde']."|".$row['nid_um_hasta']."' onclick='enviarFormCon(this.id)'>
				<td style='width:20%;'>".$row['nid_um_conversion']."</td>
				<td align='left'>".$row['cid_articulo']."</td>
				<td align='left'>".$row['articulo']."</td>
				<td align='left'>".$row['um_base']."</td>
				<td align='left'>".$row['um_destino']."</td>
				<td align='left'>".$row['nfactor_multiplicador']."</td>
				<td align='left'>".$row['nfactor_divisor']."</td>
        </tr>"; 
      } 
      //Incluimos la barra de navegación 
    ?>
  </table>
  <script type="text/javascript">
  function enviarFormCon(value){
    var valor=value.split('|');
    document.getElementById('cid_articulo_oculto').value=valor[0];
    document.getElementById('nid_unidadmedida_oculto').value=valor[1];
    document.getElementById('nid_um_hasta_oculto').value=valor[2];
    document.getElementById('form2').submit();
  }
  </script>
  <form id="form2" method="POST" action="../controladores/control_conversion.php">
    <input type="hidden" name="cid_articulo" id="cid_articulo_oculto" value="" />
    <input type="hidden" name="nid_unidadmedida" id="nid_unidadmedida_oculto" value="" />
    <input type="hidden" name="nid_um_hasta" id="nid_um_hasta_oculto" value="" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <div class="pagination">
    <ul>
      <?php echo"<li>".$_pagi_navegacion."</li>";?>
    </ul>
  </div>
  <?php }?>
</div>