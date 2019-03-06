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
							<li><a href="acuerdos.php?pag=0">ACUERDOS</a></li>
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
                <h5>Seleccionar <span style="color:orange">imagen</span> para usar en calendario general</h5>
                <form id="frm_CalendarGral" >
                  <input type="file" class="file" id="calendarioSesiones" name="cal_gral[]" style="width: 400px; display:inline-block"><input type="button" style="display:inline-block; margin-left: 10px;" value="Aceptar" onclick="subirCalendario('calgeneral')"/><input type="button" style="display:inline-block; margin-left: 10px;" value="Cerrar" onclick="hideEditCalGral()"/>
                  <br>
                </form>
                <br>
              </div>
            <li><a onclick="showEditCalSes()" class="onKlic">Cambiar calendario de sesiones</a></li>
              <div id="editCalSes" class="notaEdit oculto">
                <h5>Seleccionar <span style="color:orange">imagen</span> para usar en calendario de sesiones</h5>
                <form id="frm_CalendarSes">
                  <input type="file" class="file" id="calendarioSesiones" name="cal_ses[]" style="width: 400px; display:inline-block"><input type="button" style="display:inline-block; margin-left: 10px;" value="Aceptar" onclick="subirCalendario('calsesiones')"/><input type="button" style="display:inline-block; margin-left: 10px;" value="Cerrar" onclick="hideEditCalSes()"/>
                  <br>
                </form>
              </div>
          </ul>

        </div>
        <div class="bloque-blank">
          <legend>Gestión de normatividad</legend>
          <ul>
            <li><a onclick="showEditRegGral()" class="onKlic">Subir nuevo reglamento general UNAM</a></li>
                <div id="reglamentoGral" class="notaEdit oculto" style="padding: 20px;">
                  <center><h4>Subir nuevo reglamento general UNAM</h4></center>
                  </br>
                  <form id="frm_regGral" method="post">
                    <div class="row">
                      <div class="form-group col-sm-6">
                        <label for="exampleInputEmail1">Nombre del reglamento: </label>
                        <input type="text" class="form-control" name="nameNormGral" aria-describedby="emailHelp" placeholder="Ingresar nombre">
                        <small id="blablibli" class="form-text text-muted">Es el nombre que visualizarán los usuarios</small>
                      </div>
                      <div class="form-group col-sm-6">
                        <label for="exampleFormControlFile1">Seleccionar archivo <span style="color:red">PDF</span> del reglamento general</label>
                        <input type="file" class="form-control-file" id="regGral" name="reg_gral[]">
                      </div>
                    </div>
                    <div class="row">
                          <div class="col-sm-6">
                            <button type="button" class="btn btn-primary" style="float: right" onclick="regReglamentoGral()">Aceptar</button>
                          </div>
                          <div class="col-sm-6">
                            <button type="button" class="btn btn-secondary" onclick="hideEditRegGral()">Cancelar</button>
                          </div>
                    </div>
                    </form>
                  </div>
            <li><a onclick="showEditRegCT()" class="onKlic">Subir nuevo reglamento abrobado por el H.CT</a></li>
                <div id="reglamentoCT" class="notaEdit oculto" style="padding: 20px;">
                  <center><h4>Subir nuevo reglamento y o lineamiento</h4></center>
                  </br>
                  <form id="frm_regCT" method="post">
                    <div class="row">
                      <div class="form-group col-sm-6">
                        <label for="exampleInputEmail1">Nombre del reglamento: </label>
                        <input type="text" class="form-control" name="nameNormCT" aria-describedby="emailHelp" placeholder="Ingresar nombre">
                        <small id="blablibli" class="form-text text-muted">Es el nombre que visualizarán los usuarios</small>
                      </div>
                      <div class="form-group col-sm-6">
                        <label for="exampleFormControlFile1">Seleccionar archivo <span style="color:red">PDF</span> del reglamento</label>
                        <input type="file" class="form-control-file" id="regConsejo" name="reg_ct[]">
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-sm-6" >
                        <label for="example-date-input" class="col-2 col-form-label">Fecha de aprobación</label>
                        <div class="col-10">
                          <input class="form-control" type="date" name="fechaReg">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                          <div class="col-sm-6">
                            <button type="button" class="btn btn-primary" style="float: right" onclick="regReglamentoCT()">Aceptar</button>
                          </div>
                          <div class="col-sm-6">
                            <button type="button" class="btn btn-secondary" onclick="hideEditRegCT()">Cancelar</button>
                          </div>
                    </div>
                    </form>
                  </div>
          </ul>
          <!---------------Notificaciones de procesos-------------- -->

          <!--<div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            El nuevo reglamento ha sido registrado con éxito.
          </div>-->


        </div>



        <div class="bloque-blank">
          <legend>Gestión de comités</legend>
          <ul>
            <!--<li><a class="onKlic" onclick="veralerta()">Modificar y/o eliminar comités</a></li>-->
            <li><a onclick="showEditComA()" class="onKlic">Subir nuevo comité de académicos, licenciaturas y programas</a></li>
                <div id="comiteA" class="notaEdit oculto" style="padding: 20px;">
                  <center><h4>Subir nuevo comité de académicos, licenciaturas y programas</h4></center>
                  </br>
                  <form id="frm_comA" method="post">
                    <div class="row">
                      <div class="form-group col-sm-6">
                        <label for="exampleInputEmail1">Nombre del comité: </label>
                        <input type="text" class="form-control" name="nameNomrA" aria-describedby="emailHelp" placeholder="Ingresar nombre">
                        <small id="blablibli" class="form-text text-muted">Es el nombre que visualizarán los usuarios</small>
                      </div>
                      <div class="form-group col-sm-6">
                        <label for="exampleFormControlFile1">Seleccionar archivo <span style="color:red">PDF</span> del comité</label>
                        <input type="file" class="form-control-file" id="regGral" name="reg_a[]">
                      </div>
                    </div>
                    <div class="row">
                          <div class="col-sm-6">
                            <button type="button" class="btn btn-primary" style="float: right" onclick="regComiteA()">Aceptar</button>
                          </div>
                          <div class="col-sm-6">
                            <button type="button" class="btn btn-secondary" onclick="hideEditComA()">Cancelar</button>
                          </div>
                    </div>
                    </form>
                  </div>
            <li><a onclick="showEditComO()" class="onKlic">Subir nuevo comité de otro tipo</a></li>
                <div id="comiteO" class="notaEdit oculto" style="padding: 20px;">
                  <center><h4>Subir nuevo comité de otro tipo</h4></center>
                  </br>
                  <form id="frm_comO" method="post">
                    <div class="row">
                      <div class="form-group col-sm-6">
                        <label for="exampleInputEmail1">Nombre del comité: </label>
                        <input type="text" class="form-control" name="nameNomrO" aria-describedby="emailHelp" placeholder="Ingresar nombre">
                        <small id="blablibli" class="form-text text-muted">Es el nombre que visualizarán los usuarios</small>
                      </div>
                      <div class="form-group col-sm-6">
                        <label for="exampleFormControlFile1">Seleccionar archivo <span style="color:red">PDF</span> del comité</label>
                        <input type="file" class="form-control-file" id="regConsejo" name="reg_o[]">
                      </div>
                    </div>

                    <div class="row">
                          <div class="col-sm-6">
                            <button type="button" class="btn btn-primary" style="float: right" onclick="regComiteO()">Aceptar</button>
                          </div>
                          <div class="col-sm-6">
                            <button type="button" class="btn btn-secondary" onclick="hideEditComO()">Cancelar</button>
                          </div>
                    </div>
                    </form>
                  </div>


                    <li><a onclick="showEditComP()" class="onKlic">Subir nuevo comité de posgrado</a></li>
                        <div id="comiteP" class="notaEdit oculto" style="padding: 20px;">
                          <center><h4>Subir nuevo comité académico de posgrado</h4></center>
                          </br>
                          <form id="frm_comP" method="post">
                            <div class="row">
                              <div class="form-group col-sm-6">
                                <label for="exampleInputEmail1">Nombre del comité: </label>
                                <input type="text" class="form-control" name="nameNomrP" aria-describedby="emailHelp" placeholder="Ingresar nombre">
                                <small id="blablibli" class="form-text text-muted">Es el nombre que visualizarán los usuarios</small>
                              </div>
                              <div class="form-group col-sm-6">
                                <label for="exampleFormControlFile1">Seleccionar archivo <span style="color:red">PDF</span> del comité</label>
                                <input type="file" class="form-control-file" id="regConsejo" name="reg_P[]">
                              </div>
                            </div>

                            <div class="row">
                                  <div class="col-sm-6">
                                    <button type="button" class="btn btn-primary" style="float: right" onclick="regComiteP()">Aceptar</button>
                                  </div>
                                  <div class="col-sm-6">
                                    <button type="button" class="btn btn-secondary" onclick="hideEditComP()">Cancelar</button>
                                  </div>
                            </div>
                          </form>
                  </div>
          </ul>
          <!---------------Notificaciones de procesos-------------- -->

          <!--<div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            El nuevo reglamento ha sido registrado con éxito.
          </div>-->


        </div>


        <div class="bloque-blank">
          <legend>Gestión de comisiones</legend>
          <ul>
            <!--<li><a class="onKlic" onclick="veralerta()">Modificar y/o eliminar comités</a></li>-->
            <li><a onclick="showEditComD()" class="onKlic">Subir nueva comisión dictaminadora</a></li>
                <div id="comisionD" class="notaEdit oculto" style="padding: 20px;">
                  <center><h4>Subir nueva comisión dictaminadora</h4></center>
                  </br>
                  <form id="frm_comD" method="post">
                    <div class="row">
                      <div class="form-group col-sm-6">
                        <label for="exampleInputEmail1">Nombre de la comisión: </label>
                        <input type="text" class="form-control" name="nameNomrD" aria-describedby="emailHelp" placeholder="Ingresar nombre">
                        <small id="blablibli" class="form-text text-muted">Es el nombre que visualizarán los usuarios</small>
                      </div>
                      <div class="form-group col-sm-6">
                        <label for="exampleFormControlFile1">Seleccionar archivo <span style="color:red">PDF</span> de la comisión</label>
                        <input type="file" class="form-control-file" id="regGral" name="reg_d[]">
                      </div>
                    </div>
                    <div class="row">
                          <div class="col-sm-6">
                            <button type="button" class="btn btn-primary" style="float: right" onclick="regComisionD()">Aceptar</button>
                          </div>
                          <div class="col-sm-6">
                            <button type="button" class="btn btn-secondary" onclick="hideEditComD()">Cancelar</button>
                          </div>
                    </div>
                    </form>
                  </div>
            <li><a onclick="showEditComE()" class="onKlic">Subir nueva comisión evaluadora</a></li>
                <div id="comisionE" class="notaEdit oculto" style="padding: 20px;">
                  <center><h4>Subir nueva comisión evaluadora</h4></center>
                  </br>
                  <form id="frm_comE" method="post">
                    <div class="row">
                      <div class="form-group col-sm-6">
                        <label for="exampleInputEmail1">Nombre de la comisión: </label>
                        <input type="text" class="form-control" name="nameNomrE" aria-describedby="emailHelp" placeholder="Ingresar nombre">
                        <small id="blablibli" class="form-text text-muted">Es el nombre que visualizarán los usuarios</small>
                      </div>
                      <div class="form-group col-sm-6">
                        <label for="exampleFormControlFile1">Seleccionar archivo <span style="color:red">PDF</span> de la comisión</label>
                        <input type="file" class="form-control-file" id="regConsejo" name="reg_e[]">
                      </div>
                    </div>

                    <div class="row">
                          <div class="col-sm-6">
                            <button type="button" class="btn btn-primary" style="float: right" onclick="regComisionE()">Aceptar</button>
                          </div>
                          <div class="col-sm-6">
                            <button type="button" class="btn btn-secondary" onclick="hideEditComE()">Cancelar</button>
                          </div>
                    </div>
                    </form>
                  </div>
          </ul>
          <!---------------Notificaciones de procesos-------------- -->

          <!--<div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            El nuevo reglamento ha sido registrado con éxito.
          </div>-->


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

    function veralerta(){
          $('#alerta1').alert();
    }
  </script>
</html>
