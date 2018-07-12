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
		<link href='https://fonts.googleapis.com/css?family=Cinzel:400,700|Open+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Alegreya+Sans:400,500,700' rel='stylesheet' type='text/css'>
		<link rel="icon" type="image/png" href="">
		<link rel="shortcut icon" href="imagenes/logoUnam.jpg"/>
    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/show_docs.js"></script>
    <script src="js/down_value.js"></script>
    <link type="text/css" rel="stylesheet" href="style.css"/>

    <!-- Importación necesaria para la búsqueda inteligente del select etiqueta --->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    <!------------------------------------------------------------------------------->
    <!-- Importar ventana modal -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
      <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
      <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
    <!------------------------------------------------------------------------------------>

    <script src="js/jquery-3.1.1.js"></script>



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
							<li><a href="actas.php">ACTAS</a></li>
							<li><a href="sesiones.php">SESIONES</a></li>
							<li><a href="calendario.php">CALENDARIO</a></li>
							<li><a href="normatividad.php">NORMATIVIDAD</a></li>
              <?php
                  if($_SESSION['tipo'] == '0'){
                    echo '<li class="active"><a href="acuerdos.php">ACUERDOS</a></li>
                    <li><a href="oficios.php">OFICIOS</a></li>';
                  }
              ?>
							<li style="float: right;"><a href="conexiones/logout.php" >Salir</a></li>
            					</ul>
					</div>
			</div>

			<div id="principal">
      </br></br>

      <div class="bloque_desplegable">
          <div class ="titular"><center>Consulta de acuerdos del H. Consejo Técnico</center></div></br>
            <form class="forma" id="frm_search_acuerdo" enctype="multipart/form-data" action="conexiones/upload_files.php" method="POST">
              <div class="auxiliar">
              <div class="row">
                <div class="col-xs-5">
                    <div class="form-group">
                      <label for"">Año acta/sesión:</label>
                      <input type="date" class="fsesion" id="" placeholder="AAAA/MM/DD" style="width:100%; height:34px; border: 1px solid #CCC;" name="" onchange="" >
                    </div>
                </div>
                <div class="col-xs-7">
                  <label>Título del acuerdo:</label>
                  <input class="form-control" id="titulo_acuerdo" type="text" name="nombreAcuerdo" placeholder="Ingresar el nombre o título del acuerdo">
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <div class="form-group">
                    <label>Etiqueta:</label>

                    <?php
                      //Primera parte incluye cabecera del select y muestra las etiquetas que pertenecen a secretaría académica

                      $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Secretaría académica' ORDER BY etiqueta ASC";
                      $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

                      echo'
                      <select class="selectpicker" id="etiqueta" name="etiquetaAC" data-width="100%" data-live-search="true" title="Seleccionar etiqueta">
                      <optgroup label="Secretaría académica">';

                      while ($line = mysqli_fetch_array($result)) {
                        echo'<option>'.$line["etiqueta"].'</option>';
                      }
                      echo'</optgroup>';

                      //Muestra las etiquetas que pertenecen a servicios escolares
                      $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Servicios escolares' ORDER BY etiqueta ASC";
                      $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

                      echo'
                      <optgroup label="Servicios escolares">';

                      while ($line = mysqli_fetch_array($result)) {
                        echo'<option>'.$line["etiqueta"].'</option>';
                      }
                      echo'</optgroup>';

                      //Muestra las etiquetas que pertenecen a Secretaría de investigación y posgrado
                      $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Secretaría de investigación y posgrado' ORDER BY etiqueta ASC";
                      $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

                      echo'
                      <optgroup label="Secretaría de investigación y posgrado">';

                      while ($line = mysqli_fetch_array($result)) {
                        echo'<option>'.$line["etiqueta"].'</option>';
                      }
                      echo'</optgroup>';

                      //Muestra las etiquetas que pertenecen a Secretaría de vinculación
                      $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Secretaría de vinculación' ORDER BY etiqueta ASC";
                      $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

                      echo'
                      <optgroup label="Secretaría de vinculación">';

                      while ($line = mysqli_fetch_array($result)) {
                        echo'<option>'.$line["etiqueta"].'</option>';
                      }
                      echo'</optgroup>';

                      //Muestra las etiquetas que pertenecen a Comités y comisiones
                      $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Comités y comisiones' ORDER BY etiqueta ASC";
                      $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

                      echo'
                      <optgroup label="Comités y comisiones">';

                      while ($line = mysqli_fetch_array($result)) {
                        echo'<option>'.$line["etiqueta"].'</option>';
                      }

                      echo'</optgroup>
                      </select>';

                      ?>

                  </div>
                </div>
              </div>
            </div>
            </form>




            <form class="forma">
              <center>
                <span class="etiquetas">Mostrar acuerdos del año: </span>
                  <select class="menu" id="fecha_acuerdoZ" onchange="showActa()">
                   <option value="2018" selected >2018</option>
                   <option value="2017" >2017</option>
                   <option value="2016">2016</option>
                   <option value="2015">2015</option>
                   <option value="2014">2014</option>
                   <option value="2013">2013</option>
                  </select>
                <a class="btn btn-info" role="button" onclick="showacuerdos()" style="height: 30px; padding-top: 4px;">Consultar</a>
                <?php
                          if($_SESSION['tipo'] == '0')
                            {
                            echo '<a href="add_acuerdo.php" class="btn btn-primary" role="button" style="height: 30px; padding-top: 4px;">+ Agregar nuevo acuerdo</a>';
                            }

                  ?>
                </center>
                <!-- --------------HICE EL CAMBIO DE COLOR DE PANELCONTROL, HICE LA TABLA DE ACTAS EN BD Y COMENCÉ LA INTERFAZ DE ACTAS -->
            </form>
        </div>
        <div id="showyearAcuerdos" style="width: 85%; margin:auto;"></div>
        <div id="emptyAcuerdos"></div></br>
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
