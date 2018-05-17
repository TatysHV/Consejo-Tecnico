<?php

include "../conexiones/conexion.php";
session_start();

@$conexion = mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());

if (!mysqli_select_db($conexion, $db))
  {
    echo "<h2>Error al seleccionar la base de datos!!!";
    header("Location: actas.php");
    exit;
  }

  $year = $_POST['year'];


 if($year!="todos"){
   //Consulta SQL que muestra los reglamentos de tipo Consejo Técnico de acuerdo al año seleccionado y los ordena de manera ascendente.
   $sql="SELECT * FROM normatividad WHERE tipo = 'C' and year(fecha) = '$year' ORDER BY fecha ASC";
 }
 else{
   //Consulta SQL que muestra todos los reglamentos de tipo Consejo Técnico.
   $sql="SELECT * FROM normatividad WHERE tipo = 'C'";
 }


  $result = mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($conexion));

  $totalFilas = mysqli_num_rows($result);
  if ($totalFilas == 0){
    echo 'No se encontraron resultados';
  }

  echo'<ul>';

      while ($line = mysqli_fetch_array($result)) {
        echo'<li><span style="color: #666"><strong><a href="conexiones/uploads/'.$line["url"].'">'.$line["nombre"].'</a></strong></span>';
            if($_SESSION['tipo'] == '0'){ //Si el usuario es del tipo administrador: mostrará el botón de eliminar
               echo'<div class="onKlic" onclick="deleteReg('.$line["id"].')" style="display: inline-block; margin-left: 8px; "><img src="imagenes/flaticons/eliminar.png" style="width: 15px; heigth: auto;" title="Eliminar"/></div>';
            }
        echo'</li>';
      }

  echo'</ul>';
