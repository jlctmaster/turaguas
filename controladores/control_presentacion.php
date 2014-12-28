<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construnida.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_presentacion']))
  $nid_presentacion=trim($_POST['nid_presentacion']);

if(isset($_POST['cdescripcion']))
  $cdescripcion=trim($_POST['cdescripcion']);

if(isset($_POST['nunidades']))
  $nunidades=trim($_POST['nunidades']);

if(isset($_POST['ncapacidad']))
  $ncapacidad=trim($_POST['ncapacidad']);

if(isset($_POST['nid_unidadmedida']))
  $nid_unidadmedida=trim($_POST['nid_unidadmedida']);

include_once("../clases/class_presentacion.php");
$presentacion=new Presentacion();
if($operacion=='Registrar'){
  $presentacion->nid_presentacion($nid_presentacion);
  $presentacion->cdescripcion($cdescripcion);
  $presentacion->nunidades($nunidades);
  $presentacion->ncapacidad($ncapacidad);
  $presentacion->nid_unidadmedida($nid_unidadmedida);
  if(!$presentacion->Comprobar()){
    if($presentacion->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($presentacion->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($presentacion->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La presentación ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?presentacion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la presentación.";
    header("Location: ../vistas/menu_principal.php?presentacion");
  }
}

if($operacion=='Modificar'){
  $presentacion->nid_presentacion($nid_presentacion);
  $presentacion->cdescripcion($cdescripcion);
  $presentacion->nunidades($nunidades);
  $presentacion->ncapacidad($ncapacidad);
  $presentacion->nid_unidadmedida($nid_unidadmedida);
  if($presentacion->Actualizar($_SESSION['user_name']))
  {
    $confirmacion=1;
  }else{
    $confirmacion=-1;
  }if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La presentación ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?presentacion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la presentación.";
    header("Location: ../vistas/menu_principal.php?presentacion");
  }
}

if($operacion=='Desactivar'){
  $presentacion->nid_presentacion($nid_presentacion);
  $presentacion->cdescripcion($cdescripcion);
  $presentacion->nunidades($nunidades);
  $presentacion->ncapacidad($ncapacidad);
  $presentacion->nid_unidadmedida($nid_unidadmedida);
  if($presentacion->Consultar()){
    if($presentacion->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La presentación ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?presentacion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la presentación.";
    header("Location: ../vistas/menu_principal.php?presentacion");
  }
}

if($operacion=='Activar'){
  $presentacion->nid_presentacion($nid_presentacion);
  $presentacion->cdescripcion($cdescripcion);
  $presentacion->nunidades($nunidades);
  $presentacion->ncapacidad($ncapacidad);
  $presentacion->nid_unidadmedida($nid_unidadmedida);
  if($presentacion->Consultar()){
    if($presentacion->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La presentación ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?presentacion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la presentación.";
    header("Location: ../vistas/menu_principal.php?presentacion");
  }
}

if($operacion=='Consultar'){	
  $presentacion->nid_presentacion($nid_presentacion);
  $presentacion->cdescripcion($cdescripcion);
  $presentacion->nunidades($nunidades);
  $presentacion->ncapacidad($ncapacidad);
  $presentacion->nid_unidadmedida($nid_unidadmedida);
  if($presentacion->Consultar()){
    $_SESSION['datos']['nid_presentacion']=$presentacion->nid_presentacion();
    $_SESSION['datos']['cdescripcion']=$presentacion->cdescripcion();
    $_SESSION['datos']['nunidades']=$presentacion->nunidades();
    $_SESSION['datos']['ncapacidad']=$presentacion->ncapacidad();
    $_SESSION['datos']['nid_unidadmedida']=$presentacion->nid_unidadmedida();
    $_SESSION['datos']['estatus']=$presentacion->estatus_presentacion();
    header("Location: ../vistas/menu_principal.php?presentacion");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?presentacion");
  }
}		  
?>