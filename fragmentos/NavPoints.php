<?php
//Archivo dedicado a arrojar informacion referente a los puntos de la orden del día


include "../conexiones/conexion.php";
session_start();

@$conexion = mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());

if (!mysqli_select_db($conexion, $db))
{
  echo "<h2>No fue posible realizar la conexión con la Dase de Datos</h2>";
  exit;
}

$funcion = $_POST['func'];

switch($funcion){
  case 1:
  break;
  case 2:
  break;
  case 3:
  break;
  case 4:
  break;
}

function blabla(){

}

?>
