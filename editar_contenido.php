<?php
    session_start();
    include "conexiones/conexion.php";
    if(!isset($_SESSION['usuario'])){
        echo '<script> window.location="2016/consejo_tecnico/index.php"</script>';
    }
    if($_SESSION['tipo'] == 1)
	{
		echo '<script> window.location="2016/consejo_tecnico/portal.php"</script>';
	}

   $id_orden = $_GET['orden'];
   $num_punto = $_GET['punto'];
   echo 'orden: '.$id_orden.'';

?>

<html lang="es">
	<head>
		<title>Consejo Técnico</title>
		<meta charset="utf-8"/>
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="expires" content="0">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.css">
		<link type="text/css" rel="stylesheet" href="Bootstrap/css/bootstrap.min.css"/>
		<!--<script src="js/jquery-3.1.1.js"></script>-->
		<script src="js/show_docs.js"></script>
		<script src="js/down_value.js"></script>
    <script> window.onload = showFilesViewer; </script>
		<link type="text/css" rel="stylesheet" href="style.css"/>
		<link rel="icon" type="image/png" href="">
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
							<li><a href="portal.html">INICIO</a></li>
							<li><a href="actas.php">ACTAS</a></li>
							<li class="active"><a href="sesiones.php">SESIONES</a></li>
							<li><a href="calendario.php">CALENDARIO</a></li>
							<li><a href="normatividad.php">NORMATIVIDAD</a></li>
							<li><a href="acuerdos.php">ACUERDOS</a></li>
							<li><a href="oficios.php">OFICIOS</a></li>
            </ul>
					</div>
			</div>

			<div id="principal">
        <br><br><br><br>

        <div class ="titular1"><center>Modificar punto de la orden del día</center></div></br>
        <div id="edit_punto" style="width: 80%;">
          <img src="imagenes/checklist.png" style="max-width: 60px; height: auto; margin-left: 2%; float: left;"/>
          <table id="tcarpeta">
            <tr>
              <th><center>Punto</center></th>
              <th>Nuevo nombre del punto</th>
              <th></th>
              <th></th>
            </tr>
            <tr>
              <td><center><input type="number" id="newNumPoint" value="<?php echo $num_punto ?>" style="width:50px; text-align:center"></center></td>
              <td style="min-width: 300px">
                <input type="text" class="fsesion" style="width: 100%;" placeholder="Nombre del punto" id="newNamePoint" name="nombre_punto"/>
              </td>
              <td><center><b>Archivo Protegido: </b><input type="checkbox" class="fseseion" id="newProteger" name="proteger"/></center></td>
              <th><center><input type="button" class="btn btn-warning" value="Modificar" onclick="editar_punto()"/></center></th>
            </tr>
          </table>
        </div>

        <div class ="titular1"><center>Agregar nuevo punto a la orden del día</center></div></br>
        <div id="add_punto" style="width: 80%;">
          <img src="imagenes/checklist.png" style="max-width: 60px; height: auto; margin-left: 2%; float: left;"/>
          <table id="tcarpeta">
            <tr>
              <th><center>Punto</center></th>
              <th>Nombre del punto</th>
              <th></th>
              <th></th>
            </tr>
            <tr>
              <td><center><b>1</b></center></td>
              <td style="min-width: 300px">
                <input type="text" class="fsesion" style="width: 100%;" placeholder="Nombre del punto" id="nombre_punto" name="nombre_punto"/>
              </td>
              <td><center><b>Archivo Protegido: </b><input type="checkbox" class="fseseion" id="proteger" name="proteger"/></center></td>
              <th><center><input type="button" class="btn btn-success" value="Crear" onclick="registrar_punto()"/></center></th>
            </tr>
          </table>
        </div>

        <?php
        echo 'ID Orden dia: <input type="button" id="index_orden" value="'.$id_orden.'"/>
        <br>

        <div class="bloque_desplegable1">

					<div class ="titular1"><center>Modificar contenido del punto</center></div></br>

							<div id="add_sustrato">
                <div id="control_puntos">
                  Cont. Puntos: <input type="button" id="indice_puntos" name="indice_puntos" value="0"/><br>
                  Punto visible: <input type="button" id="index_punto" value="'.$num_punto.'" onclick=""/>
                </div>';
                ?>
                <br>
                <div id="panel-sustrato">
                  <div id="punto-tree">
                      <div class="col-xs-5">

                        <div id="anterior" onclick="beforePoint()">
                          <img src="imagenes/flaticons/toLeft.png"/>
                        </div>
                        <div id="nPunto" style="display:inline-block">1</div>. <div id="nombrePunto" style="display:inline-block">Lista de Asistencia</div>
                        <div id="siguiente" onclick="nextPoint()">
                          <img src="imagenes/flaticons/toRight.png"/>
                        </div>

                      </div>
                      <div class="col-xs-7">
                        <input type="button" style="height:34px; width:auto; margin-top:2px; float:right;" class="btn btn-success" value="(+) Nuevo punto" onclick="add_punto()">
                      </div>
                  </div>

                  <div id="smenu">
                    <div class="op-tree">
                      <div class="row">
                        <div class="col-xs-6"><a style="cursor: pointer" onclick="selec_padre()"><img src="imagenes/flaticons/left-arrow(1).png"> Atrás </a></div>
                        <div class="col-xs-6">
                          <input type="button"  id="carp_selec" value="0">
                        </div>
                      </div>
                    </div>

                    <div id="carpetas-tree">
                      <div id="listaContenido">

                      </div>
                    </div>
                    <div class="op-add">
                      <div class="left" onclick="showAddSub()"><center><b>(+) Carpeta</b></center></div>
                      <div class="right" onclick="showAddFil()"><center><b>(+) Archivos</b></center></div>
                    </div>
                  </div>

                  <div id="pnl-main">
                  <div id="navtree"><a href="">Nombre del punto</a> <b> / </b> <a href="">Subcarpeta</a></div>

                  <div id="panel">

            <!------------ INTERFACES PARA AGREGAR CARPETAS Y ARCHIVOS ---------- -->

                    <div id="add_subcarp" style="display: none;">
                      <img src="imagenes/folderBig.png"/ style="width: 60px; height: auto; float: left; margin-left:5%;"></center>
                      <p style="float: right; color: red; cursor: pointer;" onclick="hideAddSub()">[ x ]</p>
                      <table id="tcarpeta">
                        <tr>
                          <th>Crear carpeta nueva</th>
                        </tr>
                        <tr>
                          <td style="min-width: 300px"><input type="text" class="fsesion" style="width: 100%;" placeholder="Nombre de la subcarpeta" id="nombre_subcarp" name="nombre_subcarp"/></td>
                          <th><center><input type="button" class="btn btn-info" value="Crear" onclick="registrar_subcarp()"/></center></th>
                        </tr>
                      </table>
                    </div>

                    <div id="add_archivo" class="archivo" style="display:none;">
                      <img src="imagenes/files.png" style="width:60px; height: auto; float: left; margin-left: 5%; margin-top: 10px;"/>

                      <form method="post" id="frm_addfile" enctype="multipart/form-data">
                        <p style="float: right; color: red; cursor: pointer;" onclick="hideAddFil()">[ x ]</p>
                        <!--input discreto que contiene el tipo de función que ejecutará en subir_sustrato.php-->
                        <input type="text" name="funcion" value="2" style="display:none">
                        <!--input discreto que contiene el tipo de función que ejecutará en subir_sustrato.php-->
                        <table id="tarchivos" width="90%;">
                        <tr>
                          <th>Subir archivos</th>
                          <th></th>
                        </tr>
                        <tr>
                          <td><input type="file" class="file" id="file_archivo" name="file_archivo[]" multiple="true" style="width: 400px;"></td>
                          <td><input type="button" class="btn btn-info" value="Subir" onclick="registrar_archivo()"/></td>

                        </tr>
                        </table>
                      </form>
                    </div>

          <!-----------------INTERFACEZ DE EDICION DE CONTENIDO DE ORDEN DIA --------------- -->
                    <div class="aeditar" id="efolder"></div>

                    <div class="aeditar" id="efile"></div>

                    <div id="update_folder"></div>

                    <div id="update_file"></div>

                  </div>
                </div>

								<div id="menu_files"></div>
					</div>
        </div>

			  </div>

        <br><br>
			<div id="pie">
				<div class="contenido2">
					<div class="col-xs-5" id="f1">
						<div class="row">
							<div class="col-xs-2" id="flat">
								<img src="imagenes/flaticons/location.png"/>
							</div>
							<div class="col-xs-10">
								<p class="ftitulo">Dirección:</p>
								<p class="info"> Morelia, Mich.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-2" id="flat">
								<img  src="imagenes/flaticons/app.png"/>
							</div>
							<div class="col-xs-10">
								<p class="ftitulo">Teléfono:</p>
								<p class="info">(452) 44-33-22-11-00</p>
							</div>
						</div>

					</div>
					<div class="col-xs-2">
					</div>
					<div class="col-xs-5" id="f2">
							<center>
							<p class="ftitulo">Encuentranos también en:</p>
							</center>

							<div class="col-xs-6">
								<img src="imagenes/flaticons/social.png"/>
							</div>
							<div class="col-xs-6">
								<img src="imagenes/flaticons/youtube.png"/>
							</div>

					</div>
					<div id="derechos">
						<center><p>H. Consejo Técnico ENES Morelia</p></center>
					</div>
				</div>
			</div>
			</div>
		</div>
	</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

</html>
