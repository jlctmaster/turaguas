<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#formulario" data-toggle="tab" id="tab-formulario">Formularios</a></li>
    <li><a href="#pestana" data-toggle="tab" id="tab-pestana">Pestañas</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_formulario.js"> </script>
    <div class="tab-pane active" id="formulario">
      <div class="form_externo" >
        <?php
          if(isset($_SESSION['datos']['cnombreformulario'])){ 
            $disabledRCForm='disabled';
            $disabledMDForm='';
            $estatus_formularios=null;
          }else {
            $disabledRCForm='';
            $disabledMDForm='disabled';
          }
          $formularios='formulario';
          if(isset($_SESSION['datos'])){
            @$cnombreformulario=$_SESSION['datos']['cnombreformulario'];
            @$nid_formulario=$_SESSION['datos']['nid_formulario'];
            @$nid_modulo=$_SESSION['datos']['nid_modulo'];
            @$curl=$_SESSION['datos']['curl'];
            @$norden=$_SESSION['datos']['norden'];
            @$estatus_formularios=$_SESSION['datos']['estatus_formularios'];
          }
          else{
            @$cnombreformulario=null;
            @$nid_formulario=null;
            @$nid_modulo=null;
            @$curl=null;
            @$norden=null;
            @$estatus_formularios=null;
          }
          if(!isset($_GET['l'])){
        ?>
        <fieldset style="padding: 30px">
          <form action="../controladores/control_formulario.php" method="post" id="form1">
            <table border="0" style="width: 100%"> 
              <tr>
                <td><span class="texto_form">C&oacute;digo</span></td>
                <td><input title="El c&oacute;digo del formulario es generado por el sistema" name="nid_formulario" id="nid_formulario" type="text" readonly value="<?= $nid_formulario;?>" /> </td>
              </tr>
              <tr>
                <td><span class="texto_form">Formulario</span></td>
                <td><input title="Ingrese el nombre del formulario" onKeyUp="this.value=this.value.toUpperCase()" name="cnombreformulario" id="cnombreformulario" type="text" value="<?= $cnombreformulario;?>" required/></td>
              </tr>
              <tr>
                <td><span class="texto_form">Url del Formulario</span></td>
                <td><input title="Ingrese la url del formulario" onKeyUp="this.value=this.value.toUpperCase()" name="curl" id="curl" type="text" value="<?= $curl;?>" required/></td>
              </tr>
              <tr>
                <td><span class="texto_form">Órden</span></td>
                <td><input title="Ingrese el órden del formulario" onKeyPress="return isNumberKey(event)" maxlength=2 name="norden" id="norden" type="text" value="<?= $norden;?>" required/></td>
              </tr>
              <tr>
                <td><span class="texto_form">M&oacute;dulo</span></td>
                <td>
                  <select name="nid_modulo" id="nid_modulo" title="Seleccione un m&oacute;dulo" required/>
                    <option value='0'>Seleccione un M&oacute;dulo</option>
                    <?php
                      require_once("../clases/class_bd.php");
                      $pgsql=new Conexion();
                      $sql = "SELECT nid_modulo, cnombremodulo FROM seguridad.tmodulo WHERE dfecha_desactivacion IS NULL ORDER BY nid_modulo";
                      $query = $pgsql->Ejecutar($sql);
                      while ($row = $pgsql->Respuesta($query)){
                        if($row['nid_modulo']==$nid_modulo){
                          echo "<option value='".$row['nid_modulo']."' selected>".$row['cnombremodulo']."</option>";
                        }else{
                          echo "<option value='".$row['nid_modulo']."'>".$row['cnombremodulo']."</option>";
                        }
                      }
                    ?>
                  </select>
                </td>
              </tr>
              <?php echo '<tr><td colspan="2" class="'.$estatus_formularios.'" id="estatus_registro">'.$estatus_formularios.'</td></tr>'; ?>
              <tr>
                <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                  <?php
                    imprimir_boton($disabledRCForm,$disabledMDForm,$estatus_formularios,$formularios,"formulario");
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
          $cnombreformulario = $_GET['cnombreformulario'];
          $nid_modulo = $_GET['nid_modulo'];
          //la funcion reload_page() vuelve a llamar el servicio y manda por url los valores de los datos filtrados.
        ?>
        <script type="text/javascript">
          function reload_page(){
            cnombreformulario = document.getElementById('cnombreformulario').value;
            nid_modulo=document.getElementById('nid_modulo').value;
            location.href="menu_principal.php?formulario&l&cnombreformulario="+cnombreformulario+"&nid_modulo="+nid_modulo+"#formulario";
          }
        </script>
        <table border="0" style="width: 100%"> 
          <tr>
            <td><span class="texto_form">Formulario</span></td>
            <td><input title="Ingrese el nombre del formulario" onKeyUp="this.value=this.value.toUpperCase()" name="cnombreformulario" 
            id="cnombreformulario" type="text" value="<?= $cnombreformulario;?>"/></td>
            <td><span class="texto_form">M&oacute;dulo</span></td>
            <td>
              <select name="nid_modulo" id="nid_modulo" title="Seleccione un m&oacute;dulo"/>
                <option value=''>Seleccione un M&oacute;dulo</option>
                  <?php
                  require_once("../clases/class_bd.php");
                  $pgsql=new Conexion();
                  $sql = "SELECT nid_modulo, cnombremodulo FROM seguridad.tmodulo WHERE dfecha_desactivacion IS NULL ORDER BY nid_modulo";
                  $query = $pgsql->Ejecutar($sql);
                  while ($row = $pgsql->Respuesta($query)){
                    if($row['nid_modulo']==$nid_modulo){
                      echo "<option value='".$row['nid_modulo']."' selected>".$row['cnombremodulo']."</option>";
                    }else{
                      echo "<option value='".$row['nid_modulo']."'>".$row['cnombremodulo']."</option>";
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
        <a href="?formulario#formulario" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
        <a href="../excel/excel_formulario.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
        <a href="<?php echo  '../pdf/?serv=formulario';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
        <table style="width:100%;" class="tablapaginacion">
          <tr style="background: #000; color:#FFF; width:100%;"> 
            <td style="width:20%;">Código </td>
            <td align='left'>Nombre Formulario</td>
            <td align='left'>Url Formulario</td>
            <td align='left'>Código Módulo</td>
            <td align='left'>Nombre Módulo</td>
          </tr>
          <?php
            //En esta sección hacemos uso de la clase paginator.inc.php, enviando los campos obligatorios que requiere la clase.
            //Conexión a la base de datos 
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            $clausuleWhere = "";
            if($cnombreformulario!=""){
              $clausuleWhere.="WHERE f.cnombreformulario LIKE '%$cnombreformulario%' AND f.dfecha_desactivacion IS NULL ";
            }
            elseif($nid_modulo!=""){
              if($clausuleWhere==""){
                $clausuleWhere.="WHERE f.nid_modulo = '$nid_modulo' AND f.dfecha_desactivacion IS NULL";
              }
              else{
                $clausuleWhere.="AND f.nid_modulo = '$nid_modulo' AND f.dfecha_desactivacion IS NULL ";
              }
            }
            else{
              $clausuleWhere.=" WHERE f.dfecha_desactivacion IS NULL ";
            }
            //Sentencia sql (sin limit) 
            $_pagi_sql = "SELECT f.nid_formulario,f.cnombreformulario,f.curl,m.nid_modulo,m.cnombremodulo 
            FROM seguridad.tformulario f 
            INNER JOIN seguridad.tmodulo m ON f.nid_modulo = m.nid_modulo 
            $clausuleWhere
            ORDER BY f.nid_formulario DESC"; 
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
            echo "<tr><td style='width:20%;'>".$row['nid_formulario']."</td>
              <td align='left'>".$row['cnombreformulario']."</td>
              <td align='left'>".$row['curl']."</td>
              <td align='left'>".$row['nid_modulo']."</td>
              <td align='left'>".$row['cnombremodulo']."</td></tr>"; 
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
    <div class="tab-pane" id="pestana">
      <div class="form_externo" >
        <?php
          if(!empty($nid_formulario) && !empty($cnombreformulario)){
            $_SESSION['cnombreformulario']= $cnombreformulario;
            $_SESSION['nid_formulario']=$nid_formulario;
          }
          if(isset($_SESSION['datos']['cnombreservicio'])){ 
            $disabledRCPest='disabled';
            $disabledMDPest='';
            $estatus_servicios=null;
          }else {
            $disabledRCPest='';
            $disabledMDPest='disabled';
          }
          $formularios='formulario';
          if(isset($_SESSION['datos'])){
            @$cnombreservicio=$_SESSION['datos']['cnombreservicio'];
            @$nid_servicio=$_SESSION['datos']['nid_servicio'];
            @$nid_formulario=$_SESSION['datos']['nid_formulario'];
            @$cnombreformulario=$_SESSION['datos']['cnombreformulario'];
            @$estatus_servicios=$_SESSION['datos']['estatus_servicios'];
          }
          else{
            @$cnombreservicio=null;
            @$nid_servicio=null;
            @$nid_formulario=null;
            @$cnombreformulario=null;
            @$estatus_servicios=null;
          }
          if(!isset($_GET['l'])){
        ?>
        <fieldset style="padding: 30px">
          <form action="../controladores/control_servicio.php" method="post" id="form2">
            <table border="0" style="width: 100%"> 
              <tr>
                <td><span class="texto_form">Formulario</span></td>
                <td>
                <?php if(!empty($nid_formulario)){?>
                  <input type="hidden" id="nid_formulario" name="nid_formulario" value="<?= $nid_formulario; ?>">
                  <input title="El código del formulario proviene de la pestaña anterior" name="name_formulario" id="name_formulario" type="text" readonly value="<?= $nid_formulario."_".$cnombreformulario;?>" /> 
                <?php }else{?>
                  <input type="hidden" id="nid_formulario" name="nid_formulario" value="<?= $_SESSION['nid_formulario']; ?>">
                  <input title="El código del formulario proviene de la pestaña anterior" name="name_formulario" id="name_formulario" type="text" readonly value="<?= $_SESSION['nid_formulario']."_".$_SESSION['cnombreformulario'];?>" /> 
                <?php } ?>
                </td>
              </tr>
              <tr>
                <td><span class="texto_form">Código</span></td>
                <td><input title="El c&oacute;digo del formulario es generado por el sistema" onKeyUp="this.value=this.value.toUpperCase()" name="nid_servicio" id="nid_servicio" type="text" readonly value="<?= $nid_servicio;?>" /></td>
              </tr>
              <tr>
                <td><span class="texto_form">Pestaña</span></td>
                <td><input title="Ingrese el nombre de la pestaña del formulario" onKeyUp="this.value=this.value.toUpperCase()" name="cnombreservicio" id="cnombreservicio" type="text" value="<?= $cnombreservicio;?>" required/></td>
              </tr>
              <?php echo '<tr><td colspan="2" class="'.$estatus_servicios.'" id="estatus_registro">'.$estatus_servicios.'</td></tr>'; ?>
              <tr>
                <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                  <?php
                    imprimir_boton($disabledRCPest,$disabledMDPest,$estatus_servicios,$formularios,"pestana");
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
          $cnombreservicio = $_GET['cnombreservicio'];
          //la funcion reload_page() vuelve a llamar el servicio y manda por url los valores de los datos filtrados.
        ?>
        <script type="text/javascript">
          function reload_tabpestana(){
            cnombreservicio = document.getElementById('cnombreservicio').value;
            location.href="menu_principal.php?formulario&l&cnombreservicio="+cnombreservicio+"#pestana";
          }
        </script>
        <table border="0" style="width: 100%"> 
          <tr>
            <td><span class="texto_form">Pestaña</span></td>
          </tr>
          <tr>
            <td>
              <input title="Ingrese el nombre de la pestaña a consultar" onKeyUp="this.value=this.value.toUpperCase()" name="cnombreservicio" id="cnombreservicio" type="text" size="50" value="<?= $cnombreservicio;?>" />
            </td>
          </tr>
        </table>
        <table align="center">  
          <tr>
            <td>
              <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabpestana()">
              <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
            </td>
          </tr>
        </table> 
        <a href="?formulario#pestana" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
        <a href="../excel/excel_pestana.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
        <a href="<?php echo  '../pdf/?serv=pestana';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
        <table style="width:100%;" class="tablapaginacion">
          <tr style="background: #000; color:#FFF; width:100%;"> 
            <td style="width:20%;">C&oacute;digo </td>
            <td align='left'>Pestaña</td>
            <td align='left'>C&oacute;digo Formulario</td>
            <td align='left'>Formulario</td>
          </tr>
          <?php
            //En esta sección hacemos uso de la clase paginator.inc.php, enviando los campos obligatorios que requiere la clase.
            //Conexión a la base de datos 
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            $clausuleWhere = "";
            if($cnombreservicio!=""){
              $clausuleWhere.="WHERE s.cnombreservicio LIKE '%$cnombreservicio%' AND s.nid_formulario = '".$_SESSION['nid_formulario']."' AND s.dfecha_desactivacion IS NULL ";
            }
            else{
              $clausuleWhere.="WHERE s.nid_formulario = '".$_SESSION['nid_formulario']."' AND s.dfecha_desactivacion IS NULL ";
            }
            //Sentencia sql (sin limit) 
            $_pagi_sql = "SELECT s.nid_servicio,s.cnombreservicio,f.nid_formulario,f.cnombreformulario 
            FROM seguridad.tservicio s 
            INNER JOIN seguridad.tformulario f ON s.nid_formulario = f.nid_formulario 
            $clausuleWhere 
            ORDER BY s.nid_servicio DESC"; 
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
            echo "<tr><td style='width:20%;'>".$row['nid_servicio']."</td>
              <td align='left'>".$row['cnombreservicio']."</td>
              <td align='left'>".$row['nid_formulario']."</td>
              <td align='left'>".$row['cnombreformulario']."</td></tr>"; 
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