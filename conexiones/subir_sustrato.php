<?php
  include "conexion.php";

  /*Registro únicamente de un nuevo punto a la orden del día*/

    $nombre = $_POST['nombre'];
    $proteger = $_POST['proteger'];
    $numero = $_POST['numero'];

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

?>
