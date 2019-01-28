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
  case 3: delete_file_anexos();
  break;
  case 4: add_oficio_seguimiento2();
  break;
  case 5: edit_oficio();
  break;
  case 6: delete_oficio();

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

        $query = mysqli_query($con, "INSERT INTO archivos_anexos(id_oficio, nombre, url, fecha, tamano) VALUES ('$id_oficio','$name','$name','$time','$length1')");
        if(!$query){
          die('Error al registrar los anexos'.mysqli_error($con));
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

  //if($turno!="" && $dependencia !="" && $responsable!="" && $observaciones!="" && $tipo!="" && $fecha!=""){

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

    $query ="INSERT INTO tabla_seguimiento (turnadoA, dependencia, responsable, observaciones, tipo, fecha, oficio_respuesta, id_oficio) VALUES ('$turno','$dependencia','$responsable','$observaciones','$tipo','$fecha','$of_respuesta','$id_oficio')";

    /******** REGISTRAR SEGUIMIENTO EN LA BASE DE DATOS *************************/
    $result = mysqli_query($con, $query) or die ('Error al registrar seguimiento'.mysqli_error($con));
    if(!$result){
      die('Error al registrar seguimiento2');
    }
    else{
      echo 'Seguimiento registrado correctamente';
    }

 // }
}

function delete_file_anexos(){
  include "conexion.php";

  $id=$_POST['id'];

  $eject8=mysqli_query($con, "DELETE FROM archivos_anexos WHERE id='$id'");

if(!$eject8){
      echo "Ocurrió un error al eliminar el archivo" . $eject7;
    }
    else{
      echo "El archivo ha sido eliminado";
    }

}


function add_oficio_seguimiento2(){

  include "conexion.php";

  $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

  $turno = $_POST['turnadoA'];
  $dependencia = $_POST['dependencia'];
  $responsable = $_POST['responsable'];
  $observaciones = $_POST['observaciones'];
  $tipo = $_POST['tipo'];
  $fecha = $_POST['fecha'];

  $id_oficio = $_POST['id_oficio'];

  $of_respuesta = 'No_hay.pdf';

  //if($turno!="" && $dependencia !="" && $responsable!="" && $observaciones!="" && $tipo!="" && $fecha!=""){



    /******** MOVER OFICIO RESPUESTA A LA CARPETA DE UPLOADS *******************/

    foreach($_FILES['seguimiento']['name'] as $i => $name) {
      if (strlen($_FILES['seguimiento']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['seguimiento']['tmp_name'][$i], $target_path.$name)) {
            $of_respuesta = basename($_FILES['seguimiento']['name'][$i]);
          }
        }
    }

    $query ="INSERT INTO tabla_seguimiento (turnadoA, dependencia, responsable, observaciones, tipo, fecha, oficio_respuesta, id_oficio) VALUES ('$turno','$dependencia','$responsable','$observaciones','$tipo','$fecha','$of_respuesta','$id_oficio')";

    /******** REGISTRAR SEGUIMIENTO EN LA BASE DE DATOS *************************/
    $result = mysqli_query($con, $query) or die ('Error al registrar seguimiento'.mysqli_error($con));
    if(!$result){
      die('Error al registrar seguimiento2');
    }
    else{
      echo 'Seguimiento registrado correctamente';
    }

 // }
}

