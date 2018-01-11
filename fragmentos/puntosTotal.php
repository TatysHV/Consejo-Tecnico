<?php /*FUNCIÓN QUE ÚNICAMENTE RETORNA EL TOTAL DE PUNTOS DE UNA ORDEN DEL DÍA*/
include "../conexiones/conexion.php";
session_start();

@$conexion = mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());

if (!mysqli_select_db($conexion, $db))
{
  echo "<h2>No fue posible realizar la conexión con la Dase de Datos</h2>";
  exit;
}

$id_orden = $_POST["orden"];

$orden = mysqli_query($conexion, "SELECT MAX(numero) AS puntosTotales FROM orden_dia inner join ") or die ('<b>Error al obtener la id de la sesion</b>' . mysql_error());
$queryO = mysqli_query($conexion, "SELECT distinct s.id_sustrato, s.nombre FROM orden_dia as o inner join orden_tiene as ot inner join sustrato as s on o.id = ot.id_orden and ot.id_sustrato = s.id_sustrato WHERE s.numero = $nPunto and o.id = $id_orden");
  if ($row = mysqli_fetch_array($orden)) {
      $id_orden= trim($row[0]);
  }

 ?>
