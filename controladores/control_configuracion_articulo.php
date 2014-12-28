<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['filtro']))
//Asignar valor a variable
$filtro=ucfirst(trim($_POST['filtro']));

if(isset($_POST['cid_articulo']))
  $cid_articulo=trim($_POST['cid_articulo']);

if(isset($_POST['nid_configuracion_articulo']))
  $nid_configuracion_articulo=trim($_POST['nid_configuracion_articulo']);

if(isset($_POST['cid_insumo']))
  $cid_insumo=trim($_POST['cid_insumo']);

if(isset($_POST['ncantidad']))
  $ncantidad=trim($_POST['ncantidad']);

if(isset($_POST['nmerma']))
  $nmerma=trim($_POST['nmerma']);

if(isset($_POST['cinsumobase']))
  $cinsumobase=trim($_POST['cinsumobase']);

function comprobarCheckBox($value){
  if($value == "on")
    $chk = "Y";
  else
    $chk = "N";
  return $chk;
}

include_once("../clases/class_configuracion_articulo.php");
$configuracion_articulo=new Configuracion_Articulo();
if($operacion=='Registrar'){
  $configuracion_articulo->nid_configuracion_articulo($nid_configuracion_articulo);
  $configuracion_articulo->cid_articulo($cid_articulo);
  $configuracion_articulo->cid_insumo($cid_insumo);
  $configuracion_articulo->ncantidad($ncantidad);
  $configuracion_articulo->nmerma($nmerma);
  $configuracion_articulo->cinsumobase(comprobarCheckBox($cinsumobase));
  if(!$configuracion_articulo->Comprobar()){
    if($configuracion_articulo->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($configuracion_articulo->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($configuracion_articulo->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La configuración del artículo ha sido registrada con exito!";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#configuracion_articulo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la configuración del artículo.";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#configuracion_articulo");
  }
}

if($operacion=='Modificar'){
  $configuracion_articulo->nid_configuracion_articulo($nid_configuracion_articulo);
  $configuracion_articulo->cid_articulo($cid_articulo);
  $configuracion_articulo->cid_insumo($cid_insumo);
  $configuracion_articulo->ncantidad($ncantidad);
  $configuracion_articulo->nmerma($nmerma);
  $configuracion_articulo->cinsumobase(comprobarCheckBox($cinsumobase));
  if($configuracion_articulo->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La configuración del artículo ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#configuracion_articulo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la configuración del artículo.";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#configuracion_articulo");
  }
}

if($operacion=='Desactivar'){
  $configuracion_articulo->nid_configuracion_articulo($nid_configuracion_articulo);
  $configuracion_articulo->cid_articulo($cid_articulo);
  $configuracion_articulo->cid_insumo($cid_insumo);
  if($configuracion_articulo->Consultar()){
    if($configuracion_articulo->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La configuración del artículo ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#configuracion_articulo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el artículo.";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#configuracion_articulo");
  }
}

if($operacion=='Activar'){
  $configuracion_articulo->nid_configuracion_articulo($nid_configuracion_articulo);
  $configuracion_articulo->cid_articulo($cid_articulo);
  $configuracion_articulo->cid_insumo($cid_insumo);
  if($configuracion_articulo->Consultar()){
    if($configuracion_articulo->Activar($_SESSION['user_name'])){
      $confirmacion=1;
    }
    else{
      $confirmacion=-1;
    }
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La configuración del artículo ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#configuracion_articulo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la configuración del artículo.";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#configuracion_articulo");
  }
}

if($operacion=='Consultar'){
  $configuracion_articulo->nid_configuracion_articulo($nid_configuracion_articulo);
  $configuracion_articulo->cid_articulo($cid_articulo);
  $configuracion_articulo->cid_insumo($cid_insumo);
  if($configuracion_articulo->Consultar()){
    $_SESSION['datos']['nid_configuracion_articulo']=$configuracion_articulo->nid_configuracion_articulo();
    $_SESSION['datos']['cid_articulo']=$configuracion_articulo->cid_articulo();
    $_SESSION['datos']['cdescripcionarticulo']=$configuracion_articulo->articulo();
    $_SESSION['datos']['cid_insumo']=$configuracion_articulo->cid_insumo();
    $_SESSION['datos']['ncantidad']=$configuracion_articulo->ncantidad();
    $_SESSION['datos']['nmerma']=$configuracion_articulo->nmerma();
    $_SESSION['datos']['cinsumobase']=$configuracion_articulo->cinsumobase();
    $_SESSION['datos']['csimbolo']=$configuracion_articulo->csimbolo();
    $_SESSION['datos']['estatusconfiguracion']=$configuracion_articulo->estatusconfiguracion();
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#configuracion_articulo");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró ningún resultado con el filtro de búsqueda(".$cid_articulo.")";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#configuracion_articulo");
  }
}

if($operacion=="BuscarUM"){
  echo $configuracion_articulo->BuscarUM($filtro);
  unset($configuracion_articulo);
}
?>