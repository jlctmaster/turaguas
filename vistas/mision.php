<!DOCTYPE html>
<html>
<head lang="es">
	<title>El Futuro de las Turaguas</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <!-- Load JQuery-->
    <script type="text/javascript" src="../js/jquery.js"></script>
	<!-- Load Bootstrap Libreries-->
	<link rel="StyleSheet" type="text/css" href="../librerias/bootstrap/css/bootstrap.css">
	<link rel="StyleSheet" type="text/css" href="../librerias/bootstrap/css/bootstrap-theme.css">
    <script type="text/javascript" src="../librerias/bootstrap/js/bootstrap.js"></script>
	<link rel="StyleSheet" type="text/css" href="../css/style.css">
</head>
<body>
	<div class="contenido">
		<? include('header.html');?>
		<? include('menu.html');?>
	</div>
	<div class="cuerpo">
		<div class="izquierdo"><a href="http://www.mpcomunas.gob.ve" /><img src='../images/enlace_comunas.png'></a>
		<a href="http://www.cva.gob.ve" /><img src='../images/enlace_cva.png'></a></div>
		<div class="centro"><span>
				<h3 class="text-center">Misión</h3>
				<p align="justify"><?php 
				require_once('../clases/class_bd.php'); 
				$pgsql=new Conexion();
	            $sql = "SELECT cmision FROM seguridad.tsistema";
	            $query = $pgsql->Ejecutar($sql);
	            while ($row = $pgsql->Respuesta($query)){
	            	echo $row['cmision'];
	            }
				?> </p>
                </span></div>
		<div class="derecho"><a href="http://www.fondemi.gob.ve" /><img src='../images/enlace_fondemi.png'></a>
		<a href="http://www.fundacomunal.gob.ve" /><img src='../images/enlace_funda_comunal.png'></a></div>	
	</div>
	<center>
		<footer>
			<p>&copy 
				<?php 
				require_once('../clases/class_bd.php'); 
				$pgsql=new Conexion();
	            $sql = "SELECT crif_empresa||' - '||cnombre_empresa As cnombre_empresa FROM seguridad.tsistema";
	            $query = $pgsql->Ejecutar($sql);
	            while ($row = $pgsql->Respuesta($query)){
	            	echo $row['cnombre_empresa'];
	            }
				?> 2014</p>
		</footer>	
	</center>
</body>
</html>
