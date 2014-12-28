<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_categoria_sub']))
  $nid_categoria_sub=trim($_POST['nid_categoria_sub']);

if(isset($_POST['cdescripcions']))
  $cdescripcions=trim($_POST['cdescripcions']);

if(isset($_POST['nid_categoria_padre']))
$nid_categoria_padre=trim($_POST['nid_categoria_padre']);

include_once("../clases/class_subcategoria.php");
$subcategoria=new Subcategoria();
if($operacion=='Registrar'){
  $subcategoria->nid_categoria_sub($nid_categoria_sub);
  $subcategoria->cdescripcions($cdescripcions);
  $subcategoria->nid_categoria_padre($nid_categoria_padre);
  if(!$subcategoria->Comprobar()){
    if($subcategoria->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($subcategoria->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($subcategoria->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La sub - categoría ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?categoria#subcategoria");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la sub - categoría.";
    header("Location: ../vistas/menu_principal.php?categoria#subcategoria");
  }
}

if($operacion=='Modificar'){
  $subcategoria->nid_categoria_sub($nid_categoria_sub);
  $subcategoria->cdescripcions($cdescripcions);
  $subcategoria->nid_categoria_padre($nid_categoria_padre);
  if($subcategoria->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La sub - categoría ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?categoria#subcategoria");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la sub - categoría.";
    header("Location: ../vistas/menu_principal.php?categoria#subcategoria");
  }
}

if($operacion=='Desactivar'){
  $subcategoria->nid_categoria_sub($nid_categoria_sub);
  $subcategoria->cdescripcions($cdescripcions);
  $subcategoria->nid_categoria_padre($nid_categoria_padre);
  if($subcategoria->Consultar()){
    if($subcategoria->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La sub - categoría ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?categoria#subcategoria");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la sub - categoría.";
    header("Location: ../vistas/menu_principal.php?categoria#subcategoria");
  }
}

if($operacion=='Activar'){
  $subcategoria->nid_categoria_sub($nid_categoria_sub);
  $subcategoria->cdescripcions($cdescripcions);
  $subcategoria->nid_categoria_padre($nid_categoria_padre);
  if($subcategoria->Consultar()){
    if($subcategoria->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La sub - categoría ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?categoria#subcategoria");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la sub - categoría.";
    header("Location: ../vistas/menu_principal.php?categoria#subcategoria");
  }
}

if($operacion=='Consultar'){	
  $subcategoria->nid_categoria_sub($nid_categoria_sub);
  $subcategoria->cdescripcions($cdescripcions);
  $subcategoria->nid_categoria_padre($nid_categoria_padre);
  if($subcategoria->Consultar()){
    $_SESSION['datos']['nid_categoria_sub']=$subcategoria->nid_categoria_sub();
    $_SESSION['datos']['cdescripcions']=$subcategoria->cdescripcions();
    $_SESSION['datos']['nid_categoria_padre']=$subcategoria->nid_categoria_padre();
    $_SESSION['datos']['cdescripcionc']=$subcategoria->cdescripcionc();
    $_SESSION['datos']['estatus_subcategoria']=$subcategoria->estatus_subcategoria();
    header("Location: ../vistas/menu_principal.php?categoria#subcategoria");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcions.")";
    header("Location: ../vistas/menu_principal.php?categoria#subcategoria");
  }
}		  
?>