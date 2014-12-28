<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construnid_listaprecio.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_listaprecio']))
  $nid_listaprecio=trim($_POST['nid_listaprecio']);

if(isset($_POST['cdescripcionlistaprecio']))
  $cdescripcion=trim($_POST['cdescripcionlistaprecio']);

if(isset($_POST['dvigencia_desde']))
  $dvigencia_desde=$_POST['dvigencia_desde'];

if(isset($_POST['dvigencia_hasta']))
  $dvigencia_hasta=$_POST['dvigencia_hasta'];

include_once("../clases/class_listaprecio.php");
$listaprecio=new Listaprecio();
if($operacion=='Registrar'){
  $listaprecio->nid_listaprecio($nid_listaprecio);
  $listaprecio->cdescripcionlistaprecio($cdescripcionlistaprecio);
  $listaprecio->dvigencia_desde($dvigencia_desde);
  $listaprecio->dvigencia_hasta($dvigencia_hasta);
  if(!$listaprecio->Comprobar()){
    if($listaprecio->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($listaprecio->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($listaprecio->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La lista de precio ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?lista_precio#listaprecio");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la lista de precio.";
    header("Location: ../vistas/menu_principal.php?lista_precio#listaprecio");
  }
}

if($operacion=='Modificar'){
  $listaprecio->nid_listaprecio($nid_listaprecio);
  $listaprecio->cdescripcionlistaprecio($cdescripcionlistaprecio);
  $listaprecio->dvigencia_desde($dvigencia_desde);
  $listaprecio->dvigencia_hasta($dvigencia_hasta);
  if($listaprecio->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La lista de precio ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?lista_precio#listaprecio");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la lista de precio.";
    header("Location: ../vistas/menu_principal.php?lista_precio#listaprecio");
  }
}

if($operacion=='Desactivar'){
  $listaprecio->nid_listaprecio($nid_listaprecio);
  $listaprecio->cdescripcionlistaprecio($cdescripcionlistaprecio);
  $listaprecio->dvigencia_desde($dvigencia_desde);
  $listaprecio->dvigencia_hasta($dvigencia_hasta);
  if($listaprecio->Consultar()){
    if($listaprecio->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La lista de precio ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?lista_precio#listaprecio");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la lista de precio.";
    header("Location: ../vistas/menu_principal.php?lista_precio#listaprecio");
  }
}

if($operacion=='Activar'){
  $listaprecio->nid_listaprecio($nid_listaprecio);
  $listaprecio->cdescripcionlistaprecio($cdescripcionlistaprecio);
  $listaprecio->dvigencia_desde($dvigencia_desde);
  $listaprecio->dvigencia_hasta($dvigencia_hasta);
  if($listaprecio->Consultar()){
    if($listaprecio->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La lista de precio ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?lista_precio#listaprecio");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la lista de precio.";
    header("Location: ../vistas/menu_principal.php?lista_precio#listaprecio");
  }
}

if($operacion=='Consultar'){	
  $listaprecio->nid_listaprecio($nid_listaprecio);
  $listaprecio->cdescripcionlistaprecio($cdescripcionlistaprecio);
  $listaprecio->dvigencia_desde($dvigencia_desde);
  $listaprecio->dvigencia_hasta($dvigencia_hasta);
  if($listaprecio->Consultar()){
    $_SESSION['datos']['nid_listaprecio']=$listaprecio->nid_listaprecio();
    $_SESSION['datos']['cdescripcionlistaprecio']=$listaprecio->cdescripcionlistaprecio();
    $_SESSION['datos']['dvigencia_desde']=$listaprecio->dvigencia_desde();
    $_SESSION['datos']['dvigencia_hasta']=$listaprecio->dvigencia_hasta();
    $_SESSION['datos']['estatuslistaprecio']=$listaprecio->estatuslistaprecio();
    header("Location: ../vistas/menu_principal.php?lista_precio#listaprecio");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcionlistaprecio.")";
    header("Location: ../vistas/menu_principal.php?lista_precio#listaprecio");
  }
}		  
?>