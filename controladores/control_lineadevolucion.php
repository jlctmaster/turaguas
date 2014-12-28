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

if(isset($_POST['nid_detalledevolucion']))
  $nid_detalledevolucion=trim($_POST['nid_detalledevolucion']);

if(isset($_POST['nid_devolucion']))
  $nid_devolucion=trim($_POST['nid_devolucion']);

if(isset($_POST['nid_motivodevolucion']))
  $nid_motivodevolucion=trim($_POST['nid_motivodevolucion']);

if(isset($_POST['cid_articulo']))
  $cid_articulo=trim($_POST['cid_articulo']);

if(isset($_POST['ncantidad_articulo']))
  $ncantidad_articulo=trim($_POST['ncantidad_articulo']);

include_once("../clases/class_lineadevolucion.php");
$detalle_devolucion=new Detalle_Devolucion();
if($operacion=='Registrar'){
  $detalle_devolucion->nid_detalledevolucion($nid_detalledevolucion);
  $detalle_devolucion->nid_devolucion($nid_devolucion);
  $detalle_devolucion->nid_motivodevolucion($nid_motivodevolucion);
  $detalle_devolucion->cid_articulo($cid_articulo);
  $detalle_devolucion->ncantidad_articulo($ncantidad_articulo);
  if(!$detalle_devolucion->Comprobar()){
    if($detalle_devolucion->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($detalle_devolucion->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($detalle_devolucion->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La línea de la devolución ha sido registrada con exito!";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#lineadevolucionc");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la devolución.";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#lineadevolucionc");
  }
}

if($operacion=='Modificar'){
  $detalle_devolucion->nid_detalledevolucion($nid_detalledevolucion);
  $detalle_devolucion->nid_devolucion($nid_devolucion);
  $detalle_devolucion->nid_motivodevolucion($nid_motivodevolucion);
  $detalle_devolucion->cid_articulo($cid_articulo);
  $detalle_devolucion->ncantidad_articulo($ncantidad_articulo);
  if($detalle_devolucion->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La línea de la devolución ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#lineadevolucionc");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la devolución.";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#lineadevolucionc");
  }
}

if($operacion=='Desactivar'){
  $detalle_devolucion->nid_devolucion($nid_devolucion);
  $detalle_devolucion->nid_detalledevolucion($nid_detalledevolucion);
  if($detalle_devolucion->Consultar()){
    if($detalle_devolucion->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La devolución ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#lineadevolucionc");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la devolución.";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#lineadevolucionc");
  }
}

if($operacion=='Activar'){
  $detalle_devolucion->nid_devolucion($nid_devolucion);
  $detalle_devolucion->nid_detalledevolucion($nid_detalledevolucion);
  if($detalle_devolucion->Consultar()){
    if($detalle_devolucion->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="la devolución ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#lineadevolucionc");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la devolución.";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#lineadevolucionc");
  }
}

if($operacion=='Consultar'){	
  $detalle_devolucion->nid_devolucion($nid_devolucion);
  $detalle_devolucion->cid_articulo($cid_articulo);
  $detalle_devolucion->nid_detalledevolucion($nid_detalledevolucion);
  $detalle_devolucion->nid_motivodevolucion($nid_motivodevolucion);
  if($detalle_devolucion->Consultar()){
    $_SESSION['datos']['nid_detalledevolucion']=$detalle_devolucion->nid_detalledevolucion();
    $_SESSION['datos']['nid_devolucion']=$detalle_devolucion->nid_devolucion();
    $_SESSION['datos']['nnro_devolucion']=$detalle_devolucion->nnro_devolucion();
    $_SESSION['datos']['dfecha_devolucion']=$detalle_devolucion->dfecha_devolucion();
    $_SESSION['datos']['nid_motivodevolucion']=$detalle_devolucion->nid_motivodevolucion();
    $_SESSION['datos']['cid_articulo']=$detalle_devolucion->cid_articulo();
    $_SESSION['datos']['ncantidad_articulo']=$detalle_devolucion->ncantidad_articulo();
    header("Location: ../vistas/menu_principal.php?devolucioncliente#lineadevolucionc");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cid_articulo.")";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#lineadevolucionc");
  }
}
?>