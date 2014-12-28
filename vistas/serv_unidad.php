<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#unidad" data-toggle="tab">Unidad de Medida</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <div class="tab-pane active" id="unidad">
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
                          $servicios='unidadmedida';
        if(isset($_SESSION['datos'])){
                    @$cdescripcion=$_SESSION['datos']['cdescripcion'];
                    @$nid_unidadmedida=$_SESSION['datos']['nid_unidadmedida'];
                    @$csimbolo=$_SESSION['datos']['csimbolo'];
                    @$estatus=$_SESSION['datos']['estatus'];
                    }
               else{
                    @$nid_unidadmedida=$_GET['nid_unidadmedida'];
                    @$csimbolo=$_GET['csimbolo'];
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
        <br><br>
          <?php if(!isset($_GET['l'])){?>
        <script src="../js/eft_unidad.js"> </script>
             <fieldset style="padding: 30px">
                  <form action="../controladores/control_unidad.php" method="post" id="form1">
                <table border="0" style="width: 100%">
                    <input type="hidden" name="ctabla" value="tunidad_medida" />
                    <tr><td><span class="texto_form">Código </span></td><td><input title="El código de la unidad de medida es generado por el sistema" name="nid_unidadmedida" id="nid_unidadmedida" type="text" size="10" readonly value="<?= $nid_unidadmedida;?>" /> </td><tr>
                    <tr><td><span class="texto_form">Nombre </span></td><td> <input title="Ingrese el nombre de la unidad de medida. Ejemplo: gramos" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripcion;?>" required/></td><tr>
                    <tr><td><span class="texto_form">Unidad </span></td><td> <input title="Ingrese el símbolo de la undad de medida. Ejemplo: gr" onKeyUp="this.value=this.value.toUpperCase()" name="csimbolo" id="csimbolo" type="text" size="50" value="<?= $csimbolo;?>" required/></td><tr>
                     <?php echo '<tr><td colspan="2" class="'.$estatus.'" id="estatus_registro">'.$estatus.'</td></tr>'; ?>
                     <tr>
                         <td colspan="2" style="padding-top:12px;padding-bottom:12px; ">
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                              <?php
                              imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"unidad");
                             ?>         
                         </td>
                    </tr>
                  </table>    
               </form>
            </fieldset>
        <br>
          <?php }else{ 
              $cdescripcion = $_GET['cdescripcion'];
              $csimbolo = $_GET['csimbolo'];
            ?>

          <script type="text/javascript">
          function reload_page(){
            cdescripcion = document.getElementById('cdescripcion').value;
            csimbolo = document.getElementById('csimbolo').value;
            location.href="menu_principal.php?unidadmedida&l&cdescripcion="+cdescripcion+"&csimbolo="+csimbolo;
          }
        </script>

        <table border="0" style="width: 100%"> 
           <tr>
            <td><span clas="texto_form">Nombre</span></td>
            <td><span clas="texto_form">Unidad</span></td>
          <tr>

          <tr>
            <td>
              <input title="Ingrese el nombre de la unidad de medida" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" value="<?= $cdescripcion;?>" />
            </td>
            <td>
              <input title="Ingrese la unida de medida" onKeyUp="this.value=this.value.toUpperCase()" name="csimbolo" id="csimbolo" type="text" size="50" value="<?= $csimbolo;?>" />
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

          <a href="?unidadmedida" ><img src="../images/cerrar.png" alt="Cerrar" style="width:40px;heigth:40px;float:right;"></a>
          <a href="../excel/excel_unidad.php" ><img src="../images/icon-excel.png" alt="Exportar a Excel" style="width:40px;heigth:40px;float:right;"></a>
          <a href="<?php echo  '../pdf/?serv=unidad';?>" target="_blank"><img src="../images/icon-pdf.png" alt="Exportar a PDF" style="width:40px;heigth:40px;float:right;"></a>
             <table style="width:100%;" class="tablapaginacion">
                   <tr style="background: #000; color:#FFF; width:100%;"> 
                       <td style="width:20%;">C&oacute;digo </td>
                       <td align='left'>Nombre</td>
                       <td align='left'>Unidad</td>
                   </tr>
                 <?php

                   //Conexión a la base de datos 
          require_once("../clases/class_bd.php");
          $pgsql=new Conexion();

        $clausuleWhere = "";
        if($cdescripcion!=""){
          $clausuleWhere.="WHERE cdescripcion LIKE '%$cdescripcion%'";
        }
        else if($csimbolo!=""){
          if($clausuleWhere!=""){
            $clausuleWhere.="AND csimbolo LIKE '%$csimbolo%'";
          }
          else{
            $clausuleWhere.="WHERE csimbolo LIKE '%$csimbolo%'";
          }
        }

        //Sentencia sql (sin limit) 
        $_pagi_sql = "SELECT cdescripcion,nid_unidadmedida as id,csimbolo as medida 
        FROM inventario.tunidad_medida 
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
		      <td style='width:20%;'>".$row['id']."</td>
              <td align='left'>".$row['cdescripcion']."</td>
              <td align='left'>".$row['medida']."</td></tr>"; 
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
  <form id="form1" method="POST" action="../controladores/control_unidad.php">
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