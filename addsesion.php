<?php
    session_start();
    include "conexiones/conexion.php";
    if(!isset($_SESSION['usuario'])){
        echo '<script> window.location="../consejo_tecnico/index.php"</script>';
    }
	if($_SESSION['tipo'] == '1')
	{
		echo '<script> window.location="../consejo_tecnico/portal.php"</script>';
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
		<script src="js/bootstrap.min.js"></script>

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
							<li><a href="comites.php">COMITÉS</a></li>
              				<li><a href="comisiones.php">COMISIONES</a></li>
							<li><a href="acuerdos.php">ACUERDOS</a></li>
							<li><a href="oficios.php">OFICIOS</a></li>
							<li style="float: right;"><a href="conexiones/logout.php" >Salir</a></li>
            </ul>
					</div>
			</div>

			<div id="principal"></br></br>
				<div class="bloque_desplegable">
					<div class ="titular"><center>SUBIR ORDEN DEL DÍA</center></div></br>

          <form enctype="multipart/form-data" action="conexiones/upload_files.php" method="POST" class="forma">
            <div class="auxiliar">

            <legend>Subir Orden del día</legend>

            <table id="OrdenDia">
              <tr>
                <td><label class="Lform">Nombre de sesión: </label></th>
                <td colspan="3"><input type="text" class="fsesion" style="width:100%;" name="nombre"></td>
              </tr>
              <tr>
                <td><label>Tipo de sesión: </label></th>
                <td><select class="menu" style="width: 100%; margin-bottom:5px;" name="tipo">
                    <option value="Ordinaria">Sesión Ordinaria</option>
                    <option value="Extraordinaria">Sesión Extraordinaria</option>
                  </select></td>
                <td><label class="Lform">Fecha de sesión: </label></th>
                <td><input type="date" class="fsesion" placeholder="AAAA/MM/DD"style="width:100%" name="fecha"></td>
              </tr>
              <tr>
                <td collspan="1"><label class="Lform">Número de sesión: </label></th>
                <td collspan="1"><input type="number" class="fsesion" min="01" max="30" style="width:100%" name="numero"></td>
                <td><label class="Lform">Subir Orden del Día:</label></th>
                <td><input name="archivos[]" type="file" multiple="true" class="file"/><input type="hidden" name="MAX_FILE_SIZE" value="5000000" /> </td>
              </tr>
            </table>
            </br></br>
            <center><input class="btn btn-info" type="submit" value="Registrar Orden del Día"></center>

            </div>
            </form>
							</br></br>
            </div>
					</div>
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
						<center><p>H. Consejo Técnico ENES Morelia</p><a href="fragmentos/PanelControl.php">Ir al Panel de Control</a></center>
					</div>
				</div>
			</div>
			</div>
		</div>
	</body>

	<SCRIPT type="text/javascript">

	$(document).ready(function(){


	$("#continuar").on("click",function(){
		var nPuntos = $('#puntos').val();

			 $.ajax({
						url: "php/tabla_sustrato.php",
						data: {"cantidad": nPuntos},
						type: "post",
						success: function(data){
							$('#tabla_sus').html(data);
						}
				});
	});
});


	</SCRIPT>
</html>
