$(document).ready(init);
function init(){
	$('#tab-contacto').click(function(){
		if($(location).attr('search')!="?cliente" && $(location).attr('hash')!="#cliente"){
			return true;
		}
		else{
			if($('#crif_personacliente').val()==""){
				alert('Debe seleccionar un registro para continuar!');
				return false;
			}
			else{
				return true;
			}
		}
	});

	var hash = window.location.hash.substr(1); 
	var href = $('ul.nav-tabs li a').each(function(){ 
		var href = $(this).attr('href'); 
		href=href.substr(1); 
		if(hash==href){ 
			$(".tab-pane").hide(); 
			$("ul.nav-tabs li").removeClass("active"); 
			$(this).parent('li').addClass("active"); 
			$('#'+hash).fadeIn(); 
		}	 
	})     

	$("ul.nav-tabs li").click(function(){ 
		$("ul.nav-tabs li").removeClass("active"); 
		$(this).addClass("active"); 
		$(".tab-pane").hide();   
		var content = $(this).find("a").attr("href"); 
		$(content).fadeIn(); return false; 
	});
}
function validar_formulario(param,urltab){
	//para validar en caso que no return false
	permitido=true;
	//campos pestaña 1
	valor=document.getElementById('crif_personacliente').value;
	valor2=document.getElementById('cnombrecliente').value;
	valor3=document.getElementById('ctelefhabcliente').value;
	valor1=document.getElementById('cemailcliente').value;
	valor4=document.getElementById('nid_condicionpago').value;
	valor5=document.getElementById('nid_localidadcliente').value;
	valor6=document.getElementById('cdireccioncliente').value;
	valor7=document.getElementsByName('ctelefonodireccion[]');
	valor8=document.getElementsByName('csede_principaldireccion[]');
	valor9=document.getElementsByName('nid_localidaddireccion[]');
	valor10=document.getElementsByName('cdirecciondespaho[]');
	//campos pestaña 3
	valor11=document.getElementById('crif_personacontacto').value;
	valor12=document.getElementById('cnombrecontacto').value;
	valor13=document.getElementById('ccargo').value;
	valor14=document.getElementById('ctelefono').value;
	valor15=document.getElementById('nid_direcciondespacho').value;
	
	//Validar campos antes de insertar o modificar por pestañas.
	if((devuelve_boton(param)=="Registrar" && urltab == "cliente") || (devuelve_boton(param)=="Modificar" && urltab == "cliente")){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el RIF del cliente')
			permitido=false;
		}
		else if(valor1.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la dirección de correo del cliente')
			permitido=false;
		}
		else if(!(/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/.test(valor1))){// validar dirección de correo valido
			alert('Ingrese una dirección de correo valida ej: ejemplo@dominio.com')
			permitido=false;
		}
		else if(valor2.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la razón social del cliente')
			permitido=false;
		}
		else if(valor3.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el teléfono de habitación del cliente')
			permitido=false;
		}
		else if(valor4==0){ //para no permitir que se quede en blanco
			alert('Selecione la condición de pago del cliente')
			permitido=false;
		}
		else if(valor5==0){ //para no permitir que se quede en blanco
			alert('Seleccione la parroquia del cliente')
			permitido=false;
		}
		else if(valor6.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese la dirección del cliente')
			permitido=false;
		}
		else if(valor7 && valor8 && valor9 && valor10){
			//Valida que no se repitan los telefonos.
			arregloT = new Array();
			numero=0;
			for(i=0;i<valor7.length;i++){
				numero=i;
				arregloT.push(document.getElementById('ctelefonodireccion_'+i).value);
			}
			if(contarRepetidos(arregloT)>0){
				alert('No pueden haber teléfonos de las direcciones de despacho repetidos!')
				return false;
			}
			//Valida que no haya 2 sedes principales
			arregloS = new Array();
			numeroj=0;
			for(j=0;j<valor8.length;j++){
				numeroj=j;
				if(document.getElementById('csede_principaldireccion_'+j).value=="Y")
					arregloS.push(document.getElementById('csede_principaldireccion_'+j).value);
			}
			if(contarRepetidos(arregloS)>0){
				alert('Solo puede haber una sede principal!')
				return false;
			}
			//Valida que no se repitan la conbinación de parroquia y dirección
			arregloP = new Array();
			arregloD = new Array();
			numerok=0;
			for(k=0;k<valor9.length;k++){
				numerok=k;
				arregloP.push(document.getElementById('nid_localidaddireccion_'+k).value);
				arregloD.push(document.getElementById('cdirecciondespacho_'+k).value);
			}
			if(contarRepetidos(arregloP)>0 && contarRepetidos(arregloD)>0){
				alert('La conbinación de parroquia con dirección no se puede repetir!')
				return false;
			}
			//Valida que no se repitan las direcciones
			arregloDir = new Array();
			numerol=0;
			for(l=0;l<valor10.length;l++){
				numerol=l;
				arregloDir.push(document.getElementById('cdirecciondespacho_'+l).value);
			}
			if(contarRepetidos(arregloDir)>0){
				alert('No pueden haber direcciones de despacho repetidos!')
				return false;
			}
		}
	}

	if((devuelve_boton(param)=="Registrar" && urltab == "contacto") || (devuelve_boton(param)=="Modificar" && urltab == "contacto")){
		if(valor11.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el rif del contacto')
			permitido=false;
		}
		else if(valor12.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el nombre del contacto')
			permitido=false;
		}
		else if(valor13.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el cargo del contacto')
			permitido=false;
		}
		else if(valor14.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('Ingrese el teléfono del contacto')
			permitido=false;
		}
		else if(valor15==0){ //para no permitir que se quede en blanco
			alert('Seleccione la dirección de despacho')
			permitido=false;
		}
	}
	
	//Validar antes de desactivar un registro por pestaña.
	if(devuelve_boton(param)=="Desactivar" && urltab == "cliente"){
		if(valor.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}
		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false;
	}
	
	if(devuelve_boton(param)=="Desactivar" && urltab == "contacto"){
		if(valor8.replace(/^\s+|\s+$/gi,"").length==0){ //para no permitir que se quede en blanco
			alert('consultar antes desactivar')
			permitido=false;
			return false;
		}
		if(!confirm("Esta seguro que desea desactivar este registro"))
			return false;
	}
	//Enviar Formulario por pestañas.
	if(permitido==true && urltab =="cliente"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form").submit();
	}
	else if(permitido==true && urltab =="contacto"){
		document.getElementById("operacion_"+urltab).value=devuelve_boton(param);
		document.getElementById("form3").submit();
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