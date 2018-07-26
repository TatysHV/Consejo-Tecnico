<?php

include "conexion.php";

$func = $_POST['funcion'];

switch ($func) {
  case 0:
    add_acuerdo();
    break;

  case 1:
    add_acuerdo_file();
    break;
}

function add_acuerdo(){
  include "conexion.php";

  $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

  $titulo = $_POST['nombreAcuerdo'];
  $etiqueta = $_POST['etiquetaAC'];
  $fecha = $_POST['fechaActa'];
  $url_acta = $_POST['url_acta'];
  $acuerdo = $_POST['acuerdo'];
  $observaciones = $_POST['observaciones'];
  $estatus = $_POST['estatusAcuerdo'];

  /*if($url_acta!=""){*/
    //----------Subir cada uno de los archivos a la carpeta del servidor
    foreach($_FILES['oficio']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      $oficio = basename($_FILES['oficio']['name'][$i]);
      $url = basename($_FILES['oficio']['name'][$i]);

      if (strlen($_FILES['oficio']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['oficio']['tmp_name'][$i], $target_path.$name)) {

        }else{echo "Error, no se han subido los archivos";}
      }
    }

    foreach($_FILES['oficio']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      $oficio_word = basename($_FILES['oficio_word']['name'][$i]);

          if (strlen($_FILES['oficio_word']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['oficio_word']['tmp_name'][$i], $target_path.$name)) {

        }else{echo "Error, no se han subido los archivos";}
      }
    }

    foreach($_FILES['acta_admin']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      $acta_admin = basename($_FILES['acta_admin']['name'][$i]);

      if (strlen($_FILES['acta_admin']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['acta_admin']['tmp_name'][$i], $target_path.$name)) {

        }else{echo "Error, no se han subido los archivos";}
      }
    }

    $query= mysqli_query($con, "INSERT INTO acuerdos(etiqueta, acuerdo, observaciones, estatus, oficio, oficio_word, acta_admin, titulo, fecha_acta, pdf_acta) VALUES ('$etiqueta','$acuerdo','$observaciones','$estatus','$oficio','$oficio_word','$acta_admin','$titulo','$fecha', '$url_acta')");

    if(!$query){
      die('Error al registrar el acuerdo:');
    }
    else{
      echo 'Acuerdo registrado correctamente';
    }

    //------ Registro de archivos de seguimiento ------------------------------//
    //-------Obtener id del último acuerdo registrado--------------------------//
    $result = mysqli_query($con, "SELECT MAX(id) AS id FROM acuerdos") or die ('<b>Error al obtener id_acuerdo</b>' . mysql_error($con));
    if ($row = mysqli_fetch_array($result)) {
         $id_acuerdo = trim($row[0]);
    }

    add_acuerdo_file($id_acuerdo); //Función que se encarga de subir cada uno de los archivos seleccionados como seguimieto.

  /*}
  else{
    echo 'Debes seleccionar el acta a la que pertenece el acuerdo';
  }*/
}


function add_acuerdo_file($id_acuerdo){
  include "conexion.php";

  $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos


  //----------Subir cada uno de los archivos a la carpeta del servidor
  foreach($_FILES['acuerdo_files']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
    //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

    //----------- Subir la info de cada archivo a la base de datos------------

    $name = basename($_FILES['acuerdo_files']['name'][$i]);
    $query= mysqli_query($con, "INSERT INTO acuerdos_files(id_acuerdo, name, url) VALUES ('$id_acuerdo','$name','$name')");

    if(!$query){
      die('Error al registrar archivos de seguimiento');
    }
    else{
      //echo 'Archivos de seguimiento registrados';
    }

    //---------------- Sube los archivos al servidor ---------------------------
    if (strlen($_FILES['acuerdo_files']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
      if (move_uploaded_file($_FILES['acuerdo_files']['tmp_name'][$i], $target_path.$name)) {

      }else{echo "Error, no se han subido los archivos";}
    }
  }
}



 ?>
