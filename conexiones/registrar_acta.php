<?php

/*Registra en la base de datos la nueva acta y sube en archivo a la carpeta de uploads.*/

  $nombre = $_POST['nombreSA'];
  $tipo = $_POST['tipoSA'];
  $fecha = $_POST['fechaSA'];
  $numero = $_POST['numeroSA'];
  $fichero="".basename($_FILES['acta']['name'][0]); //En la posición 0, el array (porque lo dejé permitiendo más de un archivo en el input file).
  //$id_ordendia; //Declaración de variable global para obtener la id de la orden del día.
  $minuta = "".basename($_FILES['minuta']['name'][0]);
  /*+++++++++++++++++++++++++++++++++++++++++
    SUBIR A LA BASE DE DATOS EL ACTA
    +++++++++++++++++++++++++++++++++++++++++*/

    include "conexion.php";

    $query = mysqli_query($con, "INSERT INTO actas (nombre, tipo_sesion,
      numero_sesion, fecha_sesion, pdf, minuta) values ('$nombre', '$tipo',  '$numero', '$fecha', '$fichero', '$minuta')")or die("Error al subir el acta" .mysql_error());

    if(!$query){
      echo "Ocurrió un error al registrar el acta" . $query;
    }

  /*+++++++++++++++++++++++++++++++++++++++
    SUBIR EL ARCHIVO A LA CARPETA/SERVIDOR
    +++++++++++++++++++++++++++++++++++++++*/

    $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

    //Subir el archivo del acta
    foreach ($_FILES['acta']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.
   		if (strlen($_FILES['acta']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
   			if (move_uploaded_file($_FILES['acta']['tmp_name'][$i], $target_path.$name)) {
          //Copia el archivo a la dirección específica de la concatenación: ../archivos/ordendia/nombre.
          echo "El archivo ". basename($_FILES['acta']['name'][$i])." se ha sido subido";
        }
   		}
   	}

    //Subir el archivo de la minuta
    foreach ($_FILES['minuta']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.
      if (strlen($_FILES['minuta']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['minuta']['tmp_name'][$i], $target_path.$name)) {
          //Copia el archivo a la dirección específica de la concatenación: ../archivos/ordendia/nombre.
          echo "El archivo ". basename($_FILES['minuta']['name'][$i])." se ha sido subido";
        }
      }
    }
 ?>
