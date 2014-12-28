$(document).ready(init);
function init(){
	//Función que procede a Completar el Documento.
	$('#accion_completar').click(function(){
		accionDocumento('CO');
	})
	//Función que procede a Cerrar el Documento.
	$('#accion_cerrar').click(function(){
		accionDocumento('CL');
	})
	//Función que procede a Anular el Documento.
	$('#accion_anular').click(function(){
		accionDocumento('VO');
	})
	//Función que procede a cambiar el estatus del Documento según la acción correspondiente
	function accionDocumento(estatus){
		var Datos = {"operacion":"CambiarEstatus","estatus":estatus,"nid_devolucion":$('#nid_devolucion').val()};
		if(estatus=="VO"){
			alertDGC(document.getElementById('Anular'),'./menu_principal.php?devolucioncliente');
            //buscarInfo($('#ci_'+$(this).attr('name')).val());
		}
		else{
			$.ajax({
		        url: '../controladores/control_devolucion.php',
		        type: 'POST',
		        async: true,
		        data: Datos,
		        dataType: "json",
		        success: function(resp){
		        	alert(resp[0].msj)
		        },
		        error: function(){
		        	alert('¡Error al procesar la petición!')
		        }
	        });
		}
	}
	//Funcion que procede a comprobar el Estatus del Documento
	function comprobarEstatus(){
		if($('#nid_devolucion').val()!="" && document.getElementById('1').disabled==true){
			$('#nid_devolucion').removeAttr("disabled");
			var Datos = {"operacion":"BuscarEstatus","nid_devolucion":$('#nid_devolucion').val()}
			$.ajax({
		        url: '../controladores/control_devolucion.php',
		        type: 'POST',
		        async: true,
		        data: Datos,
		        dataType: "json",
		        success: function(resp){
		        	if(resp[0].estatus=="CO" || resp[0].estatus=="CL" || resp[0].estatus=="VO"){
		        		$('#cestado_devolucion').val(resp[0].estatus);
		        		$('#form1').find('input[type=text],input[type=radio],input[type=checkbox],textarea,select').attr('disabled','disabled');
		        		$('#form2').find('input[type=text],input[type=radio],input[type=checkbox],textarea,select').attr('disabled','disabled');
		        	}
		        },
		        error: function(){
		        	alert('¡Error al procesar la petición!')
		        }
	        });
		}else{
			$('#form1').find('input[type=text],input[type=radio],input[type=checkbox],input[type=hidden],textarea,select').removeAttr("disabled");
		    $('#form2').find('input[type=text],input[type=radio],input[type=checkbox],input[type=hidden],textarea,select').removeAttr("disabled");
		}
	}
	//Ejecuta la función que comprueba el estado del documento cada 1s
	setInterval(comprobarEstatus,1000)

	$('#tab-lineadevolucionc').click(function(){
		if($('#nid_devolucion').val()==""){
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
	valor0=document.getElementById('nid_devolucion').value;
	valor1=document.getElementById('nnro_devolucion').value;
	valor2=document.getElementById('nid_tipodocumento').value;
	valor3=document.getElementById('dfecha_devolucion').value;
	valor4=document.getElementById('nid_documento').value;
    //pestaña 2
    valor5=document.getElementById('nid_detalledevolucion').value;
	valor6=document.getElementById('nid_motivodevolucion').value;
    valor7=document.getElementById('cid_articulo').value;
	valor8=document.getElementById('ncantidad_articulo').value;

	if((devuelve_boton(param)=="Registrar" && urltab == "devolucionc") || (devuelve_boton(param)=="Modificar" && urltab == "devolucionc")){
		if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el nro de la órden de la devolución')
			permitido=false;
		}else if(valor2==0){ //para no permitir que se quede en blanco
			alert('Seleccione el tipo de documento')
			permitido=false;
		}else if(valor3.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Seleccione la fecha de la órden de la devolución')
			permitido=false;
		}else if(valor4==0){ //para no permitir que se quede en blanco
			alert('Seleccione el Nro. de la órden de venta')
			permitido=false;
		}
	}
     
	if((devuelve_boton(param)=="Registrar" && urltab == "lineadevolucionc") || (devuelve_boton(param)=="Modificar" && urltab == "lineadevolucionc")){
		if(valor7==0){ //para no permitir que se quede en blanco
			alert('Seleccione un artículo')
			permitido=false;
		}else if(valor8.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la cantidad de artículos')
			permitido=false;
		}
	}

	if(devuelve_boton(param)=="Desactivar" && urltab == "devolucionc"){
		if(valor0.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes de desactivar')
			permitido=false;
			return false;
		}
	    if(!confirm("Esta seguro que desea desactivar este registro"))
	     return false
	}

	if(devuelve_boton(param)=="Desactivar" && urltab == "lineadevolucionc"){
		if(valor5.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes de desactivar')
			permitido=false;
			return false;
		}
	    if(!confirm("Esta seguro que desea desactivar este registro"))
	     return false
	}

	if(permitido==true && urltab =="devolucionc"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
	else if(permitido==true && urltab =="lineadevolucionc"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form2").submit();
	}
}
