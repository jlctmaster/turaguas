<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_unidadmedida']))
  $nid_unidadmedida=trim($_POST['nid_unidadmedida']);

if(isset($_POST['csimbolo']))
  $csimbolo=trim($_POST['csimbolo']);

if(isset($_POST['cdescripcion']))
  $cdescripcion=trim($_POST['cdescripcion']);

include_once("../clases/class_unidad.php");
$unidad=new unidad();
if($operacion=='Registrar'){
  $unidad->nid_unidadmedida($nid_unidadmedida);
  $unidad->csimbolo($csimbolo);
  $unidad->cdescripcion($cdescripcion);
  if(!$unidad->Comprobar()){
    if($unidad->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($unidad->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($unidad->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La unidad de medida ha sido registrada con exito!";
    header("Location: ../vistas/menu_principal.php?unidadmedida");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la unidad.";
    header("Location: ../vistas/menu_principal.php?unidadmedida");
  }
}

if($operacion=='Modificar'){
  $unidad->nid_unidadmedida($nid_unidadmedida);
  $unidad->csimbolo($csimbolo);
  $unidad->cdescripcion($cdescripcion);
  if($unidad->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La unidad de medida ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?unidadmedida");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la unidad de medida.";
    header("Location: ../vistas/menu_principal.php?unidadmedida");
  }
}

if($operacion=='Desactivar'){
  $unidad->nid_unidadmedida($nid_unidadmedida);
  $unidad->csimbolo($csimbolo);
  $unidad->cdescripcion($cdescripcion);
  if($unidad->Consultar()){
    if($unidad->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La unidad de medida ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?unidadmedida");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la unidad de medida.";
    header("Location: ../vistas/menu_principal.php?unidadmedida");
  }
}

if($operacion=='Activar'){
  $unidad->nid_unidadmedida($nid_unidadmedida);
  $unidad->csimbolo($csimbolo);
  $unidad->cdescripcion($cdescripcion);
  if($unidad->Consultar()){
    if($unidad->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La unidad de medida ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?unidadmedida");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la unidad de medida.";
    header("Location: ../vistas/menu_principal.php?unidadmedida");
  }
}

if($operacion=='Consultar'){	
  $unidad->nid_unidadmedida($nid_unidadmedida);
  $unidad->csimbolo($csimbolo);
  $unidad->cdescripcion($cdescripcion);
  if($unidad->Consultar()){
    $_SESSION['datos']['nid_unidadmedida']=$unidad->nid_unidadmedida();
    $_SESSION['datos']['csimbolo']=$unidad->csimbolo();
    $_SESSION['datos']['cdescripcion']=$unidad->cdescripcion();
    $_SESSION['datos']['estatus']=$unidad->estatus_unidad();
    header("Location: ../vistas/menu_principal.php?unidadmedida");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?unidadmedida");
  }
}		  
?>