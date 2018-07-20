<?php
  include '../conexiones/conexion.php';

  $id_acuerdo = $_POST['id'];

  echo '
  <div id="informacion_acuerdo">
   <div class="modal" id="info_acuerdo" tabindex="-1" role="dialog">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
         <center><h4 class="modal-title">Información del acuerdo</h4></center>
         </div>
         <div class="modal-body">
         <div class="row" style="width: 90%; margin: auto;">';


           $sql = "SELECT * FROM acuerdos WHERE id = '$id_acuerdo'";
           $result3 = mysqli_query($con,$sql) or die('Error al mostrar acuerdo');

           if ($row = mysqli_fetch_array($result3)){

       echo '
             <label>Título:</label></br><p class="inf_acuerdo">'.$row['titulo'].'</p>
             <label>Acuerdo:</label></br><p class="inf_acuerdo">'.$row['acuerdo'].'</p>
             <label>Observaciones:</label></br><p class="inf_acuerdo">'.$row['observaciones'].'</p>
             <label>Etiqueta:</label></br><p class="inf_acuerdo">'.$row['etiqueta'].'</p>
             <label>Estado:</label></br><p class="inf_acuerdo">'.$row['estatus'].'</p>
             <label>Oficio:</label></br><p class="inf_acuerdo"><a href="conexiones/uploads/'.$row['oficio'].'">'.$row['oficio'].'</a></p>
             <label>Acta:</label></br><p class="inf_acuerdo"><a href="conexiones/uploads/'.$row['pdf_acta'].'">'.$row['pdf_acta'].'</a></p>';
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
