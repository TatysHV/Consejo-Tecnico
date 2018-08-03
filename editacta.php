
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
		<meta charset="utf-8"/>
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="expires" content="0">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
		<link type="text/css" rel="stylesheet" href="Bootstrap/css/bootstrap.min.css"/>
		<script src="js/jquery-3.1.1.js"></script>
		<script src="js/show_docs.js"></script>
		<script src="js/down_value.js"></script>

		<link type="text/css" rel="stylesheet" href="style.css"/>
		<link rel="icon" type="image/png" href="">
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
							<li><a href="portal.html">INICIO</a></li>
							<li class="active"><a href="actas.php">ACTAS</a></li>
							<li><a href="sesiones.php">SESIONES</a></li>
							<li><a href="calendario.html">CALENDARIO</a></li>
							<li><a href="normatividad.html">NORMATIVIDAD</a></li>
              <li><a href="comites.php">COMITÉS</a></li>
              <li><a href="comisiones.php">COMISIONES</a></li>
							<li><a href="acuerdos.html">ACUERDOS</a></li>
							<li><a href="oficios.php">OFICIOS</a></li>
            </ul>
					</div>
			</div>

			<div id="principal"></br></br>
				<div class="bloque_desplegable">
					<div class ="titular"><center>MODIFICAR ACTA</center></div></br>

          <?php
            $ID = $_GET["acta"];


            $query = 'SELECT * FROM actas WHERE id ='.$ID.'';
            $result = mysqli_query($con, $query) or die();

            if($line = mysqli_fetch_array($result)){

            echo '
            <form enctype="multipart/form-data" action="conexiones/update_acta.php" method="POST" class="forma">
              <div class="auxiliar">
                <input type="hidden" value="'.$ID.'" name="id_acta">

            <table id="OrdenDia">
              <tr>
                  <td><label class="Lform">Nombre del acta: </label></th>
                  <td colspan="3"><input type="text" class="fsesion" style="width:100%;" name="nombre" value="'.$line["nombre"].'"></td>
                </tr>
                <tr>
                  <td><label>Tipo de sesión: </label></th>
                  <td><select class="menu" style="width: 100%; margin-bottom:5px;" name="tipo">
                      ';

                      if($line["tipo_sesion"] == "Ordinaria"){
                        echo'<option value="Ordinaria">Ordinaria</option>
                        <option value="Extraordinaria">Extraordinaria</option>';
                      }
                      else{
                        echo'<option value="Extraordinaria">Extraordinaria</option>
                        <option value="Ordinaria">Ordinaria</option>
                        ';
                      }
                      echo '
                    </select></td>
                  <td><label class="Lform">Fecha de sesión: </label></th>
                  <td><input type="date" class="fsesion" style="width:100%" name="fecha" value="'.$line["fecha_sesion"].'"></td>
                </tr>
                <tr>
                  <td collspan="1"><label class="Lform">Número de sesión: </label></th>
                  <td collspan="1"><input type="number" class="fsesion" min="01" max="30" style="width:100%" name="numero" value="'.$line["numero_sesion"].'"></td>
                  <td><label class="Lform">Sustituir acta:</label></th>
                  <td><input name="archivos[]" type="file" multiple="true" class="file"/></td>
                </tr>
                <tr>
                  <td><label class="Lform">Cambiar minuta:</label></td>
                  <td><input id="minuta" name="minuta" type="file" class="file"/><input type="hidden" name="MAX_FILE_SIZE" value="5000000" /></td>
                </tr>
              </table>
              </div>
              <br><br>
              <center><input class="btn btn-success" type="submit" value="Registrar Cambios"><input class="btn btn-danger" type="button" value="Cancelar" style="margin-left: 20px" onclick="irPortal()"></center>
              </form>
              <br><br>
            ';
          }
          ?>

					</div>
			</div>
			<div id="pie">
			</div>
			</div>
		</div>
	</body>
<script>
    window.onload = cargarFooter();
    function cargarFooter(){
      $("#pie").load("../consejo_tecnico/fragmentos/footer.html");
    }
  </script>

</html>
