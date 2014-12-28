$(document).ready(init);
function init(){
	$('#tab-estado').click(function(){
		if($(location).attr('search')!="?localidad" && $(location).attr('hash')!="#pais"){
			return true;
		}
		else{
			if($('#nid_pais').val()==""){
				alert('Debe seleccionar un registro para continuar!');
				return false;
			}
			else{
				return true;
			}
		}
	});
	/*$('#tab-ciudad').click(function(){
		if($(location).attr('search')!="?localidad" && $(location).attr('hash')!="#pais" && $(location).attr('hash')!="#estado"){
			return true;
		}
		else{
			if($('#nid_estado').val()==""){
				alert('Debe seleccionar un registro para continuar!');
				return false;
			}
			else{
				return true;
			}
		}
	});*/
	$('#tab-municipio').click(function(){
		if($(location).attr('search')!="?localidad" && $(location).attr('hash')!="#pais" && $(location).attr('hash')!="#estado" && $(location).attr('hash')!="#ciudad"){
			return true;
		}
		else{
			if($('#nid_ciudad').val()==""){
				alert('Debe seleccionar un registro para continuar!');
				return false;
			}
			else{
				return true;
			}
		}
	});
	$('#tab-parroquia').click(function(){
		if($('#nid_municipio').val()==""){
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
	valor=document.getElementById('nid_pais').value;
	valor2=document.getElementById('cnombrepais').value;
	//campos pestaña 2
	valor3=document.getElementById('nid_estado').value;
	valor4=document.getElementById('cnombreestado').value;
	//campos pestaña 3
	/*valor5=document.getElementById('nid_ciudad').value;
	valor6=document.getElementById('cnombreciudad').value;*/
	//campos pestaña 4
	valor7=document.getElementById('nid_municipio').value;
	valor8=document.getElementById('cnombremunicipio').value;
	//campos pestaña 5
	valor9=document.getElementById('nid_parroquia').value;
	valor10=document.getElementById('cnombreparroquia').value;
	//Validar campos antes de insertar o modificar por pestañas.
	if((devuelve_boton(param)=="Registrar" && urltab == "pais") || (devuelve_boton(param)=="Modificar" && urltab == "pais")){
		if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el nombre del País.')
			permitido=false;
		}else if(valor2.replace(/^\s+|\s+$/gi,"").length<=3){ //para no permitir que se quede en blanco
			alert('El nombre del País debe ser mayor a 3 caracteres.')
			permitido=false;
		}
	}
	if((devuelve_boton(param)=="Registrar" && urltab == "estado") || (devuelve_boton(param)=="Modificar" && urltab == "estado")){
		if(valor4.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el nombre del Estado.')
			permitido=false;
		}else if(valor4.replace(/^\s+|\s+$/gi,"").length<=3){ //para no permitir que se quede en blanco
			alert('El nombre del Estado debe ser mayor a 3 caracteres.')
			permitido=false;
		}
	}
	/*if((devuelve_boton(param)=="Registrar" && urltab == "ciudad") || (devuelve_boton(param)=="Modificar" && urltab == "ciudad")){
		if(valor6.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el nombre de la Ciudad.')
			permitido=false;
		}else if(valor6.replace(/^\s+|\s+$/gi,"").length<=3){ //para no permitir que se quede en blanco
			alert('El nombre de la Ciudad debe ser mayor a 3 caracteres.')
			permitido=false;
		}
	}*/
	if((devuelve_boton(param)=="Registrar" && urltab == "municipio") || (devuelve_boton(param)=="Modificar" && urltab == "municipio")){
		if(valor8.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el nombre del Municipio.')
			permitido=false;
		}else if(valor8.replace(/^\s+|\s+$/gi,"").length<=3){ //para no permitir que se quede en blanco
			alert('El nombre del Municipio debe ser mayor a 3 caracteres.')
			permitido=false;
		}
	}
	if((devuelve_boton(param)=="Registrar" && urltab == "parroquia") || (devuelve_boton(param)=="Modificar" && urltab == "parroquia")){
		if(valor10.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el nombre de la Parroquia.')
			permitido=false;
		}else if(valor10.replace(/^\s+|\s+$/gi,"").length<=3){ //para no permitir que se quede en blanco
			alert('El nombre de la Parroquia debe ser mayor a 3 caracteres.')
			permitido=false;
		}
	}
	//Validar antes de desactivar un registro por pestaña.
	if(devuelve_boton(param)=="Desactivar" && urltab == "pais"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar.')
			permitido=false;
			return false;
		}
		if(!confirm("Esta seguro que desea desactivar este registro."))
			return false;
	}
	if(devuelve_boton(param)=="Desactivar" && urltab == "estado"){
		if(valor3.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}
		if(!confirm("Esta seguro que desea desactivar este registro."))
			return false;
	}
	/*if(devuelve_boton(param)=="Desactivar" && urltab == "ciudad"){
		if(valor5.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}
		if(!confirm("Esta seguro que desea desactivar este registro."))
			return false;
	}*/
	if(devuelve_boton(param)=="Desactivar" && urltab == "municipio"){
		if(valor7.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}
		if(!confirm("Esta seguro que desea desactivar este registro."))
			return false;
	}
	if(devuelve_boton(param)=="Desactivar" && urltab == "parroquia"){
		if(valor9.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}
		if(!confirm("Esta seguro que desea desactivar este registro."))
			return false;
	}
	//Enviar Formulario por pestañas.
	if(permitido==true && urltab =="pais"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
	else if(permitido==true && urltab =="estado"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form2").submit();
	}
	/*else if(permitido==true && urltab =="ciudad"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form3").submit();
	}*/
	else if(permitido==true && urltab =="municipio"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form4").submit();
	}
	else if(permitido==true && urltab =="parroquia"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form5").submit();
	}
}