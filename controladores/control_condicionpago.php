<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construnid_condicionpago.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_condicionpago']))
  $nid_condicionpago=trim($_POST['nid_condicionpago']);

if(isset($_POST['cdescripcion']))
  $cdescripcion=trim($_POST['cdescripcion']);

include_once("../clases/class_condicionpago.php");
$condicionpago=new Condicionpago();
if($operacion=='Registrar'){
  $condicionpago->nid_condicionpago($nid_condicionpago);
  $condicionpago->cdescripcion($cdescripcion);
  if(!$condicionpago->Comprobar()){
    if($condicionpago->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($condicionpago->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($condicionpago->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La condición de pago ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?condicionpago");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la condición de pago.";
    header("Location: ../vistas/menu_principal.php?condicionpago");
  }
}

if($operacion=='Modificar'){
  $condicionpago->nid_condicionpago($nid_condicionpago);
  $condicionpago->cdescripcion($cdescripcion);
  if($condicionpago->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La condición de pago ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?condicionpago");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la condición de pago.";
    header("Location: ../vistas/menu_principal.php?condicionpago");
  }
}

if($operacion=='Desactivar'){
  $condicionpago->nid_condicionpago($nid_condicionpago);
  $condicionpago->cdescripcion($cdescripcion);
  if($condicionpago->Consultar()){
    if($condicionpago->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La condición de pago ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?condicionpago");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la condición de pago.";
    header("Location: ../vistas/menu_principal.php?condicionpago");
  }
}

if($operacion=='Activar'){
  $condicionpago->nid_condicionpago($nid_condicionpago);
  $condicionpago->cdescripcion($cdescripcion);
  if($condicionpago->Consultar()){
    if($condicionpago->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La condicion de pago ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?condicionpago");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la condicion de pago.";
    header("Location: ../vistas/menu_principal.php?condicionpago");
  }
}

if($operacion=='Consultar'){	
  $condicionpago->nid_condicionpago($nid_condicionpago);
  $condicionpago->cdescripcion($cdescripcion);
  if($condicionpago->Consultar()){
    $_SESSION['datos']['nid_condicionpago']=$condicionpago->nid_condicionpago();
    $_SESSION['datos']['cdescripcion']=$condicionpago->cdescripcion();
    $_SESSION['datos']['estatus']=$condicionpago->estatus_condicionpago();
    header("Location: ../vistas/menu_principal.php?condicionpago");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?condicionpago");
  }
}		  
?>