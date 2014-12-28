<?php
if(isset($_SESSION['datos']['crif_persona'])){ 
                 $disabledRC='disabled';
                  $disabledMD='';
                  $estatus=null;
                }else {
                     $disabledRC='';
                     $disabledMD='disabled';
                	}
                  $servicios='persona';
if(isset($_SESSION['datos'])){
            @$crif_persona=$_SESSION['datos']['crif_persona'];
            @$cnombre=$_SESSION['datos']['cnombre'];
            @$cdireccion=$_SESSION['datos']['cdireccion'];
            @$ctelefhab=$_SESSION['datos']['ctelefhab'];
            @$ctelefmov=$_SESSION['datos']['ctelefmov'];
            @$cemail=$_SESSION['datos']['cemail'];
            @$nid_localidad=$_SESSION['datos']['nid_localidad'];
            @$nid_rol=$_SESSION['datos']['nid_rol'];
            @$estatus=$_SESSION['datos']['estatus'];
            }
       else{
            @$crif_persona=null;
            @$cnombre=null;
            @$cdireccion=null;
            @$ctelefhab=null;
            @$ctelefmov=null;
            @$cemail=null;
            @$nid_localidad=null;
            @$nid_rol=null;
            @$estatus=null;
      }
?>
<br><br>
  <?php if(!isset($_GET['l'])) { ?>
<div class="form_externo" >
<script src="../js/eft_persona.js"> </script>
     <fieldset style="padding: 30px">
      <legend>Persona</legend>
          <form action="../controladores/control_persona.php" method="post" id="form">
        <table border="0" style="width: 100%"> 
            <tr><td><span class="texto_form">Rol</span></td><td>
            <select id="nid_rol" name="nid_rol" title="Seleccione un rol">
              <option value=0 selected>Seleccione un rol</option>
              <?php
                  require_once("../clases/class_bd.php");
                  $pgsql=new Conexion();
                  $sql = "SELECT nid_rol,cdescripcion FROM general.trol WHERE dfecha_desactivacion IS NULL ORDER BY nid_rol ASC";
                  $query = $pgsql->Ejecutar($sql);
                  while ($row = $pgsql->Respuesta($query)){
                    if($row['nid_rol']==$nid_rol){
                      echo "<option value='".$row['nid_rol']."' selected>".$row['cdescripcion']."</option>";
                    }else{
                      echo "<option value='".$row['nid_rol']."'>".$row['cdescripcion']."</option>";
                    }
                  }
                ?>
            </select>
            </td></tr>
            <tr><td><span class="texto_form">RIF o C&eacute;dula</span></td><td>
            <input onKeyPress="return isRif(event)" onKeyUp="this.value=this.value.toUpperCase()" title="Ingrese la c&eacute;dula de la persona" name="crif_persona" id="crif_persona" type="text" maxlength="10" value="<?= $crif_persona;?>" required />
            </td></tr>
             <tr><td><span class="texto_form">Nombre</span></td><td><input title="Ingrese el nombre de la persona" onKeyUp="this.value=this.value.toUpperCase()" name="cnombre" id="cnombre" type="text" size="50" value="<?= $cnombre;?>" required /></td></tr>
             <tr><td><span class="texto_form">Tlf. Habitaci&oacute;n</span></td><td><input maxlength=11 title="Ingrese el n&uacute;mero de habitaci&oacute;n" onKeyPress="return isNumberKey(event)" name="ctelefhab" id="ctelefhab" type="text" size="50" value="<?= $ctelefhab;?>" required /></td></tr>
             <tr><td><span class="texto_form">Tlf. M&oacute;vil</span></td><td><input maxlength=11 title="Ingrese el n&uacute;mero de celular" onKeyPress="return isNumberKey(event)" name="ctelefmov" id="ctelefmov" type="text" size="50" value="<?= $ctelefmov;?>" /></td></tr>
             <tr><td><span class="texto_form">Correo Electr&oacute;nico</span></td><td><input title="Ingrese el correo electr&oacute;nico de la persona" onKeyUp="this.value=this.value.toUpperCase()" name="cemail" id="cemail" type="text" size="50" value="<?= $cemail;?>" /></td></tr>
             <tr><td><span class="texto_form">Parroquia</span></td><td>
              <select name="nid_localidad" id="nid_localidad" title="Seleccione una parroquia" required>
                <?php
                  require_once("../clases/class_bd.php");
                  $pgsql=new Conexion();
                  $sql = "SELECT nid_localidad,cdescripcion FROM general.tlocalidad WHERE ctabla='tparroquia' AND dfecha_desactivacion IS NULL ORDER BY nid_localidad ASC";
                  $query = $pgsql->Ejecutar($sql);
                  while ($row = $pgsql->Respuesta($query)){
                    if($row['nid_rol']==$nid_rol){
                      echo "<option value='".$row['nid_localidad']."' selected>".$row['cdescripcion']."</option>";
                    }else{
                      echo "<option value='".$row['nid_localidad']."'>".$row['cdescripcion']."</option>";
                    }
                  }
                ?>
              </select>
            </td></tr>
            <tr><td><span class="texto_form">Direcci&oacute;n<span></td><td><textarea onKeyUp="this.value=this.value.toUpperCase()" title="Ingrese la direcci&oacute;n de la persona" name="cdireccion" id="cdireccion" required /><?= $cdireccion;?></textarea></td></tr>
            <?php echo '<tr><td colspan="2" class="'.$estatus.'" id="estatus_registro">'.$estatus.'</td></tr>'; ?>
             <tr>
                 <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                      <?php
                      imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios);
                     ?>         
                 </td>
            </tr>
          </table>    
       </form>
    </fieldset>
