<?php
require_once("../clases/class_bd.php");

$tbHtml = "<table style='width:100%;'>
             <header>
                <tr style='width:100%;'>
                  <th style='width:20%;'>C&oacute;digo</th>
               <th align='left'>Parroquia</th>
               <th align='left'>C&oacute;digo Municipio</th>
               <th align='left'>Municipio</th>
                </tr>
            </header>";

$pgsql = new Conexion();

$sql = "SELECT p.nid_localidad_padre,m.cdescripcion municipio,p.nid_localidad,p.cdescripcion parroquia FROM general.tlocalidad p 
INNER JOIN general.tlocalidad m ON m.nid_localidad = p.nid_localidad_padre AND p.ctabla = 'tparroquia' 
WHERE p.dfecha_desactivacion IS NULL 
ORDER BY p.nid_localidad DESC";
$query = $pgsql->Ejecutar($sql);
while ($row = $pgsql->Respuesta($query)){
	$tbHtml .= "<tr>
    <td style='width:20%;'>".$row['nid_localidad']."</td>
    <td align='left'>".$row['parroquia']."</td>
    <td align='left'>".$row['nid_localidad_padre']."</td>
    <td align='left'>".$row['municipio']."</td>
    </tr>"; 

}

$tbHtml .= "</table>";
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=parroquias.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
 
?>
