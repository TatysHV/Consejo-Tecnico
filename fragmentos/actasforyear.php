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
              <th>Orden día</th>
              <th>Acta</th>
              <th>Minuta</th>';
              if($_SESSION["tipo"] == "0"){
                echo '
                <th colspan="2">Administrar</th>
                ';
              }
  echo'</tr>';

  while ($line = mysqli_fetch_array($result)) {


      $fecha_sesion = $line["fecha_sesion"];
      $tipo = $line["tipo_sesion"];

      //Obtener el archivo pdf de la orden del día.
      $query_orden = "SELECT od.direccion FROM orden_dia as od INNER JOIN actas as a ON od.fecha_sesion = a.fecha_sesion
                      AND od.tipo = a.tipo_sesion WHERE a.fecha_sesion = '$fecha_sesion' AND a.tipo_sesion = '$tipo'";

      $ejec = mysqli_query($conexion,$query_orden) or die ('Error al obtener acta'.mysql_error($conexion));

      echo '
            <tr>
              <td> <center>'.$line["numero_sesion"].'<input type="hidden" name="id_sesion" value="'.$line["id"].'"/></center></td>
              <td>'.$line["tipo_sesion"].'</td>
              <td> <center>'.$line["fecha_sesion"].'</center></td>';

              if($row = mysqli_fetch_row($ejec)){
                echo '<td> <a href="conexiones/uploads/'.$row[0].'" target="_blank"><img style="width:20px; height:auto" src="imagenes/flaticons/pdf.png"></a></td>';
              }else{
                echo '<td> <span title="Orden día no registrada"><img style="width:20px; height:auto" src="imagenes/flaticons/pdf.png"></span></td>';
              }
              echo'
              <td> <center><a href="conexiones/uploads/'.$line["pdf"].'" target="_blank"><img style="width:20px; height:auto" src="imagenes/flaticons/pdf.png"></a></center></td>
              <td> <center><a href="conexiones/uploads/'.$line["minuta"].'" target="_blank"><img style="width:20px; height:auto" src="imagenes/flaticons/pdf.png"></a></center></td>';

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
