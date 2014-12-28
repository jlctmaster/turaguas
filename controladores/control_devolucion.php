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

if(isset($_POST['estatus']))
//Asignar valor a variable de filtro
  $estatus=$_POST['estatus'];

if(isset($_POST['nid_devolucion']))
  $nid_devolucion=trim($_POST['nid_devolucion']);

if(isset($_POST['nnro_devolucion']))
  $nnro_devolucion=trim($_POST['nnro_devolucion']);

if(isset($_POST['nid_tipodocumento']))
  $nid_tipodocumento=trim($_POST['nid_tipodocumento']);

if(isset($_POST['nid_documento']))
  $nid_documento=trim($_POST['nid_documento']);

if(isset($_POST['dfecha_devolucion']))
  $dfecha_devolucion=trim($_POST['dfecha_devolucion']);

if(isset($_POST['cestado_devolucion']))
  $cestado_devolucion=trim($_POST['cestado_devolucion']);

if(isset($_POST['caccion_devolucion']))
  $caccion_devolucion=trim($_POST['caccion_devolucion']);

include_once("../clases/class_devolucion.php");
$devolucion=new Devolucion();
if($operacion=='Registrar'){
  $devolucion->nid_devolucion($nid_devolucion);
  $devolucion->nid_documento($nid_documento);
  $devolucion->nnro_devolucion($nnro_devolucion);
  $devolucion->nid_tipodocumento($nid_tipodocumento);
  $devolucion->dfecha_devolucion($dfecha_devolucion);
  $devolucion->cestado_devolucion($cestado_devolucion);
  $devolucion->caccion_devolucion($caccion_devolucion);
  if(!$devolucion->Comprobar()){
    if($devolucion->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($devolucion->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($devolucion->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La devolución ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#devolucionc");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la devolución cliente";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#devolucionc");
  }
}

if($operacion=='Modificar'){
  $devolucion->nid_devolucion($nid_devolucion);
  $devolucion->nid_documento($nid_documento);
  $devolucion->nnro_devolucion($nnro_devolucion);
  $devolucion->nid_tipodocumento($nid_tipodocumento);
  $devolucion->dfecha_devolucion($dfecha_devolucion);
  $devolucion->cestado_devolucion($cestado_devolucion);
  $devolucion->caccion_devolucion($caccion_devolucion);
  if($devolucion->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La devolución ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#devolucionc");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la devolución.";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#devolucionc");
  }
}

if($operacion=='Desactivar'){
  $devolucion->nid_devolucion($nid_devolucion);
  $devolucion->nnro_devolucion($nnro_devolucion);
  if($devolucion->Consultar()){
    if($devolucion->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La devolución ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#devolucionc");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la devolución.";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#devolucionc");
  }
}

if($operacion=='Activar'){
  $devolucion->nid_devolucion($nid_devolucion);
  $devolucion->nnro_devolucion($nnro_devolucion);
  if($devolucion->Consultar()){
    if($devolucion->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="el documento ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#devolucionc");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el documento.";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#devolucionc");
  }
}

if($operacion=='Consultar'){	
  $devolucion->nid_devolucion($nid_devolucion);
  $devolucion->nnro_devolucion($nnro_devolucion);
  if($devolucion->Consultar()){
    $_SESSION['datos']['nid_devolucion']=$devolucion->nid_devolucion();
    $_SESSION['datos']['nid_documento']=$devolucion->nid_documento();
    $_SESSION['datos']['nnro_devolucion']=$devolucion->nnro_devolucion();
    $_SESSION['datos']['nid_tipodocumento']=$devolucion->nid_tipodocumento();
    $_SESSION['datos']['dfecha_devolucion']=$devolucion->dfecha_devolucion();
    $_SESSION['datos']['cestado_devolucion']=$devolucion->cestado_devolucion();
    $_SESSION['datos']['caccion_devolucion']=$devolucion->caccion_devolucion();
    $_SESSION['datos']['estatus']=$devolucion->estatus_devolucion();
    header("Location: ../vistas/menu_principal.php?devolucioncliente#devolucionc");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$nnro_devolucion.")";
    header("Location: ../vistas/menu_principal.php?devolucioncliente#devolucionc");
  }
}

if($operacion=="CambiarEstatus"){
  echo $devolucion->CambiarEstatus($estatus,$nid_devolucion,$_SESSION['user_name']);
  unset($devolucion);
}

if($operacion=="BuscarEstatus"){
  echo $devolucion->BuscarEstatus($nid_devolucion);
  unset($devolucion);
}
?>