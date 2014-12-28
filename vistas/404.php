<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>El Futuro de las Turaguas</title>
</head>
<body style="background-color: rgb(173, 140, 140);">
<header>
<div class="front-signin" style="background:none; margin:0 auto;">
<center>  
    <img src="/turaguas/images/404.png" alt="" ><br>
    <img src="/turaguas/images/home.png" alt="" style="width:80px; height:80px;cursor:pointer" onclick="location.href='/turaguas/index.php'">   
      <br>
</center>
</div>
</header>
<center>
	<footer>
		<p>&copy 
			<?php 
			require_once('../clases/class_bd.php'); 
			$pgsql=new Conexion();
            $sql = "SELECT cnombre_empresa FROM seguridad.tsistema";
            $query = $pgsql->Ejecutar($sql);
            while ($row = $pgsql->Respuesta($query)){
            	echo $row['cnombre_empresa'];
            }
			?> 2014</p>
	</footer>
</center>
</body>
</html>