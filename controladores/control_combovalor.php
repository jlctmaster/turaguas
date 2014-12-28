<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construnid_combovalora.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_combovalor']))
  $nid_combovalor=trim($_POST['nid_combovalor']);

if(isset($_POST['ctabla']))
  $ctabla=trim($_POST['ctabla']);

if(isset($_POST['cdescripcion']))
  $cdescripcion=trim($_POST['cdescripcion']);

include_once("../clases/class_combovalor.php");
$combovalor=new Combovalor();
if($operacion=='Registrar'){
  $combovalor->nid_combovalor($nid_combovalor);
  $combovalor->ctabla($ctabla);
  $combovalor->cdescripcion($cdescripcion);
  if(!$combovalor->Comprobar()){
    if($combovalor->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($combovalor->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($combovalor->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El valor del combo ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?combovalor#combovalor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el valor del combo.";
    header("Location: ../vistas/menu_principal.php?combovalor#combovalor");
  }
}

if($operacion=='Modificar'){
  $combovalor->nid_combovalor($nid_combovalor);
  $combovalor->ctabla($ctabla);
  $combovalor->cdescripcion($cdescripcion);
  if($combovalor->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El valor del combo ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?combovalor#combovalor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el valor del combo.";
    header("Location: ../vistas/menu_principal.php?combovalor#combovalor");
  }
}

if($operacion=='Desactivar'){
  $combovalor->nid_combovalor($nid_combovalor);
  $combovalor->ctabla($ctabla);
  $combovalor->cdescripcion($cdescripcion);
  if($combovalor->Consultar()){
    if($combovalor->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El valor del combo ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?combovalor#combovalor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el valor del combo.";
    header("Location: ../vistas/menu_principal.php?combovalor#combovalor");
  }
}

if($operacion=='Activar'){
  $combovalor->nid_combovalor($nid_combovalor);
  $combovalor->ctabla($ctabla);
  $combovalor->cdescripcion($cdescripcion);
  if($combovalor->Consultar()){
    if($combovalor->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El valor del combo ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?combovalor#combovalor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el valor del combo.";
    header("Location: ../vistas/menu_principal.php?combovalor#combovalor");
  }
}

if($operacion=='Consultar'){	
  $combovalor->nid_combovalor($nid_combovalor);
  $combovalor->ctabla($ctabla);
  $combovalor->cdescripcion($cdescripcion);
  if($combovalor->Consultar()){
    $_SESSION['datos']['nid_combovalor']=$combovalor->nid_combovalor();
    $_SESSION['datos']['ctabla']=$combovalor->ctabla();
    $_SESSION['datos']['cdescripcion']=$combovalor->cdescripcion();
    $_SESSION['datos']['estatus_combovalor']=$combovalor->estatus_combovalor();
    header("Location: ../vistas/menu_principal.php?combovalor#combovalor");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?combovalor#combovalor");
  }
}		  
?>