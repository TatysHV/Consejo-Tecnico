<?php
  include '../conexiones/conexion.php';

  $id_acuerdo = $_POST['id'];

  echo '
  <div id="informacion_acuerdo">
   <div class="modal" id="notas_acuerdo" tabindex="-1" role="dialog">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
         <center><h4 class="modal-title">Notas y observaciones del acuerdo</h4></center>
         </div>
         <div class="modal-body">
         <div class="row" style="width: 90%; margin: auto;">';


           $sql = "SELECT * FROM acuerdos WHERE id = '$id_acuerdo'";
           $result3 = mysqli_query($con,$sql) or die('Error al mostrar acuerdo');

           if ($row = mysqli_fetch_array($result3)){

             echo '<p class="inf_acuerdo">'.$row['observaciones'].'</p>';

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
