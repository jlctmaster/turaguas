<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#condicionpago" data-toggle="tab">Condición de Pago</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div class="tab-pane active" id="condicionpago">
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
						
                          $servicios='condicionpago';
        if(isset($_SESSION['datos'])){
                    @$cdescripcion=$_SESSION['datos']['cdescripcion'];
                    @$nid_condicionpago=$_SESSION['datos']['nid_condicionpago'];
                    @$estatus=$_SESSION['datos']['estatus'];
                    }
               else{
                    @$nid_condicionpago=$_GET['nid_condicionpago'];
                    @$cdescripcion=$_GET['cdescripcion'];
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
        <script src="../js/eft_condicionpago.js"> </script>
        <fieldset style="padding: 30px">
          <form action="../controladores/control_condicionpago.php" method="post" id="form1">
            <table border="0" style="width: 100%">
              <tr>
                <td><span class="texto_form">Código</span></td>
                <td><input title="El código de la condición de pago es generado por el sistema" name="nid_condicionpago" id="nid_condicionpago" type="text" size="10" readonly value="<?= $nid_condicionpago;?>" /> </td>
              </tr>
              <tr>
                <td><span class="texto_form">Condición de pago</span></td>
                <td><input title="Ingrese la condición de pago" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripcion;?>" required>
                      <?php echo '<tr><td colspan="2" class="'.$estatus.'" id="estatus_registro">'.$estatus.'</td></tr>'; ?>
              <tr>
                <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                  <?php
                    imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"condicionpago");
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
            location.href="menu_principal.php?condicionpago&l&cdescripcion="+cdescripcion;
          }
        </script>
        <table border="0" style="width: 100%"> 
           <tr>
            <td><span clas="texto_form">Nombre de la condici&oacute;n de pago</span></td>
          <tr>

          <tr>
            <td>
              <input title="Ingrese el nombre de la condición de pago" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripcion;?>" />
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

          <a href="?condicionpago" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
          <a href="../excel/excel_condicionpago.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
          <a href="<?php echo  '../pdf/?serv=condicionpago';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
             <table style="width:100%;" class="tablapaginacion">
                   <tr style="background: #000; color:#FFF; width:100%;"> 
                       <td style="width:20%;">C&oacute;digo </td>
                       <td align='left'>Nombre</td>
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
        $_pagi_sql = "SELECT cdescripcion, nid_condicionpago 
        FROM facturacion.tcondicion_pago
        $clausuleWhere 
        ORDER BY cdescripcion DESC";
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
                      <td style='width:20%;'>".$row['nid_condicionpago']."</td>
                      <td align='left'>".$row['cdescripcion']."</td>
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
  <form id="form1" method="POST" action="../controladores/control_condicionpago.php">
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
</div>