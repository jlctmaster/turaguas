<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['crif_personacliente']))
$crif_persona=trim($_POST['crif_personacliente']);

if(isset($_POST['cnombrecliente']))
$cnombre=trim($_POST['cnombrecliente']);

if(isset($_POST['ctelefhabcliente']))
$ctelefhab=trim($_POST['ctelefhabcliente']);

if(isset($_POST['ctelefmovcliente']))
$ctelefmov=trim($_POST['ctelefmovcliente']);

if(isset($_POST['cemailcliente']))
$cemail=trim($_POST['cemailcliente']);

if(isset($_POST['nid_condicionpago']))
$nid_condicionpago=trim($_POST['nid_condicionpago']);

if(isset($_POST['nid_localidadcliente']))
$nid_localidad=trim($_POST['nid_localidadcliente']);

if(isset($_POST['cdireccioncliente']))
$cdireccion=trim($_POST['cdireccioncliente']);

include_once("../clases/class_cliente.php");
$cliente=new Cliente();
if($operacion=='Registrar'){
  $cliente->crif_personacliente($crif_persona);
  $cliente->cnombrecliente($cnombre);
  $cliente->ctelefhabcliente($ctelefhab);
  $cliente->ctelefmovcliente($ctelefmov);
  $cliente->cemailcliente($cemail);
  $cliente->nid_condicionpago($nid_condicionpago);
  $cliente->nid_localidadcliente($nid_localidad);
  $cliente->cdireccioncliente($cdireccion);
     if(!$cliente->Comprobar()){
      if($cliente->Registrar($_SESSION['user_name'])){
        $confirmacion=1;
         if(isset($_POST['ctelefonodireccion']) && isset($_POST['csede_principaldireccion']) && isset($_POST['nid_localidaddireccion']) && isset($_POST['cdirecciondespaho'])){
          for($i=0;$i<count($_POST['ctelefonodireccion']);$i++){
            $cliente->ctelefonodireccion($_POST['ctelefonodireccion'][$i]);
            $cliente->csede_principaldireccion($_POST['csede_principaldireccion'][$i]);
            $cliente->nid_localidaddireccion($_POST['nid_localidaddireccion'][$i]);
            $cliente->cdirecciondespaho($_POST['cdirecciondespaho'][$i]);
            $cliente->crif_personacliente($crif_persona);
            $cliente->InsertarDirecciones($_SESSION['user_name']);
          }
        }
      }else
        $confirmacion=-1;
  }else{
    if($cliente->dfecha_desactivacioncliente()==null)
      $confirmacion=0;
    else{
    if($cliente->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El Cliente ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?cliente#cliente");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar al Cliente.";
    header("Location: ../vistas/menu_principal.php?cliente#cliente");
  }
}
if($operacion=='Modificar'){
  $cliente->crif_personacliente($crif_persona);
  $cliente->cnombrecliente($cnombre);
  $cliente->ctelefhabcliente($ctelefhab);
  $cliente->ctelefmovcliente($ctelefmov);
  $cliente->cemailcliente($cemail);
  $cliente->nid_condicionpago($nid_condicionpago);
  $cliente->nid_localidadcliente($nid_localidad);
  $cliente->cdireccioncliente($cdireccion);
    if($cliente->Actualizar($_SESSION['user_name'])){
     $confirmacion=1;
     $cliente->EliminarDirecciones();
     if(isset($_POST['ctelefonodireccion']) && isset($_POST['csede_principaldireccion']) && isset($_POST['nid_localidaddireccion']) && isset($_POST['cdirecciondespaho'])){
      for($i=0;$i<count($_POST['ctelefonodireccion']);$i++){
        $cliente->ctelefonodireccion($_POST['ctelefonodireccion'][$i]);
        $cliente->csede_principaldireccion($_POST['csede_principaldireccion'][$i]);
        $cliente->nid_localidaddireccion($_POST['nid_localidaddireccion'][$i]);
        $cliente->cdirecciondespaho($_POST['cdirecciondespaho'][$i]);
        $cliente->crif_personacliente($crif_persona);
        $cliente->InsertarDirecciones($_SESSION['user_name']);
      }
    }
  }else
     $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El cliente ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?cliente#cliente");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el cliente.";
    header("Location: ../vistas/menu_principal.php?cliente#cliente");
  }
}

if($operacion=='Desactivar'){
  $cliente->crif_personacliente($crif_persona);
  if($cliente->Consultar()){
    if($cliente->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El cliente ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?cliente#cliente");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el cliente.";
    header("Location: ../vistas/menu_principal.php?cliente#cliente");
  }
}


if($operacion=='Activar'){
  $cliente->crif_personacliente($crif_persona);
  if($cliente->Consultar()){
    if($cliente->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El cliente ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?cliente#cliente");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el cliente.";
    header("Location: ../vistas/menu_principal.php?cliente#cliente");
  }
}

if($operacion=='Consultar'){ 
  $cliente->crif_personacliente($crif_persona);
  if($cliente->Consultar()){
    $_SESSION['datos']['crif_personacliente']=$cliente->crif_personacliente();
    $_SESSION['datos']['cnombrecliente']=$cliente->cnombrecliente();
    $_SESSION['datos']['ctelefhabcliente']=$cliente->ctelefhabcliente();
    $_SESSION['datos']['ctelefmovcliente']=$cliente->ctelefmovcliente();
    $_SESSION['datos']['cemailcliente']=$cliente->cemailcliente();
    $_SESSION['datos']['nid_condicionpago']=$cliente->nid_condicionpago();
    $_SESSION['datos']['nid_localidadcliente']=$cliente->nid_localidadcliente();
    $_SESSION['datos']['cdireccioncliente']=$cliente->cdireccioncliente();
    $_SESSION['datos']['estatuscliente']=$cliente->estatuscliente();
    header("Location: ../vistas/menu_principal.php?cliente#cliente");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$crif_persona.")";
    header("Location: ../vistas/menu_principal.php?cliente#cliente");
  }
}
  
?>