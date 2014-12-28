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
    //Busca los Datos del Cliente seleccionado.
    function BuscarDatosCliente(value){
        $.ajax({
        url: '../controladores/control_cotizacion.php',
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
}

function validar_formulario(param,urltab){
	//para validar en caso que no return false
	permitido=true;
	//campos pestaña 1
	valor=document.getElementById('nnro_cotizacion').value;
	valor1=document.getElementById('dfecha_documento').value;
	valor2=document.getElementById('crif_persona').value;
	valor3=document.getElementsByName('linea[]');
	valor4=document.getElementsByName('articulo[]');
	valor5=document.getElementsByName('cantidad[]');
	valor6=document.getElementsByName('precio[]');
	
	//Validar campos antes de insertar o modificar por pestañas.
	if(devuelve_boton(param)=="Registrar" && urltab == "cotizacion"){
		if(valor.replace(/^\s+|\s+$/gi,"").length>0){ //para no permitir que se quede en blanco
			alert('El Nro. de Cotización es generado por el sistema, favor ingrese el Nro de Cotización solo cuando vaya a consultar.')
			permitido=false;
		}
		else if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la fecha de la Cotización')
			permitido=false;
		}
		else if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el RIF del Cliente')
			permitido=false;
		}
		else if(valor3 && valor4 && valor5 && valor6){
			//Valida que no se repitan la conbinación de artículo y almacén
			arregloAR = new Array();
			numerok=0;
			for(k=0;k<valor4.length;k++){
				numerok=k;
				arregloAR.push(document.getElementById('articulo_'+k).value);
			}
			if(contarRepetidos(arregloAR)>0){
				alert('El articulo no se puede repetir!')
				permitido=false;
			}
		}
	}
	
	//Validar campos antes de insertar o modificar por pestañas.
	if(devuelve_boton(param)=="Modificar" && urltab == "cotizacion"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el Nro. de Cotización')
			permitido=false;
		}
		else if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la fecha de la Cotización')
			permitido=false;
		}
		else if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el RIF del Cliente')
			permitido=false;
		}
		else if(valor3 && valor4 && valor5 && valor6){
			//Valida que no se repitan la conbinación de artículo y almacén
			arregloAR = new Array();
			numerok=0;
			for(k=0;k<valor4.length;k++){
				numerok=k;
				arregloAR.push(document.getElementById('articulo_'+k).value);
			}
			if(contarRepetidos(arregloAR)>0){
				alert('El articulo no se puede repetir!')
				permitido=false;
			}
		}
	}
	
	//Validar antes de desactivar un registro por pestaña.
	if(devuelve_boton(param)=="Desactivar" && urltab == "cotizacion"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}
		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false;
	}
	//Enviar Formulario por pestañas.
	if(permitido==true && urltab =="cotizacion"){
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