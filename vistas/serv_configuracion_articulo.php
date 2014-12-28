<div class="form_externo" >
  <?php
    if(!empty($cid_articulo) && !empty($cdescripcionarticulo)){
      $_SESSION['cid_articulo']=$cid_articulo;
      $_SESSION['cdescripcionarticulo']=$cdescripcionarticulo;
    }
    if((isset($_SESSION['datos']['cid_articulo'])) && (isset($_SESSION['datos']['cid_insumo']))){ 
      $disabledRCconfiguracion_articulo='disabled';
      $disabledMDconfiguracion_articulo='';
      $estatusconfiguracion=null;
    }else {
      $disabledRCconfiguracion_articulo='';
      $disabledMDconfiguracion_articulo='disabled';
    }
    $servicios='articulo_conversion_configuracion';
    if(isset($_SESSION['datos'])){
      @$nid_configuracion_articulo=$_SESSION['datos']['nid_configuracion_articulo'];
      @$cid_articulo=$_SESSION['datos']['cid_articulo'];
      @$cdescripcionarticulo=$_SESSION['datos']['cdescripcionarticulo'];
      @$cid_insumo=$_SESSION['datos']['cid_insumo'];
      @$ncantidad=$_SESSION['datos']['ncantidad'];
      @$nmerma=$_SESSION['datos']['nmerma'];
      @$csimbolo=$_SESSION['datos']['csimbolo'];
      @$cinsumobase=$_SESSION['datos']['cinsumobase'];
      @$estatusconfiguracion=$_SESSION['datos']['estatusconfiguracion'];
    }else{
      @$nid_configuracion_articulo=null;
      @$cid_articulo=null;
      @$cdescripcionarticulo=null;
      @$cid_insumo=null;
      @$ncantidad=null;
      @$nmerma=null;
      @$csimbolo=null;
      @$cinsumobase=null;
      @$estatusconfiguracion=null;
    }
  ?>
  <?php if(!isset($_GET['l'])){?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_configuracion_articulo.php" method="post" id="form3">
      <table border="0" style="width: 100%">
        <tr>
          <td><span class="texto_form">Artículo</span></td>
          <td>
            <?php if(!empty($cid_articulo)){?>
              <input type="hidden" id="cid_articulo" name="cid_articulo" value="<?= $cid_articulo; ?>">
              <input title="El código del artículo proviene de la pestaña anterior" name="name_cid_articulo" id="name_cid_articulo" type="text" readonly value="<?= trim($cid_articulo)."_".$cdescripcionarticulo;?>" /> 
            <?php }else{?>
              <input type="hidden" id="cid_articulo" name="cid_articulo" value="<?= $_SESSION['cid_articulo']; ?>">
              <input title="El código del formulario proviene de la pestaña anterior" name="name_articulo" id="name_articulo" type="text" readonly value="<?= $_SESSION[trim('cid_articulo')]."_".$_SESSION['cdescripcionarticulo'];?>" />
            <?php } ?>  
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">C&oacute;digo</span></td>
          <td><input title="El c&oacute;digo de la configuración del artículo es generado por el sistema" name="nid_configuracion_articulo" id="nid_configuracion_articulo" type="text" size="10" readonly value="<?= $nid_configuracion_articulo;?>" /> </td>
        </tr>
        <tr>
          <td><span class="texto_form">Insumo</span></td>
          <td>
            <select name="cid_insumo" id="cid_insumo" title="Seleccione el insumo" required />
              <option value='0'>Seleccione el insumo</option>
              <?php
                require_once("../clases/class_bd.php");
                $mysql=new Conexion();
                $sql = "SELECT TRIM(a.cid_articulo) cid_articulo, a.cdescripcion, t.cdescripcion insumo
                        FROM inventario.tarticulo as a 
                        inner join INVENTARIO.TTIPO_ARTICULO t on a.nid_tipoarticulo = t.nid_tipoarticulo
                        WHERE t.cdescripcion='INSUMOS' ORDER BY a.cid_articulo";
                $query = $mysql->Ejecutar($sql);
                while ($row = $mysql->Respuesta($query)){
                  if($row['cid_articulo']==$cid_insumo){
                    echo "<option value='".$row['cid_articulo']."' selected>".$row['cdescripcion']."</option>";
                  }else{
                    echo "<option value='".$row['cid_articulo']."'>".$row['cdescripcion']."</option>";
                  }
                }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Cantidad a Usar</span></td>
          <td>
            <input title="Ingrese la cantidad a utilizar para crear el artículo" value="<?= $ncantidad?>" onKeyPress="return isNumberKey(event)" name="ncantidad" id="ncantidad" type="text" size="10" required />&nbsp;<span id="UMC"><?= $csimbolo;?></span>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Merma</span></td>
          <td>
            <input title="Ingrese la cantidad de la merma del artículo" value="<?= $nmerma?>" onKeyPress="return isNumberKey(event)" name="nmerma" id="nmerma" type="text" size="10" required />&nbsp;<span id="UMM"><?= $csimbolo;?></span>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form"></span></td>
          <td>
            <input title="Tilde solo si el artículo es un insumo base" type="checkbox" name="cinsumobase" id="cinsumobase" <? if($cinsumobase=="Y"){echo "checked='checked'";}?>/> Insumo Base 
          </td>
        </tr>
        <?php echo '<tr><td colspan="2" class="'.$estatusconfiguracion.'" id="estatus_registro">'.$estatusconfiguracion.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
          <?php
            imprimir_boton($disabledRCconfiguracion_articulo,$disabledMDconfiguracion_articulo,$estatusconfiguracion,$servicios,"configuracion_articulo");
          ?>         
          </td>
        </tr>
      </table>    
    </form>
  </fieldset>
 <?php }else{ 
    $cid_insumo = $_GET['cid_insumo'];
  ?>
  <script type="text/javascript">
    function reload_pageca(tab){
      cid_insumo = document.getElementById('cid_insumos').value;
      location.href="menu_principal.php?articulo_conversion_configuracion&l&cid_insumo="+cid_insumo+tab;
    }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td><span class="texto_form">Insumo</span></td>
      <td>
        <input name="cid_insumo" id="cid_insumos" type="text" title="Ingrese el nombre del articulo a consular" />
      </td>
    </tr>
  </table>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_pageca()">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?articulo_conversion_configuracion#configuracion_articulo" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_articulo.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=articulo';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:20%;"> Código </td>
      <td align='left'>Código Artículo</td>
      <td align='left'>Artículo</td>
      <td align='left'>Código Insumo</td>
      <td align='left'>Insumo</td>
      <td align='left'>Cant. a Usar</td>
      <td align='left'>Merma</td>
    </tr>
    <?php
      //Conexión a la base de datos 
      require_once("../clases/class_bd.php");
      $pgsql=new Conexion();
      $clausuleWhere = "WHERE ca.cid_servicio = '".$_SESSION['cid_articulo']."' ";
      if($cid_insumo!=""){
        $clausuleWhere.="AND ca.cid_insumo LIKE '%$cid_insumo%'";
      }
      //Sentencia sql (sin limit) 
      $_pagi_sql = "SELECT ca.nid_configuracionarticulo,TRIM(ca.cid_servicio) cid_servicio,ars.cdescripcion servicio, 
      TRIM(ca.cid_insumo) cid_insumo,ari.cdescripcion insumo,ca.ncantidad,ca.nmerma 
      FROM inventario.tconfiguracion_articulo ca 
      INNER JOIN inventario.tarticulo ars ON ca.cid_servicio = ars.cid_articulo 
      INNER JOIN inventario.tarticulo ari ON ca.cid_insumo = ari.cid_articulo 
      $clausuleWhere
      ORDER BY nid_configuracionarticulo DESC";
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
      echo "<tr  style='cursor: pointer;' id='".$row['cid_servicio']."|".$row['cid_insumo']."' onclick='enviarFormConf(this.id)'>
          <td style='width:20%;'>".$row['nid_configuracionarticulo']."</td>
          <td align='left'>".$row['cid_servicio']."</td>
          <td align='left'>".$row['servicio']."</td>
          <td align='left'>".$row['cid_insumo']."</td>
          <td align='left'>".$row['insumo']."</td>
          <td align='left'>".$row['ncantidad']."</td>
          <td align='left'>".$row['nmerma']."</td>
        </tr>"; 
      } 
      //Incluimos la barra de navegación 
    ?>
  </table>
  <script type="text/javascript">
  function enviarFormConf(value){
    var valor=value.split('|');
    console.log(valor[0]+" => "+valor[1]);
    document.getElementById('cid_servicio_oculto').value=valor[0];
    document.getElementById('cid_insumo_oculto').value=valor[1];
    document.getElementById('form3').submit();
  }
  </script>
  <form id="form3" method="POST" action="../controladores/control_configuracion_articulo.php">
    <input type="hidden" name="cid_articulo" id="cid_servicio_oculto" value="" />
    <input type="hidden" name="cid_insumo" id="cid_insumo_oculto" value="" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <div class="pagination">
    <ul>
      <?php echo"<li>".$_pagi_navegacion."</li>";?>
    </ul>
  </div>
  <?php }?>
</div>