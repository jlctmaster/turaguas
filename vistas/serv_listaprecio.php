<div class="form_externo" >
  <?php
    if(isset($_SESSION['datos']['cdescripcionlistaprecio'])){ 
      $disabledRClistaprecio='disabled';
      $disabledMDlistaprecio='';
      $estatuslistaprecio=null;
    }else {
      $disabledRClistaprecio='';
      $disabledMDlistaprecio='disabled';
    }
	
    if ($estatuslistaprecio=="Activo"){
       $disabledRC='disabled';
       $disabledMD='';
    }
    else if ($estatuslistaprecio=="Desactivado") {
       $disabledRC='disabled';
       $disabledMD='disabled';
    }
    else {
       $disabledRC='';
       $disabledMD='disabled';
    }
    $servicios='lista_precio';
    if(isset($_SESSION['datos'])){
      @$cdescripcionlistaprecio=$_SESSION['datos']['cdescripcionlistaprecio'];
      @$nid_listaprecio=$_SESSION['datos']['nid_listaprecio'];
      @$dvigencia_desde=$_SESSION['datos']['dvigencia_desde'];
      @$dvigencia_hasta=$_SESSION['datos']['dvigencia_hasta'];
      @$estatuslistaprecio=$_SESSION['datos']['estatuslistaprecio'];
    }else{
      @$nid_listaprecio=$_GET['nid_listaprecio'];
      @$cdescripcionlistaprecio=$_GET['cdescripcionlistaprecio'];
      @$dvigencia_desde=$_GET['dvigencia_desde'];
      @$dvigencia_hasta=$_GET['dvigencia_hasta'];
      @$estatuslistaprecio=$_GET['estatuslistaprecio'];
	  
			
	 if ($estatuslistaprecio=="Activo"){
	   $disabledRC='disabled';
	   $disabledMD='';
	 }
	 else if ($estatuslistaprecio=="Desactivado") {
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
    <form action="../controladores/control_lista_precio.php" method="post" id="form1">
      <table border="0" style="width: 100%">
        <tr>
          <td><span class="texto_form">Código</span></td>
          <td><input title="El código de la lista de precio es generado por el sistema" name="nid_listaprecio" id="nid_listaprecio" type="text" size="10" readonly value="<?= $nid_listaprecio;?>" /></td>
        </tr>
        <tr>
          <td><span class="texto_form">Lista de Precio</span></td>
          <td><input title="Ingrese la descripción de la lista de precio" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcionlistaprecio" id="cdescripcionlistaprecio" type="text" size="50" value="<?= $cdescripcionlistaprecio;?>" required></td
        ></tr>
        <tr>
          <td><span class="texto_form">Fecha de vigencia desde</span></td>
          <td><input title="Seleccione la fecha de vigencia desde que va a tener la lista de precio" type="text" size="35" name="dvigencia_desde" id="dvigencia_desde" value="<?= $dvigencia_desde;?>"></td>
        </tr>
        <tr>
          <td><span class="texto_form">Fecha de vigencia hasta</span></td>
          <td><input title="Seleccione la fecha de vigencia hasta que va a tener la lista de precio" type="text" size="35" name="dvigencia_hasta" id="dvigencia_hasta" value="<?= $dvigencia_hasta;?>"></td>
        </tr>
            <?php echo '<tr><td colspan="2" class="'.$estatuslistaprecio.'" id="estatus_registro">'.$estatuslistaprecio.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
            <?php
              imprimir_boton($disabledRClistaprecio,$disabledMDlistaprecio,$estatuslistaprecio,$servicios,"listaprecio");
            ?>         
          </td>
        </tr>
      </table>    
    </form>
  </fieldset>
  <br>
  <?php }else{ 
  $cdescripcionlistaprecio = $_GET['cdescripcionlistaprecio'];
  ?>
  <script type="text/javascript">
    function reload_tabalmacen(tab){
      cdescripcionlistaprecio = document.getElementById('cdescripcionlistaprecio').value;
      location.href="menu_principal.php?lista_precio&l&cdescripcionlistaprecio="+cdescripcionlistaprecio+tab;
    }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td><span clas="texto_form">Nombre de la lista de precio</span></td>
    </tr>
    <tr>
      <td>
        <input title="Ingrese el nombre de la lista de precio" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcionlistaprecio" id="cdescripcionlistaprecio" type="text" size="50" value="<?= $cdescripcionlistaprecio;?>" />
      </td>
    </tr>
  </table>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabalmacen('#listaprecio')">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?lista_precio#listaprecio" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_listaprecio.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=listaprecio';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:20%;">C&oacute;digo </td>
      <td align='left'>Nombre</td>
      <td align='left'>Vigencia desde</td>
      <td align='left'>Vigencia hasta</td>
    </tr>
    <?php
    //Conexión a la base de datos 
    require_once("../clases/class_bd.php");
    $pgsql=new Conexion();
    $clausuleWhere = "";
    if($cdescripcionalmacen!=""){
      $clausuleWhere.="WHERE cdescripcion LIKE '%$cdescripcionlistaprecio%'";
    }
    //Sentencia sql (sin limit) 
    $_pagi_sql = "SELECT cdescripcion as cdescripcionlistaprecio,nid_listaprecio,TO_CHAR(dvigencia_desde,'DD/MM/YYYY') dvigencia_desde,TO_CHAR(dvigencia_hasta,'DD/MM/YYYY') dvigencia_hasta
    FROM facturacion.tlista_precio 
    $clausuleWhere 
    ORDER BY cdescripcion DESC";
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
  echo "<tr  style='cursor: pointer;' id='".$row['cdescripcionlistaprecio']."' onclick='enviarForm(this.id)'>
	  	<td style='width:20%;'>".$row['nid_listaprecio']."</td>
        <td align='left'>".$row['cdescripcionlistaprecio']."</td>
        <td align='left'>".$row['dvigencia_desde']."</td>
        <td align='left'>".$row['dvigencia_hasta']."</td></tr>"; 
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
  <form id="form1" method="POST" action="../controladores/control_lista_precio.php">
    <input type="hidden" name="cdescripcionlistaprecio" id="cdescripcion_oculto" value="" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <div class="pagination">
    <ul>
      <?php echo"<li>".$_pagi_navegacion."</li>";?>
    </ul>
  </div>
  <?php }?>
</div>