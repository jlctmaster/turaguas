$(document).ready(init);
function init(){
	$('#cid_articulo').change(function(){
		var Datos = {"operacion":"BuscarConfiguracion","cid_articulo":$('#cid_articulo').val()};
		BuscarConfiguracion(Datos);
	})

	$('#ncantidad_a_producir').change(function(){
		var valor = parseFloat($('#ncantidad_a_producir').val());
		var maximo = parseFloat($('#ncantidad_max').val());
		if(valor<=maximo){
			var Datos = {"operacion":"BuscarConfiguracionPorDisponibilidad","cid_articulo":$('#cid_articulo').val(),"ncantidad_a_producir":$('#ncantidad_a_producir').val()};
			BuscarConfiguracion(Datos);
		}else{
			alert('La cantidad a producir no puede ser mayor a: '+$('#ncantidad_max').val()+', la cual es la cantidad máxima disponible para producir')
		}
	})

	function BuscarConfiguracion(value){
		$.ajax({
	        url: '../controladores/control_produccion.php',
	        type: 'POST',
	        async: true,
	        data: value,
	        dataType: "json",
	        success: function(resp){
	        	$('#ncantidad_max').val(resp[0].cantidad_disponible);
	        	$('#ncantidad_a_producir').val(resp[0].cant_disp_a_usar);
	        	for(var contador=0;contador<resp.length;contador++){
	        		$('tr[id="'+contador+'"]').remove();
	        	}
	        	for(var contador=0;contador<resp.length;contador++){
	        		linea = contador+parseInt(1);
	        		$("#TablaInsumos").append("<tr id='"+contador+"'>"+
	    			"<td>"+
	    				"<input type='hidden' name='linea[]' id='linea_'"+contador+" value='"+linea+"' />"+
						"<input type='hidden' name='insumo[]' id='insumo_"+contador+"' value='"+resp[contador].cid_insumo+"' />"+
						"<input type='text' name='descrip_insumo[]' id='descrip_insumo_"+contador+"' title='Insumo necesario para producir el artículo seleccionado' value='"+resp[contador].articulo+"' readonly />"+
					"</td>"+
					"<td>"+
	                    "<input class='campo_tabla' type='text' name='cantidad[]' id='cantidad_"+contador+"' size='50' value='"+resp[contador].cant_a_usar+"' readonly />&nbsp;<span>"+resp[contador].csimbolo+"</span>"+
	                "</td>"+
					"<td>"+
	                    "<input class='campo_tabla' type='text' name='total[]' id='total_"+contador+"' size='50' value='"+resp[contador].total_a_usar+"' readonly />&nbsp;<span>"+resp[contador].presentacion+"</span>"+
	                "</td>"+
	                "</tr>");
	        	}
	        },
	        error: function(jqXHR, textStatus, errorThrown){
	        	alert('¡Error al procesar la petición! '+textStatus+' '+errorThrown)
	        }
        });
	}
}

function validar_formulario(param,urltab){
	//para validar en caso que no return false
	permitido=true;
	//campos pestaña 1
	valor=document.getElementById('nnro_produccion').value;
	valor2=document.getElementById('dfecha_documento').value;
	valor3=document.getElementById('cid_articulo').value;
	valor4=document.getElementById('ncantidad_a_producir').value;
	
	//Validar campos antes de insertar o modificar por pestañas.
	if(devuelve_boton(param)=="Registrar" && urltab == "produccion"){
		if(valor.replace(/^\s+|\s+$/gi,"").length>0){ //para no permitir que se quede en blanco
			alert('El Nro. de Producción es generado por el sistema, favor ingrese el Nro de Producción solo cuando vaya a consultar.')
			permitido=false;
		}
		else if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la fecha de la Producción')
			permitido=false;
		}
		else if(valor3==0){
			alert('Seleccione un artículo')
			permitido=false;
		}
		else if(valor4<=0){
			alert('La cantidad a producir debe ser mayor a 0')
			permitido=false;
		}
	}
	
	//Validar campos antes de insertar o modificar por pestañas.
	if(devuelve_boton(param)=="Modificar" && urltab == "produccion"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el Nro. de Producción')
			permitido=false;
		}
		else if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la fecha de la Producción')
			permitido=false;
		}
		else if(valor3==0){
			alert('Seleccione un artículo')
			permitido=false;
		}
		else if(valor4<=0){
			alert('La cantidad a producir debe ser mayor a 0')
			permitido=false;
		}
	}
	
	//Validar antes de desactivar un registro por pestaña.
	if(devuelve_boton(param)=="Desactivar" && urltab == "produccion"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}
		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false;
	}
	//Enviar Formulario por pestañas.
	if(permitido==true && urltab =="produccion"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form").submit();
	}
}