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

if(isset($_POST['nid_devolucion']))
$nid_devolucion=trim($_POST['nid_devolucion']);

if(isset($_POST['nid_tipodocumento']))
$nid_tipodocumento=trim($_POST['nid_tipodocumento']);

if(isset($_POST['nnro_devolucion']))
$nnro_devolucion=trim($_POST['nnro_devolucion']);

if(isset($_POST['dfecha_devolucion']))
$dfecha_devolucion=trim($_POST['dfecha_devolucion']);

if(isset($_POST['nid_documentocompra']))
$nid_documentocompra=trim($_POST['nid_documentocompra']);

if(isset($_POST['nnro_recepcion']))
$nnro_recepcion=trim($_POST['nnro_recepcion']);

if(isset($_POST['dfecha_documento']))
$dfecha_documento=trim($_POST['dfecha_documento']);

include_once("../clases/class_notadevolucionproveedor.php");
$notadevolucionproveedor=new Notadevolucionproveedor();
if($operacion=='Registrar'){
  $notadevolucionproveedor->nid_tipodocumento($nid_tipodocumento);
  $notadevolucionproveedor->nnro_devolucion($nnro_devolucion);
  $notadevolucionproveedor->dfecha_devolucion($dfecha_devolucion);
  $notadevolucionproveedor->nid_documentocompra($nid_documentocompra);
     if(!$notadevolucionproveedor->Comprobar()){
      if($notadevolucionproveedor->Registrar($_SESSION['user_name'])){
         if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad']) && isset($_POST['motivodevolucion'])){
          for($i=0;$i<count($_POST['linea']);$i++){
            if($_POST['cantidad'][$i]>0){
              $notadevolucionproveedor->nlinea($_POST['linea'][$i]);
              $notadevolucionproveedor->cid_articulo($_POST['articulo'][$i]);
              $notadevolucionproveedor->ncantidad_articulo($_POST['cantidad'][$i]);
              $notadevolucionproveedor->nid_motivodevolucion($_POST['motivodevolucion'][$i]);
              $notadevolucionproveedor->InsertarDetalle($_SESSION['user_name']);
            }
          }
        }
        $notadevolucionproveedor->CrearMovimiento($_SESSION['user_name']);
        $confirmacion=1;
      }else
        $confirmacion=-1;
  }else{
    if($notadevolucionproveedor->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($notadevolucionproveedor->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $nnro_devolucion=$notadevolucionproveedor->BuscarNuevoRegistro();
    $_SESSION['datos']['mensaje']="La nota de devolución ha sido registrada con exito, el número de la nota es ".$nnro_devolucion;
    header("Location: ../vistas/menu_principal.php?notadevolucionproveedor#notadevolucionproveedor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la nota de devolución.";
    header("Location: ../vistas/menu_principal.php?notadevolucionproveedor#notadevolucionproveedor");
  }
}
if($operacion=='Modificar'){
  $notadevolucionproveedor->nid_tipodocumento($nid_tipodocumento);
  $notadevolucionproveedor->nid_devolucion($nid_devolucion);
  $notadevolucionproveedor->nnro_devolucion($nnro_devolucion);
  $notadevolucionproveedor->dfecha_devolucion($dfecha_devolucion);
  $notadevolucionproveedor->nid_documentocompra($nid_documentocompra);
    if($notadevolucionproveedor->Actualizar($_SESSION['user_name'])){
       if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad']) && isset($_POST['motivodevolucion'])){
        for($i=0;$i<count($_POST['linea']);$i++){
          if($_POST['cantidad'][$i]>0){
            $notadevolucionproveedor->nid_documentocompra($nid_documentocompra);
            $notadevolucionproveedor->nlinea($_POST['linea'][$i]);
            $notadevolucionproveedor->cid_articulo($_POST['articulo'][$i]);
            $notadevolucionproveedor->ncantidad_articulo($_POST['cantidad'][$i]);
            $notadevolucionproveedor->ncantidad_articulo_viejo($_POST['cantidad_vieja'][$i]);
            $notadevolucionproveedor->nid_motivodevolucion($_POST['motivodevolucion'][$i]);
            $notadevolucionproveedor->ActualizarDetalle($_SESSION['user_name']);
          }
        }
      }
      $notadevolucionproveedor->ModificarMovimiento($_SESSION['user_name']);
      $confirmacion=1;
    }else
      $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota de devolución ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?notadevolucionproveedor#notadevolucionproveedor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la nota de devolución.";
    header("Location: ../vistas/menu_principal.php?notadevolucionproveedor#notadevolucionproveedor");
  }
}

if($operacion=='Desactivar'){
  $notadevolucionproveedor->nid_devolucion($nid_devolucion);
  if($notadevolucionproveedor->Consultar()){
    if($notadevolucionproveedor->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota de devolución ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?notadevolucionproveedor#notadevolucionproveedor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la notade devolución.";
    header("Location: ../vistas/menu_principal.php?notadevolucionproveedor#notadevolucionproveedor");
  }
}


if($operacion=='Activar'){
  $notadevolucionproveedor->nid_devolucion($nid_devolucion);
  if($notadevolucionproveedor->Consultar()){
    if($notadevolucionproveedor->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota de devolución ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?notadevolucionproveedor#notadevolucionproveedor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la nota de devolución.";
    header("Location: ../vistas/menu_principal.php?notadevolucionproveedor#notadevolucionproveedor");
  }
}

if($operacion=='Consultar'){ 
  $notadevolucionproveedor->nnro_devolucion($nnro_devolucion);
  if($notadevolucionproveedor->Consultar()){
    $_SESSION['datos']['nid_devolucion']=$notadevolucionproveedor->nid_devolucion();
    $_SESSION['datos']['nnro_devolucion']=$notadevolucionproveedor->nnro_devolucion();
    $_SESSION['datos']['dfecha_devolucion']=$notadevolucionproveedor->dfecha_devolucion();
    $_SESSION['datos']['nid_documentocompra']=$notadevolucionproveedor->nid_documentocompra();
    $_SESSION['datos']['nnro_recepcion']=$notadevolucionproveedor->nnro_recepcion();
    $_SESSION['datos']['dfecha_documento']=$notadevolucionproveedor->dfecha_documento();
    $_SESSION['datos']['estatus']=$notadevolucionproveedor->estatus();
    header("Location: ../vistas/menu_principal.php?notadevolucionproveedor#notadevolucionproveedor");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$nnro_devolucion.")";
    header("Location: ../vistas/menu_principal.php?notadevolucionproveedor#notadevolucionproveedor");
  }
}

if($operacion=="BuscarDatosNroRecepcion"){
  echo $notadevolucionproveedor->BuscarDatosNroRecepcion($nnro_recepcion);
  unset($notadevolucionproveedor);
}
?>