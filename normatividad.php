<?php
    session_start();
    include "conexiones/conexion.php";
    if(!isset($_SESSION['usuario'])){
        echo '<script> window.location="/2016/consejo_tecnico/index.php"</script>';
    }

    if (!mysqli_select_db($con, $db))
      {
        echo "<h2>Error al seleccionar la base de datos!!!";
        header("Location: index.php");
        exit;
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
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.css">
    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/show_docs.js"></script>
    <script src="js/down_value.js"></script>

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
              <li><a href="comites.php">COMITÉS</a></li>
              <li><a href="comisiones.php">COMISIONES</a></li>
              <?php
                      if($_SESSION['tipo'] == '0')
                      {
                      	echo '<li><a href="acuerdos.php?pag=0">ACUERDOS</a></li>';
							        	echo '<li><a href="oficios.php?pag=0">OFICIOS</a></li>';
								}
                                                        ?>
							<li style="float: right;"><a href="conexiones/logout.php" >Salir</a></li>
            </ul>
					</div>
			</div>

			<div id="principal">
        <img src="imagenes/normatividad.jpg" style="width:100%; height: auto">
      </br>
      <div class="row" style="width: 80%; margin: auto;">
        <div id="normatividad">
          <!--Carga de manera automática al abrir la página, el reglamento general de la UNAM
          Y mostrará de manera dinámica el reglamento aprobado por el Consejo Técnico dependiendo del año elegido-->
          <?php
            $sql="SELECT * FROM normatividad WHERE tipo = 'G'";

            $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($conexion));
            echo'<!--<center><h3 style="color:#3380FF">Normatividad</h3></center>-->
            <div class="col-xs-6" style="padding-right: 15px; padding-left: 15px;">

              <legend style="margin-top: 30px; font-size: 1.4em">Estatutos y lineamientos generales de la UNAM</legend>

              <div style="padding-left: 20px;" class="lista">
                <ul>';

                  while ($line = mysqli_fetch_array($result)) {

                  echo'<li><span style="color: #666"><strong><a href="conexiones/uploads/'.$line["url"].'">'.$line["nombre"].'</a></strong></span>';
                      if($_SESSION['tipo'] == '0'){ //Si el usuario es del tipo administrador: mostrará el botón de eliminar
                         echo'<div class="onKlic" onclick="deleteReg('.$line["id"].')" style="display: inline-block; margin-left: 8px; "><img src="imagenes/flaticons/eliminar.png" style="width: 15px; heigth: auto;" title="Eliminar"/></div>';
                      }
                  echo'</li>';

                }
                echo'
                </ul>
              </div>
            </div>

            <div class="col-xs-6" style="padding-right: 15px; padding-left: 15px;">
              <legend style="margin-top: 30px; font-size: 1.4em">Lineamientos y reglamentos ENES Morelia</legend>
              <h4 style="color:#666">Seleccionar año:</h4>

              <div class="row">
                <form>
                  <div class="form-group col-sm-9" style="padding-right:0px;">

                  <select class="form-control" id="regYear">';


                  $year = date("Y");
                  $i = $year-1;

                  echo'<option value="'.$year.'" selected>'.$year.'</option>';

                  while($i>=2013){

                    echo'<option value="'.$i.'">'.$i.'</option>';
                    $i--;
                  }

                  echo'
                    <option value="todos">Todos</option>
                  </select>';

                echo '
                  </div>
                  <div class="col-sm-3"><button type="button" class="btn btn-info" onclick="showRegCT()"> Buscar </button></div>
                </form>
              </div>

              <div class="row">
                <div style="padding-left: 30px;" class="lista" id="reg_aprobados">
                  <!-- Espacio dinánico que muestra el resultado de la búsqueda -->
                </div>
              </div>

            </div>
        ';

          ?>
        </div>
      </div>

      <!--<div class="f-actualiz" style="margin-left: 11%; margin-top: 40px; color: grey;">
        Última fecha de actualización: 19/04/2018
      </div>
      -->

			</div>
			<div id="pie">
		  </div>
	</body>
  <script>
    window.onload = cargarFooter();
    function cargarFooter(){
      $("#pie").load("../consejo_tecnico/fragmentos/footer.php");
    }

    /*function cargarReglamentos(){
      $("#normatividad").load("../consejo_tecnico/fragmentos/reglamentos.php");
    }*/
  </script>
</html>
