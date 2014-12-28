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
//campos pestaña 1
valor=document.getElementById('cnombreopcion').value;
valor2=document.getElementById('nid_opcion').value;
valor3=document.getElementById('norden').value;
if((devuelve_boton(param)=="Registrar" && urltab == "botonera") || (devuelve_boton(param)=="Modificar" && urltab == "botonera")){
	if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
		alert('Ingrese el nombre del botón')
		permitido=false;
	}else if(valor.replace(/^\s+|\s+$/gi,"").length<=4){ //para no permitir que se queda en blanco
		alert('El nombre del botón debe ser mayor a 4 caracteres.')
		permitido=false;
	}
	else if(valor3==0){
		alert('Debe seleccionar una acción')
		permitido=false;
	}	
}
	
if(devuelve_boton(param)=="Desactivar" && urltab == "botonera"){
    if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
		alert('Debe consultar antes desactivar')
		permitido=false;
		return false;
	}	
	
	if(!confirm("Esta seguro que desea desactivar este registro"))
	 return false
}


	if(permitido==true && urltab =="botonera"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
}
