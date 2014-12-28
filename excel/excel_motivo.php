<?php
require_once("../clases/class_bd.php");

$tbHtml = "<table style='width:100%;'>
             <header>
                <tr style='width:100%;'>
                  <th style='width:20%;'> C&oacute;digo </th>
               <th align='left'>Motivo o Raz&oacute;n</th>
                </tr>
            </header>";

$pgsql = new Conexion();

$sql = "SELECT cdescripcion as motivo,nid_motivorazon as id 
FROM facturacion.tmotivo_razon
ORDER BY cdescripcion DESC";
$query = $pgsql->Ejecutar($sql);
while ($row = $pgsql->Respuesta($query)){
	$tbHtml .= "<tr>
    <td style='width:10%;'>".$row['id']."</td>
    <td align='left'>".utf8_decode($row['motivo'])."</td>
    </tr>"; 

}

$tbHtml .= "</table>";
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=motivos_o_razones.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
 
?>
