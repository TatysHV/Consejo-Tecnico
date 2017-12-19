<?php

  $nombre = $_POST['nombre'];
  $tipo = $_POST['tipo'];
  $fecha = $_POST['fecha'];
  $numero = $_POST['numero'];
  $puntos = $_POST['puntos'];
  $fichero="ordendia/".basename($_FILES['archivos']['name'][0]);

  /*+++++++++++++++++++++++++++++++++++++++++
    SUBIR A LA BASE DE DATOS LA ORDEN DEL DIA
    +++++++++++++++++++++++++++++++++++++++++*/

    include "conexion.php";

    $query = mysqli_query($conexion, "INSERT INTO orden_dia (nombre_sesion, tipo, fecha_sesion,
      numero_sesion, cant_puntos, direccion) values ('$nombre', '$tipo', '$fecha', '$numero', '$puntos', '$fichero')");

      if(!$query){
        echo "Ocurrió un error" . $query;
      }
      else{
        echo "EL REGISTRO SE REALIZÓ DE MANERA EXITOSA <br><br>";
        echo "DATOS DE LA ORDEN DEL DÍA <br>"."<b>Nombre:</b> ".$nombre."<br><b>Fecha: </b>".$fecha."<br><b>Tipo:</b> ".$tipo."<br><b>Direccion:</b> ".$fichero."<br>";
      }

  /*+++++++++++++++++++++++++++++++++++++++
    SUBIR EL ARCHIVO A LA CARPETA/SERVIDOR
    +++++++++++++++++++++++++++++++++++++++*/

    $target_path = "../archivos/ordendia/"; // carpeta donde se guardarán los archivos

    foreach ($_FILES['archivos']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.
   		if (strlen($_FILES['archivos']['name'][$i]) > 1) { //Garantiza que la cat de caracteres del nombre sea mayor a 1 (No es esencial).
   			if (move_uploaded_file($_FILES['archivos']['tmp_name'][$i], $target_path.$name)) {
          //Copia el archivo a la dirección específica de la concatenación: ../archivos/ordendia/nombre.
          echo "El archivo <b>". basename($_FILES['archivos']['name'][$i])." </b>ha sido subido.</br>";
        }
   		}
   	}

 /*+++++++++++++++++++++++++++++++++++++++++++
    SUBIR SUSTRATO Y ARCHIVOS
    ++++++++++++++++++++++++++++++++++++++++++*/

/* 1. Consultar el último insert realizado para obtener la ID de la orden del día
   2. Ir registrando en un ciclo cada una de las filas de la tabla del sustrato.
   3. Obtener la ID del punto del sustrato registrato.
   4. Insertar ID_ordendia e ID_sustrato en la tabla de relación.
   */


 ?>

