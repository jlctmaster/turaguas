<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construnid_marca.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_marca']))
  $nid_marca=trim($_POST['nid_marca']);

if(isset($_POST['cdescripcion']))
  $cdescripcion=trim($_POST['cdescripcion']);

include_once("../clases/class_marca.php");
$marca=new Marca();
if($operacion=='Registrar'){
  $marca->nid_marca($nid_marca);
  $marca->cdescripcion($cdescripcion);
  if(!$marca->Comprobar()){
    if($marca->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($marca->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($marca->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La marca del artículo ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?marca");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la marca del artículo.";
    header("Location: ../vistas/menu_principal.php?marca");
  }
}

if($operacion=='Modificar'){
  $marca->nid_marca($nid_marca);
  $marca->cdescripcion($cdescripcion);
  if($marca->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La marca del artículo ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?marca");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la marca del artículo.";
    header("Location: ../vistas/menu_principal.php?marca");
  }
}

if($operacion=='Desactivar'){
  $marca->nid_marca($nid_marca);
  $marca->cdescripcion($cdescripcion);
  if($marca->Consultar()){
    if($marca->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La marca del artículo ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?marca");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la marca del artículo.";
    header("Location: ../vistas/menu_principal.php?marca");
  }
}

if($operacion=='Activar'){
  $marca->nid_marca($nid_marca);
  $marca->cdescripcion($cdescripcion);
  if($marca->Consultar()){
    if($marca->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La marca del artículo ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?marca");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la marca del artículo.";
    header("Location: ../vistas/menu_principal.php?marca");
  }
}

if($operacion=='Consultar'){	
  $marca->nid_marca($nid_marca);
  $marca->cdescripcion($cdescripcion);
  if($marca->Consultar()){
    $_SESSION['datos']['nid_marca']=$marca->nid_marca();
    $_SESSION['datos']['cdescripcion']=$marca->cdescripcion();
    $_SESSION['datos']['estatus']=$marca->estatus_marca();
    header("Location: ../vistas/menu_principal.php?marca");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?marca");
  }
}		  
?>