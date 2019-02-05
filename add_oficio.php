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
              <li><a href="comites.php">COMITÉS</a></li>
              <li><a href="comisiones.php">COMISIONES</a></li>
              <?php
                  if($_SESSION['tipo'] == '0'){
                    echo '<li><a href="acuerdos.php?pag=0">ACUERDOS</a></li>
                    <li class="active"><a href="oficios.php?pag=0">OFICIOS</a></li>';
                  }
              ?>
							<li style="float: right;"><a href="conexiones/logout.php" >Salir</a></li>
            </ul>
					</div>
			</div>

			<div id="principal"></br></br>

        <div id="modal_seguimiento">
          <!-- ---------------- VENTANA MODAL PARA EL REGISTRO DE TABLA DE SEGUIMIENTO --------- -->
          <div class="modal fade" id="add_seguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <center><h4 class="modal-title">Registro de seguimiento</h4></center>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="frm_seguimiento" encrypte="multipart/form-data" method="POST" class="forma">
                    <div class="row">
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label>Turnado a:</label>
                          <input type="text" class="form-control" id="" name="turnadoA"/>
                        </div>
                      </div>
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label>Dependencia:</label>
                          <select class="form-control" data-width="100%" name="dependencia">
                            <option value="Secretaría académica">Secretaría académica</option>
                            <option value="Secretaría de investigación y posgrado">Secretaría de investigación y posgrado</option>
                            <option value="Secretaría de vinculación">Secretaría de vinculación</option>
                            <option value="Servicios escolares">Servicios escolares</option>
                            <option value="Otro departamento">Otro departamento</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label>Responsable:</label>
                          <input type="text" class="form-control" id="" name="responsable"/>
                        </div>
                      </div>
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label>Observaciones:</label>
                          <input type="textarea" rows="5" class="form-control" id="" name="observaciones"/>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label>Tipo: </label>
                          <select class="form-control" data-width="100%" name="tipo">
                            <option value="seguimiento">En seguimiento</option>
                            <option value="modificacion">Solicitud de modificación</option>
                            <option value="completado">Completado</option>
                            <option value="copia">Copia de conocimiento</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-xs-6">
                        <div class="form-group">
                          <label>Fecha: </label>
                          <input type="date" class="form-control" id="" name="fecha" style="width:100%; border: 1px solid #CCC;"/>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6">
                          <div class="form-group">
                            <label>Oficios respuesta</label>
                            <input type="file" name="seguimiento[]" class="file" style="width: 95%; height: 34px; border: 1px solid #CCC"/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer" id="footer-seguimiento">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-primary" onclick="add_seguimiento()">Guardar</button>
                </div>
              </div>
            </div>
          </div>
        </div>



        <div id="form_add_oficio">
				  <div class="bloque_desplegable" >

          <!-- ---------------- VENTANA MODAL PARA REGISTRO DE NUEVA ETIQUETA -------------- -->
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
                          <?php
                          mysqli_set_charset($con,'utf8');  // LÍNEA BENDITA QUE ARREGLA PROBLEMAS DE CARACTERES D: <3
                          //Primera parte incluye cabecera del select y muestra las etiquetas que pertenecen a secretaría académica

                          $sql="SELECT * FROM departamentos ORDER BY nombre ASC";
                          $result = mysqli_query($con, $sql) or die('Error al consultar tabla departamentos' . mysql_error($con));

                          echo'
                          <select class="selectpicker" id="etiqueta" name="dirigido" data-width="100%" data-live-search="false" title="Seleccionar departamento">';

                          while ($line = mysqli_fetch_array($result)) {
                            echo'<option>'.$line["nombre"].'</option>';
                          }
                          echo'<option value="Otro departamento">Otro departamento</option>';
                          echo'</select>';
                          ?>
                        </div>

                        <center><button type="button" class="btn btn-success" onclick="add_etiqueta()">Registrar</button></center>
                      </form>
                    </div>
                  </div>
          			</div>
          		</div>
          	</div>
          </div>

          <!-- ---------------- VENTANA MODAL PARA REGISTRO DE NUEVA DEPENDENCIA -------------- -->
          <div class="modal fade" id="nueva_dependencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel">Agregar nueva dependencia</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-xs-12">
                      <form id="frm_addDep" encrypte="multipart/form-data" action="conexiones/upload.php" method="POST" class="forma">

                        <div class="form-group">

                          <label for="">Nombre de la dependencia:</label>
                          <input type="text" class="form-control" id="new_dependencia"  name="new_dep" rows="3">

                        </div>
                        <center><button type="button" class="btn btn-success" onclick="add_dependencia()">Registrar</button></center>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <!-- -------------- FORMULARIO DE REGISTRO DE NUEVO OFICIO --------------- -->
					<div class ="titular"><center>Registro de nuevo oficio</center></div></br>

          <form id="frm_oficio" enctype="multipart/form-data" method="POST" class="forma">

            <div class="auxiliar">

            <div class="row">
              <div class="col-xs-6">
                <label>Folio del oficio:</label>
                <input class="form-control" id="folio_oficio" type="text" name="folio_oficio" placeholder="H.C.T/000/AAAA">
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label>Fecha de emisión:</label>
                  <input type="date" class="fsesion" id="fecha_emision" name="fecha_emision" style="width:100%; height:34px; border: 1px solid #CCC;"/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6">
                <div id="etiqueta">
                  <div class="form-group">
                    <label>Asunto/etiqueta</label><br>

                    <?php
                      mysqli_set_charset($con,'utf8');
                      //Primera parte incluye cabecera del select y muestra las etiquetas que pertenecen a secretaría académica

                      $query_dep = "SELECT nombre FROM departamentos";

                      $result_dep = mysqli_query($con, $query_dep) or die ('Error al obtener dependencias'.mysqli_error($con));

                      echo'
                      <select class="selectpicker" id="etiqueta" name="etiquetaOF" data-width="100%" data-live-search="true" title="Seleccionar etiqueta">';

                      while($dep = mysqli_fetch_array($result_dep)){

                        $dep_nombre = $dep["nombre"];

                        $query_etiqueta = "SELECT * FROM lista_etiquetas WHERE pertenece = '$dep_nombre' ORDER BY etiqueta ASC";
                        $result = mysqli_query($con, $query_etiqueta) or die('<b>No se encontraron coincidencias</b>');

                        echo'<optgroup label="'.$dep_nombre.'">';

                        while ($line = mysqli_fetch_array($result)) {
                          echo'<option>'.$line["etiqueta"].'</option>';
                        }
                        echo'</optgroup>';

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
                <div class="form-group">
                  <label>Dirigido a:</label>

                  <?php
                  mysqli_set_charset($con,'utf8');  // LÍNEA BENDITA QUE ARREGLA PROBLEMAS DE CARACTERES D: <3
                  //Primera parte incluye cabecera del select y muestra las etiquetas que pertenecen a secretaría académica

                  $sql="SELECT * FROM departamentos ORDER BY nombre ASC";
                  $result = mysqli_query($con, $sql) or die('Error al consultar tabla departamentos' . mysql_error($con));

                  echo'
                  <select class="selectpicker" id="etiqueta" name="dirigido" data-width="100%" data-live-search="false" title="Seleccionar departamento">';

                  while ($line = mysqli_fetch_array($result)) {
                    echo'<option>'.$line["nombre"].'</option>';
                  }
                  echo'<option value="Otro departamento">Otro departamento</option>';
                  echo'</select>';
                  ?>
                </div>
                <div>
                  <i class="fas fa-plus-circle" style="color: green; font-size: 1.3em"></i>
                  <a data-toggle="modal" data-target="#nueva_dependencia" clasS="onKlic">Agregar otra dependencia</a>
                </div>
              </div>
            </div>

            <div class="row">
              <br>
              <div class="col-xs-6">
                <div class="form-group">
                  <label>Nombre del oficio</label>
                  <input type="text" class="form-control" id="nombre_oficio"  name="nombre_oficio">
                </div>
              </div>

              <div class="col-xs-2">
                <label>Tipo sesión: </label>
                <select class="selectpicker" data-width="100%" id="tipo_of" name="tipo_of">
                  <option value="Ordinaria">Ordinaria</option>
                  <option value="Extraordinaria">Extraordinaria</option>
                </select>
              </div>

              <div class="col-xs-2">
                <label>Num sesión:</label>
                <input type="text" class="form-control" name="numsesion_of"/>
              </div>

              <div class="col-xs-2">
                <label>Fecha sesión: </label>
                <input type="date" class="fsesion" name="fechasesion_of" id="fecha_sesion" placeholder="AAAA/MM/DD" style="width:100%; height:34px; border: 1px solid #CCC;">
              </div>

            </div>
            <br>
            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label for="">Oficio PDF:</label>
                  <input id="actapdf" name="oficio_pdf[]" type="file" class="file" style="width: 100%; height: 34px; border: 1px solid #CCC"/><input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                </div>
              </div>
              <div class="col-xs-6">
                <label>Oficio Word:</label>
                <input type="file" class="file" id="" name="oficio_word[]" style="width: 100%; height: 34px; border: 1px solid #CCC">
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label>Estatus</label>
                  <select name="estatus_of" class="form-control" >
                    <option value="entregado">Entregado</option>
                    <option value="seguimiento">En seguimiento</option>
                    <option value="cancelado">Cancelado</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="completado">Completado</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-6">
              </div>
            </div>
            <div class="row">
              <br><br>
              <div style="width: 40%; margin: auto">
                <div class="form-group">
                  <center>
                    <label for="">Anexos:</label>
                    <input id="actapdf" name="anexos[]" type="file" class="file" multiple="true" style="width: 100%; height: 34px; border: 1px solid #CCC";/>
                  </center>
                </div>
              </div>
            </div>
            </br></br>


            <center>
              <input class="btn btn-success" style="width: 250px; margin-left: 5px;" type="button" onclick="add_oficio()" value="Registrar acuerdo">
            </center>
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

      var fecha = $("#fecha_acuerdo1").val();
      var tipo = $("#tipo_sesion1").val();

      //alert(fecha);

      $.ajax({
        url: "../consejo_tecnico/fragmentos/acta_acuerdo.php",
        data: {"fecha":fecha, "tipo":tipo},
        type: "post",
        success: function(data){
          document.getElementById("acta_acuerdo").innerHTML = data;
          //alert("hola");
        }
      });
    }
	</SCRIPT>
</html>
