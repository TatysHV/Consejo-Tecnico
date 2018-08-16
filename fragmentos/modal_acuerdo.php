<?php
  include '../conexiones/conexion.php';

  $id_acuerdo = $_POST['id'];

  echo '
  <div id="informacion_acuerdo">
   <div class="modal" id="info_acuerdo" tabindex="-1" role="dialog">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
         <center><h4 class="modal-title">Archivos de seguimiento</h4></center>
         </div>
         <div class="modal-body">
         <div class="row" style="width: 90%; margin: auto;">';


           $sql = "SELECT * FROM acuerdos_files WHERE id = '$id_acuerdo'";
           $result3 = mysqli_query($con,$sql) or die('Error al mostrar acuerdo');

           if ($row = mysqli_fetch_array($result3)){

       echo '
              <table id="acuerdos_notas">
                <tr>
                  <th>Nombre del archivo</th>
                  <th>Fecha </th>
                  <th>Tamaño </th>
                </tr>
                <tr>
                  <td><img src="imagenes/flaticons/document.png"><a href="conexiones/uploads/'.$row['name'].'" targer="_blank">'.$row['name'].'</td>
                  <td><center>2018/01/01</center></td>
                  <td><center>128kb</center></td>
                </tr>
              </table>
            ';
           }

      echo'
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
