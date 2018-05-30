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

  $query= mysqli_query($con, "INSERT INTO acuerdos(etiqueta, acuerdo, observaciones, estatus, oficio, titulo, fecha) VALUES ('$etiqueta','$acuerdo','$observaciones','$estatus','$oficio','$titulo','$fecha')");

  if(!$query){
    die('Error al registrar el acuerdo:'.mysql_error());
  }
  else{
    echo 'Acuerdo registrado correctamente';
  }

}


 ?>
