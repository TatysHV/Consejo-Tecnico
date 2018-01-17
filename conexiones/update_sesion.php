<?php

$nombre = $_POST['nombre'];
$tipo = $_POST['tipo'];
$fecha = $_POST['fecha'];
$numero = $_POST['numero'];
$fichero="".basename($_FILES['archivos']['name'][0]); //En la posición 0, el array (porque lo dejé permitiendo más de un archivo en el input file).
$id_ordendia = $_POST['id_sesion'];

include "conexion.php";

$query = mysqli_query($con, "UPDATE orden_dia SET nombre_sesion = '$nombre', tipo = '$tipo', fecha_sesion = '$fecha',
  numero_sesion ='$numero', direccion = '$fichero' WHERE id = '$id_ordendia'");

  if(!$query){
    echo "Ocurrió un error" . $query;
  }
  else{
    //  echo "ORDEN DEL DÍA MODIFICADA <br><br>";
    //  echo 'NUEVOS DATOS: <br>'.'<b>Nombre:</b> '.$nombre."<br><b>Fecha: </b>".$fecha."<br><b>Tipo:</b> ".$tipo."<br><b>Direccion:</b> ".$fichero."<br><br> <a href="../consejo_tecnico/index.php"> Volver al sitio</a>";
  }

  /*+++++++++++++++++++++++++++++++++++++++
    SUBIR EL ARCHIVO A LA CARPETA/SERVIDOR
    +++++++++++++++++++++++++++++++++++++++*/

    $target_path = "../conexiones/uploads/";
    /*$target_path = "../archivos/ordendia"; // carpeta donde se guardarán los archivo*/

    foreach ($_FILES['archivos']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.
   		if (strlen($_FILES['archivos']['name'][$i]) > 1) { //Garantiza que la cat de caracteres del nombre sea mayor a 1 (No es esencial).
   			if (move_uploaded_file($_FILES['archivos']['tmp_name'][$i], $target_path.$name)) {
          //Copia el archivo a la dirección específica de la concatenación: ../archivos/ordendia/nombre.
          echo "El archivo <b>". basename($_FILES['archivos']['name'][$i])." </b>ha sido subido.</br>";
          echo '<script> window.location="2016/consejo_tecnico/sesiones.php"</script>';
        }
   		}
   	}


?>
