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
    <script src="js/show_docs.js"></script>
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
                    echo '<li class="active"><a href="acuerdos.php?pag=0">ACUERDOS</a></li>
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

          <div class ="titular"><center>Modificar acuerdo</center></div></br>


          <?php
            $ID = $_GET["id"];


            $query0 = 'SELECT * FROM acuerdos WHERE id ='.$ID.'';
            $result0 = mysqli_query($con, $query0) or die();

            if($line0 = mysqli_fetch_array($result0)){

              echo '
          <form id="frm_acuerdo" enctype="multipart/form-data" action="conexiones/upload_files.php" method="POST" class="forma">
            <div class="auxiliar">
            <input type="hidden" value="'.$ID.'" name="id">

            <div class="row">
              <div class="col-xs-7">
                <label for="tituloAcuerdo">Título del acuerdo: </label>
                <input class="form-control" id="titulo_acuerdo" type="text" name="nombreAcuerdo" value="'.$line0['titulo'].'">
              </div>
              <div class="col-xs-5">
                <div class="form-group">
                  <label for="estatus">Estatus: </label>
                  <select class="form-control" id="estatus" name="estatusAcuerdo">
                    <option selected>'.$line0["estatus"].'</option>
                    <option>Pendiente</option>
                    <option>En seguimiento</option>
                    <option>Finalizado</option>
                    <option>Cancelado</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                <div id="etiqueta">
                  <div class="form-group">
                    <label for="">Etiqueta:</label><br>';


                      //Primera parte incluye cabecera del select y muestra las etiquetas que pertenecen a secretaría académica

                      $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Secretaría académica' ORDER BY etiqueta ASC";
                      $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

                      echo'
                      <select class="selectpicker" id="etiqueta" name="etiquetaAC" data-width="100%" data-live-search="true">
                      <option value="" selected>'.$line0["etiqueta"].'</option>


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
                      </select>
                   </div>
                  </div>
                <div>
                  <i class="fas fa-plus-circle" style="color: green; font-size: 1.3em"></i>
                  <a data-toggle="modal" data-target="#nueva_etiqueta" clasS="onKlic">Agregar otra etiqueta</a>
                </div>
              </div>

              <div class="col-xs-3">
                <label>Tipo sesión: </label>
                <select class="selectpicker" data-width="100%" id="tipo_sesion1">';

                  //while ($line = mysqli_fetch_array($result)) {
                    if($line0["tipo"] == "Ordinaria"){
                      echo'<option value="Ordinaria">Ordinaria</option>
                      <option value="Extraordinaria">Extraordinaria</option>';

                    }
                    else{
                      echo'<option value="Extraordinaria">Extraordinaria</option>
                      <option value="Ordinaria">Ordinaria</option>';

                    }

                      echo'
                </select>
              </div>

              <div class="col-xs-2">
                <label>Num sesión</label>
                <input type="text" class="form-control" name="numsesion" value="'.$line0['numero_sesion'].'"/>
              </div>

              <div class="col-xs-3">
                <label>Fecha sesión: </label>
                <input type="date" class="fsesion" id="fecha_acuerdo1" value="'.$line0['fecha_acta'].'" style="width:100%; height:34px; border: 1px solid #CCC;" name="fechaActa">
              </div>

            </div>
            <div class="row">
              <div id="acta_acuerdo">

              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <label for="">Acuerdo:</label>
                  <textarea class="form-control" id="acuerdo"  name="acuerdo" rows="3" >'.$line0['acuerdo'].'</textarea>
                </div>

                <div class="form-group">
                  <label for="">Observaciones:</label>
                  <textarea class="form-control" id="observaciones"  name="observaciones" rows="3" >'.$line0['observaciones'].'</textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-6">
                <div class="form-group">
                  <label for="">Oficio PDF</label>
                  <input id="" name="oficio[]" type="file" class="file" style="width: 100%; height: 34px; border: 1px solid #CCC";/><input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                </div>
              </div>
              <div class="col-xs-6">
                <label>Oficio Word:</label>
                <input type="file" class="file" id="" name="oficio_word[]" style="width: 100%; height: 34px; border: 1px solid #CCC">
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6">
                <label>Acta:</label>
                <input type="file" class="file" id="" name="acta_admin[]" style="width: 100%; height: 34px; border: 1px solid #CCC">
              </div>
              <div class="col-xs-6">
                <label>Archivos de seguimiento:</label>
                <input type="file" class="file" id="" name="acuerdo_files[]" style="width: 100%; height: 34px; border: 1px solid #CCC" multiple="true">
              </div>
            </div>

            </br></br>
            <center>
              <input class="btn btn-success" style="width: 250px; margin-left: 5px;" type="button" onclick="edit_acuerdo()" value="Registrar cambios"><input class="btn btn-danger" type="button" value="Cancelar" style="margin-left: 20px" onclick="irPortal()">
            </center>

            </div>
            </form>';
            }
            ?>
              </br></br>
            </div>
        </div>
      <div id="pie">

      </div>
      </div>
  </body>
  <SCRIPT type="text/javascript">

    var caracteres = 0;

    window.onload = cargarFooter();
    window.onload = showActa();

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

  </SCRIPT>
</html>
