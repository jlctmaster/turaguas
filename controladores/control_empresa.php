<?php
//Verificar Inicio de Session.
session_start();
//Verificar si la variable esta construida.
if(isset($_POST['operacion']))
//Asignar valor a variable
$operacion=ucfirst(trim($_POST['operacion']));

if(isset($_POST['crif_empresa']))
$crif_empresa=trim($_POST['crif_empresa']);

if(isset($_POST['cnombre_empresa']))
$cnombre_empresa=trim($_POST['cnombre_empresa']);

if(isset($_POST['ctlf_empresa']))
$ctlf_empresa=trim($_POST['ctlf_empresa']);

if(isset($_POST['cemail_empresa']))
$cemail_empresa=trim($_POST['cemail_empresa']);

if(isset($_POST['cclave_email_empresa']))
$cclave_email_empresa=trim($_POST['cclave_email_empresa']);

if(isset($_POST['nid_localidad']))
$nid_localidad=trim($_POST['nid_localidad']);

if(isset($_POST['cdireccion_empresa']))
$cdireccion_empresa=trim($_POST['cdireccion_empresa']);

if(isset($_POST['cmision']))
$cmision=trim($_POST['cmision']);

if(isset($_POST['cvision']))
$cvision=trim($_POST['cvision']);

if(isset($_POST['cobjetivo']))
$cobjetivo=trim($_POST['cobjetivo']);

if(isset($_POST['chistoria']))
$chistoria=trim($_POST['chistoria']);

include_once("../clases/class_empresa.php");
$empresa=new Empresa();

if($operacion=='Modificar'){
  $empresa->crif_empresa($crif_empresa);
  $empresa->cnombre_empresa($cnombre_empresa);
  $empresa->ctlf_empresa($ctlf_empresa);
  $empresa->cemail_empresa($cemail_empresa);
  $empresa->cclave_email_empresa($cclave_email_empresa);
  $empresa->nid_localidad($nid_localidad);
  $empresa->cdireccion_empresa($cdireccion_empresa);
  $empresa->cmision($cmision);
  $empresa->cvision($cvision);
  $empresa->cobjetivo($cobjetivo);
  $empresa->chistoria($chistoria);
  if($empresa->Actualizar($_SESSION['user_name']))
   $confirmacion=1;
  else
   $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="Los datos de la empresa han sido modificado con exito!";
    header("Location: ../vistas/menu_principal.php?empresa");
  }else{
    $_SESSION['datos']['mensaje']="Ocurrio un error al modificar los datos de la empresa.";
    header("Location: ../vistas/menu_principal.php?empresa");
  }
}    
?>