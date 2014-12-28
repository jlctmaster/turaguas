<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#presentacion" data-toggle="tab">Presentación del artículo</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div class="tab-pane active" id="presentacion">
      <div class="form_externo" >
        <?php
          if(isset($_SESSION['datos']['cdescripcion'])){ 
            $disabledRC='disabled';
            $disabledMD='';
            $estatus=null;
          }
		  else {
            $disabledRC='';
            $disabledMD='disabled';
           	}
            $servicios='presentacion';
          if(isset($_SESSION['datos'])){
            @$nid_presentacion=$_SESSION['datos']['nid_presentacion'];
            @$cdescripcion=$_SESSION['datos']['cdescripcion'];
            @$nunidades=$_SESSION['datos']['nunidades'];
            @$ncapacidad=$_SESSION['datos']['ncapacidad'];
            @$nid_unidadmedida=$_SESSION['datos']['nid_unidadmedida'];
            @$estatus=$_SESSION['datos']['estatus'];
          }
		  else{
            @$nid_presentacion=$_GET['nid_presentacion'];
            @$cdescripcion=$_GET['cdescripcion'];
            @$nunidades=$_GET['nunidades'];
            @$ncapacidad=$_GET['ncapacidad'];
            @$nid_unidadmedida=$_GET['nid_unidadmedida'];
            @$estatus=$_GET['estatus'];
            if ($estatus=="Activo"){
            $disabledRC='disabled';
            $disabledMD='';
           }
           else if ($estatus=="Desactivado") {
                $disabledRC='disabled';
                $disabledMD='disabled';
               }
            else {
                $disabledRC='';
                $disabledMD='disabled';
               }
            }
        ?>
        <?php if(!isset($_GET['l'])){?>
        <script src="../js/eft_presentacion.js"> </script>
        <fieldset>
          <form action="../controladores/control_presentacion.php" method="post" id="form1">
            <table border="0" style="width: 100%">
              <tr>
                <td><span class="texto_form">Código</span></td>
                <td><input title="El código de la presentación es generado por el sistema" name="nid_presentacion" id="nid_presentacion" type="text" size="10" readonly value="<?= $nid_presentacion;?>" /> </td>
              </tr>
              <tr>
                <td><span class="texto_form">Presentación</span></td>
                <td><input title="Ingrese el nombre de la presentación" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripcion;?>" required></td>
              </tr>
              <tr>
                <td><span class="texto_form">Unidades</span></td>
                <td> <input title="Ingrese las unidades de la presentación" onKeyUp="this.value=this.value.toUpperCase()" name="nunidades" id="nunidades" type="text" size="50" value="<?= $nunidades;?>" required></td>
              </tr>
                <td>
                <tr>
                  <td><span class="texto_form">Capacidad</span></td>
                  <td> <input title="Ingrese la capacidad"  name="ncapacidad" id="ncapacidad" type="text" size="50" value="<?= $ncapacidad;?>" required>
                  <select id="nid_unidadmedida" name="nid_unidadmedida" title="Seleccione una unidad de medida" required>
                    <option value=0 selected>Unidad de medida</option>
                    <?php
                      require_once("../clases/class_bd.php");
                      $pgsql=new Conexion();
                      $sql = "SELECT nid_unidadmedida,csimbolo FROM inventario.tunidad_medida WHERE dfecha_desactivacion IS NULL ORDER BY nid_unidadmedida ASC";
                      $query = $pgsql->Ejecutar($sql);
                      while ($row = $pgsql->Respuesta($query)){
                      if($row['nid_unidadmedida']==$nid_unidadmedida){
                        echo "<option value='".$row['nid_unidadmedida']."' selected>".$row['csimbolo']."</option>";
                      }else{
                        echo "<option value='".$row['nid_unidadmedida']."'>".$row['csimbolo']."</option>";
                      }
                      }
                    ?>
                  </select>
        </td></tr>
                <?php echo '<tr><td colspan="2" class="'.$estatus.'" id="estatus_registro">'.$estatus.'</td></tr>'; ?>
              <tr>
                <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                  <?php
                    imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"presentacion");
                  ?>         
                </td>
              </tr>
            </table>    
          </form>
        </fieldset>
        <br>
        <?php }else{ 
          $cdescripcion = $_GET['cdescripcion'];
        ?>
        <script type="text/javascript">
          function reload_page(){
          cdescripcion = document.getElementById('cdescripcion').value;
          location.href="menu_principal.php?presentacion&l&cdescripcion="+cdescripcion;
          }
        </script>
        <table border="0" style="width: 100%"> 
          <tr>
            <td><span clas="texto_form">Nombre de la presentac&iacute;n del artículo</span></td>
          <tr>
          <tr>
            <td><input title="La presentación del artículo" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripcion;?>" /></td>
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
        <a href="?presentacion" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
        <a href="../excel/excel_presentacion.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
        <a href="<?php echo  '../pdf/?serv=presentacion';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
        <table style="width:100%;" class="tablapaginacion">
          <tr style="background: #000; color:#FFF; width:100%;"> 
            <td style="width:20%;">C&oacute;digo </td>
            <td align='left'>Presentación</td>
            <td align='left'>Unidades</td>
            <td align='left'>Capacidad</td>
          </tr>
          <?php
            //Conexión a la base de datos 
            require_once("../clases/class_bd.php");
            $pgsql=new Conexion();
            $clausuleWhere = "";
            if($cdescripcion!=""){
              $clausuleWhere.="WHERE cdescripcion LIKE '%$cdescripcion%'";
            }
            //Sentencia sql (sin limit) 
            $_pagi_sql = "SELECT p.cdescripcion,p.nid_presentacion as id, p.nunidades as unidades, p.ncapacidad || ' ' || u.csimbolo as capacidad
            FROM inventario.tpresentacion as p
            inner join inventario.tunidad_medida as u on u.nid_unidadmedida = p.nid_unidadmedida
            $clausuleWhere 
            ORDER BY p.cdescripcion DESC";
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
                        <td align='left'>".$row['unidades']."</td>
                        <td align='left'>".$row['capacidad']."</td>
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
  <form id="form1" method="POST" action="../controladores/control_presentacion.php">
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