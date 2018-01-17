<?php

/*Registra en la base de datos la nueva sesión (oden del día) y sube en archivo a la carpeta de uploads.*/

  $nombre = $_POST['nombre'];
  $tipo = $_POST['tipo'];
  $fecha = $_POST['fecha'];
  $numero = $_POST['numero'];
  $fichero="".basename($_FILES['archivos']['name'][0]); //En la posición 0, el array (porque lo dejé permitiendo más de un archivo en el input file).
  $id_ordendia; //Declaración de variable global para obtener la id de la orden del día.

  /*+++++++++++++++++++++++++++++++++++++++++
    SUBIR A LA BASE DE DATOS LA ORDEN DEL DIA
    +++++++++++++++++++++++++++++++++++++++++*/

    include "conexion.php";

    $query = mysqli_query($con, "INSERT INTO orden_dia (nombre_sesion, tipo, fecha_sesion,
      numero_sesion, direccion, cant_puntos) values ('$nombre', '$tipo', '$fecha', '$numero', '$fichero',0)")or die("Error al subir" .mysql_error());

	//    if(!$query){
        //echo "Ocurrió un error" . $query;
      //}
      //else{
       // echo "EL REGISTRO SE REALIZÓ DE MANERA EXITOSA <br><br>";
        //echo "DATOS DE LA ORDEN DEL DÍA <br>"."<b>Nombre:</b> ".$nombre."<br><b>Fecha: </b>".$fecha."<br><b>Tipo:</b> ".$tipo."<br><b>Direccion:</b> ".$fichero."<br>";
      //}

  /*+++++++++++++++++++++++++++++++++++++++
    SUBIR EL ARCHIVO A LA CARPETA/SERVIDOR
    +++++++++++++++++++++++++++++++++++++++*/

    $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

    foreach ($_FILES['archivos']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.
   		if (strlen($_FILES['archivos']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
   			if (move_uploaded_file($_FILES['archivos']['tmp_name'][$i], $target_path.$name)) {
          //Copia el archivo a la dirección específica de la concatenación: ../archivos/ordendia/nombre.
          echo "El archivo <b>". basename($_FILES['archivos']['name'][$i])." </b>ha sido subido.</br>";
        }
   		}
   	}

    $result1 = mysqli_query($con, "SELECT MAX(id) AS id FROM orden_dia") or die ('<b>Error al obtener id_ordendia</b>' . mysql_error());
    if ($row = mysqli_fetch_array($result1)) {
         $id_ordendia = trim($row[0]);
        }

/*	echo '<a href="../sesiones.php">Volver Atrás</a>';*/
  header("Location: /2016/consejo_tecnico/add_sustrato.php?orden=$id_ordendia");

 ?>
