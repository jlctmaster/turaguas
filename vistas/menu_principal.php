<?php
session_start();
if(isset($_SESSION['user_estado'])){
?>
  <!DOCTYPE html>
  <html>
  <head lang="es">
    <title>El Futuro de las Turaguas</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <!-- Load StyleSheet-->
    <link rel="StyleSheet" href="../css/jquery-ui.css" />
    <link rel="StyleSheet" href="../librerias/bootstrap/css/normalize.css">
    <link rel="StyleSheet" href="../librerias/bootstrap/css/bootstrap.css">
    <link rel="StyleSheet" href="../css/style.css">
    <link rel="StyleSheet" href="../librerias/noty/buttons.css"/>
    <link rel="stylesheet" href="../librerias/alert/Alert.css" />
    <!-- Load Alert-->
    <script src="../librerias/alert/Alert.js"></script>    
    <!-- Load JQuery-->
    <script src="../js/jquery.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/jquery.ui.datepicker-es.js"></script>
    <script src="../js/jquery-ui-timepicker.js"></script>
    <!-- Load Bootstrap Libreries-->
    <script src="../librerias/bootstrap/js/bootstrap.min.js"></script>
    <!-- Load Noty Libreries-->
    <script src="../librerias/noty/jquery.noty.packaged.min.js"></script>
    <!-- Load System Files-->
    <script type="text/javascript" src="../js/main.js"></script>
    <style>
    .Activo{
      color: green;              
    }
    .Desactivado{
      color: red;                 
    }
    </style>
  </head>
  <body>
    <div id="sidebar">
    <a href='./menu_principal.php'><img id='logo' src='../images/logo.gif'></a>
      <?php
        if($_SESSION['user_estado']==1){
           include("menu.php");
        }
      ?>
    </div>
    <div id="mainBody">
      <div class="container-fluid">
        <div class="row-fluid">
          <div style="text-align: center;" class="span12 center">
            <img id="banner" src="../images/BANNER_TURAGUAS.jpg">
               <?php 
               include("botones.php");
                   if($_SESSION['user_estado']==3){
                     $_SESSION['datos']['mensaje']="Completa los datos de seguridad";
                     include("serv_usuario.php");                                             
                   }elseif($_SESSION['user_estado']==2){
                    $_SESSION['datos']['mensaje']="Contraseña caducida";
                    echo "<script>location.href='intranet.php?p=olvidar-clave'</script>";
                    exit();
                   }elseif($_SESSION['user_caducidad']=='1'){
                      $_SESSION['datos']['mensaje']="Debe cambiar la clave cada 6 meses";
                    echo "<script>location.href='intranet.php?p=olvidar-clave'</script>";
                    exit();
                    }elseif($_SESSION['user_estado']==1){
                        //seguridad
                        if(isset($_GET['perfil'])) include("serv_usuario.php"); 
                        else if(isset($_GET['nuevousuario'])) include("serv_nuevo_usuario.php");
                        else if(isset($_GET['cambiarcontrasena'])) include("serv_cambiar_contrasena.php");
                        else if(isset($_GET['perfiles'])) include("serv_perfil.php"); 
                        else if(isset($_GET['formulario'])) include("servicio.php");
                        else if(isset($_GET['configuracion'])) include("serv_configuracion.php");
                        else if(isset($_GET['empresa'])) include("serv_empresa.php");
                        else if(isset($_GET['bitacora'])) include("serv_bitacora.php");
                        else if(isset($_GET['desbloquearusuario'])) include("serv_desbloquearusuario.php");
                        else if(isset($_GET['modulo'])) include("serv_modulo.php");
                        else if(isset($_GET['botones'])) include("serv_opcion.php");
                        else if(isset($_GET['combovalor'])) include("serv_combovalor.php");
                        //ubicaciones
                        else if(isset($_GET['localidad'])) include("serv_localidad.php");
                        //general
                        else if(isset($_GET['condicionpago'])) include("serv_condicionpago.php");
                        else if(isset($_GET['empleado'])) include("serv_empleado.php");
                        else if(isset($_GET['impuesto'])) include("serv_impuesto.php");
                        else if(isset($_GET['lista_precio'])) include("serv_lista_precio.php");
                        else if(isset($_GET['motivorazon'])) include("serv_motivo.php");
                        else if(isset($_GET['roles'])) include("serv_rol.php");
                        else if(isset($_GET['tipodocumento'])) include("serv_tipodocumento.php");
                        //inventario
                        else if(isset($_GET['localizador'])) include("serv_localizador.php");
                        else if(isset($_GET['inventario'])) include("serv_inventario.php");
                        else if(isset($_GET['movimientomaterial'])) include("serv_movimientomaterial.php");
                        else if(isset($_GET['produccion'])) include("serv_produccion.php");
                        //devolución
                        else if(isset($_GET['motivodevolucion'])) include("serv_motivodevolucion.php");
                        else if(isset($_GET['notadevolucioncliente'])) include("serv_notadevolucioncliente.php");
                        else if(isset($_GET['notadevolucionproveedor'])) include("serv_notadevolucionproveedor.php");
                        //ventas
                        //else if(isset($_GET['ordendespacho'])) include("serv_ordendespacho.php");
                        //else if(isset($_GET['facturacliente'])) include("serv_facturacliente.php");
                        //else if(isset($_GET['ordenventa'])) include("serv_ordenventa.php");
                        else if(isset($_GET['reembolsocliente'])) include("serv_reembolsocliente.php");
                        else if(isset($_GET['notaentrega'])) include("serv_notaentrega.php");
                        else if(isset($_GET['cotizacion'])) include("serv_cotizacion.php");
                        else if(isset($_GET['cliente'])) include("serv_cliente_direccion_contacto.php");
                        //compras
                        //else if(isset($_GET['ordenrecibo'])) include("serv_ordenrecibo.php");
                        //else if(isset($_GET['facturaproveedor'])) include("serv_facturaproveedor.php");
                        else if(isset($_GET['ordencompra'])) include("serv_ordencompra.php");
                        else if(isset($_GET['reembolsoproveedor'])) include("serv_reembolsoproveedor.php");
                        else if(isset($_GET['solicitudcompra'])) include("serv_solicitudcompra.php");
                        else if(isset($_GET['notarecepcion'])) include("serv_notarecepcion.php");
                        else if(isset($_GET['proveedor'])) include("serv_proveedor_direccion_contacto.php");
                        //materiales
                        else if(isset($_GET['articulo_conversion_configuracion'])) include("serv_articulo_conversion_configuracion.php");
                        else if(isset($_GET['categoria'])) include("serv_formcategoria.php");
                        else if(isset($_GET['marca'])) include("serv_marca.php");
                        else if(isset($_GET['presentacion'])) include("serv_presentacion.php");
                        else if(isset($_GET['tipoarticulo'])) include("serv_tipoarticulo.php");
                        else if(isset($_GET['unidadmedida'])) include("serv_unidad.php");
                        //reportes
                        else if(isset($_GET['nr_proveedor'])) include("reporte_nr_proveedor.php");
                        else if(isset($_GET['ne_cliente'])) include("reporte_ne_cliente.php");
                        else if(isset($_GET['solicitudcompra_emitida'])) include("reporte_solicitudcompra_emitida.php");
                        else if(isset($_GET['cotizacion_emitida'])) include("reporte_cotizacion_emitida.php");
                        else if(isset($_GET['inv_materiales'])) include("reporte_inv_materiales.php");
                        else if(isset($_GET['inv_fisico'])) include("reporte_inv_fisico.php");
                        else if(isset($_GET['devolucion_cliente'])) include("reporte_devolucion_cliente.php");
                        else if(isset($_GET['devolucion_proveedor'])) include("reporte_devolucion_proveedor.php");
                        else if(isset($_GET['reembolso_cliente'])) include("reporte_reembolso_cliente.php");
                        else if(isset($_GET['reembolso_proveedor'])) include("reporte_reembolso_proveedor.php");
                        //principal
                        else include("serv_inicio.php");                                                                                                                                                                                                                                                                                                                                            
                    }else {
                      echo "<script>location.href='403.php'</script>";
                      }
               ?>                                   
          </div>  
        </div>
      </div>
    </div>
  <?php
  if(isset($_SESSION['datos']['mensaje'])){
      echo "<script>alert('".$_SESSION['datos']['mensaje']."')</script>";  
    }
  if(isset($_SESSION['datos']))
    unset($_SESSION['datos']);  
  ?>
  </body>
  </html>
  <?php
}else{
    echo "<script>location.href='403.php'</script>";
  }
?>