function edit_oficio(){
  include "conexion.php";

  $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos
  $id = $_POST['id'];

  $folio = $_POST['folio_oficio'];
  $fecha_emision = $_POST['fecha_emision'];
  $asunto = $_POST['etiquetaOF'];
  $dirigido = $_POST['dirigido'];
  $nombre = $_POST['nombre_oficio'];
  $tipo_sesion = $_POST['tipo_of'];
  $num_sesion = $_POST['numsesion_of'];
  $fecha_sesion = $_POST['fechasesion_of'];
  $estatus = $_POST['estatus_of'];

  $of_pdf = "".basename($_FILES['oficio_pdf']['name'][0]);
  $of_word = "".basename($_FILES['oficio_word']['name'][0]);

  $of_anexos = "".basename($_FILES['anexos']['name'][0]);


  $query= mysqli_query($con, "UPDATE oficios SET folio = '$folio', nombre = '$nombre',
    dirigidoA = '$dirigido', asunto = '$asunto', estatus = '$estatus', fecha_emision = '$fecha_emision',
    tipo_sesion = '$tipo_sesion', numero_sesion = '$num_sesion', fecha_sesion = '$fecha_sesion' WHERE id_oficio = '$id'");

  if(!$query){
    die('Error al modificar oficio');
  }
  else{
    echo 'Oficio modificado correctamente';
  }


  if($of_pdf != ""){
    //----------Subir cada uno de los archivos a la carpeta del servidor
    foreach($_FILES['oficio_pdf']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      //$name = basename($_FILES['oficio_pdf']['name'][$i]);
      $url = basename($_FILES['oficio_pdf']['name'][$i]);

      if (strlen($_FILES['oficio_pdf']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['oficio_pdf']['tmp_name'][$i], $target_path.$name)) {
          $query= mysqli_query($con, "UPDATE oficios SET oficio_pdf = '$url' WHERE id_oficio = '$id'");

          if(!$query){
            die('Error al registrar el oficio pdf');
          }
          else{
            echo 'Oficio pdf registrado correctamente';
          }
        }else{echo "Error, no se han subido los archivos of pdf";}
      }
    }
  }

  if($of_word != ""){
//----------Subir cada uno de los archivos a la carpeta del servidor
    foreach($_FILES['oficio_word']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      //$factad = basename($_FILES['oficio_word']['name'][$i]);
      $url = basename($_FILES['oficio_word']['name'][$i]);

      if (strlen($_FILES['oficio_word']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['oficio_word']['tmp_name'][$i], $target_path.$name)) {
          $query= mysqli_query($con, "UPDATE oficios SET oficio_word = '$url' WHERE id_oficio = '$id'");

          if(!$query){
            die('Error al registrar el oficio word');
          }
          else{
            echo 'Oficio word registrado correctamente';
          }
        }else{echo "Error, no se han subido los archivos of word";}
      }
    }
  }

  if($of_anexos != ""){
    //----------Subir cada uno de los archivos anexos al servidor y a la BD

    add_oficio_anexo($id); //Función que se encarga de subir cada uno de los archivos seleccionados como seguimieto.

  }
}

function delete_oficio(){
  include "conexion.php";

  $id = $_POST['id'];
  $target_path = "../conexiones/uploads/";

  /*Nota: Es necesario eliminar todos los archivos anexados y la tabla de
  seguimiento que están vinculados al oficio y después procedemos a eliminar
  el registro del oficio en la base de datos.


  /******************* Eliminar los archivos anexos, si tiene *******************/

  //------- Obtener el nombre del archivo anexado para eliminarlo del servidor--- /

  $nombre_anexo ="";
  $query_names= mysqli_query($con, "SELECT nombre FROM archivos_anexos WHERE id_oficio = '$id'");

  while($row = mysqli_fetch_array($query_names)){
    $nombre_anexo = $row[0];

    if(unlink($target_path.$nombre_anexo)){
      echo 'Archivo anexo borrado correctamente ';
    }
    else{
      echo 'Error al eliminar el archivo anexo ';
     }
  }

  // ------ Eliminar todos los datos del archivo en la base de datos -------------/
  $query2 = mysqli_query($con, "DELETE FROM archivos_anexos WHERE id_oficio = '$id'");

  if(!$query2){
    die('Error al eliminar archivos anexos del oficio ');
  }
  else{
    echo 'Archivos anexos eliminados ';
  }


  /********************* Eliminar la tabla de seguimiento  ***********************/

  // ------ Eliminar los archivos de oficio respuesta del servidor ---------------/
  $nombre_seguimiento ="";
  $query_oficios= mysqli_query($con, "SELECT oficio_respuesta FROM tabla_seguimiento WHERE id_oficio = '$id'");

  while($row = mysqli_fetch_array($query_oficios)){
    $nombre_seguimiento = $row[0];

    if(unlink($target_path.$nombre_seguimiento)){
      echo 'Oficio respuesta eliminado correctamente ';
    }
    else{
      echo 'Error al eliminar el oficio respuesta ';
     }
  }

  //----------- Eliminar todos los registros de la tabla de seguimiento de BD ----------/

  $query3 = mysqli_query($con, "DELETE FROM tabla_seguimiento WHERE id_oficio = '$id'");

  if(!$query3){
    die('Error al eliminar archivos de seguimiento del oficio ');
  }
  else{
    echo 'Archivos de seguimiento eliminados correctamente ';
  }

  /********************* Eliminar el oficio por su id ***************************/

  $query = mysqli_query($con, "DELETE FROM oficios WHERE id_oficio = '$id'");

  if(!$query){
    die('Error al eliminar el oficio');
  }
  else{
    echo 'Oficio eliminado correctamente ';
  }

}

 ?>
