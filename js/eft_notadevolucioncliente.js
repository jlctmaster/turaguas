function validar_formulario(param,urltab){
	//para validar en caso que no return false
	permitido=true;
	//campos pestaña 1
	valor=document.getElementById('nnro_devolucion').value;
	valor0=document.getElementById('nnro_entrega').value;
	valor1=document.getElementById('dfecha_devolucion').value;
	valor2=document.getElementsByName('linea[]');
	valor3=document.getElementsByName('articulo[]');
	valor4=document.getElementsByName('cantidad[]');
	valor5=document.getElementsByName('cantidad_vieja[]');
	valor6=document.getElementsByName('motivodevolucion[]');
	//Validar campos antes de insertar o modificar por pestañas.
	if(devuelve_boton(param)=="Registrar" && urltab == "notadevolucioncliente"){
		if(valor.replace(/^\s+|\s+$/gi,"").length>0){ //para no permitir que se quede en blanco
			alert('El Nro. de Devolución es generado por el sistema, favor ingrese el Nro de Devolución solo cuando vaya a consultar.')
			permitido=false;
		}
		else if(valor0==0){ //para no permitir que se quede en blanco
			alert('Seleccione un Nro. de Entrega')
			permitido=false;
		}
		else if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Seleccione la fecha de la Devolución')
			permitido=false;
		}
		else if(valor2 && valor3 && valor4 && valor5 && valor6){
			arregloCN = new Array();
			for(j=0;j<valor2.length;j++){
				var CV=document.getElementById('cantidad_vieja_'+j).value;
				var CN=document.getElementById('cantidad_'+j).value;
				var Ln=document.getElementById('linea_'+j).value;
				var MD=document.getElementById('motivodevolucion_'+j).value;
				arregloCN.push(document.getElementById('cantidad_'+j).value);
				var ART=$("#descrip_articulo_"+j).val();
				if(parseInt(CN)>parseInt(CV)){
					alert("La cantidad ingresada del artículo "+ART+" debe ser menor o igual a "+CV);
					permitido=false;
				}
				else if(CN>0 && MD==0){
					alert("Seleccione un motido de devolución para el artículo "+ART);
					permitido=false;
				}
			}
			if(contarDistintoACeros(arregloCN)>0){
				alert("Debe haber al menos una línea con la cantidad mayor a 0");
				permitido=false;
			}
		}
	}
	//Validar campos antes de insertar o modificar por pestañas.
	if(devuelve_boton(param)=="Modificar" && urltab == "notadevolucioncliente"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el Nro. de Devolución')
			permitido=false;
		}
		else if(valor0==0){ //para no permitir que se quede en blanco
			alert('Seleccione un Nro. de Entrega')
			permitido=false;
		}
		else if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Seleccione la fecha de la Devolución')
			permitido=false;
		}
		else if(valor2 && valor3 && valor4 && valor5 && valor6){
			arregloCN = new Array();
			for(j=0;j<valor2.length;j++){
				var CV=document.getElementById('cantidad_vieja_'+j).value;
				var CN=document.getElementById('cantidad_'+j).value;
				var Ln=document.getElementById('linea_'+j).value;
				var MD=document.getElementById('motivodevolucion_'+j).value;
				arregloCN.push(document.getElementById('cantidad_'+j).value);
				var ART=$("#descrip_articulo_"+j).val();
				if(parseInt(CN)>parseInt(CV)){
					alert("La cantidad ingresada del artículo "+ART+" debe ser menor o igual a "+CV);
					permitido=false;
				}
				else if(CN>0 && MD==0){
					alert("Seleccione un motido de devolución para el artículo "+ART);
					permitido=false;
				}
			}
			if(contarDistintoACeros(arregloCN)>0){
				alert("Debe haber al menos una linea con la cantidad mayor a 0");
				permitido=false;
			}
		}
	}
	//Validar antes de desactivar un registro por pestaña.
	if(devuelve_boton(param)=="Desactivar" && urltab == "notadevolucioncliente"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}
		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false;
	}
	//Enviar Formulario por pestañas.
	if(permitido==true && urltab =="notadevolucioncliente"){
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

function contarDistintoACeros(arreglo){
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
                	if(arreglo2[m]==0)
                		con++;
                }
            }
        }
    }
    return con;
}