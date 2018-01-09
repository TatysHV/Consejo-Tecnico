<?php

/*ESTE ARCHIVO PHP SE ENCARGA DE GENERAR EL VISOR DE ARCHIVOS DE UNA SESIÓN
LOS DATOS QUE NECESITA SON LA ID DE LA ORDEN DEL DÍA Y EL NÚMERO DEL PUNTO A CONSULTAR*/

include "../conexiones/conexion.php";
session_start();

@$conexion = mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());

if (!mysqli_select_db($conexion, $db))
{
  echo "<h2>No fue posible realizar la conexión con la Dase de Datos</h2>";
  header("Location: sesiones.php");
  exit;
}
/*EXISTEN DOS CASOS UNO DONDE SE DEBE OBTENER LA ÚLTIMA ID DE UNA ORDEN DEL DIA
Y OTRO DONDE DESDE UNA FUNCIÓN EXTERNA SE MANDA DIRETAMENTE LA ID DE LA ORDEN DEL DIA
(ya no es necesario obtener su id mediante consulta sql)*/

$recibeID = 1;

$nPunto= $_POST["num_punto"];
$id_orden;


/*EL VALOR DEL ID_PUNTO DEPENDERÁ DE SI SE ESTÁ VISUALIZANDO EL CONTENIDO DEL ULTIMO
PUNTO CREADO, EL CUAL SUCEDE INMEDIATAMENTE DESPUÉS DE REGISTRAR UN NUEVO PUNTO.
O EN EL CASO DE QUE SE ESTÉ CONSULTANDO A TRAVÉS DEL BOTÓN ADELANTE O ATRÁS, ES necesario
OBTENER EL ID DEL PUNTO EN EL QUE SE ESTÁ NAVEGANDO, A TRAVÉS DE LA CONSULTA DEL CASO 1*/
$id_punto;

if($recibeID == 1){ //En caso de que sí esté recibiendo la id de la orden del día.
  $id_orden = $_POST["orden"];
}

elseif($recibeID == 0){
  //Obtener la ID de última orden del día registrada.
$orden = mysqli_query($conexion, "SELECT MAX(id) AS id_orden FROM orden_dia") or die ('<b>Error al obtener la id de la sesion</b>' . mysql_error());

  if ($row = mysqli_fetch_array($orden)) {
      $id_orden= trim($row[0]);
  }
}



/************OBTIENE EL ID DEL PUNTO A PARTIR DE SU NUMERO********************/
$queryO = mysqli_query($conexion, "SELECT distinct s.id_sustrato, s.nombre FROM orden_dia as o inner join orden_tiene as ot inner join sustrato as s on o.id = ot.id_orden and ot.id_sustrato = s.id_sustrato WHERE s.numero = $nPunto and o.id = $id_orden");
if($row= mysqli_fetch_array($queryO)){
    $id_punto= $row["id_sustrato"];
}
/*****************************************************************************/


$carpeta = $_POST["carpeta"];
/**************MOSTRAR CARPETAS***********************************************/
$queryFolder = "SELECT distinct cha.id_carpeta, cha.nombre FROM sustrato as s inner join carpeta_sustrato as cs inner join carpeta_raiz as cr inner join cpadre_chijos as cch inner join carpeta_hija as cha on s.id_sustrato = cs.id_sustrato and cs.id_carpeta = cr.id_raiz and cr.id_raiz = cch.id_padre and cch.id_hijo = cha.id_carpeta where cs.id_sustrato='$id_punto' and cha.tipo = '1' and cha.id_carpeta_padre = $carpeta"; //and cha.tipo = '1'

//$sql= "SELECT * FROM orden_dia WHERE year(fecha_sesion) = '$year' ORDER BY numero_sesion";

$result = mysqli_query($conexion, $queryFolder) or die('<b>No se encontraron coincidencias</b>' . mysql_error($conexion));

while ($line = mysqli_fetch_array($result)) {

  echo '<div id="wrap"> <div id="carpeta" onclick="selec_carp('.$line["id_carpeta"].')"><img src="imagenes/flaticons/folder.png"> '.$line["nombre"].' </div> <div class="edit" onclick="optionsEditFolder('.$line["id_carpeta"].')"><i class="fa fa-pencil" aria-hidden="true"></i></div></div>';

}

/**************MOSTRAR ARCHIVOS**************************************/

if($carpeta==0){
  $qFiles = "SELECT distinct a.id, a.nombre, a.id_carpeta FROM sustrato as s inner join carpeta_sustrato as cs inner join carpeta_raiz as cr inner join cpadre_chijos as cch inner join carpeta_hija as cha inner join archivo as a on s.id_sustrato = cs.id_sustrato and cs.id_carpeta = cr.id_raiz and cr.id_raiz = cch.id_padre and cch.id_hijo = cha.id_carpeta and cha.id_carpeta = a.id_carpeta where cs.id_sustrato='$id_punto' and cha.id_carpeta_padre = 0 and cha.tipo = '0'";
}
else{
  $qFiles = "SELECT distinct a.id, a.nombre, a.id_carpeta FROM sustrato as s inner join carpeta_sustrato as cs inner join carpeta_raiz as cr inner join cpadre_chijos as cch inner join carpeta_hija as cha inner join archivo as a on s.id_sustrato = cs.id_sustrato and cs.id_carpeta = cr.id_raiz and cr.id_raiz = cch.id_padre and cch.id_hijo = cha.id_carpeta and cha.id_carpeta = a.id_carpeta where cs.id_sustrato='$id_punto' and a.id_carpeta = '$carpeta' and cha.tipo = '1'";
}

  $result2 = mysqli_query($conexion, $qFiles) or die('<b>No se encontraron coincidencias</b>' . mysql_error($conexion));


    while ($line = mysqli_fetch_array($result2)) {

      echo '<div id="wrap"> <div id="archivo" onclick=""><img src="imagenes/flaticons/file.png"> '.$line["nombre"].'</div> <div class="edit" onclick="optionsEditFile('.$line["id"].')"><i class="fa fa-pencil" aria-hidden="true"></i></div></div>';

    }

 ?>
