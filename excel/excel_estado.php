<?php
require_once("../clases/class_bd.php");

$tbHtml = "<table style='width:100%;'>
             <header>
                <tr style='width:100%;'>
                  <th style='width:20%;'>C&oacute;digo</th>
               <th align='left'>Estado</th>
               <th align='left'>C&oacute;digo Pa&iacute;s</th>
               <th align='left'>Pa&iacute;s</th>
                </tr>
            </header>";

$pgsql = new Conexion();

$sql = "SELECT e.nid_localidad,e.cdescripcion estado,e.nid_localidad_padre,p.cdescripcion pais 
FROM general.tlocalidad e INNER JOIN general.tlocalidad p ON e.nid_localidad_padre = p.nid_localidad AND e.ctabla = 'testado' 
ORDER BY e.nid_localidad DESC";
$query = $pgsql->Ejecutar($sql);
while ($row = $pgsql->Respuesta($query)){
	$tbHtml .= "<tr>
    <td style='width:20%;'>".$row['nid_localidad']."</td>
    <td align='left'>".$row['estado']."</td>
    <td align='left'>".$row['nid_localidad_padre']."</td>
    <td align='left'>".$row['pais']."</td>
    </tr>"; 

}

$tbHtml .= "</table>";
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=estados.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
 
?>
