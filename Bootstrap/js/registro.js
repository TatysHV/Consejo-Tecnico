function showDatosEnvio(){
	document.getElementById('datosbasicos').style.display ='none';
	document.getElementById('indicador2').style.color ='#01A9DB';
	document.getElementById('indicador1').style.color ='#086A87';
	document.getElementById('datosenvio').style.display ='block';
}

function showDatosBasicos(){
	document.getElementById('datosenvio').style.display ='none';
	document.getElementById('datosbasicos').style.display ='block';
	document.getElementById('indicador2').style.color ='#086A87';
	document.getElementById('indicador1').style.color ='#01A9DB';
}

function encriptar(etiqueta){
	var id = "\""+etiqueta+"\"";
	console.log("etiqueta: "+id);
	var cadena = $(id).val();
 	var cadena_enc = btoa(cadena);
  alert("Cadena encriptada: "+cadena_enc);
	return cadena_enc;
}

function desencriptar(){
  var cadena = document.getElementById("palabra").value;
  contraseña_des = atob(palabra);
  console.log("Desencriptado: "+palabra_dec);
  document.getElementById("desencriptado").value = palabra_dec;
}

function registrar(){
   	var nombre = $("#nombreusuario").val();
   	var correo = $("#correo").val();
    var correo2 = $("#correo2").val();
    var contraseña = $("#pass").val();
    var contraseña2= $("#pass2").val();
		var direccion = $("#direccion").val();
		var curp = $("#curp").val();
		var rfc = $("#rfc").val();
		var oknombre = true;
		var okcorreo = true;
		var okcontraseña = true;
		var okdireccion = true;
		var okrfc = true;
		var okcurp = true;
		var correos_coinciden = false;
		var contraseñas_coinciden = false;
		var okcaptcha = false;

		var exReg_nombre = /([a-z]|[A-Z]|\s){4,15}/;
		var exReg_correo = /([a-z]|[A-Z]|\d|_){5,}@[a-z]{1,}\.[a-z]{2,3}/;
		var exReg_contraseña = /.{4,20}/;
		var exReg_direccion = /([a-z]|[A-Z]|#|\d|\s){10,30}/;
		var exReg_curp = /[A-Z]{1}[A|E|I|O|U]{1}[A-Z]{2}[0-9]{2}((0[1-9])|(1[0-2]))((0[1-9])|(1[0-9])|(2[0-9])|(3[0-1]))[H|M]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B|C|D|F|G|H|J|K|L|M|N|P|Q|R|S|T|V|W|X|Y|Z]{3}[0-9]{2}/;
		var exReg_rfc = /[A-Z]{3,4}[0-9]{6}([A-Z]|[0-9]){3}/;


	    if(nombre==""||exReg_nombre.test(nombre)==false){
	        alert("Necesitas colocar un nombre de entre 4 y 15 caracteres");
					oknombre=false;
	    }

	    else if(correo==""||exReg_correo.test(correo)==false){
	        alert("Necesitas colocar tu correo electrónico\nEjemplo: CarambolaMorelia@miemail.com");
					okcorreo=false;
			}

	    else if(correo2!=correo){
	        alert("Los correos electrónicos deben coincidir");
	    }

	    else if(contraseña==""||exReg_contraseña.test(contraseña)==false){
	        alert("Necesitas colocar una contraseña");
					okcontraseña=false;
	    }

	    else if(contraseña2!=contraseña){
	        alert("Las contraseñas deben coincidir");
	    }

			else if(direccion==""||exReg_direccion.test(direccion)==false){
				alert("Necesitas colocar una direccón");
				okdireccion=false;
			}

			else if(rfc==""||exReg_rfc.test(rfc)==false){
				alert("Necesitas colocar tu RFC \n Consta de: 4 o 3 letras 6 dígitos y 3 alfanuméricos");
				okrfc=false;
			}

			else if(curp==""||exReg_curp.test(curp)==false){
				alert("Necesitas colocar tu CURP");
				okcurp=false;
			}

			if(correo2==correo){ correos_coinciden=true;}
			if(contraseña2==contraseña){ contraseñas_coinciden=true;}
			if(grecaptcha.getResponse()!=""){ okcaptcha = true;}
			else{
				alert("Comprueba que no eres un robot");
			}

			if(oknombre==true
					&&okcorreo==true
					&&okcontraseña==true
					&&okcurp==true
					&&okdireccion==true
					&&okrfc==true
					&&okcaptcha==true
					&&contraseñas_coinciden==true
					&&correos_coinciden==true){
						console.log("Entra a hacer registro");
						alert("Has sido registrado correctamente: "+(nombre));

					//	nombre = (nombre);//Para encriptar B64--->btoa();
					//	correo = (correo);
					//	direccion = (direccion);
					//	curp = (curp);
					//  rfc = (rfc);



					$.ajax({
						url: "conexiones/registro.php",
						data: {
						"nombre":nombre,
            "email":correo,
            "pass":contraseña,
            "direc":direccion,
            "curp":curp,
            "rfc":rfc},
						type: "post",
						success: function(data){
										console.log("Te has registrado correctamente");
										alert("Has sido registrado correctamente: "+(data));
										window.load("index.php");
						}

				});
			}
}
