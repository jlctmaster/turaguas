function validar_formulario(param,urltab){
	//para validar en caso que no return false
	permitido=true;
	//campos pestaña 1
	valor=document.getElementById('nid_combovalor').value;
	valor1=document.getElementById('ctabla').value;
	valor2=document.getElementById('cdescripcion').value;
	//Validar campos antes de insertar o modificar por pestañas.
	if((devuelve_boton(param)=="Registrar" && urltab == "combovalor") || (devuelve_boton(param)=="Modificar" && urltab == "combovalor")){
		if(valor1==0){ //para no permitir que se quede en blanco
			alert('Seleccione una tabla.')
			permitido=false;
		}else if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el texto a mostrar.')
			permitido=false;
		}else if(valor2.replace(/^\s+|\s+$/gi,"").length<=3){ //para no permitir que se quede en blanco
			alert('El texto a mostrar debe ser mayor a 3 caracteres.')
			permitido=false;
		}
	}
	//Validar antes de desactivar un registro por pestaña.
	if(devuelve_boton(param)=="Desactivar" && urltab == "combovalor"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar.')
			permitido=false;
			return false;
		}
		if(!confirm("Esta seguro que desea desactivar este registro."))
			return false;
	}
	//Enviar Formulario por pestañas.
	if(permitido==true && urltab =="combovalor"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
}