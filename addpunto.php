
<?php
    session_start();
    include "conexiones/conexion.php";
    if(!isset($_SESSION['usuario'])){
        echo '<script> window.location="/consejo_tecnico/index.php"</script>';
    }
    if($_SESSION['tipo'] == 1)
	{
		echo '<script> window.location="/consejo_tecnico/portal.php"</script>';
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
							<li><a href="sesiones.php">SESIONES</a></li>
							<li><a href="calendario.php">CALENDARIO</a></li>
							<li><a href="normatividad.php">NORMATIVIDAD</a></li>
							<li><a href="acuerdos.php">ACUERDOS</a></li>
							<li><a href="oficios.php">OFICIOS</a></li>
							<li class="active"><a href="addpunto.php">Modificar</a></li>
            </ul>
					</div>
			</div>

			<div id="principal"></br></br>
				<div class="bloque_desplegable">
					<div class ="titular"><center>MODIFICAR SUSTRATO</center></div></br>

						<form enctype="multipart/form-data" action="desplegar_archivos()" method="POST" class="forma">
							<div class="auxiliar">
							<?php
								include "conexiones/conexion.php";
								$conexion = @mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());

								if (!mysqli_select_db($conexion, $db))
								{
								    echo "<h2>Error al seleccionar la base de datos!!!";
								    echo '<script> window.location="/consejo_tecnico/portal.php"</script>';
							    	exit;
					  			}
								$ID = $_GET['sesion'];
								if(!isset($_GET['sesion'])){
									echo '<script> window.location="/consejo_tecnico/portal.php"</script>';
								}

								$sql= "SELECT distinct s.id_sustrato, s.nombre FROM orden_dia as o inner join orden_tiene as t inner join sustrato as s INNER JOIN archivo_sustrato as au INNER JOIN archivo as a on o.id = t.id_orden and t.id_sustrato = s.id_sustrato and a.id = au.id_archivo and au.id_sustrato = s.id_sustrato where t.id_orden='$ID'";
								$resultado = mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());

								echo '<legend><H1>Elegir Sustrato </H1></legend>';
								echo '<select class="menu" name="seleccion" id="seleccion">';

								while ($line = mysqli_fetch_array($resultado)){

									   	 echo '<option value="'.$line["id_sustrato"].'">'.$line["nombre"].'</option>';


								}
								echo '</select>
									&nbsp;&nbsp;<input class="btn btn-info" value="Continuar" id="continuar">
							<table id="OrdenDia">
								<tr>
									<th id="resultado">

									</th>
								</tr>
								<tr id="msustrato">
								</tr>
								</table>
								';

								mysqli_close($conexion);

							?>









							</div>
							</br></br>

							</br></br>
<!--/////////////////////////////////////////////////////////////-->
						</form>
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
						<center><p>H. Consejo Técnico ENES Morelia</p></center>
					</div>
				</div>
			</div>
			</div>
		</div>
	</body>

	<SCRIPT type="text/javascript">

	$(document).ready(function(){


	$("#continuar").on("click",function(){
		var nPuntos = $('#seleccion').val();

			 $.ajax({
						url: "php/modifica.php",
						data: {"id": nPuntos},
						type: "post",
						success: function(data){
							$('#resultado').html(data);
						}
				});
	});
});
</SCRIPT>
</html>
