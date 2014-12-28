<?php
require_once("../clases/class_bd.php");

$tbHtml = "<table style='width:100%;'>
             <header>
                <tr style='width:100%;'>
                  <th style='width:20%;'> C&oacute;digo </th>
               <th align='left'>Nombre</th>
               <th align='left'>Unidad</th>
                </tr>
            </header>";

$pgsql = new Conexion();

$sql = "SELECT nid_unidadmedida as id,cdescripcion as unidad,csimbolo as medida
FROM inventario.tunidad_medida 
ORDER BY cdescripcion DESC";
$query = $pgsql->Ejecutar($sql);
while ($row = $pgsql->Respuesta($query)){
	$tbHtml .= "<tr>
    <td style='width:20%;'>".$row['id']."</td>
    <td align='left'>".$row['unidad']."</td>
    <td align='left'>".$row['medida']."</td>
    </tr>"; 

}

$tbHtml .= "</table>";
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=ubicaciones.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
 
?>