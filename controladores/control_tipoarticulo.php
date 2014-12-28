<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construnid_tipoarticulo.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_tipoarticulo']))
  $nid_tipoarticulo=trim($_POST['nid_tipoarticulo']);

if(isset($_POST['cdescripcion']))
  $cdescripcion=trim($_POST['cdescripcion']);

include_once("../clases/class_tipoarticulo.php");
$tipoarticulo=new Tipoarticulo();
if($operacion=='Registrar'){
  $tipoarticulo->nid_tipoarticulo($nid_tipoarticulo);
  $tipoarticulo->cdescripcion($cdescripcion);
  if(!$tipoarticulo->Comprobar()){
    if($tipoarticulo->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($tipoarticulo->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($tipoarticulo->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El tipo de artículo ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?tipoarticulo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el tipo de artículo.";
    header("Location: ../vistas/menu_principal.php?tipoarticulo");
  }
}

if($operacion=='Modificar'){
  $tipoarticulo->nid_tipoarticulo($nid_tipoarticulo);
  $tipoarticulo->cdescripcion($cdescripcion);
  if($tipoarticulo->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El tipo de artículo ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?tipoarticulo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el tipo de artículo.";
    header("Location: ../vistas/menu_principal.php?tipoarticulo");
  }
}

if($operacion=='Desactivar'){
  $tipoarticulo->nid_tipoarticulo($nid_tipoarticulo);
  $tipoarticulo->cdescripcion($cdescripcion);
  if($tipoarticulo->Consultar()){
    if($tipoarticulo->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El tipo de artículo ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?tipoarticulo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el tipo de artículo.";
    header("Location: ../vistas/menu_principal.php?tipoarticulo");
  }
}

if($operacion=='Activar'){
  $tipoarticulo->nid_tipoarticulo($nid_tipoarticulo);
  $tipoarticulo->cdescripcion($cdescripcion);
  if($tipoarticulo->Consultar()){
    if($tipoarticulo->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El tipo de artículo ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?tipoarticulo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el tipo de artículo.";
    header("Location: ../vistas/menu_principal.php?tipoarticulo");
  }
}

if($operacion=='Consultar'){	
  $tipoarticulo->nid_tipoarticulo($nid_tipoarticulo);
  $tipoarticulo->cdescripcion($cdescripcion);
  if($tipoarticulo->Consultar()){
    $_SESSION['datos']['nid_tipoarticulo']=$tipoarticulo->nid_tipoarticulo();
    $_SESSION['datos']['cdescripcion']=$tipoarticulo->cdescripcion();
    $_SESSION['datos']['estatus']=$tipoarticulo->estatus_tipoarticulo();
    header("Location: ../vistas/menu_principal.php?tipoarticulo");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?tipoarticulo");
  }
}		  
?>