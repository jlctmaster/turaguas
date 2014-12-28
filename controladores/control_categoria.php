<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construnid_categoriaa.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_categoria']))
  $nid_categoria=trim($_POST['nid_categoria']);

if(isset($_POST['cdescripcionc']))
  $cdescripcionc=trim($_POST['cdescripcionc']);

include_once("../clases/class_categoria.php");
$categoria=new Categoria();
if($operacion=='Registrar'){
  $categoria->nid_categoria($nid_categoria);
  $categoria->cdescripcionc($cdescripcionc);
  if(!$categoria->Comprobar()){
    if($categoria->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($categoria->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($categoria->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La categoría ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?categoria#categoria");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la categoría.";
    header("Location: ../vistas/menu_principal.php?categoria#categoria");
  }
}

if($operacion=='Modificar'){
  $categoria->nid_categoria($nid_categoria);
  $categoria->cdescripcionc($cdescripcionc);
  if($categoria->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La categoría ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?categoria#categoria");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la categoría.";
    header("Location: ../vistas/menu_principal.php?categoria#categoria");
  }
}

if($operacion=='Desactivar'){
  $categoria->nid_categoria($nid_categoria);
  $categoria->cdescripcionc($cdescripcionc);
  if($categoria->Consultar()){
    if($categoria->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La categoría ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?categoria#categoria");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la categoría.";
    header("Location: ../vistas/menu_principal.php?categoria#categoria");
  }
}

if($operacion=='Activar'){
  $categoria->nid_categoria($nid_categoria);
  $categoria->cdescripcionc($cdescripcionc);
  if($categoria->Consultar()){
    if($categoria->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La categoría ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?categoria#categoria");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la categoría.";
    header("Location: ../vistas/menu_principal.php?categoria#categoria");
  }
}

if($operacion=='Consultar'){	
  $categoria->nid_categoria($nid_categoria);
  $categoria->cdescripcionc($cdescripcionc);
  if($categoria->Consultar()){
    $_SESSION['datos']['nid_categoria']=$categoria->nid_categoria();
    $_SESSION['datos']['cdescripcionc']=$categoria->cdescripcionc();
    $_SESSION['datos']['estatus_categoria']=$categoria->estatus_categoria();
    header("Location: ../vistas/menu_principal.php?categoria#categoria");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcionc.")";
    header("Location: ../vistas/menu_principal.php?categoria#categoria");
  }
}		  
?>