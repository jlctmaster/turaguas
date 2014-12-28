<div class="form_externo" >
  <?php
    if(!empty($nid_listaprecio) && !empty($cdescripcionlistaprecio)){
    $_SESSION['cdescripcionlistaprecio']= $cdescripcionlistaprecio;
    $_SESSION['nid_listaprecio']=$nid_listaprecio;
  }
    if(isset($_SESSION['datos']['cid_articulo'])){ 
      $disabledRClinea='disabled';
      $disabledMDlinea='';
      $estatuslinea=null;
    }else {
      $disabledRClinea='';
      $disabledMDlinea='disabled';
    }
    $servicios='lista_precio';
    if(isset($_SESSION['datos'])){
      @$cdescripcionlistaprecio=$_SESSION['datos']['cdescripcion'];
      @$cid_articulo=$_SESSION['datos']['cid_articulo'];
      @$nid_detallelistaprecio=$_SESSION['datos']['nid_detallelistaprecio'];
      @$nid_listaprecio=$_SESSION['datos']['nid_listaprecio'];
      @$nprecio=$_SESSION['datos']['nprecio'];
      @$nprecio_limite=$_SESSION['datos']['nprecio_limite'];
      @$ndescuento=$_SESSION['datos']['ndescuento'];
      @$estatuslinea=$_SESSION['datos']['estatuslinea'];
    }else{
      @$cdescripcionlistaprecio=null;
      @$cid_articulo=null;
      @$nid_detallelistaprecio=null;
      @$nid_listaprecio=null;
      @$nprecio=null;
      @$nprecio_limite=null;
      @$ndescuento=null;
      @$estatuslinea=null;
    }
  ?>
  <?php if(!isset($_GET['l'])){?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_linea.php" method="post" id="form2">
      <table border="0" style="width: 100%">
        <tr>
          <td><span class="texto_form">Lista de precio</span></td>
          <td>
            <?php if(!empty($nid_listaprecio)){?>
              <input type="hidden" id="nid_listaprecio" name="nid_listaprecio" value="<?= $nid_listaprecio; ?>">
              <input title="El código de la lista de precio proviene de la pestaña anterior" name="name_listaprecio" id="name_listaprecio" type="text" readonly value="<?= $nid_listaprecio."_".$cdescripcionlistaprecio;?>" /> 
            <?php }else{?>
              <input type="hidden" id="nid_listaprecio" name="nid_listaprecio" value="<?= $_SESSION['nid_listaprecio']; ?>">
              <input title="El nombre de la lista de precio proviene de la pestaña anterior" name="name_listaprecio" id="name_listaprecio" type="text" readonly value="<?= $_SESSION['nid_listaprecio']."_".$_SESSION['cdescripcionlistaprecio'];?>" /> 
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Código</span></td>
          <td><input title="El código de la línea es generado por el sistema" name="nid_detallelistaprecio" id="nid_detallelistaprecio" type="text" size="10" readonly value="<?= $nid_detallelistaprecio;?>" /></td>
        </tr>
        <tr>
          <td><span class="texto_form">Artículo</span></td>
          <td>
            <select name="cid_articulo" id="cid_articulo" title="Seleccione el artículo" required />
              <option value='0'>Seleccione el artículo</option>
              <?php
                require_once("../clases/class_bd.php");
                $mysql=new Conexion();
                $sql = "SELECT cid_articulo, cdescripcion FROM inventario.tarticulo WHERE dfecha_desactivacion IS NULL ORDER BY cid_articulo";
                $query = $mysql->Ejecutar($sql);
                while ($row = $mysql->Respuesta($query)){
                  if($row['cid_articulo']==$cid_articulo){
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
          <td><span class="texto_form">Precio</span></td>
          <td><input title="Ingrese el precio de la línea" type="text" onKeyPress="return isNumberKey(event)" size="35" name="nprecio" id="nprecio" value="<?= $nprecio;?>"></td>
        </tr>
        <tr>
          <td><span class="texto_form">Precio Límite</span></td>
          <td><input title="Ingrese el límite del precio de la línea" type="text" onKeyPress="return isNumberKey(event)" size="35" name="nprecio_limite" id="nprecio_limite" value="<?= $nprecio_limite;?>"></td>
        </tr>
        <tr>
          <td><span class="texto_form">Descuento</span></td>
          <td><input title="Ingrese el descuenta de la línea" type="text" size="35" name="ndescuento" id="ndescuento" value="<?= $ndescuento;?>"></td>
        </tr>
            <?php echo '<tr><td colspan="2" class="'.$estatuslinea.'" id="estatus_registro">'.$estatuslinea.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
            <?php
              imprimir_boton($disabledRClinea,$disabledMDlinea,$estatuslinea,$servicios,"linea");
            ?>         
          </td>
        </tr>
      </table>    
    </form>
  </fieldset>
  <br>
  <?php }else{ 
  $cid_articulo = $_GET['cid_articulo'];
  ?>
  <script type="text/javascript">
    function reload_tabalmacen(tab){
      cid_articulo = document.getElementById('cid_articulo').value;
      location.href="menu_principal.php?lista_precio&l&cid_articulo="+cid_articulo+tab;
    }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td><span clas="texto_form">Nombre del artículo</span></td>
    </tr>
    <tr>
      <td>
        <input title="Ingrese el nombre del artículo" onKeyUp="this.value=this.value.toUpperCase()" name="cid_articulo" id="cid_articulo" type="text" size="50" value="<?= $cid_articulo;?>" />
      </td>
    </tr>
  </table>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabalmacen('#linea')">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?lista_precio#linea"><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_linea.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=linea';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:20%;">C&oacute;digo </td>
      <td style="width:20%;">Lista de precio</td>
      <td align='left'>Artículo</td>
      <td align='left'>Precio</td>
      <td align='left'>Precio Límite</td>
      <td align='left'>Descuento</td>
    </tr>
    <?php
    //Conexión a la base de datos 
    require_once("../clases/class_bd.php");
    $pgsql=new Conexion();
    $clausuleWhere = "WHERE d.nid_listaprecio = '".$_SESSION['nid_listaprecio']."'";
    //Sentencia sql (sin limit) 
    $_pagi_sql = "SELECT d.nid_detallelistaprecio as nid_detallelistaprecio,d.nid_listaprecio as nid_listaprecio,l.cdescripcion as lista_precio,
    d.cid_articulo as cid_articulo,d.nprecio as nprecio,d.nprecio_limite as nprecio_limite,d.ndescuento as ndescuento
    FROM facturacion.tdetalle_lista_precio as d
    inner join  facturacion.tlista_precio  l on d.nid_listaprecio = l.nid_listaprecio
    $clausuleWhere
    ORDER BY d.cid_articulo DESC";
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
      echo "<tr style='cursor: pointer;' id='".$row['nid_listaprecio']."|".$row['cid_articulo']."' onclick='enviarFormLOC(this.id)'>
	    <td style='width:20%;'>".$row['nid_detallelistaprecio']."</td>
        <td style='width:20%;'>".$row['lista_precio']."</td>
        <td align='left'>".$row['cid_articulo']."</td>
        <td align='left'>".$row['nprecio']."</td>
        <td align='left'>".$row['nprecio_limite']."</td>
        <td align='left'>".$row['ndescuento']."</td></tr>"; 
    } 
    //Incluimos la barra de navegación 
    ?>
  </table>
  <script type="text/javascript">
  function enviarFormLOC(value){
    var valor=value.split('|');
    document.getElementById('nid_listaprecio_oculto').value=valor[0];
    document.getElementById('cid_articulo_oculto').value=valor[1];
    document.getElementById('form2').submit();
  }
  </script>
  <form id="form2" method="POST" action="../controladores/control_linea.php">
    <input type="hidden" name="nid_listaprecio" id="nid_listaprecio_oculto" value="" />
    <input type="hidden" name="cid_articulo" id="cid_articulo_oculto" value="" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <div class="pagination">
    <ul>
      <?php echo"<li>".$_pagi_navegacion."</li>";?>
    </ul>
  </div>
  <?php }?>
</div>