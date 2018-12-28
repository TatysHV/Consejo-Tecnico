<?php
include "conexion.php";

$funcion = $_POST['funcion'];

switch ($funcion){
  case 0: add_oficio();
  break;
  case 1: add_oficio_anexo();
  break;
  case 2: add_oficio_seguimiento();
  break;

}

function add_oficio(){
  include "conexion.php";

  $target_path = "../conexiones/uploads/";

  $folio = $_POST['folio_oficio'];
  $nombre = $_POST['nombre_oficio'];
  $dirigido = $_POST['dirigido'];
  $asunto = $_POST['etiquetaOF'];
  $estatus = $_POST['estatus_of'];
  $fecha_emision = $_POST['fecha_emision'];
  $tipo = $_POST['tipo_of'];
  $num_sesion = $_POST['numsesion_of'];
  $fecha_sesion = $_POST['fechasesion_of'];

  $oficio_pdf="".basename($_FILES['oficio_pdf']['name'][0]);
  $oficio_word="".basename($_FILES['oficio_word']['name'][0]);
  $seguimiento = false;
  $anexos="".basename($_FILES['anexos']['name'][0]);

  //*******Subiendo el oficio PDF al servidor*************************************/
  if($oficio_pdf!=""){
    if (strlen($_FILES['oficio_pdf']['name'][0]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
      if (move_uploaded_file($_FILES['oficio_pdf']['tmp_name'][0], $target_path.$oficio_pdf)) {
        //Subiendo archivo al servidor
      }else{//echo "Error al subir al servidor el oficio PDF";
      }
    }
  }

  //******Subiendo el oficio Word al servidor***********************************/
  if($oficio_word!=""){
    if (strlen($_FILES['oficio_word']['name'][0]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
      if (move_uploaded_file($_FILES['oficio_word']['tmp_name'][0], $target_path.$oficio_word)) {
        //Subiendo archivo al servidor
      }else{//echo "Error al subir al servidor el oficio word";
      }
    }
  }

  //*****Registrar en la base de datos el nuevo oficio**************************/
  $query= mysqli_query($con, "INSERT INTO oficios(folio, nombre, dirigidoA, asunto, estatus, fecha_emision, oficio_word, oficio_pdf, tipo_sesion, numero_sesion, fecha_sesion)
  VALUES ('$folio', '$nombre', '$dirigido', '$asunto', '$estatus', '$fecha_emision', '$oficio_word', '$oficio_pdf', '$tipo', '$num_sesion', '$fecha_sesion') ") or die ('Error al registrar el oficio'.mysqli_error($con));

  if(!$query){
    //echo 'Error al registrar el nuevo oficio';
  }
  else{
    //echo 'Oficio registrado correctamente';
  }

  //*****Obtener id del oficio registrado *************************************/
  $id_oficio ="";
  $query_id = mysqli_query($con, "SELECT MAX(id_oficio) AS id FROM oficios") or die ('Error al obtener el id del oficio'.mysqli_error($con));
  if ($row = mysqli_fetch_array($query_id)) {
       $id_oficio = trim($row[0]);
  }

  //*****Si se necesitan subir anexos, la función se encarga de hacerlo********/
  if($anexos!=""){
    add_oficio_anexo($id_oficio);
  }

  echo $id_oficio;

}

function add_oficio_anexo($id_oficio){
  include "conexion.php";

  $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

  //********Subir cada uno de los archivos a la carpeta del servidor
  foreach($_FILES['anexos']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
    //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

    //----------- Subir la info de cada archivo a la base de datos------------

    $name = basename($_FILES['anexos']['name'][$i]);
    //---------------- Sube los archivos al servidor ---------------------------
    if (strlen($_FILES['anexos']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
      if (move_uploaded_file($_FILES['anexos']['tmp_name'][$i], $target_path.$name)) {

        $length =  filesize($target_path.$name);
        $length1 = $length * 0.00097656;
        $length1 = round($length1, 2);

        $result = mysqli_query($con,"SELECT CURDATE()");
        if ($row = mysqli_fetch_array($result)) {
                 $time = trim($row[0]);
            }

        /******** Obtener el id del último elemento agregado a la tabla de archivos_anexos ****/
        $result = mysqli_query($con, "SELECT MAX(id) AS id FROM archivos_anexos") or die ('<b>Error al obtener id_anexo</b>' . mysqli_error($con));
        if ($row = mysqli_fetch_array($result)) {
             $id_anexo = trim($row[0]);
        }

        /******* Registro de los datos del archivo en la base de datos ***********************/

        $query= mysqli_query($con, "INSERT INTO archivos_anexos(id_oficio, nombre, url, fecha, tamaño) VALUES ('$id_oficio','$name','$name','$time','$length1')");
        if(!$query){
          die('Error al registrar los anexos');
        }
        else{
          echo 'Archivos anexos registrados correctamente';
        }

      }else{echo "Error al copiar el archivo a la carpeta de uploads";}
    }
  }

}

function add_oficio_seguimiento(){

  include "conexion.php";

  $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

  $turno = $_POST['turnadoA'];
  $dependencia = $_POST['dependencia'];
  $responsable = $_POST['responsable'];
  $observaciones = $_POST['observaciones'];
  $tipo = $_POST['tipo'];
  $fecha = $_POST['fecha'];

  $of_respuesta = 'No_hay.pdf';

  if($turno!="" && $dependencia !="" && $responsable!="" && $observaciones!="" && $tipo!="" && $fecha!=""){

    //***** OBTENER ID DEL ÚLTIMO OFICIO REGISTRADO ****************************/
    $id_oficio ="";
    $query_id = mysqli_query($con, "SELECT MAX(id_oficio) AS id FROM oficios") or die ('Error al obtener el id del oficio'.mysqli_error($con));
    if ($row = mysqli_fetch_array($query_id)) {
         $id_oficio = trim($row[0]);
    }



    /******** MOVER OFICIO RESPUESTA A LA CARPETA DE UPLOADS *******************/

    foreach($_FILES['seguimiento']['name'] as $i => $name) {
      if (strlen($_FILES['seguimiento']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['seguimiento']['tmp_name'][$i], $target_path.$name)) {
            $of_respuesta = basename($_FILES['seguimiento']['name'][$i]);
          }
        }
    }

    $query ="INSERT INTO tabla_seguimiento(turnadoA, dependencia, responsable, observaciones, tipo, fecha, oficio_respuesta, id_oficio) VALUES ('$turno','$dependencia','$responsable','$observaciones','$tipo','$fecha','$of_respuesta','$id_oficio')";

    /******** REGISTRAR SEGUIMIENTO EN LA BASE DE DATOS *************************/
    $result = mysqli_query($con, $query) or die ('Error al registrar seguimiento'.mysqli_error($con));
    if(!$result){
      die('Error al registrar seguimiento2');
    }
    else{
      echo 'Seguimiento registrado correctamente';
    }

  }
}


 ?>
