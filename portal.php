<?php
    session_start();
    include "conexiones/conexion.php";
    if(!isset($_SESSION['usuario'])){
        header("Location: index.php");
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
    <script src="js/jquery-3.1.1.js"></script>
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
								<li><a href="comites.php">COMITÉS</a></li>
              					<li><a href="comisiones.php">COMISIONES</a></li>
								<?php
                if($_SESSION['tipo'] == '0')
                {
                        echo '<li><a href="acuerdos.php?pag=0">ACUERDOS</a></li>
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
			</div>
	</body>
  <script>
    window.onload = cargarFooter();
    function cargarFooter(){
      $("#pie").load("../consejo_tecnico/fragmentos/footer.html");
    }
  </script>
</html>
