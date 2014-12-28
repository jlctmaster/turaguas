<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#nuevousuario" data-toggle="tab" id="tab-nuevousuario">Nuevo Usuario</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_usuario_nuevo.js"> </script>
    <div class="tab-pane active in" id="nuevousuario">
      <div class="form_externo" >
        <?php
        $servicios='nuevousuario';
        $disabledRC=null;
        $disabledMD=null;
        $estatus=null;
        if(!isset($_GET['l'])){ 
        ?>
        <fieldset style="padding: 30px">
          <form id="form1" name="form" action="../controladores/control_cambiar_clave.php" method="post" enctype="multipart/form-data">
            <table width="100%" border="0">
              <tr>
                <td>
                  <div align="right"><span class="texto_form">C&eacute;dula:</span></div>
                </td>
                <td>
                  <label>
                    <input name="cedula" id="cedula" value="" size="8" onKeyPress="return isRif(event)" onKeyUp="this.value=this.value.toUpperCase()" 
                    placeholder="ingrese la c&eacute;dula del nuevo usuario ej: V123456789" type="text" 
                    title="Por favor, ingrese la c&eacute;dula del nuevo usuario ej: V123456789" required /> 
                  </label>
                </td>
                <td>
                  <div align="right"><span class="texto_form">Perfil:</span></div>
                </td>
                <td>
                  <label>
                    <select name="perfil" id="perfil" title="Seleccione un perfil" required />
                      <?php 
                        include_once("../clases/class_html.php");
                        $html=new Html();
                        $id="nid_perfil";
                        $descripcion="cnombreperfil";
                        $sql="SELECT * FROM seguridad.tperfil WHERE dfecha_desactivacion IS NULL";
                        $Seleccionado='null';
                        $html->Generar_Opciones($sql,$id,$descripcion,$Seleccionado); 
                      ?>
                    </select>
                  </label>
                </td>
              </tr>
            </table>  
            <table style="width:100%" border="0">            
              <tr>
              <td align="center">
                <label>
                  <label>
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                    <?php
                      imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"nuevousuario");
                    ?> 
                  </label>
                </label>
              </td>
              </tr>
            </table>
          </form>
        </fieldset>
        <?php }else{ ?>
        <a href="./menu_principal.php?nuevousuario" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
        <table style="width:100%;" class="tablapaginacion">
          <tr style="background: #000; color:#FFF; width:100%;"> 
            <td style="width:25%;">Nombre Usuario </td>
            <td align='left'>Perfil de usuario</td>
            <td align='left'>Estatus</td>
          </tr>
          <?php

          //Conexión a la base de datos 
          require_once("../clases/class_bd.php");
          $pgsql=new Conexion();
          //Sentencia sql (sin limit) 
          $_pagi_sql = "SELECT u.cnombreusuario,tp.cnombreperfil,
          CASE WHEN (u.dfecha_desactivacion IS NULL) THEN 'Activo' ELSE 'Desactivado' END as estado 
          FROM seguridad.tusuario u INNER JOIN seguridad.tperfil tp on tp.nid_perfil=u.nid_perfil 
          ORDER BY cnombreusuario ASC"; 
          //Booleano. Define si se utiliza pg_num_rows() (true) o COUNT(*) (false).
          $_pagi_conteo_alternativo = true;
          //cantidad de resultados por página (opcional, por defecto 20) 
          $_pagi_cuantos = 15; 
          //Cadena que separa los enlaces numéricos en la barra de navegación entre páginas.
          $_pagi_separador = " ";
          //Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación.
          $_pagi_nav_num_enlaces=5;
          //Incluimos el script de paginación. Éste ya ejecuta la consulta automáticamente 
          @include("../librerias/paginador/paginator.inc.php");
          //Leemos y escribimos los registros de la página actual 
          while($row = pg_fetch_array($_pagi_result)){ 
            echo "<tr>
            <td style='width:20%;'>".$row['cnombreusuario']."</td>
            <td align='left'>".$row['cnombreperfil']."</td>
            <td align='left' class='".$row['estado']."'>".$row['estado']."</td>
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
</div>