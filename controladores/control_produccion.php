<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_produccion']))
$nid_produccion=trim($_POST['nid_produccion']);

if(isset($_POST['nid_tipodocumento']))
$nid_tipodocumento=trim($_POST['nid_tipodocumento']);

if(isset($_POST['nnro_produccion']))
$nnro_produccion=trim($_POST['nnro_produccion']);

if(isset($_POST['dfecha_documento']))
$dfecha_documento=trim($_POST['dfecha_documento']);

if(isset($_POST['cid_articulo']))
$cid_articulo=trim($_POST['cid_articulo']);

if(isset($_POST['ncantidad_a_producir']))
$ncantidad=trim($_POST['ncantidad_a_producir']);

include_once("../clases/class_produccion.php");
$produccion=new Produccion();
if($operacion=='Registrar'){
  $produccion->nid_produccion($nid_produccion);
  $produccion->nid_tipodocumento($nid_tipodocumento);
  $produccion->nnro_produccion($nnro_produccion);
  $produccion->dfecha_documento($dfecha_documento);
  $produccion->cid_articulo($cid_articulo);
  $produccion->ncantidad($ncantidad);
     if(!$produccion->Comprobar()){
      if($produccion->Registrar($_SESSION['user_name'])){
         if(isset($_POST['linea']) && isset($_POST['insumo']) && isset($_POST['cantidad']) && isset($_POST['total'])){
          for($i=0;$i<count($_POST['linea']);$i++){
            $produccion->nlinea($_POST['linea'][$i]);
            $produccion->cid_insumo($_POST['insumo'][$i]);
            $produccion->ncantidad_a_usar($_POST['cantidad'][$i]);
            $produccion->ntotal_a_usar($_POST['total'][$i]);
            $produccion->InsertarDetalle($_SESSION['user_name']);
          }
        }
        $produccion->CrearSalida($_SESSION['user_name']);
        $produccion->CrearEntrada($_SESSION['user_name']);
        $confirmacion=1;
      }else
        $confirmacion=-1;
  }else{
    if($produccion->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($produccion->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $nnro_produccion=$produccion->BuscarNuevoRegistro();
    $_SESSION['datos']['mensaje']="La producción ha sido registrada con exito, el número de producción es ".$nnro_produccion;
    header("Location: ../vistas/menu_principal.php?produccion#produccion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la producción.";
    header("Location: ../vistas/menu_principal.php?produccion#produccion");
  }
}
if($operacion=='Modificar'){
  $produccion->nid_produccion($nid_produccion);
  $produccion->nid_tipodocumento($nid_tipodocumento);
  $produccion->nnro_produccion($nnro_produccion);
  $produccion->dfecha_documento($dfecha_documento);
  $produccion->cid_articulo($cid_articulo);
  $produccion->ncantidad($ncantidad);
    if($produccion->Actualizar($_SESSION['user_name'])){
       if(isset($_POST['linea']) && isset($_POST['insumo']) && isset($_POST['cantidad']) && isset($_POST['total'])){
        for($i=0;$i<count($_POST['linea']);$i++){
          $produccion->nid_produccion($nid_produccion);
          $produccion->nlinea($_POST['linea'][$i]);
          $produccion->cid_insumo($_POST['insumo'][$i]);
          $produccion->ncantidad_a_usar($_POST['cantidad'][$i]);
          $produccion->ntotal_a_usar($_POST['total'][$i]);
          $produccion->ActualizarDetalle($_SESSION['user_name']);
        }
      }
      $produccion->ModificarSalida($_SESSION['user_name']);
      $produccion->ModificarEntrada($_SESSION['user_name']);
      $confirmacion=1;
    }else
      $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La producción ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?produccion#produccion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la producción.";
    header("Location: ../vistas/menu_principal.php?produccion#produccion");
  }
}

if($operacion=='Desactivar'){
  $produccion->nid_produccion($nid_produccion);
  if($produccion->Consultar()){
    if($produccion->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La producción ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?produccion#produccion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la producción.";
    header("Location: ../vistas/menu_principal.php?produccion#produccion");
  }
}


if($operacion=='Activar'){
  $produccion->nid_produccion($nid_produccion);
  if($produccion->Consultar()){
    if($produccion->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La producción ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?produccion#produccion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la producción.";
    header("Location: ../vistas/menu_principal.php?produccion#produccion");
  }
}

if($operacion=='Consultar'){ 
  $produccion->nnro_produccion($nnro_produccion);
  if($produccion->Consultar()){
    $_SESSION['datos']['nid_produccion']=$produccion->nid_produccion();
    $_SESSION['datos']['nnro_produccion']=$produccion->nnro_produccion();
    $_SESSION['datos']['dfecha_documento']=$produccion->dfecha_documento();
    $_SESSION['datos']['cid_articulo']=$produccion->cid_articulo();
    $_SESSION['datos']['ncantidad_a_producir']=$produccion->ncantidad();
    $_SESSION['datos']['estatus']=$produccion->estatus();
    header("Location: ../vistas/menu_principal.php?produccion#produccion");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$nnro_produccion.")";
    header("Location: ../vistas/menu_principal.php?produccion#produccion");
  }
}

if($operacion=="BuscarConfiguracion"){
  echo $produccion->BuscarConfiguracion($cid_articulo);
  unset($produccion);
}

if($operacion=="BuscarConfiguracionPorDisponibilidad"){
  echo $produccion->BuscarConfiguracionPorDisponibilidad($cid_articulo,$ncantidad);
  unset($produccion);
}
  
?>