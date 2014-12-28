<?php
require_once("../clases/class_bd.php");

$tbHtml = "<table style='width:100%;'>
             <header>
                <tr style='width:100%;'>
                  <th style='width:20%;'> C&oacute;digo </th>
               <th align='left'>Nombre de la condici&oacute;n de pago</th>
                </tr>
            </header>";

$pgsql = new Conexion();

$sql = "SELECT cdescripcion as condicionpago,nid_condicionpago as id
FROM facturacion.tcondicion_pago
ORDER BY cdescripcion DESC";
$query = $pgsql->Ejecutar($sql);
while ($row = $pgsql->Respuesta($query)){
	$tbHtml .= "<tr>
    <td style='width:10%;'>".$row['id']."</td>
    <td align='left'>".$row['condicionpago']."</td>
    </tr>"; 

}

$tbHtml .= "</table>";
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=condiciones_de_pago.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
 
?>
