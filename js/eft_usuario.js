function validar_formulario(param,urltab){
	if(document.getElementById('cedula')){
		ci=document.form.cedula.value.trim();
	}
	if(document.getElementById('cedula_usuario')){
		ci=document.form.cedula_usuario.value.trim();
	}
	if(document.getElementById('cedula_usuario')){
		arreglo = new Array();
		numero=0;
		for(i=0;i<document.getElementById('nnumero_preguntas').value;i++){
			numero=i+1;
			arreglo.push(document.getElementById('pregunta_'+i).value);
			if(document.getElementById('pregunta_'+i).value==""){
				alert('Ingrese la pregunta '+numero+' de seguridad')
				return false;
			}
			if(document.getElementById('respuesta_'+i).value==""){
				alert('Ingrese la respuesta de la pregunta '+numero+' de seguridad')
				return false;
			}
		}
		if(contarRepetidos(arreglo)>0){
			alert('No pueden haber preguntas repetidas!')
			return false;
		}
	}
	if(document.getElementById('nueva_contrasena')){
		if(validar_contrasena()==false)
			return false;
		document.getElementById("form1").submit();
	}

	document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
	document.getElementById("form1").submit();
}

function validar_contrasena(){
	var ExpCE=new RegExp("(?=.*[`~!@#$\%\^&\*()_\|:;\"\'<>,\.\?/]{"+document.getElementById('ncantidad_caracteresespeciales').value+",})");
	var ExpLMay = new RegExp("(?=.*[A-Z]{"+document.getElementById('ncantidad_letrasmayusculas').value+",})");
	var ExpLMin = new RegExp("(?=.*[a-z]{"+document.getElementById('ncantidad_letrasminusculas').value+",})");
	var ExpLNum = new RegExp("(?=.*[0-9]{"+document.getElementById('ncantidad_numeros').value+",})");
   	if(document.getElementById('nueva_contrasena').value.replace(/^\s+|\s+$/g, "").length==0){
    	alert("El ingrese la contraseña!.");
      	return false;
    }
	if(document.getElementById('nueva_contrasena').value.replace(/^\s+|\s+$/g, "")!=document.getElementById('confirmar_contrasena').value.replace(/^\s+|\s+$/g,"")){
        alert("Las contrase\u00f1as no coeciden!.");
      	return false;
    }
    if(!(ExpCE.test(document.getElementById('nueva_contrasena').value))){
    	alert("<div style='text-align:left;'>La contrase\u00f1a debe tener:</br> "+
			"* Al menos "+document.getElementById('ncantidad_letrasmayusculas').value+" letra(s) may\u00fascula(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_letrasminusculas').value+" letra(s) min\u00fascula(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_numeros').value+" n\u00famero(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_caracteresespeciales').value+" car\u00e1cter(es) especial(es). pj: ` ~ ! @ # $ \% \^ & \* ( ) _ \| : ; \" \' < > , \. \? / </br> "+
			"* Una longitud que sea como m\u00ednimo "+document.getElementById('nlongitud_minclave').value+" car\u00e1cteres. </br> "+
			"* Una longitud que sea como m\u00e1ximo "+document.getElementById('nlongitud_maxclave').value+" car\u00e1cteres.</div>");
      	return false;
    }
	else if(!(ExpLMin.test(document.getElementById('nueva_contrasena').value))){
		alert("<div style='text-align:left;'>La contrase\u00f1a debe tener:</br> "+
			"* Al menos "+document.getElementById('ncantidad_letrasmayusculas').value+" letra(s) may\u00fascula(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_letrasminusculas').value+" letra(s) min\u00fascula(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_numeros').value+" n\u00famero(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_caracteresespeciales').value+" car\u00e1cter(es) especial(es). pj: ` ~ ! @ # $ \% \^ & \* ( ) _ \| : ; \" \' < > , \. \? / </br> "+
			"* Una longitud que sea como m\u00ednimo "+document.getElementById('nlongitud_minclave').value+" car\u00e1cteres. </br> "+
			"* Una longitud que sea como m\u00e1ximo "+document.getElementById('nlongitud_maxclave').value+" car\u00e1cteres.</div>");
      	return false;
    }
	else if(!(ExpLMay.test(document.getElementById('nueva_contrasena').value))){
		alert("<div style='text-align:left;'>La contrase\u00f1a debe tener:</br> "+
			"* Al menos "+document.getElementById('ncantidad_letrasmayusculas').value+" letra(s) may\u00fascula(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_letrasminusculas').value+" letra(s) min\u00fascula(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_numeros').value+" n\u00famero(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_caracteresespeciales').value+" car\u00e1cter(es) especial(es). pj: ` ~ ! @ # $ \% \^ & \* ( ) _ \| : ; \" \' < > , \. \? / </br> "+
			"* Una longitud que sea como m\u00ednimo "+document.getElementById('nlongitud_minclave').value+" car\u00e1cteres. </br> "+
			"* Una longitud que sea como m\u00e1ximo "+document.getElementById('nlongitud_maxclave').value+" car\u00e1cteres.</div>");
      	return false;
    }
	else if(!(ExpLNum.test(document.getElementById('nueva_contrasena').value))){
		alert("<div style='text-align:left;'>La contrase\u00f1a debe tener:</br> "+
			"* Al menos "+document.getElementById('ncantidad_letrasmayusculas').value+" letra(s) may\u00fascula(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_letrasminusculas').value+" letra(s) min\u00fascula(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_numeros').value+" n\u00famero(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_caracteresespeciales').value+" car\u00e1cter(es) especial(es). pj: ` ~ ! @ # $ \% \^ & \* ( ) _ \| : ; \" \' < > , \. \? / </br> "+
			"* Una longitud que sea como m\u00ednimo "+document.getElementById('nlongitud_minclave').value+" car\u00e1cteres. </br> "+
			"* Una longitud que sea como m\u00e1ximo "+document.getElementById('nlongitud_maxclave').value+" car\u00e1cteres.</div>");
      	return false;
    }
    else if(document.getElementById('nueva_contrasena').value.replace(/^\s+|\s+$/g, "").length<document.getElementById('nlongitud_minclave').value){
		alert("<div style='text-align:left;'>La contrase\u00f1a debe tener:</br> "+
			"* Al menos "+document.getElementById('ncantidad_letrasmayusculas').value+" letra(s) may\u00fascula(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_letrasminusculas').value+" letra(s) min\u00fascula(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_numeros').value+" n\u00famero(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_caracteresespeciales').value+" car\u00e1cter(es) especial(es). pj: ` ~ ! @ # $ \% \^ & \* ( ) _ \| : ; \" \' < > , \. \? / </br> "+
			"* Una longitud que sea como m\u00ednimo "+document.getElementById('nlongitud_minclave').value+" car\u00e1cteres. </br> "+
			"* Una longitud que sea como m\u00e1ximo "+document.getElementById('nlongitud_maxclave').value+" car\u00e1cteres.</div>");
      	return false;
    }
    else if(document.getElementById('nueva_contrasena').value.replace(/^\s+|\s+$/g, "").length>document.getElementById('nlongitud_maxclave').value){
		alert("<div style='text-align:left;'>La contrase\u00f1a debe tener:</br> "+
			"* Al menos "+document.getElementById('ncantidad_letrasmayusculas').value+" letra(s) may\u00fascula(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_letrasminusculas').value+" letra(s) min\u00fascula(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_numeros').value+" n\u00famero(s).</br> "+
			"* Al menos "+document.getElementById('ncantidad_caracteresespeciales').value+" car\u00e1cter(es) especial(es). pj: ` ~ ! @ # $ \% \^ & \* ( ) _ \| : ; \" \' < > , \. \? / </br> "+
			"* Una longitud que sea como m\u00ednimo "+document.getElementById('nlongitud_minclave').value+" car\u00e1cteres. </br> "+
			"* Una longitud que sea como m\u00e1ximo "+document.getElementById('nlongitud_maxclave').value+" car\u00e1cteres.</div>");
      	return false;
    }
    return true;
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

String.prototype.trim = function(){ return this.replace(/^\s+|\s+$/g, ""); };// para cortar espacio en blanco en un cadena similar a trim()  php y mysql