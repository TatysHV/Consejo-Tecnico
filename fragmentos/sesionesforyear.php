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

  //$sql= "SELECT * FROM orden_dia WHERE year(fecha_sesion) = '$year' ORDER BY numero_sesion"; Muestra ordenados por numero de sesion
  $sql= "SELECT * FROM orden_dia WHERE year(fecha_sesion) = '$year' ORDER BY fecha_sesion ASC"; // Muestra ordenados por fecha de sesion

  $result = mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($conexion));

  echo '<div class="sesiones" id="bloque_desplegable">
          <table id="sesiones">
            <tr>
              <th><center>N°</center></th>
              <th width="350">Tipo de sesión</th>
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

  $i = 0;
  while ($line = mysqli_fetch_array($result)) {
      $i++;

      $fecha_sesion = $line["fecha_sesion"];
      $tipo_sesion = $line["tipo"];

      //Obtener el archivo pdf del acta cuyo fecha y tipo sesión son iguales a la orden del día.
      $query = "SELECT a.pdf FROM actas as a INNER JOIN orden_dia as od ON a.fecha_sesion = od.fecha_sesion
                AND a.tipo_sesion = od.tipo WHERE od.fecha_sesion = '$fecha_sesion' AND od.tipo = '$tipo_sesion'";
      $ejec = mysqli_query($conexion,$query) or die ('Error al obtener acta'.mysql_error($conexion));

      //Obtener el archivo pdf de la minuta cuya fecha y tipo sesión son iguales a la orden del día.
      $query_minuta = "SELECT a.minuta FROM actas as a INNER JOIN orden_dia as od ON a.fecha_sesion = od.fecha_sesion
                      AND a.tipo_sesion = od.tipo WHERE od.fecha_sesion = '$fecha_sesion' AND od.tipo = '$tipo_sesion'";
      $ejec_minuta = mysqli_query($conexion,$query_minuta) or die ('Error al obtener minuta');

      echo '
            <tr>
              <td> <center> '.$i.' <input type="hidden" name="id_sesion" value="'.$line["id"].'"/></center></td>
              <td><center>'.$line["tipo"].' '.$line["numero_sesion"].'</center></td>
              <td> <center>'.$line["fecha_sesion"].'</center></td>
              <td> <a href="sesion.php?sesion='.$line["id"].'"><img style="width:20px; height:auto" src="imagenes/flaticons/folder.png"></a></td>';

              if($row = mysqli_fetch_row($ejec)){
                echo '<td> <center><a href="conexiones/uploads/'.$row[0].'"><img style="width:20px; height:auto" src="imagenes/flaticons/pdf.png"></a></center></td>';
              }else{
                echo '<td> <center><span title="No hay acta registrada"><img style="width:20px; height:auto" src="imagenes/flaticons/pdf.png"></span></center></td>';
              }

              if($row2 = mysqli_fetch_row($ejec_minuta)){
                if ($row2[0]==""){
                  echo '<td> <center><span title="No hay minuta registrada"><img style="width:20px; height:auto" src="imagenes/flaticons/pdf.png"></span></center></td>';
                }
                else{
                  echo '<td> <center><a href="conexiones/uploads/'.$row2[0].'"><img style="width:20px; height:auto" src="imagenes/flaticons/pdf.png"></a></center></td>';
                }
              }

              if($_SESSION["tipo"] == "0"){
                echo '<td> <a href="editsesion.php?sesion='.$line["id"].'" style="color: orange">Modificar</a></td>
                <td> <a onclick="delete_orden_dia('.$line["id"].')" style="color:red">Eliminar</a></td>
                ';
              }

      echo '<tr>';

  }
  echo '</table><br>';
mysqli_close($conexion);
  ?>
