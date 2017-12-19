<?php
  header("Content-Type: text/html;charset=utf-8");

  include "../conexiones/conexion.php";

  $conexion = @mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());
  if (!mysqli_select_db($conexion, $db))
  { 
    echo "<h2>Error al seleccionar la base de datos!!!</h2>"; 
    echo '<script> window.location="/2016/consejo_tecnico/index.php"</script>';
    exit; 
  }

  $ID = $_GET['sesion'];
  if(!isset($_GET['sesion'])){
      echo '<script> window.location="/2016/consejo_tecnico/portal.php"</script>';
  }
  $orden;


/*---------------Borrar relacion sustrato/archivo------------------*/
  $sql= "SELECT a.id FROM sustrato as s INNER JOIN archivo_sustrato as au INNER JOIN archivo as a on s.id_sustrato = au.id_sustrato AND a.id = au.id_archivo where s.id_sustrato ='$ID'";
  $result = mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());
  while ($line = mysqli_fetch_array($result)){
      $sql= "DELETE FROM `archivo_sustrato` WHERE `archivo_sustrato`.`id_sustrato` = ".$ID." AND `archivo_sustrato`.`id_archivo` = ".$line["id"]."";
      mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());
      /*----------------------Borrar archivo------------------------*/
      $sql= "DELETE FROM `archivo` WHERE `archivo`.`id` = ".$line["id"]."";
      mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());
  } 

  /*---------------Borrar relacion archivo/orden dia------------------*/
  $sql= "SELECT o.id FROM orden_dia as o INNER JOIN orden_tiene as ot INNER JOIN sustrato as s on o.id = ot.id_orden AND ot.id_sustrato = s.id_sustrato where s.id_sustrato ='$ID'";
  $result = mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());
  while ($line = mysqli_fetch_array($result)){
      $sql= "DELETE FROM `orden_tiene` WHERE `orden_tiene`.`id_orden` = ".$line["id"]." AND `orden_tiene`.`id_sustrato` = '$ID'";
      mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());
      $orden=$line["id"];
  }
  /*----------------------Borrar sustrato------------------------*/
  $sql= "DELETE FROM `sustrato` WHERE `sustrato`.`id_sustrato` = ".$ID."";
  mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error()); 
  mysqli_close($conexion);
  echo '<script> window.location="/2016/consejo_tecnico/addpunto.php?sesion='.$orden.'"</script>';
?>
