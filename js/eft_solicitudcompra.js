function validar_formulario(param,urltab){
	//para validar en caso que no return false
	permitido=true;
	//campos pestaña 1
	valor=document.getElementById('nnro_solicitud').value;
	valor2=document.getElementById('dfecha_documento').value;
	valor3=document.getElementsByName('linea[]');
	valor4=document.getElementsByName('articulo[]');
	valor5=document.getElementsByName('cantidad[]');
	
	//Validar campos antes de insertar por pestañas.
	if(devuelve_boton(param)=="Registrar" && urltab == "solicitudcompra"){
		if(valor.replace(/^\s+|\s+$/gi,"").length>0){ //para no permitir que se quede en blanco
			alert('El Nro. de Solicitud es generado por el sistema, favor ingrese el Nro de Solicitud solo cuando vaya a consultar.')
			permitido=false;
		}
		else if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la fecha de la Solicitud')
			permitido=false;
		}
		else if(valor3 && valor4 && valor5){
			//Valida que no se repitan la conbinación de artículo y almacén
			arregloAR = new Array();
			numerok=0;
			for(k=0;k<valor3.length;k++){
				numerok=k;
				arregloAR.push(document.getElementById('articulo_'+k).value);
			}
			if(contarRepetidos(arregloAR)>0){
				alert('El artículo no se puede repetir!')
				permitido=false;
			}
		}
	}

	//Validar campos antes de modificar por pestañas.
	if(devuelve_boton(param)=="Modificar" && urltab == "solicitudcompra"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el Nro. de Solicitud')
			permitido=false;
		}
		else if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la fecha de la Solicitud')
			permitido=false;
		}
		else if(valor3 && valor4 && valor5){
			//Valida que no se repitan la conbinación de artículo y almacén
			arregloAR = new Array();
			numerok=0;
			for(k=0;k<valor3.length;k++){
				numerok=k;
				arregloAR.push(document.getElementById('articulo_'+k).value);
			}
			if(contarRepetidos(arregloAR)>0){
				alert('El artículo no se puede repetir!')
				permitido=false;
			}
		}
	}
	
	//Validar antes de desactivar un registro por pestaña.
	if(devuelve_boton(param)=="Desactivar" && urltab == "solicitudcompra"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}
		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false;
	}
	//Enviar Formulario por pestañas.
	if(permitido==true && urltab =="solicitudcompra"){
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