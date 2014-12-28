<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construnid_tipopersona.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_tipopersona']))
  $nid_tipopersona=trim($_POST['nid_tipopersona']);

if(isset($_POST['cdescripcion']))
  $cdescripcion=trim($_POST['cdescripcion']);

include_once("../clases/class_tipopersona.php");
$tipopersona=new Tipopersona();
if($operacion=='Registrar'){
  $tipopersona->nid_tipopersona($nid_tipopersona);
  $tipopersona->cdescripcion($cdescripcion);
  if(!$tipopersona->Comprobar()){
    if($tipopersona->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($tipopersona->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($tipopersona->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El tipo de persona ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?tipopersona");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el tipo de persona.";
    header("Location: ../vistas/menu_principal.php?tipopersona");
  }
}

if($operacion=='Modificar'){
  $tipopersona->nid_tipopersona($nid_tipopersona);
  $tipopersona->cdescripcion($cdescripcion);
  if($tipopersona->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El tipo de persona ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?tipopersona");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el tipo persona.";
    header("Location: ../vistas/menu_principal.php?tipopersona");
  }
}

if($operacion=='Desactivar'){
  $tipopersona->nid_tipopersona($nid_tipopersona);
  $tipopersona->cdescripcion($cdescripcion);
  if($tipopersona->Consultar()){
    if($tipopersona->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El tipo de persona ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?tipopersona");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el tipo de persona.";
    header("Location: ../vistas/menu_principal.php?tipopersona");
  }
}

if($operacion=='Activar'){
  $tipopersona->nid_tipopersona($nid_tipopersona);
  $tipopersona->cdescripcion($cdescripcion);
  if($tipopersona->Consultar()){
    if($tipopersona->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El tipo de persona ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?tipopersona");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el tipo de persona.";
    header("Location: ../vistas/menu_principal.php?tipopersona");
  }
}

if($operacion=='Consultar'){	
  $tipopersona->nid_tipopersona($nid_tipopersona);
  $tipopersona->cdescripcion($cdescripcion);
  if($tipopersona->Consultar()){
    $_SESSION['datos']['nid_tipopersona']=$tipopersona->nid_tipopersona();
    $_SESSION['datos']['cdescripcion']=$tipopersona->cdescripcion();
    $_SESSION['datos']['estatus']=$tipopersona->estatus_tipopersona();
    header("Location: ../vistas/menu_principal.php?tipopersona");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?tipopersona");
  }
}		  
?>