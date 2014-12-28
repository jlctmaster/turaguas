<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_direcciondespacho']))
$nid_direcciondespacho=trim($_POST['nid_direcciondespacho']);

if(isset($_POST['crif_personacliente']))
$crif_persona=trim($_POST['crif_personacliente']);

if(isset($_POST['cdireccion']))
$cdireccion=trim($_POST['cdireccion']);

if(isset($_POST['ctelefonodireccion']))
$ctelefono=trim($_POST['ctelefonodireccion']);

if(isset($_POST['csede_principaldireccion']))
$csede_principal=trim($_POST['csede_principaldireccion']);

if(isset($_POST['nid_localidaddireccion']))
$nid_localidad=trim($_POST['nid_localidaddireccion']);


include_once("../clases/class_direccioncliente.php");
$direccion=new DireccionCliente();
if($operacion=='Registrar'){
  $direccion->nid_direcciondespacho($nid_direcciondespacho);
  $direccion->crif_personacliente($crif_persona);
  $direccion->cdireccion($cdireccion);
  $direccion->ctelefonodireccion($ctelefono);
  $direccion->csede_principaldireccion($csede_principal);
  $direccion->nid_localidaddireccion($nid_localidad);
  if(!$direccion->Comprobar()){
    if($direccion->Registrar($_SESSION['user_name']))
       $confirmacion=1;
    else
       $confirmacion=-1;
  }else{
    if($direccion->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
      if($direccion->Activar($_SESSION['user_name']))            
         $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La dirección del cliente ha sido registrada con exito!";
    header("Location: ../vistas/menu_principal.php?cliente#direccion");
   }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la dirección del cliente.";
    header("Location: ../vistas/menu_principal.php?cliente#direccion");
  }
}

if($operacion=='Modificar'){
  $direccion->nid_direcciondespacho($nid_direcciondespacho);
  $direccion->crif_personacliente($crif_persona);
  $direccion->cdireccion($cdireccion);
  $direccion->ctelefonodireccion($ctelefono);
  $direccion->csede_principaldireccion($csede_principal);
  $direccion->nid_localidaddireccion($nid_localidad);
    if($direccion->Actualizar($_SESSION['user_name']))
     $confirmacion=1;
    else
     $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La dirección del cliente ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?cliente#direccion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la dirección del cliente.";
    header("Location: ../vistas/menu_principal.php?cliente#direccion");
  }
}

if($operacion=='Desactivar'){
  $direccion->cdireccion($cdireccion);
  $direccion->nid_direcciondespacho($nid_direcciondespacho);
  if($direccion->Consultar()){
    if($direccion->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La dirección del cliente ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?cliente#direccion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la dirección del cliente.";
    header("Location: ../vistas/menu_principal.php?cliente#direccion");
  }
}


if($operacion=='Activar'){
  $direccion->cdireccion($cdireccion);
  $direccion->nid_direcciondespacho($nid_direcciondespacho);
  if($direccion->Consultar()){
    if($direccion->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La dirección del cliente ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?cliente#direccion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la dirección del del cliente.";
    header("Location: ../vistas/menu_principal.php?cliente#direccion");
  }
}

if($operacion=='Consultar'){ 
  $direccion->cdireccion($cdireccion);
  if($direccion->Consultar()){
    $_SESSION['datos']['nid_direcciondespacho']=$direccion->nid_direcciondespacho();
    $_SESSION['datos']['crif_personacliente']=$direccion->crif_personacliente();
    $_SESSION['datos']['cdireccion']=$direccion->cdireccion();
    $_SESSION['datos']['ctelefonodireccion']=$direccion->ctelefonodireccion();
    $_SESSION['datos']['csede_principaldireccion']=$direccion->csede_principaldireccion();
    $_SESSION['datos']['nid_localidaddireccion']=$direccion->nid_localidaddireccion();
    $_SESSION['datos']['estatusdireccion']=$direccion->estatusdireccion();
    $_SESSION['datos']['cnombrecliente']=$direccion->cnombre_personacliente();
    header("Location: ../vistas/menu_principal.php?cliente#direccion");
  }else{
    $_SESSION['datos']['mensaje']=utf8_encode("No se encontró algún resultado con el filtro de búsqueda(".$cdireccion.")");
    header("Location: ../vistas/menu_principal.php?cliente#direccion");
  }
}
  
?>