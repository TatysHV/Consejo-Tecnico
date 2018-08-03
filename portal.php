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
		<link type="text/css" rel="stylesheet" href="style.css"/>
		<link href='https://fonts.googleapis.com/css?family=Cinzel:400,700|Open+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Alegreya+Sans:400,500,700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link rel="icon" type="image/png" href="">
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
                <li class="active"><a href="portal.php">INICIO</a></li>
								<li><a href="actas.php">ACTAS</a></li>
								<li><a href="sesiones.php">SESIONES</a></li>
								<li><a href="calendario.php">CALENDARIO</a></li>
								<li><a href="normatividad.php">NORMATIVIDAD</a></li>
								<li><a href="comites.php">COMITÉS</a></li>
              					<li><a href="comisiones.php">COMISIONES</a></li>
								<?php
                if($_SESSION['tipo'] == '0')
                {
                        echo '<li><a href="acuerdos.php?pag=0">ACUERDOS</a></li>
                        <li><a href="oficios.php">OFICIOS</a></li>';
                }
                ?>
								<li style="float: right;"><a href="conexiones/logout.php" >Salir</a></li>
            </ul>
					</div>
			</div>


			<div id="principal" style="font-family:'Open Sans'">

				<img src="imagenes/panorama1.jpg" style="width:100%; height: auto">
        <div class="auxiliar">

				</br>
        <center><h3><span style="color: #0064B9">H. Consejo Técnico</span></h3></center></br></br>
        <p>El Honorable Consejo Técnico de la Escuela Nacional de Estudios Superiores, Unidad Morelia es, junto con la Dirección, la máxima autoridad universitaria. Está conformado por profesores y alumnos con sus respectivos suplentes que son elegidos mediante voto libre y secreto conforme a los lineamientos establecidos para elegibles y electores en el Reglamento para la Elección de Consejeros Universitarios y Técnicos Representantes de Profesores y Alumnos, así como de los criterios emitidos por el Abogado General de la UNAM.</p>

      </p>Todos los representantes del H. C. T. son electos por su comunidad y se reúnen una vez al menos cada 4 semanas.</p></br></br>

        <center><h3><span style="color: #0064B9">DIRECTORIO</span></h3></center>
        <div style="width:60%; margin:auto"><center>
        <span style="color: #0064B9">PRESIDENTE</span></br>
        <span style="color: #0064B9">(Directora)</span></br>
        Dra. Diana Tamara Martínez Ruiz</br>

        Correo: direccion@enesmorelia.unam.mx</br></br>

        <span style="color: #0064B9">SECRETARIO</span></br>
        <span style="color: #0064B9">(Secretario General)</span></br>
        Dr. Víctor Hugo Anaya Muñoz</br>

        Correo: secretaria_general@enesmorelia.unam.mx</br></br>

      <span style="color: #0064B9">CONSEJEROS REPRESENTANTES (2012-2018)</span></br></br>
        <span style="color: #0064B9">Área de las Humanidades y las Artes</span></br>
        Dra. Berenice Araceli Granados Vázquez. Consejera Titular</br>
        Correo: berenice_granados@enesmorelia.unam.mx</br></br>

        Dr. Rodolfo González Equihua. Consejero Suplente</br>
        Correo: rodolfoge@gmail.com</br></br>

        <span style="color: #0064B9">Área de las Ciencias Físico-Matemáticas y las Ingenierías</span></br>
        Dr. Miguel Cervantes Solano. Consejero Titular</br>
        Correo: miguel_cervantes@enesmorelia.unam.mx</br></br>

        <span style="color: #0064B9">Área de las Ciencias Sociales</span></br>
        Mtra. Claudia Escalera Matamoros. Consejera Titular</br>
        Correo: cescalera@enesmorelia.unam.mx</br></br>

        Dr. Fernando Antonio Rosete Vergés. Consejero Suplente</br>
        Correo: fernando.rosetev@enesmorelia.unam.mx</br></br>

        <span style="color: #0064B9">Área de las Ciencias Biológicas, Químicas y de la Salud</span></br>
        Dr. Luis Daniel Ávila Cabadilla. Consejero Titular</br>
        Correo: luis_avila@enesmorelia.unam.mx</br></br>

        Dra. Yunuen Tapia Torres. Consejera Suplente</br>
        Correo: ytapia@enesmorelia.unam.mx</br></br>

        <span style="color: #0064B9">Consejeros Representantes Técnicos Académicos (2016-2020)</span></br>
        Consejero Titular: Dr. José Santiago Arizaga Pérez</br>
        Correo: santiago_arizaga@enesmorelia.unam.mx</br></br>

        Consejero Suplente: Mtra. Ana Yesica Martínez Villalba</br>
        Correo: amartinez@enesmorelia.unam.mx</br></br>

        Consejeros Alumnos (2016-2018)</br>
        Consejero Titular (AAGD): Salvador Luna Perales</br></br>

        Consejero Suplente (LCA): Isaac Rhodart Hernández Zamorano</br></br>

        Consejero Titular (LI): Quetzal Mata Trejo</br></br>

        Consejero Suplente (ESGL): Eduardo Munguía Chocoteco</br></br>

      <span style="color: #0064B9">SECRETARIO AUXILIAR</span></br>
        Lic. Marcela Katia Méndez Flores</br>
        Correo: kmendez@enesmorelia.unam.mx</br>
        Tel. 56237300 y (443) 6893500 Ext. 80614</br></br></br>
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
      $("#pie").load("../consejo_tecnico/fragmentos/footer.html");
    }
  </script>
</html>
