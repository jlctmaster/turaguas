$(document).ready(init);
function init(){
	$('#tab-motivodev').click(function(){
		if($('#nid_motivodevolucion').val()==""){
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
	//para validar en caso q no return false
	permitido=true;
	//pestaña 1
	valor0=document.getElementById('nid_motivodevolucion').value;
	valor1=document.getElementById('cdescripcion').value;
    //pestaña 2
    valor3=document.getElementById('nid_motivodevolucion_padre').value;
	valor4=document.getElementById('cdescripcionmotivo').value;

	if((devuelve_boton(param)=="Registrar" && urltab == "grupo") || (devuelve_boton(param)=="Modificar" && urltab == "grupo")){
		if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la descripción del grupo de motivo')
			permitido=false;
		}
	}
     
if((devuelve_boton(param)=="Registrar" && urltab == "motivodev") || (devuelve_boton(param)=="Modificar" && urltab == "motivodev")){
		if(valor4.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la descripción del motivo')
			permitido=false;
		}
}
	if(devuelve_boton(param)=="Desactivar" && urltab == "grupo"){
		if(valor0.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes de desactivar')
			permitido=false;
			return false;
		}
	    if(!confirm("Esta seguro que desea desactivar este registro"))
	     return false
	}


	if(devuelve_boton(param)=="Desactivar" && urltab == "motivodev"){
		if(valor3.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes de desactivar')
			permitido=false;
			return false;
		}
	    if(!confirm("Esta seguro que desea desactivar este registro"))
	     return false
	}

	if(permitido==true && urltab =="grupo"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
	else if(permitido==true && urltab =="motivodev"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form2").submit();
	}
}
