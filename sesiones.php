<?php
    session_start();
    include "conexiones/conexion.php";
    if(!isset($_SESSION['usuario'])){
        echo '<script> window.location="/consejo_tecnico/index.php"</script>';
    }
?>

<!Doctype html>
<html lang="es">
	<head>
		<title>Consejo Técnico</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="expires" content="0">
		<link type="text/css" rel="stylesheet" href="Bootstrap/css/bootstrap.min.css"/>
		<script src="js/jquery-3.1.1.js"></script>
		<script src="js/show_docs.js"></script>

		<link type="text/css" rel="stylesheet" href="style.css"/>
		<link rel="icon" type="image/png" href="">
		<link rel="shortcut icon" href="imagenes/logoUnam.jpg"/>
	</head>
	<body>
		<div id="contenedor">
			<div id="cabecera">
				<!--
					<div id="usuario">
					</div>
				-->
					<div id="nombre">
						<img src="imagenes/logo-shct.png" style="display: inline-block;">
						<span id="titulo">H. Consejo Técnico</span>
					</div>
					<div id="navbar">
						<ul id="nav">
							<li><a href="portal.php">INICIO</a></li>
							<li><a href="actas.php">ACTAS</a></li>
							<li class="active"><a href="sesiones.php">SESIONES</a></li>
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
			</br></br>
				<div class="bloque_year">
					<div class ="titular"><center>SESIONES DEL H. CONSEJO TÉCNICO</center></div></br>
					<form class="forma">
						<center>
							<span class="etiquetas">Mostrar sesiones del año: <span>
                <select class="menu" id="year">
                 <option value="2018" selected >2018</option>
  							 <option value="2017" >2017</option>
  							 <option value="2016">2016</option>
  							 <option value="2015">2015</option>
  							 <option value="2014">2014</option>
  							 <option value="2013">2013</option>
  							</select>
							<a class="btn btn-info" role="button" onclick="showforyear()" style="height: 30px; padding-top: 4px;">Consultar</a>
							<?php
                        if($_SESSION['tipo'] == '0')
                          {
                          echo '<a href="addsesion.php" class="btn btn-primary" role="button" style="height: 30px; padding-top: 4px;">+ Agregar nueva Sesión</a>';
                          }

                ?>
              </center>
					</form>
				</div>
				<div id="showyear" style="width: 85%; margin:auto;"></div>
				<div id="empty"></div></br>
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
								<p class="info"> Morelia, Mich.</p>
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
