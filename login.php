<?php
	session_start();
?>
<!Doctype html>
<html lang="es">
	<head>
		<title>Carambola Morelia</title>
		<meta charset="utf-8"/>
		<link type="text/css" rel="stylesheet" href="css/Bootstrap/css/bootstrap.min.css"/>
		<link type="text/css" rel="stylesheet" href="registro.css"/>
		<link rel="icon" type="image/png" href="Imagenes/favicon_billar.png">
		<link href='https://fonts.googleapis.com/css?family=Cinzel:400,700|Open+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Alegreya+Sans:400,500,700' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="js/jquery-2.2.4.js"></script>
		<script type="text/javascript" src="js/registro.js"></script>
		<script src='https://www.google.com/recaptcha/api.js?hl=es'></script>
	</head>
	<body>
		<div id="contenedor">
			<div id="cabecera">
				<div id="usuario">
					<div class="boton_usuario" id="a_car">
						<a href="compras.php">CARRITO DE COMPRAS</a>
					</div>
					<div class="boton_usuario" id="a_reg">
						<?php
							if(!$_SESSION){
								?>
								<a href="registro.php">REGISTRAR</a>
						<?php
							}else{
						?>
								<a href="conexiones/cerrar_sesion.php">Cerrar Sesión</a>
						<?php
							}
						?>
					</div>
					<div class="boton_usuario" id="a_en">
						<?php
							if(!$_SESSION){
								?>
								<a href="login.php">ENTRAR</a>
						<?php
						}else{
							echo base64_decode($_SESSION['nombre']);
						}
						?>
					</div>
				</div>
				<div id="nombre">
					<img display="inline-block" src="Imagenes/logo.png"/>
				</div>
					<div id="navbar">
						<ul id="nav">
								<li><a href="index.php">INDICE</a></li>
								<li><a href="catalogo.php">CATÁLOGO</a></li>
								<li><a href="contacto.php">CONTACTO</a></li>
						</ul>
					</div>
			</div>


			<div id="principal">
				<div class="contenido">

						<form class="forma" id="datosbasicos">
							<br>
							<center><h4>Iniciar Sesión</h4></center>
							<br><br>
							<div class="input-group">
								<span class="input-group-addon" id="sizing-addon2">Correo electrónico:</span>
		  						<input type="email" placeholder="BillarCarambola@email.com" class="form-control" aria-describedby="sizing-addon2" id="correo"  data-container="body" required>
							</div>
							<br>

							<div class="input-group">
								<span class="input-group-addon" id="sizing-addon2">Contraseña:</span>
		  						<input type="password" class="form-control" aria-describedby="sizing-addon2" id="pass" data-container="body" required>
							</div>
							<br>
							<center>
								<br>
							<input class="btn btn-success" type="button" value="Iniciar Sesión" id="conect">
							<input class="btn btn-danger" type="button" value="Cancelar" onClick="">
							<br><br><br>
							<a href="registro.php">¿No tienes una cuenta?</a> || <a href="#">Olvidé mi contraseña</a>
							</center>
						</form>
				</div>
			</div>

			<div id="pie">
				<div class="contenido2">
					<div class="col-xs-5" id="f1">
						<div class="row">
							<div class="col-xs-2" id="flat">
								<img src="Imagenes/flaticons/location.png"/>
							</div>
							<div class="col-xs-10">
								<p class="ftitulo">Dirección:</p>
								<p class="info">Estocolmo n° 508, col. Infonavit Aguacates, Morelia, Mich.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-2" id="flat">
								<img  src="Imagenes/flaticons/app.png"/>
							</div>
							<div class="col-xs-10">
								<p class="ftitulo">Teléfono:</p>
								<p class="info">(452) 44-33-22-11-00</p>
							</div>
						</div>

					</div>
					<div class="col-xs-2">
					</div>
					<div class="col-xs-5" id="f2">
							<center>
							<p class="ftitulo">Encuentranos también en:</p>
							</center>

							<div class="col-xs-6">
								<img src="Imagenes/flaticons/social.png"/>
							</div>
							<div class="col-xs-6">
								<img src="Imagenes/flaticons/youtube.png"/>
							</div>

					</div>
					<div id="derechos">
						<center><p>Desarrollado por equipo Lotus - Instituto Tecnológico de Morelia</p></center>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
		$(document).ready(function(){

			$("#conect").on("click",function(){
				var correo = btoa($("#correo").val());
				var pass = $("#pass").val();
				console.log("Correo encriptado: "+correo);

				$.ajax({
					url: "conexiones/validar_usuario.php",
					data: {"correo": correo, "pass": pass},
					type: "post",
					success: function(data){
						console.log("Data: "+data+" Correo: "+correo);
						console.log("Correo Desencriptado: "+atob(correo));
						if(data==correo){
							alert("Correcto");
							location.href="index.php";
						}
						else{
							alert("incorrecto"+data);
						}
					}
				});
			});
		});
	</script>


</html>
