<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['filtro']))
//Asignar valor a variable de filtro
  $filtro=$_POST['filtro'];

if(isset($_POST['estatus']))
//Asignar valor a variable de filtro
  $estatus=$_POST['estatus'];

if(isset($_POST['nid_motivorazon']))
//Asignar valor a variable de filtro
  $nid_motivorazon=$_POST['nid_motivorazon'];

if(isset($_POST['nid_documento']))
  $nid_documento=trim($_POST['nid_documento']);

if(isset($_POST['nnro_orden']))
  $nnro_orden=trim($_POST['nnro_orden']);

if(isset($_POST['nnro_ent_recib']))
  $nnro_ent_recib=trim($_POST['nnro_ent_recib']);

if(isset($_POST['nid_tipodocumento']))
  $nid_tipodocumento=trim($_POST['nid_tipodocumento']);

if(isset($_POST['dfecha_documento']))
  $dfecha_documento=trim($_POST['dfecha_documento']);

if(isset($_POST['dfecha_ent_recib']))
  $dfecha_ent_recib=trim($_POST['dfecha_ent_recib']);

if(isset($_POST['crif_persona']))
  $crif_persona=trim($_POST['crif_persona']);

if(isset($_POST['cdirecciondespacho']))
  $cdirecciondespacho=trim($_POST['cdirecciondespacho']);

if(isset($_POST['nid_condicionpago']))
  $nid_condicionpago=trim($_POST['nid_condicionpago']);

if(isset($_POST['nid_almacen']))
  $nid_almacen=trim($_POST['nid_almacen']);

if(isset($_POST['cestado_documento']))
  $cestado_documento=trim($_POST['cestado_documento']);

if(isset($_POST['caccion_documento']))
  $caccion_documento=trim($_POST['caccion_documento']);

if(isset($_POST['nmonto_total']))
  $nmonto_total=trim($_POST['nmonto_total']);

