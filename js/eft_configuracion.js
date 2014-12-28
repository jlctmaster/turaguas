function validar_formulario(param,urltab){
	//para validar en caso que no retorne false
	permitido=true;

	valor=document.getElementById('nid_configuracion').value;
	valor1=document.getElementById('cdescripcion').value;
	valor2=document.getElementById('nlongitud_minclave').value;
	valor3=document.getElementById('nlongitud_maxclave').value;
	valor4=document.getElementById('ncantidad_letrasmayusculas').value;
	valor5=document.getElementById('ncantidad_letrasminusculas').value;
	valor6=document.getElementById('ncantidad_caracteresespeciales').value;
	valor7=document.getElementById('ncantidad_numeros').value;
	valor8=document.getElementById('ndias_vigenciaclave').value;
	valor9=document.getElementById('ndias_aviso').value;
	valor10=document.getElementById('nintentos_fallidos').value;
	valor11=document.getElementById('nnumero_preguntas').value;
	valor12=document.getElementById('nnumero_respuestasaresponder').value;
	total=parseInt(valor4)+parseInt(valor5)+parseInt(valor6)+parseInt(valor7);
	if((devuelve_boton(param)=="Registrar" && urltab == "configuraciones") || (devuelve_boton(param)=="Modificar" && urltab == "configuraciones")){
		if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el nombre de la configuración')
			permitido=false;
		}else if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la longitud mínima para la clave')
			permitido=false;
		}else if(valor3.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la longitud máxima para la clave')
			permitido=false;
		}else if(valor4.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la cantidad de letras mayúsculas')
			permitido=false;
		}else if(valor5.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la cantidad de letras minúsculas')
			permitido=false;
		}else if(valor6.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la cantidad de carácteres númericos')
			permitido=false;
		}else if(valor7.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la cantidad de carácteres especiales')
			permitido=false;
		}else if(valor8.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la cantidad de días para la vigencia de la clave')
			permitido=false;
		}else if(valor9.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la cantidad de días para avisar el vencimiento de la clave')
			permitido=false;
		}else if(valor10.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la cantidad de intentos fallidos para acceder al sistema')
			permitido=false;
		}else if(valor11.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la cantidad de preguntas secretas')
			permitido=false;
		}else if(valor12.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la cantidad de preguntas secretas a responder')
			permitido=false;
		}else if(parseInt(valor3)<parseInt(valor2)){
			alert('La longitud máxima no puede ser menor a '+valor2);
			permitido=false;
		}else if(parseInt(valor2)<parseInt(total)){
			alert('La configuración de la contraseña es de '+total+' debe estar entre un mínimo de '+valor2+' caracteres')
			permitido=false;
		}
	}
		
	if(devuelve_boton(param)=="Desactivar" && urltab == "configuraciones"){
		
	    if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}	
		
	    if(!confirm("Esta seguro que desea desactivar este registro"))
	     return false
	}

	if(permitido==true && urltab =="configuraciones"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
}