<br>
  <?php } else{ 
    $crif_persona = $_GET['crif_persona'];
    $cnombre = $_GET['cnombre'];
    ?>

  <script type="text/javascript">
  function reload_page(){
    crif_persona = document.getElementById('crif_persona').value;
    cnombre = document.getElementById('cnombre').value;
    location.href="menu_principal.php?persona&l&crif_persona="+crif_persona+"&cnombre="+cnombre;
  }
</script>

<table border="0" style="width: 100%"> 
  <tr>
    <td><span class="texto_form">RIF o C&eacute;dula</span></td>
    <td>
      <input onKeyPress="return isRif(event)" title="Ingrese la c&eacute;dula de la persona a buscar" name="crif_persona" id="crif_persona" type="text" size="10" value="<?= $crif_persona;?>" />
    </td>
    <td><span class="texto_form">Nombre</span></td>
    <td>
      <input title="Ingrese el nombre de la persona a buscar" onKeyUp="this.value=this.value.toUpperCase()" name="cnombre" id="cnombre" type="text" size="50" value="<?= $cnombre;?>" />
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

  <a href="?persona" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_persona.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=persona';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
     <table style="width:100%;" class="tablapaginacion">
           <tr style="background: #000; color:#FFF; width:100%;"> 
               <td style="width:20%;"> RIF o C&eacute;dula </td>
               <td align='left'>Nombre</td>
               <td align='left'>Tlf. Habitaci&oacute;n</td>
               <td align='left'>Email</td>
               <td align='left'>Rol o Cargo</td>
               <td align='left'>Direcci&oacute;n</td>
           </tr>
         <?php

           //Conexión a la base de datos 
  require_once("../clases/class_bd.php");
  $pgsql=new Conexion();

$clausuleWhere = "";
if($crif_persona!=""){
  $clausuleWhere.="WHERE p.crif_persona LIKE '%$crif_persona%'";
}
else if($cnombre!=""){
  if($clausuleWhere=="")
    $clausuleWhere.="WHERE p.cnombre LIKE '%$cnombre%'";
  else
    $clausuleWhere.="AND p.cnombre LIKE '%$cnombre%'";
}

//Sentencia sql (sin limit) 
$_pagi_sql = "SELECT p.crif_persona,p.cnombre,p.ctelefhab,p.cemail,r.cdescripcion rol, p.cdireccion 
FROM general.tpersona p 
INNER JOIN general.trol r ON p.nid_rol = r.nid_rol 
$clausuleWhere 
ORDER BY p.crif_persona DESC";
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
    echo "<tr><td style='width:20%;'>".$row['crif_persona']."</td>
    <td align='left'>".$row['cnombre']."</td>
    <td align='left'>".$row['ctelefhab']."</td>
    <td align='left'>".$row['cemail']."</td>
    <td align='left'>".$row['rol']."</td>
    <td align='left'>".$row['cdireccion']."</td></tr>"; 
} 
//Incluimos la barra de navegación 
         ?>
       </table>
<div class="pagination">
       <ul>
           <?php echo"<li>".$_pagi_navegacion."</li>";?>
       </ul>
   </div>
</div>
  <?php }?>
