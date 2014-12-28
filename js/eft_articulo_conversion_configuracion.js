$(document).ready(init);
function init(){
	$('#tab-conversion').click(function(){
		if($('#cid_articulo').val()==""){
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

	$('#nid_presentacion').change(function(){
		var Datos = {"operacion":"AsignarNombre","nid_categoria":$('#nid_categoria').val(),
		"nid_marca":$('#nid_marca').val(),"nid_presentacion":$('#nid_presentacion').val()};
		AsignarNombreProducto(Datos);
	});

	function AsignarNombreProducto(value){
		$.ajax({
	        url: '../controladores/control_articulo.php',
	        type: 'POST',
	        async: true,
	        data: value,
	        dataType: "json",
	        success: function(resp){
	        	$('#cdescripcionarticulo').val(resp[0].nombre);
	        },
	        error: function(jqXHR, textStatus, errorThrown){
	        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
	        }
        });
	}

	$('#cid_insumo').change(function(){
		var Datos = {"operacion": "BuscarUM","filtro":$('#cid_insumo').val()};
		BuscarUM(Datos);
	});

	function BuscarUM(value){
		$.ajax({
	        url: '../controladores/control_configuracion_articulo.php',
	        type: 'POST',
	        async: true,
	        data: value,
	        dataType: "json",
	        success: function(resp){
	        	$('#UMC').text(resp[0].simbolo);
	        	$('#UMM').text(resp[0].simbolo);
	        },
	        error: function(jqXHR, textStatus, errorThrown){
	        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
	        }
        });
	}
}

function validar_formulario(param,urltab){
	//para validar en caso que no return false
	permitido=true;
	//campos pestaña 1
	valor=document.getElementById('cdescripcionarticulo').value;
	valor2=document.getElementById('cid_articulo').value;
	valor3=document.getElementById('nid_tipoarticulo').value;
	valor4=document.getElementById('nid_presentacion').value;
	valor5=document.getElementById('nid_categoria').value;
	valor7=document.getElementById('nid_marca').value;
	valor8=document.getElementById('ncantidad_min').value;
	valor9=document.getElementById('ncantidad_max').value;
	valor10=document.getElementById('nid_impuesto').value;
	//campos pestaña 2
    valor11=document.getElementById('cid_articulo').value;
    valor12=document.getElementById('nid_um_conversion').value;
    valor13=document.getElementById('nid_unidadmedida').value;
    valor14=document.getElementById('nid_um_hasta').value;
    valor15=document.getElementById('nfactor_multiplicador').value;
    valor16=document.getElementById('nfactor_divisor').value;
    //campo pestaña 3
    valor17=document.getElementById('nid_configuracion_articulo').value;
    valor18=document.getElementById('cid_insumo').value;
    valor20=document.getElementById('cid_articulo').value;
	if((devuelve_boton(param)=="Registrar" && urltab == "articulo") || (devuelve_boton(param)=="Modificar" && urltab == "articulo")){
		if (valor2.replace(/^\s+|\s+$/gi,"").length==0){
			alert('Ingrese el código del artículo')
			permitido=false;
		}
		else if(valor3==0){ //para no permitir que se queda en blanco
		alert('Seleccione el tipo de artículo')
		permitido=false;
		}
		else if (valor4==0){ //para no permitir que se queda en blanco
		alert('Seleccione la presentación')
		permitido=false;
		}
		else if(valor5==0){ //para no permitir que se queda en blanco
		alert('Seleccione la categoría')
		permitido=false;
		}
		else if(valor8.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
		alert('Ingrese la cantidad mínima del artículo')
		permitido=false;
		}
		else  if(valor9.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
		alert('Ingrese la cantidad máxima del artículo')
		permitido=false;
		}else if(valor10==0){ //para no permitir que se queda en blanco
		alert('Seleccione el impuesto')
		permitido=false;
		}else if ((parseInt(valor8)+100)>parseInt(valor9))
		{
			alert('Cantidad mínima no puede ser mayor a la cantidad máxima debe haber por lo menos una diferencia de 100')
			permitido=false;
		}
	}
	
	if((devuelve_boton(param)=="Registrar" && urltab == "conversion") || (devuelve_boton(param)=="Modificar" && urltab == "conversion")){
		if(valor13==0){ //para no permitir que se queda en blanco
		alert('Seleccione unidad de medida desde')
		permitido=false;
		}else if(valor14==0){ //para no permitir que se queda en blanco
		alert('Seleccione la unidad de medida hasta')
		permitido=false;
		}
		else if(valor15.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
		alert('Ingrese el factor multiplicador')
		permitido=false;
		}
		else  if(valor16.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
		alert('Ingrese el factor divisor')
		permitido=false;
		}
	}

	if((devuelve_boton(param)=="Registrar" && urltab == "configuracion_articulo") || (devuelve_boton(param)=="Modificar" && urltab == "configuracion_articulo")){
		if(valor18==0){ //para no permitir que se queda en blanco
		alert('Seleccione el insumo')
		permitido=false;
		}
	}
	if(devuelve_boton(param)=="Desactivar" && urltab == "articulo"){
		if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}	

		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false;
	}

	if(devuelve_boton(param)=="Desactivar" && urltab == "conversion"){
		if(valor11.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}	

		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false;
	}

	if(devuelve_boton(param)=="Desactivar" && urltab == "configuracion_articulo"){
		if(valor17==0){ //para no permitir que se queda en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}	

		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false;
	}

	if(permitido==true && urltab =="articulo"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
	else if(permitido==true && urltab =="conversion"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form2").submit();
	}
	else if(permitido==true && urltab =="configuracion_articulo"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form3").submit();
	}
}