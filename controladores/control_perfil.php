<?php
session_start();
if(isset($_POST['operacion']))
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_perfil']))
$nid_perfil=trim($_POST['nid_perfil']);

if(isset($_POST['nid_configuracion']))
$nid_configuracion=trim($_POST['nid_configuracion']);

if(isset($_POST['cnombreperfil']))
$cnombreperfil=trim($_POST['cnombreperfil']);

include_once("../clases/class_perfil.php");
$perfil=new Perfil();
if($operacion=='Registrar'){
  $perfil->nid_perfil($nid_perfil);
  $perfil->nid_configuracion($nid_configuracion);
  $perfil->cnombreperfil($cnombreperfil);
  if(!$perfil->Comprobar()){
    if($perfil->Registrar($_SESSION['user_name'])){
      $confirmacion=1;			                   			                   
      $perfil->ELIMINAR_OPCION_SERVICIO_PERFIL();
      if(isset($_POST['modulos'])){
        foreach($_POST['modulos'] as $indiceM => $valorM){
          if(isset($_POST['formularios'])){
            foreach ($_POST['formularios'] as $indiceF => $valorF) {
              if(isset($_POST['servicios'])){               
                foreach($_POST['servicios'] as $indiceS => $valorS){
                  $perfil->nid_servicio($valorS);                       
                  if(isset($_POST['opciones'])){                        
                    foreach(@$_POST['opciones'][$valorS] as $indiceO => $valorO){
                      $perfil->nid_opcion($valorO);                             
                      $perfil->INSERTAR_OPCION_SERVICIO_PERFIL($_SESSION['user_name']);
                    }                                 
                  }                                                        
                }
              }
            }
          }
        }        
      }
    }else
      $confirmacion=-1;
  }else{
    if($perfil->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
      if($perfil->Activar($_SESSION['user_name']))					  
        $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El perfil ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?perfiles");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar perfil.";
    header("Location: ../vistas/menu_principal.php?perfiles");
  }
}


if($operacion=='Modificar'){
  $perfil->nid_perfil($nid_perfil);
  $perfil->nid_configuracion($nid_configuracion);
  $perfil->cnombreperfil($cnombreperfil);
  if($perfil->Actualizar($_SESSION['user_name'])){
    $confirmacion=1;
    $perfil->ELIMINAR_OPCION_SERVICIO_PERFIL();
    if(isset($_POST['modulos'])){
      foreach($_POST['modulos'] as $indiceM => $valorM){
        if(isset($_POST['formularios'])){
          foreach ($_POST['formularios'] as $indiceF => $valorF) {
            if(isset($_POST['servicios'])){               
              foreach($_POST['servicios'] as $indiceS => $valorS){
                $perfil->nid_servicio($valorS);                       
                if(isset($_POST['opciones'])){                        
                  foreach(@$_POST['opciones'][$valorS] as $indiceO => $valorO){
                    $perfil->nid_opcion($valorO);                             
                    $perfil->INSERTAR_OPCION_SERVICIO_PERFIL($_SESSION['user_name']);
                  }                                 
                }                                                        
              }
            }
          }
        }
      }			   
    }
  }
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El perfil ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?perfiles");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el perfil.";
    header("Location: ../vistas/menu_principal.php?perfiles");
  }
}

if($operacion=='Desactivar'){
  $perfil->nid_perfil($nid_perfil);
  $perfil->cnombreperfil($cnombreperfil);
  if($perfil->Consultar()){
    if($perfil->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
    else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El perfil ha sido desactivado con exito";
    header("Location: ../vistas/menu_principal.php?perfiles");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el perfil.";
    header("Location: ../vistas/menu_principal.php?perfiles");
  }
}
		
if($operacion=='Activar'){
  $perfil->nid_perfil($nid_perfil);
  $perfil->cnombreperfil($cnombreperfil);
  if($perfil->Consultar()){
    if($perfil->Activar($_SESSION['user_name']))
    $confirmacion=1;
    else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El perfil ha sido activado con exito";
    header("Location: ../vistas/menu_principal.php?perfiles");
  }else{
    $_SESSION['datos']['mensaje']="Problema al activar el perfil.";
    header("Location: ../vistas/menu_principal.php?perfiles");
  }
}		
		
if($operacion=='Consultar'){	
  $perfil->nid_perfil($nid_perfil);
  $perfil->cnombreperfil($cnombreperfil);
  if($perfil->Consultar()){
    $_SESSION['datos']['nid_perfil']=$perfil->nid_perfil();
    $_SESSION['datos']['nid_configuracion']=$perfil->nid_configuracion();
    $_SESSION['datos']['cnombreperfil']=$perfil->cnombreperfil();
    $_SESSION['datos']['estatus']=$perfil->estatus_perfil();
    header("Location: ../vistas/menu_principal.php?perfiles");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cnombreperfil.")";
    header("Location: ../vistas/menu_principal.php?perfiles");
  }
}		  
?>