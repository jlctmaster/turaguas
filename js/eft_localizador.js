$(document).ready(init);
function init(){
	$('#tab-almacen').click(function(){
		if($('#nid_ubicacion').val()==""){
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
	valor0=document.getElementById('nid_ubicacion').value;
	valor1=document.getElementById('cdescripcion').value;
    valor2=document.getElementById('cpunto_referencia').value;
    //pestaña 2
    valor3=document.getElementById('nid_almacen').value;
	valor4=document.getElementById('cdescripcionalmacen').value;

	if((devuelve_boton(param)=="Registrar" && urltab == "ubicacion") || (devuelve_boton(param)=="Modificar" && urltab == "ubicacion")){
		if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el nombre de la ubicación')
			permitido=false;
		}
        else if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese un punto de referencia')
			permitido=false;
		}
	}
	if((devuelve_boton(param)=="Registrar" && urltab == "almacen") || (devuelve_boton(param)=="Modificar" && urltab == "almacen")){
			if(valor4.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
				alert('Ingrese el nombre del almacén')
				permitido=false;
			}
	}
	if(devuelve_boton(param)=="Desactivar" && urltab == "ubicacion"){
		if(valor0.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes de desactivar')
			permitido=false;
			return false;
		}
	    if(!confirm("Esta seguro que desea desactivar este registro"))
	     return false
	}


	if(devuelve_boton(param)=="Desactivar" && urltab == "almacen"){
		if(valor3.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes de desactivar')
			permitido=false;
			return false;
		}
	    if(!confirm("Esta seguro que desea desactivar este registro"))
	     return false
	}

	if(permitido==true && urltab =="ubicacion"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
	else if(permitido==true && urltab =="almacen"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form2").submit();
	}
}
