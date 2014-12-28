<?php
require_once("../clases/class_bd.php");

$tbHtml = "<table style='width:100%;'>
             <header>
                <tr style='width:100%;'>
                  <th style='width:20%;'>C&oacute;digo</th>
               <th align='left'>Ciudad</th>
               <th align='left'>C&oacute;digo Estado</th>
               <th align='left'>Estado</th>
                </tr>
            </header>";

$pgsql = new Conexion();

$sql = "SELECT c.nid_localidad_padre,e.cdescripcion estado,c.nid_localidad,c.cdescripcion ciudad FROM general.tlocalidad c 
INNER JOIN general.tlocalidad e ON e.nid_localidad = c.nid_localidad_padre AND c.ctabla = 'tciudad' 
WHERE c.dfecha_desactivacion IS NULL 
ORDER BY c.nid_localidad DESC";
$query = $pgsql->Ejecutar($sql);
while ($row = $pgsql->Respuesta($query)){
	$tbHtml .= "<tr>
    <td style='width:20%;'>".$row['nid_localidad']."</td>
    <td align='left'>".$row['ciudad']."</td>
    <td align='left'>".$row['nid_localidad_padre']."</td>
    <td align='left'>".$row['estado']."</td>
    </tr>"; 

}

$tbHtml .= "</table>";
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=ciudades.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
 
?>
