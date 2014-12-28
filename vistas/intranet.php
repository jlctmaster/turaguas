<?php session_start();?>
<!DOCTYPE html>
<html>
<head lang="es">
	<title>El Futuro de las Turaguas</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <!-- Load JQuery-->
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/jquery.ui.datepicker-es.js"></script>
    <script src="../js/jquery-ui-timepicker.js"></script>
	<!-- Load Bootstrap Libreries-->
    <script src="../librerias/bootstrap/js/bootstrap.js"></script>
	<link rel="StyleSheet" type="text/css" href="../librerias/bootstrap/css/normalize.css">
	<link rel="StyleSheet" type="text/css" href="../librerias/bootstrap/css/bootstrap.css">
	<link rel="StyleSheet" type="text/css" href="../librerias/bootstrap/css/bootstrap-theme.css">
    <!-- Load Noty Libreries-->
   	<script type="text/javascript" src="../librerias/noty/jquery.noty.js"></script>
    <link rel="stylesheet" type="text/css" href="../librerias/noty/jquery.noty.css"/>
  	<link rel="stylesheet" type="text/css" href="../librerias/noty/noty_theme_default.css"/>
    <!-- Load System Files-->
	<link rel="StyleSheet" type="text/css" href="../css/style.css">
    <script type="text/javascript" src="../js/main.js"></script>
    <script type="text/javascript" src="../js/eft_usuario.js"></script>
</head>
<?php
      $url="#";	   
	   if(empty($_GET)){
	   $url="../controladores/control_login.php";	
	   }elseif($_GET['p']=="olvidar-clave" || $_GET['p']=="pregunta-seguridad"){
	   $url="../controladores/control_recuperar_clave.php";	
	   }elseif($_GET['p']=="cambiar-contrasena"){
	   $url="../controladores/control_cambiar_clave.php";	
	   }
