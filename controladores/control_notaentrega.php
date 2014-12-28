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

if(isset($_POST['nid_documentoventa']))
$nid_documentoventa=trim($_POST['nid_documentoventa']);

if(isset($_POST['nid_tipodocumento']))
$nid_tipodocumento=trim($_POST['nid_tipodocumento']);

if(isset($_POST['nnro_cotizacion']))
$nnro_cotizacion=trim($_POST['nnro_cotizacion']);

if(isset($_POST['numero_cotizacion']))
$numero_cotizacion=trim($_POST['numero_cotizacion']);

if(isset($_POST['dfecha_documento']))
$dfecha_documento=trim($_POST['dfecha_documento']);

if(isset($_POST['nnro_factura']))
$nnro_factura=trim($_POST['nnro_factura']);

if(isset($_POST['nnro_entrega']))
$nnro_entrega=trim($_POST['nnro_entrega']);

if(isset($_POST['dfecha_entrega']))
$dfecha_entrega=trim($_POST['dfecha_entrega']);

if(isset($_POST['crif_persona']))
$crif_persona=trim($_POST['crif_persona']);

if(isset($_POST['nid_condicionpago']))
$nid_condicionpago=trim($_POST['nid_condicionpago']);

include_once("../clases/class_notaentrega.php");
$notaentrega=new NotaEntrega();
if($operacion=='Registrar'){
  $notaentrega->nid_documentoventa($nid_documentoventa);
  $notaentrega->nid_tipodocumento($nid_tipodocumento);
  $notaentrega->nnro_cotizacion($nnro_cotizacion);
  $notaentrega->dfecha_documento($dfecha_documento);
  $notaentrega->nnro_factura($nnro_factura);
  $notaentrega->nnro_entrega($nnro_entrega);
  $notaentrega->dfecha_entrega($dfecha_entrega);
  $notaentrega->crif_persona($crif_persona);
  $notaentrega->nid_condicionpago($nid_condicionpago);
     if(!$notaentrega->Comprobar()){
      if($notaentrega->Registrar($_SESSION['user_name'])){
         if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad'])){
          for($i=0;$i<count($_POST['linea']);$i++){
            $notaentrega->nlinea($_POST['linea'][$i]);
            $notaentrega->cid_articulo($_POST['articulo'][$i]);
            $notaentrega->ncantidad_articulo($_POST['cantidad'][$i]);
            $notaentrega->InsertarDetalle($_SESSION['user_name']);
          }
        }
        $notaentrega->CrearMovimiento($_SESSION['user_name']);
        $confirmacion=1;
      }else
        $confirmacion=-1;
  }else{
    if($notaentrega->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($notaentrega->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $nnro_entrega=$notaentrega->BuscarNuevoRegistro();
    $_SESSION['datos']['mensaje']="La nota de entrega ha sido registrada con exito, el número de la nota es ".$nnro_entrega;
    header("Location: ../vistas/menu_principal.php?notaentrega#notaentrega");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la nota de entrega.";
    header("Location: ../vistas/menu_principal.php?notaentrega#notaentrega");
  }
}
if($operacion=='Modificar'){
  $notaentrega->nid_documentoventa($nid_documentoventa);
  $notaentrega->nid_tipodocumento($nid_tipodocumento);
  $notaentrega->nnro_cotizacion($numero_cotizacion);
  $notaentrega->dfecha_documento($dfecha_documento);
  $notaentrega->nnro_factura($nnro_factura);
  $notaentrega->nnro_entrega($nnro_entrega);
  $notaentrega->dfecha_entrega($dfecha_entrega);
  $notaentrega->crif_persona($crif_persona);
  $notaentrega->nid_condicionpago($nid_condicionpago);
    if($notaentrega->Actualizar($_SESSION['user_name'])){
       if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad'])){
        for($i=0;$i<count($_POST['linea']);$i++){
          $notaentrega->nid_documentoventa($nid_documentoventa);
          $notaentrega->nlinea($_POST['linea'][$i]);
          $notaentrega->cid_articulo($_POST['articulo'][$i]);
          $notaentrega->ncantidad_articulo($_POST['cantidad'][$i]);
          $notaentrega->ncantidad_articulo_viejo($_POST['cantidad_vieja'][$i]);
          $notaentrega->ActualizarDetalle($_SESSION['user_name']);
        }
      }
      $notaentrega->ModificarMovimiento($_SESSION['user_name']);
      $confirmacion=1;
    }else
      $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota de entrega ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?notaentrega#notaentrega");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la nota de entrega.";
    header("Location: ../vistas/menu_principal.php?notaentrega#notaentrega");
  }
}

if($operacion=='Desactivar'){
  $notaentrega->nid_documentoventa($nid_documentoventa);
  if($notaentrega->Consultar()){
    if($notaentrega->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota de entrega ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?notaentrega#notaentrega");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la nota de entrega.";
    header("Location: ../vistas/menu_principal.php?notaentrega#notaentrega");
  }
}


if($operacion=='Activar'){
  $notaentrega->nid_documentoventa($nid_documentoventa);
  if($notaentrega->Consultar()){
    if($notaentrega->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota de entrega ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?notaentrega#notaentrega");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la nota de entrega.";
    header("Location: ../vistas/menu_principal.php?notaentrega#notaentrega");
  }
}

if($operacion=='Consultar'){ 
  $notaentrega->nnro_entrega($nnro_entrega);
  if($notaentrega->Consultar()){
    $_SESSION['datos']['nid_documentoventa']=$notaentrega->nid_documentoventa();
    $_SESSION['datos']['nnro_cotizacion']=$notaentrega->nnro_cotizacion();
    $_SESSION['datos']['dfecha_documento']=$notaentrega->dfecha_documento();
    $_SESSION['datos']['nnro_factura']=$notaentrega->nnro_factura();
    $_SESSION['datos']['nnro_entrega']=$notaentrega->nnro_entrega();
    $_SESSION['datos']['dfecha_entrega']=$notaentrega->dfecha_entrega();
    $_SESSION['datos']['crif_persona']=$notaentrega->crif_persona();
    $_SESSION['datos']['cnombrecliente']=$notaentrega->cnombre();
    $_SESSION['datos']['nid_condicionpago']=$notaentrega->nid_condicionpago();
    $_SESSION['datos']['estatus']=$notaentrega->estatus();
    header("Location: ../vistas/menu_principal.php?notaentrega#notaentrega");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$nnro_entrega.")";
    header("Location: ../vistas/menu_principal.php?notaentrega#notaentrega");
  }
}

if($operacion=="BuscarDatosNroCotizacion"){
  echo $notaentrega->BuscarDatosNroCotizacion($nnro_cotizacion);
  unset($notaentrega);
}

if($operacion=="BuscarDatosCliente"){
  echo $notaentrega->BuscarDatosCliente($filtro);
  unset($notaentrega);
}

?>