<div class="form_externo" >
  <?php
  if(!empty($crif_personaproveedor) && !empty($cnombreproveedor)){
    $_SESSION['cnombreproveedor']= $cnombreproveedor;
    $_SESSION['crif_personaproveedor']=$crif_personaproveedor;
  }
if(isset($_SESSION['datos']['crif_personacontacto'])){ 
                 $disabledRCcontacto='disabled';
                  $disabledMDcontacto='';
                  $estatuscontacto=null;
                }else {
                     $disabledRCcontacto='';
                     $disabledMDcontacto='disabled';
                  }
                  $servicios='proveedor';
if(isset($_SESSION['datos'])){
            @$nid_personacontacto=$_SESSION['datos']['nid_personacontacto'];
            @$crif_personacontacto=$_SESSION['datos']['crif_personacontacto'];
            @$cnombrecontacto=$_SESSION['datos']['cnombrecontacto'];
            @$crif_personaproveedor=$_SESSION['datos']['crif_personaproveedor'];
            @$cnombreproveedor=$_SESSION['datos']['cnombreproveedor'];
            @$nid_direcciondespacho=$_SESSION['datos']['nid_direcciondespacho'];
            @$ccargo=$_SESSION['datos']['ccargo'];
            @$ctelefono=$_SESSION['datos']['ctelefono'];
            @$estatuscontacto=$_SESSION['datos']['estatuscontacto'];
            }
       else{
            @$nid_personacontacto=null;
            @$crif_personacontacto=null;
            @$cnombrecontacto=null;
            @$crif_personaproveedor=null;
            @$cnombreproveedor=null;
            @$nid_direccionespacho=null;
            @$ccargo=null;
            @$ctelefono=null;
            @$estatuscontacto=null;
      }
