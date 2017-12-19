/*******************************************************************************
Este archivo es el encargado de mostrar el contenido de un punto de la orden del
día, y está por separado para que pueda ser llamado desde un AJAX, para
que se refresquen constantemente.
********************************************************************************/
<?php
include "../conexiones/conexion.php";

@$conexion = mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());
if (!mysqli_select_db($conexion, $db))
{
  echo "<h2>Error al seleccionar la base de datos!!!";
  header("Location: index.php");
  exit;
}

/*sentencia SQL de inner join por Fil :)
la sentencia debe mostrar las carpetas y los archivos de la última carpeta padre creada
ejemplo: id_carpeta:18, tipo:0, padre:0. Todas las carpetas por default, tienen como padre definido el 0
y como tipo el 0.
*/

?>

//
  <div>
    <ul id="listaContenido">
      <li><a href=""><i class="fa fa-folder" aria-hidden="true"></i> Carpeta 1</a></li>
      <li><a href=""><i class="fa fa-folder" aria-hidden="true"></i> Carpeta 2</a></li>
      <li><a href=""><i class="fa fa-folder" aria-hidden="true"></i> Carpeta 3</a></li>
      <li><a href=""><i class="fa fa-file-o" aria-hidden="true"></i> Archivo 1</a></li>
      <li><a href=""><i class="fa fa-file-o" aria-hidden="true"></i> Archivo 2</a></li>
    </ul>
  </div>
