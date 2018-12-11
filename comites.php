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
							<li><a href="normatividad.php">NORMATIVIDAD</a></li>
              <li class="active"><a href="comites.php">COMITÉS</a></li>
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
      </br></br></br>
      <div class="row" style="width: 80%; margin: auto;">
        <div id="comites">
          <!--Carga de manera automática al abrir la página, el reglamento general de la UNAM
          Y mostrará de manera dinámica el reglamento aprobado por el Consejo Técnico dependiendo del año elegido-->
          <?php
            $sql="SELECT * FROM comites WHERE tipo = 'A' ORDER BY nombre ASC";

            $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($conexion));

            echo' <center><h3 style="color:#3380FF">Comités</h3></center>
            <div class="col-xs-6" style="padding-right: 15px; padding-left: 15px;">

              <legend style="margin-top: 30px; font-size: 1.4em">Comités académicos de licenciaturas</legend>

              <div style="padding-left: 20px;" class="lista">
                <ul>
                  <li><a href="#">Comité Académico Licenciatura en Ciencias Ambientales</a></li>
                  <li><a href="#">Comité Académico Licenciatura en Ecología</a></li>
                  <li><a href="#">Comité Académico Licenciatura en Geociencias</a></li>
                  <li><a href="#">Comité Académico Licenciatura en Ciencia de Materiales Sustentables</a></li>
                  <li><a href="#">Comité Académico Licenciatura en Tecnologías para la Información en Ciencias</a></li>
                  <li><a href="#">Comité Académico Licenciatura en Estudios Sociales y Gestión Local</a></li>
                  <li><a href="#">Comité Académico Licenciatura en Geohistoria</a></li>
                  <li><a href="#">Comité Académico Licenciatura en Historia del Arte</a></li>
                  <li><a href="#">Comité Académico Licenciatura en Literatura Intercultural</a></li>
                  <li><a href="#">Comité Académico Licenciatura en Arte y Diseño</a></li>
                  <li><a href="#">Comité Académico Licenciatura en Administración de Archivos y Gestión Documental</a></li>
                  <li><a href="#">Comité Académico Licenciatura en Música y Tecnología Artística</a></li>
                ';

                  while ($line = mysqli_fetch_array($result)) {

                  if ($line["url"]){
                    echo'<li><span style="color: #666"><strong><a href="conexiones/uploads/'.$line["url"].'">'.$line["nombre"].'</a></strong></span>';
                      if($_SESSION['tipo'] == '0'){ //Si el usuario es del tipo administrador: mostrará el botón de eliminar
                         echo'<div class="onKlic" onclick="deleteCom('.$line["id"].')" style="display: inline-block; margin-left: 8px; "><img src="imagenes/flaticons/eliminar.png" style="width: 15px; heigth: auto;" title="Eliminar"/></div>
                         <div style="display: inline-block; margin-left: 8px; "><a href="editcomite.php?id='.$line["id"].'"><img src="imagenes/flaticons/edit-icon.png" style="width: 15px; heigth: auto;" title="Editar"/></a></div>';
                      }
                    echo'</li>';
                    }else{
                      echo'<li><span style="color: #666"><strong><a href="#">'.$line["nombre"].'</a></strong></span>';
                      if($_SESSION['tipo'] == '0'){ //Si el usuario es del tipo administrador: mostrará el botón de eliminar
                         echo'<div class="onKlic" onclick="deleteCom('.$line["id"].')" style="display: inline-block; margin-left: 8px; "><img src="imagenes/flaticons/eliminar.png" style="width: 15px; heigth: auto;" title="Eliminar"/></div>
                         <div style="display: inline-block; margin-left: 8px; "><a href="editcomite.php?id='.$line["id"].'"><img src="imagenes/flaticons/edit-icon.png" style="width: 15px; heigth: auto;" title="Editar"/></a></div>';
                      }
                    echo'</li>';
                    }


                }
                echo'
                </ul>
              </div>
            </div>';

          ?>
        </div>
        <div id="comites">
          <!--Carga de manera automática al abrir la página, el reglamento general de la UNAM
          Y mostrará de manera dinámica el reglamento aprobado por el Consejo Técnico dependiendo del año elegido-->
          <?php
            $sql2="SELECT * FROM comites WHERE tipo = 'O' ORDER BY nombre ASC";

            $result2 = mysqli_query($con, $sql2) or die('<b>No se encontraron coincidencias</b>' . mysql_error($conexion));

            echo'
            <div class="col-xs-6" style="padding-right: 15px; padding-left: 15px;">
              <div class="row">
                <legend style="margin-top: 30px; font-size: 1.4em">Comités académicos de posgrado</legend>

                <div style="padding-left: 20px;" class="lista">
                  <ul>

                ';

                    while ($line2 = mysqli_fetch_array($result2)) {

                   if ($line2["url"]){
                    echo'<li><span style="color: #666"><strong><a href="conexiones/uploads/'.$line2["url"].'">'.$line2["nombre"].'</a></strong></span>';
                      if($_SESSION['tipo'] == '0'){ //Si el usuario es del tipo administrador: mostrará el botón de eliminar
                         echo'<div class="onKlic" onclick="deleteCom('.$line2["id"].')" style="display: inline-block; margin-left: 8px; "><img src="imagenes/flaticons/eliminar.png" style="width: 15px; heigth: auto;" title="Eliminar"/></div>
                              <div style="display: inline-block; margin-left: 8px; "><a href="editcomite.php?id='.$line2["id"].'"><img src="imagenes/flaticons/edit-icon.png" style="width: 15px; heigth: auto;" title="Editar"/></a></div>';
                      }
                    echo'</li>';
                    }else{
                      echo'<li><span style="color: #666"><strong><a href="#">'.$line2["nombre"].'</a></strong></span>';
                      if($_SESSION['tipo'] == '0'){ //Si el usuario es del tipo administrador: mostrará el botón de eliminar
                         echo'<div class="onKlic" onclick="deleteCom('.$line2["id"].')" style="display: inline-block; margin-left: 8px; "><img src="imagenes/flaticons/eliminar.png" style="width: 15px; heigth: auto;" title="Eliminar"/></div>
                         <div style="display: inline-block; margin-left: 8px; "><a href="editcomite.php?id='.$line2["id"].'"><img src="imagenes/flaticons/edit-icon.png" style="width: 15px; heigth: auto;" title="Editar"/></a></div>';
                      }
                    echo'</li>';
                    }

                  }
                  echo'
                  </ul>
                </div>
              </div>
              <div class="row">
              <legend style="margin-top: 30px; font-size: 1.4em"> Otros Comités</legend>

              <div style="padding-left: 20px;" class="lista">
                <ul>
                  <li><a href="#">Comité Académico del Archivo Alfredo Zalce</a></li>
                  <li><a href="#">Comité Académico de Formación Complementaria</a></li>
                  <li><a href="#">Comité Académico de Bibliotecas</a></li>
                  <li><a href="#">Comité Académico Editorial</a></li>
                  <li><a href="#">Comité Académico de Idiomas y Mediateca</a></li>
                  <li><a href="#">Comité del Laboratorio de Microscopia</a></li>
                  <li><a href="#">Comité de Educación Continua</a></li>
                  <li><a href="#">Comité de Ética</a></li>
                ';


                    while ($line2 = mysqli_fetch_array($result2)) {


                   if ($line2["url"]){
                    echo'<li><span style="color: #666"><strong><a href="conexiones/uploads/'.$line2["url"].'">'.$line2["nombre"].'</a></strong></span>';
                      if($_SESSION['tipo'] == '0'){ //Si el usuario es del tipo administrador: mostrará el botón de eliminar
                         echo'<div class="onKlic" onclick="deleteCom('.$line2["id"].')" style="display: inline-block; margin-left: 8px; "><img src="imagenes/flaticons/eliminar.png" style="width: 15px; heigth: auto;" title="Eliminar"/></div>
                              <div style="display: inline-block; margin-left: 8px; "><a href="editcomite.php?id='.$line2["id"].'"><img src="imagenes/flaticons/edit-icon.png" style="width: 15px; heigth: auto;" title="Editar"/></a></div>';
                      }
                      echo'</li>';
                      }else{
                      echo'<li><span style="color: #666"><strong><a href="#">'.$line2["nombre"].'</a></strong></span>';
                      if($_SESSION['tipo'] == '0'){ //Si el usuario es del tipo administrador: mostrará el botón de eliminar
                         echo'<div class="onKlic" onclick="deleteCom('.$line2["id"].')" style="display: inline-block; margin-left: 8px; "><img src="imagenes/flaticons/eliminar.png" style="width: 15px; heigth: auto;" title="Eliminar"/></div>
                         <div style="display: inline-block; margin-left: 8px; "><a href="editcomite.php?id='.$line2["id"].'"><img src="imagenes/flaticons/edit-icon.png" style="width: 15px; heigth: auto;" title="Editar"/></a></div>';
                      }
                    echo'</li>';
                    }

                }
                echo'
                </ul>
              </div>
              </div>


            </div>';

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
