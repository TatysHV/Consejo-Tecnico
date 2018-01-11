<?php
  include "conexion.php";

  /*Registro únicamente de un nuevo punto a la orden del día*/


  $caso = $_POST['caso'];

  switch ($caso){
    case 1: //Agregar el punto al final
      addFinalPunto();
    break;
    case 2: //Agregar un punto intermedio
      addInterPunto();
    break;
    case 3: //Modificar un punto
      editPunto();
    break;
    case 4: //Eliminar un punto
    break;

  }

  function addFinalPunto(){
    include "conexion.php";

    $query = mysqli_query($con, "INSERT INTO sustrato (numero, nombre, bloqueo) /*sube uno de los puntos de la orden del día*/
                            values ('$numero', '$nombre', '$proteger')");

    if(!$query){
        echo "Ocurrió un error" . $query;
      }
      else{
        echo "EL REGISTRO DEL PUNTO ".$nombre." SE REALIZÓ DE MANERA EXITOSA";
      }


      //--------Definición de variables globales-------------------
      $id_ordendia;
      $id_punto;
      $id_carpeta;
      //--------Obtener ID de la orden del día antes registrada-----
      $result1 = mysqli_query($con, "SELECT MAX(id) AS id FROM orden_dia") or die ('<b>Error al obtener id_ordendia</b>' . mysql_error());
      if ($row = mysqli_fetch_array($result1)) {
           $id_ordendia = trim($row[0]);
          }
      //--------Obtener ID del punto (sustrato)---------------------
      $result2 = mysqli_query($con, "SELECT MAX(id_sustrato) AS id FROM sustrato") or die ('<b>Error al obtener id_sustrato</b>' . mysql_error());
      if ($row = mysqli_fetch_array($result2)) {
           $id_punto = trim($row[0]);
          }
      //---------Registrar en tabla relacion ordendia-punto---------
      $ejec = mysqli_query($con, "INSERT INTO orden_tiene (id_orden, id_sustrato) values ('$id_ordendia', '$id_punto')") or die ('<b>Error al generar relación Ordendia-Sustrato</b>' . mysql_error());

      //Actualizamos la cantidad de puntos totales que contiene la orden del día.
      $updateOrden = mysqli_query($con, "UPDATE orden_dia SET cant_puntos = '$numero' WHERE id = '$id_ordendia'");

        if(!$updateOrden){
          echo "Ocurrió un error al actualizar la cantidad de puntos totales" . $query;
        }
        else{
          echo "Actualización de puntos totales realizado correctamente";
        }

/*TODOS LOS PUNTOS DE LA ORDEN DEL DÍA, AL MOMENTO DE SER CREADOS, DEBEN TENER UNA CARPETA POR DEFAULT (CERO)
PARA QUE SE PUEDEN COMENZAR A AGREGAR LAS CARPETAS Y/O ARCHIVOS DIRECTAMENTE EN ESE Punto
*/

      //------------Crear carpeta raiz por defecto del punto nuevo creado (sustrato)
      $ejec2 = mysqli_query($con, "INSERT INTO carpeta_raiz(descripcion) values ('')");

      //-----------------Obtener ID de la última carpeta raiz creada--------------------
      $result3 = mysqli_query($con, "SELECT MAX(id_raiz) AS id FROM carpeta_raiz") or die ('<b>Error al obtener id_sustrato</b>' . mysql_error());
      if ($row = mysqli_fetch_array($result3)) {
         $id_craiz = trim($row[0]);
      }

      //------------Registrar en tabla relacion carpeta-sustrato
      $ejec3 = mysqli_query($con, "INSERT INTO carpeta_sustrato (id_sustrato, id_carpeta) values ('$id_punto', '$id_craiz')");

  }

  function addInterPunto(){
    include "conexion.php";
    /*SE ESTARÁ AGREGANDO UN NUEVO PUNTO EN EL LUGAR DE OTRO YA EXISTENTE. POR LO TANTO
    EL PUNTO VIEJO DEBERÁ AUMENTAR EN 1 PARA QUEDAR EN SEGUIDA DEL NUEVO PUNTO QUE SE DESEA AGREGAR
    ES DECIR QUE EMPUJARÁ TODOS LOS DEMÁS PUNTOS, (se logrará sumando en 1 a todos los puntos subsiguientes)*/

    $id_orden = $_POST["orden"];

    $nombre = $_POST['nombre'];
    $proteger = $_POST['proteger'];
    $numero = $_POST['numero'];

    /******Obtener cantidad de puntos totales, para saber si se agrega al final o en medio*****/
    $orden = mysqli_query($con, "SELECT cant_puntos FROM orden_dia WHERE id='$id_orden'");
      if ($row = mysqli_fetch_array($orden)) {
          $cant_puntos= trim($row[0]);
      }

    if($cant_puntos < $numero ){ //Significa que es un punto intermedio
      //Aumentar en 1 todos los números de punto siguientes al número de punto que se desea agregar
      //Ejemplo: 1234, agregar punto 2. Mover(+1): 1(345). Agregar: 1(2)345

      $aumentar = mysqli_query($con, "UPDATE orden_dia as o inner join orden_tiene as ot inner join sustrato as s on o.id = ot.id_orden
      and ot.id_sustrato = s.id_sustrato set s.numero=s.numero+1 where o.id = '$id_orden' and s.numero > '$numero'");
    }

    /*******Sube el nuevo punto con el número directamente asignado por el usuario******/
    $query = mysqli_query($con, "INSERT INTO sustrato (numero, nombre, bloqueo) values ('$numero', '$nombre', '$proteger')");

    if(!$query){ echo "Ocurrió un error" . $query; }
    else{ echo "EL REGISTRO DEL PUNTO ".$nombre." SE REALIZÓ DE MANERA EXITOSA"; }

  }

  function editPunto(){
        include "conexion.php";

    $numPunto = $_POST["numPunto"];

    $nombre = $_POST['nombre'];
    $proteger = $_POST['proteger'];
    $numero = $_POST['numero'];

    $eject4=mysqli_query($con, "UPDATE sustrato SET numero='$numero', nombre='$nombre', bloqueo='$proteger' WHERE id_sustrato= '$numPunto'");
    
    if(!$eject4){
          echo "Ocurrió un error al modificar el punto" . $eject4;
        }
        else{
          echo "Actualización del punto realizada correctamente";
        }
  }



?>
