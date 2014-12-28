<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_motivodevolucion']))
  $nid_motivodevolucion=trim($_POST['nid_motivodevolucion']);

if(isset($_POST['cdescripcion']))
  $cdescripcion=trim($_POST['cdescripcion']);

include_once("../clases/class_grupo.php");
$grupo=new Grupo();
if($operacion=='Registrar'){
  $grupo->nid_motivodevolucion($nid_motivodevolucion);
  $grupo->cdescripcion($cdescripcion);
  if(!$grupo->Comprobar()){
    if($grupo->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($grupo->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($grupo->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El grupo de motivos ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#grupo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el grupo de motivos.";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#grupo");
  }
}

if($operacion=='Modificar'){
  $grupo->nid_motivodevolucion($nid_motivodevolucion);
  $grupo->cdescripcion($cdescripcion);
  if($grupo->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El grupo de motivos ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#grupo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el grupo de motivos.";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#grupo");
  }
}

if($operacion=='Desactivar'){
  $grupo->nid_motivodevolucion($nid_motivodevolucion);
  $grupo->cdescripcion($cdescripcion);
  if($grupo->Consultar()){
    if($grupo->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El grupo de motivos ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#grupo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el grupo de motivos.";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#grupo");
  }
}

if($operacion=='Activar'){
  $grupo->nid_motivodevolucion($nid_motivodevolucion);
  $grupo->cdescripcion($cdescripcion);
  if($grupo->Consultar()){
    if($grupo->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="el grupo de motivos ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#grupo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el grupo de motivos.";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#grupo");
  }
}

if($operacion=='Consultar'){	
  $grupo->nid_motivodevolucion($nid_motivodevolucion);
  $grupo->cdescripcion($cdescripcion);
  if($grupo->Consultar()){
    $_SESSION['datos']['nid_motivodevoluciongrupo']=$grupo->nid_motivodevolucion();
    $_SESSION['datos']['cdescripciongrupo']=$grupo->cdescripcion();
    $_SESSION['datos']['estatusgrupo']=$grupo->estatus_grupo();
    header("Location: ../vistas/menu_principal.php?motivodevolucion#grupo");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#grupo");
  }
}		  
?>