<?php
  header("Content-Type: text/html;charset=utf-8");
  session_start();
    include "../conexiones/conexion.php";
    if(!isset($_SESSION['usuario'])){
        echo '<script> window.location="/2016/consejo_tecnico/index.php"</script>';
    }
    if($_SESSION['tipo'] == 1)
	{
		echo '<script> window.location="/2016/consejo_tecnico/portal.php"</script>';
	}  


  $conexion = @mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());
  if (!mysqli_select_db($conexion, $db))
  { 
    echo "<h2>Error al seleccionar la base de datos!!!</h2>"; 
    echo '<script> window.location="/2016/consejo_tecnico/portal.php"</script>';
    exit; 
  }

  $arc = $_GET['archivo'];
  $ID = $_GET['sustrato'];
  $orden;
  if(!isset($_GET['archivo']) && !!isset($_GET['sustrato'])){
	echo '<script> window.location="/2016/consejo_tecnico/portal.php"</script>';
  }


  $sql= "SELECT  o.id FROM orden_dia as o inner join orden_tiene as t inner join sustrato as s INNER JOIN archivo_sustrato as au INNER JOIN archivo as a on o.id = t.id_orden and t.id_sustrato = s.id_sustrato and a.id = au.id_archivo and au.id_sustrato = s.id_sustrato where a.id='$arc'";
  $result=mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());
  while ($line= mysqli_fetch_array($result)) {
      $orden = $line["id"];
  }
  
  


  /*---------------elimina relacion sustrato/archivo-----------*/
  $sql= "DELETE FROM `archivo_sustrato` WHERE `archivo_sustrato`.`id_sustrato` = '$ID' AND `archivo_sustrato`.`id_archivo` = '$arc'";
  mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());

  /*---------------elimina archivo en servidor-----------------*/
  /*$sql= "SELECT url FROM archivo WHERE id = '$arc'";
  $result = mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());
  while ($line = mysqli_fetch_array($result)) {
    $file = '/Applications/XAMPP/xamppfiles/htdocs/SHCT/archivos/'.$line["url"].'';
    if (!unlink($file))
    {
      echo ("Error deleting $file");
    }
    else
    {
      echo ("Deleted $file");
    }
  }
  */

  /*---------------elimina registro de archivo-----------------*/  
  $sql= "DELETE FROM `archivo` WHERE `archivo`.`id` = '$arc'";
  mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());
 mysqli_close($conexion);
  echo '<script> window.location="/2016/consejo_tecnico/addpunto.php?sesion='.$orden.'"</script>';
?>
