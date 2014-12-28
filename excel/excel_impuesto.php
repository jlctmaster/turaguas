<?php
require_once("../clases/class_bd.php");

$tbHtml = "<table style='width:100%;'>
             <header>
                <tr style='width:100%;'>
                  <th style='width:20%;'> C&oacute;digo </th>
               <th align='left'>Impuesto</th>
               <th align='left'>Porcentaje</th>
                </tr>
            </header>";

$pgsql = new Conexion();

$sql = "SELECT cdescripcion as impuesto,nid_impuesto as id, nporcentaje || '%' as porcentaje
FROM facturacion.timpuesto
ORDER BY cdescripcion ASC";
$query = $pgsql->Ejecutar($sql);
while ($row = $pgsql->Respuesta($query)){
	$tbHtml .= "<tr>
    <td style='width:10%;'>".$row['id']."</td>
    <td align='left'>".$row['impuesto']."</td>
    <td align='left'>".$row['porcentaje']."</td>
    </tr>"; 

}

$tbHtml .= "</table>";
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Impuestos.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
 
?>
