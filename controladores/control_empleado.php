<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_rol']))
$nid_rol=trim($_POST['nid_rol']);

if(isset($_POST['crif_persona']))
$crif_persona=trim($_POST['crif_persona']);

if(isset($_POST['cnombre']))
$cnombre=trim($_POST['cnombre']);

if(isset($_POST['ctelefhab']))
$ctelefhab=trim($_POST['ctelefhab']);

if(isset($_POST['ctelefmov']))
$ctelefmov=trim($_POST['ctelefmov']);

if(isset($_POST['cemail']))
$cemail=trim($_POST['cemail']);

if(isset($_POST['nid_localidad']))
$nid_localidad=trim($_POST['nid_localidad']);

if(isset($_POST['cdireccion']))
$cdireccion=trim($_POST['cdireccion']);

include_once("../clases/class_empleado.php");
$persona=new Empleado();
if($operacion=='Registrar'){
  $persona->nid_rol($nid_rol);
  $persona->crif_persona($crif_persona);
  $persona->cnombre($cnombre);
  $persona->ctelefhab($ctelefhab);
  $persona->ctelefmov($ctelefmov);
  $persona->cemail($cemail);
  $persona->nid_localidad($nid_localidad);
  $persona->cdireccion($cdireccion);
  if(!$persona->Comprobar()){
    if($persona->Registrar($_SESSION['user_name']))
       $confirmacion=1;
    else
       $confirmacion=-1;
  }else{
    if($persona->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
      if($persona->Activar($_SESSION['user_name']))            
         $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El empleado ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?empleado");
   }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el empleado.";
    header("Location: ../vistas/menu_principal.php?empleado");
  }
}

if($operacion=='Modificar'){
  $persona->nid_rol($nid_rol);
  $persona->crif_persona($crif_persona);
  $persona->cnombre($cnombre);
  $persona->ctelefhab($ctelefhab);
  $persona->ctelefmov($ctelefmov);
  $persona->cemail($cemail);
  $persona->nid_localidad($nid_localidad);
  $persona->cdireccion($cdireccion);
    if($persona->Actualizar($_SESSION['user_name']))
     $confirmacion=1;
    else
     $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El empleado ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?empleado");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el empleado.";
    header("Location: ../vistas/menu_principal.php?empleado");
  }
}

if($operacion=='Desactivar'){
  $persona->crif_persona($crif_persona);
  $persona->cnombre($cnombre);
  if($persona->Consultar()){
    if($persona->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El empleado ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?empleado");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el empleado.";
    header("Location: ../vistas/menu_principal.php?empleado");
  }
}


if($operacion=='Activar'){
  $persona->crif_persona($crif_persona);
  $persona->cnombre($cnombre);
  if($persona->Consultar()){
    if($persona->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El empleado ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?empleado");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el empleado.";
    header("Location: ../vistas/menu_principal.php?empleado");
  }
}

if($operacion=='Consultar'){ 
  $persona->crif_persona($crif_persona);
  $persona->cnombre($cnombre);
  if($persona->Consultar()){
    $_SESSION['datos']['nid_rol']=$persona->nid_rol();
    $_SESSION['datos']['crif_persona']=$persona->crif_persona();
    $_SESSION['datos']['cnombre']=$persona->cnombre();
    $_SESSION['datos']['ctelefhab']=$persona->ctelefhab();
    $_SESSION['datos']['ctelefmov']=$persona->ctelefmov();
    $_SESSION['datos']['cemail']=$persona->cemail();
    $_SESSION['datos']['nid_localidad']=$persona->nid_localidad();
    $_SESSION['datos']['cdireccion']=$persona->cdireccion();
    $_SESSION['datos']['estatus']=$persona->estatus_persona();
    header("Location: ../vistas/menu_principal.php?empleado");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$crif_persona.")";
    header("Location: ../vistas/menu_principal.php?empleado");
  }
}
  
?>