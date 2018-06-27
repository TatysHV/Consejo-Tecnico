<?php

include '../conexiones/conexion.php';
session_start();

@$conexion = mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());

$fecha = $_POST["fecha"];
$tipo = $_POST["tipo"];

if (!mysqli_select_db($conexion, $db))
  {
    echo "<h2>Error al seleccionar la base de datos!!!";
    header("Location: actas.php");
    exit;
  }



$sql = 'SELECT * FROM actas WHERE fecha_sesion = "'.$fecha.'" and tipo_sesion = "'.$tipo.'"';
$result = mysqli_query($conexion,$sql) or die ("Error");

if ($line = mysqli_fetch_array($result)) {
    echo '<div class="alert alert-info" role="alert">
            El acuerdo pertenece a la <a href="conexiones/uploads/'.$line["pdf"].'" class="alert-link" target="_blank">Sesión '.$line["tipo_sesion"].' '.$line["numero_sesion"].' del '.$fecha.'</a>
            <input type="hidden" value="'.$line["pdf"].'" name="url_acta">
          </div>';
}
else{
    echo '
    <div class="alert alert-danger" role="alert">
        No se encuentra registrada el acta. <a href="http://localhost/consejo_tecnico/actas.php" class="alert-link">Registrar acta aquí</a>
        <input type="hidden" value="" name="url_acta">
    </div>';

}


?>
