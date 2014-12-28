<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_modulo']))
$nid_modulo=trim($_POST['nid_modulo']);

if(isset($_POST['cnombremodulo']))
$cnombremodulo=trim($_POST['cnombremodulo']);

if(isset($_POST['cicono']))
$cicono=trim($_POST['cicono']);

if(isset($_POST['norden']))
$norden=trim($_POST['norden']);

include_once("../clases/class_modulo.php");
$modulo=new Modulo();
if($operacion=='Registrar'){
  $modulo->nid_modulo($nid_modulo);
  $modulo->cnombremodulo($cnombremodulo);
  $modulo->cicono($cicono);
  $modulo->norden($norden);
  if(!$modulo->Comprobar()){
    if($modulo->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($modulo->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
      if($modulo->Activar($_SESSION['user_name']))            
        $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El módulo ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?modulo");
  }else {
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el módulo.";
    header("Location: ../vistas/menu_principal.php?modulo");
  }
}


if($operacion=='Modificar'){
  $modulo->nid_modulo($nid_modulo);
  $modulo->cnombremodulo($cnombremodulo);
  $modulo->cicono($cicono);
  $modulo->norden($norden);
  if($modulo->Actualizar($_SESSION['user_name']))
   $confirmacion=1;
  else
   $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El módulo ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?modulo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el módulo.";
    header("Location: ../vistas/menu_principal.php?modulo");
  }
}

if($operacion=='Desactivar'){
  $modulo->nid_modulo($nid_modulo);
  $modulo->cnombremodulo($cnombremodulo);
  if($modulo->Consultar()){
    if($modulo->Desactivar($_SESSION['user_name']))
     $confirmacion=1;
    else
     $confirmacion=-1;
  }else{
     $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El módulo ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?modulo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el módulo.";
    header("Location: ../vistas/menu_principal.php?modulo");
  }
}


if($operacion=='Activar'){
  $modulo->nid_modulo($nid_modulo);
  $modulo->cnombremodulo($cnombremodulo);
  if($modulo->Consultar()){
    if($modulo->Activar($_SESSION['user_name']))
     $confirmacion=1;
    else
     $confirmacion=-1;
  }else{
     $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El módulo ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?modulo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el módulo.";
    header("Location: ../vistas/menu_principal.php?modulo");
  }
}

if($operacion=='Consultar'){  
  $modulo->nid_modulo($nid_modulo);
  $modulo->cnombremodulo($cnombremodulo);
  $modulo->cicono($cicono);
  if($modulo->Consultar()){
    $_SESSION['datos']['nid_modulo']=$modulo->nid_modulo();
    $_SESSION['datos']['cnombremodulo']=$modulo->cnombremodulo();
    $_SESSION['datos']['cicono']=$modulo->cicono();
    $_SESSION['datos']['norden']=$modulo->norden();
    $_SESSION['datos']['estatus']=$modulo->estatus_modulo();
    header("Location: ../vistas/menu_principal.php?modulo");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cnombremodulo.")";
    header("Location: ../vistas/menu_principal.php?modulo");
  }                              
}     
?>