<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construnid_localidada.
if(isset($_POST['operacion']))
//Asignar valor a variable
  $operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['nid_pais']))
  $nid_localidad=trim($_POST['nid_pais']);

if(isset($_POST['ctabla_pais']))
  $ctabla=trim($_POST['ctabla_pais']);

if(isset($_POST['cnombrepais']))
  $cdescripcion=trim($_POST['cnombrepais']);

include_once("../clases/class_pais.php");
$pais=new Pais();
if($operacion=='Registrar'){
  $pais->nid_localidad($nid_localidad);
  $pais->ctabla($ctabla);
  $pais->cdescripcion($cdescripcion);
  if(!$pais->Comprobar()){
    if($pais->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($pais->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
    if($pais->Activar($_SESSION['user_name']))					  
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El país ha sido registrado con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#pais");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar el país.";
    header("Location: ../vistas/menu_principal.php?localidad#pais");
  }
}

if($operacion=='Modificar'){
  $pais->nid_localidad($nid_localidad);
  $pais->ctabla($ctabla);
  $pais->cdescripcion($cdescripcion);
  if($pais->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El país ha sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#pais");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar el país.";
    header("Location: ../vistas/menu_principal.php?localidad#pais");
  }
}

if($operacion=='Desactivar'){
  $pais->nid_localidad($nid_localidad);
  $pais->ctabla($ctabla);
  $pais->cdescripcion($cdescripcion);
  if($pais->Consultar()){
    if($pais->Desactivar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El país ha sido desactivado con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#pais");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar el país.";
    header("Location: ../vistas/menu_principal.php?localidad#pais");
  }
}

if($operacion=='Activar'){
  $pais->nid_localidad($nid_localidad);
  $pais->ctabla($ctabla);
  $pais->cdescripcion($cdescripcion);
  if($pais->Consultar()){
    if($pais->Activar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="El país ha sido activado con exito!";
    header("Location: ../vistas/menu_principal.php?localidad#pais");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar el país.";
    header("Location: ../vistas/menu_principal.php?localidad#pais");
  }
}

if($operacion=='Consultar'){	
  $pais->nid_localidad($nid_localidad);
  $pais->ctabla($ctabla);
  $pais->cdescripcion($cdescripcion);
  if($pais->Consultar()){
    $_SESSION['datos']['nid_pais']=$pais->nid_localidad();
    $_SESSION['datos']['ctabla']=$pais->ctabla();
    $_SESSION['datos']['cnombrepais']=$pais->cdescripcion();
    $_SESSION['datos']['estatus_pais']=$pais->estatus_pais();
    header("Location: ../vistas/menu_principal.php?localidad#pais");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cdescripcion.")";
    header("Location: ../vistas/menu_principal.php?localidad#pais");
  }
}		  
?>