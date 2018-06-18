<?php

//include '../conexiones/conexion.php';
/*session_start();

@$conexion = mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());


if (!mysqli_select_db($conexion, $db))
  {
    echo "<h2>Error al seleccionar la base de datos!!!";
    header("Location: actas.php");
    exit;
  }

$fecha = $_POST["fecha"];

$sql = 'SELECT * FROM actas WHERE fecha_sesion = '.$fecha;
$result = mysqli_query($conexion,$sql) or die ("Error");

if ($line = mysqli_fetch_array($result)) {
    echo '<td>'.$line["tipo_sesion"].'</td><td>'.$line["numero_sesion"].'</td><td>'.$fecha.'</td><td><a href="'.$line["pdf"].'>"Ver acta</a></td>';
}
else{
    echo 'No existe el acta registrado. <a href="http://localhost/consejo_tecnico/actas.php">Registrar aquí</a>';
}
*/
echo 'tuputamadre';
?>
