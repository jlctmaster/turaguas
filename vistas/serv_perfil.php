<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#perfiles" data-toggle="tab">Perfil</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div class="tab-pane active" id="perfiles">
      <div class="form_externo_perfil" >
        <?php
        if(isset($_SESSION['datos']['cnombreperfil'])){ 
          $disabledRC='disabled';//para desactivar el boton registrar y consultar (RC)
          $disabledMD='';//para activar el boton Modificar y Desactivar (MD)
        }else {
          $disabledRC='';//para activar el boton registrar y consultar (RC)
          $disabledMD='disabled'; //para desactivar el boton Modificar y Desactivar (MD)
        }
        $servicios='perfiles';
        if(isset($_SESSION['datos'])){
          @$cnombreperfil=$_SESSION['datos']['cnombreperfil'];
          @$nid_perfil=$_SESSION['datos']['nid_perfil'];
          @$nid_configuracion=$_SESSION['datos']['nid_configuracion'];
          @$estatus=$_SESSION['datos']['estatus'];
        }
        else{
          $cnombreperfil=null;
          $nid_perfil=null;
          $nid_configuracion=null;
          $estatus=null;
        }
        if(!isset($_GET['l'])){?>
          <script src="../js/eft_perfil.js"> </script>
          <fieldset style="padding: 5px">
            <form action="../controladores/control_perfil.php" method="post" id="form1">
            <table border="0" style="width: 100%"> 
              <tr>
                <td style="width:40%;padding-right:2em"><span class="texto_form">Perfil de Usuario:</span></td>
                <td align="left">
                  <input title="el c&oacute;digo del perfil es generado por el sistema" style="width:3em" name="nid_perfil" id="nid_perfil" type="text" size=5 readonly value="<?= $nid_perfil;?>" /> 
                  <input title="Ingrese el nombre del perfil de usuario" onKeyUp="this.value=this.value.toUpperCase()" name="cnombreperfil" id="cnombreperfil" type="text" value="<?= $cnombreperfil;?>" required />
                </td>
              </tr>
              <tr>
                <td style="width:40%;padding-right:2em"><span class="texto_form">Tipo de Configuración:</span></td>
                <td align="left">
                  <select id="nid_configuracion" name="nid_configuracion" title="Seleccione una Configuración" required />
                    <option value='0'>Seleccione una Configuración</option>
                    <?php
                      require_once("../clases/class_bd.php");
                      $pgsql=new Conexion();
                      $sql = "SELECT nid_configuracion,cdescripcion FROM seguridad.tconfiguracion ORDER BY nid_configuracion ASC";
                      $query = $pgsql->Ejecutar($sql);
                      while ($row = $pgsql->Respuesta($query)){
                        if($row['nid_configuracion']==$nid_configuracion){
                          echo "<option value='".$row['nid_configuracion']."' selected>".$row['cdescripcion']."</option>";
                        }else{
                          echo "<option value='".$row['nid_configuracion']."'>".$row['cdescripcion']."</option>";
                        }
                      }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                  <center>
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                    <?php
                      imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"perfiles");
                    ?>
                  </center>
                </td>
              </tr>
            </table>
            <?php 
              include_once('../clases/class_html.php');
              $html=new Html();
              $html->configurar_menu($nid_perfil);   
            ?>    
            </form>
          </fieldset>
        <?php }else{ 
        $cnombreperfil = $_GET['cnombreperfil'];
        ?>
        <script type="text/javascript">
        function reload_page(){
          cnombreperfil = document.getElementById('cnombreperfil').value;
          location.href="menu_principal.php?perfiles&l&cnombreperfil="+cnombreperfil;
        }
        </script>
        <table border="0" style="width: 100%"> 
          <tr>
            <td><span class="texto_form">Perfil de Usuario</span></td>
          </tr>
          <tr>
            <td><input title="Ingrese el nombre del perfil de usuario" onKeyUp="this.value=this.value.toUpperCase()" name="cnombreperfil" id="cnombreperfil" type="text" value="<?= $cnombreperfil;?>"/></td>
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
        <a href="?perfiles#perfiles" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
        <a href="../excel/excel_perfil.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
        <a href="<?php echo  '../pdf/?serv=perfil';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
        <table style="width:100%;" class="tablapaginacion">
          <tr style="background: #000; color:#FFF; width:100%;"> 
            <td style="width:25%;"> Código </td>
            <td align='left'>Perfil de Usuario</td>
            <td align='left'>Código Configuración</td>
            <td align='left'>Configuración</td>
          </tr>
          <?php
          //Conexión a la base de datos 
          include_once("../clases/class_bd.php");
          $pgsql=new Conexion();
          $clausuleWhere="WHERE p.dfecha_desactivacion IS NULL ";
          if($cnombreperfil!=""){
            $clausuleWhere.="AND p.cnombreperfil LIKE '%$cnombreperfil%'";
          }
          //Sentencia sql (sin limit) 
          $_pagi_sql = "SELECT p.nid_perfil,p.cnombreperfil,p.nid_configuracion,c.cdescripcion 
          FROM seguridad.tperfil p 
          INNER JOIN seguridad.tconfiguracion c ON p.nid_configuracion = c.nid_configuracion 
          $clausuleWhere
          ORDER BY p.nid_perfil DESC"; 
          //Booleano. Define si se utiliza pg_num_rows() (true) o COUNT(*) (false).
          $_pagi_conteo_alternativo = true;
          //cantidad de resultados por página (opcional, por defecto 20) 
          $_pagi_cuantos = 10; 
          //Cadena que separa los enlaces numéricos en la barra de navegación entre páginas.
          $_pagi_separador = " ";
          //Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
          $_pagi_nav_num_enlaces=5;
          //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente 
          @include_once("../librerias/paginador/paginator.inc.php"); 
          //Leemos y escribimos los registros de la página actual 
          while($row = pg_fetch_array($_pagi_result)){ 
          echo "<tr>
                  <td style='width:20%;'>".$row['nid_perfil']."</td>
                  <td align='left'>".$row['cnombreperfil']."</td>
                  <td align='left'>".$row['nid_configuracion']."</td>
                  <td align='left'>".$row['cdescripcion']."</td>
                </tr>"; 
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