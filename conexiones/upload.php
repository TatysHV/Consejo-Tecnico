<?php

  include "conexion.php";

  $etiqueta = $_POST['etiqueta'];
  $pertenece = $_POST['pertenece'];


  $query = mysqli_query($con, "INSERT INTO lista_etiquetas(etiqueta, pertenece) VALUES ('$etiqueta', '$pertenece')");

    if(!$query){
      //echo "Ocurrió un error" . $query;
    }
    else{
      //echo "Etiqueta registrada";
    }


/*
    $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Secretaría académica' ORDER BY etiqueta ASC";
    $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

  echo'
    <div class="form-group">
    <label for="">Etiqueta:</label><br>
    <select class="selectpicker" name="etiquetaAC" data-width="100%" data-live-search="true" title="Seleccionar etiqueta" >
    <optgroup label="Secretaría académica">';

      while ($line = mysqli_fetch_array($result)) {
        echo'<option>'.$line["etiqueta"].'</option>';
      }
      echo'</optgroup>';

      //Muestra las etiquetas que pertenecen a servicios escolares
      $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Servicios escolares' ORDER BY etiqueta ASC";
      $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

      echo'
      <optgroup label="Servicios escolares">';

      while ($line = mysqli_fetch_array($result)) {
        echo'<option>'.$line["etiqueta"].'</option>';
      }
      echo'</optgroup>';

      //Muestra las etiquetas que pertenecen a Secretaría de investigación y posgrado
      $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Secretaría de investigación y posgrado' ORDER BY etiqueta ASC";
      $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

      echo'
      <optgroup label="Secretaría de investigación y posgrado">';

      while ($line = mysqli_fetch_array($result)) {
        echo'<option>'.$line["etiqueta"].'</option>';
      }
      echo'</optgroup>';

      //Muestra las etiquetas que pertenecen a Secretaría de vinculación
      $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Secretaría de vinculación' ORDER BY etiqueta ASC";
      $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

      echo'
      <optgroup label="Secretaría de vinculación">';

      while ($line = mysqli_fetch_array($result)) {
        echo'<option>'.$line["etiqueta"].'</option>';
      }
      echo'</optgroup>';

      //Muestra las etiquetas que pertenecen a Comités y comisiones
      $sql="SELECT * FROM lista_etiquetas WHERE pertenece = 'Comités y comisiones' ORDER BY etiqueta ASC";
      $result = mysqli_query($con, $sql) or die('<b>No se encontraron coincidencias</b>' . mysql_error($con));

      echo'
      <optgroup label="Comités y comisiones">';

      while ($line = mysqli_fetch_array($result)) {
        echo'<option>'.$line["etiqueta"].'</option>';
      }

      echo'</optgroup>
      </select>
          </div>';
*/


 ?>
