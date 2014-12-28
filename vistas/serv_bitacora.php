<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#bitacora" data-toggle="tab" id="tab-bitacora">Histórico de Cambios</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div class="form_externo_bitacora">
      <?php
        $fecha_desde = $_GET['fecha_desde'];
        $fecha_hasta = $_GET['fecha_hasta'];
        $usuario = $_GET['usuario'];
        $operacion = $_GET['operacion'];
      ?>
      <style>
      table.tablapaginacion tr:nth-child(2n){
        background-color: #CCC;
      }
      </style>
      <script type="text/javascript">
        function reload_page(){
          fechad = document.getElementById('dfecha_desde').value;
          fechah = document.getElementById('dfecha_hasta').value;
          usuario = document.getElementById('usuario').value;
          operacion = document.getElementById('operacion').value;
          location.href="menu_principal.php?bitacora&fecha_desde="+fechad+"&fecha_hasta="+fechah+"&usuario="+usuario+"&operacion="+operacion;
        }
      </script>
      <table border="0" style="width: 100%"> 
        <tr>
          <td><span class="texto_form">Fecha Desde:</span></td>
          <td>
            <input name="fecha_desde" id="dfecha_desde" type="text" value="<?= $fecha_desde;?>" title="Seleccione la fecha inicio" />
          </td>
          <td><span class="texto_form">Fecha Hasta:</span></td>
          <td>
            <input name="fecha_hasta" id="dfecha_hasta" type="text" value="<?= $fecha_hasta;?>" title="Seleccione la fecha inicio" />
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Usuario Aplicaci&oacute;n:</span></td>
          <td>
            <select id="usuario" name="usuario" title="Seleccione un usuario">
              <option value=''>Seleccione una opci&oacute;n</option>
              <?php
                require_once("../clases/class_bd.php");
                $pgsql=new Conexion();
                $sql = "SELECT cnombreusuario FROM seguridad.tusuario WHERE dfecha_desactivacion IS NULL ORDER BY cnombreusuario";
                $query = $pgsql->Ejecutar($sql);
                while ($row = $pgsql->Respuesta($query)){
                  if($row['cnombreusuario']==$usuario){
                    echo "<option value='".$row['cnombreusuario']."' selected>".$row['cnombreusuario']."</option>";
                  }else{
                    echo "<option value='".$row['cnombreusuario']."'>".$row['cnombreusuario']."</option>";
                  }
                }
              ?>
            </select>
          </td>
          <td><span class="texto_form">Sentencia SQL:</span></td>
          <td>
            <select id="operacion" name="operacion" title="Seleccione un tipo de sentencia SQL">
              <option value=''>Seleccione un tipo de sentencia SQL</option>
              <option value="select" <?php if($operacion=="select"){ echo "selected";} ?> >Select</option>
              <option value="insert" <?php if($operacion=="insert"){ echo "selected";} ?> >Insert</option>
              <option value="update" <?php if($operacion=="update"){ echo "selected";} ?> >Update</option>
              <option value="delete" <?php if($operacion=="delete"){ echo "selected";} ?> >Delete</option>
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
      <br>
      <table  style="float:0px !important; width:100% !important; font-size: 10pt !important;" class="tablapaginacion">
        <tr style="background: #000; color:#FFF; width:100%;"> 
          <td> Fecha </td>
          <td> Hora </td>
          <td >  IP </td>
          <td> Usuario Aplicacion </td>
          <td>  Usuario BD </td>
          <td>  Navigador  </td>
          <td>  SO </td>
          <td widht="30">  Sentencia SQL </td>
        </tr>
        <?php
        //Conexión a la base de datos 
        require_once("../clases/class_bd.php");
        $pgsql=new Conexion();
        $clausuleWhere="";
        if($fecha_desde!="" && $fecha_hasta!="" && $usuario!="" && $operacion!=""){
          $clausuleWhere.="WHERE dfecha BETWEEN '$fecha_desde' AND '$fecha_hasta' 
          AND cusuario_aplicacion = '$usuario' AND LOWER(cquery) LIKE '%$operacion%'";
        }
        else if($fecha_desde!="" && $usuario!="" && $operacion!=""){
          $clausuleWhere.="WHERE dfecha >='$fecha_desde' 
          AND cusuario_aplicacion = '$usuario' AND LOWER(cquery) LIKE '%$operacion%'";
        }
        else if($fecha_hasta!="" && $usuario!="" && $operacion!=""){
          $clausuleWhere.="WHERE dfecha <='$fecha_hasta' 
          AND cusuario_aplicacion = '$usuario' AND LOWER(cquery) LIKE '%$operacion%'";
        }
        else if($fecha_desde!="" && $fecha_hasta!="" && $usuario!=""){
          $clausuleWhere.="WHERE dfecha BETWEEN '$fecha_desde' AND '$fecha_hasta' 
          AND cusuario_aplicacion = '$usuario'";
        }
        else if($fecha_desde!="" && $fecha_hasta!="" && $operacion!=""){
          $clausuleWhere.="WHERE dfecha BETWEEN '$fecha_desde' AND '$fecha_hasta' 
          AND LOWER(cquery) LIKE '%$operacion%'";
        }
        else if($fecha_desde!="" && $fecha_hasta!=""){
          $clausuleWhere.="WHERE dfecha BETWEEN '$fecha_desde' AND '$fecha_hasta'";
        }
        else if($fecha_desde!="" && $usuario!=""){
          $clausuleWhere.="WHERE dfecha >='$fecha_desde' AND cusuario_aplicacion = '$usuario'";
        }
        else if($fecha_hasta!="" && $usuario!=""){
          $clausuleWhere.="WHERE dfecha <='$fecha_hasta' AND cusuario_aplicacion = '$usuario'";
        }
        else if($fecha_desde!="" && $operacion!=""){
          $clausuleWhere.="WHERE dfecha >='$fecha_desde' AND LOWER(cquery) LIKE '%$operacion%'";
        }
        else if($fecha_hasta!="" && $operacion!=""){
          $clausuleWhere.="WHERE dfecha <='$fecha_hasta' AND LOWER(cquery) LIKE '%$operacion%'";
        }
        else if($usuario!="" && $operacion!=""){
          $clausuleWhere.="WHERE cusuario_aplicacion = '$usuario' AND LOWER(cquery) LIKE '%$operacion%'";
        }
        else if($fecha_desde!=""){
          $clausuleWhere.="WHERE dfecha >='$fecha_desde'";
        }
        else if($fecha_hasta!=""){
          $clausuleWhere.="WHERE dfecha <='$fecha_hasta'";
        }
        else if($usuario!=""){
          $clausuleWhere.="WHERE cusuario_aplicacion = '$usuario'";
        }
        else if($operacion!=""){
          $clausuleWhere.="WHERE LOWER(cquery) LIKE '%$operacion%'";
        }
        //Sentencia sql (sin limit) 
        $_pagi_sql = "SELECT *,to_char(dfecha,'DD/MM/YYYY') AS fecha,to_char(dfecha,'HH:MM:SS') AS hora 
        FROM seguridad.tbitacora $clausuleWhere  
        ORDER BY nid_bitacora DESC"; 
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
          echo "<tr><td>".$row['fecha']."</td>
            <td>".$row['hora']."</td>
            <td>".$row['cip']."</td><td>".$row['cusuario_aplicacion']."</td>
            <td>".$row['cusuario_base_de_datos']."</td>
            <td>".$row['cnavegador']."</td>    
            <td>".$row['cso']."</td>    
            <td width='30' onclick='javascript:alert(this.innerHTML)' title='".$row['cquery']."' class='tdaction'>".$row['cquery']."</td>    
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
    </div>
  </div>
</div>