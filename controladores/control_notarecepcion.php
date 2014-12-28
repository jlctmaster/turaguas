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

if(isset($_POST['nid_documentocompra']))
$nid_documentocompra=trim($_POST['nid_documentocompra']);

if(isset($_POST['nid_tipodocumento']))
$nid_tipodocumento=trim($_POST['nid_tipodocumento']);

if(isset($_POST['nnro_solicitud']))
$nnro_solicitud=trim($_POST['nnro_solicitud']);

if(isset($_POST['numero_solicitud']))
$numero_solicitud=trim($_POST['numero_solicitud']);

if(isset($_POST['dfecha_documento']))
$dfecha_documento=trim($_POST['dfecha_documento']);

if(isset($_POST['nnro_factura']))
$nnro_factura=trim($_POST['nnro_factura']);

if(isset($_POST['nnro_recepcion']))
$nnro_recepcion=trim($_POST['nnro_recepcion']);

if(isset($_POST['dfecha_recepcion']))
$dfecha_recepcion=trim($_POST['dfecha_recepcion']);

if(isset($_POST['crif_persona']))
$crif_persona=trim($_POST['crif_persona']);

include_once("../clases/class_notarecepcion.php");
$notarecepcion=new NotaRecepcion();
if($operacion=='Registrar'){
  $notarecepcion->nid_documentocompra($nid_documentocompra);
  $notarecepcion->nid_tipodocumento($nid_tipodocumento);
  $notarecepcion->nnro_solicitud($nnro_solicitud);
  $notarecepcion->dfecha_documento($dfecha_documento);
  $notarecepcion->nnro_factura($nnro_factura);
  $notarecepcion->nnro_recepcion($nnro_recepcion);
  $notarecepcion->dfecha_recepcion($dfecha_recepcion);
  $notarecepcion->crif_persona($crif_persona);
     if(!$notarecepcion->Comprobar()){
      if($notarecepcion->Registrar($_SESSION['user_name'])){
         if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad'])){
          for($i=0;$i<count($_POST['linea']);$i++){
            $notarecepcion->nlinea($_POST['linea'][$i]);
            $notarecepcion->cid_articulo($_POST['articulo'][$i]);
            $notarecepcion->ncantidad_articulo($_POST['cantidad'][$i]);
            $notarecepcion->InsertarDetalle($_SESSION['user_name']);
          }
        }
        $notarecepcion->CrearMovimiento($_SESSION['user_name']);
        $confirmacion=1;
      }else
        $confirmacion=-1;
  }else{
    if($notarecepcion->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($notarecepcion->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $nnro_recepcion=$notarecepcion->BuscarNuevoRegistro();
    $_SESSION['datos']['mensaje']="La nota de recepción ha sido registrada con exito, el número de la nota es ".$nnro_recepcion;
    header("Location: ../vistas/menu_principal.php?notarecepcion#notarecepcion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la nota de recepción.";
    header("Location: ../vistas/menu_principal.php?notarecepcion#notarecepcion");
  }
}
if($operacion=='Modificar'){
  $notarecepcion->nid_documentocompra($nid_documentocompra);
  $notarecepcion->nid_tipodocumento($nid_tipodocumento);
  $notarecepcion->nnro_solicitud($numero_solicitud);
  $notarecepcion->dfecha_documento($dfecha_documento);
  $notarecepcion->nnro_factura($nnro_factura);
  $notarecepcion->nnro_recepcion($nnro_recepcion);
  $notarecepcion->dfecha_recepcion($dfecha_recepcion);
  $notarecepcion->crif_persona($crif_persona);
    if($notarecepcion->Actualizar($_SESSION['user_name'])){
       if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad'])){
        for($i=0;$i<count($_POST['linea']);$i++){
          $notarecepcion->nid_documentocompra($nid_documentocompra);
          $notarecepcion->nlinea($_POST['linea'][$i]);
          $notarecepcion->cid_articulo($_POST['articulo'][$i]);
          $notarecepcion->ncantidad_articulo($_POST['cantidad'][$i]);
          $notarecepcion->ncantidad_articulo_viejo($_POST['cantidad_vieja'][$i]);
          $notarecepcion->ActualizarDetalle($_SESSION['user_name']);
        }
      }
      $notarecepcion->ModificarMovimiento($_SESSION['user_name']);
      $confirmacion=1;
    }else
      $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota de recepción ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?notarecepcion#notarecepcion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la nota de recepción.";
    header("Location: ../vistas/menu_principal.php?notarecepcion#notarecepcion");
  }
}

if($operacion=='Desactivar'){
  $notarecepcion->nid_documentocompra($nid_documentocompra);
  if($notarecepcion->Consultar()){
    if($notarecepcion->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota de recepción ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?notarecepcion#notarecepcion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la nota de recepción.";
    header("Location: ../vistas/menu_principal.php?notarecepcion#notarecepcion");
  }
}


if($operacion=='Activar'){
  $notarecepcion->nid_documentocompra($nid_documentocompra);
  if($notarecepcion->Consultar()){
    if($notarecepcion->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota de recepción ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?notarecepcion#notarecepcion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la nota de recepción.";
    header("Location: ../vistas/menu_principal.php?notarecepcion#notarecepcion");
  }
}

if($operacion=='Consultar'){ 
  $notarecepcion->nnro_recepcion($nnro_recepcion);
  if($notarecepcion->Consultar()){
    $_SESSION['datos']['nid_documentocompra']=$notarecepcion->nid_documentocompra();
    $_SESSION['datos']['nnro_solicitud']=$notarecepcion->nnro_solicitud();
    $_SESSION['datos']['dfecha_documento']=$notarecepcion->dfecha_documento();
    $_SESSION['datos']['nnro_factura']=$notarecepcion->nnro_factura();
    $_SESSION['datos']['nnro_recepcion']=$notarecepcion->nnro_recepcion();
    $_SESSION['datos']['dfecha_recepcion']=$notarecepcion->dfecha_recepcion();
    $_SESSION['datos']['crif_persona']=$notarecepcion->crif_persona();
    $_SESSION['datos']['cnombreproveedor']=$notarecepcion->cnombre();
    $_SESSION['datos']['estatus']=$notarecepcion->estatus();
    header("Location: ../vistas/menu_principal.php?notarecepcion#notarecepcion");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$nnro_recepcion.")";
    header("Location: ../vistas/menu_principal.php?notarecepcion#notarecepcion");
  }
}

if($operacion=="BuscarDatosNroSolicitud"){
  echo $notarecepcion->BuscarDatosNroSolicitud($nnro_solicitud);
  unset($notarecepcion);
}

if($operacion=="BuscarDatosProveedor"){
  echo $notarecepcion->BuscarDatosProveedor($filtro);
  unset($notarecepcion);
}

?>