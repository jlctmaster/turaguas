<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#desbloquearusuario" data-toggle="tab" id="tab-desbloquearusuario">Desbloquear Usuarios</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div class="tab-pane active in" id="desbloquearusuario">
      <div class="form_externo">
        <fieldset style="padding: 30px">
          <form action="../controladores/control_desbloquearusuario.php" method="post" id="form">
            <table border="1" style="width: 100%">
            <tr style="background: #000; color:#FFF; width:100%;">
              <td>Seleccione</td>
              <td>Nombre de Usuario</td>
              <td>C&eacute;dula</td>
              <td>Nombres y Apellidos</td>
              <td>Fecha de Bloqueo</td>
              <td>Intentos Realizados</td>
            </tr>
            <?php
            //Conexión a la base de datos 
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            //Sentencia sql (sin limit) 
            $_pagi_sql = "SELECT u.cnombreusuario,u.ccedula,p.cnombre,c.dmodificado_desde,u.nintentos_fallidos 
            FROM seguridad.tusuario u 
            INNER JOIN general.tpersona p ON u.ccedula = p.crif_persona 
            INNER JOIN seguridad.tcontrasena c ON u.cnombreusuario = c.cnombreusuario 
            WHERE c.nestado = 4 
            ORDER BY c.dmodificado_desde ASC"; 
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
            echo "<tr><td><input type='checkbox' name='bloqueados[]' value='".$row['cnombreusuario']."'></td>";
            echo "<td>".$row['cnombreusuario']."</td>";
            echo "<td>".$row['ccedula']."</td>";
            echo "<td>".$row['cnombre']."</td>";
            echo "<td>".$row['dmodificado_desde']."</td>";
            echo "<td>".$row['nintentos_fallidos']."</td></tr>";
            }
            ?>
            </table>
            <table>
            <tr>
            <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
            <input type="hidden" name="operacion" value="DesbloquearUsuario" id="operacion" />
            <input type="submit" class="btn btn-default" value="Desbloquear Usuarios">         
            </td>
            </tr>
            </table>
            <div class="pagination">
              <ul>
                <?php echo"<li>".$_pagi_navegacion."</li>";?>
              </ul>
            </div>  
          </form>
        </fieldset>
      </div>
    </div>
  </div>
</div>