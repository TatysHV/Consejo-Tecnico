<?php

//Sube los archivos a un punto específico de la orden del dia
  include "conexion.php";

    $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

    $id_archivo;
    $id_carpeta;

    //-------Obtener ID del último punto agregado--------
    $id_punto;
    $result1 = mysqli_query($con, "SELECT MAX(id_sustrato) AS id FROM sustrato") or die ('<b>Error al obtener id_punto</b>' . mysql_error());

    if ($row = mysqli_fetch_array($result1)) {
        $id_punto = trim($row[0]);
    }
    //----------------------------------------------------

   //-----------Obtener la ID de la última carpeta creada (carpeta contenedora)------------
   $result3 = mysqli_query($con, "SELECT MAX(id_carpeta) AS id FROM carpetas") or die ('<b>Error al obtener id_carpeta</b>');
   if ($row = mysqli_fetch_array($result3)) {
       $id_carpeta = trim($row[0]);
   }


    //----------Subir cada uno de los archivos a la carpeta del servidor
    foreach ($_FILES['file_archivo']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.
      //----------- Subir la info de cada archivo a la base de datos------------
      $nombre = basename($_FILES['file_archivo']['name'][$i]);

      $url=basename($_FILES['file_archivo']['name'][$i]);

      $query = mysqli_query($con, "INSERT INTO archivo (nombre, url, id_carpeta) values ('$nombre', '$url', '$id_carpeta')");

    	if (strlen($_FILES['file_archivo']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
   			if (move_uploaded_file($_FILES['file_archivo']['tmp_name'][$i], $target_path.$name)) {
          //echo '<div class="file_success"><img style="display: inline-block" src="imagenes/success.png"> '.$name.' subido </div>';

          //--------Obtener id del último archivo añadido------------
          $result2 = mysqli_query($con, "SELECT MAX(id) AS id FROM archivo") or die ('<b>Error al obtener id_archivo</b>');
          if ($row = mysqli_fetch_array($result2)) {
              $id_archivo = trim($row[0]);
          }
          //-----Registrar ids para crear la relación Punto-Archivo----
          $ejec = mysqli_query($con, "INSERT INTO archivo_sustrato (id_sustrato, id_archivo) values ('$id_punto', '$id_archivo')") or die ('<b>Error al registrar relación</b>');

        }else{echo "Error, no se han subido los archivos";}
   		}
   	}

?>
