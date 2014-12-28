<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construnid_rol.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_rol']))
  $nid_rol=trim($_POST['nid_rol']);

if(isset($_POST['cdescripcion']))
  $cdescripcion=trim($_POST['cdescripcion']);

include_once("../clases/class_rol.php");
$rol=new Rol();
if($operacion=='Registrar'){
  $rol->nid_rol($nid_rol);
  $rol->cdescripcion($cdescripcion);
  if(!$rol->Comprobar()){
    if($rol->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($rol->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($rol->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El rol ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?roles");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el rol.";
    header("Location: ../vistas/menu_principal.php?roles");
  }
}

if($operacion=='Modificar'){
  $rol->nid_rol($nid_rol);
  $rol->cdescripcion($cdescripcion);
  if($rol->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El rol ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?roles");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el rol.";
    header("Location: ../vistas/menu_principal.php?roles");
  }
}

if($operacion=='Desactivar'){
  $rol->nid_rol($nid_rol);
  $rol->cdescripcion($cdescripcion);
  if($rol->Consultar()){
    if($rol->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El rol ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?roles");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el rol.";
    header("Location: ../vistas/menu_principal.php?roles");
  }
}

if($operacion=='Activar'){
  $rol->nid_rol($nid_rol);
  $rol->cdescripcion($cdescripcion);
  if($rol->Consultar()){
    if($rol->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El rol ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?roles");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el rol.";
    header("Location: ../vistas/menu_principal.php?roles");
  }
}

if($operacion=='Consultar'){	
  $rol->nid_rol($nid_rol);
  $rol->cdescripcion($cdescripcion);
  if($rol->Consultar()){
    $_SESSION['datos']['nid_rol']=$rol->nid_rol();
    $_SESSION['datos']['cdescripcion']=$rol->cdescripcion();
    $_SESSION['datos']['estatus']=$rol->estatus_rol();
    header("Location: ../vistas/menu_principal.php?roles");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?roles");
  }
}		  
?>