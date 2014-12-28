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

if(isset($_POST['nid_documentoventa']))
$nid_documentoventa=trim($_POST['nid_documentoventa']);

if(isset($_POST['nnro_entrega']))
$nnro_entrega=trim($_POST['nnro_entrega']);

if(isset($_POST['dfecha_documento']))
$dfecha_documento=trim($_POST['dfecha_documento']);

include_once("../clases/class_notadevolucioncliente.php");
$notadevolucioncliente=new Notadevolucioncliente();
if($operacion=='Registrar'){
  $notadevolucioncliente->nid_tipodocumento($nid_tipodocumento);
  $notadevolucioncliente->nnro_devolucion($nnro_devolucion);
  $notadevolucioncliente->dfecha_devolucion($dfecha_devolucion);
  $notadevolucioncliente->nid_documentoventa($nid_documentoventa);
     if(!$notadevolucioncliente->Comprobar()){
      if($notadevolucioncliente->Registrar($_SESSION['user_name'])){
         if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad']) && isset($_POST['motivodevolucion'])){
          for($i=0;$i<count($_POST['linea']);$i++){
            if($_POST['cantidad'][$i]>0){
              $notadevolucioncliente->nlinea($_POST['linea'][$i]);
              $notadevolucioncliente->cid_articulo($_POST['articulo'][$i]);
              $notadevolucioncliente->ncantidad_articulo($_POST['cantidad'][$i]);
              $notadevolucioncliente->nid_motivodevolucion($_POST['motivodevolucion'][$i]);
              $notadevolucioncliente->InsertarDetalle($_SESSION['user_name']);
            }
          }
        }
        $notadevolucioncliente->CrearMovimiento($_SESSION['user_name']);
        $confirmacion=1;
      }else
        $confirmacion=-1;
  }else{
    if($notadevolucioncliente->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($notadevolucioncliente->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $nnro_devolucion=$notadevolucioncliente->BuscarNuevoRegistro();
    $_SESSION['datos']['mensaje']="La nota de devolución ha sido registrada con exito, el número de la nota es ".$nnro_devolucion;
    header("Location: ../vistas/menu_principal.php?notadevolucioncliente#notadevolucioncliente");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la nota de devolución.";
    header("Location: ../vistas/menu_principal.php?notadevolucioncliente#notadevolucioncliente");
  }
}
if($operacion=='Modificar'){
  $notadevolucioncliente->nid_tipodocumento($nid_tipodocumento);
  $notadevolucioncliente->nid_devolucion($nid_devolucion);
  $notadevolucioncliente->nnro_devolucion($nnro_devolucion);
  $notadevolucioncliente->dfecha_devolucion($dfecha_devolucion);
  $notadevolucioncliente->nid_documentoventa($nid_documentoventa);
    if($notadevolucioncliente->Actualizar($_SESSION['user_name'])){
       if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad']) && isset($_POST['motivodevolucion'])){
        for($i=0;$i<count($_POST['linea']);$i++){
          if($_POST['cantidad'][$i]>0){
            $notadevolucioncliente->nid_documentoventa($nid_documentoventa);
            $notadevolucioncliente->nlinea($_POST['linea'][$i]);
            $notadevolucioncliente->cid_articulo($_POST['articulo'][$i]);
            $notadevolucioncliente->ncantidad_articulo($_POST['cantidad'][$i]);
            $notadevolucioncliente->ncantidad_articulo_viejo($_POST['cantidad_vieja'][$i]);
            $notadevolucioncliente->nid_motivodevolucion($_POST['motivodevolucion'][$i]);
            $notadevolucioncliente->ActualizarDetalle($_SESSION['user_name']);
          }
        }
      }
      $notadevolucioncliente->ModificarMovimiento($_SESSION['user_name']);
      $confirmacion=1;
    }else
      $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota de devolución ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?notadevolucioncliente#notadevolucioncliente");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la nota de devolución.";
    header("Location: ../vistas/menu_principal.php?notadevolucioncliente#notadevolucioncliente");
  }
}

if($operacion=='Desactivar'){
  $notadevolucioncliente->nid_devolucion($nid_devolucion);
  if($notadevolucioncliente->Consultar()){
    if($notadevolucioncliente->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota de devolución ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?notadevolucioncliente#notadevolucioncliente");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la notade devolución.";
    header("Location: ../vistas/menu_principal.php?notadevolucioncliente#notadevolucioncliente");
  }
}


if($operacion=='Activar'){
  $notadevolucioncliente->nid_devolucion($nid_devolucion);
  if($notadevolucioncliente->Consultar()){
    if($notadevolucioncliente->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota de devolución ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?notadevolucioncliente#notadevolucioncliente");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la nota de devolución.";
    header("Location: ../vistas/menu_principal.php?notadevolucioncliente#notadevolucioncliente");
  }
}

if($operacion=='Consultar'){ 
  $notadevolucioncliente->nnro_devolucion($nnro_devolucion);
  if($notadevolucioncliente->Consultar()){
    $_SESSION['datos']['nid_devolucion']=$notadevolucioncliente->nid_devolucion();
    $_SESSION['datos']['nnro_devolucion']=$notadevolucioncliente->nnro_devolucion();
    $_SESSION['datos']['dfecha_devolucion']=$notadevolucioncliente->dfecha_devolucion();
    $_SESSION['datos']['nid_documentoventa']=$notadevolucioncliente->nid_documentoventa();
    $_SESSION['datos']['nnro_entrega']=$notadevolucioncliente->nnro_entrega();
    $_SESSION['datos']['dfecha_documento']=$notadevolucioncliente->dfecha_documento();
    $_SESSION['datos']['estatus']=$notadevolucioncliente->estatus();
    header("Location: ../vistas/menu_principal.php?notadevolucioncliente#notadevolucioncliente");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$nnro_devolucion.")";
    header("Location: ../vistas/menu_principal.php?notadevolucioncliente#notadevolucioncliente");
  }
}

if($operacion=="BuscarDatosNroEntrega"){
  echo $notadevolucioncliente->BuscarDatosNroEntrega($nnro_entrega);
  unset($notadevolucioncliente);
}
?>