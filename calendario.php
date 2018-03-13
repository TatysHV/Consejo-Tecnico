<?php
    session_start();
    include "conexiones/conexion.php";
    if(!isset($_SESSION['usuario'])){
        echo '<script> window.location="../../consejo_tecnico/index.php"</script>';
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
							<li class="active"><a href="calendario.php">CALENDARIO</a></li>
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

      <div id="calendarios">
        <?php

          $query1 = mysqli_query($con, "SELECT name FROM admin_files WHERE type = 'calgeneral'") or die ('<b>Error al obtener el calendario general</b>' . mysql_error());

          if ($row = mysqli_fetch_array($query1)) {
              $cal_gral= trim($row[0]);
          }

          $query2 = mysqli_query($con, "SELECT name FROM admin_files WHERE type = 'calsesiones'") or die ('<b>Error al obtener el calendario general</b>' . mysql_error());

          if ($row = mysqli_fetch_array($query2)) {
              $cal_ses= trim($row[0]);
          }
        ?>
        <div class="col-xs-6">
          <center>
            <legend>Calendario General</legend>
              <a href="conexiones/uploads/<?php echo $cal_gral?>" download="Calendario Semestral.png">Descargar</a>
              </br>
    				<img src="conexiones/uploads/<?php echo $cal_gral?>">
    			</center>
        </div>
        <div class="col-xs-6">
          <center>
            <legend>Calendario de Sesiones</legend>
            <a href="conexiones/uploads/<?php echo $cal_ses?>" download="Calendario de Sesiones.png">Descargar</a>
            </br>
            <img src="conexiones/uploads/<?php echo $cal_ses?>">

          </center>
        </div>
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
