function validar_formulario(param){
	//para validar en caso q no return false
	permitido=true;
	valor=document.getElementById('$cid_articulo').value;
	valor2=document.getElementById('nid_um_conversion').value;
	valor3=document.getElementById('nid_um_desde').value;
	valor4=document.getElementById('nid_um_hasta').value;
	valor5=document.getElementById('nfactor_multiplicador').value;
	valor6=document.getElementById('nfactor_divisor').value;
	if(devuelve_boton(param)=="Registrar" || devuelve_boton(param)=="Modificar"){
		if(valor==0){ //para no permitir que se queda en blanco
			alert('Ingrese el nombre de la sub - categoría')
			permitido=false;
		}else if(valor4==""){
			alert('Ingrese la unidad de medida hasta')
			permitido=false;
		}else if(valor5==""){
			alert('Ingrese el factor multiplicador')
			permitido=false;
		}else if(valor6==""){
			alert('Ingrese el factor multiplicador')
			permitido=false;
		}
	}

	if(devuelve_boton(param)=="Desactivar"){
		if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se queda en blanco
			alert('consultar antes de desactivar')
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
