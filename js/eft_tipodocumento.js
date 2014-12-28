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
	valor=document.getElementById('cdescripcion').value;
	valor2=document.getElementById('nid_tipodocumento').value;
	valor3=document.getElementById('nfactor').value;
	if((devuelve_boton(param)=="Registrar" && urltab == "tipodocumento") || (devuelve_boton(param)=="Modificar"&& urltab == "tipodocumento")){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese el Tipo de Documento')
			permitido=false;
		}else if(valor.replace(/^\s+|\s+$/gi,"").length<5){ 
			alert('El Tipo de Documento debe tener un mínimo de 5 caracteres')
			permitido=false;	
		}else if(valor3==0){
			alert('Seleccione un factor')
			permitido=false;
		}
	}
	
	if(devuelve_boton(param)=="Consultar"  && urltab == "tipodocumento"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese el Tipo de Documento')
			permitido=false;
			}
	}

	if(devuelve_boton(param)=="Desactivar" && urltab == "tipodocumento"){
		if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('consultar antes de desactivar')
			permitido=false;
			return false;
		}
	    if(!confirm("Esta seguro que desea desactivar este registro"))
	     return false
	}

	
	if(permitido==true && urltab =="tipodocumento"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
}