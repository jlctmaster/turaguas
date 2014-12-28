<div id="defensa_div" >    
    <div style="margin: auto 0px;">
      <form action="../pdf/reporte_compra.php"  method="post">
      	<fieldset>
      		<legend>Listado de Materias por Secciones</legend>      	
      		<span>Sección Desde:</span>
	       <select name="seccion_desde" id="seccion_desde" title="Seleccione la Sección">
	       		<?php
	       			include_once("../clases/class_bd");
	       			$conexion = new Conexion();
	       			$sql="SELECT * FROM tseccion WHERE fecha_desactivacion IS NULL ORDER BY seccion ASC";
	       			$query=$conexion->Ejecutar($sql);
	       			while ($row = $conexion->Respuesta($query)){
	       				echo "<option value=".$row['seccion'].">".$row['nombre_seccion']."</option>";
	       			}
	       		?>
	       </select>
	       <br/>
      		<span>Sección Hasta:</span>
	       <select name="seccion_hasta" id="seccion_hasta" title="Seleccione la Sección">
	       		<?php
	       			include_once("../clases/class_bd");
	       			$conexion = new Conexion();
	       			$sql="SELECT * FROM tseccion WHERE fecha_desactivacion IS NULL ORDER BY seccion ASC";
	       			$query=$conexion->Ejecutar($sql);
	       			while ($row = $conexion->Respuesta($query)){
	       				echo "<option value=".$row['seccion'].">".$row['nombre_seccion']."</option>";
	       			}
	       		?>
	       </select>
	       <br/>
	       <input type="submit" class="myButton Buttonbuscar"  value="Aceptar"/>
      </form>
	  </fieldset>
     </div>

</div>

<?php if(isset($_SESSION['datos'])) unset($_SESSION['datos']);?>