if(!isset($_GET['l'])) { ?>
     <fieldset style="padding: 30px">
          <form action="../controladores/control_contactoproveedor.php" method="post" id="form3">
        <table border="0" style="width: 100%">
         <tr> <td><span class="texto_form">Proveedor</span></td>
          <td>
             <?php if(!empty($crif_personaproveedor)){?>
              <input type="hidden" id="crif_personaproveedor" name="crif_personaproveedor" value="<?= $crif_personaproveedor; ?>">
              <input title="El RIF del Proveedor proviene de la pestaña anterior" name="cnombreproveedor" id="cnombreproveedor" type="text" readonly value="<?= $crif_personaproveedor."_".$cnombreproveedor;?>" /> 
            <?php }else{?>
              <input type="hidden" id="crif_personaproveedor" name="crif_personaproveedor" value="<?= $_SESSION['crif_personaproveedor']; ?>">
              <input title="El código del formulario proviene de la pestaña anterior" name="cnombreproveedor" id="cnombreproveedor" type="text" readonly value="<?= $_SESSION['crif_personaproveedor']."_".$_SESSION['cnombreproveedor'];?>" /> 
            <?php } ?>
          </td>
        </tr>
            <tr><td><span class="texto_form">Dirección de Sucursal</span></td>
          <td>
             <select name="nid_direcciondespacho" id="nid_direcciondespacho" title="Seleccione una dirección de sucursal" required>
              <option value="0">Seleccione una dirección de sucursal</option>
              <?php
              require_once("../clases/class_bd.php");
              $conexion = new Conexion();
              if(!empty($crif_personaproveedor)){
                $sql="SELECT nid_direcciondespacho, cdireccion FROM general.tdireccion_despacho WHERE crif_persona = '$crif_personaproveedor' ORDER BY nid_direcciondespacho ASC";
              }else{
                $sql="SELECT nid_direcciondespacho, cdireccion FROM general.tdireccion_despacho WHERE crif_persona = '".$_SESSION['crif_personaproveedor']."' ORDER BY nid_direcciondespacho ASC";
              }
              $query=$conexion->Ejecutar($sql);
              while ($row=$conexion->Respuesta($query)){
                if($row['nid_direcciondespacho']==$nid_direcciondespacho){
                  echo "<option value='".$row['nid_direcciondespacho']."' selected >".$row['cdireccion']."</option>";
                }else{
                  echo "<option value='".$row['nid_direcciondespacho']."' >".$row['cdireccion']."</option>";
                }
              }
              ?>
             </select>
          </td>
        </tr>
            <tr><td><span class="texto_form">Código Contacto</span></td>
              <td><input readonly title="El código del contacto es generado por el sistema" name="nid_personacontacto" id="nid_personacontacto" type="text" size="50" value="<?= $nid_personacontacto;?>" required /></td>
            </tr>
            <tr><td><span class="texto_form">RIF Contacto</span></td>
              <td><input maxlength="10" title="Ingrese el rif del contacto" onKeyPress="return isRif(event,this.value)" onKeyUp="this.value=this.value.toUpperCase()" name="crif_personacontacto" id="crif_personacontacto" type="text" size="50" value="<?= $crif_personacontacto;?>" required /></td>
            </tr>
            <tr><td><span class="texto_form">Nombre Contacto</span></td>
              <td><input title="Ingrese el nombre de la persona contacto" onKeyUp="this.value=this.value.toUpperCase()" name="cnombrecontacto" id="cnombrecontacto" type="text" size="50" value="<?= $cnombrecontacto;?>" required /></td>
            </tr>
            <tr><td><span class="texto_form">Cargo</span></td>
              <td><input title="Ingrese el nombre del cargo" onKeyUp="this.value=this.value.toUpperCase()" name="ccargo" id="ccargo" type="text" size="50" value="<?= $ccargo;?>" required /></td>
            </tr>
          </tr>
            <tr>
              <td><span class="texto_form">Tel&eacute;fono</span></td>
              <td><input maxlength=11 title="Ingrese el n&uacute;mero de Tel&eacute;fono" onKeyPress="return isNumberKey(event)" name="ctelefono" id="ctelefono" type="text" size="50" value="<?= $ctelefono;?>" required /></td>
        </tr>

            <tr>
          <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
            <?php
              imprimir_boton($disabledRCcontacto,$disabledMDcontacto,$estatuscontacto,$servicios,"contacto");
            ?>        
                 </td>
            </tr>
          </table>    
       </form>
    </fieldset>
<br>
  <?php } else{ 
    $crif_personacontacto = $_GET['crif_personacontacto'];
    $cnombrecontacto = $_GET['cnombrecontacto'];
  ?>
   <script type="text/javascript">
  function reload_tabcontacto(tab){
    crif_personacontacto = document.getElementById('crif_personacontacto').value;
    cnombrecontacto = document.getElementById('cnombrecontacto').value;
        location.href="menu_principal.php?proveedor&l&crif_personacontacto="+crif_personacontacto+"&cnombrecontacto="+cnombrecontacto+tab;
  }
</script>

      <table border="0" style="width: 100%"> 
    <tr>
      <td><span class="texto_form">RIF o C&eacute;dula</span></td>
      <td>
        <input onKeyPress="return isRif(event)" onKeyUp="this.value=this.value.toUpperCase()" title="Ingrese la c&eacute;dula del contacto" name="crif_personacontacto" id="crif_personacontacto" type="text" size="10" value="<?= $crif_personacontacto;?>" />
      </td>
      <td><span class="texto_form">Nombre Contacto</span></td>
      <td><input title="Ingrese el nombre de la persona contacto" onKeyUp="this.value=this.value.toUpperCase()" name="cnombrecontacto" id="cnombrecontacto" type="text" size="50" value="<?= $cnombrecontacto;?>" required /></td>
    </tr>
  </table>
  <table align="center">  
    <tr>
      <td>
        <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabcontacto('#contacto')">
        <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
      </td>
    </tr>
  </table> 
  <a href="?proveedor#contacto"><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_personacontacto.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=contactoproveedor';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
     <table style="width:100%;" class="tablapaginacion">
           <tr style="background: #000; color:#FFF; width:100%;"> 
               <td style="width:20%;"> RIF o C&eacute;dula </td>
               <td align='left'>Nombre</td>
               <td align='left'>Tel&eacute;fono</td>
               <td align='left'>Cargo</td>
               <td align='left'>Direcci&oacute;n del Contacto</td>
           </tr>
         <?php

           //Conexión a la base de datos 
  require_once("../clases/class_bd.php");
  $pgsql=new Conexion();

$clausuleWhere = "WHERE p.crif_persona = '".$_SESSION['crif_personaproveedor']."'";
if($crif_personacontacto!="" && $cnombrecontacto!=""){
  $clausuleWhere.="AND pc.crif_persona LIKE '%$crif_personacontacto%' AND pc.cnombre LIKE '%$cnombrecontacto%'";
}
else if($crif_personacontacto!=""){
  $clausuleWhere.="AND pc.crif_persona LIKE '%$crif_personacontacto%'";
}
else if($cnombrecontacto!=""){
  $clausuleWhere.="AND pc.cnombre LIKE '%$cnombrecontacto%'";
}

//Sentencia sql (sin limit) 
$_pagi_sql = "SELECT pc.crif_persona crif_personacontacto,pc.cnombre,d.cdireccion,pc.ccargo,pc.ctelefono
FROM general.tpersona p 
INNER JOIN general.tdireccion_despacho d ON d.crif_persona = p.crif_persona 
INNER JOIN general.tpersona_contacto pc on pc.nid_direcciondespacho=d.nid_direcciondespacho 
$clausuleWhere 
ORDER BY pc.crif_persona DESC";
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
          echo "<tr  style='cursor: pointer;' id='".$row['crif_personacontacto']."' onclick='enviarFormS(this.id)'>
          <td style='width:20%;'>".$row['crif_personacontacto']."</td>    
          <td align='left'>".$row['cnombre']."</td>
          <td align='left'>".$row['ctelefono']."</td>
          <td align='left'>".$row['ccargo']."</td>
          <td align='left'>".$row['cdireccion']."</td>"; 
} 
//Incluimos la barra de navegación 
         ?>
       </table>
  <script type="text/javascript">
  function enviarFormS(value){
    document.getElementById('cdescripcion_oculto2').value=value;
    document.getElementById('form3').submit();
  }
  </script>
  <form id="form3" method="POST" action="../controladores/control_contactoproveedor.php">
    <input type="hidden" name="crif_personacontacto" id="cdescripcion_oculto2" value="" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
<div class="pagination">
       <ul>
           <?php echo"<li>".$_pagi_navegacion."</li>";?>
       </ul>
   </div>
  <?php }?>
</div>
