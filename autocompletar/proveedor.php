<?php
require_once('../clases/class_bd.php');
$conexion = new Conexion();
$sql = "SELECT TRIM(crif_persona) crif_persona,cnombre FROM general.tpersona
   		WHERE ntipo_persona = (SELECT nid_combovalor FROM general.tcombo_valor WHERE cdescripcion LIKE '%PROVEEDOR%') 
   		AND (crif_persona LIKE '%".$_GET['term']."%' OR cnombre LIKE '%".$_GET['term']."%')";
$query = $conexion->Ejecutar($sql);
while($Obj=$conexion->Respuesta($query)){
	$rows[]=array(
		'label' => $Obj['crif_persona'].'_'.$Obj['cnombre'],
		'value' => $Obj['crif_persona']
		);
}
echo json_encode($rows);
?>