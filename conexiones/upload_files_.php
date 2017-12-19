<?php
/*  $variable_control = $_POST['funcion'];

  if($variable_control = 'upload_ordendia'){}

  if($variable_control = 'upload_sustrato'){}
*/

  $nombre = $_POST['nombre'];
  $tipo = $_POST['tipo'];
  $fecha = $_POST['fecha'];
  $numero = $_POST['numero'];
  //$puntos = $_POST['puntos']; Usarla sólo en caso de que sea necesario, hasta el momento no se necesita 30/OCT/2017
  $fichero="ordendia/".basename($_FILES['archivos']['name'][0]);

  /*+++++++++++++++++++++++++++++++++++++++++
    SUBIR A LA BASE DE DATOS LA ORDEN DEL DIA
    +++++++++++++++++++++++++++++++++++++++++*/

    include "conexion.php";
    session_start();

    $conexion = @mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());
    if (!mysqli_select_db($conexion, $db))
  {
    echo "<h2>Error al seleccionar la base de datos!!!";
    echo '<script> window.location="/2016/consejo_tecnico/index.php"</script>';
    exit;
  }

    $query = mysqli_query($conexion, "INSERT INTO orden_dia (nombre_sesion, tipo, fecha_sesion,
      numero_sesion, cant_puntos, direccion) values ('$nombre', '$tipo', '$fecha', '$numero', '$puntos', '$fichero')");

      if(!$query){
        echo "Ocurrió un error" . $query;
        echo '<script> window.location="/2016/consejo_tecnico/sesiones.php"</script>';
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
          echo '<script> window.location="/2016/consejo_tecnico/sesiones.php"</script>';
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
