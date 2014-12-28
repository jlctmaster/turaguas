<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['cid_articulo']))
  $cid_articulo=trim($_POST['cid_articulo']);

if(isset($_POST['nid_listaprecio']))
  $nid_listaprecio=trim($_POST['nid_listaprecio']);

if(isset($_POST['nprecio_limite']))
  $nprecio_limite=trim($_POST['nprecio_limite']);

if(isset($_POST['ndescuento']))
  $ndescuento=trim($_POST['ndescuento']);

if(isset($_POST['nid_detallelistaprecio']))
  $nid_detallelistaprecio=trim($_POST['nid_detallelistaprecio']);

if(isset($_POST['nprecio']))
  $nprecio=trim($_POST['nprecio']);

include_once("../clases/class_linea.php");
$linea=new Linea();
if($operacion=='Registrar'){
  $linea->nid_detallelistaprecio($nid_detallelistaprecio);
  $linea->cid_articulo($cid_articulo);
  $linea->nid_listaprecio($nid_listaprecio);
  $linea->nprecio($nprecio);
  $linea->nprecio_limite($nprecio_limite);
  $linea->ndescuento($ndescuento);
  if(!$linea->Comprobar()){
    if($linea->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($linea->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($linea->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La linea ha sido registrada con exito!";
    header("Location: ../vistas/menu_principal.php?lista_precio#linea");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar lalinea.";
    header("Location: ../vistas/menu_principal.php?lista_precio#linea");
  }
}

if($operacion=='Modificar'){
  $linea->nid_detallelistaprecio($nid_detallelistaprecio);
  $linea->cid_articulo($cid_articulo);
  $linea->nid_listaprecio($nid_listaprecio);
  $linea->nprecio($nprecio);
  $linea->nprecio_limite($nprecio_limite);
  $linea->ndescuento($ndescuento);
  if($linea->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La linea ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?lista_precio#linea");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la linea.";
    header("Location: ../vistas/menu_principal.php?lista_precio#linea");
  }
}

if($operacion=='Desactivar'){
  $linea->nid_detallelistaprecio($nid_detallelistaprecio);
  $linea->cid_articulo($cid_articulo);
  $linea->nid_listaprecio($nid_listaprecio);
  $linea->nprecio($nprecio);
  $linea->nprecio_limite($nprecio_limite);
  $linea->ndescuento($ndescuento);
  if($linea->Consultar()){
    if($linea->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La linea ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?lista_precio#linea");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la linea.";
    header("Location: ../vistas/menu_principal.php?lista_precio#linea");
  }
}

if($operacion=='Activar'){
  $linea->nid_detallelistaprecio($nid_detallelistaprecio);
  $linea->cid_articulo($cid_articulo);
  $linea->nid_listaprecio($nid_listaprecio);
  $linea->nprecio($nprecio);
  $linea->nprecio_limite($nprecio_limite);
  $linea->ndescuento($ndescuento);
  if($linea->Consultar()){
    if($linea->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La linea ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?lista_precio#linea");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la linea.";
    header("Location: ../vistas/menu_principal.php?lista_precio#linea");
  }
}

if($operacion=='Consultar'){	
  $linea->nid_listaprecio($nid_listaprecio);
  $linea->cid_articulo($cid_articulo);
  if($linea->Consultar()){
    $_SESSION['datos']['cdescripcion']=$linea->cdescripcion();
    $_SESSION['datos']['cid_articulo']=$linea->cid_articulo();
    $_SESSION['datos']['nid_listaprecio']=$linea->nid_listaprecio();
    $_SESSION['datos']['nprecio']=$linea->nprecio();
    $_SESSION['datos']['nprecio_limite']=$linea->nprecio_limite();
    $_SESSION['datos']['ndescuento']=$linea->ndescuento();
    $_SESSION['datos']['nid_detallelistaprecio']=$linea->nid_detallelistaprecio();
    $_SESSION['datos']['estatuslinea']=$linea->estatuslinea();
    header("Location: ../vistas/menu_principal.php?lista_precio#linea");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró ningún resultado con el filtro de búsqueda(".$nid_detallelistaprecio.")";
    header("Location: ../vistas/menu_principal.php?lista_precio#linea");
  }
}		  
?>