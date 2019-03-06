<?php
    session_start();
    include "conexiones/conexion.php";
    if(!isset($_SESSION['usuario'])){
        echo '<script> window.location="2016/consejo_tecnico/index.php"</script>';
    }
	if($_SESSION['tipo'] == '1')
	{
		echo '<script> window.location="2016/consejo_tecnico/portal.php"</script>';
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
    <script src="js/down_value.js"></script>
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
							<li class="active"><a href="actas.php">ACTAS</a></li>
							<li><a href="sesiones.php">SESIONES</a></li>
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
					<div class ="titular"><center>SUBIR NUEVA ACTA</center></div></br>

          <form id="frm_addActa" enctype="multipart/form-data" action="conexiones/upload_files.php" method="POST" class="forma">
            <div class="auxiliar">

            <legend>Subir acta de la sesión</legend>

            <table id="OrdenDia">
              <tr>
                <td><label class="Lform">Nombre del acta: </label></th>
                <td colspan="3"><input type="text" class="fsesion" style="width:100%;" name="nombreSA"></td>
              </tr>
              <tr>
                <td><label>Tipo de sesión: </label></th>
                <td><select class="menu" style="width: 100%; margin-bottom:5px;" name="tipoSA">
                    <option value="Ordinaria">Sesión Ordinaria</option>
                    <option value="Extraordinaria">Sesión Extraordinaria</option>
                  </select></td>
                <td><label class="Lform">Fecha de sesión: </label></th>
                <td><input type="date" class="fsesion" placeholder="AAAA/MM/DD"style="width:100%" name="fechaSA"></td>
              </tr>
              <tr>
                <td collspan="1"><label class="Lform">Número de sesión: </label></th>
                <td collspan="1"><input type="number" class="fsesion" min="01" max="30" style="width:100%" name="numeroSA"></td>
                <td><label class="Lform">Subir acta:</label></th>
                <td><input id="actapdf" name="acta[]" type="file" class="file"/><input type="hidden" name="MAX_FILE_SIZE" value="90000000" /> </td>
              </tr>
              <tr>
                <td><label class="Lform">Subir minuta:</label></td>
                <td><input id="minuta" name="minuta[]" type="file" class="file"/><input type="hidden" name="MAX_FILE_SIZE" value="90000000" /></td>
              </tr>
            </table>
            </br></br>
            <center><input class="btn btn-info" type="button" onclick="registrar_acta()" value="Registrar Acta"></center>

            </div>
            </form>
							</br></br>
            </div>
					</div>
			</div>
			<div id="pie">

			</div>
			</div>
		</div>
	</body>

	<SCRIPT type="text/javascript">

    window.onload = cargarFooter();
    function cargarFooter(){
      $("#pie").load("../consejo_tecnico/fragmentos/footer.php");
    }


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
