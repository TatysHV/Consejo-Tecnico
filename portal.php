<?php
    session_start();
    include "conexiones/conexion.php";
    if(!isset($_SESSION['usuario'])){
        echo '<script> window.location="/2016/consejo_tecnico/index.php"</script>';
    }
?>


<!Doctype html>
<html lang="es">
	<head>
		<title>Consejo Técnico</title>
		<meta charset="utf-8"/>
		<link type="text/css" rel="stylesheet" href="Bootstrap/css/bootstrap.min.css"/>
		<link type="text/css" rel="stylesheet" href="style.css"/>
		<link href='https://fonts.googleapis.com/css?family=Cinzel:400,700|Open+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Alegreya+Sans:400,500,700' rel='stylesheet' type='text/css'>
		<link rel="icon" type="image/png" href="">
	</head>
	<body>
		<div id="contenedor">
			<div id="cabecera">
					<!--<div id="usuario">
					</div>-->
					<div id="nombre">
            <img src="imagenes/logo-shct.png" style="display: inline-block;">
						<span id="titulo">H. Consejo Técnico</span>
					</div>
					<div id="navbar">
						<ul id="nav">
                <li class="active"><a href="portal.php">INICIO</a></li>
								<li><a href="actas.php">ACTAS</a></li>
								<li><a href="sesiones.php">SESIONES</a></li>
								<li><a href="calendario.php">CALENDARIO</a></li>
								<li><a href="normatividad.php">NORMATIVIDAD</a></li>
								<?php
                                                                if($_SESSION['tipo'] == '0')
                                                                {
                                                                        echo '<li><a href="acuerdos.php">ACUERDOS</a></li>
                                                                        <li><a href="oficios.php">OFICIOS</a></li>';
                                                                }
                                                        ?>
								<li style="float: right;"><a href="conexiones/logout.php" >Salir</a></li>
            </ul>
					</div>
			</div>


			<div id="principal">
				<img src="imagenes/panorama1.jpg" style="width:100%; height: auto">
      	<center><h2>Bienvenido al sitio oficial del H. Consejo Técnico de la ENES Morelia<h2></center>
				</br>
			</div>

			<div id="pie">
				<div class="contenido2">
					<div class="col-xs-5" id="f1">
						<div class="row">
							<div class="col-xs-2" id="flat">
								<img src="imagenes/flaticons/location.png"/>
							</div>
							<div class="col-xs-10">
								<p class="ftitulo">Dirección:</p>
								<p class="info">Morelia, Mich.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-2" id="flat">
								<img  src="imagenes/flaticons/app.png"/>
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
								<img src="imagenes/flaticons/social.png"/>
							</div>
							<div class="col-xs-6">
								<img src="imagenes/flaticons/youtube.png"/>
							</div>

					</div>
					<div id="derechos">
						<center><p>H. Consejo Técnico ENES Morelia</p></center>
					</div>
				</div>
			</div>
			</div>
		</div>
	</body>
</html>
