<?php
  include '../conexiones/conexion.php';

  $id_oficio = $_POST['id'];


  $sql = "SELECT * FROM tabla_seguimiento WHERE id_oficio = '$id_oficio'";
  $result3 = mysqli_query($con,$sql) or die('Error al mostrar tabla de seguimiento');

  $resultados = mysqli_num_rows(mysqli_query($con,"SELECT * FROM tabla_seguimiento WHERE id_oficio = '$id_oficio'"));

  echo '
    <div class="modal" id="tabla_seguimiento" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <center><h3 class="modal-title">Tabla de seguimiento</h3></center>
            </button>
          </div>
          <div class="modal-body">';

            if($resultados!=0){

              echo'
              <table class="table thead-dark table-bordered" id="oficios">
                <thead>
                  <tr style="background-color:#D8D8D8; color:#585858">
                    <th>Turnado a</th>
                    <th>Dependencia</th>
                    <th>Responsable</th>
                    <th>Tipo</th>
                    <th>Observaciones</th>
                    <th>Fecha</th>
                    <th>Oficios respuesta</th>
                  </tr>';

                while ($row = mysqli_fetch_array($result3)){
                 echo '
                     <tr style="color:#424242">
                       <td>'.$row["turnadoA"].'</td>
                       <td>'.$row["dependencia"].'</td>
                       <td>'.$row["responsable"].'</td>
                       <td>'.$row["tipo"].'</td>
                       <td>'.$row["observaciones"].'</td>
                       <td><center>'.$row["fecha"].'</center></td>
                       <td><a href="conexiones/uploads/'.$row["oficio_respuesta"].'" target="_blank"><img src="imagenes/flaticons/doc.png"></a></td>
                     </tr>
                      ';
                  }

                  echo'
                  </table>';

                }else{
                    echo '<h4><center>No hay registro de seguimiento</center></h4>';
                }

                echo'
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>';




 ?>
