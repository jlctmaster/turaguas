<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_estado']))
$nid_localidad=trim($_POST['nid_estado']);

if(isset($_POST['ctabla_estado']))
$ctabla=trim($_POST['ctabla_estado']);

if(isset($_POST['cnombreestado']))
$cdescripcion=trim($_POST['cnombreestado']);

if(isset($_POST['nid_pais']))
$nid_localidad_padre=trim($_POST['nid_pais']);


include_once("../clases/class_estado.php");
$estado=new Estado();
if($operacion=='Registrar'){
  $estado->nid_localidad($nid_localidad);
  $estado->ctabla($ctabla);
  $estado->cdescripcion($cdescripcion);
  $estado->nid_localidad_padre($nid_localidad_padre);
  if(!$estado->Comprobar()){
    if($estado->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($estado->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
      if($estado->Activar($_SESSION['user_name']))            
        $confirmacion=1;
    }
  }

  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El estado ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#estado");
   }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar estado.";
    header("Location: ../vistas/menu_principal.php?localidad#estado");
  }
}

if($operacion=='Modificar'){
  $estado->nid_localidad($nid_localidad);
  $estado->ctabla($ctabla);
  $estado->cdescripcion($cdescripcion);
  $estado->nid_localidad_padre($nid_localidad_padre);
    if($estado->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El estado ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#estado");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el estado.";
    header("Location: ../vistas/menu_principal.php?localidad#estado");
  }
}

if($operacion=='Desactivar'){
  $estado->nid_localidad($nid_localidad);
  $estado->ctabla($ctabla);
  $estado->cdescripcion($cdescripcion);
  $estado->nid_localidad_padre($nid_localidad_padre);
  if($estado->Consultar()){
    if($estado->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El estado ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#estado");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el estado.";
    header("Location: ../vistas/menu_principal.php?localidad#estado");
  }
}


if($operacion=='Activar'){
  $estado->nid_localidad($id);
  $estado->ctabla($ctabla);
  $estado->cdescripcion($cdescripcion);
  $estado->nid_localidad_padre($nid_localidad_padre);
  if($estado->Consultar()){
    if($estado->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El estado ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#estado");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el estado.";
    header("Location: ../vistas/menu_principal.php?localidad#estado");
  }
}

if($operacion=='Consultar'){ 
  $estado->nid_localidad($nid_localidad);
  $estado->ctabla($ctabla);
  $estado->cdescripcion($cdescripcion);
  if($estado->Consultar()){
    $_SESSION['datos']['nid_estado']=$estado->nid_localidad();
    $_SESSION['datos']['cnombreestado']=$estado->cdescripcion();
    $_SESSION['datos']['cnombrepais']=$estado->cnombrepais();
    $_SESSION['datos']['nid_pais']=$estado->nid_localidad_padre();
    $_SESSION['datos']['estatus_estado']=$estado->estatus_estado();
    header("Location: ../vistas/menu_principal.php?localidad#estado");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?localidad#estado");
  }
}    
?>