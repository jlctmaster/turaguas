<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_ciudad']))
$nid_localidad=trim($_POST['nid_ciudad']);

if(isset($_POST['ctabla_ciudad']))
$ctabla=trim($_POST['ctabla_ciudad']);

if(isset($_POST['cnombreciudad']))
$cdescripcion=trim($_POST['cnombreciudad']);

if(isset($_POST['nid_estado']))
$nid_localidad_padre=trim($_POST['nid_estado']);


include_once("../clases/class_ciudad.php");
$ciudad=new ciudad();
if($operacion=='Registrar'){
  $ciudad->nid_localidad($nid_localidad);
  $ciudad->ctabla($ctabla);
  $ciudad->cdescripcion($cdescripcion);
  $ciudad->nid_localidad_padre($nid_localidad_padre);
  if(!$ciudad->Comprobar()){
    if($ciudad->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($ciudad->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
      if($ciudad->Activar($_SESSION['user_name']))            
        $confirmacion=1;
    }
  }

  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La ciudad ha sido registrada con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#ciudad");
   }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la ciudad.";
    header("Location: ../vistas/menu_principal.php?localidad#ciudad");
  }
}

if($operacion=='Modificar'){
  $ciudad->nid_localidad($nid_localidad);
  $ciudad->ctabla($ctabla);
  $ciudad->cdescripcion($cdescripcion);
  $ciudad->nid_localidad_padre($nid_localidad_padre);
    if($ciudad->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La ciudad ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#ciudad");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la ciudad.";
    header("Location: ../vistas/menu_principal.php?localidad#ciudad");
  }
}

if($operacion=='Desactivar'){
  $ciudad->nid_localidad($nid_localidad);
  $ciudad->ctabla($ctabla);
  $ciudad->cdescripcion($cdescripcion);
  $ciudad->nid_localidad_padre($nid_localidad_padre);
  if($ciudad->Consultar()){
    if($ciudad->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La ciudad ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#ciudad");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la ciudad.";
    header("Location: ../vistas/menu_principal.php?localidad#ciudad");
  }
}


if($operacion=='Activar'){
  $ciudad->nid_localidad($id);
  $ciudad->ctabla($ctabla);
  $ciudad->cdescripcion($cdescripcion);
  $ciudad->nid_localidad_padre($nid_localidad_padre);
  if($ciudad->Consultar()){
    if($ciudad->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La ciudad ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#ciudad");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la ciudad.";
    header("Location: ../vistas/menu_principal.php?localidad#ciudad");
  }
}

if($operacion=='Consultar'){ 
  $ciudad->nid_localidad($nid_localidad);
  $ciudad->ctabla($ctabla);
  $ciudad->cdescripcion($cdescripcion);
  if($ciudad->Consultar()){
    $_SESSION['datos']['nid_ciudad']=$ciudad->nid_localidad();
    $_SESSION['datos']['cnombreestado']=$ciudad->cnombreestado();
    $_SESSION['datos']['cnombreciudad']=$ciudad->cdescripcion();
    $_SESSION['datos']['nid_estado']=$ciudad->nid_localidad_padre();
    $_SESSION['datos']['estatus_ciudad']=$ciudad->estatus_ciudad();
    header("Location: ../vistas/menu_principal.php?localidad#ciudad");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?localidad#ciudad");
  }
}    
?>