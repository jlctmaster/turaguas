<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#configuraciones" data-toggle="tab" id="tab-configuracion">Configuración de Perfiles</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_configuracion.js"> </script>
    <div class="tab-pane active in" id="configuraciones">
      <div class="form_externo" >
      <?php
      if(isset($_SESSION['datos']['cdescripcion'])){ 
        $disabledRC='disabled';
        $disabledMD='';
        $estatus=null;
      }else {
        $disabledRC='';
        $disabledMD='disabled';
        }
      $servicios='configuracion';
      if(isset($_SESSION['datos'])){
        @$nid_configuracion=$_SESSION['datos']['nid_configuracion'];
        @$cdescripcion=$_SESSION['datos']['cdescripcion'];
        @$nlongitud_minclave=$_SESSION['datos']['nlongitud_minclave'];
        @$nlongitud_maxclave=$_SESSION['datos']['nlongitud_maxclave'];
        @$ncantidad_letrasmayusculas=$_SESSION['datos']['ncantidad_letrasmayusculas'];
        @$ncantidad_letrasminusculas=$_SESSION['datos']['ncantidad_letrasminusculas'];
        @$ncantidad_caracteresespeciales=$_SESSION['datos']['ncantidad_caracteresespeciales'];
        @$ncantidad_numeros=$_SESSION['datos']['ncantidad_numeros'];
        @$ndias_vigenciaclave=$_SESSION['datos']['ndias_vigenciaclave'];
        @$ndias_aviso=$_SESSION['datos']['ndias_aviso'];
        @$nintentos_fallidos=$_SESSION['datos']['nintentos_fallidos'];
        @$nnumero_preguntas=$_SESSION['datos']['nnumero_preguntas'];
        @$nnumero_respuestasaresponder=$_SESSION['datos']['nnumero_respuestasaresponder'];
        @$estatus=$_SESSION['datos']['estatus'];
      }
      else{
        @$nid_configuracion=null;
        @$cdescripcion=null;
        @$nlongitud_minclave=null;
        @$nlongitud_maxclave=null;
        @$ncantidad_letasmayusculas=null;
        @$ncantidad_letasminusculas=null;
        @$ncantidad_caracteresespeciales=null;
        @$ncantidad_numeros=null;
        @$ndias_vigenciaclave=null;
        @$ndias_aviso=null;
        @$nintentos_fallidos=null;
        @$nnumero_preguntas=null;
        @$nnumero_respuestasaresponder=null;
        @$estatus=null;
      }
      if(!isset($_GET['l'])){?>
      <fieldset style="padding: 30px">
        <form action="../controladores/control_configuracion.php" method="post" id="form1">
          <table border="0" style="width: 100%"> 
            <tr>
              <td><span class="texto_form">C&oacute;digo</span></td>
              <td><input title="El c&oacute;digo de la configuración es generado por el sistema" name="nid_configuracion" id="nid_configuracion" type="text" size="10" readonly value="<?= $nid_configuracion;?>" /></td>
            </tr>
            <tr>
              <td><span class="texto_form">Nombre</span></td>
              <td><input title="Ingrese el nombre de la configuración" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripcion;?>" required/></td>
            </tr>
            <tr>
              <td><span class="texto_form">Longitud Mínima de la Clave</span></td>
              <td><input title="Ingrese la longitud mínima para la clave" onKeyPress="return isNumberKey(event)" maxlength=2 name="nlongitud_minclave" id="nlongitud_minclave" type="text" size="50" value="<?= $nlongitud_minclave;?>" required/></td>
            </tr>
            <tr>
              <td><span class="texto_form">Longitud Máxima de la Clave</span></td>
              <td><input title="Ingrese la longitud máxima para la clave" onKeyPress="return isNumberKey(event)" maxlength=3 name="nlongitud_maxclave" id="nlongitud_maxclave" type="text" size="50" value="<?= $nlongitud_maxclave;?>" required/></td>
            </tr>
            <tr>
              <td><span class="texto_form">Cantidad de Letras Mayúsculas</span></td>
              <td><input title="Ingrese la cantidad de letras mayúsculas" onKeyPress="return isNumberKey(event)" maxlength=2 name="ncantidad_letrasmayusculas" id="ncantidad_letrasmayusculas" type="text" size="50" value="<?= $ncantidad_letrasmayusculas;?>" required/></td>
            </tr>
            <tr>
              <td><span class="texto_form">Cantidad de Letras Minúsculas</span></td>
              <td><input title="Ingrese la cantidad de letras minúsculas" onKeyPress="return isNumberKey(event)" maxlength=2 name="ncantidad_letrasminusculas" id="ncantidad_letrasminusculas" type="text" size="50" value="<?= $ncantidad_letrasminusculas;?>" required/></td>
            </tr>
            <tr>
              <td><span class="texto_form">Cantidad de Carácteres Númericos</span></td>
              <td><input title="Ingrese la cantidad de carácteres númericos" onKeyPress="return isNumberKey(event)" maxlength=2 name="ncantidad_numeros" id="ncantidad_numeros" type="text" size="50" value="<?= $ncantidad_numeros;?>" required/></td>
            </tr>
            <tr>
              <td><span class="texto_form">Cantidad de Carácteres Especiales</span></td>
              <td><input title="Ingrese la cantidad de carácteres especiales" onKeyPress="return isNumberKey(event)" maxlength=2 name="ncantidad_caracteresespeciales" id="ncantidad_caracteresespeciales" type="text" size="50" value="<?= $ncantidad_caracteresespeciales;?>" required/></td>
            </tr>
            <tr>
              <td><span class="texto_form">Cant. de Días de Vigencia de la Clave</span></td>
              <td><input title="Ingrese la cantidad de días para la vigencia de la clave" onKeyPress="return isNumberKey(event)" maxlength=3 name="ndias_vigenciaclave" id="ndias_vigenciaclave" type="text" size="50" value="<?= $ndias_vigenciaclave;?>" required/></td>
            </tr>
            <tr>
              <td><span class="texto_form">Cantidad de Días de Aviso de la Clave</span></td>
              <td><input title="Ingrese la cantidad de días para avisar el vencimiento de la clave" onKeyPress="return isNumberKey(event)" maxlength=2 name="ndias_aviso" id="ndias_aviso" type="text" size="50" value="<?= $ndias_aviso;?>" required/></td>
            </tr>
            <tr>
              <td><span class="texto_form">Cantidad de Intentos Fallidos</span></td>
              <td><input title="Ingrese la cantidad de intentos fallidos para acceder al sistema" onKeyPress="return isNumberKey(event)" maxlength=2 name="nintentos_fallidos" id="nintentos_fallidos" type="text" size="50" value="<?= $nintentos_fallidos;?>" required/></td>
            </tr>
            <tr>
              <td><span class="texto_form">Cantidad de Preguntas Secretas</span></td>
              <td><input title="Ingrese la cantidad de preguntas secretas" onKeyPress="return isNumberKey(event)" maxlength=2 name="nnumero_preguntas" id="nnumero_preguntas" type="text" size="50" value="<?= $nnumero_preguntas;?>" required/></td>
            </tr>
            <tr>
              <td><span class="texto_form">Cantidad de Preguntas a Responder</span></td>
              <td><input title="Ingrese la cantidad de preguntas secretas a responder" onKeyPress="return isNumberKey(event)" maxlength=2 name="nnumero_respuestasaresponder" id="nnumero_respuestasaresponder" type="text" size="50" value="<?= $nnumero_respuestasaresponder;?>" required/></td>
            </tr>
            <?php echo '<tr><td colspan="2" class="'.$estatus.'" id="estatus_registro">'.$estatus.'</td></tr>'; ?>
            <tr>
              <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                <?php
                  imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"configuraciones");
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
      function reload_tabconfiguracion(tab){
        cdescripcion = document.getElementById('cdescripcion').value;
        location.href="menu_principal.php?configuracion&l&cdescripcion="+cdescripcion+tab;
      }
      </script>
      <table border="0" style="width: 100%"> 
        <tr>
          <td><span class="texto_form">Nombre</span></td>
        </tr>
        <tr>
          <td><input title="Ingrese el nombre de la configuración" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripcion;?>" /></td>
        </tr>
      </table>
      <table align="center">  
        <tr>
          <td>
            <input type="button" class="btn btn-default" value="Buscar" onclick="reload_tabconfiguracion('#configuracion')">
            <input type="button" class="btn btn-default" value="Limpiar" onclick="limpiar()">
          </td>
        </tr>
      </table> 
      <a href="menu_principal.php?configuracion" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
      <a href="../excel/excel_configuracion.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
      <a href="<?php echo  '../pdf/?serv=configuracion';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
      <table style="width:100%;" class="tablapaginacion">
        <tr style="background: #000; color:#FFF; width:100%;"> 
          <td style="width:5%;"> Código </td>
          <td align='left'>Nombre</td>
          <td align='left'>Mín. Clave</td>
          <td align='left'>Máx. Clave</td>
          <td align='left'>Letras Mayús.</td>
          <td align='left'>Letras Minús.</td>
          <td align='left'>Carácteres Núm.</td>
          <td align='left'>Carácteres Esp.</td>
          <td align='left'>Vig. Clave</td>
          <td align='left'>Días Aviso</td>
        </tr>
        <?php
        //Conexión a la base de datos 
        require_once("../clases/class_bd.php");
        $pgsql=new Conexion();
        $clausuleWhere="WHERE dfecha_desactivacion IS NULL ";
        if($cdescripcion!=""){
          $clausuleWhere.="AND cdescripcion LIKE '%$cdescripcion%' ";
        }
        //Sentencia sql (sin limit) 
        $_pagi_sql = "SELECT * FROM seguridad.tconfiguracion $clausuleWhere ORDER BY nid_configuracion DESC";
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
          echo "<tr><td style='width:5%;'>".$row['nid_configuracion']."</td>
            <td align='center'>".$row['cdescripcion']."</td>
            <td align='center'>".$row['nlongitud_minclave']."</td>
            <td align='center'>".$row['nlongitud_maxclave']."</td>
            <td align='center'>".$row['ncantidad_letrasmayusculas']."</td>
            <td align='center'>".$row['ncantidad_letrasminusculas']."</td>
            <td align='center'>".$row['ncantidad_numeros']."</td>
            <td align='center'>".$row['ncantidad_caracteresespeciales']."</td>
            <td align='center'>".$row['ndias_vigenciaclave']."</td>
            <td align='center'>".$row['ndias_aviso']."</td>
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