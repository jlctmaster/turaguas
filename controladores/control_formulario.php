<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construnid_formularioa.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_formulario']))
$nid_formulario=trim($_POST['nid_formulario']);

if(isset($_POST['cnombreformulario']))
$cnombreformulario=trim($_POST['cnombreformulario']);

if(isset($_POST['nid_modulo']))
$nid_modulo=trim($_POST['nid_modulo']);

if(isset($_POST['curl']))
$curl=trim($_POST['curl']);

if(isset($_POST['norden']))
$norden=trim($_POST['norden']);

include_once("../clases/class_formulario.php");
$formularios=new Formularios();
if($operacion=='Registrar'){
  $formularios->nid_formulario($nid_formulario);
  $formularios->cnombreformulario($cnombreformulario);
  $formularios->nid_modulo($nid_modulo);
  $formularios->curl($curl);
  $formularios->norden($norden);
  if(!$formularios->Comprobar()){
    if($formularios->Registrar($_SESSION['user_name']))
       $confirmacion=1;
    else
       $confirmacion=-1;
  }else{
    if($formularios->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
      if($formularios->Activar($_SESSION['user_name']))            
         $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El formulario ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?formulario#formulario");
   }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el formulario.";
    header("Location: ../vistas/menu_principal.php?formulario#formulario");
  }
}

if($operacion=='Modificar'){
  $formularios->nid_formulario($nid_formulario);
  $formularios->cnombreformulario($cnombreformulario);
  $formularios->nid_modulo($nid_modulo);
  $formularios->curl($curl);
  $formularios->norden($norden);
  if($formularios->Actualizar($_SESSION['user_name']))
   $confirmacion=1;
  else
   $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El formulario ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?formulario#formulario");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el formulario.";
    header("Location: ../vistas/menu_principal.php?formulario#formulario");
  }
}

if($operacion=='Desactivar'){
  $formularios->nid_formulario($nid_formulario);
  $formularios->cnombreformulario($cnombreformulario);
  if($formularios->Consultar()){
    if($formularios->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El formulario ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?formulario#formulario");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el formulario.";
    header("Location: ../vistas/menu_principal.php?formulario#formulario");
  }
}

if($operacion=='Activar'){
  $formularios->nid_formulario($nid_formulario);
  $formularios->cnombreformulario($cnombreformulario);
  if($formularios->Consultar()){
    if($formularios->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El formulario ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?formulario#formulario");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el formulario.";
    header("Location: ../vistas/menu_principal.php?formulario#formulario");
  }
}

if($operacion=='Consultar'){ 
  $formularios->nid_formulario($nid_formulario);
  $formularios->cnombreformulario($cnombreformulario);
  if($formularios->Consultar()){
    $_SESSION['datos']['nid_formulario']=$formularios->nid_formulario();
    $_SESSION['datos']['cnombreformulario']=$formularios->cnombreformulario();
    $_SESSION['datos']['nid_modulo']=$formularios->nid_modulo();
    $_SESSION['datos']['estatus_formularios']=$formularios->estatus_formularios();
    $_SESSION['datos']['curl']=$formularios->curl();
    $_SESSION['datos']['norden']=$formularios->norden();
    header("Location: ../vistas/menu_principal.php?formulario#formulario");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cnombreformulario.")";
    header("Location: ../vistas/menu_principal.php?formulario#formulario");
  }
}    
?>