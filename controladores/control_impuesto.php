<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construnida.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_impuesto']))
  $nid_impuesto=trim($_POST['nid_impuesto']);

if(isset($_POST['cdescripcion']))
  $cdescripcion=trim($_POST['cdescripcion']);

if(isset($_POST['nporcentaje']))
  $nporcentaje=trim($_POST['nporcentaje']);

include_once("../clases/class_impuesto.php");
$impuesto=new Impuesto();
if($operacion=='Registrar'){
  $impuesto->nid_impuesto($nid_impuesto);
  $impuesto->cdescripcion($cdescripcion);
  $impuesto->nporcentaje($nporcentaje);
  if(!$impuesto->Comprobar()){
    if($impuesto->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($impuesto->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($impuesto->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El impuesto ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?impuesto");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el impuesto.";
    header("Location: ../vistas/menu_principal.php?impuesto");
  }
}

if($operacion=='Modificar'){
  $impuesto->nid_impuesto($nid_impuesto);
  $impuesto->cdescripcion($cdescripcion);
  $impuesto->nporcentaje($nporcentaje);
  if($impuesto->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El impuesto ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?impuesto");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el impuesto.";
    header("Location: ../vistas/menu_principal.php?impuesto");
  }
}

if($operacion=='Desactivar'){
  $impuesto->nid_impuesto($nid_impuesto);
  $impuesto->cdescripcion($cdescripcion);
  $impuesto->nporcentaje($nporcentaje);
  if($impuesto->Consultar()){
    if($impuesto->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El impuesto ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?impuesto");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el impuesto.";
    header("Location: ../vistas/menu_principal.php?impuesto");
  }
}

if($operacion=='Activar'){
  $impuesto->nid_impuesto($nid_impuesto);
  $impuesto->cdescripcion($cdescripcion);
  $impuesto->nporcentaje($nporcentaje);
  if($impuesto->Consultar()){
    if($impuesto->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El impuesto ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?impuesto");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el impuesto.";
    header("Location: ../vistas/menu_principal.php?impuesto");
  }
}

if($operacion=='Consultar'){	
  $impuesto->nid_impuesto($nid_impuesto);
  $impuesto->cdescripcion($cdescripcion);
  $impuesto->nporcentaje($nporcentaje);
  if($impuesto->Consultar()){
    $_SESSION['datos']['nid_impuesto']=$impuesto->nid_impuesto();
    $_SESSION['datos']['cdescripcion']=$impuesto->cdescripcion();
    $_SESSION['datos']['nporcentaje']=$impuesto->nporcentaje();
    $_SESSION['datos']['estatus']=$impuesto->estatus_impuesto();
    header("Location: ../vistas/menu_principal.php?impuesto");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?impuesto");
  }
}		  
?>