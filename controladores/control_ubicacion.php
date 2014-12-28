<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_ubicacion']))
  $nid_ubicacion=trim($_POST['nid_ubicacion']);

if(isset($_POST['cpunto_referencia']))
  $cpunto_referencia=trim($_POST['cpunto_referencia']);

if(isset($_POST['cdescripcion']))
  $cdescripcion=trim($_POST['cdescripcion']);

include_once("../clases/class_ubicacion.php");
$ubicacion=new ubicacion();
if($operacion=='Registrar'){
  $ubicacion->nid_ubicacion($nid_ubicacion);
  $ubicacion->cpunto_referencia($cpunto_referencia);
  $ubicacion->cdescripcion($cdescripcion);
  if(!$ubicacion->Comprobar()){
    if($ubicacion->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($ubicacion->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($ubicacion->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La ubicación ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?localizador#ubicacion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la ubicación.";
    header("Location: ../vistas/menu_principal.php?localizador#ubicacion");
  }
}

if($operacion=='Modificar'){
  $ubicacion->nid_ubicacion($nid_ubicacion);
  $ubicacion->cpunto_referencia($cpunto_referencia);
  $ubicacion->cdescripcion($cdescripcion);
  if($ubicacion->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La ubicación ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?localizador#ubicacion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la ubicación.";
    header("Location: ../vistas/menu_principal.php?localizador#ubicacion");
  }
}

if($operacion=='Desactivar'){
  $ubicacion->nid_ubicacion($nid_ubicacion);
  $ubicacion->cpunto_referencia($cpunto_referencia);
  $ubicacion->cdescripcion($cdescripcion);
  if($ubicacion->Consultar()){
    if($ubicacion->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La ubicación ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?localizador#ubicacion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la ubicación.";
    header("Location: ../vistas/menu_principal.php?localizador#ubicacion");
  }
}

if($operacion=='Activar'){
  $ubicacion->nid_ubicacion($nid_ubicacion);
  $ubicacion->cpunto_referencia($cpunto_referencia);
  $ubicacion->cdescripcion($cdescripcion);
  if($ubicacion->Consultar()){
    if($ubicacion->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La ubicación ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?localizador#ubicacion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la ubicación.";
    header("Location: ../vistas/menu_principal.php?localizador#ubicacion");
  }
}

if($operacion=='Consultar'){	
  $ubicacion->nid_ubicacion($nid_ubicacion);
  $ubicacion->cpunto_referencia($cpunto_referencia);
  $ubicacion->cdescripcion($cdescripcion);
  if($ubicacion->Consultar()){
    $_SESSION['datos']['nid_ubicacionlocalizador']=$ubicacion->nid_ubicacion();
    $_SESSION['datos']['cpunto_referencialocalizador']=$ubicacion->cpunto_referencia();
    $_SESSION['datos']['cdescripcionlocalizador']=$ubicacion->cdescripcion();
    $_SESSION['datos']['estatuslocalizador']=$ubicacion->estatus_ubicacion();
    header("Location: ../vistas/menu_principal.php?localizador#ubicacion");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?localizador#ubicacion");
  }
}		  
?>