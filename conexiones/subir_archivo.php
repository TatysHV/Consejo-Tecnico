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
          addFolder(1);
          break;
      case 2: //subir archivos
          addFile();
          break;
      case 3: //Editar carpeta
          updateFolder();
          break;
      case 4: //Editar archivo
          updateFile();
          break;
      case 5: //Eliminar carpeta
          deleteFolder();
          break;
      case 6: //Eliminar archivo
          deleteFile();
          break;
  }

//************************** OBTENER ID PADRE DE CARPETA HIJA ***********************************//

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

  function addFolder($tipo){
    include "conexion.php";
    //tabla: carpeta_hija
    //Nombre, Tipo=1(estamos creando una carpeta visible), idPadre(siempre lo obtenemos gracias al codigo de arriba)
    //Usa una sentencia u otra dependiendo de si se trata de una carpeta normal o una creada por default.
    $nombre;
    $idpadre;
    $id_craiz; $id_chija;

    $id_punto;
    $nPunto = $_POST["punto"];
    $id_orden = $_POST["orden_dia"];


    if($tipo == 0){
      $nombre = 'default';
      $query= mysqli_query($con, "INSERT INTO carpeta_hija (nombre, tipo, id_carpeta_padre) values ('$nombre', '0', 0)"); //idpadre = 0
    }
    else{
      $nombre = $_POST['nomCarpeta'];
      $idpadre = $_POST['idPadre'];
      $query= mysqli_query($con, "INSERT INTO carpeta_hija (nombre, tipo, id_carpeta_padre) values ('$nombre', '1', $idpadre)");
    }

    /*UNA VEZ QUE SE REGISTRA UNA CARPETA HIJA, SE DEBE HACER LA REALACION PARA SABER DENTRO
    DE QUÉ CARPETA RAIZ ESTÁ CONTENIDA, Esta relación necesita id de carpeta hija creada y carpeta raiz
    Es necesario obtener el id de la CARPETA RAIZ que le pertenece al punto x cuyo número sea n.
    perteneciente a la última orden del día creada.*/

    //Obtenemos la id del punto en base a la orden del día que pertenece y al número de punto que corresponde
    $queryO = mysqli_query($con, "SELECT distinct s.id_sustrato, s.nombre FROM orden_dia as o inner join orden_tiene as ot inner join sustrato as s on o.id = ot.id_orden and ot.id_sustrato = s.id_sustrato WHERE s.numero = '$nPunto' and o.id = '$id_orden' ");
    if($row= mysqli_fetch_array($queryO)){
        $id_punto= $row["id_sustrato"];
    }

    //----Obtiene la ID de la carpeta raiz del punto obtenido.
    $queryRaiz= mysqli_query($con, "SELECT distinct cr.id_raiz FROM sustrato as s inner join carpeta_sustrato as cs inner join carpeta_raiz as cr on s.id_sustrato = cs.id_sustrato and cs.id_carpeta = cr.id_raiz WHERE s.id_sustrato = '$id_punto' ") or die ('<b>Error al obtener id_sustrato</b>' . mysql_error());
    if ($row = mysqli_fetch_array($queryRaiz)) {
       $id_craiz = trim($row[0]);
    }

    //------Obtiene la ID de la última carpeta hija creada
    $queryHija= mysqli_query($con, "SELECT MAX(id_carpeta) AS id FROM carpeta_hija") or die ('<b>Error al obtener id_sustrato</b>' . mysql_error());
    if ($row = mysqli_fetch_array($queryHija)) {
       $id_chija = trim($row[0]);
    }

    //-----Crea la relación que permite indicar a qué lugar pertenece cada carpeta creada.

    $Rel = mysqli_query($con, "INSERT INTO cpadre_chijos (id_padre, id_hijo) values ('$id_craiz', '$id_chija')");
  }