?>
<body>
	<div class="contenido">
		<? include('header.html'); ?>
		<? include('menu.html'); ?>
	</div>
	<div class="container">
		<center>
			<form role="form" id="form" name="form" method="POST" action="<?=  $url; ?>" <?php if(isset($_GET['p']) and $_GET['p']=='cambiar-contrasena') echo "onsubmit='return validar_contrasena()'"?> >
				<!-- AUTHENTICATION!-->
	      		<?php if(empty($_GET['p'])){ ?> 
	      		 <div class="control-group"> 
		      		 <div class="controls">
				  		<div class="input-prepend">
				    		<span class="add-on"><i class="icon-user"></i></span>
				    		<input type="text" onKeyUp="this.value=this.value.toUpperCase()" name="usuario" id="usuario" placeholder="Introduce tu usuario"  title="Por favor coloque su nombre de usuario" required />
				  		</div>
				  		<br />
				  		<div class="input-prepend">
				    		<span class="add-on"><i class="icon-lock"></i></span>
				    		<input type="password" name="contrasena" id="contrasena" placeholder="Contraseña"  title="Por favor coloque su contraseña" required />
				  		</div>
			  		</div>
		  		</div>
		  		<?php } ?>
		  		<!-- END AUTHENTICATION!-->
	      		<!-- CHANGE TO PASSWORD!-->
	            <?php if(!empty($_GET['p']) and $_GET['p']=='cambiar-contrasena'
	             and isset($_SESSION['pregunta_respuesta']) and $_SESSION['pregunta_respuesta']==4){ 
					require_once('../clases/class_bd.php');
					$conexion = new Conexion();
					$sql = "SELECT c.* FROM seguridad.tconfiguracion c 
					INNER JOIN seguridad.tperfil p ON p.nid_configuracion = c.nid_configuracion 
					WHERE p.nid_perfil = '".$_SESSION['user_codigo_perfil']."'";
					$query=$conexion->Ejecutar($sql);
					if($Obj=$conexion->Respuesta($query)){
						echo "<input type='hidden' id='nlongitud_minclave' value='".$Obj['nlongitud_minclave']."' />";
						echo "<input type='hidden' id='nlongitud_maxclave' value='".$Obj['nlongitud_maxclave']."' />";
						echo "<input type='hidden' id='ncantidad_letrasmayusculas' value='".$Obj['ncantidad_letrasmayusculas']."' />";
						echo "<input type='hidden' id='ncantidad_letrasminusculas' value='".$Obj['ncantidad_letrasminusculas']."' />";
						echo "<input type='hidden' id='ncantidad_caracteresespeciales' value='".$Obj['ncantidad_caracteresespeciales']."' />";
						echo "<input type='hidden' id='ncantidad_numeros' value='".$Obj['ncantidad_numeros']."' />";
					}
	            ?> 
	      		<div class="control-group"> 
		      		<div class="controls">
				  		<div class="input-prepend">
				    		<span class="add-on"><i class="icon-lock"></i></span>
				    		<input type="password" name="contrasena_actual" id="contrasena_actual" title="Contraseña actual" value="<?php echo $_SESSION['user_passwd'];?>" readonly required />
				  		</div>
				  		<br />
				  		<div class="input-prepend">
				    		<span class="add-on"><i class="icon-lock"></i></span>
				    		<input type="password" name="nueva_contrasena" id="nueva_contrasena" placeholder="Nueva Contraseña" title="Por favor coloque su nueva contraseña"  required>
				  		</div>
				  		<br />
				  		<div class="input-prepend">
				    		<span class="add-on"><i class="icon-lock"></i></span>
				    		<input type="password" name="confirmar_contrasena" id="confirmar_contrasena" placeholder="Repita la Contraseña" title="Por favor repita la contraseña ingresada" required>
				  		</div>
				  		<input type="hidden" name="cambiar_clave_sin_logeo"/>
			  		</div>
		  		</div>
		  		<?php } ?>
		  		<!-- END CHANGE TO PASSWORD!-->
	      		<!-- USER IDENTIFY!-->
	            <?php if(!empty($_GET['p']) and $_GET['p']=='olvidar-clave'){?>
	      		<div class="control-group"> 
		      		<div class="controls">
			            <div class="input-prepend">
				    		<span class="add-on"><i class="icon-user"></i></span>
				    		<input type="text" onKeyUp="this.value=this.value.toUpperCase()" name="user_name" id="user_name" placeholder="Introduce tu usuario" title="Por favor coloque su nombre de usuario" required>
				  		</div>
			  		</div>
		  		</div>
		  		<?php } ?>
		  		<!-- END USER IDENTIFY!-->
	      		<!-- SECRET QUESTION ANSWER!-->
	            <?php if(!empty($_GET['p']) and $_GET['p']=='pregunta-seguridad'){?>    
	      		<div class="control-group"> 
		      		<div class="controls">
		      			<input type='hidden' value="<?php echo $_SESSION['pregunta_respuesta'];?>" name="accion" />
		      			<?php
		      			if(isset($_SESSION['pregunta_respuesta'])){
			      			for($i=0;$i<$_SESSION['user_preguntas_a_responder'];$i++){
			      				for($j=0;$j<$_SESSION['user_numero_preguntas'];$j++){
			      					if($i==$j){
				      					echo "<div class='input-prepend'>";
					      				echo "<H5>¿".ucfirst($_SESSION['user_pregunta'][$j])."?</H5>";
					      				echo "</div><br />";
					      				echo "<div class='input-prepend'>
									    		<span class='add-on'><i class='icon-question-sign'></i></span>
									    		<input type='text' onKeyUp='this.value=this.value.toUpperCase()' name='respuesta[]' placeholder='Ingresa la respuesta...' title='Por favor ingrese la respuesta' required />
									  		</div><br />";
			      					}
			      				}
			      			}
			      		}
		      			?>
			  		</div>
		  		</div>
	            <?php } ?>
	      		<!-- END SECRET QUESTION ANSWER!-->
		  		<button type="submit" class="btn btn-default">Enviar</button>
		  		<br />
		  		<?php if(empty($_GET['p'])){?> 
		  		<p class="link">Olvidaste tu contrase&ntilde;a. click <a href="?p=olvidar-clave">aquí</a></p>
		  		<?php }else {?>
		          <br><img src="../images/home.png" alt="" style="width:80px; height:80px;cursor:pointer"
		           onclick="location.href='../index.php'">         
	            <?php }?>
			</form>
		</center>
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
<?php
if(isset($_SESSION['datos']['mensaje'])){
    echo "<script>alert('".$_SESSION['datos']['mensaje']."')</script>";	
   unset($_SESSION['datos']['mensaje']);	
   unset($_SESSION['pregunta_respuesta']);
	}
?>
