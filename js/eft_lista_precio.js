$(document).ready(init);
function init(){
	$('#tab-linea').click(function(){
		if($('#nid_listaprecio').val()==""){
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
	valor=document.getElementById('cdescripcionlistaprecio').value;
	valor2=document.getElementById('nid_listaprecio').value;
	valor3=document.getElementById('dvigencia_desde').value;
	valor4=document.getElementById('dvigencia_hasta').value;
	//campos pestaña 2
	valor5=document.getElementById('nid_detallelistaprecio').value;
	valor6=document.getElementById('nid_listaprecio').value;
	valor7=document.getElementById('cid_articulo').value;
	valor8=document.getElementById('nprecio').value;
	valor9=document.getElementById('nprecio_limite').value;
	valor10=document.getElementById('ndescuento').value;
	
	if((devuelve_boton(param)=="Registrar" && urltab == "listaprecio") || (devuelve_boton(param)=="Modificar" && urltab == "listaprecio")){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese la descripción del tipo de persona')
			permitido=false;
		}else if(valor3==""){
			alert('Ingrese la fecha de vigenvia desde')
			permitido=false;
		}else if(valor4==""){
			alert('Ingrese la fecha de vigenvia hasta')
			permitido=false;
		}
	}

	if((devuelve_boton(param)=="Registrar" && urltab == "linea") || (devuelve_boton(param)=="Modificar" && urltab == "linea")){
		if(valor6.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese la lista de precio')
			permitido=false;
		}else if(valor7==0){
			alert('Seleccione el artículo')
			permitido=false;
		}else if(valor8.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese el precio')
			permitido=false;
		}else if(valor9.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese el precio límite')
			permitido=false;
		}else if(valor10.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('Ingrese el descuento')
			permitido=false;
		}
	}
		
	if(devuelve_boton(param)=="Desactivar" && urltab == "listaprecio"){
		if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}	

		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false;
	}

	if(devuelve_boton(param)=="Desactivar" && urltab == "linea"){
		if(valor5.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}	

		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false;
	}

	if(permitido==true && urltab =="listaprecio"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
	else if(permitido==true && urltab =="linea"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form2").submit();
	}
}