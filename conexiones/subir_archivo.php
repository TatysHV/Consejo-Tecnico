<?php

/*NOTA: Primer archivo php donde busco implementar el uso de diferentes funciones en un sólo php para evitar generar
tantos documentos php como todos los que hay en el proyecto. "simulacion de funciones"

Subir_archivo.php se encargará de crear tanto las carpetas como subir sus archivos correspondientes.
Se ejecutará la función addFile para agregar los archivos y addFolder para las carpetas.
14/Noviembre/2017 By TatysHV
*/

//*********************VARIABLES GLOBALES***************************************//
  include "conexion.php";
  //Todos los Ayax que envían a este php, mandan la funcion que se va a realizar.
  $funcion = $_POST['funcion'];
  $carpeta = 0;

  switch ($funcion) {
      case 0: //obtener idPadre
          idPadre();
          break;
      case 1: //crear carpetas
          addFolder();
          break;
      case 2: //subir archivos
          addFile();
          break;
  }

//************************** FUNCION IDPADRE ***********************************//

  function idPadre(){
    include "conexion.php";
    global $idPadre;
    $carpeta = $_POST['carpeta']; //Carpeta seleccionada
    //Obtiene el id de la carpeta padre, de la carpeta seleccionada, y lo manda a su función
    //java que actualiza el valor del botón de control de ids.
    $query = mysqli_query($con, "SELECT id_carpeta_padre FROM carpeta_hija WHERE id_carpeta = $carpeta");
    if ($row = mysqli_fetch_array($query)) {
         $idPadre = trim($row[0]);
        }

    echo "$idPadre";
  }
//*****************************FUNCION CREAR CARPETAS***************************//

  function addFolder(){
    include "conexion.php";
    //tabla: carpeta_hija
    //Nombre, Tipo=1(estamos creando una carpeta visible), idPadre(siempre lo obtenemos gracias al codigo de arriba)
    $nombre = $_POST['nomCarpeta'];
    $idpadre = $_POST['idPadre'];

    $query= mysqli_query($con, "INSERT INTO carpeta_hija (nombre, tipo, id_carpeta_padre) values ('$nombre', '1', $idpadre)");

    /*UNA VEZ QUE SE REGISTRA UNA CARPETA HIJA, SE DEBE HACER LA REALACION PARA SABER DENTRO
    DE QUÉ CARPETA RAIX ESTÁ CONTENIDA, Esta relación necesita la última id de carpeta hija creada y carpeta raiz*/

    //----Obtiene la ID de la última carpeta raiz creada
    $queryRaiz= mysqli_query($con, "SELECT MAX(id_raiz) AS id FROM carpeta_raiz") or die ('<b>Error al obtener id_sustrato</b>' . mysql_error());
    if ($row = mysqli_fetch_array($queryRaiz)) {
       $id_craiz = trim($row[0]);
    }

    //------Obtiene la ID de la última carpeta hija creada
    $queryHija= mysqli_query($con, "SELECT MAX(id_carpeta) AS id FROM carpeta_hija") or die ('<b>Error al obtener id_sustrato</b>' . mysql_error());
    if ($row = mysqli_fetch_array($queryHija)) {
       $id_chija = trim($row[0]);
    }

    $Rel = mysqli_query($con, "INSERT INTO cpadre_chijos (id_padre, id_hijo) values ('$id_craiz', '$id_chija')");
  }
//***********************FUNCION SUBIR ARCHIVOS*********************************//

  function addFile(){
    include "conexion.php";

    $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

    //-------Obtener ID del último punto agregado--------
    $id_punto;
    $result1 = mysqli_query($con, "SELECT MAX(id_sustrato) AS id FROM sustrato") or die ('<b>Error al obtener id_punto</b>' . mysql_error());

    if ($row = mysqli_fetch_array($result1)) {
        $id_punto = trim($row[0]);
    }
    /*

   //-----------Obtener la ID de la última carpeta creada (carpeta contenedora)------------
   $result3 = mysqli_query($con, "SELECT MAX(id_carpeta) AS id FROM carpetas") or die ('<b>Error al obtener id_carpeta</b>');
   if ($row = mysqli_fetch_array($result3)) {
       $id_carpeta = trim($row[0]);
   }*/

    //Recibir la ID de la carpeta contenedora donde se van a agregar los archivos
    $id_carpeta = $_POST['carpeta']; //Carpeta seleccionada
    echo $id_carpeta;


    //----------Subir cada uno de los archivos a la carpeta del servidor
    foreach ($_FILES['file_archivo']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.
      //----------- Subir la info de cada archivo a la base de datos------------
      $nombre = basename($_FILES['file_archivo']['name'][$i]);

      $url=basename($_FILES['file_archivo']['name'][$i]);

      $query = mysqli_query($con, "INSERT INTO archivo (url,nombre,id_carpeta) values ('$url', '$nombre', '$id_carpeta')");

      if (strlen($_FILES['file_archivo']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['file_archivo']['tmp_name'][$i], $target_path.$name)) {
          //echo '<div class="file_success"><img style="display: inline-block" src="imagenes/success.png"> '.$name.' subido </div>';
/*
          //--------Obtener id del último archivo añadido------------
          $result2 = mysqli_query($con, "SELECT MAX(id) AS id FROM archivo") or die ('<b>Error al obtener id_archivo</b>');
          if ($row = mysqli_fetch_array($result2)) {
              $id_archivo = trim($row[0]);
          }
          //-----Registrar ids para crear la relación Punto-Archivo----
          $ejec = mysqli_query($con, "INSERT INTO archivo_sustrato (id_sustrato, id_archivo) values ('$id_punto', '$id_archivo')") or die ('<b>Error al registrar relación</b>');
*/
        }else{echo "Error, no se han subido los archivos";}
      }
    }
}



?>
