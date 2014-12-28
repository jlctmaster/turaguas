<?php
require_once("../clases/class_bd.php");

$tbHtml = "<table style='width:100%;'>
             <header>
                <tr style='width:100%;'>
                  <th style='width:20%;'>C&oacute;digo</th>
               <th align='left'>Municipio</th>
               <th align='left'>C&oacute;digo Ciudad</th>
               <th align='left'>Ciudad</th>
                </tr>
            </header>";

$pgsql = new Conexion();

$sql = "SELECT m.nid_localidad_padre,m.cdescripcion municipio,m.nid_localidad,c.cdescripcion ciudad FROM general.tlocalidad m 
INNER JOIN general.tlocalidad c ON c.nid_localidad = m.nid_localidad_padre AND m.ctabla = 'tmunicipio' 
WHERE m.ctabla = 'tmunicipio' AND m.dfecha_desactivacion IS NULL 
ORDER BY m.nid_localidad DESC";
$query = $pgsql->Ejecutar($sql);
while ($row = $pgsql->Respuesta($query)){
	$tbHtml .= "<tr>
    <td style='width:20%;'>".$row['nid_localidad']."</td>
    <td align='left'>".$row['municipio']."</td>
    <td align='left'>".$row['nid_localidad_padre']."</td>
    <td align='left'>".$row['ciudad']."</td>
    </tr>"; 

}

$tbHtml .= "</table>";
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=municipios.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
 
?>
