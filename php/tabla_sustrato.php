<?php

$puntos=$_POST['cantidad'];
$cont = 0;
$indice = 1;

echo '
<legend>Sustrato de la Orden del Día</legend>
  <table id="add_sustrato">
    <tr>
      <th>Punto</th>
      <th><center>Nombre</center></th>
      <th><center>Proteger</center></th>
      <th><center>Acción</center></th>
    </tr>';

    while ($cont<$puntos){
      echo '
          <tr>
            <td style="color:#0B0B61"><b><center>'.$indice.'</center></b></td>
            <td><input type="text" name="punto'.$indice.'" class="tsesion" style="width: 300px; margin-top: 5px;"></td>
            <td><center><input type="radio" name="prot'.$indice.'" class="tsesion"></center></td>
            <td><input name="uploadedfile" name="files'.$indice.'" type="file" multiple="true" class="file"/></td>
          </tr>';
      $cont++;
      $indice++;
    }

echo '</table>';

 ?>
