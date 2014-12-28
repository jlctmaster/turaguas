<?php
	echo '<div id="userlogin">Bievenid@: '.$_SESSION['fullname_user'].'</div>';
?>
<div class="accordion" id="leftMenu">
	<div class="accordion-group">
      	<div class="accordion-heading">
         	<a class="accordion-toggle" href="./menu_principal.php">
            	<i class="icon-home active"></i> Principal
       		</a>
		</div>
	</div>
	<?php  
	require_once("../clases/class_perfil.php");
	$perfil=new Perfil();
	$perfil->nid_perfil($_SESSION['user_codigo_perfil']);
	$a=$perfil->IMPRIMIR_MODULOS();
	for($x=0;$x<count($a);$x++) {
		$titulo=ucfirst(strtolower($a[$x]['cnombremodulo']));
	echo '	
		<div class="accordion-group">
			<div class="accordion-heading">
			    <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#collapse_'.$x.'">
			    	<i class="'.strtolower($a[$x]['cicono']).'"></i> '.ucfirst($a[$x]['cnombremodulo']).'
			  	</a>
			</div>
			<div id="collapse_'.$x.'" class="accordion-body collapse" style="height: 0px; ">
				<div class="accordion-inner">
					<ul class="navi">';
					$perfil->nid_modulo($a[$x]['nid_modulo']);
					$b=$perfil->IMPRIMIR_FORMULARIOS();
					for($y=0;$y<count($b);$y++) {
					echo 	'<li><a href="menu_principal.php?'.strtolower($b[$y]['curl']).'"><i></i>'.ucfirst($b[$y]['cnombreformulario']).'</a></li>';
					}
				  echo '</ul>
				</div>
			</div>
		</div> ';
		}
		?>
	<div class="accordion-group">
      	<div class="accordion-heading">
         	<a class="accordion-toggle" onclick="salir()">
            	<i class="icon-off"></i> Salir
       		</a>
		</div>
	</div>
</div>
