function validar_formulario(param,urltab){
	if(document.getElementById('cedula')){
		if(document.getElementById('cedula').value.trim().length!==10){
			alert("la cédula debe tener 10 caracteres")
			return false;
		}
	}
	if(document.getElementById('perfil')){
		if(document.getElementById('perfil').value.trim()=="" || document.getElementById('perfil').value.trim()=="null"){
			alert("selecciona el perfil del usuario")
			return false;
		}
	}

	document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
	document.getElementById("form1").submit();
	return true;
}

String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ""); }