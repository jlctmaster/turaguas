<?php
if(isset($_SESSION['datos']['cdescripcion'])){ 
                 $disabledRC='disabled';
                  $disabledMD='';
                  $estatus=null;
                }else {
                     $disabledRC='';
                     $disabledMD='disabled';
                	}
                  $servicios='tipopersona';
if(isset($_SESSION['datos'])){
            @$cdescripcion=$_SESSION['datos']['cdescripcion'];
            @$nid_tipopersona=$_SESSION['datos']['nid_tipopersona'];
            @$estatus=$_SESSION['datos']['estatus'];
            }
       else{
            @$cdescripcion=null;
            @$nid_tipopersona=null;
            @$estatus=null;
            }
?>
<br><br>
  <?php if(!isset($_GET['l'])){?>
<div class="form_externo" >
<script src="../js/eft_tipopersona.js"> </script>
     <fieldset style="padding: 30px">
      <legend>Tipo de Persona</legend>
          <form action="../controladores/control_tipopersona.php" method="post" id="form">
        <table border="0" style="width: 100%">

            <tr><td>Código </td><td><input title="El código del tipo de persona es generado por el sistema" name="nid_tipopersona" id="nid_tipopersona" type="text" size="10" readonly value="<?= $nid_tipopersona;?>" /> </td><tr>
             <tr><td>Descripción</td><td> <input title="Ingrese la descripción del tipo de persona" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripcion;?>" required>
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
  <?php }else{ ?>
  <a href="?pais" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
  <a href="../excel/excel_pais.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
  <a href="<?php echo  '../pdf/?serv=tipopersona';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
     <table style="width:100%;" class="tablapaginacion">
           <tr style="background: #000; color:#FFF; width:100%;"> 
               <td style="width:25%;"> Codigo </td>
               <td align='left'>Nombre</td>
           </tr>
         <?php

           //Conexión a la base de datos 
  require_once("../clases/class_bd.php");
  $mysql=new Conexion();

//Sentencia sql (sin limit) 
$_pagi_sql = "SELECT * FROM tpais where fecha_desactivacion is null order by nid_localidad desc"; 
//cantidad de resultados por página (opcional, por defecto 20) 
$_pagi_cuantos = 10; 
//Cadena que separa los enlaces numéricos en la barra de navegación entre páginas.
$_pagi_separador = " ";
//Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
$_pagi_nav_num_enlaces=5;
//Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente 
@include("../librerias/paginador/paginator.inc.php"); 

//Leemos y escribimos los registros de la página actual 
while($row = mysql_fetch_array($_pagi_result)){ 
    echo "<tr><td style='width:20%;'>".$row['nid_localidad']."</td><td align='left'>".$row['cdescripcion']."</td></tr>"; 
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