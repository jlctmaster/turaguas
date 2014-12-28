<div class="form_externo" >
  <?php
    if((isset($_SESSION['datos']['cid_articulo'])) || (isset($_SESSION['datos']['cdescripcionarticulo']))){ 
      $disabledRCarticulo='disabled';
      $disabledMDarticulo='';
      $estatusarticulo=null;
    }else {
       $disabledRCarticulo='';
       $disabledMDarticulo='disabled';
    }
	if ($estatus=="Activo"){
         $disabledRC='disabled';
         $disabledMD='';
    }
       else if ($estatus=="Desactivado") {
         $disabledRC='disabled';
         $disabledMD='disabled';
       }
       else {
         $disabledRC='';
         $disabledMD='disabled';
       }
    $servicios='articulo_conversion_configuracion';
    if(isset($_SESSION['datos'])){
      @$cid_articulo=$_SESSION['datos']['cid_articulo'];
      @$cdescripcionarticulo=$_SESSION['datos']['cdescripcionarticulo'];
      @$nid_impuesto=$_SESSION['datos']['nid_impuesto'];
      @$nid_tipoarticulo=$_SESSION['datos']['nid_tipoarticulo'];
      @$nid_presentacion=$_SESSION['datos']['nid_presentacion'];
      @$nid_categoria=$_SESSION['datos']['nid_categoria'];
      @$nid_marca=$_SESSION['datos']['nid_marca'];
      @$ncantidad_min=$_SESSION['datos']['ncantidad_min'];
      @$ncantidad_max=$_SESSION['datos']['ncantidad_max'];
      @$estatusarticulo=$_SESSION['datos']['estatusarticulo'];
    }
	else{
      @$cid_articulo=$_GET['cid_articulo'];
      @$cdescripcionarticulo=$_GET['cdescripcionarticulo'];
      @$nid_impuesto=$_GET['nid_impuesto'];
      @$nid_tipoarticulo=$_GET['nid_tipoarticulo'];
      @$nid_presentacion=$_GET['nid_presentacion'];
      @$nid_categoria=$_GET['nid_categoria'];
      @$nid_marca=$_GET['nid_marca'];
      @$ncantidad_min=$_GET['ncantidad_min'];
      @$ncantidad_max=$_GET['ncantidad_max'];
      @$estatusarticulo=$_GET['estatusarticulo'];
					
		if ($estatus=="Activo"){
		  $disabledRC='disabled';
		  $disabledMD='';
		}
		else if ($estatus=="Desactivado") {
		  $disabledRC='disabled';
		  $disabledMD='disabled';
		}
		else {
		  $disabledRC='';
		  $disabledMD='disabled';
		}
	}
  ?>
  <?php if(!isset($_GET['l'])){?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_articulo.php" method="post" id="form1">
      <table border="0" style="width: 100%">
        <tr>
          <td><span class="texto_form">Tipo de artículo</span></td>
          <td>
            <select name="nid_tipoarticulo" id="nid_tipoarticulo" title="Seleccione el tipo de atículo" required />
              <option value='0'>Seleccione el tipo de artículo</option>
              <?php
                require_once("../clases/class_bd.php");
                $mysql=new Conexion();
                $sql = "SELECT nid_tipoarticulo,cdescripcion FROM inventario.ttipo_articulo WHERE dfecha_desactivacion IS NULL and cdescripcion!='SERVICIOS' ORDER BY cdescripcion";
                $query = $mysql->Ejecutar($sql);
                while ($row = $mysql->Respuesta($query)){
                  if($row['nid_tipoarticulo']==$nid_tipoarticulo){
                    echo "<option value='".$row['nid_tipoarticulo']."' selected>".$row['cdescripcion']."</option>";
                  }else{
                    echo "<option value='".$row['nid_tipoarticulo']."'>".$row['cdescripcion']."</option>";
                  }
                }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Categoría</span></td>
          <td>
            <select name="nid_categoria" id="nid_categoria" title="Seleccione la categoría" required />
              <option value='0'>Seleccione la Categoría</option>
              <?php
                require_once("../clases/class_bd.php");
                $mysql=new Conexion();
                $sql = "SELECT nid_categoria,cdescripcion FROM inventario.tcategoria WHERE cacumulado='N' AND nid_categoria_padre IS NOT NULL AND dfecha_desactivacion IS NULL ORDER BY cdescripcion";
                $query = $mysql->Ejecutar($sql);
                while ($row = $mysql->Respuesta($query)){
                  if($row['nid_categoria']==$nid_categoria){
                    echo "<option value='".$row['nid_categoria']."' selected>".$row['cdescripcion']."</option>";
                  }else{
                    echo "<option value='".$row['nid_categoria']."'>".$row['cdescripcion']."</option>";
                  }
                }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Marca</span></td>
          <td>
            <select name="nid_marca" id="nid_marca" title="Seleccione la marca" />
              <option value='0'>Seleccione la marca</option>
              <?php
                require_once("../clases/class_bd.php");
                $mysql=new Conexion();
                $sql = "SELECT nid_marca,cdescripcion FROM inventario.tmarca WHERE dfecha_desactivacion IS NULL ORDER BY cdescripcion";
                $query = $mysql->Ejecutar($sql);
                while ($row = $mysql->Respuesta($query)){
                  if($row['nid_marca']==$nid_marca){
                    echo "<option value='".$row['nid_marca']."' selected>".$row['cdescripcion']."</option>";
                  }else{
                    echo "<option value='".$row['nid_marca']."'>".$row['cdescripcion']."</option>";
                  }
                }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Presentación</span></td>
          <td>
            <select name="nid_presentacion" id="nid_presentacion" title="Seleccione la presentación" required />
              <option value='0'>Seleccione la presentación</option>
              <?php
                require_once("../clases/class_bd.php");
                $mysql=new Conexion();
                $sql = "SELECT p.nid_presentacion as nid_presentacion,p.cdescripcion|| ' ' || p.nunidades || ' unidades ' || p.ncapacidad || u.csimbolo as nombre
                FROM inventario.tpresentacion as p
                inner join inventario.tunidad_medida as u on p.nid_unidadmedida = u.nid_unidadmedida
                WHERE p.dfecha_desactivacion IS NULL 
                ORDER BY nombre";
                $query = $mysql->Ejecutar($sql);
                while ($row = $mysql->Respuesta($query)){
                  if($row['nid_presentacion']==$nid_presentacion){
                    echo "<option value='".$row['nid_presentacion']."' selected>".$row['nombre']."</option>";
                  }else{
                    echo "<option value='".$row['nid_presentacion']."'>".$row['nombre']."</option>";
                  }
                }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Código</span></td>
          <td><input maxlength=15 title="Ingrese el código del atículo" onKeyUp="this.value=this.value.toUpperCase()" value="<?= $cid_articulo;?>" name="cid_articulo" id="cid_articulo" type="text" size="10" required /></td>
        </tr>
        <tr>
          <td><span class="texto_form">Nombre</span></td>
          <td><input name="cdescripcionarticulo" title="El nombre del atículo es generado por el sistema" id="cdescripcionarticulo" type="text" size="50" value="<?= $cdescripcionarticulo;?>" readonly/></td>
        </tr>
        <tr>
          <td><span class="texto_form">Impuesto</span></td>
          <td>
            <select name="nid_impuesto" id="nid_impuesto" title="Seleccione el impuesto" required />
              <option value='0'>Seleccione el impuesto</option>
              <?php
                require_once("../clases/class_bd.php");
                $mysql=new Conexion();
                $sql = "SELECT nid_impuesto,cdescripcion FROM facturacion.timpuesto WHERE dfecha_desactivacion IS NULL ORDER BY cdescripcion";
                $query = $mysql->Ejecutar($sql);
                while ($row = $mysql->Respuesta($query)){
                  if($row['nid_impuesto']==$nid_impuesto){
                    echo "<option value='".$row['nid_impuesto']."' selected>".$row['cdescripcion']."</option>";
                  }else{
                    echo "<option value='".$row['nid_impuesto']."'>".$row['cdescripcion']."</option>";
                  }
                }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Cantidad Mínima</span></td>
          <td><input title="Ingrese la cantidad mínima del atículo" value="<?= $ncantidad_min?>" onKeyPress="return isNumberKey(event)" name="ncantidad_min" id="ncantidad_min" type="text" size="10" required /></td>
        </tr>
        <tr>
          <td><span class="texto_form">Cantidad Máxima</span></td>
          <td><input title="Ingrese la cantidad máxima del atículo" value="<?= $ncantidad_max;?>" onKeyPress="return isNumberKey(event)" name="ncantidad_max" id="ncantidad_max" type="text" size="10" required /></td>
        </tr>  
        <?php echo '<tr><td colspan="2" class="'.$estatusarticulo.'" id="estatus_registro">'.$estatusarticulo.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
            <?php
              imprimir_boton($disabledRCarticulo,$disabledMDarticulo,$estatusarticulo,$servicios,"articulo");
            ?>         
          </td>
        </tr>
      </table>    
    </form>
  </fieldset>
  <?php }else{ 
    $cid_articulo = $_GET['cid_articulo'];
    $nid_tipoarticulo = $_GET['nid_tipoarticulo'];
    $nid_categoria = $_GET['nid_categoria'];
  ?>
  <script type="text/javascript">
    function reload_page(){
      cid_articulo = document.getElementById('cid_articulo').value;
      nid_tipoarticulo = document.getElementById('nid_tipoarticulo').value;
      nid_categoria = document.getElementById('nid_categoria').value;
      location.href="menu_principal.php?articulo_conversion_configuracion&l&cid_articulo="+cid_articulo+"&nid_tipoarticulo="+nid_tipoarticulo+"&nid_categoria="+nid_categoria;
    }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td><span class="texto_form">C&oacute;digo</span></td>
      <td>
        <input class="texto_form" title="Ingrese el c&oacute;digo del artículo a buscar" name="cid_articulo" id="cid_articulo" type="text" size="10" value="<?= $cid_articulo;?>" />
      </td>
      <td><span class="texto_form">Tipo de artículo</span></td>
      <td>
        <select name="nid_tipoarticulo" id="nid_tipoarticulo" title="Seleccione el tipo de atículo" required />
          <option value=''>Seleccione el tipo de artículo</option>
          <?php
            require_once("../clases/class_bd.php");
            $mysql=new Conexion();
            $sql = "SELECT nid_tipoarticulo,cdescripcion FROM inventario.ttipo_articulo WHERE dfecha_desactivacion IS NULL and cdescripcion!='SERVICIOS' ORDER BY cdescripcion";
            $query = $mysql->Ejecutar($sql);
            while ($row = $mysql->Respuesta($query)){
              if($row['nid_tipoarticulo']==$nid_tipoarticulo){
                echo "<option value='".$row['nid_tipoarticulo']."' selected>".$row['cdescripcion']."</option>";
              }else{
                echo "<option value='".$row['nid_tipoarticulo']."'>".$row['cdescripcion']."</option>";
              }
            }
          ?>
        </select>
      </td>
    </tr>
      <td><span class="texto_form">Categoría</span></td>
      <td>
        <select name="nid_categoria" id="nid_categoria" title="Seleccione la categoría" required />
          <option value=''>Seleccione la Categoría</option>
          <?php
            require_once("../clases/class_bd.php");
            $mysql=new Conexion();
            $sql = "SELECT nid_categoria,cdescripcion FROM inventario.tcategoria WHERE cacumulado='N' AND nid_categoria_padre IS NOT NULL AND dfecha_desactivacion IS NULL ORDER BY cdescripcion";
            $query = $mysql->Ejecutar($sql);
            while ($row = $mysql->Respuesta($query)){
              if($row['nid_categoria']==$nid_categoria){
                echo "<option value='".$row['nid_categoria']."' selected>".$row['cdescripcion']."</option>";
              }else{
                echo "<option value='".$row['nid_categoria']."'>".$row['cdescripcion']."</option>";
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
  <a href="?articulo_conversion_configuracion#articulo" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_articulo.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=articulo';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:20%;"> Código </td>
      <td align='left'>Nombre del Artículo</td>
      <td align='left'>Tipo de Artículo</td>
      <td align='left'>Categoría</td>
      <td align='left'>Presentación</td>
      <td align='left'>Impuesto</td>
    </tr>
    <?php
      //Conexión a la base de datos 
      require_once("../clases/class_bd.php");
      $pgsql=new Conexion();
      $clausuleWhere = "";
      if($cid_articulo!=""){
        $clausuleWhere.="WHERE a.cid_articulo LIKE '%$cid_articulo%'";
      }
      else if($nid_tipoarticulo!=""){
        if($clausuleWhere=="")
          $clausuleWhere.="WHERE a.nid_tipoarticulo='$nid_tipoarticulo'";
        else
          $clausuleWhere.="AND a.nid_tipoarticulo='$nid_tipoarticulo'";
      }else if($nid_categoria!=""){
        if($clausuleWhere=="")
          $clausuleWhere.="WHERE a.nid_categoria='$nid_categoria'";
        else
          $clausuleWhere.="AND a.nid_categoria='$nid_categoria'";
      }else if($nid_impuesto!=""){
        if($clausuleWhere=="")
          $clausuleWhere.="WHERE a.nid_impuesto='$nid_impuesto'";
        else
          $clausuleWhere.="AND a.nid_impuesto='$nid_impuesto'";
      }
      //Sentencia sql (sin limit) 
      $_pagi_sql = "SELECT a.cid_articulo,a.cdescripcion as nom_articulo,ti.cdescripcion as nom_tipoarticulo,c.cdescripcion as nom_categoria,
      i.cdescripcion as nom_impuesto,p.cdescripcion|| ' ' || p.nunidades || ' UNIDADES ' || p.ncapacidad || u.csimbolo as nom_presentacion
      FROM inventario.tarticulo a 
      INNER JOIN inventario.ttipo_articulo ti ON a.nid_tipoarticulo = ti.nid_tipoarticulo
      INNER JOIN inventario.tpresentacion p ON a.nid_presentacion = p.nid_presentacion
      INNER JOIN inventario.tcategoria c ON a.nid_categoria = c.nid_categoria
      inner join inventario.tunidad_medida as u on p.nid_unidadmedida = u.nid_unidadmedida 
      INNER JOIN facturacion.timpuesto i ON a.nid_impuesto = i.nid_impuesto
      $clausuleWhere 
      ORDER BY a.cid_articulo DESC";
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
      echo "<tr  style='cursor: pointer;' id='".$row['cid_articulo']."' onclick='enviarForm(this.id)'>
          <td style='width:20%;'>".$row['cid_articulo']."</td>
          <td align='left'>".$row['nom_articulo']."</td>
          <td align='left'>".$row['nom_tipoarticulo']."</td>
          <td align='left'>".$row['nom_categoria']."</td>
          <td align='left'>".$row['nom_presentacion']."</td>
          <td align='left'>".$row['nom_impuesto']."</td>
        </tr>"; 
      } 
      //Incluimos la barra de navegación 
    ?>
  </table>
  <script type="text/javascript">
  function enviarForm(value){
    document.getElementById('cdescripcion_oculto').value=value;
    document.getElementById('form1').submit();
  }
  </script>
  <form id="form1" method="POST" action="../controladores/control_articulo.php">
    <input type="hidden" name="cid_articulo" id="cdescripcion_oculto" value="" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <div class="pagination">
    <ul>
      <?php echo"<li>".$_pagi_navegacion."</li>";?>
    </ul>
  </div>
  <?php }?>
</div>