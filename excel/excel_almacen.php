<?php
require_once("../clases/class_bd.php");

$tbHtml = "<table style='width:100%;'>
             <header>
                <tr style='width:100%;'>
                  <th style='width:20%;'> C&oacute;digo </th>
               <th align='left'>Nombre del Almac&eacute;</th>
               <th align='left'>C&oacute;digo</th>
               <th align='left'>Ubicaci&oacute;n</th>
                </tr>
            </header>";

$pgsql = new Conexion();

$sql = "SELECT a.cdescripcion as almacen,a.nid_almacen as aid,u.cdescripcion as ubicacion,u.nid_ubicacion as uid_ubicacion 
FROM inventario.talmacen a 
INNER JOIN inventario.tubicacion u ON a.nid_ubicacion = u.nid_ubicacion 
ORDER BY a.cdescripcion DESC";
$query = $pgsql->Ejecutar($sql);
while ($row = $pgsql->Respuesta($query)){
	$tbHtml .= "<tr>
    <td style='width:10%;'>".$row['aid']."</td>
    <td align='left'>".$row['almacen']."</td>
    <td align='left'>".$row['uid_ubicacion']."</td>
    <td align='left'>".$row['ubicacion']."</td>
    </tr>"; 

}

$tbHtml .= "</table>";
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=almacenes.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
 
?>
