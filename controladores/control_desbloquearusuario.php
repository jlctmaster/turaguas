<?php
session_start();
if(isset($_POST['operacion']))
$operacion=ucfirst(trim($_POST['operacion']));

include_once("../clases/class_usuario.php");
$usuario = new Usuario();
$confirmacion=0;
if($operacion=='DesbloquearUsuario'){
	if(isset($_POST['bloqueados'])){               
	  foreach($_POST['bloqueados'] as $indice => $valor){
	    $usuario->cnombreusuario($valor);
	    if($usuario->DesbloquearUsuario())
	    	$confirmacion++;
	    else
	    	$confirmacion=0;
	  }                                                        
	}
	if($confirmacion!=0){
		$_SESSION['datos']['mensaje']="Se han desbloqueado los usuarios correctamente!";
		header("Location: ../vistas/menu_principal.php?desbloquearusuario");
	}else{
		$_SESSION['datos']['mensaje']="Ocurrió un error al desbloquear los usuarios.";
		header("Location: ../vistas/menu_principal.php?desbloquearusuario");
	}
}
?>