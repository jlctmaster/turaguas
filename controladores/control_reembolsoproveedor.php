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

if(isset($_POST['nid_reembolso']))
$nid_reembolso=trim($_POST['nid_reembolso']);

if(isset($_POST['nid_tipodocumento']))
$nid_tipodocumento=trim($_POST['nid_tipodocumento']);

if(isset($_POST['nnro_reembolso']))
$nnro_reembolso=trim($_POST['nnro_reembolso']);

if(isset($_POST['dfecha_documento']))
$dfecha_documento=trim($_POST['dfecha_documento']);

if(isset($_POST['nid_devolucion']))
$nid_devolucion=trim($_POST['nid_devolucion']);

if(isset($_POST['crif_persona']))
$crif_persona=trim($_POST['crif_persona']);

include_once("../clases/class_reembolsoproveedor.php");
$reembolsoproveedor=new ReembolsoProveedor();
if($operacion=='Registrar'){
  $reembolsoproveedor->nid_reembolso($nid_reembolso);
  $reembolsoproveedor->nid_tipodocumento($nid_tipodocumento);
  $reembolsoproveedor->nnro_reembolso($nnro_reembolso);
  $reembolsoproveedor->dfecha_documento($dfecha_documento);
  $reembolsoproveedor->nid_devolucion($nid_devolucion);
  $reembolsoproveedor->crif_persona($crif_persona);
     if(!$reembolsoproveedor->Comprobar()){
      if($reembolsoproveedor->Registrar($_SESSION['user_name'])){
         if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad'])){
          for($i=0;$i<count($_POST['linea']);$i++){
            $reembolsoproveedor->nlinea($_POST['linea'][$i]);
            $reembolsoproveedor->cid_articulo($_POST['articulo'][$i]);
            $reembolsoproveedor->ncantidad_articulo($_POST['cantidad'][$i]);
            $reembolsoproveedor->InsertarDetalle($_SESSION['user_name']);
          }
        }
        $reembolsoproveedor->CrearMovimiento($_SESSION['user_name']);
        $confirmacion=1;
      }else
        $confirmacion=-1;
  }else{
    if($reembolsoproveedor->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($reembolsoproveedor->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $nnro_reembolso=$reembolsoproveedor->BuscarNuevoRegistro();
    $_SESSION['datos']['mensaje']="La nota del reembolso ha sido registrada con exito, el número de la nota es ".$nnro_reembolso;
    header("Location: ../vistas/menu_principal.php?reembolsoproveedor#reembolsoproveedor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la nota del reembolso.";
    header("Location: ../vistas/menu_principal.php?reembolsoproveedor#reembolsoproveedor");
  }
}
if($operacion=='Modificar'){
  $reembolsoproveedor->nid_reembolso($nid_reembolso);
  $reembolsoproveedor->nid_tipodocumento($nid_tipodocumento);
  $reembolsoproveedor->nnro_reembolso($nnro_reembolso);
  $reembolsoproveedor->dfecha_documento($dfecha_documento);
  $reembolsoproveedor->nid_devolucion($numero_solicitud);
  $reembolsoproveedor->crif_persona($crif_persona);
    if($reembolsoproveedor->Actualizar($_SESSION['user_name'])){
       if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad'])){
        for($i=0;$i<count($_POST['linea']);$i++){
          $reembolsoproveedor->nid_reembolso($nid_reembolso);
          $reembolsoproveedor->nlinea($_POST['linea'][$i]);
          $reembolsoproveedor->cid_articulo($_POST['articulo'][$i]);
          $reembolsoproveedor->ncantidad_articulo($_POST['cantidad'][$i]);
          $reembolsoproveedor->ncantidad_articulo_viejo($_POST['cantidad_vieja'][$i]);
          $reembolsoproveedor->ActualizarDetalle($_SESSION['user_name']);
        }
      }
      $reembolsoproveedor->ModificarMovimiento($_SESSION['user_name']);
      $confirmacion=1;
    }else
      $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota del reembolso ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?reembolsoproveedor#reembolsoproveedor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la nota del reembolso.";
    header("Location: ../vistas/menu_principal.php?reembolsoproveedor#reembolsoproveedor");
  }
}

if($operacion=='Desactivar'){
  $reembolsoproveedor->nid_reembolso($nid_reembolso);
  if($reembolsoproveedor->Consultar()){
    if($reembolsoproveedor->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota del reembolso ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?reembolsoproveedor#reembolsoproveedor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la nota del reembolso.";
    header("Location: ../vistas/menu_principal.php?reembolsoproveedor#reembolsoproveedor");
  }
}


if($operacion=='Activar'){
  $reembolsoproveedor->nid_reembolso($nid_reembolso);
  if($reembolsoproveedor->Consultar()){
    if($reembolsoproveedor->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota del reembolso ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?reembolsoproveedor#reembolsoproveedor");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la nota del reembolso.";
    header("Location: ../vistas/menu_principal.php?reembolsoproveedor#reembolsoproveedor");
  }
}

if($operacion=='Consultar'){ 
  $reembolsoproveedor->nnro_reembolso($nnro_reembolso);
  if($reembolsoproveedor->Consultar()){
    $_SESSION['datos']['nid_reembolso']=$reembolsoproveedor->nid_reembolso();
    $_SESSION['datos']['nnro_reembolso']=$reembolsoproveedor->nnro_reembolso();
    $_SESSION['datos']['dfecha_documento']=$reembolsoproveedor->dfecha_documento();
    $_SESSION['datos']['nid_devolucion']=$reembolsoproveedor->nid_devolucion();
    $_SESSION['datos']['nnro_devolucion']=$reembolsoproveedor->nnro_devolucion();
    $_SESSION['datos']['dfecha_devolucion']=$reembolsoproveedor->dfecha_devolucion();
    $_SESSION['datos']['crif_persona']=$reembolsoproveedor->crif_persona();
    $_SESSION['datos']['cnombreproveedor']=$reembolsoproveedor->cnombre();
    $_SESSION['datos']['estatus']=$reembolsoproveedor->estatus();
    header("Location: ../vistas/menu_principal.php?reembolsoproveedor#reembolsoproveedor");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$nnro_reembolso.")";
    header("Location: ../vistas/menu_principal.php?reembolsoproveedor#reembolsoproveedor");
  }
}

if($operacion=="BuscarDatosNroDevolucion"){
  echo $reembolsoproveedor->BuscarDatosNroDevolucion($filtro);
  unset($reembolsoproveedor);
}

?>