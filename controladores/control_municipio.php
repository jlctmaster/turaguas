<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_municipio']))
$nid_localidad=trim($_POST['nid_municipio']);

if(isset($_POST['ctabla_municipio']))
$ctabla=trim($_POST['ctabla_municipio']);

if(isset($_POST['cnombremunicipio']))
$cdescripcion=trim($_POST['cnombremunicipio']);

if(isset($_POST['nid_ciudad']))
$nid_localidad_padre=trim($_POST['nid_ciudad']);


include_once("../clases/class_municipio.php");
$municipio=new municipio();
if($operacion=='Registrar'){
  $municipio->nid_localidad($nid_localidad);
  $municipio->ctabla($ctabla);
  $municipio->cdescripcion($cdescripcion);
  $municipio->nid_localidad_padre($nid_localidad_padre);
  if(!$municipio->Comprobar()){
    if($municipio->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($municipio->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
      if($municipio->Activar($_SESSION['user_name']))            
        $confirmacion=1;
    }
  }

  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El municipio ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#municipio");
   }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar municipio.";
    header("Location: ../vistas/menu_principal.php?localidad#municipio");
  }
}

if($operacion=='Modificar'){
  $municipio->nid_localidad($nid_localidad);
  $municipio->ctabla($ctabla);
  $municipio->cdescripcion($cdescripcion);
  $municipio->nid_localidad_padre($nid_localidad_padre);
    if($municipio->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El municipio ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#municipio");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el municipio.";
    header("Location: ../vistas/menu_principal.php?localidad#municipio");
  }
}

if($operacion=='Desactivar'){
  $municipio->nid_localidad($nid_localidad);
  $municipio->ctabla($ctabla);
  $municipio->cdescripcion($cdescripcion);
  $municipio->nid_localidad_padre($nid_localidad_padre);
  if($municipio->Consultar()){
    if($municipio->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El municipio ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#municipio");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el municipio.";
    header("Location: ../vistas/menu_principal.php?localidad#municipio");
  }
}


if($operacion=='Activar'){
  $municipio->nid_localidad($id);
  $municipio->ctabla($ctabla);
  $municipio->cdescripcion($cdescripcion);
  $municipio->nid_localidad_padre($nid_localidad_padre);
  if($municipio->Consultar()){
    if($municipio->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El municipio ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#municipio");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el municipio.";
    header("Location: ../vistas/menu_principal.php?localidad#municipio");
  }
}

if($operacion=='Consultar'){ 
  $municipio->nid_localidad($nid_localidad);
  $municipio->ctabla($ctabla);
  $municipio->cdescripcion($cdescripcion);
  if($municipio->Consultar()){
    $_SESSION['datos']['nid_municipio']=$municipio->nid_localidad();
    $_SESSION['datos']['cnombreciudad']=$municipio->cnombreciudad();
    $_SESSION['datos']['cnombremunicipio']=$municipio->cdescripcion();
    $_SESSION['datos']['nid_ciudad']=$municipio->nid_localidad_padre();
    $_SESSION['datos']['estatus_municipio']=$municipio->estatus_municipio();
    header("Location: ../vistas/menu_principal.php?localidad#municipio");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?localidad#municipio");
  }
}    
?>