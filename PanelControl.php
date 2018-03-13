<?php
  session_start();
  include "conexiones/conexion.php";
  if(!isset($_SESSION['usuario'])){
      echo '<script> window.location="../../index.php"</script>';
  }
	if($_SESSION['tipo'] == '1')
	{
		echo '<script> window.location="../../portal.php"</script>';
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
    <script src="js/down_value.js"></script>
    <script src="js/show_docs.js"></script>

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
							<li><a href="sesiones.php">SESIONES</a></li>
							<li><a href="calendario.php">CALENDARIO</a></li>
							<li><a href="normatividad.php">NORMATIVIDAD</a></li>
							<li><a href="acuerdos.php">ACUERDOS</a></li>
							<li><a href="oficios.php">OFICIOS</a></li>
							<li style="float: right;"><a href="conexiones/logout.php" >Salir</a></li>
            </ul>
					</div>
			</div>

			<div id="principal" style="padding-top: 60px; "></br></br>
        <div class="bloque-blank">
          <legend>Gestión de Calendario</legend>
          <ul>
            <li><a onclick="showEditCalGral()" class="onKlic">Cambiar calendario general</a></li>
              <div id="editCalGral" class="notaEdit oculto">
                <h5>Seleccionar imagen para usar en calendario general</h5>
                <form id="frm_CalendarGral" >
                  <input type="file" class="file" id="calendarioSesiones" name="cal_gral[]" style="width: 400px; display:inline-block"><input type="button" style="display:inline-block; margin-left: 10px;" value="Aceptar" onclick="subirCalendario('calgeneral')"/><input type="button" style="display:inline-block; margin-left: 10px;" value="Cancelar" onclick="hideEditCalGral()"/>
                  <br>
                </form>
                <br>
              </div>
            <li><a onclick="showEditCalSes()" class="onKlic">Cambiar calendario de sesiones</a></li>
              <div id="editCalSes" class="notaEdit oculto">
                <h5>Seleccionar imagen para usar en calendario de sesiones</h5>
                <form id="frm_CalendarSes">
                  <input type="file" class="file" id="calendarioSesiones" name="cal_ses[]" style="width: 400px; display:inline-block"><input type="button" style="display:inline-block; margin-left: 10px;" value="Aceptar" onclick="subirCalendario('calsesiones')"/><input type="button" style="display:inline-block; margin-left: 10px;" value="Cancelar" onclick="hideEditCalSes()"/>
                  <br>
                </form>
              </div>
          </ul>

        </div>
        <div class="bloque-blank">
          <legend>Gestión de normatividad</legend>
          <ul>
            <li><a class="onKlic">Cambiar reglamento general</a></li>
            <div id="editCalSes" class="notaEdit oculto">
              <h5>Seleccionar archivo PDF de reglamento general</h5>
              <form>
                <input type="file" class="file" id="calendarioSesiones" style="width: 400px; display:inline-block"><input type="button" style="display:inline-block; margin-left: 10px;" value="Aceptar" onclick="calendarioSesiones()"/>
                <br>
              </form>
            </div>
            <li><a class="onKlic">Cambiar reglamento del Consejo Técnico</a></li>
            <div id="editCalSes" class="notaEdit oculto">
              <h5>Seleccionar archivo PDF de reglamento del Consejo Técnico</h5>
              <form>
                <input type="file" class="file" id="calendarioSesiones" style="width: 400px; display:inline-block"><input type="button" style="display:inline-block; margin-left: 10px;" value="Aceptar" onclick="calendarioSesiones()"/>
                <br>
              </form>
            </div>
          </ul>
        </div>

        <div class="bloque-blank">
          <legend>Gestión de usuarios</legend>
          <ul>
            <li><a onclick="show_users_table()" class="onKlic">Consultar usuarios registrados</a></li>
            <li><a onclick="show_add_user()" class="onKlic">Registrar nuevo usuario</a></li>
          </ul>
        </div>

        <div class="bloque-blank" id="tabla_usuarios">
          <!--CARGA DESDE AJAX-->
        </div>
        <div id="bloque_edicion_usuario">
          <!--CARGA DESDE AJAX-->
        </div>
				<div id="bloque_registrar_usuario" class="bloque_desplegable" style="width: 80%; display:none;">

					<div class ="titular"><center>REGISTRAR NUEVO USUARIO</center></div></br>

          <form enctype="multipart/form-data" action="" method="POST" class="forma">
            <div class="auxiliar">

            <center><!--<legend>Datos del usuario</legend>-->
              <br><br>

            <table id="newUser" style="width: 400px;">
              <tr>
                <td colspan="2"><label class="Lform">Nombre: </label></td>
                <td colspan="2"><input type="text" class="fsesion" style="width:100%;" id="userName" name="nombre" placeholder="Nombre de usuario"></td>
              </tr>
              <tr>
                <td colspan="2"><label>Contraseña: </label></td>
                <td colspan="2"><input type="text" class="fsesion" style="width:100%;" id="userPass" name="password" placeholder="Asignar contraseña"></td>
              </tr>
              <tr>
                <td colspan="2"><label>Descripción: </label></td>
                <td colspan="2"><input type="text" class="fsesion" style="width:100%;" id="userDesc" name="descripcion" placeholder="Nota o recordatorio"></td>
              </tr>
              <tr>
                <td colspan="2"><label>Permisos: </label></td>
                <td colspan="2"><select id="userType" >
                                <option value="0">Todos</option>
                                <option value="1">Limitados</option>
                                </select>
                </td>
              </tr>
            </table>
            </br></br>
            <center><input class="btn btn-info" onclick="addUser()" value="Registrar"></center>
          </center>
            </div>
            </form>
							</br></br>
            </div>
            </br></br>
					</div>
			<div id="pie">
			</div>
    </div>
	</body>
  <script>
    window.onload = cargarFooter();
    function cargarFooter(){
      $("#pie").load("../consejo_tecnico/fragmentos/footer.php");
    }
  </script>
</html>
