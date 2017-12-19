<?php
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
    echo "<h2>Error al seleccionar la base de datos!!!"; 
    echo '<script> window.location="/2016/consejo_tecnico/portal.php"</script>';
    exit; 
  }

  $id = $_POST['id'];


  /*-----------Consulta sustrato-------------------------------*/
  $sql= "SELECT nombre FROM sustrato where id_sustrato = '$id' ";
  $result = mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());

  while ($line = mysqli_fetch_array($result)) {
      echo '
            <h1>'.$line["nombre"].' &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://132.247.186.25/2016/consejo_tecnico/eliminar/eliminaSustrato.php?sesion='.$id.'">Eliminar</a></h1></br>
            ';
  }


  /*----------Consulta de archivos del sustrato ---------------*/
  $sql= "SELECT a.url, a.nombre, a.id FROM sustrato as s inner join archivo_sustrato as u inner join archivo as a on a.id = u.id_archivo and u.id_sustrato = s.id_sustrato where u.id_sustrato = '$id' ";
  $result = mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());


while ($line = mysqli_fetch_array($result)) {
      echo '
            <label>'.$line["nombre"].' </label>
            <span class="docs"><span class="icon-file-text"></span><a href="http://132.247.186.25/2016/consejo_tecnico/archivos/'.$line["url"].'">Archivo '.$line["id"].'</a></span> &nbsp;&nbsp;
            <a class="btn btn-danger" href="http://132.247.186.25/2016/consejo_tecnico/eliminar/eliminaArchivo.php?archivo='.$line["id"].'&sustrato='.$id.'">Eliminar</a></br></br>

            ';
  }
  
?>
