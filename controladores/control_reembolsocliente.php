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

include_once("../clases/class_reembolsocliente.php");
$reembolsocliente=new ReembolsoCliente();
if($operacion=='Registrar'){
  $reembolsocliente->nid_reembolso($nid_reembolso);
  $reembolsocliente->nid_tipodocumento($nid_tipodocumento);
  $reembolsocliente->nnro_reembolso($nnro_reembolso);
  $reembolsocliente->dfecha_documento($dfecha_documento);
  $reembolsocliente->nid_devolucion($nid_devolucion);
  $reembolsocliente->crif_persona($crif_persona);
     if(!$reembolsocliente->Comprobar()){
      if($reembolsocliente->Registrar($_SESSION['user_name'])){
         if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad'])){
          for($i=0;$i<count($_POST['linea']);$i++){
            $reembolsocliente->nlinea($_POST['linea'][$i]);
            $reembolsocliente->cid_articulo($_POST['articulo'][$i]);
            $reembolsocliente->ncantidad_articulo($_POST['cantidad'][$i]);
            $reembolsocliente->InsertarDetalle($_SESSION['user_name']);
          }
        }
        $reembolsocliente->CrearMovimiento($_SESSION['user_name']);
        $confirmacion=1;
      }else
        $confirmacion=-1;
  }else{
    if($reembolsocliente->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($reembolsocliente->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $nnro_reembolso=$reembolsocliente->BuscarNuevoRegistro();
    $_SESSION['datos']['mensaje']="La nota del reembolso ha sido registrada con exito, el número de la nota es ".$nnro_reembolso;
    header("Location: ../vistas/menu_principal.php?reembolsocliente#reembolsocliente");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la nota del reembolso.";
    header("Location: ../vistas/menu_principal.php?reembolsocliente#reembolsocliente");
  }
}
if($operacion=='Modificar'){
  $reembolsocliente->nid_reembolso($nid_reembolso);
  $reembolsocliente->nid_tipodocumento($nid_tipodocumento);
  $reembolsocliente->nnro_reembolso($nnro_reembolso);
  $reembolsocliente->dfecha_documento($dfecha_documento);
  $reembolsocliente->nid_devolucion($numero_solicitud);
  $reembolsocliente->crif_persona($crif_persona);
    if($reembolsocliente->Actualizar($_SESSION['user_name'])){
       if(isset($_POST['linea']) && isset($_POST['articulo']) && isset($_POST['cantidad'])){
        for($i=0;$i<count($_POST['linea']);$i++){
          $reembolsocliente->nid_reembolso($nid_reembolso);
          $reembolsocliente->nlinea($_POST['linea'][$i]);
          $reembolsocliente->cid_articulo($_POST['articulo'][$i]);
          $reembolsocliente->ncantidad_articulo($_POST['cantidad'][$i]);
          $reembolsocliente->ncantidad_articulo_viejo($_POST['cantidad_vieja'][$i]);
          $reembolsocliente->ActualizarDetalle($_SESSION['user_name']);
        }
      }
      $reembolsocliente->ModificarMovimiento($_SESSION['user_name']);
      $confirmacion=1;
    }else
      $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota del reembolso ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?reembolsocliente#reembolsocliente");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la nota del reembolso.";
    header("Location: ../vistas/menu_principal.php?reembolsocliente#reembolsocliente");
  }
}

if($operacion=='Desactivar'){
  $reembolsocliente->nid_reembolso($nid_reembolso);
  if($reembolsocliente->Consultar()){
    if($reembolsocliente->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota del reembolso ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?reembolsocliente#reembolsocliente");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la nota del reembolso.";
    header("Location: ../vistas/menu_principal.php?reembolsocliente#reembolsocliente");
  }
}


if($operacion=='Activar'){
  $reembolsocliente->nid_reembolso($nid_reembolso);
  if($reembolsocliente->Consultar()){
    if($reembolsocliente->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La nota del reembolso ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?reembolsocliente#reembolsocliente");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la nota del reembolso.";
    header("Location: ../vistas/menu_principal.php?reembolsocliente#reembolsocliente");
  }
}

if($operacion=='Consultar'){ 
  $reembolsocliente->nnro_reembolso($nnro_reembolso);
  if($reembolsocliente->Consultar()){
    $_SESSION['datos']['nid_reembolso']=$reembolsocliente->nid_reembolso();
    $_SESSION['datos']['nnro_reembolso']=$reembolsocliente->nnro_reembolso();
    $_SESSION['datos']['dfecha_documento']=$reembolsocliente->dfecha_documento();
    $_SESSION['datos']['nid_devolucion']=$reembolsocliente->nid_devolucion();
    $_SESSION['datos']['nnro_devolucion']=$reembolsocliente->nnro_devolucion();
    $_SESSION['datos']['dfecha_devolucion']=$reembolsocliente->dfecha_devolucion();
    $_SESSION['datos']['crif_persona']=$reembolsocliente->crif_persona();
    $_SESSION['datos']['cnombrecliente']=$reembolsocliente->cnombre();
    $_SESSION['datos']['estatus']=$reembolsocliente->estatus();
    header("Location: ../vistas/menu_principal.php?reembolsocliente#reembolsocliente");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$nnro_reembolso.")";
    header("Location: ../vistas/menu_principal.php?reembolsocliente#reembolsocliente");
  }
}

if($operacion=="BuscarDatosNroDevolucion"){
  echo $reembolsocliente->BuscarDatosNroDevolucion($filtro);
  unset($reembolsocliente);
}

?>