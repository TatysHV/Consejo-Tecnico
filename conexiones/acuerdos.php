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
  case 2:
    edit_acuerdo();
    break;
  case 3:
    delete_acuerdo();
    break;
  case 4:
    delete_file_seguimiento();
    break;

}

function add_acuerdo(){
  include "conexion.php";

  $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

  $titulo = $_POST['nombreAcuerdo'];
  $etiqueta = $_POST['etiquetaAC'];
  $fecha = $_POST['fechaActa'];
  $acuerdo = $_POST['acuerdo'];
  $observaciones = $_POST['observaciones'];
  $estatus = $_POST['estatusAcuerdo'];
  $tipo = $_POST['tipo_sesion1'];
  $num_sesion = $_POST['numsesion'];

  $aux_files="".basename($_FILES['acuerdo_files']['name'][0]);

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


    $query= mysqli_query($con, "INSERT INTO acuerdos(etiqueta, acuerdo, observaciones, estatus, oficio, oficio_word, acta_admin, titulo, fecha_acta, tipo, numero_sesion) VALUES ('$etiqueta','$acuerdo','$observaciones','$estatus','$oficio','$oficio_word','$acta_admin','$titulo','$fecha','$tipo','$num_sesion') ") or die ('Error al registrar el acuerdo'.mysql_error());

    if(!$query){
      echo 'Error al registrar el acuerdo';
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

    if($aux_files!=""){
      add_acuerdo_file($id_acuerdo); //Función que se encarga de subir cada uno de los archivos seleccionados como seguimieto.
    }
    
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

    //$size = $_FILES['acuerdo_files']['size'][$i];

    $name = basename($_FILES['acuerdo_files']['name'][$i]);

    $result = mysqli_query($con,"SELECT CURDATE()");
    if ($row = mysqli_fetch_array($result)) {
             $time = trim($row[0]);
        }
    $query= mysqli_query($con, "INSERT INTO acuerdos_files(id_acuerdo, name, url, fecha) VALUES ('$id_acuerdo','$name','$name','$time')");

    if(!$query){
      die('Error al registrar archivos de seguimiento');
    }
    else{
      echo 'Archivos de seguimiento registrados';
    }

    //---------------- Sube los archivos al servidor ---------------------------
    if (strlen($_FILES['acuerdo_files']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
      if (move_uploaded_file($_FILES['acuerdo_files']['tmp_name'][$i], $target_path.$name)) {
        $length =  filesize($target_path.$name);
        $length1 = $length * 0.00097656;
        $length1 = round($length1, 2);
        $result = mysqli_query($con, "SELECT MAX(id) AS id FROM acuerdos_files") or die ('<b>Error al obtener id_acuerdo</b>' . mysqli_error($con));
        if ($row = mysqli_fetch_array($result)) {
             $id_acuerdo_file = trim($row[0]);
        }

        $query2= mysqli_query($con, "UPDATE acuerdos_files SET tamaño = '$length1' WHERE id = '$id_acuerdo_file' ");
        if(!$query2){
          die('Error al registrar archivos de seguimiento');
        }
        else{
          echo 'Archivos de seguimiento registrados';
        }
      }else{echo "Error, no se han subido los archivos";}
    }
  }
}

function edit_acuerdo(){
  include "conexion.php";

  $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos
  $id = $_POST['id'];
  $titulo = $_POST['nombreAcuerdo'];
  $etiqueta = $_POST['etiquetaAC'];
  $fecha = $_POST['fechaActa'];
  $acuerdo = $_POST['acuerdo'];
  $observaciones = $_POST['observaciones'];
  $estatus = $_POST['estatusAcuerdo'];
  $fichero="".basename($_FILES['oficio']['name'][0]);
  $fword="".basename($_FILES['oficio_word']['name'][0]);
  $factad="".basename($_FILES['acta_admin']['name'][0]);
  $facufil="".basename($_FILES['acuerdo_files']['name'][0]);


  $query= mysqli_query($con, "UPDATE acuerdos SET etiqueta = '$etiqueta', acuerdo = '$acuerdo', observaciones = '$observaciones', estatus = '$estatus', titulo = '$titulo', fecha_acta = '$fecha' WHERE id = '$id'");

  if(!$query){
    die('Error al registrar el acuerdo:');
  }
  else{
    echo 'Acuerdo registrado correctamente';
  }

  if($fichero != ""){
//----------Subir cada uno de los archivos a la carpeta del servidor
    foreach($_FILES['oficio']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      $fichero = basename($_FILES['oficio']['name'][$i]);
      $url = basename($_FILES['oficio']['name'][$i]);

      if (strlen($_FILES['oficio']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['oficio']['tmp_name'][$i], $target_path.$name)) {

          $query= mysqli_query($con, "UPDATE acuerdos SET oficio = '$fichero' WHERE id = '$id'");

          if(!$query){
            die('Error al registrar el oficio:');
          }
          else{
            echo 'Oficio registrado correctamente';
          }
        }else{echo "Error, no se han subido los archivos";}
      }
    }
  }

  if($fword != ""){
//----------Subir cada uno de los archivos a la carpeta del servidor
    foreach($_FILES['oficio_word']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      $fword = basename($_FILES['oficio_word']['name'][$i]);
      $url = basename($_FILES['oficio_word']['name'][$i]);

      if (strlen($_FILES['oficio_word']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['oficio_word']['tmp_name'][$i], $target_path.$name)) {
          $query= mysqli_query($con, "UPDATE acuerdos SET oficio_word = '$fword' WHERE id = '$id'");

          if(!$query){
            die('Error al registrar el oficio de word:');
          }
          else{
            echo 'Oficio de word registrado correctamente';
          }
        }else{echo "Error, no se han subido los archivos";}
      }
    }
  }
  if($factad != ""){
//----------Subir cada uno de los archivos a la carpeta del servidor
    foreach($_FILES['acta_admin']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      $factad = basename($_FILES['acta_admin']['name'][$i]);
      $url = basename($_FILES['acta_admin']['name'][$i]);

      if (strlen($_FILES['acta_admin']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['acta_admin']['tmp_name'][$i], $target_path.$name)) {
          $query= mysqli_query($con, "UPDATE acuerdos SET acta_admin = '$factad' WHERE id = '$id'");

          if(!$query){
            die('Error al registrar el acta:');
          }
          else{
            echo 'Acta de word registrado correctamente';
          }
        }else{echo "Error, no se han subido los archivos";}
      }
    }
  }
  if($facufil != ""){
//----------Subir cada uno de los archivos a la carpeta del servidor
    /*$result = mysqli_query($con, "SELECT MAX(id) AS id FROM acuerdos") or die ('<b>Error al obtener id_acuerdo</b>' . mysql_error($con));
    if ($row = mysqli_fetch_array($result)) {
         $id_acuerdo = trim($row[0]);
    }*/

    add_acuerdo_file($id); //Función que se encarga de subir cada uno de los archivos seleccionados como seguimieto.

  }
}


function delete_acuerdo(){
    include "conexion.php";

    $id=$_POST['id'];

    $eject7=mysqli_query($con, "DELETE FROM acuerdos WHERE id='$id'");

    if(!$eject7){
          echo "Ocurrió un error al eliminar el acuerdo" . $eject7;
        }
        else{
          echo "El acta ha sido eliminada";
        }
    }

function delete_file_seguimiento(){
        include "conexion.php";

        $id=$_POST['id'];

        $eject8=mysqli_query($con, "DELETE FROM acuerdos_files WHERE id='$id'");

      if(!$eject8){
            echo "Ocurrió un error al eliminar el archivo" . $eject7;
          }
          else{
            echo "El archivo ha sido eliminado";
          }

    }

 ?>
