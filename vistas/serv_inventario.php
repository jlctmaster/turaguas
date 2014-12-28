<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#inventario" data-toggle="tab" id="tab-inventario">Inventario</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div class="form_externo_bitacora">
      <?php
        $articulo = $_GET['articulo'];
        $almacen = $_GET['almacen'];
        $nestatus_inventario= $_GET['nestatus_inventario'];
      ?>
      <style>
        table.tablapaginacion tr:nth-child(2n){
          background-color: #CCC;
        }
      </style>
      <script type="text/javascript">
        function reload_page(){
          articulo = document.getElementById('articulo').value;
          nestatus_inventario = document.getElementById('nestatus_inventario').value;
          location.href="menu_principal.php?inventario&articulo="+articulo+"&nestatus_inventario="+nestatus_inventario;
        }
      </script>
      <table border="0" style="width: 100%"> 
        <tr>
          <td><span class="texto_form">Artículo:</span></td>
          <td>
            <input name="articulo" id="articulo" onKeyUp="this.value=this.value.toUpperCase()" type="text" value="<?= $articulo;?>" title="Seleccione el artículo" />
          </td>
        </tr>
        <tr>
          <td><span class="texto_form">Estatus:</span></td>
          <td>
            <select id="nestatus_inventario" name="nestatus_inventario" title="Seleccione el Tipo de Inventario">
              <option value=''>Seleccione una opci&oacute;n</option>
              <?php
                require_once("../clases/class_bd.php");
                $con=new Conexion();
                $sql = "SELECT nid_combovalor,cdescripcion FROM general.tcombo_valor WHERE dfecha_desactivacion IS NULL AND ctabla='tdetalle_movimiento_inventario' ORDER BY nid_combovalor ASC";
                $query = $con->Ejecutar($sql);
                while ($row = $con->Respuesta($query)){
                  if($row['nid_combovalor']==$nestatus_inventario){
                    echo "<option value='".$row['nid_combovalor']."' selected>".$row['cdescripcion']."</option>";
                  }else{
                    echo "<option value='".$row['nid_combovalor']."'>".$row['cdescripcion']."</option>";
                  }
                }
              ?>
            </select>
          </td>
        </tr>
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
          <td> Tipo de Inventario </td>
          <td> Código del Artículo </td>
          <td> Artículo </td>
          <td> Existencia </td>
          </tr>
        <?php
        //Conexión a la base de datos 
        require_once("../clases/class_bd.php");
        $pgsql=new Conexion();
        $clausuleWhere="WHERE existencia <> 0 ";
        if($articulo!="" && $nestatus_inventario!=""){
          $clausuleWhere.="AND articulo LIKE '%$articulo%' 
          AND nid_estatus_inventario='$nestatus_inventario'"; 
        }
        else if($articulo!=""){
          $clausuleWhere.="AND articulo LIKE '%$articulo%'";
        }
        else if($nestatus_inventario!=""){
          $clausuleWhere.="AND nid_estatus_inventario='$nestatus_inventario'";
        }
        //Sentencia sql (sin limit) 
        $_pagi_sql = "SELECT estatus_inventario, cid_articulo,articulo,ROUND(existencia,1) existencia 
        FROM inventario.vw_inventario_productos 
        $clausuleWhere
        ORDER BY estatus_inventario, cid_articulo DESC"; 
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
          echo "<tr>
            <td>".$row['estatus_inventario']."</td>
            <td>".$row['cid_articulo']."</td>
            <td>".$row['articulo']."</td>
            <td>".$row['existencia']."</td>
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