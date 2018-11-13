<?php
include "conexion.php";

$funcion = $_POST['funcion'];

switch ($func){
  case 0 : add_oficio();
  break;
  case 1: add_oficio_anexo();
  break;
  case 2: add_oficio_seguimiento();
  break;

}

function add_oficio(){
  include "conexión.php";

  $target_path = "../conexiones/uploads/";

  $folio = $_POST['folio_oficio'];
  $fecha_emision = $_POST['fecha_emision'];
  $asunto = $_POST['etiquetaOF'];
  $tipo = $_POST['tipo_of'];
  $num_sesion = $_POST['numsesion_of'];
  $fecha_sesion = $_POST['fechasesion_of'];
  $estatus = $_POST['estatus_of'];

  $oficio_pdf="".basename($_FILES['oficio_pdf']['name'][0]);
  $oficio_word="".basename($_FILES['oficio_word']['name'][0]);
  $anexos="".basename($_FILES['anexos']['name'][0]);
  $seguimiento="".basename($_FILES['seguimiento']['name'][0]);

  //*******Subiendo el oficio PDF al servidor**************/
  if($oficio_pdf!=""){
    if (strlen($_FILES['oficio_pdf']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
      if (move_uploaded_file($_FILES['oficio_pdf']['tmp_name'][$i], $target_path.$oficio_pdf)) {
        //Subiendo archivo al servidor
      }else{echo "Error al subir al servidor el oficio PDF";}
    }
  }

  //******Subiendo el oficio Word al servidor***************/
  if($oficio_word!=""){
    if (strlen($_FILES['oficio_word']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
      if (move_uploaded_file($_FILES['oficio_word']['tmp_name'][$i], $target_path.$oficio_word)) {
        //Subiendo archivo al servidor
      }else{echo "Error al subir al servidor el oficio word";}
    }
  }

  //*****Obtener id del oficio registrado *****************/
  $id_oficio ="";
  $query_id = mysqli_query($con, "SELECT MAX(id_oficio) AS id FROM oficios") or die ('Error al obtener el id del oficio'.mysqli_error($con));
  if ($row = mysqli_fetch_array($query_id)) {
       $id_oficio = trim($row[0]);
  }

  //*****Si se necesitan subir anexos, la función se encarga de hacerlo********/
  if($anexos!=""){
    add_oficio_anexo($id_oficio);
  }
  //*****Si se necesitan subir archivos de seguimiento, la función lo hace*****/
  if($seguimiento!=""){
    add_oficio_seguimiento($id_oficio);
  }


}

function add_oficio_anexo($id_oficio){
  include "conexion.php";

  $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

  //********Subir cada uno de los archivos a la carpeta del servidor
  foreach($_FILES['anexos']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
    //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

    //----------- Subir la info de cada archivo a la base de datos------------

    //$size = $_FILES['acuerdo_files']['size'][$i];

    $name = basename($_FILES['anexos']['name'][$i]);

    $result = mysqli_query($con,"SELECT CURDATE()");
    if ($row = mysqli_fetch_array($result)) {
             $time = trim($row[0]);
        }

    $query= mysqli_query($con, "INSERT INTO oficios_anexos(id_oficio, nombre, url, fecha) VALUES ('$id_acuerdo','$name','$name','$time')");

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


 ?>
