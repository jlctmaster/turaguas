function validar_formulario(param){
//para validar en caso q no return false
permitido=true;
valor=document.getElementById('crif_persona').value;
valor0=document.getElementById('cnombre').value;
valor1=document.getElementById('cdireccion').value;
valor2=document.getElementById('ctelefhab').value;
valor3=document.getElementById('nid_rol').value;
valor4=document.getElementById('nid_localidad').value;
if(devuelve_boton(param)=="Registrar" || devuelve_boton(param)=="Modificar"){
	if(valor.replace(/^\s+|\s+$/gi,"").length==0){
		alert('Ingrese el rif o cédula de la persona')
		permitido=false;
	}else if(valor0.replace(/^\s+|\s+$/gi,"").length==0){
		alert('Ingrese el nombre de la persona')
		permitido=false;
	}
	else if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
		alert('Ingrese la dirección de la persona')
		permitido=false;
	}
	else if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
		alert('Ingrese el teléfono de habitación de la persona')
		permitido=false;
	}
	else if(valor3==0){ //para no permitir que se queda en blanco
		alert('Seleccione un rol o cargo')
		permitido=false;
	}
	else if(valor4==0){ //para no permitir que se queda en blanco
		alert('Seleccione una parroquia')
		permitido=false;
	}
}
	
if(devuelve_boton(param)=="Desactivar"){
	if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
		alert('consultar antes desactivar')
		permitido=false;
		return false;
	}	
	if(!confirm("Esta seguro que desea desactivar este registro"))
     return false
}

document.getElementById("operacion").value=devuelve_boton(param);
if(permitido==true)
document.getElementById("form").submit();
}
