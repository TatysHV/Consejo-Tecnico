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
                        <li><a href="oficios.php?pag=0">OFICIOS</a></li>';
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

      <span style="color: #0064B9">CONSEJEROS REPRESENTANTES</span></br></br>
        <span style="color: #0064B9">Área de las Humanidades y las Artes (2018-2022)</span></br>
        Consejero Titular: Dr. Félix Alejandro Lerma Rodríguez</br>
        Correo: flerma@enesmorelia.unam.mxsa</br></br>

        Consejero Suplente: Dr. Santiago Cortés Hernández</br>
        Correo: scortes@enesmorelia.unam.mx</br></br>

        <span style="color: #0064B9">Área de las Ciencias Físico-Matemáticas y las Ingenierías (2018-2022)</span></br>
        Consejero Titular: Dr. Mario Rodríguez Martínez</br>
        Correo: mrodriguez@enesmorelia.unam.mx</br></br>

        Consejera Suplente:	Dra. Yesenia Arredondeo León<br>
        Correo: yesenia@enesmorelia.unam.mx</br></br>

        <span style="color: #0064B9">Área de las Ciencias Sociales (2017-2021)</span></br>
        Consejera Titular: Mtra. Claudia Escalera Matamoros</br>
        Correo: cescalera@enesmorelia.unam.mx</br></br>

        Consejero Suplente: Dr. Fernando Antonio Rosete Vergés</br>
        Correo: fernando.rosetev@enesmorelia.unam.mx</br></br>

        <span style="color: #0064B9">Área de las Ciencias Biológicas, Químicas y de la Salud (2017-2021)</span></br>
        Consejera Titular: Dra. Yunuen Tapia Torres</br>
        Correo: ytapia@enesmorelia.unam.mx</br></br>


        <span style="color: #0064B9">Consejeros Representantes Técnicos Académicos (2016-2020)</span></br>
        Consejero Titular: Mtra. Ana Yesica Martínez Villalba</br>
        Correo: amartinez@enesmorelia.unam.mx</br></br>

        <span style="color: #0064B9">Consejeros Alumnos (2018-2020)</span></br>

        Consejero Titular (HA):	Diana Cotoñeto Luevano</br>
        Correo: diianna.luevano@gmail.com</br></br>

        Consejero Suplente (TIC'S): Carlos Cortés Méndez</br>
        Correo: alcros33@gmail.com</br></br>

        Consejero Titular (ESGL):	Marco Sánchez Mendoza</br>
        Correo: soccermsm98@gmail.com</br></br>

        Consejero Suplente (LCA): Fernando Aldair Valencia Vázquez</br>
        Correo: aldaval.vaz@enesmorelia.unam.mx</br></br>

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
      $("#pie").load("../consejo_tecnico/fragmentos/footer.php");
    }
  </script>
</html>
