<?php
require_once("../clases/class_bd.php");

$tbHtml = "<table style='width:100%;'>
             <header>
                <tr style='width:100%;'>
                  <th style='width:20%;'> C&oacute;digo </th>
               <th align='left'>Nombre del Art&iacute;culo</th>
               <th align='left'>C&oacute;digo</th>
               <th align='left'>Tipo de Art&iacute;culo</th>
               <th align='left'>C&oacute;digo</th>
               <th align='left'>Unidad de Medida</th>
               <th align='left'>C&oacute;digo</th>
               <th align='left'>Categor&iacute;a</th>
               <th align='left'>C&oacute;digo</th>
               <th align='left'>Presentaci&oacute;n</th>
                </tr>
            </header>";

$pgsql = new Conexion();

$sql = "SELECT a.cid_articulo as articulo,a.cdescripcion as nom_articulo,a.nid_tipoarticulo,ti.cdescripcion as nom_tipoarticulo,a.nid_presentacion,p.cdescripcion as nom_presentacion,a.nid_categoria,c.cdescripcion as nom_categoria,a.nid_unidadmedida,u.cdescripcion as nom_unidadmedida 
FROM inventario.tarticulo a 
INNER JOIN inventario.ttipo_articulo ti ON a.nid_tipoarticulo = ti.nid_tipoarticulo
INNER JOIN inventario.tpresentacion p ON a.nid_presentacion = p.nid_presentacion
INNER JOIN inventario.tcategoria c ON a.nid_categoria = c.nid_categoria
INNER JOIN inventario.tunidad_medida u ON a.nid_unidadmedida = u.nid_unidadmedida
ORDER BY a.cid_articulo DESC";
$query = $pgsql->Ejecutar($sql);
while ($row = $pgsql->Respuesta($query)){
	$tbHtml .= "<tr>
    <td style='width:20%;'>".$row['articulo']."</td>
    <td align='left'>".$row['nom_articulo']."</td>
    <td align='left'>".$row['nid_tipoarticulo']."</td>
    <td align='left'>".$row['nom_tipoarticulo']."</td>
    <td align='left'>".$row['nid_unidadmedida']."</td>
    <td align='left'>".$row['nom_unidadmedida']."</td>
    <td align='left'>".$row['nid_categoria']."</td>
    <td align='left'>".$row['nom_categoria']."</td>
    <td align='left'>".$row['nid_presentacion']."</td>
    <td align='left'>".$row['nom_presentacion']."</td>
    </tr>"; 

}

$tbHtml .= "</table>";
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=articulos.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
 
?>