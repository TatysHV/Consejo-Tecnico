<?php
include "conexiones/conexion.php";
session_start(); ?>

<!Doctype html>
<html lang="es">
	<head>
		<title>Consejo Técnico</title>
		<meta charset="utf-8"/>
		<link type="text/css" rel="stylesheet" href="Bootstrap/css/bootstrap.min.css"/>
		<script src="js/jquery-3.1.1.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/show_docs.js"></script>
		<script src="js/down_value.js"></script>
		<link type="text/css" rel="stylesheet" href="style.css"/>
		<link type="text/css" rel="stylesheet" href="fonts.css"/>
		  <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.css">
		<link href='https://fonts.googleapis.com/css?family=Cinzel:400,700|Open+Sans:400,700' rel='stylesheet' type='text/css'/>
		<link href='https://fonts.googleapis.com/css?family=Alegreya+Sans:400,500,700' rel='stylesheet' type='text/css'/>

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


				<?php
					$ID = $_GET['sesion'];
					if(!isset($_GET['sesion'])){
   					   echo '<script> window.location="/consejo_tecnico/portal.php"</script>';
  					}

					if(!isset($_GET['sesion'])){
						echo '<script> window.location="/consejo_tecnico/sesiones.php"</script>';
					}


					@$conexion = mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());

					if (!mysqli_select_db($conexion, $db))
  					{
    						echo "<h2>Error al seleccionar la base de datos!!!";
    						header("Location: sesiones.php");
    						exit;
  					}

					$sql= "SELECT s.nombre, s.id_sustrato, s.numero FROM orden_dia as o inner join orden_tiene as t inner join sustrato as s
					on o.id = t.id_orden and t.id_sustrato = s.id_sustrato where t.id_orden='$ID' ORDER BY s.numero ASC";
					$resultado = mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());

					$query= 'SELECT * FROM orden_dia WHERE id = '.$ID.'';
					$result = mysqli_query($conexion, $query) or die();

					if($line = mysqli_fetch_array($result)){

					echo '
					</br></br>
					<center>
						<h3>Orden del día de la sesión <span style="text-transform:lowercase; color: #0080FF;">'.$line["tipo"].'</span> número <span style="text-transform:lowercase; color: #0080FF;">'.$line["numero_sesion"].'</span></h3>
					</center>';

						if($_SESSION['tipo'] == '0'){
							echo '<a style="float:right; margin-right: 20px; margin-top: -40px;" class="btn btn-warning" href="editsesion.php?sesion='.$ID.'">Editar Orden Día<a/>
								<a style="float:right; margin-right: 20px;" class="btn btn-danger" onclick="delete_orden_dia('.$ID.')">Eliminar Orden del Día</a><br><br><br>';
						}

					echo '
					<div class="bloque_sesion" style="padding: 15px;">
						ID Orden día: <input type="button" id="id_ordenDia" value=" '.$line["id"].'"/>
						<div id="pdf">
							<embed src="conexiones/uploads/'.$line["direccion"].'" width="100%" height="1100"></embed>
						</div>
						<div id="menu" onclick="show_menu()">
							<center><span class="icon-menu" style="font-size: 30px;"></span></center>
						</div>
						<div class="menu-sustrato" id="menu-sustrato">
							<div id="bt-deslizante" onclick="hide_menu()">
								<img src="imagenes/flaticons/flechita.png" style="opacity: 0.9; width: 15px; height: auto;">
							</div>
							<div id="sustrato">
								<div class="titulo_sustrato"><center><br>CONTENIDO</center></div>


									';
									while ($sus = mysqli_fetch_array($resultado)){
							$padre = 0;
							/*<div id="punto" onclick="desplegar_docs('.$sus["id_sustrato"].')">*/
						  echo '<div id="wrap"> 
						  			<div id="punto" onclick="desplegar_docs('.$sus["id_sustrato"].','.$padre.')">
										<span class="icon-folder"></span>
										<b>'.$sus["numero"].'.</b>  '.$sus["nombre"].'
										<div class="edit" onclick="delete_punto('.$sus["id_sustrato"].','.$sus['numero'].','.$ID.')">  	
											<i class="fa fa-window-close" aria-hidden="true"></i>
										</div>
										<div class="edit" >
											<a href="editar_contenido.php?orden='.$line["id"].'&punto='.$sus["numero"].'&idpunto='.$sus["id_sustrato"].'">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</a>
										</div>
									</div>
									<div id="puntos'.$sus["id_sustrato"].'" style="width: 85%; margin:auto;">
									</div>
									<input type="hidden" value="0" id="vista'.$sus["id_sustrato"].'"/>
							   		
							   	</div>';
							}
						echo '
							</div>
						</div>
					</div>
				';
				}
mysqli_close($conexion);

		?>
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
	</body>
</html>
