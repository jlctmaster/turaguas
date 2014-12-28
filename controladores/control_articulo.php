<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['cid_articulo']))
  $cid_articulo=trim($_POST['cid_articulo']);

if(isset($_POST['nid_tipoarticulo']))
  $nid_tipoarticulo=trim($_POST['nid_tipoarticulo']);

if(isset($_POST['nid_presentacion']))
  $nid_presentacion=trim($_POST['nid_presentacion']);

if(isset($_POST['nid_categoria']))
  $nid_categoria=trim($_POST['nid_categoria']);

if(isset($_POST['nid_marca']))
  $nid_marca=trim($_POST['nid_marca']);

if(isset($_POST['nid_impuesto']))
  $nid_impuesto=trim($_POST['nid_impuesto']);

if(isset($_POST['cdescripcionarticulo']))
  $cdescripcionarticulo=trim($_POST['cdescripcionarticulo']);

if(isset($_POST['ncantidad_min']))
  $ncantidad_min=trim($_POST['ncantidad_min']);

if(isset($_POST['ncantidad_max']))
  $ncantidad_max=trim($_POST['ncantidad_max']);

include_once("../clases/class_articulo.php");
$articulo=new Articulo();
if($operacion=='Registrar'){
  $articulo->cid_articulo($cid_articulo);
  $articulo->nid_tipoarticulo($nid_tipoarticulo);
  $articulo->nid_impuesto($nid_impuesto);
  $articulo->nid_presentacion($nid_presentacion);
  $articulo->nid_categoria($nid_categoria);
  $articulo->nid_marca($nid_marca);
  $articulo->cdescripcionarticulo($cdescripcionarticulo);
  $articulo->ncantidad_min($ncantidad_min);
  $articulo->ncantidad_max($ncantidad_max);
  if(!$articulo->Comprobar()){
    if($articulo->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($articulo->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($articulo->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El artículo ha sido registrada con exito!";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#articulo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el artículo.";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#articulo");
  }
}

if($operacion=='Modificar'){
  $articulo->cid_articulo($cid_articulo);
  $articulo->nid_tipoarticulo($nid_tipoarticulo);
  $articulo->nid_impuesto($nid_impuesto);
  $articulo->nid_presentacion($nid_presentacion);
  $articulo->nid_categoria($nid_categoria);
  $articulo->nid_marca($nid_marca);
  $articulo->cdescripcionarticulo($cdescripcionarticulo);
  $articulo->ncantidad_min($ncantidad_min);
  $articulo->ncantidad_max($ncantidad_max);
  if($articulo->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El artículo ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#articulo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el artículo.";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#articulo");
  }
}

if($operacion=='Desactivar'){
  $articulo->cid_articulo($cid_articulo);
  $articulo->nid_tipoarticulo($nid_tipoarticulo);
  $articulo->nid_impuesto($nid_impuesto);
  $articulo->nid_presentacion($nid_presentacion);
  $articulo->nid_categoria($nid_categoria);
  $articulo->nid_marca($nid_marca);
  $articulo->cdescripcionarticulo($cdescripcionarticulo);
  $articulo->ncantidad_min($ncantidad_min);
  $articulo->ncantidad_max($ncantidad_max);
  if($articulo->Consultar()){
    if($articulo->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El artículo ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#articulo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el artículo.";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#articulo");
  }
}

if($operacion=='Activar'){
  $articulo->cid_articulo($cid_articulo);
  $articulo->nid_tipoarticulo($nid_tipoarticulo);
  $articulo->nid_impuesto($nid_impuesto);
  $articulo->nid_presentacion($nid_presentacion);
  $articulo->nid_categoria($nid_categoria);
  $articulo->nid_marca($nid_marca);
  $articulo->cdescripcionarticulo($cdescripcionarticulo);
  $articulo->ncantidad_min($ncantidad_min);
  $articulo->ncantidad_max($ncantidad_max);
  if($articulo->Consultar()){
    if($articulo->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El artículo ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#articulo");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el artículo.";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#articulo");
  }
}

if($operacion=='Consultar'){	
  $articulo->cid_articulo($cid_articulo);
  if($articulo->Consultar()){
    $_SESSION['datos']['cid_articulo']=$articulo->cid_articulo();
    $_SESSION['datos']['nid_tipoarticulo']=$articulo->nid_tipoarticulo();
    $_SESSION['datos']['nid_impuesto']=$articulo->nid_impuesto();
    $_SESSION['datos']['nid_presentacion']=$articulo->nid_presentacion();
    $_SESSION['datos']['nid_categoria']=$articulo->nid_categoria();
    $_SESSION['datos']['nid_marca']=$articulo->nid_marca();
    $_SESSION['datos']['cdescripcionarticulo']=$articulo->cdescripcionarticulo();
    $_SESSION['datos']['ncantidad_min']=$articulo->ncantidad_min();
    $_SESSION['datos']['ncantidad_max']=$articulo->ncantidad_max();
    $_SESSION['datos']['estatusarticulo']=$articulo->estatusarticulo();
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#articulo");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró ningún resultado con el filtro de búsqueda(".$cid_articulo.")";
    header("Location: ../vistas/menu_principal.php?articulo_conversion_configuracion#articulo");
  }
}

if($operacion=="AsignarNombre"){
  echo $articulo->GenerarNombreArticulo($nid_categoria,$nid_marca,$nid_presentacion);
  unset($articulo);
}
?>