<?php
  include '../conexiones/conexion.php';

  $id_oficio = $_POST['id'];

  echo '
  <div id="informacion_acuerdo">
   <div class="modal" id="oficio_anexos" tabindex="-1" role="dialog">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
         <center><h4 class="modal-title">Archivos anexos</h4></center>
         </div>
         <div class="modal-body">
         <div class="row" style="width: 90%; margin: auto;">';

echo '
              <table id="acuerdos_notas" >
                <tr>
                  <th>Nombre del archivo</th>
                  <th>Fecha </th>
                  <th>Tamaño </th>
                  <th>Admin </th>
                </tr>';
            $sql = "SELECT * FROM archivos_anexos WHERE id_oficio = '$id_oficio'";
           $result3 = mysqli_query($con,$sql) or die('Error al mostrar archivos anexos');
           while ($row = mysqli_fetch_array($result3)){

       echo '
                <tr>
                  <td><img src="imagenes/flaticons/document.png"><a href="conexiones/uploads/'.$row['nombre'].'" targer="_blank">'.$row['nombre'].'</td>
                  <td><center>'.$row["fecha"].'</center></td>
                  <td><center>'.$row["tamaño"].' KB</center></td>
                  <td><a href="" onclick = "delete_file_anexos('.$row["id"].')">Eliminar</a></td>
                </tr>

            ';
           }

      echo'</table>
           </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
         </div>
       </div>
     </div>
   </div>
 </div>
 ';
 ?>
