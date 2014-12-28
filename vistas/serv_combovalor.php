<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#combovalor" data-toggle="tab" id="tab-combovalor">Combo Valor</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_combovalor.js"> </script>
    <div class="tab-pane active" id="combovalor">
      <div class="form_externo" >
        <?php
          //Comprobamos si la variable de busqueda esta construida, si es asi deshabilitamos los botones registrar,consultar 
          //y habilitamos los botones modificar,desactivar.
          if(isset($_SESSION['datos']['ctabla']) && isset($_SESSION['datos']['cdescripcion'])){ 
            $disabledRCCombovalor='disabled';
            $disabledMDCombovalor='';
            $estatus_combovalor=null;
          }else {
            $disabledRCCombovalor='';
            $disabledMDCombovalor='disabled';
          }
          //definimos la url de nuestro archivo en la variable $servicios, esta debe ser igual que el se encuentra en el archivo menu_principal.php
          //y el valor de la BD.
          $servicios='combovalor';
          //Comprobamos si esta construida la variable de sesion con los datos del formulario y asignamos a las variables respectivas,
          //de lo contrario asignamos null a esas variables.
          if(isset($_SESSION['datos'])){
            @$nid_combovalor=$_SESSION['datos']['nid_combovalor'];
            @$ctabla=$_SESSION['datos']['ctabla'];
            @$cdescripcion=$_SESSION['datos']['cdescripcion'];
            @$estatus_combovalor=$_SESSION['datos']['estatus_combovalor'];
          }
          else{
            @$nid_combovalor=null;
            @$ctabla=null;
            @$cdescripcion=null;
            @$estatus_combovalor=null;
          }
          //comprobamos si la url de la pagina tiene la letra 'l' si es asi mostramos la vista donde se listan los registros,
          //en caso contrario mostramos el formulario.
          if(!isset($_GET['l'])){
        ?>
        <fieldset style="padding: 30px">
          <form action="../controladores/control_combovalor.php" method="post" id="form1">
            <table border="0" style="width: 100%">
              <tr>
                <td><span class="texto_form">Código</span></td>
                <td><input title="el código para el valor del combo es generado por el sistema" name="nid_combovalor" id="nid_combovalor" type="text" size="10" readonly value="<?= $nid_combovalor;?>" /> </td>
              </tr>
              <tr>
                <td><span class="texto_form">Tabla Destino</span></td>
                <td>
                  <select name="ctabla" id="ctabla" title="Seleccione una tabla" required >
                    <?php
                      require_once('../clases/class_bd.php');
                      $conexion = new Conexion();
                      $sql="SELECT DISTINCT schemaname FROM pg_catalog.pg_tables 
                      WHERE schemaname IN ('general','facturacion','inventario','seguridad') 
                      ORDER BY schemaname ASC";
                      $query=$conexion->Ejecutar($sql);
                      while ($schema=$conexion->Respuesta($query)){
                        echo "<optgroup label='".$schema['schemaname']."'>";
                        $sqlx="SELECT DISTINCT tablename FROM pg_catalog.pg_tables 
                        WHERE schemaname = '".$schema['schemaname']."'
                        ORDER BY tablename ASC";
                        $querys=$conexion->Ejecutar($sqlx);
                        while ($tables=$conexion->Respuesta($querys)){
                          echo "<option value='".$tables['tablename']."'>".$tables['tablename']."</option>";
                        }
                      }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td><span class="texto_form">Texto a Mostrar</span></td>
                <td><input title="Ingrese el texto a mostrar en el combo" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripcion;?>" required /></td>
              </tr>
              <?php echo '<tr><td colspan="2" class="'.$estatus_combovalor.'" id="estatus_registro">'.$estatus_combovalor.'</td></tr>'; ?>
              <tr>
                <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                          <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                  <?php
                    //Imprimimos la botonera en el formulario, ya esto esta definido en el archivo botones.php
                    imprimir_boton($disabledRCCombovalor,$disabledMDCombovalor,$estatus_combovalor,$servicios,"combovalor");
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
          $ctabla = $_GET['ctabla'];
          $cdescripcion = $_GET['cdescripcion'];
          //la funcion reload_page() vuelve a llamar el servicio y manda por url los valores de los datos filtrados.
        ?>
        <script type="text/javascript">
          function reload_tabcombovalor(tab){
            ctabla = document.getElementById('ctabla').value;
            cdescripcion = document.getElementById('cdescripcion').value;
            location.href="menu_principal.php?combovalor&l&ctabla="+ctabla+"&cdescripcion="+cdescripcion+tab;
          }
        </script>
        <table border="0" style="width: 100%"> 
          <tr>
            <td><span class="texto_form">Tabla</span></td>
            <td>
              <input title="Ingrese el nombre de la tabla" onKeyUp="this.value=this.value.toUpperCase()" name="ctabla" id="ctabla" type="text" size="50" value="<?= $ctabla;?>" />
            </td>
            <td><span class="texto_form">Texto a Mostrar</span></td>
            <td>
              <input title="Ingrese el texto a mostrar en el combo" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripcion;?>" />
            </td>
          </tr>
        </table>
        <table align="center">  
          <tr>
            <td>
              <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabcombovalor('#combovalor')">
              <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
            </td>
          </tr>
        </table>
        <a href="?combovalor#combovalor" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
        <a href="../excel/excel_combovalor.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
        <a href="<?php echo  '../pdf/?serv=combovalor';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
        <table style="width:100%;" class="tablapaginacion">
          <tr style="background: #000; color:#FFF; width:100%;"> 
            <td style="width:20%;">C&oacute;digo </td>
            <td align='left'>Tabla</td>
            <td align='left'>Texto a Mostrar</td>
          </tr>
          <?php
            //En esta sección hacemos uso de la clase paginator.inc.php, enviando los campos obligatorios que requiere la clase.
            //Conexión a la base de datos 
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            $clausuleWhere = "WHERE dfecha_desactivacion IS NULL ";
            if($cdescripcion!="" && $ctabla!=""){
              $clausuleWhere.="AND cdescripcion LIKE '%$cdescripcion%' AND UPPER(ctabla) LIKE '%$ctabla%'";
            }
            else if( $ctabla!=""){
              $clausuleWhere.="AND UPPER(ctabla) LIKE '%$ctabla%'";
            }
            else if( $cdescripcion!=""){
              $clausuleWhere.="AND cdescripcion LIKE '%$cdescripcion%'";
            }
            //Sentencia sql (sin limit) 
            $_pagi_sql = "SELECT cdescripcion as combovalor,nid_combovalor as id,UPPER(ctabla) tabla 
            FROM general.tcombo_valor
            $clausuleWhere  
            ORDER BY nid_combovalor,tabla,cdescripcion DESC";
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
              <td style='width:20%;'>".$row['id']."</td>
              <td align='left'>".$row['tabla']."</td>
              <td align='left'>".$row['combovalor']."</td>
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