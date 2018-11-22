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
      <!--<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>-->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!------------------------------------------------------------------------------------>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
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
        <input type="hidden" id="pag_acuerdos" value="0">

        <div id="modal_anexos">

        </div>

        <div id="modal_tablaseguimiento">
          <div class="modal" id="tabla_seguimiento" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <center><h3 class="modal-title">Tabla de seguimiento</h3></center>
                  </button>
                </div>
                <div class="modal-body">
                  <table class="table thead-dark table-bordered" id="oficios">
                    <thead>
                      <tr>
                        <th>Turnado a</th>
                        <th>Dependencia</th>
                        <th>Responsable</th>
                        <th>Tipo</th>
                        <th>Observaciones</th>
                        <th>Fecha</th>
                        <th>Oficios respuesta</th>
                      </tr>
                      <tr>
                        <td>Nombre de persona</td>
                        <td>Secretaría académica</td>
                        <td>Nombre de responsable</td>
                        <td>Copia de conocimiento</td>
                        <td>Recibió Agustín para firma de Alejando</td>
                        <td>2018/11/21</td>
                        <td><img src="imagenes/flaticons/doc.png"></td>
                      </tr>
                      <tr>
                        <td>Nombre de persona</td>
                        <td>Secretaría académica</td>
                        <td>Nombre de responsable</td>
                        <td>Copia de conocimiento</td>
                        <td>Recibió Agustín para firma de Alejando</td>
                        <td>2018/11/21</td>
                        <td><img src="imagenes/flaticons/doc.png"></td>
                      </tr>
                  </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
        </div>

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
                        <select class="selectpicker" data-width="100%">
                          <option value="">Secretaría académica</option>
                          <option value="">Secretaría de investigación y posgrado</option>
                          <option value="">Secretaría de vinculación</option>
                          <option value="">Servicios escolares</option>
                          <option value="">Otro departamento</option>
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
                        <select class="selectpicker" data-width="100%">
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
                        <input type="date" class="form-control" id="" name="" style="width:100%; border: 1px solid #CCC;"/>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6">
                      <div class="form-group">
                        <label></label>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
              </div>
            </div>
          </div>
        </div>


        <div id="tabla_acuerdos">
          <center><h3 style="color:#3380FF">Oficios del H. Consejo Técnico </h3></center>
          </br></br>
          <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#form_acuerdo">Buscar oficios</button>
          <a class="btn btn-primary" href="add_oficio.php">Registrar nuevo oficio</a>
          </br></br>


          <?php

          $year = date("Y");
          $color = ''; //Variable para guardar un string hexadecimal

          $pag = $_GET['pag']; /* $pag es la pagina actual*/

          $cantidad = 5; // cantidad de resultados por página
          $inicial = $pag * $cantidad;

          $i = $inicial+1; // índice de fila

          /*--------------------------------------------------------------------
           Realizar consulta de acuerdos del año en curso, mostrando de 10 en 10
          ---------------------------------------------------------------------*/
          $sql = "SELECT * FROM oficios WHERE year(fecha_emision) = '$year' LIMIT $inicial, $cantidad";
          //Consulta auxiliar SELECT *, @s:=@s+1 FROM acuerdos, (SELECT @s:= 0) AS s WHERE year(fecha_acta) = '$year'
          $result = mysqli_query($con,$sql) or die('Error al consultar acuerdos');


          //Obtener el total de resultados de la consulta para crear páginas
          $oficios= "SELECT * FROM oficios WHERE year(fecha_emision) = '$year'";
          $result2= mysqli_query($con,$oficios);
          $num_resultados = mysqli_num_rows($result2);
          $pages = intval($num_resultados / $cantidad); //Total/numero de filas


          echo '
              <div style="float: left"><img src="imagenes/indicecolores.png" style="width: 390px; height: auto;" /></div>
              <div style="float: right;"><h5><b>Total de resultados: </b>'.$num_resultados.'</h5></div>
              <table class="table thead-dark table-bordered" id="acuerdos">
               <thead>
                 <tr>
                   <th>N°</th>
                   <th>Folio</th>
                   <th>Fecha oficio</th>
                   <th>Nombre</th>
                   <th>Asunto</th>
                   <th>Dirigido a:</th>
                   <th>Sesión</th>
                   <th>Oficio</th>
                   <th>Anexos</th>
                   <th>Seguimiento</th>
                   <th>Admin</th>
                 </tr>
               </thead>
               <tbody>';
               while ($line = mysqli_fetch_array($result)){

                 switch($line["estatus"]){
                   case 'Finalizado': $color = '#D1ECF1';
                    break;
                   case 'Pendiente': $color = '#FFF3CD';
                    break;
                   case 'Cancelado': $color = '#F8D7DA';
                    break;
                   case 'En seguimiento': $color = '#E2E3E5';
                    break;
                   case 'Completado': $color = '#C3E6CB';
                 }

                 echo '<tr style="background-color:'.$color.'">
                        <td><strong>'.$i.'</strong></td>
                        <td>'.$line["folio"].'</td>
                        <td>'.$line["fecha_emision"].'</td>
                        <td>'.$line["nombre"].'</td>
                        <td>'.$line["asunto"].'</td>
                        <td>'.$line["dirigidoA"].'</td>
                        <td><center>'.$line["tipo_sesion"].' '.$line['numero_sesion'].'</br>'.$line["fecha_sesion"].'</center></td>
                        <td><span title="Ver oficio PDF"><a href="conexiones/uploads/'.$line["oficio_pdf"].'" target="_blank"><img src="imagenes/flaticons/pdf.png"></a></span><br><a href="conexiones/uploads/'.$line["oficio_word"].'" target="_blank"><img title="Ver oficio Word" src="imagenes/flaticons/doc.png"></a></td>
                        <td><span title="Ver archivos anexos"><a type="button" class="onKlic" onclick="show_anexos('.$line["id_oficio"].')"><img src="imagenes/flaticons/folder.png"></a></span></td>
                        <td><center><img src="imagenes/flaticons/folder.png" onclick="show_tabla_seguimiento()" class="onKlic"><br><span title="Agregar seguimiento"><a type="button" href="" data-toggle="modal" data-target="#add_seguimiento"> <img src="imagenes/flaticons/plus.png" style="width: 20px; height:auto;" class="onKlic"></a></span></center></td>
                        <td><a href="editacuerdo.php? ">Editar</a></br><a href="" onclick = "">Eliminar</a></td>
                      </tr>';
                $i = $i+1;
               }

               echo '
                </tbody>
              </table>';?>

              <?php
              /*----------------------------------------------------------------
                              Creación de botones de paginación
              ----------------------------------------------------------------*/
              echo'
              <center>
              <nav aria-label="Page navigation example">
                <ul class="pagination">';

                if($pag>0){
                  echo'<li class="page-item"><a class="page-link" href="acuerdos.php?pag='.($pag-1).'">Anterior</a></li>';
                }
                else{
                  echo'<li class="page-item"><a class="page-link" href="acuerdos.php?pag='.($pag).'">Anterior</a></li>';
                }

                for($li = 0; $li < ($pages+1); $li++){
                      echo'<li class="page-item"><a class="page-link" href="acuerdos.php?pag='.$li.'">'.$li.'</a></li>';
                }

                if($pages>60){ //Es necesario programar lo que sucede en este caso
                    echo'<li class="page-item"><a class="page-link" href="#">...</a></li>';
                }

                echo'<li class="page-item"><a class="page-link" href="acuerdos.php?pag='.($pag+1).'">Siguiente</a></li>
                </ul>
              </nav>
              </center>';

              ?>

              <div>
                <div>
                  <center>
                    <form action="conexiones/create_table.php">
                        <input type="submit" class="btn btn-success" value="Descargar tabla en Excel" />
                    </form>
                  </center>
                </div>
              </div>

              <!--Ventana modal para mostrar la información completa de un acuerdo
               ------------------------------------------------------------------>

               <div id="modal_acuerdo">

               </div>

               <!-- Ventana modal para mostrar NOTAS de acuerdos ----------------->

               <div id="modal_notes">

               </div>

        </div>

        <div id="blablibli" style="width:100%">
          <!-- Modal formulario para la búsqueda de acuerdos -->
          <div class="modal fade" id="form_acuerdo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <center><h4 class="modal-title" id="exampleModalLabel">Filtro de búsqueda de acuerdos</h5></center>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  </button>
                </div>
                <div class="modal-body">
                  <form id="frm_acuerdo" enctype="multipart/form-data" action="conexiones/upload_files.php" method="POST" class="forma">
                    <div class="auxiliar" style="width: 95%">

                    <div class="row">
                      <div class="col-xs-4">
                        <label for"tituloAcuerdo">Año:</label>
                        <select class="selectpicker" id="srch_year" name="" data-width="100%" data-live-search="false" title="Selecciona un año" onchange="bloquear_campos()">
                         <option value="2018">2018</option>
                         <option value="2017">2017</option>
                         <option value="2016">2016</option>
                         <option value="2015">2015</option>
                         <option value="2014">2014</option>
                         <option value="2013">2013</option>
                        </select>
                      </div>
                      <div class="col-xs-8">
                          <div id="etiqueta">
                            <div class="form-group">
                              <label for="">Etiqueta:</label><br>

                              <?php
                                mysqli_set_charset($con,'utf8');
                                //Primera parte incluye cabecera del select y muestra las etiquetas que pertenecen a secretaría académica

                                $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Secretaría académica' ORDER BY etiqueta ASC";
                                $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>');

                                echo'
                                <select class="selectpicker" id="srch_etiqueta" name="etiquetaAC" data-width="100%" data-live-search="true" title="Seleccionar etiqueta">
                                <optgroup label="Secretaría académica">';

                                while ($line = mysqli_fetch_array($result)) {
                                  echo'<option>'.$line["etiqueta"].'</option>';
                                }
                                echo'</optgroup>';

                                //Muestra las etiquetas que pertenecen a servicios escolares
                                $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Servicios escolares' ORDER BY etiqueta ASC";
                                $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>');

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

                                mysqli_close($con);
                                ?>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                        <div class="form-group">
                          <label>Estatus:</label>
                          <select class="selectpicker" id="srch_estatus" data-width="100%" data-live-search="false" title="Seleccionar estatus">
                            <option value="Pendiente">Pendiente</option>
                            <option value="En seguimiento">En seguimiento</option>
                            <option value="Finalizado">Finalizado</option>
                            <option value="Cancelado">Cancelado</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-xs-8">
                        <div class="form-group">
                          <label>Título del acuerdo</label>
                          <input class="form-control" id="srch_titulo" type="text" name="nombreAcuerdo" placeholder="Ingresar el nombre o título del acuerdo">
                      </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <label for"tituloAcuerdo">Contenido del acuerdo:</label>
                        <input class="form-control" id="srch_acuerdo" type="text" name="contAcuerdo" placeholder="Escribe el texto de contenido del acuerdo">
                      </div>
                    </div>
                    </br>
                    <div class="row">
                        <hr/>
                      <div class="col-xs-4">
                        <div class="form-group">
                          <label for="">Busqueda por rango de años:</label>
                        </div>
                      </div>
                      <div class="col-xs-4">
                        <div class="form-group">
                          <select class="selectpicker" id="srch_init" name="" data-width="100%" data-live-search="false" title="Selecciona año de inicio"  onchange="bloquear_campos()" >
                           <option value="2018">2018</option>
                           <option value="2017" >2017</option>
                           <option value="2016">2016</option>
                           <option value="2015">2015</option>
                           <option value="2014">2014</option>
                           <option value="2013">2013</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-xs-4">
                        <select class="selectpicker" id="srch_finish" name="" data-width="100%" data-live-search="false" title="Selecciona año de fin">
                         <option value="2018">2018</option>
                         <option value="2017">2017</option>
                         <option value="2016">2016</option>
                         <option value="2015">2015</option>
                         <option value="2014">2014</option>
                         <option value="2013">2013</option>
                        </select>
                      </div>
                    </div>
                    <br>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" onclick="limpiarFormulario()">Limpiar</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-primary" onclick="busqueda_acuerdos()">Realizar búsqueda por filtro</button>
                </div>
              </div>
            </div>
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

    /*function showActa(){

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
    }*/

    function limpiarFormulario() {
       $("#frm_acuerdo")[0].reset();
       $("#srch_year").selectpicker("refresh");
       $("#srch_etiqueta").selectpicker("refresh");
       $("#srch_finish").selectpicker("refresh");
       // $("#srch_finish").val('default').selectpicker("refresh");
       $("#srch_init").selectpicker("refresh");
       $("#srch_estatus").selectpicker("refresh");

       document.getElementById("srch_init").disabled = false;
       document.getElementById("srch_finish").disabled = false;
       document.getElementById("srch_year").disabled = false;
    }

	</SCRIPT>
</html>
