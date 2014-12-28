<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#botonera" data-toggle="tab" id="tab-botonera">Botones</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_opcion.js"> </script>
    <div class="tab-pane active in" id="botonera">
      <div class="form_externo" >
        <?php
        if(isset($_SESSION['datos']['cnombreopcion'])){ 
          $disabledRC='disabled';
          $disabledMD='';
          $estatus=null;
        }else {
          $disabledRC='';
          $disabledMD='disabled';
        }
        $servicios='botones';
        if(isset($_SESSION['datos'])){
          @$cnombreopcion=$_SESSION['datos']['cnombreopcion'];
          @$nid_opcion=$_SESSION['datos']['nid_opcion'];
          @$estatus=$_SESSION['datos']['estatus'];
          @$norden=$_SESSION['datos']['norden'];
        }
        else{
          @$cnombreopcion=null;
          @$nid_opcion=null;
          @$estatus=null;
          @$norden=null;
        }
        if(!isset($_GET['l'])){?>
        <fieldset style="padding: 30px">
          <form action="../controladores/control_opcion.php" method="post" id="form1">
            <table border="0" style="width: 100%"> 
              <tr>
                <td><span class="texto_form">Código</span></td>
                <td><input title="El código del botón es generado por el sistema" name="nid_opcion" id="nid_opcion" type="text" size="10" readonly value="<?= $nid_opcion;?>" required /> </td>
              </tr>
              <tr>
                <td><span class="texto_form">Botón</span></td>
                <td><input title="Ingrese el nombre del botón" onKeyUp="this.value=this.value.toUpperCase()" name="cnombreopcion" id="cnombreopcion" type="text" size="50" value="<?= $cnombreopcion;?>" required />
              </tr>
              <tr>
                <td><span class="texto_form">¿Qué acción va a realizar este botón?</span></td>
                <td> 
                  <select  name="norden" id="norden" title="Seleccione una acci&oacute;n" required >
                    <option <?php  if(!is_null($norden) and $norden==0) echo "selected"; ?> value="0">Sin acción</option>
                    <option <?php  if(!is_null($norden) and $norden==1) echo "selected"; ?> value="1">Insertar,Incluir,Registrar,Guardar</option>
                    <option <?php  if(!is_null($norden) and $norden==2) echo "selected"; ?> value="2">Modificar,Actualizar,Guardar</option>
                    <option <?php  if(!is_null($norden) and $norden==3) echo "selected"; ?> value="3">Desactivar,Deshabilitar</option>
                    <option <?php  if(!is_null($norden) and $norden==4) echo "selected"; ?> value="4">Activar,Habilitar</option>
                    <option <?php  if(!is_null($norden) and $norden==5) echo "selected"; ?> value="5">Buscar,Consultar</option>
                    <option <?php  if(!is_null($norden) and $norden==6) echo "selected"; ?> value="6">Cancelar,Deshacer </option>
                    <option <?php  if(!is_null($norden) and $norden==7) echo "selected"; ?> value="7">Listar,Mostrar,Imprimir</option>
                    <option <?php  if(!is_null($norden) and $norden==8) echo "selected"; ?> value="8">Aceptar</option>
                  </select>  
                </td>
              </tr>      
              <?php echo '<tr><td colspan="2" class="'.$estatus.'" id="estatus_registro">'.$estatus.'</td></tr>'; ?>           
              <tr>
                <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                  <?php
                    imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"botonera");
                  ?>                 
                </td>
              </tr>
            </table>    
          </form>
        </fieldset>
        <br>
        <?php }else{
        $cnombreopcion = $_GET['cnombreopcion'];
        ?>
        <script type="text/javascript">
          function reload_tabboton(tab){
            cnombreopcion = document.getElementById('cnombreopcion').value;
            location.href="menu_principal.php?botones&l&cnombreopcion="+cnombreopcion+tab;
          }
        </script>
        <table border="0" style="width: 100%"> 
          <tr>
            <td><span class="texto_form">Botón</span></td>
          </tr>
          <tr>
            <td><input title="Ingrese el nombre de la ciudad" onKeyUp="this.value=this.value.toUpperCase()" name="cnombreopcion" id="cnombreopcion" type="text" size="50" value="<?= $cnombreopcion;?>" /></td>
          </tr>
        </table>
        <table align="center">  
          <tr>
            <td>
              <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabboton('#botonera')">
              <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
            </td>
          </tr>
        </table> 
        <a href="./menu_principal.php?botones#botonera" ><img src="../images/cerrar.png" alt="Volver Atras" style="width:40px;heigth:40px;float:right;"></a>
        <a href="../excel/excel_boton.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
        <a href="<?php echo  '../pdf/?serv=boton';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
        <table style="width:100%;" class="tablapaginacion">
          <tr style="background: #000; color:#FFF; width:100%;"> 
            <td style="width:25%;"> Código </td>
            <td align='left'>Botón</td>
            <td align='left'>Órden</td>
          </tr>
          <?php
          //Conexión a la base de datos 
          require_once("../clases/class_bd.php");
          $pgsql=new Conexion();
          $clausuleWhere="WHERE dfecha_desactivacion IS NULL ";
          if($cnombreopcion!=""){
            $clausuleWhere.="AND cnombreopcion LIKE '%$cnombreopcion%'";
          }
          //Sentencia sql (sin limit) 
          $_pagi_sql = "SELECT * FROM seguridad.topcion $clausuleWhere ORDER BY nid_opcion DESC"; 
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
          echo "<tr><td style='width:20%;'>".$row['nid_opcion']."</td>
            <td align='left'>".$row['cnombreopcion']."</td>
            <td align='left'>".$row['norden']."</td></tr>"; 
          } 
          //Incluimos la barra de navegación
          ?>
        </table>
        <div class="pagination">
          <ul>
            <?php echo"<li>".$_pagi_navegacion."</li>";?>
          </ul>
        </div>
        <?php }?>
      </div>
    </div>
  </div>
</div>