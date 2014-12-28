<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#modulos" data-toggle="tab" id="tab-modulo">Módulo</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_modulo.js"> </script>
    <div class="tab-pane active in" id="modulos">
      <div class="form_externo" >
      <?php
      if(isset($_SESSION['datos']['cnombremodulo'])){ 
        $disabledRC='disabled';
        $disabledMD='';
        $estatus=null;
      }else {
        $disabledRC='';
        $disabledMD='disabled';
        }
      $servicios='modulo';
      if(isset($_SESSION['datos'])){
        @$cnombremodulo=$_SESSION['datos']['cnombremodulo'];
        @$nid_modulo=$_SESSION['datos']['nid_modulo'];
        @$cicono=$_SESSION['datos']['cicono'];
        @$norden=$_SESSION['datos']['norden'];
        @$estatus=$_SESSION['datos']['estatus'];
      }
      else{
        @$cnombremodulo=null;
        @$nid_modulo=null;
        @$cicono=null;
        @$norden=null;
        @$estatus=null;
      }
      if(!isset($_GET['l'])){?>
      <fieldset style="padding: 30px">
        <form action="../controladores/control_modulo.php" method="post" id="form1">
          <table border="0" style="width: 100%"> 
            <tr>
              <td><span class="texto_form">C&oacute;digo</span></td>
              <td><input title="el c&oacute;digo del m&oacute;dulo es generado por el sistema" name="nid_modulo" id="nid_modulo" type="text" size="10" readonly value="<?= $nid_modulo;?>" /> </td>
            </tr>
            <tr>
              <td><span class="texto_form">M&oacute;dulo</span></td>
              <td> <input title="Ingrese el nombre del m&oacute;dulo" onKeyUp="this.value=this.value.toUpperCase()" name="cnombremodulo" id="cnombremodulo" type="text" size="50" value="<?= $cnombremodulo;?>" required/> </td>
            </tr>
            <tr>
              <td><span class="texto_form">Órden</span></td>
              <td><input title="Ingrese el órden del módulo" onKeyPress="return isNumberKey(event)" maxlength=2 name="norden" id="norden" type="text" value="<?= $norden;?>" required/></td>
            </tr>
            <tr>
              <td><span class="texto_form">Icono</span></td>
              <td> 
                <input name="cicono" id="cicono" type="radio" value="icon-home" title="Seleccionar icono de casa" checked="checked" <? if($cicono=="icon-home"){ echo "checked='checked'"; } ?> required/>
                <span class="icon-home" title="Icono de casa"></span> 
                <input name="cicono" id="cicono" type="radio" value="icon-list" title="Seleccionar icono de lista" <? if($cicono=="icon-list"){ echo "checked='checked'"; } ?> required/>
                <span class="icon-list" title="Icono de lista"></span> 
                <input name="cicono" id="cicono" type="radio" value="icon-list-alt" title="Seleccionar icono de lista alternativa" <? if($cicono=="icon-list-alt"){ echo "checked='checked'"; } ?> required/>
                <span class="icon-list-alt" title="Icono de lista alternativa"></span> 
                <input name="cicono" id="cicono" type="radio" value="icon-cog" title="Seleccionar icono de configuraci&oacute;n" <? if($cicono=="icon-cog"){ echo "checked='checked'"; } ?> required/>
                <span class="icon-cog" title="Icono de configuraci&oacute;n"></span> 
                <input name="cicono" id="cicono" type="radio" value="icon-lock" title="Seleccionar icono de seguridad" <? if($cicono=="icon-lock"){ echo "checked='checked'"; } ?> required/>
                <span class="icon-lock" title="Icono de seguridad"></span> 
              </td>
            </tr>
            <?php echo '<tr><td colspan="2" class="'.$estatus.'" id="estatus_registro">'.$estatus.'</td></tr>'; ?>
            <tr>
              <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                <?php
                  imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"modulos");
                ?>         
              </td>
            </tr>
          </table>    
        </form>
      </fieldset>
      <br>
      <?php }else{
        $cnombremodulo = $_GET['cnombremodulo'];
      ?>
      <script type="text/javascript">
      function reload_tabmodulo(tab){
        cnombremodulo = document.getElementById('cnombremodulo').value;
        location.href="menu_principal.php?modulo&l&cnombremodulo="+cnombremodulo+tab;
      }
      </script>
      <table border="0" style="width: 100%"> 
        <tr>
          <td><span class="texto_form">Módulo</span></td>
        </tr>
        <tr>
          <td><input title="Ingrese el nombre del módulo" onKeyUp="this.value=this.value.toUpperCase()" name="cnombremodulo" id="cnombremodulo" type="text" size="50" value="<?= $cnombremodulo;?>" /></td>
        </tr>
      </table>
      <table align="center">  
        <tr>
          <td>
            <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabmodulo('#modulos')">
            <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
          </td>
        </tr>
      </table> 
      <a href="?modulo" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
      <a href="../excel/excel_modulo.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
      <a href="<?php echo  '../pdf/?serv=modulo';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
      <table style="width:100%;" class="tablapaginacion">
        <tr style="background: #000; color:#FFF; width:100%;"> 
          <td style="width:25%;"> Codigo </td>
          <td align='left'>Módulo</td>
          <td align='left'>Icono</td>
          <td align='left'>Órden</td>
        </tr>
        <?php
        //Conexión a la base de datos 
        require_once("../clases/class_bd.php");
        $pgsql=new Conexion();
        $clausuleWhere="WHERE dfecha_desactivacion IS NULL ";
        if($cnombremodulo!=""){
          $clausuleWhere.="AND cnombremodulo LIKE '%$cnombremodulo%' ";
        }
        //Sentencia sql (sin limit) 
        $_pagi_sql = "SELECT * FROM seguridad.tmodulo $clausuleWhere ORDER BY nid_modulo DESC";
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
          echo "<tr><td style='width:20%;'>".$row['nid_modulo']."</td>
            <td align='left'>".$row['cnombremodulo']."</td>
            <td align='left'><span class=".$row['cicono']."></span>".$row['cicono']."</td>
            <td align='left'>".$row['norden']."</td></tr>"; 
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