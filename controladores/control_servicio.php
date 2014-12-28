<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

echo $_POST['operacion'];

if(isset($_POST['nid_servicio']))
$nid_servicio=trim($_POST['nid_servicio']);

if(isset($_POST['cnombreservicio']))
$cnombreservicio=trim($_POST['cnombreservicio']);

if(isset($_POST['nid_formulario']))
$nid_formulario=trim($_POST['nid_formulario']);

include_once("../clases/class_servicio.php");
$servicios=new Servicios();
if($operacion=='Registrar'){
  $servicios->nid_servicio($nid_servicio);
  $servicios->cnombreservicio($cnombreservicio);
  $servicios->nid_formulario($nid_formulario);
  if(!$servicios->Comprobar()){
    if($servicios->Registrar($_SESSION['user_name']))
       $confirmacion=1;
    else
       $confirmacion=-1;
  }else{
    if($servicios->dfecha_desactivacion()==null)
      $confirmacion=0;
    else{
      if($servicios->Activar($_SESSION['user_name']))            
         $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La pestaña ha sido registrada con exito!";
    header("Location: ../vistas/menu_principal.php?formulario#pestana");
   }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al registrar la pestaña.";
    header("Location: ../vistas/menu_principal.php?formulario#pestana");
  }
}

if($operacion=='Modificar'){
  $servicios->nid_servicio($nid_servicio);
  $servicios->cnombreservicio($cnombreservicio);
  $servicios->nid_formulario($nid_formulario);
  if($servicios->Actualizar($_SESSION['user_name']))
   $confirmacion=1;
  else
   $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La pestaña ha sido modificada con exito!";
    header("Location: ../vistas/menu_principal.php?formulario#pestana");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al modificar la pestaña.";
    header("Location: ../vistas/menu_principal.php?formulario#pestana");
  }
}

if($operacion=='Desactivar'){
  $servicios->nid_servicio($nid_servicio);
  $servicios->cnombreservicio($cnombreservicio);
  if($servicios->Consultar()){
    if($servicios->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La pestaña ha sido desactivada con exito!";
    header("Location: ../vistas/menu_principal.php?formulario#pestana");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al desactivar la pestaña.";
    header("Location: ../vistas/menu_principal.php?formulario#pestana");
  }
}

if($operacion=='Activar'){
  $servicios->nid_servicio($nid_servicio);
  $servicios->cnombreservicio($cnombreservicio);
  if($servicios->Consultar()){
    if($servicios->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  }else{
    $confirmacion=0;
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="La pestaña ha sido activada con exito!";
    header("Location: ../vistas/menu_principal.php?formulario#pestana");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrió un error al activar la pestaña.";
    header("Location: ../vistas/menu_principal.php?formulario#pestana");
  }
}

if($operacion=='Consultar'){ 
  $servicios->nid_servicio($nid_servicio);
  $servicios->cnombreservicio($cnombreservicio);
  if($servicios->Consultar()){
    $_SESSION['datos']['nid_servicio']=$servicios->nid_servicio();
    $_SESSION['datos']['cnombreservicio']=$servicios->cnombreservicio();
    $_SESSION['datos']['nid_formulario']=$servicios->nid_formulario();
    $_SESSION['datos']['cnombreformulario']=$servicios->cnombreformulario();
    $_SESSION['datos']['estatus_servicios']=$servicios->estatus_servicios();
    header("Location: ../vistas/menu_principal.php?formulario#pestana");
  }else{
    $_SESSION['datos']['mensaje']="No se encontró algún resultado con el filtro de búsqueda(".$cnombreservicio.")";
    header("Location: ../vistas/menu_principal.php?formulario#pestana");
  }
}    
?>