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

  //$sql= "SELECT * FROM orden_dia WHERE year(fecha_sesion) = '$year' ORDER BY numero_sesion"; Muestra ordenados por numero de sesion
  $sql= "SELECT * FROM actas WHERE year(fecha_sesion) = '$year' ORDER BY fecha_sesion ASC"; // Muestra ordenados por fecha de sesion

  $result = mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($conexion));

  echo '<div class="sesiones" id="bloque_desplegable">
          <table id="sesiones">
            <tr>
              <th><center>Número </br>de sesión</center></th>
              <th>Tipo de sesión</th>
              <th><center>Fecha </br>(AA/MM/DD)</center></th>
              <th>Acción</th> ';
              if($_SESSION["tipo"] == "0"){
                echo '
                <th colspan="2">Administrar</th>
                ';
              }
  echo'</tr>';

  while ($line = mysqli_fetch_array($result)) {

      echo '
            <tr>
              <td> <center>'.$line["numero_sesion"].'<input type="hidden" name="id_sesion" value="'.$line["id"].'"/></center></td>
              <td>'.$line["tipo_sesion"].'</td>
              <td> <center>'.$line["fecha_sesion"].'</center></td>
              <td> <a href="acta.php?acta='.$line["id"].'">Mostrar</a></td>';

              if($_SESSION["tipo"] == "0"){
                echo '<td> <a href="editacta.php?acta='.$line["id"].'" class="onKlic" style="color: orange">Modificar</a></td>
                <td> <a onclick="delete_acta('.$line["id"].')" class="onKlic" style="color:red">Eliminar</a></td>
                ';
              }

      echo '<tr>';

  }
  echo '</table><br>';
mysqli_close($conexion);
  ?>
