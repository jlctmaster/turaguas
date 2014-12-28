$(document).ready(init);
function init(){
	//Busquedas del cliente por autocompletar.
	$('#crif_persona').autocomplete({
		source:'../autocompletar/cliente.php', 
		minLength:1,
		select: function (event, ui){
			Datos={"operacion":"BuscarDatosCliente","filtro":ui.item.value};
			BuscarDatosCliente(Datos);
		}
	});
	//Buscar los datos del nro de orden seleccionado.
	$('#nnro_cotizacion').change(function(){
		Datos = {"operacion":"BuscarDatosNroCotizacion","nnro_cotizacion": $('#nnro_cotizacion').val()};
		BuscarDatosNroCotizacion(Datos);
	})
    //Busca los Datos del Cliente seleccionado.
    function BuscarDatosCliente(value){
        $.ajax({
        url: '../controladores/control_notaentrega.php',
        type: 'POST',
        async: true,
        data: value,
        dataType: "json",
        success: function(resp){
        	$('#cnombrecliente').val(resp[0].cnombre);
        	$('#nid_condicionpago').val(resp[0].nid_condicionpago);
        },
        error: function(resp){
        	alert('Error al procesar la petición')
        }
        });
    }
    //Busca los datos del número de cotizacion seleccionado.
    function BuscarDatosNroCotizacion(value){
        $.ajax({
        url: '../controladores/control_notaentrega.php',
        type: 'POST',
        async: true,
        data: value,
        dataType: "json",
        success: function(resp){
        	$('#dfecha_documento_sc').val(resp[0].dfecha_documento);
        	$('#crif_persona').val(resp[0].crif_persona);
        	$('#cnombrecliente').val(resp[0].cnombre);
        	$('#nid_condicionpago').val(resp[0].nid_condicionpago);
        	$("#dfecha_recepcion_entrega").datepicker("option", "minDate", resp[0].dfecha_documento);
            for(var contador=0;contador<99;contador++){
              $('tr[id="'+contador+'"]').remove();
            }
        	for(var contador=0;contador<resp.length;contador++){
        		$("#TablaArticulos").append("<tr id='"+contador+"'>"+
    			"<td>"+
    			"<center>"+
                  	"<input type='hidden' name='linea[]' id='linea_"+contador+"' value='"+resp[contador].nlinea+"' />"+
					"<select name='articulo[]' id='articulo_"+contador+"' title='Seleccione una artículo'>"+
					"<option value='"+resp[contador].cid_articulo+"'>"+resp[contador].articulo+"</option>"+
					"</select>"+
				"</center>"+
				"</td>"+
				"<td>"+
				"<center>"+
                    "<input type='hidden' name='cantidad_vieja[]' id='cantidad_vieja_"+contador+"' value='"+resp[contador].ncantidad_articulo+"' />"+
                    "<input type='hidden' name='existencia[]' id='existencia_"+contador+"' value='"+resp[contador].existencia+"' />"+
                    "<input class='campo_tabla' type='text' onKeyPress='return isNumberKey(event)' name='cantidad[]' id='cantidad_"+contador+"' size='50' value='"+resp[contador].ncantidad_articulo+"' />"+
                "</center>"+
                "</td>"+
                "</tr>");
        	}
        },
        error: function(resp){
        	alert('Error al procesar la petición')
        }
        });
    }

    function showNroCotizacion(){
    	if($('#numero_cotizacion').val()!=""){
    		$('#numero_cotizacion').attr("type","text");
    		$('#nnro_cotizacion').hide();
    	}
    }

    setInterval(showNroCotizacion,500);
}

