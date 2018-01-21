<?php
  include "../conexiones/conexion.php";

 @$conexion = mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());
  if (!mysqli_select_db($conexion, $db))
  {
    echo "<h2>Error al seleccionar la base de datos!!!";
    header("Location: index.php");
    exit;
  }




  $id = $_POST['id'];
  $padre=$_POST['padre'];

$sql= "SELECT distinct cha.id_carpeta, cha.nombre FROM sustrato as s inner join carpeta_sustrato as cs inner join carpeta_raiz as cr inner join cpadre_chijos as cch inner join carpeta_hija as cha on s.id_sustrato = cs.id_sustrato and cs.id_carpeta = cr.id_raiz and cr.id_raiz = cch.id_padre and cch.id_hijo = cha.id_carpeta where cs.id_sustrato='$id' and cha.tipo = '1' and cha.id_carpeta_padre = $padre"; //and cha.tipo = '1'


  //$sql= "SELECT a.url, a.nombre, a.id FROM sustrato as s inner join archivo_sustrato as u inner join archivo as a on a.id = u.id_archivo and u.id_sustrato = s.id_sustrato where u.id_sustrato = '$id' ";

  $result = mysqli_query($conexion, $sql) or die('<b>No se encontraron coincidencias</b>' . mysqli_error());
  while ($line = mysqli_fetch_array($result)) {
/*
<div id="carp_punto" onclick="desplegar_sub('.$id.','.$line["id_carpeta"].')">
            <span class="docs"><span class="icon-folder"></span>'.$line["nombre"].'</span></div>
            <input type="hidden" value="0" id="vista'.$line["id_carpeta"].'"/>
*/
      echo '
             <div id="carp_punto" onclick="desplegar_sub('.$id.','.$line["id_carpeta"].','.$padre.')">
                  <span class="docs">
                    <span class="icon-folder"></span>'.$line["nombre"].'</span>
              </div>
                  <div id="puntos'.$line["id_carpeta"].'" style="width: 85%; margin:auto;">
                  </div>
              <input type="hidden" value="0" id="vista'.$line["id_carpeta"].'"/>
            ';
  }


if($padre==0){
  $qFiles = "SELECT distinct a.id, a.nombre, a.url, a.id_carpeta FROM sustrato as s inner join carpeta_sustrato as cs inner join carpeta_raiz as cr inner join cpadre_chijos as cch inner join carpeta_hija as cha inner join archivo as a on s.id_sustrato = cs.id_sustrato and cs.id_carpeta = cr.id_raiz and cr.id_raiz = cch.id_padre and cch.id_hijo = cha.id_carpeta and cha.id_carpeta = a.id_carpeta where cs.id_sustrato='$id' and cha.id_carpeta_padre = 0 and cha.tipo = '0'";
}
else{
  $qFiles = "SELECT distinct a.id, a.nombre, a.url, a.id_carpeta FROM sustrato as s inner join carpeta_sustrato as cs inner join carpeta_raiz as cr inner join cpadre_chijos as cch inner join carpeta_hija as cha inner join archivo as a on s.id_sustrato = cs.id_sustrato and cs.id_carpeta = cr.id_raiz and cr.id_raiz = cch.id_padre and cch.id_hijo = cha.id_carpeta and cha.id_carpeta = a.id_carpeta where cs.id_sustrato='$id' and a.id_carpeta = '$padre' and cha.tipo = '1'";
}

  $result2 = mysqli_query($conexion, $qFiles) or die('<b>No se encontraron coincidencias</b>' . mysql_error($conexion));


    while ($line = mysqli_fetch_array($result2)) {

      echo '
            <span class="docs"><span class="icon-file-text"></span><a href="http://132.247.186.25/2016/consejo_tecnico/conexiones/uploads/'.$line["url"].'">'.$line["nombre"].'</a></span></br>
            ';
  }


mysqli_close($conexion);
//-----------------------------------//


?>