$(document).ready(init);
function init(){
	$('#tab-pestana').click(function(){
		if($('#nid_formulario').val()==""){
			alert('Debe seleccionar un registro para continuar!');
			return false;
		}
		else if($(location).attr('search')=="?formulario&l#pestana"){
			alert('Debe seleccionar un registro para continuar!');
			return false;
		}
		else{
			return true;
		}
	});

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
	//para validar en caso que no return false
	permitido=true;
	//campos pestaña 1
	valor=document.getElementById('cnombreformulario').value;
	valor2=document.getElementById('nid_formulario').value;
	valor3=document.getElementById('nid_modulo').value;
	valor4=document.getElementById('curl').value;
	valor0=document.getElementById('norden').value;
	//campos pestaña 2
	valor5=document.getElementById('cnombreservicio').value;
	valor6=document.getElementById('nid_servicio').value;
	valor7=document.getElementById('nid_formulario').value;
	if((devuelve_boton(param)=="Registrar" && urltab == "formulario") || (devuelve_boton(param)=="Modificar" && urltab == "formulario")){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese el nombre del formulario')
			permitido=false;
		}else if(valor4.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese la url del formulario')
			permitido=false;
		}else if(valor0.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese el órden del formulario')
			permitido=false;
		}else if(valor3==0){
			alert('Seleccione un módulo')
			permitido=false;
		}
	}

	if((devuelve_boton(param)=="Registrar" && urltab == "pestana") || (devuelve_boton(param)=="Modificar" && urltab == "pestana")){
		if(valor5.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese el nombre de la pestaña del formulario')
			permitido=false;
		}
	}
		
	if(devuelve_boton(param)=="Desactivar" && urltab == "formulario"){
		if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}	

		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false
	}

	if(devuelve_boton(param)=="Desactivar" && urltab == "pestana"){
		if(valor6.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}	

		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false
	}

	if(permitido==true && urltab =="formulario"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
	else if(permitido==true && urltab =="pestana"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form2").submit();
	}
}