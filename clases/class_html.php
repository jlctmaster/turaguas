<?php
   require_once("class_bd.php");
   require_once("class_perfil.php");
   class Html{
	private $c,$con;
	public function __construct(){
		$this->c=new Conexion();
	}

	public function __destruct(){	  
	}

	public function Generar_Opciones($sql,$codigo,$descripcion,$Seleccionado){ 
		$lbResultado=false;
		$query=$this->c->Ejecutar($sql);
		$Seleccionado!="null"? 
		$opcion_inicial="<option value='null' > Elige una opcion...</option>": $opcion_inicial="<option value='' selected> Elige una opcion...</option>";
		echo $opcion_inicial;
		while($Datos=$this->c->Respuesta($query)){
			$lbResultado=true;
			$id=$Datos[$codigo];
			$value=$Datos[$descripcion];
			if ($id==$Seleccionado){
				echo "<option value='$id' selected> $value</option>";
			}
			else{
				echo "<option value='$id'>$value</option>";
			}
		}
		return $lbResultado;
	}

	public function Generar_checkbox($sql,$codigo,$descripcion,$Seleccionado){ 
		$lbResultado=false;
		$query=$this->c->Ejecutar($sql);
		$x=-1;
		while($Datos=$this->c->Respuesta($query)){
			$x++;			    
			$lbResultado=true;
			$id=$Datos[$codigo];
			$value=$Datos[$descripcion];
			$var=false;
			if(is_array($Seleccionado)){
				$var=in_array($id,$Seleccionado);			   	
			}
			if (is_array($Seleccionado)==true && $var==true){
				echo $value."<input type='checkbox' value='".$id."' name='".$codigo."[]' id='".$codigo.$x."' checked />&nbsp; | &nbsp;";
			}
			else{
				echo $value."<input type='checkbox'  value='".$id."' name='".$codigo."[]' id='".$codigo.$x."' />&nbsp;|&nbsp; ";
			}
		}
		return $lbResultado;
	}

	public function configurar_menu($perfil_usuario){
		echo "<script>
		function checkear(param){
			var x=0;
			var AB = document.getElementsByClassName(param);
			for(i=1;i<AB.length;i++){
				if(AB[i].checked){
					AB[0].checked=true;
					x++;
				}
			}
			if(AB[0].checked==true && x==0){
				AB[0].checked=false;
				return false;
			}
		}

		function checkear2(param){
			var x=0;
			var AB = document.getElementsByClassName(param);
			if(AB[0].checked){
				prompt('yes')               	
			}	            
			for(i=1;i<AB.length;i++){
				if(AB[i].checked){
					AB[0].checked=true;
					x++;
				}
			}
			if(AB[0].checked==true && x==0){
				AB[0].checked=false;
				return false;
			}
		}

		function seleccionar_todos(param){
			var t=document.getElementsByTagName('input');
			for(i=0;i<t.length;i++){
				if(t[i].type=='checkbox')
					t[i].checked=param;
			}
			document.getElementById('todos').checked=true;
			if(param==true){
				document.getElementById('todos').checked=true;
				document.getElementById('ninguno').checked=false;
			}else{
				document.getElementById('todos').checked=false;
				document.getElementById('ninguno').checked=true;
			}            	
		}
		</script>"; 
		$perfil=new Perfil();
		$query=$this->c->Ejecutar("SELECT * FROM seguridad.tmodulo WHERE dfecha_desactivacion IS NULL ORDER BY nid_modulo ASC");
		echo "<span style='color:#000; font-weight: bold;'>Todos&nbsp;&nbsp;
		<input onclick=seleccionar_todos(true) type='checkbox' name='todos' id='todos'/> 
		/ Ninguno&nbsp;&nbsp;<input onclick=seleccionar_todos(false) type='checkbox' name='ninguno' id='ninguno'/></span>";		 
		echo "<table style='width:100%;font-size:9pt' border=2>";
		echo "<tr style='color:#FFFFFF;background:#3A3A3A'><td>SERVICIOS / OPCIONES</td><td><table border=2 style='width:100%'><tr>";
		$query4=$this->c->Ejecutar("SELECT * FROM seguridad.topcion WHERE dfecha_desactivacion IS NULL");
		while($Datos4=$this->c->Respuesta($query4)){// opciones
			echo "<td style='width: 118px;'>".$Datos4['cnombreopcion']."</td>";
		}
		echo "</tr></table></td></tr>";
		while($Datos1=$this->c->Respuesta($query)){// modulos
			$query2=$this->c->Ejecutar("SELECT * FROM seguridad.tformulario WHERE nid_modulo='".$Datos1['nid_modulo']."' and dfecha_desactivacion IS NULL");         	
			echo "<tr style='color:#FFFFFF;background:#89151A'>";
			echo "<td align='left'><input type='hidden' value='".$Datos1['nid_modulo']."' name='modulos[]'/>"."&nbsp;&nbsp;&nbsp;".$Datos1['cnombremodulo']."</td><td>".""."</td>";
			echo "</tr>";
			while($Datos2=$this->c->Respuesta($query2)){ // formularios 
				$query3=$this->c->Ejecutar("SELECT * FROM seguridad.tservicio WHERE nid_formulario='".$Datos2['nid_formulario']."' and dfecha_desactivacion IS NULL");         	
				echo "<tr style='color:#FFFFFF;background:#E09EA1'>";
				echo "<td align='center'><input type='hidden' value='".$Datos2['nid_formulario']."' name='formularios[]'/>"."&nbsp;&nbsp;&nbsp;".$Datos2['cnombreformulario']."</td><td>".""."</td>";
				echo "</tr>";
				while($Datos3=$this->c->Respuesta($query3)){  // servicios
					$perfil->nid_perfil($perfil_usuario);
					$perfil->nid_servicio($Datos3['nid_servicio']);             	       	
					$perfil->Consultar_SERVICIOS()==true? $checked='checked': $checked='';
					echo "<tr>";
					echo "<td align='center' style='padding-left:2em;'>"; 
					echo "<input onclick=checkear2(this.class) class='cls_".$Datos3['nid_servicio']."' $checked type='checkbox' name='servicios[]' value='".$Datos3['nid_servicio']."'/>"; 
					echo $Datos3['cnombreservicio']; 
					echo "</td>"; 
					$query4=$this->c->Ejecutar("SELECT * FROM seguridad.topcion WHERE dfecha_desactivacion IS NULL");
					echo "<td><table border=0 style='width:100%'><tr>";
					while($Datos4=$this->c->Respuesta($query4)){  //opciones
						echo "<td style='border-right:1px #000 solid;'>";          	
						$perfil->nid_opcion($Datos4['nid_opcion']);             	       	
						$perfil->Consultar_OPCIONES()==true? $checked='checked': $checked='';
						echo "<center><input onclick=checkear('cls_".$Datos3['nid_servicio']."') 
						class='cls_".$Datos3['nid_servicio']."'
						$checked type='checkbox' value='".$Datos4['nid_opcion']."' 
						name='opciones[".$Datos3['nid_servicio']."][]'/></center>"."                      ";
						echo "</td>";          	
					}   
					echo "</tr></table></td>";    	 
					echo "</tr>";
				}
			}
		}

		echo "<tr style='color:#FFFFFF;background:#89151A'><td colspan=2>FIN DE SERVICIOS</td></tr></table>";		 
	}
}
?>