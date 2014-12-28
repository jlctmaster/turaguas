<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#miperfil" data-toggle="tab" id="tab-miperfil">Mi Perfil</a></li>
  </ul>
  <div id="myTabContent" class="tab-content">
    <script src="../js/eft_usuario.js"> </script>
    <div class="tab-pane active in" id="miperfil">
      <div class="form_externo" >
        <?php
          $servicios='perfil';
          $disabledRC=null;
          $disabledMD=null;
          $estatus=null;
          require_once('../clases/class_bd.php');
          $conexion = new Conexion();
          $sql = "SELECT c.* FROM seguridad.tconfiguracion c 
          INNER JOIN seguridad.tperfil p ON p.nid_configuracion = c.nid_configuracion 
          WHERE p.nid_perfil = '".$_SESSION['user_codigo_perfil']."'";
          $query=$conexion->Ejecutar($sql);
          if($Obj=$conexion->Respuesta($query)){
            echo "<input type='hidden' id='nlongitud_minclave' value='".$Obj['nlongitud_minclave']."' />";
            echo "<input type='hidden' id='nlongitud_maxclave' value='".$Obj['nlongitud_maxclave']."' />";
            echo "<input type='hidden' id='ncantidad_letrasmayusculas' value='".$Obj['ncantidad_letrasmayusculas']."' />";
            echo "<input type='hidden' id='ncantidad_letrasminusculas' value='".$Obj['ncantidad_letrasminusculas']."' />";
            echo "<input type='hidden' id='ncantidad_caracteresespeciales' value='".$Obj['ncantidad_caracteresespeciales']."' />";
            echo "<input type='hidden' id='ncantidad_numeros' value='".$Obj['ncantidad_numeros']."' />";
            echo "<input type='hidden' id='nnumero_preguntas' value='".$Obj['nnumero_preguntas']."' />";
            $npreguntas = $Obj['nnumero_preguntas'];
          }
        ?>
        <fieldset style="padding: 30px">
          <form  id="form1" name="form" action="../controladores/control_cambiar_clave.php" method="post" enctype="multipart/form-data">
            <table width="100%" border="0">
              <tr>
                <td>
                  <div align="right"><span class="texto_form">C&eacute;dula:</span></div>
                </td>
                <td>
                <label>
                  <input type="text" name="cedula_usuario" id="cedula_usuario" value="<?php echo $_SESSION['user_cedula'];?>" size="8" readonly required /> 
                </label>
                </td>
                <td>
                  <div align="right"><span class="texto_form">Nombre Usuario:</span></div>
                </td>
                <td>
                  <label>
                    <input readonly type="text" name="nombre_usuario" id="nombre_usuario" value="<?php echo trim($_SESSION['user_name']);?>" size="20" required /> 
                  </label>
                </td>
              </tr>
              <?php
                for($i=0;$i<$npreguntas;$i++){
                  $numero=$i+1;
                  echo "<tr>
                  <td>
                    <div align='right'><span class='texto_form'>Pregunta $numero:</span></div>
                  </td>
                  <td>
                    <label>
                      <textarea onKeyUp='this.value=this.value.toUpperCase()' name='preguntas[]' id='pregunta_".$i."' title='Ingrese la pregunta $numero de seguridad' required/>".$_SESSION['user_pregunta'][$i]."</textarea>
                    </label>
                  </td>
                  <td>
                    <div align='right'><span class='texto_form'>Respuesta:</span></div>
                  </td>
                  <td>
                    <label>
                      <textarea onKeyUp='this.value=this.value.toUpperCase()' name='respuestas[]' id='respuesta_".$i."' title='Ingrese la respuesta de la pregunta $numero de seguridad' required/>".$_SESSION['user_respuesta'][$i]."</textarea>
                    </label>
                  </td>
                  </tr>";
                }
              ?>
            </table>
            <?php if($_SESSION['user_estado']==3){?>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on"><i class="icon-lock"></i></span> 
                <input value="123456" type="password" name="contrasena" id="contrasena_actual" readonly required/>
              </div>
              <br>
              <div class="input-prepend">
                <span class="add-on"><i class="icon-lock"></i></span>                
                <input name="nueva_contrasena" type="password" id="nueva_contrasena" placeholder="Nueva contraseña" title="Por favor coloque su contraseña" required />                      
              </div>
              <br>
              <div class="input-prepend">
                <span class="add-on"><i class="icon-lock"></i></span>
                <input name="confirmar_contrasena" type="password" id="confirmar_contrasena" placeholder="Repita la Contraseña" title="Repita la Contraseña" required/>
              </div>
            </div>      
            <input type="hidden" name="cambiar_clave_con_logeo" value="1"/>        
            <?php } ?>
            <table style="width:100%" border="0">            
              <tr>
                <td align="center">
                  <center>
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
                    <?php
                      imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"miperfil");
                    ?> 
                  </center>
                </td>
              </tr>
            </table>
          </form>
        </fieldset>
      </div>
    </div>
  </div>
</div