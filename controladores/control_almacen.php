<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_ubicacionlocalizador']))
  $nid_ubicacion=trim($_POST['nid_ubicacionlocalizador']);

if(isset($_POST['nid_almacen']))
  $nid_almacen=trim($_POST['nid_almacen']);

if(isset($_POST['cdescripcionalmacen']))
  $cdescripcion=trim($_POST['cdescripcionalmacen']);

include_once("../clases/class_almacen.php");
$almacen=new Almacen();
if($operacion=='Registrar'){
  $almacen->nid_almacen($nid_almacen);
  $almacen->nid_ubicacion($nid_ubicacion);
  $almacen->cdescripcion($cdescripcion);
  if(!$almacen->Comprobar()){
    if($almacen->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($almacen->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($almacen->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El almacén ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?localizador#almacen");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el almacén.";
    header("Location: ../vistas/menu_principal.php?localizador#almacen");
  }
}

if($operacion=='Modificar'){
  $almacen->nid_ubicacion($nid_ubicacion);
  $almacen->nid_almacen($nid_almacen);
  $almacen->cdescripcion($cdescripcion);
  if($almacen->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El almacén ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?localizador#almacen");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el almacén.";
    header("Location: ../vistas/menu_principal.php?localizador#almacen");
  }
}

if($operacion=='Desactivar'){
  $almacen->nid_ubicacion($nid_ubicacion);
  $almacen->nid_almacen($nid_almacen);
  $almacen->cdescripcion($cdescripcion);
  if($almacen->Consultar()){
    if($almacen->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El almacén ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?localizador#almacen");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el almacén.";
    header("Location: ../vistas/menu_principal.php?localizador#almacen");
  }
}

if($operacion=='Activar'){
  $almacen->nid_ubicacion($nid_ubicacion);
  $almacen->nid_almacen($nid_almacen);
  $almacen->cdescripcion($cdescripcion);
  if($almacen->Consultar()){
    if($almacen->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El almacén ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?localizador#almacen");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el almacén.";
    header("Location: ../vistas/menu_principal.php?localizador#almacen");
  }
}

if($operacion=='Consultar'){	
  $almacen->nid_ubicacion($nid_ubicacion);
  $almacen->nid_almacen($nid_almacen);
  $almacen->cdescripcion($cdescripcion);
  if($almacen->Consultar()){
    $_SESSION['datos']['nid_ubicacionlocalizador']=$almacen->nid_ubicacion();
    $_SESSION['datos']['nid_almacen']=$almacen->nid_almacen();
    $_SESSION['datos']['cdescripcionalmacen']=$almacen->cdescripcion();
    $_SESSION['datos']['cdescripcionlocalizador']=$almacen->cnombreubicacion();
    $_SESSION['datos']['estatusalmacen']=$almacen->estatus_almacen();
    header("Location: ../vistas/menu_principal.php?localizador#almacen");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró ningún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?localizador#almacen");
  }
}		  
?>