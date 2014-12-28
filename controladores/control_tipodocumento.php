<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construnida.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_tipodocumento']))
  $nid_tipodocumento=trim($_POST['nid_tipodocumento']);

if(isset($_POST['cdescripcion']))
  $cdescripcion=trim($_POST['cdescripcion']);

if(isset($_POST['nfactor']))
  $nfactor=trim($_POST['nfactor']);

if(isset($_POST['ctipo_transaccion']))
  $ctipo_transaccion=trim($_POST['ctipo_transaccion']);

function comprobarCheckBox($value){
  if($value == "on")
    $chk = "V";
  else
    $chk = "C";
  return $chk;
}

include_once("../clases/class_tipodocumento.php");
$tipodocumento=new Tipodocumento();
if($operacion=='Registrar'){
  $tipodocumento->nid_tipodocumento($nid_tipodocumento);
  $tipodocumento->cdescripcion($cdescripcion);
  $tipodocumento->nfactor($nfactor);
  $tipodocumento->ctipo_transaccion(comprobarCheckBox($ctipo_transaccion));
  if(!$tipodocumento->Comprobar()){
    if($tipodocumento->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($tipodocumento->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($tipodocumento->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El tipo de documento ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?tipodocumento");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el tipo de documento.";
    header("Location: ../vistas/menu_principal.php?tipodocumento");
  }
}

if($operacion=='Modificar'){
  $tipodocumento->nid_tipodocumento($nid_tipodocumento);
  $tipodocumento->cdescripcion($cdescripcion);
  $tipodocumento->nfactor($nfactor);
  $tipodocumento->ctipo_transaccion(comprobarCheckBox($ctipo_transaccion));
  if($tipodocumento->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El tipo de documento ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?tipodocumento");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el tipo de documento.";
    header("Location: ../vistas/menu_principal.php?tipodocumento");
  }
}

if($operacion=='Desactivar'){
  $tipodocumento->nid_tipodocumento($nid_tipodocumento);
  $tipodocumento->cdescripcion($cdescripcion);
  $tipodocumento->nfactor($nfactor);
  if($tipodocumento->Consultar()){
    if($tipodocumento->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El tipo de documento ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?tipodocumento");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el tipo de documento.";
    header("Location: ../vistas/menu_principal.php?tipodocumento");
  }
}

if($operacion=='Activar'){
  $tipodocumento->nid_tipodocumento($nid_tipodocumento);
  $tipodocumento->cdescripcion($cdescripcion);
  $tipodocumento->nfactor($nfactor);
  if($tipodocumento->Consultar()){
    if($tipodocumento->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El tipo de documento ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?tipodocumento");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el tipo de documento.";
    header("Location: ../vistas/menu_principal.php?tipodocumento");
  }
}

if($operacion=='Consultar'){	
  $tipodocumento->nid_tipodocumento($nid_tipodocumento);
  $tipodocumento->cdescripcion($cdescripcion);
  $tipodocumento->nfactor($nfactor);
  if($tipodocumento->Consultar()){
    $_SESSION['datos']['nid_tipodocumento']=$tipodocumento->nid_tipodocumento();
    $_SESSION['datos']['cdescripcion']=$tipodocumento->cdescripcion();
    $_SESSION['datos']['nfactor']=$tipodocumento->nfactor();
    $_SESSION['datos']['ctipo_transaccion']=$tipodocumento->ctipo_transaccion();
    $_SESSION['datos']['estatus']=$tipodocumento->estatus_tipodocumento();
    header("Location: ../vistas/menu_principal.php?tipodocumento");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?tipodocumento");
  }
}		  
?>