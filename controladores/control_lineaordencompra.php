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

if(isset($_POST['nid_detalledocumento']))
  $nid_detalledocumento=trim($_POST['nid_detalledocumento']);

if(isset($_POST['nid_documento']))
  $nid_documento=trim($_POST['nid_documento']);

if(isset($_POST['nlinea']))
  $nlinea=trim($_POST['nlinea']);

if(isset($_POST['cid_articulo']))
  $cid_articulo=trim($_POST['cid_articulo']);

if(isset($_POST['ncantidad_articulo']))
  $ncantidad_articulo=trim($_POST['ncantidad_articulo']);

if(isset($_POST['nid_impuesto']))
  $nid_impuesto=trim($_POST['nid_impuesto']);

if(isset($_POST['nprecio']))
  $nprecio=trim($_POST['nprecio']);

if(isset($_POST['npreciolista']))
  $npreciolista=trim($_POST['npreciolista']);

if(isset($_POST['almacen']))
  $almacen=trim($_POST['almacen']);

if(isset($_POST['nmontoneto']))
  $nmonto_total=($_POST['nmontoneto']+$_POST['nmontoimpuesto'])-$_POST['nmontodescuento'];

include_once("../clases/class_lineaordencompra.php");
$detalle_documento=new Detalle_Documento();
if($operacion=='Registrar'){
  $detalle_documento->nid_detalledocumento($nid_detalledocumento);
  $detalle_documento->nid_documento($nid_documento);
  $detalle_documento->nlinea($nlinea);
  $detalle_documento->cid_articulo($cid_articulo);
  $detalle_documento->ncantidad_articulo($ncantidad_articulo);
  $detalle_documento->nid_impuesto($nid_impuesto);
  $detalle_documento->nid_almacen($almacen);
  $detalle_documento->nprecio($nprecio);
  $detalle_documento->npreciolista($npreciolista);
  $detalle_documento->nmonto_total($nmonto_total);
  if(!$detalle_documento->Comprobar()){
    if($detalle_documento->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($detalle_documento->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($detalle_documento->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La línea de la órden ha sido registrada con exito!";
    $_SESSION['datos']['nlinea']=$detalle_documento->nlinea()+1;
    header("Location: ../vistas/menu_principal.php?ordencompra#lineaordencompra");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la línea de la órden.";
    header("Location: ../vistas/menu_principal.php?ordencompra#lineaordencompra");
  }
}

if($operacion=='Modificar'){
  $detalle_documento->nid_detalledocumento($nid_detalledocumento);
  $detalle_documento->nid_documento($nid_documento);
  $detalle_documento->nlinea($nlinea);
  $detalle_documento->cid_articulo($cid_articulo);
  $detalle_documento->ncantidad_articulo($ncantidad_articulo);
  $detalle_documento->nid_impuesto($nid_impuesto);
  $detalle_documento->nid_almacen($almacen);
  $detalle_documento->nprecio($nprecio);
  $detalle_documento->nmonto_total($nmonto_total);
  if($detalle_documento->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La líneaa de órden ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?ordencompra#lineaordencompra");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la línea de órden.";
    header("Location: ../vistas/menu_principal.php?ordencompra#lineaordencompra");
  }
}

if($operacion=='Desactivar'){
  $detalle_documento->nid_documento($nid_documento);
  $detalle_documento->nlinea($nlinea);
  if($detalle_documento->Consultar()){
    if($detalle_documento->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La línea de órden ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?ordencompra#lineaordencompra");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la línea de órden.";
    header("Location: ../vistas/menu_principal.php?ordencompra#lineaordencompra");
  }
}

if($operacion=='Activar'){
  $detalle_documento->nid_documento($nid_documento);
  $detalle_documento->nlinea($nlinea);
  if($detalle_documento->Consultar()){
    if($detalle_documento->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="la línea de órden ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?ordencompra#lineaordencompra");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la línea de órden.";
    header("Location: ../vistas/menu_principal.php?ordencompra#lineaordencompra");
  }
}

if($operacion=='Consultar'){	
  $detalle_documento->nid_documento($nid_documento);
  $detalle_documento->nlinea($nlinea);
  if($detalle_documento->Consultar()){
    $_SESSION['datos']['nid_detalledocumento']=$detalle_documento->nid_detalledocumento();
    $_SESSION['datos']['nid_documento']=$detalle_documento->nid_documento();
    $_SESSION['datos']['nnro_orden']=$detalle_documento->nnro_orden();
    $_SESSION['datos']['dfecha_documento']=$detalle_documento->dfecha_documento();
    $_SESSION['datos']['nlinea']=$detalle_documento->nlinea();
    $_SESSION['datos']['cid_articulo']=$detalle_documento->cid_articulo();
    $_SESSION['datos']['ncantidad_articulo']=$detalle_documento->ncantidad_articulo();
    $_SESSION['datos']['nid_impuesto']=$detalle_documento->nid_impuesto();
    $_SESSION['datos']['nid_almaceninventario']=$detalle_documento->nid_almacen();
    $_SESSION['datos']['nprecio']=$detalle_documento->nprecio();
    $_SESSION['datos']['npreciolista']=$detalle_documento->npreciolista();
    $_SESSION['datos']['npreciolimite']=$detalle_documento->npreciolimite();
    $_SESSION['datos']['ndescuento']=$detalle_documento->ndescuento();
    $_SESSION['datos']['nimpuesto']=$detalle_documento->nimpuesto();
    $_SESSION['datos']['nmontoneto']=$detalle_documento->nmontoneto();
    $_SESSION['datos']['nmontoimpuesto']=$detalle_documento->nmontoimpuesto();
    $_SESSION['datos']['nmontodescuento']=$detalle_documento->nmontodescuento();
    header("Location: ../vistas/menu_principal.php?ordencompra#lineaordencompra");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cid_articulo.")";
    header("Location: ../vistas/menu_principal.php?ordencompra#lineaordencompra");
  }
}

if($operacion=="BuscarPrecio"){
  echo $detalle_documento->BuscarPrecioLista($filtro);
  unset($detalle_documento);
}

if($operacion=="BuscarImpuesto"){
  echo $detalle_documento->BuscarImpuesto($filtro);
  unset($detalle_documento);
}
?>