<?php
require_once("../clases/class_bd.php");

$tbHtml = "<table style='width:100%;'>
             <header>
                <tr style='width:100%;'>
                  <th style='width:20%;'> C&oacute;digo </th>
               <th align='left'>Tipo de documento</th>
               <th align='left'>De</th>
                </tr>
            </header>";

$pgsql = new Conexion();

$sql = "SELECT cdescripcion as tipo,nid_tipodocumento as id, case nfactor when -1 then 'EGRESO' else 'INGRESO' end factor
FROM facturacion.ttipo_documento
ORDER BY cdescripcion ASC";
$query = $pgsql->Ejecutar($sql);
while ($row = $pgsql->Respuesta($query)){
	$tbHtml .= "<tr>
    <td style='width:10%;'>".$row['id']."</td>
    <td align='left'>".$row['tipo']."</td>
    <td align='left'>".$row['factor']."</td>
    </tr>"; 

}

$tbHtml .= "</table>";
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Tipos_de_documento.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
 
?>
