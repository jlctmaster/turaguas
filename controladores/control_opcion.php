<?php
session_start();
if(isset($_POST['operacion']))
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_opcion']))
$nid_opcion=trim($_POST['nid_opcion']);

if(isset($_POST['cnombreopcion']))
$cnombreopcion=trim($_POST['cnombreopcion']);

if(isset($_POST['norden']))
$norden=trim($_POST['norden']);

include_once("../clases/class_opcion.php");
$opciones=new Opcion();
if($operacion=='Registrar'){
  $opciones->nid_opcion($nid_opcion);
  $opciones->cnombreopcion($cnombreopcion);
  $opciones->norden($norden);
  if(!$opciones->Comprobar()){
    if($opciones->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($opciones->fecha_desactivacion()==null)
      $confirmacion=0;
    else{
      if($opciones->Activar($_SESSION['user_name']))					  
        $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El botón ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?botones#botonera");
   }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el botón.";
    header("Location: ../vistas/menu_principal.php?botones#botonera");
  }
}

if($operacion=='Modificar'){
  $opciones->nid_opcion($nid_opcion);
  $opciones->cnombreopcion($cnombreopcion);
  $opciones->norden($norden);
  if($opciones->Actualizar($_SESSION['user_name']))
  $confirmacion=1;
  else
  $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El botón ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?botones#botonera");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el botón.";
    header("Location: ../vistas/menu_principal.php?botones#botonera");
  }
}

if($operacion=='Desactivar'){
  $opciones->nid_opcion($nid_opcion);
  $opciones->cnombreopcion($cnombreopcion);
  if($opciones->Consultar()){
    if($opciones->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
    else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El botón ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?botones#botonera");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el botón.";
    header("Location: ../vistas/menu_principal.php?botones#botonera");
  }
}

if($operacion=='Activar'){
  $opciones->nid_opcion($nid_opcion);
  $opciones->cnombreopcion($cnombreopcion);
  if($opciones->Consultar()){
    if($opciones->Activar($_SESSION['user_name']))
    $confirmacion=1;
    else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El botón ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?botones#botonera");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el botón.";
    header("Location: ../vistas/menu_principal.php?botones#botonera");
  }
}

if($operacion=='Consultar'){	
  $opciones->nid_opcion($nid_opcion);
  $opciones->cnombreopcion($cnombreopcion);
  if($opciones->Consultar()){
    $_SESSION['datos']['nid_opcion']=$opciones->nid_opcion();
    $_SESSION['datos']['cnombreopcion']=$opciones->cnombreopcion();
    $_SESSION['datos']['estatus']=$opciones->estatus_opciones();
    $_SESSION['datos']['norden']=$opciones->norden();
    header("Location: ../vistas/menu_principal.php?botones#botonera");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cnombreopcion.")";
    header("Location: ../vistas/menu_principal.php?botones#botonera");
  }
}
?>