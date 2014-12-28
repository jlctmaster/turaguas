function validar_formulario(param,urltab){
	//para validar en caso que no retorne false
	permitido=true;

	valor=document.getElementById('cnombremodulo').value;
	valor2=document.getElementById('nid_modulo').value;
	valor3=document.getElementById('cicono').value;
	valor4=document.getElementById('norden').value;
	if((devuelve_boton(param)=="Registrar" && urltab == "modulos") || (devuelve_boton(param)=="Modificar" && urltab == "modulos")){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
		alert('Ingrese el nombre del módulo')
		permitido=false;
		}else if(valor4.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
		alert('Ingrese el número del órden para el módulo')
		permitido=false;
		}
	}
		
	if(devuelve_boton(param)=="Desactivar" && urltab == "modulos"){
		
	    if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}	
		
	    if(!confirm("Esta seguro que desea desactivar este registro"))
	     return false
	}

	if(permitido==true && urltab =="modulos"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form1").submit();
	}
}