<?php
//Su función es únicamente retornar el nombre del punto x, necesario en el visor de archivos.

include "../conexiones/conexion.php";
session_start();

@$conexion = mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());

if (!mysqli_select_db($conexion, $db))
{
  echo "<h2>No fue posible realizar la conexión con la Dase de Datos</h2>";
  exit;
}

$nPunto= $_POST["num_punto"];
$id_orden;
$nombre;

//Obtener la ID de última orden del día registrada.
$orden = mysqli_query($conexion, "SELECT MAX(id) AS id_orden FROM orden_dia") or die ('<b>Error al obtener la id de la sesion</b>' . mysql_error());

if ($row = mysqli_fetch_array($orden)) {
    $id_orden= trim($row[0]);
}

/************RECIBIENDO EL NUMERO EXACTO DEL PUNTO A CONSULTAR************/
$queryO = mysqli_query($conexion, "SELECT distinct s.id_sustrato, s.nombre FROM orden_dia as o inner join orden_tiene as ot inner join sustrato as s on o.id = ot.id_orden and ot.id_sustrato = s.id_sustrato WHERE s.numero = $nPunto and o.id = $id_orden");
if($row= mysqli_fetch_array($queryO)){
    $nombre= $row["nombre"];
}

echo ''.$nombre;

?>
