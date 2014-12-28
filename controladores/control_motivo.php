<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_motivorazon']))
  $nid_motivorazon=trim($_POST['nid_motivorazon']);

if(isset($_POST['cdescripcion']))
  $cdescripcion=trim($_POST['cdescripcion']);

include_once("../clases/class_motivo.php");
$motivo=new Motivo();
if($operacion=='Registrar'){
  $motivo->nid_motivorazon($nid_motivorazon);
  $motivo->cdescripcion($cdescripcion);
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
    $_SESSION['datos']['mensaje']="El motivo/razon ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?motivorazon");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el motivo/razon.";
    header("Location: ../vistas/menu_principal.php?motivorazon");
  }
}

if($operacion=='Modificar'){
  $motivo->nid_motivorazon($nid_motivorazon);
  $motivo->cdescripcion($cdescripcion);
  if($motivo->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El motivo/razon ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?motivorazon");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el motivo/razon.";
    header("Location: ../vistas/menu_principal.php?motivorazon");
  }
}

if($operacion=='Desactivar'){
  $motivo->nid_motivorazon($nid_motivorazon);
  $motivo->cdescripcion($cdescripcion);
  if($motivo->Consultar()){
    if($motivo->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El motivo/razon ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?motivorazon");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el motivo/razon.";
    header("Location: ../vistas/menu_principal.php?motivorazon");
  }
}

if($operacion=='Activar'){
  $motivo->nid_motivorazon($nid_motivorazon);
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
    $_SESSION['datos']['mensaje']="El motivo/razon ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?motivorazon");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el motivo/razon.";
    header("Location: ../vistas/menu_principal.php?motivorazon");
  }
}

if($operacion=='Consultar'){	
  $motivo->nid_motivorazon($nid_motivorazon);
  $motivo->cdescripcion($cdescripcion);
  if($motivo->Consultar()){
    $_SESSION['datos']['nid_motivorazon']=$motivo->nid_motivorazon();
    $_SESSION['datos']['cdescripcion']=$motivo->cdescripcion();
    $_SESSION['datos']['estatus']=$motivo->estatus_motivo();
    header("Location: ../vistas/menu_principal.php?motivorazon");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?motivorazon");
  }
}		  
?>