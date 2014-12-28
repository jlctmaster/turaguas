<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#cambiarcontrasena" data-toggle="tab" id="tab-cambiarclave">Cambiar Contraseña</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
    	<script src="../js/eft_usuario.js"> </script>
    	<div class="tab-pane active in" id="cambiarcontrasena">
			<div class="form_externo" >
				<?php
				  $servicios='cambiarcontrasena';
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
				  }
				?>
			  	<fieldset style="padding: 30px">
					<form action="../controladores/control_cambiar_clave.php" method='post' id="form1" name="form" >
						<table width="100%" border="0">
							<tr>
								<td>              
									<span class="texto_form">Contrase&ntilde;a Actual</span>
								</td>
								<td>              
									<input title="Clave actual" type="password" id="contrasena" name="contrasena" size="25" 
									value="<?php echo $_SESSION['user_password'];?>" readonly/>
								</td>
							</tr>
							<tr>
								<td>              
									<span class="texto_form">Nueva Contrase&ntilde;a</span>
								</td>
								<td>              
									<input type="password" id="nueva_contrasena" name="nueva_contrasena" size="25" 
									placeholder="Ingrese la nueva contrase&ntilde;a" title="Ingrese la nueva contrase&ntilde;a" required/>
								</td>
							</tr>
							<tr>
								<td>              
									<span class="texto_form">Confirmar Contrase&ntilde;a</span>
								</td>
								<td>              
									<input type="password" id="confirmar_contrasena" name="confirmar_contrasena" size="25" 
									placeholder="confirme su nueva contrase&ntilde;a" title="Confirme su nueva contrase&ntilde;a" required/>
								</td>
							</tr>
							<?php echo '<tr><td colspan="2" class="'.$estatus.'" id="estatus_registro">'.$estatus.'</td></tr>'; ?>
						</table>
						<table style="width:100%" border="0">            
							<tr>
								<td align="center">
									<center>
                    <span class="texto_form"> Los campos resaltados en rojo son obligatorios </span><br /><br />
										<?php
											imprimir_boton($disabledRC,$disabledMD,$estatus,$servicios,"cambiarcontrasena");
										?> 
									</center>
								</td>
							</tr>
						</table>
						<input type="hidden" value="0" name="cambiar_clave_con_logeo" id="cambiar_clave_con_logeo" />
					</form>
				</fieldset>
			</div>
    	</div>
  	</div>
</div>