<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['crif_personacontacto']))
$crif_personacontacto=trim($_POST['crif_personacontacto']);

if(isset($_POST['cnombrecontacto']))
$cnombrecontacto=trim($_POST['cnombrecontacto']);

if(isset($_POST['ccargo']))
$ccargo=trim($_POST['ccargo']);

if(isset($_POST['ctelefono']))
$ctelefono=trim($_POST['ctelefono']);

if(isset($_POST['nid_direcciondespacho']))
$nid_direcciondespacho=trim($_POST['nid_direcciondespacho']);

include_once("../clases/class_contactoproveedor.php");
$contacto=new ContactoProveedor();
if($operacion=='Registrar'){
    $contacto->crif_personacontacto($crif_personacontacto);
    $contacto->cnombrecontacto($cnombrecontacto);
    $contacto->ccargo($ccargo);
    $contacto->ctelefono($ctelefono);
    $contacto->nid_direcciondespacho($nid_direcciondespacho);
     if(!$contacto->Comprobar()){
    if($contacto->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($contacto->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($contacto->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El contacto ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?proveedor#contacto");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar al contacto.";
    header("Location: ../vistas/menu_principal.php?proveedor#contacto");
  }
}

if($operacion=='Modificar'){
    $contacto->crif_personacontacto($crif_personacontacto);
    $contacto->cnombrecontacto($cnombrecontacto);
    $contacto->ccargo($ccargo);
    $contacto->ctelefono($ctelefono);
    $contacto->nid_direcciondespacho($nid_direcciondespacho);
    if($contacto->Actualizar($_SESSION['user_name']))
     $confirmacion=1;
    else
     $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El contacto ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?proveedor#contacto");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el contacto.";
    header("Location: ../vistas/menu_principal.php?proveedor#contacto");
  }
}

if($operacion=='Desactivar'){
  $contacto->crif_personacontacto($crif_personacontacto);
  if($contacto->Consultar()){
    if($contacto->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El contacto ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?proveedor#contacto");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el contacto.";
   header("Location: ../vistas/menu_principal.php?proveedor#contacto");
  }
}


if($operacion=='Activar'){
  $contacto->crif_personacontacto($crif_personacontacto);
  if($contacto->Consultar()){
    if($contacto->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El contacto ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?proveedor#contacto");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el contacto.";
    header("Location: ../vistas/menu_principal.php?proveedor#contacto");
  }
}

if($operacion=='Consultar'){ 
  $contacto->crif_personacontacto($crif_personacontacto);
  if($contacto->Consultar()){
  $_SESSION['datos']['crif_personaproveedor']=$contacto->crif_personaproveedor();
    $_SESSION['datos']['cnombreproveedor']=$contacto->cnombreproveedor();
    $_SESSION['datos']['nid_direcciondespacho']=$contacto->nid_direcciondespacho();
    $_SESSION['datos']['cdireccion']=$contacto->cdireccion();
    $_SESSION['datos']['nid_personacontacto']=$contacto->nid_personacontacto();
    $_SESSION['datos']['crif_personacontacto']=$contacto->crif_personacontacto();
    $_SESSION['datos']['cnombrecontacto']=$contacto->cnombrecontacto();
    $_SESSION['datos']['ccargo']=$contacto->ccargo();
    $_SESSION['datos']['ctelefono']=$contacto->ctelefono();
    $_SESSION['datos']['estatuscontacto']=$contacto->estatuscontacto();
    header("Location: ../vistas/menu_principal.php?proveedor#contacto");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$crif_personaproveedor.")";
    header("Location: ../vistas/menu_principal.php?proveedor#contacto");
  }
}
  
?>