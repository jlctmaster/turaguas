<?php
require_once("../clases/class_bd.php");

$tbHtml = "<table style='width:100%;'>
             <header>
                <tr style='width:100%;'>
                <th style='width:20%;'>RIF o C&eacute;dula  </th>
               <th align='left'>Nombre</th>
               <th align='left'>Tlf de Habitaci&oacute;n</th>
               <th align='left'>Email</th>
               <th align='left'>Dirección</th>
               <th align='left'>Rol o Cargo</th>
                </tr>
            </header>";

$pgsql = new Conexion();

  $sql = "SELECT p.crif_persona,p.cnombre,p.ctelefhab,p.cemail,r.cdescripcion rol, p.cdireccion 
		FROM general.tpersona p 
		INNER JOIN general.trol r ON p.nid_rol = r.nid_rol 
		INNER JOIN general.tcombo_valor c ON p.ntipo_persona = c.nid_combovalor 
    WHERE LOWER(c.cdescripcion) LIKE '%empleado%'
		ORDER BY p.crif_persona DESC";
  $query = $pgsql->Ejecutar($sql);
  while ($row = $pgsql->Respuesta($query)){
  	$tbHtml .= "<tr>
      <td style='width:20%;'>".$row['crif_persona']."</td>
      <td align='left'>".$row['cnombre']."</td>
      <td align='left'>".$row['ctelefhab']."</td>
      <td align='left'>".$row['cemail']."</td>
      <td align='left'>".$row['cdireccion']."</td>
      <td align='left'>".$row['rol']."</td>
      </tr>"; 
  }

$tbHtml .= "</table>";
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Empleados.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
 
?>