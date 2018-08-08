<?php
    session_start();
    include "conexiones/conexion.php";
    if(!isset($_SESSION['usuario'])){
        echo '<script> window.location="/2016/consejo_tecnico/index.php"</script>';
    }

    if (!mysqli_select_db($con, $db))
      {
        echo "<h2>Error al seleccionar la base de datos!!!";
        header("Location: index.php");
        exit;
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
		<link rel="icon" type="image/png" href="">
		<link rel="shortcut icon" href="imagenes/logoUnam.jpg"/>
    <link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.css">
    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/show_docs.js"></script>
    <script src="js/down_value.js"></script>

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
							<li><a href="portal.php">INICIO</a></li>
							<li><a href="actas.php">ACTAS</a></li>
							<li><a href="sesiones.php">SESIONES</a></li>
							<li><a href="calendario.php">CALENDARIO</a></li>
							<li><a href="normatividad.php">NORMATIVIDAD</a></li>
              <li class="active"><a href="comites.php">COMITÉS</a></li>
              <li><a href="comisiones.php">COMISIONES</a></li>
              <?php
                      if($_SESSION['tipo'] == '0')
                      {
                      	echo '<li><a href="acuerdos.php?pag=0">ACUERDOS</a></li>';
							        	echo '<li><a href="oficios.php">OFICIOS</a></li>';
								}
                                                        ?>
							<li style="float: right;"><a href="conexiones/logout.php" >Salir</a></li>
            </ul>
					</div>
			</div>

			<div id="principal">
      </br></br></br>
      <div class="row" style="width: 80%; margin: auto;">
        <div id="comites">
          <!--Carga de manera automática al abrir la página, el reglamento general de la UNAM
          Y mostrará de manera dinámica el reglamento aprobado por el Consejo Técnico dependiendo del año elegido-->
         

          <div class="bloque-blank">
          <center><legend>Modificar Comité</legend></center>
          <ul>
                <div id="comiteA"  style="padding: 20px;">
                 
                  </br>
                  <form id="frm_com" method="post">

                     <?php

            $ID = $_GET["id"];
            $sql="SELECT * FROM comites WHERE id = '$ID'";

            $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($conexion));

            if($line = mysqli_fetch_array($result)){
         echo '<input type="hidden" value="'.$ID.'" name="id">
                    <div class="row">
                      <div class="form-group col-sm-6">
                        <label for="exampleInputEmail1">Nombre del comité </label>
                        <input type="text" class="form-control" name="nameNomr" aria-describedby="emailHelp" value="'.$line["nombre"].'">
                        <small id="blablibli" class="form-text text-muted">Es el nombre que visualizarán los usuarios</small>
                      </div>
                      <div class="form-group col-sm-6">
                        <label for="exampleFormControlFile1">Seleccionar archivo <span style="color:red">PDF</span> del comité</label>
                        <input type="file" class="form-control-file" id="regGral" name="reg[]">
                      </div>
                      <div class="form-group col-sm-6">
                        <label>Tipo de comisión: </label>
                        <select class="selectpicker" data-width="100%" name="tipo">';
                          if($line["tipo"] == "A"){
                            echo'<option value="A">Comité académicos, licenciaturas y programas</option>
                            <option value="O">Comité de otro tipo</option>';
                          }
                          else{
                            echo'<option value="O">Comité de otro tipo</option>
                            <option value="A">Comité académicos, licenciaturas y programas</option>';
                          }
                        echo'
                        </select>
                      </div>
                    </div>
                    <div class="row">
                          <div class="col-sm-6">
                            <button type="button" class="btn btn-success" style="float: right" onclick="editComite()">Guardar cambios</button>
                          </div>
                          <div class="col-sm-6">
                            <button type="button" class="btn btn-danger" onclick="cancelar()">Cancelar</button>
                          </div>
                    </div>';      
                  }
                     ?>
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
        </div>
      </div>

      <!--<div class="f-actualiz" style="margin-left: 11%; margin-top: 40px; color: grey;">
        Última fecha de actualización: 19/04/2018
      </div>
      -->

			</div>
			<div id="pie">
		  </div>
	</body>
  <script>
    window.onload = cargarFooter();
    function cargarFooter(){
      $("#pie").load("../consejo_tecnico/fragmentos/footer.php");
    }

    function cancelar(){
       window.location.assign("../consejo_tecnico/comites.php");
    }
  </script>
</html>
