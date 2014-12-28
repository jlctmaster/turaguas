<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_motivodevolucion']))
  $nid_motivodevolucion=trim($_POST['nid_motivodevolucion']);

if(isset($_POST['nid_motivodevolucion_padre']))
  $nid_motivodevolucion_padre=trim($_POST['nid_motivodevolucion_padre']);

if(isset($_POST['cdescripcionmotivo']))
  $cdescripcionmotivo=trim($_POST['cdescripcionmotivo']);

include_once("../clases/class_motivodevolucion.php");
$motivo=new MotivoDev();
if($operacion=='Registrar'){
  $motivo->nid_motivodevolucion($nid_motivodevolucion);
  $motivo->nid_motivodevolucion_padre($nid_motivodevolucion_padre);
  $motivo->cdescripcionmotivo($cdescripcionmotivo);
  if(!$motivo->Comprobar()){
    if($motivo->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($motivo->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($motivo->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El motivo ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#motivodev");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el motivo.";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#motivodev");
  }
}

if($operacion=='Modificar'){
  $motivo->nid_motivodevolucion($nid_motivodevolucion);
  $motivo->cdescripcionmotivo($cdescripcionmotivo);
  if($motivo->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El motivo ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#motivodev");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el motivo.";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#motivodev");
  }
}

if($operacion=='Desactivar'){
  $motivo->nid_motivodevolucion($nid_motivodevolucion);
  $motivo->cdescripcionmotivo($cdescripcionmotivo);
  if($motivo->Consultar()){
    if($motivo->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El motivo ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#motivodev");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el motivo.";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#motivodev");
  }
}

if($operacion=='Activar'){
  $motivo->nid_motivodevolucion($nid_motivodevolucion);
  $motivo->cdescripcion($cdescripcion);
  if($motivo->Consultar()){
    if($motivo->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El motivo ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#motivodev");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el motivo.";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#motivodev");
  }
}

if($operacion=='Consultar'){	
  $motivo->nid_motivodevolucion($nid_motivodevolucion);
  $motivo->cdescripcionmotivo($cdescripcionmotivo);
  if($motivo->Consultar()){
    $_SESSION['datos']['nid_motivodevolucion_padre']=$motivo->nid_motivodevolucion_padre();
    $_SESSION['datos']['nid_motivodevolucion']=$motivo->nid_motivodevolucion();
    $_SESSION['datos']['cdescripcionmotivo']=$motivo->cdescripcionmotivo();
    $_SESSION['datos']['cdescripciongrupo']=$motivo->cdescripciongrupo();
    $_SESSION['datos']['estatusmotivodev']=$motivo->estatus_motivo();
    header("Location: ../vistas/menu_principal.php?motivodevolucion#motivodev");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró ningún resultado con el filtro de búsqueda(".$cdescripcionmotivo.")";
    header("Location: ../vistas/menu_principal.php?motivodevolucion#motivodev");
  }
}		  
?>