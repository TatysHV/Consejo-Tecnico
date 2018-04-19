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
		<link rel="shortcut icon" href="imagenes/logoUnam.jpg"/>
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
							<li><a href="portal.php">INICIO</a></li>
							<li><a href="actas.php">ACTAS</a></li>
							<li><a href="sesiones.php">SESIONES</a></li>
							<li><a href="calendario.php">CALENDARIO</a></li>
							<li class="active"><a href="normatividad.php">NORMATIVIDAD</a></li>
              <?php
                      if($_SESSION['tipo'] == '0')
                      {
                      	echo '<li><a href="acuerdos.php">ACUERDOS</a></li>';
							        	echo '<li><a href="oficios.php">OFICIOS</a></li>';
								}
                                                        ?>
							<li style="float: right;"><a href="conexiones/logout.php" >Salir</a></li>
            </ul>
					</div>
			</div>

			<!-- BANNER
      <div id="banner">
			<img style="width:100%; height=auto" src="Imagenes/Banner1.jpg">
			</div>
      -->

			<div id="principal">
      </br></br></br>
      <div class="row" style="width: 80%; margin: auto;">
        <center><h3 style="color:#3380FF">Normatividad</h3></center>
        <div class="col-xs-6" style="padding-right: 15px; padding-left: 15px;">

          <legend style="margin-top: 30px; font-size: 1.4em">Estatutos y lineamientos generales de la UNAM</legend>

          <div style="padding-left: 20px;" class="lista">
            <ul>
              <li><span style="color: #666"><strong>Ley Orgánica de la UNAM</strong></span></li>
              <li><span style="color: #666"><strong>Estatuto General de la UNAM  </strong></span></li>
              <li><span style="color: #666"><strong>Reglamento del H. Consejo Técnico </strong></span></li>
            </ul>
          </div>

          <!--<embed src="archivos/reglamento-consejo.pdf" width="90%" height="800"></embed>-->

        </div>

        <div class="col-xs-6" style="padding-right: 15px; padding-left: 15px;">
          <legend style="margin-top: 30px;font-size: 1.4em">Lineamientos y reglamentos ENES Morelia</legend>
          <div style="border: 1px solid #cbcbcb; padding: 10px; border-radius: 3px; width: 100%; background-color: #F5F5F5;">
          <span class="etiquetas">Consultar por año:
            <select>
              <option value="2018">2018</option>
              <option value="2017">2017</option>
              <option value="2016">2016</option>
              <option value="all">Todos</option>
            </select>
          </span>
          </div>
          </br>

          <div style="padding-left: 20px;" class="lista">
            <ul>
              <li><span style="color: #666"><strong>Reglamento 1 </strong></span></li>
              <li><span style="color: #666"><strong>Reglamento 2 </strong></span></li>
              <li><span style="color: #666"><strong>Reglamento 3 </strong></span></li>
              <li><span style="color: #666"><strong>Reglamento 3 </strong></span></li>
              <li><span style="color: #666"><strong>Reglamento 4 </strong></span></li>
            </ul>
          </div>

        </div>
      </div>

      <div class="f-actualiz" style="margin-left: 11%; margin-top: 40px; color: grey;">
        Última fecha de actualización: 19/04/2018
      </div>

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
