$(document).ready(init);
function init(){
	//Buscar los datos del nro de orden seleccionado.
	$('#nnro_devolucion').change(function(){
		Datos = {"operacion":"BuscarDatosNroDevolucion","filtro": $('#nnro_devolucion').val()};
		BuscarDatosNroDevolucion(Datos);
	})
    //Busca los datos del número de devolucion seleccionado.
    function BuscarDatosNroDevolucion(value){
        $.ajax({
        url: '../controladores/control_reembolsocliente.php',
        type: 'POST',
        async: true,
        data: value,
        dataType: "json",
        success: function(resp){
        	$('#nid_devolucion').val(resp[0].nid_devolucion);
        	$('#dfecha_documento_sc').val(resp[0].dfecha_devolucion);
        	$("#dfecha_documento").datepicker("option", "minDate", resp[0].dfecha_devolucion);
        	$('#crif_persona').val(resp[0].crif_persona);
        	$('#cnombrecliente').val(resp[0].cnombre);
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
                "</td>");
        	}
        },
        error: function(resp){
        	alert('Error al procesar la petición')
        }
        });
    }

    function showNroDevolucion(){
    	if($('#numero_devolucion').val()!=""){
    		$('#numero_devolucion').attr("type","text");
    		$('#nnro_devolucion').hide();
    	}
    }

    setInterval(showNroDevolucion,500);
}

function validar_formulario(param,urltab){
	//para validar en caso que no return false
	permitido=true;
	//campos pestaña 1
	valor=document.getElementById('nnro_reembolso').value;
	valor0=document.getElementById('nnro_devolucion').value;
	valor1=document.getElementById('dfecha_documento').value;
	valor2=document.getElementsByName('linea[]');
	valor3=document.getElementsByName('articulo[]');
	valor4=document.getElementsByName('cantidad[]');
	valor5=document.getElementsByName('cantidad_vieja[]');
	valor8=document.getElementsByName('existencia[]');
	//Validar campos antes de insertar o modificar por pestañas.
	if(devuelve_boton(param)=="Registrar" && urltab == "reembolsocliente"){
		if(valor.replace(/^\s+|\s+$/gi,"").length>0){ //para no permitir que se quede en blanco
			alert('El Nro. del Reembolso es generado por el sistema, favor ingrese el Nro del Reembolso solo cuando vaya a consultar.')
			permitido=false;
		}
		else if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Seleccione la fecha del Reembolso')
			permitido=false;
		}
		else if(valor0==0){ //para no permitir que se quede en blanco
			alert('Seleccione un Nro. de Devolución')
			permitido=false;
		}
		else if(valor2 && valor3 && valor4 && valor5){
			//Valida que no se repitan los artículos
			arregloAR = new Array();
			numerok=0;
			for(k=0;k<valor2.length;k++){
				numerok=k;
				arregloAR.push(document.getElementById('articulo_'+k).value);
				var EX=document.getElementById('existencia_'+k).value;
				var CV=document.getElementById('cantidad_vieja_'+k).value;
				var CN=document.getElementById('cantidad_'+k).value;
				var ART=$("#articulo_"+k+" option:selected").html();
				if(parseInt(CN)>parseInt(CV)){
					alert("La cantidad ingresada del articulo "+ART+" debe ser menor o igual a "+CV);
				}
				else if(parseInt(CN)>parseInt(EX)){
					alert("La cantidad ingresada del articulo "+ART+" debe ser menor o igual a la existencia disponible: "+CV);
					permitido=false;
				}
			}
			if(contarRepetidos(arregloAR)>0){
				alert('El articulo no se puede repetir!')
				return false;
			}
		}
	}
	//Validar campos antes de insertar o modificar por pestañas.
	if(devuelve_boton(param)=="Modificar" && urltab == "reembolsocliente"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el Nro. del Reembolso')
			permitido=false;
		}
		else if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Seleccione la fecha del Reembolso')
			permitido=false;
		}
		else if(valor0==0){ //para no permitir que se quede en blanco
			alert('Seleccione un Nro. de Devolución')
			permitido=false;
		}
		else if(valor2 && valor3 && valor4 && valor5){
			//Valida que no se repitan los artículos
			arregloAR = new Array();
			numerok=0;
			for(k=0;k<valor2.length;k++){
				numerok=k;
				arregloAR.push(document.getElementById('articulo_'+k).value);
				var CV=document.getElementById('cantidad_vieja_'+k).value;
				var CN=document.getElementById('cantidad_'+k).value;
				var ART=$("#articulo_"+k+" option:selected").html();
				if(parseInt(CN)>parseInt(CV)){
					alert("La cantidad ingresada del articulo "+ART+" debe ser menor o igual a "+CV);
				}
			}
			if(contarRepetidos(arregloAR)>0){
				alert('El articulo no se puede repetir!')
				return false;
			}
		}
	}
	//Validar antes de desactivar un registro por pestaña.
	if(devuelve_boton(param)=="Desactivar" && urltab == "reembolsocliente"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}
		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false;
	}
	//Enviar Formulario por pestañas.
	if(permitido==true && urltab =="reembolsocliente"){
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