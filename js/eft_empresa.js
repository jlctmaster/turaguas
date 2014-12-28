function validar_formulario(param,urltab){
	//para validar en caso que no retorne false
	permitido=true;
	valor=document.getElementById('crif_empresa').value;
	valor2=document.getElementById('cnombre_empresa').value;
	valor3=document.getElementById('ctlf_empresa').value;
	valor4=document.getElementById('nid_localidad').value;
	valor5=document.getElementById('cdireccion_empresa').value;
	valor6=document.getElementById('cmision').value;
	valor7=document.getElementById('cvision').value;
	valor8=document.getElementById('cobjetivo').value;
	valor9=document.getElementById('chistoria').value;
	if((devuelve_boton(param)=="Modificar" && urltab == "empresa")){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el rif de la empresa')
			permitido=false;
		}
		else if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el nombre de la empresa')
			permitido=false;
		}
		else if(valor3.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el teléfono de habitación de la empresa')
			permitido=false;
		}
		else if(valor4==0){ //para no permitir que se quede en blanco
			alert('Seleccione una parroquia')
			permitido=false;
		}
		else if(valor5.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la dirección de la empresa')
			permitido=false;
		}
		else if(valor6.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la misión de la empresa')
			permitido=false;
		}
		else if(valor7.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la visión rif de la empresa')
			permitido=false;
		}
		else if(valor8.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese los objetivos de la empresa')
			permitido=false;
		}
		else if(valor9.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la reseña histórica de la empresa')
			permitido=false;
		}
	}

	if(permitido==true && urltab =="empresa"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
}