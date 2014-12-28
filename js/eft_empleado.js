$(document).ready(init);
function init(){
	var hash = window.location.hash.substr(1); 
	var href = $('ul.nav-tabs li a').each(function(){ 
		var href = $(this).attr('href'); 
		href=href.substr(1); 
		if(hash==href){ 
			$(".tab-pane").hide(); 
			$("ul.nav-tabs li").removeClass("active"); 
			$(this).parent('li').addClass("active"); 
			$('#'+hash).fadeIn(); 
		}	 
	})     

	$("ul.nav-tabs li").click(function(){ 
		$("ul.nav-tabs li").removeClass("active"); 
		$(this).addClass("active"); 
		$(".tab-pane").hide();   
		var content = $(this).find("a").attr("href"); 
		$(content).fadeIn(); return false; 
	});
}

function validar_formulario(param,urltab){
	//para validar en caso q no return false
	permitido=true;
	valor=document.getElementById('crif_persona').value;
	valor0=document.getElementById('cnombre').value;
	valor1=document.getElementById('cdireccion').value;
	valor2=document.getElementById('ctelefhab').value;
	valor3=document.getElementById('nid_rol').value;
	valor4=document.getElementById('nid_localidad').value;
	valor5=document.getElementById('cemail').value;
	if((devuelve_boton(param)=="Registrar" && urltab == "empleado") || (devuelve_boton(param)=="Modificar" && urltab == "empleado")){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){
			alert('Ingrese el rif o cédula del empleado')
			permitido=false;
		}else if(valor.replace(/^\s+|\s+$/gi,"").length<7){
			alert('El rif o cédula del empleado debe tener mínimo 7 caracteres')
			permitido=false;
		}else if(valor0.replace(/^\s+|\s+$/gi,"").length==0){
			alert('Ingrese el nombre del empleado')
			permitido=false;
		}
		else if(valor0.replace(/^\s+|\s+$/gi,"").length<6){
			alert('El nombre del empleado debe tener mínimo 6 caracteres')
			permitido=false;
		}
		else if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese el teléfono de habitación del empleado')
			permitido=false;
		}
		else if(valor2.replace(/^\s+|\s+$/gi,"").length<11){ //para no permitir que se queda en blanco
			alert('El teléfono de habitación del empleado debe tener 11 caracteres')
			permitido=false;
		}
		else if(valor5.replace(/^\s+|\s+$/gi,"").length==0){// validar dirección de correo valido
			alert('Ingrese la dirección de correo electrónico')
			permitido=false;
		}
		else if(!(/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/.test(valor5)) || valor5.replace(/^\s+|\s+$/gi,"").length==0){// validar dirección de correo valido
			alert('Ingrese una dirección de correo electrónico valida')
			permitido=false;
		}
		
		else if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese la dirección del empleado')
			permitido=false;
		}
		else if(valor1.replace(/^\s+|\s+$/gi,"").length<24){ //para no permitir que se queda en blanco
			alert('La dirección del empleado debe tener mínimo 24 caracteres')
			permitido=false;
		}
		else if(valor4==0){ //para no permitir que se queda en blanco
			alert('Seleccione una parroquia')
			permitido=false;
		}
		else if(valor3==0){ //para no permitir que se queda en blanco
			alert('Seleccione un rol o cargo')
			permitido=false;
		}
	}
	if(devuelve_boton(param)=="Consultar" && urltab == "empleado"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Debe ingresar la cédula del empleado')
			permitido=false;
			}
	}
	if(devuelve_boton(param)=="Desactivar" && urltab == "empleado"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}	
		if(!confirm("Esta seguro que desea desactivar este registro"))
	     return false
	}

	if(permitido==true && urltab =="empleado"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
}