<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_documentocompra']))
$nid_documentocompra=trim($_POST['nid_documentocompra']);

if(isset($_POST['nid_tipodocumento']))
$nid_tipodocumento=trim($_POST['nid_tipodocumento']);

if(isset($_POST['nnro_solicitud']))
$nnro_solicitud=trim($_POST['nnro_solicitud']);

if(isset($_POST['dfecha_documento']))
$dfecha_documento=trim($_POST['dfecha_documento']);

include_once("../clases/class_solicitudcompra.php");
$solicitudcompra=new SolicitudCompra();
if($operacion=='Registrar'){
  $solicitudcompra->nid_documentocompra($nid_documentocompra);
  $solicitudcompra->nid_tipodocumento($nid_tipodocumento);
  $solicitudcompra->nnro_solicitud($nnro_solicitud);
  $solicitudcompra->dfecha_documento($dfecha_documento);
     if(!$solicitudcompra->Comprobar()){
      if($solicitudcompra->Registrar($_SESSION['user_name'])){
        $confirmacion=1;
         if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad'])){
          for($i=0;$i<count($_POST['linea']);$i++){
            $solicitudcompra->nlinea($_POST['linea'][$i]);
            $solicitudcompra->cid_articulo($_POST['articulo'][$i]);
            $solicitudcompra->ncantidad_articulo($_POST['cantidad'][$i]);
            $solicitudcompra->InsertarDetalle($_SESSION['user_name']);
          }
        }
      }else
        $confirmacion=-1;
  }else{
    if($solicitudcompra->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($solicitudcompra->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $nnro_solicitud=$solicitudcompra->BuscarNuevoRegistro();
    $_SESSION['datos']['mensaje']="La solicitud de compra ha sido registrada con exito, el número de solicitud es ".$nnro_solicitud;
    header("Location: ../vistas/menu_principal.php?solicitudcompra#solicitudcompra");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la solicitud de compra.";
    header("Location: ../vistas/menu_principal.php?solicitudcompra#solicitudcompra");
  }
}
if($operacion=='Modificar'){
  $solicitudcompra->nid_documentocompra($nid_documentocompra);
  $solicitudcompra->nid_tipodocumento($nid_tipodocumento);
  $solicitudcompra->nnro_solicitud($nnro_solicitud);
  $solicitudcompra->dfecha_documento($dfecha_documento);
    if($solicitudcompra->Actualizar($_SESSION['user_name'])){
     $confirmacion=1;
       if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad'])){
        for($i=0;$i<count($_POST['linea']);$i++){
          $solicitudcompra->nid_documentocompra($nid_documentocompra);
          $solicitudcompra->nlinea($_POST['linea'][$i]);
          $solicitudcompra->cid_articulo($_POST['articulo'][$i]);
          $solicitudcompra->ncantidad_articulo($_POST['cantidad'][$i]);
          $solicitudcompra->ncantidad_articulo_viejo($_POST['cantidad_vieja'][$i]);
          $solicitudcompra->ActualizarDetalle($_SESSION['user_name']);
        }
      }
    }else
      $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La solicitud de compra ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?solicitudcompra#solicitudcompra");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la solicitud de compra.";
    header("Location: ../vistas/menu_principal.php?solicitudcompra#solicitudcompra");
  }
}

if($operacion=='Desactivar'){
  $solicitudcompra->nid_documentocompra($nid_documentocompra);
  if($solicitudcompra->Consultar()){
    if($solicitudcompra->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La solicitud de compra ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?solicitudcompra#solicitudcompra");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la solicitud de compra.";
    header("Location: ../vistas/menu_principal.php?solicitudcompra#solicitudcompra");
  }
}


if($operacion=='Activar'){
  $solicitudcompra->nid_documentocompra($nid_documentocompra);
  if($solicitudcompra->Consultar()){
    if($solicitudcompra->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La solicitud de compra ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?solicitudcompra#solicitudcompra");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la solicitud de compra.";
    header("Location: ../vistas/menu_principal.php?solicitudcompra#solicitudcompra");
  }
}

if($operacion=='Consultar'){ 
  $solicitudcompra->nnro_solicitud($nnro_solicitud);
  if($solicitudcompra->Consultar()){
    $_SESSION['datos']['nid_documentocompra']=$solicitudcompra->nid_documentocompra();
    $_SESSION['datos']['nnro_solicitud']=$solicitudcompra->nnro_solicitud();
    $_SESSION['datos']['dfecha_documento']=$solicitudcompra->dfecha_documento();
    $_SESSION['datos']['estatus']=$solicitudcompra->estatus();
    header("Location: ../vistas/menu_principal.php?solicitudcompra#solicitudcompra");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$nnro_solicitud.")";
    header("Location: ../vistas/menu_principal.php?solicitudcompra#solicitudcompra");
  }
}
  
?>