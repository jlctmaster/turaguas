<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#movimientomaterial" data-toggle="tab" id="tab-movimientomaterial">Movimiento del Material</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div class="form_externo_bitacora">
      <?php
        $articulo = $_GET['articulo'];
        $almacen = $_GET['almacen'];
        $tipo = $_GET['tipo'];
        $nestatus_movimientomaterial= $_GET['nestatus_movimientomaterial'];
      ?>
      <style>
        table.tablapaginacion tr:nth-child(2n){
          background-color: #CCC;
        }
      </style>
      <script type="text/javascript">
        function reload_page(){
          articulo = document.getElementById('articulo').value;
          tipo = document.getElementById('tipo').value;
          nestatus_movimientomaterial = document.getElementById('nestatus_movimientomaterial').value;
          location.href="menu_principal.php?movimientomaterial&articulo="+articulo+"&tipo="+tipo+"&nestatus_movimientomaterial="+nestatus_movimientomaterial;
        }
      </script>
      <table border="0" style="width: 100%"> 
        <tr>
          <td><span class="texto_form">Artículo:</span></td>
          <td>
            <input name="articulo" id="articulo" onKeyUp="this.value=this.value.toUpperCase()" type="text" value="<?= $articulo;?>" title="Seleccione el artículo" />
          </td>
          <td><span class="texto_form">Estatus:</span></td>
          <td>
            <select id="nestatus_movimientomaterial" name="nestatus_movimientomaterial" title="Seleccione el Tipo de Movimientomaterial">
              <option value=''>Seleccione una opci&oacute;n</option>
              <?php
                require_once("../clases/class_bd.php");
                $con=new Conexion();
                $sql = "SELECT nid_combovalor,cdescripcion FROM general.tcombo_valor WHERE dfecha_desactivacion IS NULL AND ctabla='tdetalle_movimiento_inventario' ORDER BY nid_combovalor ASC";
                $query = $con->Ejecutar($sql);
                while ($row = $con->Respuesta($query)){
                  if($row['nid_combovalor']==$nestatus_movimientomaterial){
                    echo "<option value='".$row['nid_combovalor']."' selected>".$row['cdescripcion']."</option>";
                  }else{
                    echo "<option value='".$row['nid_combovalor']."'>".$row['cdescripcion']."</option>";
                  }
                }
              ?>
            </select>
          </td>
          <td><span class="texto_form">Tipo de Movimiento:</span></td>
          <td>
            <select id="tipo" name="tipo" title="Seleccione el tipo de movimiento">
              <option value=''>Seleccione una opci&oacute;n</option>
              <option value='E' <?if($tipo=="E"){echo "selected";}?> >Entrada</option>
              <option value='S' <?if($tipo=="S"){echo "selected";}?> >Salida</option>
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
          <td> Código del Movimiento </td>
          <td> Tipo de Movimiento </td>
          <td> Fecha de Movimiento </td>
          <td> Nro. de Documento </td>
          <td> Tipo de Inventario </td>
          <td> Artículo </td>
          <td> Cantidad </td>
          </tr>
        <?php
        //Conexión a la base de datos 
        require_once("../clases/class_bd.php");
        $pgsql=new Conexion();
        $clausuleWhere="";
        if($articulo!="" && $nestatus_movimientomaterial!="" && $tipo!=""){
          $clausuleWhere.="WHERE articulo LIKE '%$articulo%' 
          AND ntipo_inventario='$nestatus_movimientomaterial' 
          AND ctipo_movinventario='$tipo'"; 
        }
        else if($articulo!="" && $tipo!=""){
          $clausuleWhere.="WHERE articulo LIKE '%$articulo%' 
          AND ctipo_movinventario='$tipo'";
        }
        else if($articulo!="" && $nestatus_movimientomaterial!=""){
          $clausuleWhere.="WHERE articulo LIKE '%$articulo%' 
          AND ntipo_inventario='$nestatus_movimientomaterial'"; 
        }
        else if($tipo!="" && $nestatus_movimientomaterial!=""){
          $clausuleWhere.="WHERE ctipo_movinventario='$tipo' 
          AND ntipo_inventario='$nestatus_movimientomaterial'"; 
        }
        else if($articulo!=""){
          $clausuleWhere.="WHERE articulo LIKE '%$articulo%'";
        }
        else if($nestatus_movimientomaterial!=""){
          $clausuleWhere.="WHERE ntipo_inventario='$nestatus_movimientomaterial'";
        }
        else if($tipo!=""){
          $clausuleWhere.="WHERE ctipo_movinventario='$tipo'";
        }
        //Sentencia sql (sin limit) 
        $_pagi_sql = "SELECT nid_movinventario,tipo,TO_CHAR(fecha,'DD/MM/YYYY') fecha,documento,
        inventario,TRIM(articulo) articulo,ROUND(ncantidad,1) ncantidad 
        FROM inventario.vw_movimiento_inventario 
        $clausuleWhere 
        ORDER BY nid_movinventario DESC"; 
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
          echo "<tr><td>".$row['nid_movinventario']."</td>
            <td>".$row['tipo']."</td>
            <td>".$row['fecha']."</td>
            <td>".$row['documento']."</td>
            <td>".$row['inventario']."</td>
            <td>".$row['articulo']."</td>
            <td>".$row['ncantidad']."</td>
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