//***********************FUNCION SUBIR ARCHIVOS*********************************//

  function addFile(){
    include "conexion.php";

    $nPunto = $_POST["punto"];
    $id_orden = $_POST["orden_dia"];

    $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

    //-------Obtener ID del punto al que se le agregarán dichos archivos

    $id_punto;
    $queryO = mysqli_query($con, "SELECT distinct s.id_sustrato, s.nombre FROM orden_dia as o inner join orden_tiene as ot inner join sustrato as s on o.id = ot.id_orden and ot.id_sustrato = s.id_sustrato WHERE s.numero = '$nPunto' and o.id = '$id_orden' ");
    if($row= mysqli_fetch_array($queryO)){
        $id_punto= $row["id_sustrato"];
    }

    //Recibir la ID de la carpeta contenedora donde se van a agregar los archivos
    $id_carpeta = $_POST['carpeta']; //Carpeta seleccionada

    //----Identificar si el archivo será agregado a la raíz o no.
    //En caso de ser agregado en la raiz, se deben crear carpetas contenedoras del tipo 0, no visibles.

    if($id_carpeta == 0){
      echo $id_carpeta;
          addFolder(0);

          //---Al crear una nueva carpeta hija, por default, es necesario obtener su id para registrarla en el campo de la tabla archivo
          $q = mysqli_query($con, "SELECT MAX(id_carpeta) AS id FROM carpeta_hija") or die ('<b>Error al obtener id_carpeta_hija</b>' . mysql_error());

          if ($row = mysqli_fetch_array($q)) {
              $id_carpeta= trim($row[0]);
          }

    }else{echo 'No entra if';}


    //----------Subir cada uno de los archivos a la carpeta del servidor
    foreach ($_FILES['file_archivo']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      $nombre = basename($_FILES['file_archivo']['name'][$i]);

      $url=basename($_FILES['file_archivo']['name'][$i]);

      $query = mysqli_query($con, "INSERT INTO archivo (url,nombre,id_carpeta) values ('$url', '$nombre', '$id_carpeta')");

      if (strlen($_FILES['file_archivo']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['file_archivo']['tmp_name'][$i], $target_path.$name)) {

        }else{echo "Error, no se han subido los archivos";}
      }
    }
}

/********************** MODIFICAR CONTENIDO ***********************/

function updateFolder(){
  //No obtienen la carpeta desde el auxiliar, sino lo reciben directamente al darle clic al botón de editar.
  include "conexion.php";

  $nombre = $_POST["nombre"];
  $id_folder = $_POST["carpeta"];

  $query = mysqli_query($con, "UPDATE carpeta_hija SET nombre='$nombre' WHERE id_carpeta= '$id_folder' ");

}

function updateFile(){
  //Obtiene el id del archivo a modificar mediante AJAX.
  include "conexion.php";

  $id_file = $_POST["file"];

  //Eliminar el archivo del servidor para después subir uno nuevo.

  $select = mysqli_query($con,"SELECT nombre FROM archivo WHERE id=$id_file ");

  if ($row = mysqli_fetch_array($select)) {
      $ToDelete= trim($row[0]);
      unlink("uploads/".$ToDelete);
  }
  //Sube al servidor el archivo nuevo y actualiza el nombre y url del archivo anterior por el nuevo.
  $target_path = "../conexiones/uploads/";

  foreach ($_FILES['file_archivo']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
    //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

    //----------- Subir la info de cada archivo a la base de datos------------
    $nombre = basename($_FILES['file_archivo']['name'][$i]);

    $url=basename($_FILES['file_archivo']['name'][$i]);

    $query = mysqli_query($con, "UPDATE archivo SET nombre='$nombre', url='$nombre' WHERE id= '$id_file' ");

    if (strlen($_FILES['file_archivo']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
      if (move_uploaded_file($_FILES['file_archivo']['tmp_name'][$i], $target_path.$name)) {

      }else{echo "Error, no se han subido los archivos";}
    }
  }
}

/****************** ELIMINAR CONTENIDO *******************************/

function deleteFolder(){
  //No obtienen la carpeta desde el auxiliar, sino lo reciben directamente al darle clic al botón de editar.
  include "conexion.php";

  $id_folder = $_POST["carpeta"];
  echo"hola que hace";

  $query = mysqli_query($con, "DELETE FROM carpeta_hija WHERE id_carpeta='$id_folder' ");

}

function deleteFile(){
  include "conexion.php";

  $id_file = $_POST["file"];

  $select = mysqli_query($con,"SELECT nombre FROM archivo WHERE id= '$id_file' ");

  if ($row = mysqli_fetch_array($select)) { //Eliminar el archivo virtual
      $ToDelete= trim($row[0]);
      unlink("uploads/".$ToDelete);
  }

  $query = mysqli_query($con, "DELETE FROM archivo WHERE id= '$id_file' ");
  //Eliminarlo de la base de datos
  echo"entra al php";
  }


?>
