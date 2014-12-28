<?php
require_once("../clases/class_bd.php");

$tbHtml = "<table>
             <header>
                <tr>
                  <th>C&oacute;digo</th>
                  <th>Carrera</th>
                </tr>
            </header>";

$mysql = new Conexion();
$sql = "SELECT c.cod_carrera, c.nombre_carrera, CONCAT( u.rif,  ' - ', u.nombre_corto ) universidad FROM tcarrera c 
INNER JOIN tuniversidad u ON c.rif = u.rif WHERE c.fecha_desactivacion IS NULL ORDER BY cod_carrera DESC";
$query = $mysql->Ejecutar($sql);
while ($row = $mysql->Respuesta($query)){
	$tbHtml .= "<tr><td>".$row['cod_carrera']."</td><td>".$row['nombre_carrera']."</td></tr>";
}

$tbHtml .= "</table>";
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=carreras.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
 
?>