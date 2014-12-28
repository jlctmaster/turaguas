<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tipodocumento" data-toggle="tab">Tipo de Documento</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div class="tab-pane active" id="tipodocumento">
      <div class="form_externo" >
        <?php
        if(isset($_SESSION['datos']['cdescripcion'])){ 
          $disabledRC='disabled';
          $disabledMD='';
          $estatus=null;
        }else {
          $disabledRC='';
          $disabledMD='disabled';
        }
        $servicios='tipodocumento';
        if(isset($_SESSION['datos'])){
          @$cdescripcion=$_SESSION['datos']['cdescripcion'];
          @$nid_tipodocumento=$_SESSION['datos']['nid_tipodocumento'];
          @$nfactor=$_SESSION['datos']['nfactor'];
          @$ctipo_transaccion=$_SESSION['datos']['ctipo_transaccion'];
          @$estatus=$_SESSION['datos']['estatus'];
        }
        else{
          @$cdescripcion=$_GET['cdescripcion'];
          @$nid_tipodocumento=$_GET['nid_tipodocumento'];
          @$nfactor=$_GET['nfactor'];
          @$ctipo_transaccion=$_GET['ctipo_transaccion'];
          @$estatus=$_GET['estatus'];
        }
        ?>
        <br><br>
          <?php if(!isset($_GET['l'])){?>
        <script src="../js/eft_tipodocumento.js"> </script>
             <fieldset>
                  <form action="../controladores/control_tipodocumento.php" method="post" id="form1">
                <table border="0" style="width: 100%">
                    <tr>
                      <td><span class="texto_form">Código </span></td>
                      <td><input title="El código del tipo de documento es generado por el sistema" name="nid_tipodocumento" id="nid_tipodocumento" type="text" size="10" readonly value="<?= $nid_tipodocumento;?>" /> </td><tr>
                    <tr>
                      <td><span class="texto_form">Típo de documento </span></td><td> <input title="Ingrese el tipo de documento" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripcion;?>" required></td>
                    </tr>
                    <tr><td><span class="texto_form">Factor </span></td>
                      <td>
                        <select name="nfactor" id="nfactor" title="Seleccione el factor" requiere title="Seleccione el factor"/>
                          <option value='0'>Seleccione un factor</option>
                          <option value='1'<? if($nfactor=="1"){ echo "selected";}?>>Positivo</option>
                          <option value='-1'<? if($nfactor=="-1"){ echo "selected";}?>>Negativo</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><span class="texto_form"></span></td>
                      <td>
                        <input type="checkbox" name="ctipo_transaccion" id="ctipo_transaccion" <? if($ctipo_transaccion=="V"){echo "checked='checked'";}?>/> Transacción de Ventas
                      </td>
                    </tr>
                    <?php echo '<tr><td colspan="2" class="'.$estatus.'" id="estatus_registro">'.$estatus.'</td></tr>'; ?>
                     <tr>
                         <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                              <?php
                              imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"tipodocumento");
                             ?>         
                         </td>
                    </tr>
                  </table>    
               </form>
            </fieldset>
        <br>
          <?php }else{
          //en esta sección mostramos el listar.
          //recibimos los valores de filtro para mostrar los registros paginados.
              $cdescripcion = $_GET['cdescripcion'];
          //la funcion reload_page() vuelve a llamar el servicio y manda por url los valores de los datos filtrados.
            ?>

          <script type="text/javascript">
          function reload_page(){
            cdescripcion = document.getElementById('cdescripcion').value;
            location.href="menu_principal.php?tipodocumento&l&cdescripcion="+cdescripcion;
          }
        </script>

        <table border="0" style="width: 100%"> 
           <tr>
            <td><span class="texto_form">Tipo de documento</span></td>
          </tr>
          <tr>
            <td>
              <input title="Ingrese el nombre del tipo de documento" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripcion;?>" />
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

          <a href="?tipodocumento" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
          <a href="../excel/excel_tipodocumento.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
          <a href="<?php echo  '../pdf/?serv=tipodocumento';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
             <table style="width:100%;" class="tablapaginacion">
                   <tr style="background: #000; color:#FFF; width:100%;"> 
                       <td style="width:20%;">C&oacute;digo </td>
                       <td align='left'>Tipo de documento</td>
                       <td align='left'>Factor</td>
                       <td align='left'>Tipo de Transacción</td>
                   </tr>
                 <?php
          //En esta sección hacemos uso de la clase paginator.inc.php, enviando los campos obligatorios que requiere la clase.
                   //Conexión a la base de datos 
          require_once("../clases/class_bd.php");
          $pgsql=new Conexion();

        $clausuleWhere = "";
        if($cdescripcion!=""){
          $clausuleWhere.="WHERE cdescripcion LIKE '%$cdescripcion%'";
        }

        //Sentencia sql (sin limit) 
        $_pagi_sql = "SELECT cdescripcion,nid_tipodocumento as id, 
        CASE nfactor WHEN -1 THEN 'EGRESO' ELSE 'INGRESO' END factor,
        CASE ctipo_transaccion WHEN 'C' THEN 'COMPRA' ELSE 'VENTA' END tipo_transaccion
        FROM facturacion.ttipo_documento
        $clausuleWhere 
        ORDER BY cdescripcion ASC";
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
                      <td style='width:20%;'>".$row['id']."</td>
                      <td align='left'>".$row['cdescripcion']."</td>
                      <td align='left'>".$row['factor']."</td>
                      <td align='left'>".$row['tipo_transaccion']."</td>
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
  <form id="form1" method="POST" action="../controladores/control_tipodocumento.php">
    <input type="hidden" name="cdescripcion" id="cdescripcion_oculto" value="" />
    <input type="hidden" name="operacion" id="operacion" value="Consultar" />
  </form>
        <div class="pagination">
               <ul>
                   <?php echo"<li>".$_pagi_navegacion."</li>";?>
               </ul>
           </div>
        </div>
          <?php }?>
    </div>
  </div>
</div>