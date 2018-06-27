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

  $id_orden = $_GET["orden"];

  $orden = mysqli_query($con, "SELECT cant_puntos FROM orden_dia WHERE id='$id_orden'");
    if ($row = mysqli_fetch_array($orden)) {
        $cant_puntos= trim($row[0]);
    }

  $punto = $cant_puntos+1;

?>

<!Doctype html>
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

			<div id="principal"></br></br>

        <div id="tituloZ" style="margin: auto; margin-top: 50px; width: 80%; margin-bottom: 5px;">
          <center><h2 style="color:#4f4f4f">Registro de contenido de la orden del día</h2></center>
        </div>
          <div id="id_ordenDia" style="display:block">ID Orden dia: <input type="button" id="index_orden" value="<?php echo $id_orden ?>"/></div>

        <div class="notas" id="notaAddPunto" style="color:#616161">
          <hr style="height: 1px; width: 100%; background-color: #F0F0F0;"/>
          <p><span>Nota: </span>Permite el registro de un solo punto a la vez, de la orden del día de la sesión del consejo técnico previamente registrada.</p>
          <hr style="height: 1px; width: 100%; background-color: #F0F0F0;"/>
        </div>

        <div id="add_punto" style="width: 80%;">
          <img src="imagenes/checklist.png" style="max-width: 60px; height: auto; margin-left: 2%; float: left;"/>
          <table id="tcarpeta">
            <tr>
              <th><center>Punto</center></th>
              <th>Título</th>
              <th></th>
              <th></th>
            </tr>
            <tr>
              <td><center><input type="number" id="numPoint" value="<?php echo $punto; ?>"style="width:50px; text-align:center"/></td>
              <td style="min-width: 300px">
                <input type="text" class="fsesion" style="width: 100%;" placeholder="Nombre del punto" id="nombre_punto" name="nombre_punto"/>
              </td>
              <td><center><b>Archivo Protegido: </b><input type="checkbox" class="fseseion" id="proteger" name="proteger"/></center></td>
              <th><center><input type="button" id="btnAddPunto" class="btn btn-success" value="Crear" onclick="registrar_punto()"/></center></th>
            </tr>
          </table>
        </div>


        <!--<div style="width:80%; margin:auto; margin-top: 20px; display:none;" id="addp-btn"><input type="button" class="btn btn-info" onclick="add_punto()" value="+ Añadir Nuevo Punto"/></div> -->


				<div class="bloque_desplegable1" id="visor_contenido" style="display:none">
          <div id="edit_punto" style="display: none;"></div>
					<div class ="titular1"><center>Añadir Sustrato de la orden del día</center></div></br>

							<div id="add_sustrato">
                <div id="control_puntos">
                  Cant. Puntos: <input type="button" id="indice_puntos" name="indice_puntos" value="<?php echo $cant_puntos ?>"/><br>
                  Punto visible: <input type="button" id="index_punto" value="0" onclick=""/>
                </div>
                <br>
                <div id="panel-sustrato">
                  <div id="punto-tree">
                      <div class="col-xs-7">

                        <div id="anterior" onclick="beforePoint()">
                          <img src="imagenes/flaticons/toLeft.png"/>
                        </div>
                        <div id="nPunto" style="display:inline-block">1</div>. <div id="nombrePunto" style="display:inline-block">Lista de Asistencia</div>
                        <div id="siguiente" onclick="nextPoint()">
                          <img src="imagenes/flaticons/toRight.png"/>
                        </div>

                      </div>
                      <div class="col-xs-5">
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

                    <div id="carpetas-tree" style="overflow: scroll; height:480px;">
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

                      <form method="post" id="frm_addfile" enctype="multipart/form-data" >
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
				
			</div>
			</div>
		</div>
	</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script>
    window.onload = cargarFooter();
    function cargarFooter(){
      $("#pie").load("../consejo_tecnico/fragmentos/footer.html");
    }
  </script>
</html>
