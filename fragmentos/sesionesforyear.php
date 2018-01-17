<?php

include "../conexiones/conexion.php";
session_start();

@$conexion = mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());

if (!mysqli_select_db($conexion, $db))
  {
    echo "<h2>Error al seleccionar la base de datos!!!";
    header("Location: sesiones.php");
    exit;
  }


  $year = $_POST['year'];

  $sql= "SELECT * FROM orden_dia WHERE year(fecha_sesion) = '$year' ORDER BY numero_sesion";

  $result = mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($conexion));

  echo '<div class="sesiones" id="bloque_desplegable">
          <table id="sesiones">
            <tr>
              <th><center>Número </br>de sesión</center></th>
              <th>Tipo de sesión</th>
              <th><center>Fecha </br>(AA/MM/DD)</center></th>
              <th>Acci&oacute;n</th>
            </tr>';

  while ($line = mysqli_fetch_array($result)) {

      echo '
            <tr>

              <td> <center>'.$line["numero_sesion"].'<input type="hidden" name="id_sesion" value="'.$line["id"].'"/></center></td>
              <td>'.$line["tipo"].'</td>
              <td> <center>'.$line["fecha_sesion"].'</center></td>
              <td> <a href="sesion.php?sesion='.$line["id"].'">Mostrar</a></td>

            <tr>
            ';
  }
  echo '</table><br>';
mysqli_close($conexion);
  ?>
