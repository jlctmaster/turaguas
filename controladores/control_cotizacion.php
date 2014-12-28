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

if(isset($_POST['dfecha_documento']))
$dfecha_documento=trim($_POST['dfecha_documento']);

if(isset($_POST['crif_persona']))
$crif_persona=trim($_POST['crif_persona']);

if(isset($_POST['nid_condicionpago']))
$nid_condicionpago=trim($_POST['nid_condicionpago']);

include_once("../clases/class_cotizacion.php");
$cotizacion=new Cotizacion();
if($operacion=='Registrar'){
  $cotizacion->nid_documentoventa($nid_documentoventa);
  $cotizacion->nid_tipodocumento($nid_tipodocumento);
  $cotizacion->nnro_cotizacion($nnro_cotizacion);
  $cotizacion->dfecha_documento($dfecha_documento);
  $cotizacion->crif_persona($crif_persona);
  $cotizacion->nid_condicionpago($nid_condicionpago);
     if(!$cotizacion->Comprobar()){
      if($cotizacion->Registrar($_SESSION['user_name'])){
        $confirmacion=1;
         if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad']) && isset($_POST['precio'])){
          for($i=0;$i<count($_POST['linea']);$i++){
            $cotizacion->nlinea($_POST['linea'][$i]);
            $cotizacion->cid_articulo($_POST['articulo'][$i]);
            $cotizacion->ncantidad_articulo($_POST['cantidad'][$i]);
            $cotizacion->nprecio($_POST['precio'][$i]);
            $cotizacion->InsertarDetalle($_SESSION['user_name']);
          }
        }
      }else
        $confirmacion=-1;
  }else{
    if($cotizacion->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($cotizacion->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $nnro_cotizacion=$cotizacion->BuscarNuevoRegistro();
    $_SESSION['datos']['mensaje']="La cotización ha sido registrada con exito, el número de cotización es ".$nnro_cotizacion;
    header("Location: ../vistas/menu_principal.php?cotizacion#cotizacion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la cotización.";
    header("Location: ../vistas/menu_principal.php?cotizacion#cotizacion");
  }
}
if($operacion=='Modificar'){
  $cotizacion->nid_documentoventa($nid_documentoventa);
  $cotizacion->nid_tipodocumento($nid_tipodocumento);
  $cotizacion->nnro_cotizacion($nnro_cotizacion);
  $cotizacion->dfecha_documento($dfecha_documento);
  $cotizacion->crif_persona($crif_persona);
  $cotizacion->nid_condicionpago($nid_condicionpago);
    if($cotizacion->Actualizar($_SESSION['user_name'])){
     $confirmacion=1;
       if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad']) && isset($_POST['precio'])){
        for($i=0;$i<count($_POST['linea']);$i++){
          $cotizacion->nid_documentoventa($nid_documentoventa);
          $cotizacion->nlinea($_POST['linea'][$i]);
          $cotizacion->cid_articulo($_POST['articulo'][$i]);
          $cotizacion->ncantidad_articulo($_POST['cantidad'][$i]);
          $cotizacion->ncantidad_articulo_viejo($_POST['cantidad_vieja'][$i]);
          $cotizacion->nprecio($_POST['precio'][$i]);
          $cotizacion->ActualizarDetalle($_SESSION['user_name']);
        }
      }
    }else
      $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La cotización ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?cotizacion#cotizacion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la cotización.";
    header("Location: ../vistas/menu_principal.php?cotizacion#cotizacion");
  }
}

if($operacion=='Desactivar'){
  $cotizacion->nid_documentoventa($nid_documentoventa);
  if($cotizacion->Consultar()){
    if($cotizacion->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La cotización ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?cotizacion#cotizacion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la cotización.";
    header("Location: ../vistas/menu_principal.php?cotizacion#cotizacion");
  }
}


if($operacion=='Activar'){
  $cotizacion->nid_documentoventa($nid_documentoventa);
  if($cotizacion->Consultar()){
    if($cotizacion->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La cotización ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?cotizacion#cotizacion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la cotización.";
    header("Location: ../vistas/menu_principal.php?cotizacion#cotizacion");
  }
}

if($operacion=='Consultar'){ 
  $cotizacion->nnro_cotizacion($nnro_cotizacion);
  if($cotizacion->Consultar()){
    $_SESSION['datos']['nid_documentoventa']=$cotizacion->nid_documentoventa();
    $_SESSION['datos']['nnro_cotizacion']=$cotizacion->nnro_cotizacion();
    $_SESSION['datos']['dfecha_documento']=$cotizacion->dfecha_documento();
    $_SESSION['datos']['crif_persona']=$cotizacion->crif_persona();
    $_SESSION['datos']['cnombrecliente']=$cotizacion->cnombre();
    $_SESSION['datos']['nid_condicionpago']=$cotizacion->nid_condicionpago();
    $_SESSION['datos']['estatus']=$cotizacion->estatus();
    header("Location: ../vistas/menu_principal.php?cotizacion#cotizacion");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$nnro_cotizacion.")";
    header("Location: ../vistas/menu_principal.php?cotizacion#cotizacion");
  }
}

if($operacion=="BuscarDatosCliente"){
  echo $cotizacion->BuscarDatosCliente($filtro);
  unset($cotizacion);
}
  
?>