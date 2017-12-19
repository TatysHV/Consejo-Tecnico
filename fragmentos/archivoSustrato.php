<?php
  include "../conexiones/conexion.php";

 @$conexion = mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());
  if (!mysqli_select_db($conexion, $db))
  {
    echo "<h2>Error al seleccionar la base de datos!!!";
    header("Location: index.php");
    exit;
  }

  $id = $_POST['id'];

  $sql= "SELECT a.url, a.nombre, a.id FROM sustrato as s inner join carpeta_sustrato as u inner join archivo as a on a.id = u.id_carpeta and u.id_sustrato = s.id_sustrato where u.id_sustrato = '$id' ";
  //$sql= "SELECT a.url, a.nombre, a.id FROM sustrato as s inner join archivo_sustrato as u inner join archivo as a on a.id = u.id_archivo and u.id_sustrato = s.id_sustrato where u.id_sustrato = '$id' ";

  $result = mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());

  while ($line = mysqli_fetch_array($result)) {

      echo '
            <span class="docs"><span class="icon-file-text"></span><a href="http://132.247.186.25/2016/consejo_tecnico/conexiones/uploads/'.$line["url"].'">'.$line["nombre"].'</a></span></br>

            ';
  }
mysqli_close($conexion);
?>
