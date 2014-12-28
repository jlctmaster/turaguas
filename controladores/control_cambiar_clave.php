<?php
session_start(); 
if(isset($_POST['cambiar_clave_con_logeo']) and $_POST['cambiar_clave_con_logeo']==0 and isset($_POST['operacion']) and $_POST['operacion']=='Modificar'){
  if(!(isset($_SESSION['user_name']) and isset($_SESSION['user_password']) and $_SESSION['user_perfil']))
    header("Location: controladores/control_desconectar.php");
  else if($_POST['nueva_contrasena']!=$_POST['confirmar_contrasena']){
    $_SESSION['datos']['mensaje']="Las contraseñas no coeciden!";
    header("Location: ../vistas/menu_principal.php?cambiarcontrasena");
  }else if(strlen($_POST['nueva_contrasena'])< $_POST['nlongitud_minclave']){
    $_SESSION['datos']['mensaje']="La contraseña debe tener mínimo ".$_POST['nlongitud_minclave']." caracteres!";
    header("Location: ../vistas/menu_principal.php?cambiarcontrasena");
  }else if($_POST['nueva_contrasena']==$_POST['confirmar_contrasena']){
    include("../clases/class_usuario.php");
    $Usuario=new Usuario();
    $Usuario->cnombreusuario($_SESSION['user_name']);
    $Usuario->ccontrasena($_POST['nueva_contrasena']);    
    if($Usuario->Buscar_ultimas_3_clave()==false){
      if($Usuario->Cambiar_Clave($_SESSION['user_name'])){
        $_SESSION['datos']['mensaje']="Tu contraseña ha sido cambiada con éxito!";
        $_SESSION['user_password']=sha1(md5($_POST['nueva_contrasena']));
        header("Location: ../vistas/menu_principal.php?cambiarcontrasena");
      }
      else{
        $_SESSION['datos']['mensaje']="Tu contraseña no ha sido cambiada!";
        header("Location: ../vistas/menu_principal.php?cambiarcontrasena");
      }
    }else{
      $_SESSION['datos']['mensaje']="Esta clave ha sido usado anteriormente, usa una clave nueva!";
      header("Location: ../vistas/menu_principal.php?cambiarcontrasena");
    }
  }else{
    header("Location: ../vistas/menu_principal.php?cambiarcontrasena");
  }
}

if(isset($_POST['operacion']) and $_POST['operacion']=='Registrar'){
  include("../clases/class_usuario.php");
  $Usuario=new Usuario();
  $Usuario->ccedula($_POST['cedula']);
  if($Usuario->Consultar_personal()){
    $Usuario=new Usuario();
    $Usuario->nid_perfil(trim($_POST['perfil']));
    $Usuario->cnombreusuario($Usuario->Generar_NombreUsuario(trim($_POST['cedula']),trim($_POST['perfil'])));
    $Usuario->ccedula(trim($_POST['cedula']));
    if(!$Usuario->Registrar($_SESSION['user_name'])){
      $_SESSION['datos']['mensaje']="Lo sentimos, el usuario no se ha podido registrar, intenta más tarde";
      header("Location: ../vistas/menu_principal.php?nuevousuario");
    }else{
      $_SESSION['datos']['mensaje']="El usuario se ha creado con éxito!";
      header("Location: ../vistas/menu_principal.php?nuevousuario");
    }
  }else{
  $_SESSION['datos']['mensaje']="Lo sentimos, (".$_POST['cedula'].") no esta registrado como personal administrativo";
  }
  header("Location: ../vistas/menu_principal.php?nuevousuario");
}

