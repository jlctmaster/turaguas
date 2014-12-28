<?php
require_once("../clases/class_bd.php");

$tbHtml = "<table style='width:100%;'>
             <header>
                <tr style='width:100%;'>
                  <th style='width:20%;'>C&oacute;digo</th>
               <th align='left'>Sub-categor&iacute;a</th>
               <th align='left'>C&oacute;digo</th>
               <th align='left'>Categor&iacute;a</th>
                </tr>
            </header>";

$pgsql = new Conexion();

$sql = "SELECT c.cdescripcion as categoria,c.nid_categoria as id,s.cdescripcion as subcategoria,s.nid_categoria as idsub
FROM inventario.tcategoria c INNER JOIN inventario.tcategoria s ON s.nid_categoria = c.nid_categoria_padre
$clausuleWhere AND c.dfecha_desactivacion IS NULL
ORDER BY s.cdescripcion DESC";
$query = $pgsql->Ejecutar($sql);
while ($row = $pgsql->Respuesta($query)){
	$tbHtml .= "<tr>
    <td style='width:20%;'>".$row['idsub']."</td>
    <td align='left'>".$row['subcategoria']."</td>
    <td align='left'>".$row['id']."</td>
    <td align='left'>".$row['categoria']."</td>
    </tr>"; 

}

$tbHtml .= "</table>";
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Subcategorias.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
 
?>
