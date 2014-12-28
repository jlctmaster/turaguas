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
		var Datos = {"operacion":"CambiarEstatus","estatus":estatus,"nid_documento":$('#nid_documento').val(),"nid_motivorazon": $('#nid_motivorazon').val()};
		if(estatus=="VO"){
			alertDGC(document.getElementById('Anular'),'./menu_principal.php?ordenrecibo');
			//Función que procede a cambiar el estatus del Documento a Anular.
			$('#BtnAnular').click(function(){
				$('.dgcAlert').animate({opacity:0},50);
			    $('.dgcAlert').css('display','none');
				document.getElementById('Anular').innerHTML="";
				$.ajax({
			        url: '../controladores/control_ordenrecibo.php',
			        type: 'POST',
			        async: true,
			        data: Datos2,
			        dataType: "json",
			        success: function(resp){
			        	alert(resp[0].msj)
			        },
			        error: function(jqXHR, textStatus, errorThrown){
			        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
			        }
		        });
			})
		}
		else{
			$.ajax({
		        url: '../controladores/control_ordenrecibo.php',
		        type: 'POST',
		        async: true,
		        data: Datos,
		        dataType: "json",
		        success: function(resp){
		        	alert(resp[0].msj)
		        },
		        error: function(jqXHR, textStatus, errorThrown){
		        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
		        }
	        });
		}
	}
	//Funcion que procede a comprobar el Estatus del Documento
	function comprobarEstatus(){
		if($('#nid_documento').val()!="" && document.getElementById('1').disabled==true){
			$('#nid_documento').removeAttr("disabled");
			var Datos = {"operacion":"BuscarEstatus","nid_documento":$('#nid_documento').val()}
			$.ajax({
		        url: '../controladores/control_ordenrecibo.php',
		        type: 'POST',
		        async: true,
		        data: Datos,
		        dataType: "json",
		        success: function(resp){
		        	if(resp[0].estatus=="CO" || resp[0].estatus=="CL" || resp[0].estatus=="VO"){
		        		$('#nnro_orden').val(resp[0].nnro_orden);
		        		$('#cestado_documento').val(resp[0].estatus);
		        		$('#caccion_documento').val(resp[0].accion);
		        		if($('#cestado_documento').val()=="CO"){
		        			$('#estado_doc').val("Completado");
		        		}else if($('#cestado_documento').val()=="CL"){
		        			$('#estado_doc').val("Cerrado");
		        		}else if($('#cestado_documento').val()=="VO"){
		        			$('#estado_doc').val("Anulado");
		        		}
		        		if($('#caccion_documento').val()=="CL" || $('#caccion_documento').val()=="--"){
		        			$('#accion_completar').attr("disabled","disabled");
		        		}else{
		        			$('#accion_completar').removeAttr("disabled");
		        		}
		        		if($('#caccion_documento').val()=="CO" || $('#caccion_documento').val()=="--"){
		        			$('#accion_cerrar').attr("disabled","disabled");
		        		}else{
		        			$('#accion_cerrar').removeAttr("disabled");
		        		}
		        		if($('#caccion_documento').val()=="CO" || $('#caccion_documento').val()=="--"){
		        			$('#accion_anular').attr("disabled","disabled");
		        		}else{
		        			$('#accion_anular').removeAttr("disabled");
		        		}
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

	$('#tab-lineaordenrecibo').click(function(){
		if($('#nid_documento').val()==""){
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
	//Busquedas del proveedor por autocompletar.
	$('#crif_persona').autocomplete({
		source:'../autocompletar/proveedor.php', 
		minLength:1,
		select: function (event, ui){
			Datos={"operacion":"BuscarDatosProveedor","filtro":ui.item.value};
			BuscarDatosProveedor(Datos);
		}
	});
	//Esta comentado porque en el proceso de Compra 
	//se debe ingresar es el número del documento que facilite el proveedor
	//Buscar nro de orden.
	/*$('#nid_tipodocumento').change(function(){
		var nro_ent_orden = $('#nnro_ent_recib').val();
		if(nro_ent_orden.length==0 && $('#nid_tipodocumento').val()!=0){
			Datos = {"operacion":"BuscarNroOrden"};
			BuscarNroOrden(Datos);
		}
	})*/
	//Buscar los datos del nro de orden seleccionado.
	$('#b_nnro_orden').change(function(){
		Datos = {"operacion":"BuscarDatosNroOrden","nnro_orden": $('#b_nnro_orden').val()};
		BuscarDatosNroOrden(Datos);
	})
	//Buscar precios del producto seleccionado
	$('#cid_articulo').change(function(){
		Datos = {"operacion":"BuscarPrecio","filtro":$('#cid_articulo').val()};
		BuscarPrecioLista(Datos);
	})
	//Buscar porcentaje de impuesto
	$('#nid_impuesto').change(function(){
		Datos = {"operacion":"BuscarImpuesto","filtro":$('#nid_impuesto').val()};
		BuscarImpuesto(Datos);
	})
	//Calcular Montos según cantidad de artículos cuando se cambia la cantidad
	$('#ncantidad_articulo').change(function(){
		var cantidad = parseFloat($('#ncantidad_articulo').val());
		var precio = parseFloat($('#nprecio').val());
		var por_descuento = parseFloat($('#ndescuento').val()/100);
		var por_iva = parseFloat($('#nimpuesto').val()/100);
		var total_linea = cantidad*precio;
		var descuento = total_linea*por_descuento;
		var iva = total_linea*por_iva;
		$('#nmontoneto').val(total_linea);
		$('#nmontodescuento').val(descuento);
		$('#nmontoimpuesto').val(iva);
	})
	//Calcular Montos según cantidad de artículos cuando se cambia el precio
	$('#nprecio').change(function(){
		var cantidad = parseFloat($('#ncantidad_articulo').val());
		var precio = parseFloat($('#nprecio').val());
		var por_descuento = parseFloat($('#ndescuento').val()/100);
		var por_iva = parseFloat($('#nimpuesto').val()/100);
		var total_linea = cantidad*precio;
		var descuento = total_linea*por_descuento;
		var iva = total_linea*por_iva;
		$('#nmontoneto').val(total_linea);
		$('#nmontodescuento').val(descuento);
		$('#nmontoimpuesto').val(iva);
	})
    //Busca el siguente número de órden disponible.
    function BuscarNroOrden(value){
        $.ajax({
        url: '../controladores/control_ordenrecibo.php',
        type: 'POST',
        async: true,
        data: value,
        dataType: "json",
        success: function(resp){
        	var numero = resp[0].nnro_orden;
        	if(numero!=""){
	        	if(numero.length<10){
	        		while(numero.length<10){
	        			numero="0"+numero;
	        		}
	        	}
        	}else{
        		numero="0000000001";
        	}
        	$('#nnro_orden').val(numero);
        },
        error: function(resp){
        	alert('Error al procesar la petición')
        }
        });
    }
    //Busca los datos del número de órden seleccionado.
    function BuscarDatosNroOrden(value){
        $.ajax({
        url: '../controladores/control_ordenrecibo.php',
        type: 'POST',
        async: true,
        data: value,
        dataType: "json",
        success: function(resp){
        	$('#dfecha_documento').val(resp[0].dfecha_documento);
        	$('#crif_persona').val(resp[0].crif_persona);
        	$('#cnombreproveedor').val(resp[0].cnombre);
        	$('#cdireccionproveedor').val(resp[0].cdireccion);
        	$('#nid_condicionpago').val(resp[0].nid_condicionpago);
        	$('#nid_almacen').val(resp[0].nid_almacen);
        	$('#nmonto_base').val(resp[0].nmonto_base);
        	$('#nmonto_total').val(resp[0].nmonto_total);
        	$("#dfecha_ent_recib").datepicker("option", "minDate", resp[0].dfecha_documento)
        },
        error: function(resp){
        	alert('Error al procesar la petición')
        }
        });
    }
    //Busca los datos de la lista de precios según el articulo seleccionado
    function BuscarPrecioLista(value){
        $.ajax({
        url: '../controladores/control_lineaordenrecibo.php',
        type: 'POST',
        async: true,
        data: value,
        dataType: "json",
        success: function(resp){
        	$('#nprecio').val(resp[0].nprecio);
        	$('#npreciolista').val(resp[0].nprecio);
        	$('#npreciolimite').val(resp[0].nprecio_limite);
        	$('#ndescuento').val(resp[0].ndescuento);
        	$('#nid_impuesto').val(resp[0].nid_impuesto);
        	$('#nimpuesto').val(resp[0].nporcentaje);
        },
        error: function(resp){
        	alert('Error al procesar la petición')
        }
        });
    }
    //Busca el porcentaje del impuesto según el valor seleccionado
    function BuscarImpuesto(value){
        $.ajax({
        url: '../controladores/control_lineaordenrecibo.php',
        type: 'POST',
        async: true,
        data: value,
        dataType: "json",
        success: function(resp){
        	$('#nimpuesto').val(resp[0].nporcentaje);
        },
        error: function(resp){
        	alert('Error al procesar la petición')
        }
        });
    }

    //Busca los Datos del Proveedor seleccionado.
    function BuscarDatosProveedor(value){
        $.ajax({
        url: '../controladores/control_ordenrecibo.php',
        type: 'POST',
        async: true,
        data: value,
        dataType: "json",
        success: function(resp){
        	$('#cnombreproveedor').val(resp[0].cnombre);
        	$('#cdireccionproveedor').val(resp[0].cdireccion);
        	$('#nid_condicionpago').val(resp[0].nid_condicionpago);
        },
        error: function(resp){
        	alert('Error al procesar la petición')
        }
        });
    }
}

function validar_formulario(param,urltab){
	//para validar en caso q no return false
	permitido=true;
	//pestaña 1
	valor0=document.getElementById('nid_documento').value;
	valor1=document.getElementById('nnro_ent_recib').value;
	valor2=document.getElementById('nid_tipodocumento').value;
	valor3=document.getElementById('dfecha_ent_recib').value;
	valor4=document.getElementById('crif_persona').value;
	valor5=document.getElementById('nid_condicionpago').value;
	valor6=document.getElementById('nid_almacen').value;
    //pestaña 2
    valor7=document.getElementById('nid_detalledocumento').value;
	valor8=document.getElementById('nlinea').value;
    valor9=document.getElementById('cid_articulo').value;
	valor10=document.getElementById('ncantidad_articulo').value;
    valor11=document.getElementById('nid_impuesto').value;
	valor12=document.getElementById('nprecio').value;

	if((devuelve_boton(param)=="Registrar" && urltab == "ordenrecibo") || (devuelve_boton(param)=="Modificar" && urltab == "ordenrecibo")){
		if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el nro de la órden de recíbo')
			permitido=false;
		}else if(valor2==0){ //para no permitir que se quede en blanco
			alert('Seleccione el tipo de documento')
			permitido=false;
		}else if(valor3.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Seleccione la fecha de la órden de recíbo')
			permitido=false;
		}else if(valor4.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Seleccione al proveedor')
			permitido=false;
		}else if(valor5==0){ //para no permitir que se quede en blanco
			alert('Seleccione una condición de pago')
			permitido=false;
		}else if(valor6==0){ //para no permitir que se quede en blanco
			alert('Seleccione un almacén')
			permitido=false;
		}
	}
     
	if((devuelve_boton(param)=="Registrar" && urltab == "lineaordenrecibo") || (devuelve_boton(param)=="Modificar" && urltab == "lineaordenrecibo")){
		if(valor8.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la línea de la orden de recíbo')
			permitido=false;
		}else if(valor9==0){ //para no permitir que se quede en blanco
			alert('Seleccione un artículo')
			permitido=false;
		}else if(valor10.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la cantidad de artículos')
			permitido=false;
		}else if(valor11==0){ //para no permitir que se quede en blanco
			alert('Seleccione un impuesto')
			permitido=false;
		}else if(valor12.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el precio a facturar el artículo')
			permitido=false;
		}
	}

	if(devuelve_boton(param)=="Desactivar" && urltab == "ordenrecibo"){
		if(valor0.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes de desactivar')
			permitido=false;
			return false;
		}
	    if(!confirm("Esta seguro que desea desactivar este registro"))
	     return false
	}

	if(devuelve_boton(param)=="Desactivar" && urltab == "lineaordenrecibo"){
		if(valor7.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes de desactivar')
			permitido=false;
			return false;
		}
	    if(!confirm("Esta seguro que desea desactivar este registro"))
	     return false
	}

	if(permitido==true && urltab =="ordenrecibo"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
	else if(permitido==true && urltab =="lineaordenrecibo"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form2").submit();
	}
}
