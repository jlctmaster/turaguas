<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_configuracion']))
$nid_configuracion=trim($_POST['nid_configuracion']);

if(isset($_POST['cdescripcion']))
$cdescripcion=trim($_POST['cdescripcion']);

if(isset($_POST['nlongitud_minclave']))
$nlongitud_minclave=trim($_POST['nlongitud_minclave']);

if(isset($_POST['nlongitud_maxclave']))
$nlongitud_maxclave=trim($_POST['nlongitud_maxclave']);

if(isset($_POST['ncantidad_letrasmayusculas']))
$ncantidad_letrasmayusculas=trim($_POST['ncantidad_letrasmayusculas']);

if(isset($_POST['ncantidad_letrasminusculas']))
$ncantidad_letrasminusculas=trim($_POST['ncantidad_letrasminusculas']);

if(isset($_POST['ncantidad_caracteresespeciales']))
$ncantidad_caracteresespeciales=trim($_POST['ncantidad_caracteresespeciales']);

if(isset($_POST['ncantidad_numeros']))
$ncantidad_numeros=trim($_POST['ncantidad_numeros']);

if(isset($_POST['ndias_vigenciaclave']))
$ndias_vigenciaclave=trim($_POST['ndias_vigenciaclave']);

if(isset($_POST['ndias_aviso']))
$ndias_aviso=trim($_POST['ndias_aviso']);

if(isset($_POST['nintentos_fallidos']))
$nintentos_fallidos=trim($_POST['nintentos_fallidos']);

if(isset($_POST['nnumero_preguntas']))
$nnumero_preguntas=trim($_POST['nnumero_preguntas']);

if(isset($_POST['nnumero_respuestasaresponder']))
$nnumero_respuestasaresponder=trim($_POST['nnumero_respuestasaresponder']);

include_once("../clases/class_configuracion.php");
$configuracion=new Configuracion();
if($operacion=='Registrar'){
  $configuracion->nid_configuracion($nid_configuracion);
  $configuracion->cdescripcion($cdescripcion);
  $configuracion->nlongitud_minclave($nlongitud_minclave);
  $configuracion->nlongitud_maxclave($nlongitud_maxclave);
  $configuracion->ncantidad_letrasmayusculas($ncantidad_letrasmayusculas);
  $configuracion->ncantidad_letrasminusculas($ncantidad_letrasminusculas);
  $configuracion->ncantidad_caracteresespeciales($ncantidad_caracteresespeciales);
  $configuracion->ncantidad_numeros($ncantidad_numeros);
  $configuracion->ndias_vigenciaclave($ndias_vigenciaclave);
  $configuracion->ndias_aviso($ndias_aviso);
  $configuracion->nintentos_fallidos($nintentos_fallidos);
  $configuracion->nnumero_preguntas($nnumero_preguntas);
  $configuracion->nnumero_respuestasaresponder($nnumero_respuestasaresponder);
  if(!$configuracion->Comprobar()){
    if($configuracion->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($configuracion->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
      if($configuracion->Activar($_SESSION['user_name']))            
        $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La configuración ha sido registrada con exito!";
    header("Location: ../vistas/menu_principal.php?configuracion");
  }else {
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la configuración.";
    header("Location: ../vistas/menu_principal.php?configuracion");
  }
}


if($operacion=='Modificar'){
  $configuracion->nid_configuracion($nid_configuracion);
  $configuracion->cdescripcion($cdescripcion);
  $configuracion->nlongitud_minclave($nlongitud_minclave);
  $configuracion->nlongitud_maxclave($nlongitud_maxclave);
  $configuracion->ncantidad_letrasmayusculas($ncantidad_letrasmayusculas);
  $configuracion->ncantidad_letrasminusculas($ncantidad_letrasminusculas);
  $configuracion->ncantidad_caracteresespeciales($ncantidad_caracteresespeciales);
  $configuracion->ncantidad_numeros($ncantidad_numeros);
  $configuracion->ndias_vigenciaclave($ndias_vigenciaclave);
  $configuracion->ndias_aviso($ndias_aviso);
  $configuracion->nintentos_fallidos($nintentos_fallidos);
  $configuracion->nnumero_preguntas($nnumero_preguntas);
  $configuracion->nnumero_respuestasaresponder($nnumero_respuestasaresponder);
  if($configuracion->Actualizar($_SESSION['user_name']))
   $confirmacion=1;
  else
   $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La configuración ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?configuracion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la configuración.";
    header("Location: ../vistas/menu_principal.php?configuracion");
  }
}

if($operacion=='Desactivar'){
  $configuracion->nid_configuracion($nid_configuracion);
  $configuracion->cdescripcion($cdescripcion);
  if($configuracion->Consultar()){
    if($configuracion->Desactivar($_SESSION['user_name']))
     $confirmacion=1;
    else
     $confirmacion=-1;
  }else{
     $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La configuración ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?configuracion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la configuración.";
    header("Location: ../vistas/menu_principal.php?configuracion");
  }
}


if($operacion=='Activar'){
  $configuracion->nid_configuracion($nid_configuracion);
  $configuracion->cdescripcion($cdescripcion);
  if($configuracion->Consultar()){
    if($configuracion->Activar($_SESSION['user_name']))
     $confirmacion=1;
    else
     $confirmacion=-1;
  }else{
     $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La configuración ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?configuracion");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la configuración.";
    header("Location: ../vistas/menu_principal.php?configuracion");
  }
}

if($operacion=='Consultar'){  
  $configuracion->nid_configuracion($nid_configuracion);
  $configuracion->cdescripcion($cdescripcion);
  if($configuracion->Consultar()){
    $_SESSION['datos']['nid_configuracion']=$configuracion->nid_configuracion();
    $_SESSION['datos']['cdescripcion']=$configuracion->cdescripcion();
    $_SESSION['datos']['nlongitud_minclave']=$configuracion->nlongitud_minclave();
    $_SESSION['datos']['nlongitud_maxclave']=$configuracion->nlongitud_maxclave();
    $_SESSION['datos']['ncantidad_letrasmayusculas']=$configuracion->ncantidad_letrasmayusculas();
    $_SESSION['datos']['ncantidad_letrasminusculas']=$configuracion->ncantidad_letrasminusculas();
    $_SESSION['datos']['ncantidad_caracteresespeciales']=$configuracion->ncantidad_caracteresespeciales();
    $_SESSION['datos']['ncantidad_numeros']=$configuracion->ncantidad_numeros();
    $_SESSION['datos']['ndias_vigenciaclave']=$configuracion->ndias_vigenciaclave();
    $_SESSION['datos']['ndias_aviso']=$configuracion->ndias_aviso();
    $_SESSION['datos']['nintentos_fallidos']=$configuracion->nintentos_fallidos();
    $_SESSION['datos']['nnumero_preguntas']=$configuracion->nnumero_preguntas();
    $_SESSION['datos']['nnumero_respuestasaresponder']=$configuracion->nnumero_respuestasaresponder();
    $_SESSION['datos']['estatus']=$configuracion->estatus_configuracion();
    header("Location: ../vistas/menu_principal.php?configuracion");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?configuracion");
  }                              
}     
?>