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
		<script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
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
					$ID = $_GET['acta'];

					if(!isset($_GET['sesion'])){
   					   echo '<script> window.location="2016/consejo_tecnico/portal.php"</script>';
  					}

					if(!isset($_GET['sesion'])){
						echo '<script> window.location="2016/consejo_tecnico/sesiones.php"</script>';
					}


					@$conexion = mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());

					if (!mysqli_select_db($conexion, $db))
  					{
    						echo "<h2>Error al seleccionar la base de datos!!!";
    						header("Location: sesiones.php");
    						exit;
  					}

			/*		$sql= "SELECT s.nombre, s.id_sustrato, s.numero FROM orden_dia as o inner join orden_tiene as t inner join sustrato as s
					on o.id = t.id_orden and t.id_sustrato = s.id_sustrato where t.id_orden='$ID' ORDER BY s.numero ASC";
					$resultado = mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());
					$var1 = 1;*/

					$query= 'SELECT * FROM acta WHERE id = '.$ID.'';
					$result = mysqli_query($conexion, $query) or die();

					if($line = mysqli_fetch_array($result)){

					echo '
					</br></br>
					<center>
						<h3>Orden del día de la sesión <span style="text-transform:lowercase; color: #0080FF;">'.$line["tipo"].'</span> número <span style="text-transform:lowercase; color: #0080FF;">'.$line["numero_sesion"].'</span></h3>
					</center>';

						/*if($_SESSION['tipo'] == '0'){
							echo '<a style="float:right; margin-right: 20px; margin-top: -40px;" class="btn btn-warning" href="editsesion.php?sesion='.$ID.'">Editar Orden Día<a/>
								<a style="float:right; margin-right: 20px;" class="btn btn-danger" onclick="delete_orden_dia('.$ID.')">Eliminar Orden del Día</a><br><br><br>';
						}*/

					echo '
					<div class="bloque_sesion" style="padding: 15px;">
						ID Orden día: <input type="button" id="id_ordenDia" value=" '.$line["id"].'"/>
						<div id="wrap-sesion">';

						if ($line["pdf"]){/*En esta parte revisamos que exista un documento referente a la orden del día*/
							echo '<div id="pdf">
									<embed src="conexiones/uploads/'.$line["pdf"].'" width="100%" height="900px"></embed>
								  </div>';
						}else{
							echo '<div id="pdf">
									<embed src="conexiones/uploads/No_hay.pdf" width="100%" height="900px"></embed>
								  </div>';
						}

						/*
						echo	'<div id="menu" onclick="show_menu()" title="Mostrar Menú">
									<center><img src="imagenes/flaticons/menu.png" style="width: 30px; height:auto;"></center>
								</div>
								<div class="menu-sustrato" id="menu-sustrato">
								<div id="bt-deslizante" onclick="hide_menu()" title="Ocultar Menú">
									<img src="imagenes/flaticons/arrow.png" style="width: 15px; height: auto; margin-top:15px;">
								</div>
								<div id="sustrato" style="overflow: scroll; height:900px;">
									<div class="titulo_sustrato"><center><br>CONTENIDO</center></div>
									<div id="wrap">
									<a href="add_sustrato.php?orden='.$line["id"].'">
									<div id="punto">
										<div>
											<i class="fas fa-plus-circle"></i>&nbsp;&nbsp;Agregar nuevo punto
										</div>
									</div>
									</a>
									</div>


									';
									while ($sus = mysqli_fetch_array($resultado)){
							$padre = 0;
							*/

							/*<div id="punto" onclick="desplegar_docs('.$sus["id_sustrato"].')">
						   echo '<div id="wrap" >
						  			<div id="punto" onclick="desplegar_docs('.$var1,$sus["id_sustrato"].','.$padre.')">
										<span class="icon-folder"></span>
										<b>'.$sus["numero"].'.</b>  '.$sus["nombre"];
									if($_SESSION['tipo'] == '0'){
										echo '
										<div class="edit" onclick="delete_punto('.$sus["id_sustrato"].','.$sus['numero'].','.$ID.')">
											<i class="fa fa-window-close" aria-hidden="true"></i>
										</div>
										<div class="edit">
											<a href="editar_contenido.php?orden='.$line["id"].'&punto='.$sus["numero"].'&idpunto='.$sus["id_sustrato"].'">
												<i class="fas fa-pencil-alt"></i>
											</a>
										</div>
									';
								}
								echo'	</div>
									<div id="puntos'.$var1,$sus["id_sustrato"].'" style="width: 85%; margin:auto;">
									</div>
									<input type="hidden" value="0" id="vista'.$var1,$sus["id_sustrato"].'"/>

							   	</div>';
							   	$var1 = $var1 + 1;
							}
						echo '
						</div>
							</div>
						</div>
					</div>
				';*/
				}
mysqli_close($conexion);

		?>
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
