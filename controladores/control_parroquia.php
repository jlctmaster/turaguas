<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_parroquia']))
$nid_localidad=trim($_POST['nid_parroquia']);

if(isset($_POST['ctabla_parroquia']))
$ctabla=trim($_POST['ctabla_parroquia']);

if(isset($_POST['cnombreparroquia']))
$cdescripcion=trim($_POST['cnombreparroquia']);

if(isset($_POST['nid_municipio']))
$nid_localidad_padre=trim($_POST['nid_municipio']);


include_once("../clases/class_parroquia.php");
$parroquia=new parroquia();
if($operacion=='Registrar'){
  $parroquia->nid_localidad($nid_localidad);
  $parroquia->ctabla($ctabla);
  $parroquia->cdescripcion($cdescripcion);
  $parroquia->nid_localidad_padre($nid_localidad_padre);
  if(!$parroquia->Comprobar()){
    if($parroquia->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($parroquia->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
      if($parroquia->Activar($_SESSION['user_name']))            
        $confirmacion=1;
    }
  }

  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La parroquia ha sido registrada con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#parroquia");
   }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la parroquia.";
    header("Location: ../vistas/menu_principal.php?localidad#parroquia");
  }
}

if($operacion=='Modificar'){
  $parroquia->nid_localidad($nid_localidad);
  $parroquia->ctabla($ctabla);
  $parroquia->cdescripcion($cdescripcion);
  $parroquia->nid_localidad_padre($nid_localidad_padre);
    if($parroquia->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La parroquia ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#parroquia");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la parroquia.";
    header("Location: ../vistas/menu_principal.php?localidad#parroquia");
  }
}

if($operacion=='Desactivar'){
  $parroquia->nid_localidad($nid_localidad);
  $parroquia->ctabla($ctabla);
  $parroquia->cdescripcion($cdescripcion);
  $parroquia->nid_localidad_padre($nid_localidad_padre);
  if($parroquia->Consultar()){
    if($parroquia->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La parroquia ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#parroquia");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la parroquia.";
    header("Location: ../vistas/menu_principal.php?localidad#parroquia");
  }
}


if($operacion=='Activar'){
  $parroquia->nid_localidad($id);
  $parroquia->ctabla($ctabla);
  $parroquia->cdescripcion($cdescripcion);
  $parroquia->nid_localidad_padre($nid_localidad_padre);
  if($parroquia->Consultar()){
    if($parroquia->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La parroquia ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#parroquia");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la parroquia.";
    header("Location: ../vistas/menu_principal.php?localidad#parroquia");
  }
}

if($operacion=='Consultar'){ 
  $parroquia->nid_localidad($nid_localidad);
  $parroquia->ctabla($ctabla);
  $parroquia->cdescripcion($cdescripcion);
  if($parroquia->Consultar()){
    $_SESSION['datos']['nid_parroquia']=$parroquia->nid_localidad();
    $_SESSION['datos']['cnombremunicipio']=$parroquia->cnombremunicipio();
    $_SESSION['datos']['cnombreparroquia']=$parroquia->cdescripcion();
    $_SESSION['datos']['nid_municipio']=$parroquia->nid_localidad_padre();
    $_SESSION['datos']['estatus_parroquia']=$parroquia->estatus_parroquia();
    header("Location: ../vistas/menu_principal.php?localidad#parroquia");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?localidad#parroquia");
  }
}    
?>