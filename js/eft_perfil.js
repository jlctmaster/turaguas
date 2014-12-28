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
	valor=document.getElementById('cnombreperfil').value;
	valor2=document.getElementById('nid_perfil').value;
	valor3=document.getElementById('nid_configuracion').value;
	if((devuelve_boton(param)=="Registrar" && urltab == "perfiles") || (devuelve_boton(param)=="Modificar" && urltab == "perfiles")){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese el perfil')
			permitido=false;
		}
		else if(valor3=="0"){
			alert('Seleccione una configuración')
			permitido=false;
		}
	}
		
	if(devuelve_boton(param)=="Desactivar" && urltab == "perfiles"){
		if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}
	    if(!confirm("Esta seguro que desea desactivar este registro"))
	     return false
	}

	if(permitido==true && urltab =="perfiles"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
}