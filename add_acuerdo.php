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

    <!-- Importación necesaria para la búsqueda inteligente del select etiqueta --->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    <!------------------------------------------------------------------------------->
    <!-- Importar ventana modal -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
      <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
      <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
    <!------------------------------------------------------------------------------------>


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		<link rel="icon" type="image/png" href="">
		<link rel="shortcut icon" href="imagenes/logoUnam.jpg"/>

    <script src="js/jquery-3.1.1.js"></script>


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
              <?php
                  if($_SESSION['tipo'] == '0'){
                    echo '<li class="active"><a href="acuerdos.php">ACUERDOS</a></li>
                    <li><a href="oficios.php">OFICIOS</a></li>';
                  }
              ?>
							<li style="float: right;"><a href="conexiones/logout.php" >Salir</a></li>
            </ul>
					</div>
			</div>

			<div id="principal"></br></br>
				<div class="bloque_desplegable">

          <div class="modal fade" id="nueva_etiqueta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          	<div class="modal-dialog" role="document">
          		<div class="modal-content">
          			<div class="modal-header">
          				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true">&times;</span>
          				</button>
          				<h4 class="modal-title" id="myModalLabel">Agregar nueva etiqueta</h4>
          			</div>
          			<div class="modal-body">
                  <div class="row">
                    <div class="col-xs-12">
                      <form id="frm_addEtiqueta" encrypte="multipart/form-data" action="conexiones/upload.php" method="POST" class="forma">

                        <div class="form-group">
                          <div class="alert alert-danger oculto" role="alert" id="alert-etiqueta-larga">
                            El nombre de la etiqueta es muy largo.
                          </div>
                          <label for="">Nombre de la etiqueta:</label>
                          <input type="text" class="form-control" id="new_etiqueta"  name="new_etiqueta" rows="3" placeholder="Nombre de la etiqueta no más de 150 caracteres" onkeyup="contCaracteres()">
                          <div class="contadorCaracteres" style="color: grey">
                            Has escrito en total: <span id="cantCaract">0</span> caracteres.
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="">Pertenece a:</label>
                          <select class="selectpicker" name="perteneceAC" id="perteneceAC" data-width="100%" title="Seleccionar departamento">
                            <option>Secretaría académica</option>
                            <option>Secretaría de investigación y posgrado</option>
                            <option>Secretaría de vinculación</option>
                            <option>Servicios escolares</option>
                            <option>Comités y comisiones</option>
                          </select>
                        </div>

                        <center><button type="button" class="btn btn-success" onclick="add_etiqueta()">Registrar</button></center>
                      </form>
                    </div>
                  </div>
          			</div>
          		</div>
          	</div>
          </div>

					<div class ="titular"><center>Registro de nuevo acuerdo</center></div></br>
          <!--
          <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#miModal">
          	Abrir modal
          </button>
          -->
          <form id="frm_acuerdo" enctype="multipart/form-data" action="conexiones/upload_files.php" method="POST" class="forma">
            <div class="auxiliar">

            <div class="row">
              <div class="col-xs-12">
                <label for"tituloAcuerdo">Título del acuerdo: </label>
                <input class="form-control" id="titulo_acuerdo" type="text" name="nombreAcuerdo" placeholder="Ingresar el nombre o título del acuerdo">
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6">
                <div id="etiqueta">
                  <div class="form-group">
                    <label for="">Etiqueta:</label><br>

                    <?php
                      //Primera parte incluye cabecera del select y muestra las etiquetas que pertenecen a secretaría académica

                      $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Secretaría académica' ORDER BY etiqueta ASC";
                      $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

                      echo'
                      <select class="selectpicker" id="etiqueta" name="etiquetaAC" data-width="100%" data-live-search="true" title="Seleccionar etiqueta">
                      <optgroup label="Secretaría académica">';

                      while ($line = mysqli_fetch_array($result)) {
                        echo'<option>'.$line["etiqueta"].'</option>';
                      }
                      echo'</optgroup>';

                      //Muestra las etiquetas que pertenecen a servicios escolares
                      $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Servicios escolares' ORDER BY etiqueta ASC";
                      $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

                      echo'
                      <optgroup label="Servicios escolares">';

                      while ($line = mysqli_fetch_array($result)) {
                        echo'<option>'.$line["etiqueta"].'</option>';
                      }
                      echo'</optgroup>';

                      //Muestra las etiquetas que pertenecen a Secretaría de investigación y posgrado
                      $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Secretaría de investigación y posgrado' ORDER BY etiqueta ASC";
                      $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

                      echo'
                      <optgroup label="Secretaría de investigación y posgrado">';

                      while ($line = mysqli_fetch_array($result)) {
                        echo'<option>'.$line["etiqueta"].'</option>';
                      }
                      echo'</optgroup>';

                      //Muestra las etiquetas que pertenecen a Secretaría de vinculación
                      $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Secretaría de vinculación' ORDER BY etiqueta ASC";
                      $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

                      echo'
                      <optgroup label="Secretaría de vinculación">';

                      while ($line = mysqli_fetch_array($result)) {
                        echo'<option>'.$line["etiqueta"].'</option>';
                      }
                      echo'</optgroup>';

                      //Muestra las etiquetas que pertenecen a Comités y comisiones
                      $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Comités y comisiones' ORDER BY etiqueta ASC";
                      $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

                      echo'
                      <optgroup label="Comités y comisiones">';

                      while ($line = mysqli_fetch_array($result)) {
                        echo'<option>'.$line["etiqueta"].'</option>';
                      }

                      echo'</optgroup>
                      </select>';

                      ?>

                    </div>
                  </div>
                <div>
                  <i class="fas fa-plus-circle" style="color: green; font-size: 1.3em"></i>
                  <a data-toggle="modal" data-target="#nueva_etiqueta" clasS="onKlic">Agregar otra etiqueta</a>
                </div>
              </div>

              <div class="col-xs-6">
                <label>Fecha sesión: </label>
                <input type="date" class="fsesion" id="fecha_acuerdo1" placeholder="AAAA/MM/DD" style="width:100%; height:34px; border: 1px solid #CCC;" name="fechaEtiqueta" onchange="showActa()" >
              </div>
            </div>
            <br>
            <div class="row" id="acta_acuerdo">
                <label>Acta a la que pertenece: <label>

            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="">Acuerdo:</label>
                  <textarea class="form-control" id="acuerdo"  name="acuerdo" rows="3" placeholder="Escribir el contenido del acuerdo"></textarea>
                </div>

                <div class="form-group">
                  <label for="">Observaciones:</label>
                  <textarea class="form-control" id="observaciones"  name="observaciones" rows="3" placeholder="Notas u observaciones sobre el acuerdo"></textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label for"estatus">Estatus: </label>
                  <select class="form-control" id="estatus" name="estatusAcuerdo">
                    <option>Entregado</option>
                    <option>Pendiente</option>
                    <option>En seguimiento</option>
                    <option>Completado</option>
                    <option>Cancelado</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label for="">Oficio PDF</label>
                  <input id="actapdf" name="oficio[]" type="file" multiple="true" class="file" style="width: 100%; height: 34px; border: 1px solid #CCC";/><input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                </div>
              </div>
            </div>

            </br></br>
            <center><input class="btn btn-info" type="button" onclick="registrar_acuerdo()" value="Registrar Acta"></center>

            </div>
            </form>
							</br></br>
            </div>
				</div>
			<div id="pie">

			</div>
			</div>
		</div>
	</body>
	<SCRIPT type="text/javascript">

    var caracteres = 0;

    window.onload = cargarFooter();

    function cargarFooter(){
      $("#pie").load("../consejo_tecnico/fragmentos/footer.php");
    }

    function contCaracteres(){
      var etiqueta;
      var cant;

      etiqueta = $("#new_etiqueta").val();
      cant = etiqueta.length;
      $("#cantCaract").html(cant);

      if(cant>150){
        document.getElementById("alert-etiqueta-larga").style.display="block";
      }else{
        document.getElementById("alert-etiqueta-larga").style.display="none";
      }
    }

    function showActa(){
      
      var fecha = String($("#fecha_acuerdo1").val());

      alert(fecha);

      $.ajax({
        url: "/fragmentos/acta_acuerdo.php",
        data: {"fecha":fecha},
        type: "post",
        success: function(data){
          //$('#acta_acuerdo').html(data);
          alert(data);
          alert("hola");
        } 
      });
    }
	</SCRIPT>
</html>
