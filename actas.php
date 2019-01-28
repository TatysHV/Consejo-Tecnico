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
		<link rel="shortcut icon" href="imagenes/logoUnam.jpg"/>
    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/show_docs.js"></script>
    <script src="js/down_value.js"></script>

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
						<span id="titulo">H. Consejo Técnio</span>
					</div>
					<div id="navbar">
						<ul id="nav">
							<li><a href="portal.php">INICIO</a></li>
							<li class="active"><a href="actas.php">ACTAS</a></li>
							<li><a href="sesiones.php">SESIONES</a></li>
							<li><a href="calendario.php">CALENDARIO</a></li>
							<li><a href="normatividad.php">NORMATIVIDAD</a></li>
              <li><a href="comites.php">COMITÉS</a></li>
              <li><a href="comisiones.php">COMISIONES</a></li>
							<?php
                      if($_SESSION['tipo'] == '0')
                      {
                              echo '<li><a href="acuerdos.php?pag=0">ACUERDOS</a></li>
                              <li><a href="oficios.php?pag=0">OFICIOS</a></li>';
                      }
              ?>
							<li style="float: right;"><a href="conexiones/logout.php" >Salir</a></li>
            					</ul>
					</div>
			</div>

			<div id="principal">
        <img src="imagenes/banner_actas.png" style="width:100%; height: auto">
      </br>
        <div class="bloque_year">
          <div class ="titular"><center>ACTAS DEL H. CONSEJO TÉCNICO</center></div></br>
          <form class="forma">
            <center>
              <span class="etiquetas">Mostrar actas del año: </span>
                <select class="menu" id="yearActas">
                 <option value="2018" selected >2018</option>
                 <option value="2017" >2017</option>
                 <option value="2016">2016</option>
                 <option value="2015">2015</option>
                 <option value="2014">2014</option>
                 <option value="2013">2013</option>
                </select>
              <a class="btn btn-info" role="button" onclick="showactas()" style="height: 30px; padding-top: 4px;">Consultar</a>
              <?php
                        if($_SESSION['tipo'] == '0')
                          {
                          echo '<a href="addActa.php" class="btn btn-primary" role="button" style="height: 30px; padding-top: 4px;">+ Agregar nueva Acta</a>';
                          }

                ?>
              </center>
              <!-- --------------HICE EL CAMBIO DE COLOR DE PANELCONTROL, HICE LA TABLA DE ACTAS EN BD Y COMENCÉ LA INTERFAZ DE ACTAS -->
          </form>
        </div>
        <div id="showyearActas" style="width: 85%; margin:auto;"></div>
        <div id="emptyActas"></div></br>
			</div>
			<div id="pie">
		  </div>
	</body>
  <script>
    window.onload = cargarFooter();
    function cargarFooter(){
      $("#pie").load("../consejo_tecnico/fragmentos/footer.php");
    }
  </script>
</html>
