<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construnid_categoriaa.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_um_conversion']))
  $nid_um_conversion=trim($_POST['nid_um_conversion']);

if(isset($_POST['cid_articulo']))
  $cid_articulo=trim($_POST['cid_articulo']);

if(isset($_POST['nid_unidadmedida']))
$nid_unidadmedida=trim($_POST['nid_unidadmedida']);

if(isset($_POST['nid_um_hasta']))
$nid_um_hasta=trim($_POST['nid_um_hasta']);

if(isset($_POST['nfactor_multiplicador']))
$nfactor_multiplicador=trim($_POST['nfactor_multiplicador']);

if(isset($_POST['nfactor_divisor']))
$nfactor_divisor=trim($_POST['nfactor_divisor']);

include_once("../clases/class_conversion.php");
$conversion=new Conversion();
if($operacion=='Registrar'){
  $conversion->nid_um_conversion($nid_um_conversion);
  $conversion->cid_articulo($cid_articulo);
  $conversion->nid_unidadmedida($nid_unidadmedida);
  $conversion->nid_um_hasta($nid_um_hasta);
  $conversion->nfactor_multiplicador($nfactor_multiplicador);
  $conversion->nfactor_divisor($nfactor_divisor);
  if(!$conversion->Comprobar()){
    if($conversion->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($conversion->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($conversion->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La conversión ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#conversion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la conversión.";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#conversion");
  }
}

if($operacion=='Modificar'){
  $conversion->nid_um_conversion($nid_um_conversion);
  $conversion->cid_articulo($cid_articulo);
  $conversion->nid_unidadmedida($nid_unidadmedida);
  $conversion->nid_um_hasta($nid_um_hasta);
  $conversion->nfactor_multiplicador($nfactor_multiplicador);
  $conversion->nfactor_divisor($nfactor_divisor);
  if($conversion->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La conversión ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#conversion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la conversión.";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#conversion");
  }
}

if($operacion=='Desactivar'){
  $conversion->nid_um_conversion($nid_um_conversion);
  $conversion->cid_articulo($cid_articulo);
  $conversion->nid_unidadmedida($nid_unidadmedida);
  $conversion->nid_um_hasta($nid_um_hasta);
  $conversion->nfactor_multiplicador($nfactor_multiplicador);
  $conversion->nfactor_divisor($nfactor_divisor);
  if($conversion->Consultar()){
    if($conversion->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La conversión ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#conversion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la conversión.";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#conversion");
  }
}

if($operacion=='Activar'){
  $conversion->nid_um_conversion($nid_um_conversion);
  $conversion->cid_articulo($cid_articulo);
  $conversion->nid_unidadmedida($nid_unidadmedida);
  $conversion->nid_um_hasta($nid_um_hasta);
  $conversion->nfactor_multiplicador($nfactor_multiplicador);
  $conversion->nfactor_divisor($nfactor_divisor);
  if($conversion->Consultar()){
    if($conversion->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La conversión ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#conversion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la conversión.";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#conversion");
  }
}

if($operacion=='Consultar'){	
  $conversion->cid_articulo($cid_articulo);
  $conversion->nid_unidadmedida($nid_unidadmedida);
  $conversion->nid_um_hasta($nid_um_hasta);
  if($conversion->Consultar()){
    $_SESSION['datos']['nid_um_conversion']=$conversion->nid_um_conversion();
    $_SESSION['datos']['cid_articulo']=$conversion->cid_articulo();
    $_SESSION['datos']['cdescripcionarticulo']=$conversion->cdescripcion();
    $_SESSION['datos']['nid_unidadmedida']=$conversion->nid_unidadmedida();
    $_SESSION['datos']['nid_um_hasta']=$conversion->nid_um_hasta();
    $_SESSION['datos']['nfactor_multiplicador']=$conversion->nfactor_multiplicador();
    $_SESSION['datos']['nfactor_divisor']=$conversion->nfactor_divisor();
    $_SESSION['datos']['estatusconversion']=$conversion->estatusconversion();
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#conversion");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cid_articulo.")";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#conversion");
  }
}		  
?>