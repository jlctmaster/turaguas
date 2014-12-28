<div class="form_externo" >
<?php
if(!empty($nid_categoria) && !empty($cdescripcionc)){
    $_SESSION['cdescripcionc']=$cdescripcionc;
    $_SESSION['nid_categoria']=$nid_categoria;
  }
if(isset($_SESSION['datos']['cdescripcions'])){ 
                 $disabledRCsubcateria='disabled';
                  $disabledMDsubcategoria='';
                  $estatus_subcategoria=null;
                }else {
                     $disabledRCsubcateria='';
                     $disabledMDsubcategoria='disabled';
                  }
                  $servicios='categoria';
if(isset($_SESSION['datos'])){
            @$cdescripcions=$_SESSION['datos']['cdescripcions'];
            @$cdescripcionc=$_SESSION['datos']['cdescripcionc'];
            @$nid_categoria_sub=$_SESSION['datos']['nid_categoria_sub'];
            @$nid_categoria_padre=$_SESSION['datos']['nid_categoria_padre'];
            @$estatus_subcategoria=$_SESSION['datos']['estatus_subcategoria'];
            }
       else{
            @$cdescripcions=null;
            @$nid_categoria_sub=null;
            @$nid_categoria_padre=null;
            @$cdescripcionc=null;
            @$estatus_subcategoria=null;
            }
?>
  <?php if(!isset($_GET['l'])){?>
     <fieldset style="padding: 30px">
          <form action="../controladores/control_subcategoria.php" method="post" id="form2">
        <table border="0" style="width: 100%">
          <tr>
          <td><span class="texto_form">Categoría</span></td>
          <td>
            <?php if(!empty($nid_categoria_padre)){?>
              <input type="hidden" id="nid_categoria_padre" name="nid_categoria_padre" value="<?= $nid_categoria_padre; ?>">
              <input title="El código de la categoría proviene de la pestaña anterior" name="nid_categoria_padre" id="nid_categoria_padre" type="text" readonly value="<?= $nid_categoria_padre."_".$cdescripcionc;?>" /> 
            <?php }else{?>
              <input type="hidden" id="nid_categoria_padre" name="nid_categoria_padre" value="<?= $_SESSION['nid_categoria']; ?>">
              <input title="El código de la categoría proviene de la pestaña anterior" name="name_categoria" id="name_categoria" type="text" readonly value="<?= $_SESSION['nid_categoria']."_".$_SESSION['cdescripcionc'];?>" /> 
            <?php } ?>
          </td>
        </tr>
            <tr><td><span class="texto_form">C&oacute;digo </span></td><td><input title="El c&oacute;digo de la subcategoria es generado por el sistema" name="nid_categoria_sub" id="nid_categoria_sub" type="text" size="10" readonly value="<?= $nid_categoria_sub;?>" /> </td></tr>
             <tr><td><span class="texto_form">Sub - categoría</span></td><td><input title="Ingrese el nombre de la subcategoria" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcions" id="cdescripcions" type="text" size="50" value="<?= $cdescripcions;?>" required /></td></tr>
             <?php echo '<tr><td colspan="2" class="'.$estatus_subcategoria.'" id="estatus_registro">'.$estatus_subcategoria.'</td></tr>'; ?>
             <tr>
                 <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                      <?php
                      imprimir_boton($disabledRCsubcateria,$disabledMDsubcategoria,$estatus_subcategoria,$servicios,"subcategoria");
                     ?>         
                 </td>
            </tr>
          </table>    
       </form>
    </fieldset>
<br>
  <?php }else{ 
   $cdescripcions = $_GET['cdescripcions'];
    ?>

  <script type="text/javascript">
  function reload_page(){
    cdescripcions = document.getElementById('cdescripcions').value;
    location.href="menu_principal.php?categoria&l&cdescripcions="+cdescripcions+tab;
  }
</script>

<table border="0" style="width: 100%"> 
   <tr>
    <td><span class="texto_form">Sub-categor&iacute;a</span></td>
   </tr>
  <tr>
    <td>
      <input title="Ingrese el nombre de la sub-categoría" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcions" id="cdescripcions" type="text" size="50" value="<?= $cdescripcions;?>" />
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

  <a href="?categoria#subcategoria" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_subcategoria.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=subcategoria';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
     <table style="width:100%;" class="tablapaginacion">
           <tr style="background: #000; color:#FFF; width:100%;"> 
               <td style="width:20%;">C&oacute;digo </td>
               <td align='left'>Sub-categoria</td>
               <td align='left'>C&oacute;digo </td>
               <td align='left'>Categoria</td>
           </tr>
         <?php




           //Conexión a la base de datos 
  require_once("../clases/class_bd.php");
  $pgsql=new Conexion();
  $clausuleWhere = "WHERE s.nid_categoria_padre = '".$_SESSION['nid_categoria']."' AND s.dfecha_desactivacion IS NULL";
  if($cdescripcions!=""){
    $clausuleWhere.="AND s.cdescripcion LIKE '%$cdescripcions%'";
  }

//Sentencia sql (sin limit) 
$_pagi_sql = "SELECT c.cdescripcion as categoria,c.nid_categoria as id,s.cdescripcion as cdescripcions,s.nid_categoria as idsub
FROM inventario.tcategoria c 
INNER JOIN inventario.tcategoria s ON c.nid_categoria = s.nid_categoria_padre
$clausuleWhere 
ORDER BY s.cdescripcion DESC";
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
          echo "<tr  style='cursor: pointer;' id='".$row['cdescripcions']."' onclick='enviarFormS(this.id)'>
                <td style='width:20%;'>".$row['idsub']."</td>
                <td align='left'>".$row['cdescripcions']."</td>
                <td align='left'>".$row['id']."</td>
                <td align='left'>".$row['categoria']."</td></tr>"; 
} 
//Incluimos la barra de navegación 
         ?>
       </table>
  <script type="text/javascript">
  function enviarFormS(value){
    document.getElementById('cdescripcion_oculto2').value=value;
    document.getElementById('form2').submit();
  }
  </script>
  <form id="form2" method="POST" action="../controladores/control_subcategoria.php">
    <input type="hidden" name="cdescripcions" id="cdescripcion_oculto2" value="" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
<div class="pagination">
       <ul>
           <?php echo"<li>".$_pagi_navegacion."</li>";?>
       </ul>
   </div>
</div>
  <?php }?>