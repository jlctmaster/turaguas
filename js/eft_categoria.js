$(document).ready(init);
function init(){
	$('#tab-subcategoria').click(function(){
		if($('#nid_categoria').val()==""){
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
	valor=document.getElementById('cdescripcionc').value;
	valor2=document.getElementById('nid_categoria').value;
	//campos pestaña 2
	valor3=document.getElementById('cdescripcions').value;
	valor4=document.getElementById('nid_categoria_sub').value;
	valor5=document.getElementById('nid_categoria_padre').value;
	if((devuelve_boton(param)=="Registrar" && urltab == "categoria") || (devuelve_boton(param)=="Modificar" && urltab == "categoria")){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese la descripción de la categoría')
			permitido=false;
		}
	}

	if((devuelve_boton(param)=="Registrar" && urltab == "subcategoria") || (devuelve_boton(param)=="Modificar" && urltab == "subcategoria")){
		if(valor3.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese la descripción de la subcategoría')
			permitido=false;
		}
	}
		
	if(devuelve_boton(param)=="Desactivar" && urltab == "categoria"){
		if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}	

		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false;
	}

	if(devuelve_boton(param)=="Desactivar" && urltab == "subcategoria"){
		if(valor4.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}	

		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false;
	}

	if(permitido==true && urltab =="categoria"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
	else if(permitido==true && urltab =="subcategoria"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form2").submit();
	}
}