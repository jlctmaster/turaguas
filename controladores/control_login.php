<?php
session_start();
include("../clases/class_usuario.php");
$Usuario=new Usuario();
$Usuario->cnombreusuario(trim($_POST['usuario']));
$Usuario->ccontrasena(trim($_POST['contrasena']));
$res=$Usuario->Buscar();
if($res!=null){
   if($res[0]['estado']==4){
      $_SESSION['datos']['mensaje']="Usuario bloqueado, contacte al administrador!";
      header("Location: ../vistas/intranet.php");
   }else{
      $_SESSION['user_name']=$res[0]['name'];
      $_SESSION['fullname_user']=$res[0]['fullname_user'];
      $_SESSION['user_cedula']=$res[0]['cedula'];
      $_SESSION['user_pregunta']=$preguntas;
      $_SESSION['user_respuesta']=$respuestas;
      $_SESSION['user_password']=$res[0]['contrasena'];
      $_SESSION['user_perfil']=$res[0]['perfil'];
      $_SESSION['user_codigo_perfil']=$res[0]['codigo_perfil'];
      $_SESSION['user_caducidad']=$res[0]['caducidad'];
      $_SESSION['user_diasaviso']=$res[0]['ndias_aviso'];
      $_SESSION['user_npreguntas']=$res[0]['nnumero_preguntas'];
      $_SESSION['user_nrespuestas']=$res[0]['nnumero_respuestasaresponder'];
      $_SESSION['user_estado']=$res[0]['estado'];
      for($i=0;$i<$res[0]['nnumero_preguntas'];$i++){
         $preguntas[]=$res[$i]['preguntas'];
         $respuestas[]=$res[$i]['respuestas'];
      }
      $_SESSION['user_pregunta']=$preguntas;
      $_SESSION['user_respuesta']=$respuestas;
      $Usuario->Intento_Fallido(false);
      header("Location: ../vistas/menu_principal.php");
   }
}else{
   $Usuario->Intento_Fallido(true);
   $Usuario->Bloquear_Usuario();
   $_SESSION['datos']['mensaje']="Usuario/Clave incorrecto!";
   header("Location: ../vistas/intranet.php");
}
?>