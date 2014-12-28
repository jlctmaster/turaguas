<div class="form_externo" >
  <?php
  if(isset($_SESSION['datos']['cdescripciongrupo'])){ 
    $disabledRCgrupo='disabled';
    $disabledMDgrupo='';
    $estatusgrupo=null;
  }else {
    $disabledRCgrupo='';
    $disabledMDgrupo='disabled';
  }
  $servicios='motivodevolucion';
  if(isset($_SESSION['datos'])){
    @$cdescripciongrupo=$_SESSION['datos']['cdescripciongrupo'];
    @$nid_motivodevoluciongrupo=$_SESSION['datos']['nid_motivodevoluciongrupo'];
    @$estatusgrupo=$_SESSION['datos']['estatusgrupo'];
  }
  else{
    @$cdescripciongrupo=null;
    @$nid_motivodevoluciongrupo=null;
    @$estatusgrupo=null;
  }
  if(!isset($_GET['l'])){?>
  <fieldset style="padding: 30px">
    <form action="../controladores/control_grupo.php" method="post" id="form1">
      <table border="0" style="width: 100%">
        <tr><td><span class="texto_form">Código</span></td><td><input title="el código del grupo es generado por el sistema" name="nid_motivodevolucion" id="nid_motivodevolucion" type="text" size="10" readonly value="<?= $nid_motivodevoluciongrupo;?>" /></td><tr>
        <tr><td><span class="texto_form">Grupo de Motivos</span></td><td><input title="Ingrese la descripción del grupo de motivo devolucion" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripciongrupo;?>" required/></td><tr>
        <?php echo '<tr><td colspan="2" class="'.$estatusgrupo.'" id="estatus_registro">'.$estatusgrupo.'</td></tr>'; ?>
        <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
            <?php
              imprimir_boton($disabledRCgrupo,$disabledMDgrupo,$estatusgrupo,$servicios,"grupo");
            ?>         
          </td>
        </tr>
      </table>    
    </form>
  </fieldset>
  <br>
  <?php }else{  
  $cdescripciongrupo = $_GET['cdescripcion'];
  ?>
  <script type="text/javascript">
    function reload_tabgrupo(tab){
      cdescripcion = document.getElementById('cdescripcion').value;
      location.href="menu_principal.php?motivodevolucion&l&cdescripcion="+cdescripcion+tab;
    }
  </script>
  <table border="0" style="width: 100%"> 
    <tr>
      <td><span class="texto_form">Grupo de Motivos</span></td>
    </tr>
    <tr>
      <td><input title="Ingrese la descripción del grupo de motivo devolución" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripciongrupo;?>" required/></td>
    </tr>
  </table>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabgrupo('#grupo')">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?motivodevolucion#grupo" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_grupo.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=grupo';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
  <table style="width:100%;" class="tablapaginacion">
    <tr style="background: #000; color:#FFF; width:100%;"> 
      <td style="width:25%;"> Codigo </td>
      <td align='left'>Grupo de Motivos</td>
    </tr>
    <?php
    //Conexión a la base de datos 
    require_once("../clases/class_bd.php");
    $pgsql=new Conexion();
    $clausuleWhere="WHERE dfecha_desactivacion IS NULL AND cacumulado = 'Y'";
    if($cdescripciongrupo!=""){
      $clausuleWhere.="AND cdescripcion LIKE '%$cdescripciongrupo%'";
    }
    //Sentencia sql (sin limit) 
    $_pagi_sql = "SELECT * FROM facturacion.tmotivo_devolucion 
    $clausuleWhere 
    ORDER BY nid_motivodevolucion DESC";
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
      echo "<tr  style='cursor: pointer;' id='".$row['cdescripcion']."' onclick='enviarForm(this.id)'>
      <td style='width:20%;'>".$row['nid_motivodevolucion']."</td>
        <td align='left'>".$row['cdescripcion']."</td></tr>"; 
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
  <form id="form1" method="POST" action="../controladores/control_grupo.php">
    <input type="hidden" name="cdescripcion" id="cdescripcion_oculto" value="" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
  <div class="pagination">
    <ul>
      <?php echo"<li>".$_pagi_navegacion."</li>";?>
    </ul>
  </div>
  <?php }?>
</div>