include_once("../clases/class_ordendespacho.php");
$documento=new Documento();
if($operacion=='Registrar'){
  $documento->nid_documento($nid_documento);
  $documento->nnro_orden($nnro_orden);
  $documento->nnro_ent_recib($nnro_ent_recib);
  $documento->nid_tipodocumento($nid_tipodocumento);
  $documento->dfecha_documento($dfecha_documento);
  $documento->dfecha_ent_recib($dfecha_ent_recib);
  $documento->crif_persona($crif_persona);
  $documento->cdirecciondespacho($cdirecciondespacho);
  $documento->nid_condicionpago($nid_condicionpago);
  $documento->nid_almacen($nid_almacen);
  $documento->cestado_documento($cestado_documento);
  $documento->caccion_documento($caccion_documento);
  $documento->nmonto_total($nmonto_total);
  if(!$documento->Comprobar()){
    if($documento->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($documento->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($documento->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El documento ha sido registrado con exito!";
    $documento->nid_documento($nid_documento);
    $documento->nnro_ent_recib($nnro_ent_recib);
    if($documento->Consultar()){
      $_SESSION['datos']['nid_documento']=$documento->nid_documento();
      $_SESSION['datos']['nnro_orden']=$documento->nnro_orden();
      $_SESSION['datos']['nnro_ent_recib']=$documento->nnro_ent_recib();
      $_SESSION['datos']['nid_tipodocumento']=$documento->nid_tipodocumento();
      $_SESSION['datos']['dfecha_documento']=$documento->dfecha_documento();
      $_SESSION['datos']['dfecha_ent_recib']=$documento->dfecha_ent_recib();
      $_SESSION['datos']['nid_documentodocumento']=$documento->nid_documento();
      $_SESSION['datos']['crif_persona']=$documento->crif_persona();
      $_SESSION['datos']['cnombrecliente']=$documento->cnombrecliente();
      $_SESSION['datos']['cdireccioncliente']=$documento->cdireccioncliente();
      $_SESSION['datos']['cdirecciondespacho']=$documento->cdirecciondespacho();
      $_SESSION['datos']['nid_condicionpago']=$documento->nid_condicionpago();
      $_SESSION['datos']['nid_almacen']=$documento->nid_almacen();
      $_SESSION['datos']['cestado_documento']=$documento->cestado_documento();
      $_SESSION['datos']['caccion_documento']=$documento->caccion_documento();
      $_SESSION['datos']['nmonto_base']=$documento->nmonto_base();
      $_SESSION['datos']['nmonto_total']=$documento->nmonto_total();
      $_SESSION['datos']['estatus']=$documento->estatus_documento();
      header("Location: ../vistas/menu_principal.php?ordendespacho#lineaordendespacho");
    }
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el documento.";
    header("Location: ../vistas/menu_principal.php?ordendespacho#ordendespacho");
  }
}

if($operacion=='Modificar'){
  $documento->nid_documento($nid_documento);
  $documento->nnro_orden($nnro_orden);
  $documento->nnro_ent_recib($nnro_ent_recib);
  $documento->nid_tipodocumento($nid_tipodocumento);
  $documento->dfecha_documento($dfecha_documento);
  $documento->dfecha_ent_recib($dfecha_ent_recib);
  $documento->crif_persona($crif_persona);
  $documento->cdirecciondespacho($cdirecciondespacho);
  $documento->nid_condicionpago($nid_condicionpago);
  $documento->nid_almacen($nid_almacen);
  $documento->cestado_documento($cestado_documento);
  $documento->caccion_documento($caccion_documento);
  $documento->nmonto_total($nmonto_total);
  if($documento->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El documento ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?ordendespacho#ordendespacho");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el documento.";
    header("Location: ../vistas/menu_principal.php?ordendespacho#ordendespacho");
  }
}

if($operacion=='Desactivar'){
  $documento->nid_documento($nid_documento);
  $documento->nnro_orden($nnro_orden);
  if($documento->Consultar()){
    if($documento->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El documento ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?ordendespacho#ordendespacho");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el documento.";
    header("Location: ../vistas/menu_principal.php?ordendespacho#ordendespacho");
  }
}

if($operacion=='Activar'){
  $documento->nid_documento($nid_documento);
  $documento->nnro_orden($nnro_orden);
  if($documento->Consultar()){
    if($documento->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="el documento ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?ordendespacho#ordendespacho");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el documento.";
    header("Location: ../vistas/menu_principal.php?ordendespacho#ordendespacho");
  }
}

if($operacion=='Consultar'){	
  $documento->nid_documento($nid_documento);
  $documento->nnro_ent_recib($nnro_ent_recib);
  if($documento->Consultar()){
    $_SESSION['datos']['nid_documento']=$documento->nid_documento();
    $_SESSION['datos']['nnro_orden']=$documento->nnro_orden();
    $_SESSION['datos']['nnro_ent_recib']=$documento->nnro_ent_recib();
    $_SESSION['datos']['nid_tipodocumento']=$documento->nid_tipodocumento();
    $_SESSION['datos']['dfecha_documento']=$documento->dfecha_documento();
    $_SESSION['datos']['dfecha_ent_recib']=$documento->dfecha_ent_recib();
    $_SESSION['datos']['nid_documentodocumento']=$documento->nid_documento();
    $_SESSION['datos']['crif_persona']=$documento->crif_persona();
    $_SESSION['datos']['cnombrecliente']=$documento->cnombrecliente();
    $_SESSION['datos']['cdireccioncliente']=$documento->cdireccioncliente();
    $_SESSION['datos']['cdirecciondespacho']=$documento->cdirecciondespacho();
    $_SESSION['datos']['nid_condicionpago']=$documento->nid_condicionpago();
    $_SESSION['datos']['nid_almacen']=$documento->nid_almacen();
    $_SESSION['datos']['cestado_documento']=$documento->cestado_documento();
    $_SESSION['datos']['caccion_documento']=$documento->caccion_documento();
    $_SESSION['datos']['nmonto_base']=$documento->nmonto_base();
    $_SESSION['datos']['nmonto_total']=$documento->nmonto_total();
    $_SESSION['datos']['estatus']=$documento->estatus_documento();
    header("Location: ../vistas/menu_principal.php?ordendespacho#ordendespacho");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$nnro_ent_recib.")";
    header("Location: ../vistas/menu_principal.php?ordendespacho#ordendespacho");
  }
}

if($operacion=="BuscarNroOrden"){
  echo $documento->BuscarNroOrden();
  unset($documento);
}

if($operacion=="BuscarDatosNroOrden"){
  echo $documento->BuscarDatosNroOrden($nnro_orden);
  unset($documento);
}

if($operacion=="BuscarDatosCliente"){
  echo $documento->BuscarDatosCliente($filtro);
  unset($documento);
}

if($operacion=="BuscarDirecciones"){
  echo $documento->BuscarDirecciones($filtro);
  unset($documento);
}

if($operacion=="CambiarEstatus"){
  echo $documento->CambiarEstatus($estatus,$nid_documento,$_SESSION['user_name'],$nid_motivorazon);
  unset($documento);
}

if($operacion=="BuscarEstatus"){
  echo $documento->BuscarEstatus($nid_documento);
  unset($documento);
}
?>