function validar_formulario(param,urltab){
	//para validar en caso que no return false
	permitido=true;
	//campos pestaña 1
	valor=document.getElementById('nnro_entrega').value;
	valor0=document.getElementById('nnro_cotizacion').value;
	valor1=document.getElementById('dfecha_recepcion_entrega').value;
	valor2=document.getElementById('crif_persona').value;
	valor3=document.getElementById('nid_condicionpago').value;
	valor4=document.getElementsByName('linea[]');
	valor5=document.getElementsByName('articulo[]');
	valor6=document.getElementsByName('cantidad[]');
	valor7=document.getElementsByName('cantidad_vieja[]');
	valor8=document.getElementsByName('existencia[]');
	valor9=document.getElementById('nnro_factura').value;
	//Validar campos antes de insertar por pestañas.
	if(devuelve_boton(param)=="Registrar" && urltab == "notaentrega"){
		if(valor.replace(/^\s+|\s+$/gi,"").length>0){ //para no permitir que se quede en blanco
			alert('El Nro. de Entrega es generado por el sistema, favor ingrese el Nro de Entrega solo cuando vaya a consultar.')
			permitido=false;
		}
		else if(valor0==0){
			alert('Seleccione el Nro. de Cotización')
			permitido=false;
		}
		else if(valor9.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el Nro. de la Factura')
			permitido=false;
		}
		else if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Seleccione la fecha de la Entrega')
			permitido=false;
		}
		else if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Seleccione el cliente')
			permitido=false;
		}
		else if(valor3==0){ //para no permitir que se quede en blanco
			alert('Seleccione la condición de pago')
			permitido=false;
		}
		else if(valor4 && valor5 && valor6 && valor7 && valor8){
			//Valida que no se repitan los artículos
			arregloAR = new Array();
			numerok=0;
			for(k=0;k<valor4.length;k++){
				numerok=k;
				arregloAR.push(document.getElementById('articulo_'+k).value);
				var EX=document.getElementById('existencia_'+k).value;
				var CV=document.getElementById('cantidad_vieja_'+k).value;
				var CN=document.getElementById('cantidad_'+k).value;
				var ART=$("#articulo_"+k+" option:selected").html();
				if(parseInt(CN)>parseInt(CV)){
					alert("La cantidad ingresada del articulo "+ART+" debe ser menor o igual a "+CV);
					permitido=false;
				}
				else if(parseInt(CN)>parseInt(EX)){
					alert("La cantidad ingresada del articulo "+ART+" debe ser menor o igual a la existencia disponible: "+CV);
					permitido=false;
				}
			}
			if(contarRepetidos(arregloAR)>0){
				alert('El articulo no se puede repetir!')
				permitido=false;
			}
		}
	}
	//Validar campos antes de insertar o modificar por pestañas.
	if(devuelve_boton(param)=="Modificar" && urltab == "notaentrega"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el Nro. de Entrega')
			permitido=false;
		}
		else if(valor0==0){ //para no permitir que se quede en blanco
			alert('Seleccione un número de Cotización')
			permitido=false;
		}
		else if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Seleccione la fecha de la Entrega')
			permitido=false;
		}
		else if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Seleccione el cliente')
			permitido=false;
		}
		else if(valor3==0){ //para no permitir que se quede en blanco
			alert('Seleccione la condición de pago')
			permitido=false;
		}
		else if(valor8.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el Nro. de la Factura')
			permitido=false;
		}
		else if(valor4 && valor5 && valor6 && valor7 && valor8){
			//Valida que no se repitan los artículos
			arregloAR = new Array();
			numerok=0;
			for(k=0;k<valor4.length;k++){
				numerok=k;
				arregloAR.push(document.getElementById('articulo_'+k).value);
				var EX=document.getElementById('existencia_'+k).value;
				var CV=document.getElementById('cantidad_vieja_'+k).value;
				var CN=document.getElementById('cantidad_'+k).value;
				var ART=$("#articulo_"+k+" option:selected").html();
				if(parseInt(CN)>parseInt(CV)){
					alert("La cantidad ingresada del articulo "+ART+" debe ser menor o igual a "+CV);
					permitido=false;
				}
				else if(parseInt(CN)>parseInt(EX)){
					alert("La cantidad ingresada del articulo "+ART+" debe ser menor o igual a la existencia disponible: "+CV);
					permitido=false;
				}
			}
			if(contarRepetidos(arregloAR)>0){
				alert('El articulo no se puede repetir!')
				permitido=false;
			}
		}
	}
	//Validar antes de desactivar un registro por pestaña.
	if(devuelve_boton(param)=="Desactivar" && urltab == "notaentrega"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}
		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false;
	}
	//Enviar Formulario por pestañas.
	if(permitido==true && urltab =="notaentrega"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form").submit();
	}
}

function contarRepetidos(arreglo){
    var arreglo2 = arreglo;
    var con=0;
    for (var m=0; m<arreglo2.length; m++)
    {
        for (var n=0; n<arreglo2.length; n++)
        {
            if(n!=m)
            {
                if(arreglo2[m]==arreglo2[n])
                {
                	con++;
                }
            }
        }
    }
    return con;
}