if(isset($_POST['operacion']) and $_POST['operacion']=='Modificar'){
  include("../clases/class_usuario.php");
  $Usuario=new Usuario();
  if($_SESSION['user_estado']<>3){
    $Usuario->cnombreusuario($_POST['nombre_usuario']);
    if($Usuario->Actualizar($_SESSION['user_name'],$_SESSION['user_pregunta'],$_POST['preguntas'],$_POST['respuestas'])){
      $Usuario->cnombreusuario($_POST['nombre_usuario']);
      $res=$Usuario->Buscar_1();
      if($res!=null){
        for($i=0;$i<$res[0]['nnumero_preguntas'];$i++){
           $preguntas[]=$res[$i]['preguntas'];
           $respuestas[]=$res[$i]['respuestas'];
        }
        $_SESSION['user_pregunta']=$preguntas;
        $_SESSION['user_respuesta']=$respuestas;
      }
      $_SESSION['datos']['mensaje']="Se han realizado los cambios exitosamente!";
      $_SESSION['user_estado']=1;
      header("Location: ../vistas/menu_principal.php?perfil");
    }else{
      $_SESSION['datos']['mensaje']="Ocurrió un error al actualizar los datos, intenta más tarde!";
      header("Location: ../vistas/menu_principal.php?perfil");
    }
  }
  else{
    $Usuario->cnombreusuario($_POST['nombre_usuario']);
    $Usuario->ccontrasena($_POST['nueva_contrasena']);
    if($Usuario->Cambiar_Clave($_SESSION['user_name'])){
      if($Usuario->CompletarDatos($_SESSION['user_name'],$_POST['preguntas'],$_POST['respuestas'])){
        $Usuario->cnombreusuario($_POST['nombre_usuario']);
        $res=$Usuario->Buscar_1();
        if($res!=null){
          for($i=0;$i<$res[0]['nnumero_preguntas'];$i++){
             $preguntas[]=$res[$i]['preguntas'];
             $respuestas[]=$res[$i]['respuestas'];
          }
          $_SESSION['user_pregunta']=$preguntas;
          $_SESSION['user_respuesta']=$respuestas;
        }
        $_SESSION['datos']['mensaje']="Se han realizado los cambios exitosamente!";
        $_SESSION['user_estado']=1;
        header("Location: ../vistas/menu_principal.php");
      }else{
        $_SESSION['datos']['mensaje']="Ocurrió un error al actualizar los datos, intenta más tarde!";
        header("Location: ../vistas/menu_principal.php");
      }
    }else{
      $_SESSION['datos']['mensaje']="Ocurrió un error al actualizar los datos, intenta más tarde!";
      header("Location: ../vistas/menu_principal.php");
    }
  }
}

if(isset($_POST['cambiar_clave_sin_logeo'])){	
  if($_POST['nueva_contrasena']!=$_POST['confirmar_contrasena']){
    $_SESSION['datos']['mensaje']="Las contraseñas no coeciden!";
    header("Location: ../vistas/intranet.php?p=cambiar-contrasena");
  }else if($_POST['nueva_contrasena']==$_POST['confirmar_contrasena']){
    include("../clases/class_usuario.php");
    $Usuario=new Usuario();
    $Usuario->cnombreusuario($_SESSION['user_name']);
    $Usuario->ccontrasena($_POST['nueva_contrasena']);
    if($Usuario->Buscar_ultimas_3_clave()==false){
      if($Usuario->Cambiar_Clave($_SESSION['user_name'])){
        $_SESSION['datos']['mensaje']="Tu contraseña ha sido cambiada exitosamente!";
        $_SESSION['user_password']=sha1(md5($_POST['nueva_contrasena']));
        header("Location: ../vistas/intranet.php");
      }
      else{
        $_SESSION['datos']['mensaje']="Tu contraseña no ha sido cambiada!";
        header("Location: ../vistas/intranet.php");
      }
    }else{
      $_SESSION['pregunta_respuesta']=4;
      $_SESSION['datos']['mensaje']="Esta clave ha sido usado anteriormente, usa una clave nueva!";
      header("Location: ../vistas/intranet.php?p=cambiar-contrasena");
    }
  }else{
    header("Location: ../");
  }
}	
?>