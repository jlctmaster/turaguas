<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['crif_personaproveedor']))
$crif_persona=trim($_POST['crif_personaproveedor']);

if(isset($_POST['cnombreproveedor']))
$cnombre=trim($_POST['cnombreproveedor']);

if(isset($_POST['ctelefhabproveedor']))
$ctelefhab=trim($_POST['ctelefhabproveedor']);

if(isset($_POST['ctelefmovproveedor']))
$ctelefmov=trim($_POST['ctelefmovproveedor']);

if(isset($_POST['cemailproveedor']))
$cemail=trim($_POST['cemailproveedor']);

if(isset($_POST['nid_condicionpago']))
$nid_condicionpago=trim($_POST['nid_condicionpago']);

if(isset($_POST['nid_localidadproveedor']))
$nid_localidad=trim($_POST['nid_localidadproveedor']);

if(isset($_POST['cdireccionproveedor']))
$cdireccion=trim($_POST['cdireccionproveedor']);

include_once("../clases/class_proveedor.php");
$proveedor=new Proveedor();
if($operacion=='Registrar'){
  $proveedor->crif_personaproveedor($crif_persona);
  $proveedor->cnombreproveedor($cnombre);
  $proveedor->ctelefhabproveedor($ctelefhab);
  $proveedor->ctelefmovproveedor($ctelefmov);
  $proveedor->cemailproveedor($cemail);
  $proveedor->nid_condicionpago($nid_condicionpago);
  $proveedor->nid_localidadproveedor($nid_localidad);
  $proveedor->cdireccionproveedor($cdireccion);
     if(!$proveedor->Comprobar()){
      if($proveedor->Registrar($_SESSION['user_name'])){
        $confirmacion=1;
         if(isset($_POST['ctelefonodireccion']) && isset($_POST['csede_principaldireccion']) && isset($_POST['nid_localidaddireccion']) && isset($_POST['cdirecciondespaho'])){
          for($i=0;$i<count($_POST['ctelefonodireccion']);$i++){
            $proveedor->ctelefonodireccion($_POST['ctelefonodireccion'][$i]);
            $proveedor->csede_principaldireccion($_POST['csede_principaldireccion'][$i]);
            $proveedor->nid_localidaddireccion($_POST['nid_localidaddireccion'][$i]);
            $proveedor->cdirecciondespaho($_POST['cdirecciondespaho'][$i]);
            $proveedor->crif_personaproveedor($crif_persona);
            $proveedor->InsertarDirecciones($_SESSION['user_name']);
          }
        }
      }else
        $confirmacion=-1;
  }else{
    if($proveedor->dfecha_desactivacionproveedor()==null)
      $confirmacion=0;
    else{
    if($proveedor->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El proveedor ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?proveedor#proveedor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar al proveedor.";
    header("Location: ../vistas/menu_principal.php?proveedor#proveedor");
  }
}
if($operacion=='Modificar'){
  $proveedor->crif_personaproveedor($crif_persona);
  $proveedor->cnombreproveedor($cnombre);
  $proveedor->ctelefhabproveedor($ctelefhab);
  $proveedor->ctelefmovproveedor($ctelefmov);
  $proveedor->cemailproveedor($cemail);
  $proveedor->nid_condicionpago($nid_condicionpago);
  $proveedor->nid_localidadproveedor($nid_localidad);
  $proveedor->cdireccionproveedor($cdireccion);
    if($proveedor->Actualizar($_SESSION['user_name'])){
     $confirmacion=1;
     $proveedor->EliminarDirecciones();
     if(isset($_POST['ctelefonodireccion']) && isset($_POST['csede_principaldireccion']) && isset($_POST['nid_localidaddireccion']) && isset($_POST['cdirecciondespaho'])){
      for($i=0;$i<count($_POST['ctelefonodireccion']);$i++){
        $proveedor->ctelefonodireccion($_POST['ctelefonodireccion'][$i]);
        $proveedor->csede_principaldireccion($_POST['csede_principaldireccion'][$i]);
        $proveedor->nid_localidaddireccion($_POST['nid_localidaddireccion'][$i]);
        $proveedor->cdirecciondespaho($_POST['cdirecciondespaho'][$i]);
        $proveedor->crif_personaproveedor($crif_persona);
        $proveedor->InsertarDirecciones($_SESSION['user_name']);
      }
    }
  }else
     $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El proveedor ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?proveedor#proveedor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el proveedor.";
    header("Location: ../vistas/menu_principal.php?proveedor#proveedor");
  }
}

if($operacion=='Desactivar'){
  $proveedor->crif_personaproveedor($crif_persona);
  if($proveedor->Consultar()){
    if($proveedor->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El proveedor ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?proveedor#proveedor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el proveedor.";
    header("Location: ../vistas/menu_principal.php?proveedor#proveedor");
  }
}


if($operacion=='Activar'){
  $proveedor->crif_personaproveedor($crif_persona);
  if($proveedor->Consultar()){
    if($proveedor->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El proveedor ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?proveedor#proveedor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el proveedor.";
    header("Location: ../vistas/menu_principal.php?proveedor#proveedor");
  }
}

if($operacion=='Consultar'){ 
  $proveedor->crif_personaproveedor($crif_persona);
  if($proveedor->Consultar()){
    $_SESSION['datos']['crif_personaproveedor']=$proveedor->crif_personaproveedor();
    $_SESSION['datos']['cnombreproveedor']=$proveedor->cnombreproveedor();
    $_SESSION['datos']['ctelefhabproveedor']=$proveedor->ctelefhabproveedor();
    $_SESSION['datos']['ctelefmovproveedor']=$proveedor->ctelefmovproveedor();
    $_SESSION['datos']['cemailproveedor']=$proveedor->cemailproveedor();
    $_SESSION['datos']['nid_condicionpago']=$proveedor->nid_condicionpago();
    $_SESSION['datos']['nid_localidadproveedor']=$proveedor->nid_localidadproveedor();
    $_SESSION['datos']['cdireccionproveedor']=$proveedor->cdireccionproveedor();
    $_SESSION['datos']['estatusproveedor']=$proveedor->estatusproveedor();
    header("Location: ../vistas/menu_principal.php?proveedor#proveedor");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$crif_persona.")";
    header("Location: ../vistas/menu_principal.php?proveedor#proveedor");
  }
}
  
?>