<?php

include "conexion.php";

$func = $_POST['funcion'];

switch ($func) {
  case 0:
    add_acuerdo();
    break;

  case 1:
    // code...
    break;
}

function add_acuerdo(){
  include "conexion.php";

  $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

  $titulo = $_POST['nombreAcuerdo'];
  $etiqueta = $_POST['etiquetaAC'];
  $fecha = $_POST['fechaEtiqueta'];
  $acuerdo = $_POST['acuerdo'];
  $observaciones = $_POST['observaciones'];
  $estatus = $_POST['estatusAcuerdo'];
  $oficio = $_POST['oficio'];


  //----------Subir cada uno de los archivos a la carpeta del servidor
  foreach ($_FILES['oficio']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
    //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

    //----------- Subir la info de cada archivo a la base de datos------------
    $nombre = basename($_FILES['acuerdo_pdf']['name'][$i]);
    $url = basename($_FILES['acuerdo_pdf']['name'][$i]);

    if (strlen($_FILES['acuerdo_pdf']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
      if (move_uploaded_file($_FILES['file_archivo']['tmp_name'][$i], $target_path.$name)) {

      }else{echo "Error, no se han subido los archivos";}
    }
  }

  $query= mysqli_query($con, "INSERT INTO acuerdos(etiqueta, acuerdo, observaciones, estatus, oficio, titulo, fecha) VALUES ('$etiqueta','$acuerdo','$observaciones','$estatus','$oficio','$titulo','$fecha')");

  if(!$query){
    die('Error al registrar el acuerdo:'.mysql_error());
  }
  else{
    echo 'Acuerdo registrado correctamente';
  }

}


 ?>
