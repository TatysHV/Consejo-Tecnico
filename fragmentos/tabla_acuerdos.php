<center><h3 style="color:#3380FF">Acuerdos del H. Consejo Técnico </h3></center>
</br></br>
<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#form_acuerdo">Buscar acuerdos</button>
<a class="btn btn-primary" href="add_acuerdo.php">Registrar nuevo acuerdo</a>
</br></br>
<?php

include "../conexiones/conexion.php";
/*--------------------------------------------------------------------
 Realizar consulta de acuerdos del año en curso, mostrando de 10 en 10
---------------------------------------------------------------------*/

$color = ''; //Variable para guardar un string hexadecimal
$i = 1;
$pag = $_POST['pag'];
$cantidad = 2; // cantidad de resultados por página
$inicial = $pag * $cantidad;
$sql = $_POST['query'];
$result = mysqli_query($con,$sql) or die('Error al consultar acuerdos');


//Obtener el total de resultados de la consulta para crear páginas
$num_resultados = mysqli_num_rows($result);
$pages = intval($num_resultados / $cantidad); //Total/numero de filas


echo '
    <div style="float: right;"><h5><b>Total de resultados: </b>'.$num_resultados.'</h5></div>
    <table class="table thead-dark table-bordered">
     <thead>
       <tr>
         <th>N°</th>
         <th>Fecha acta</th>
         <th>Etiqueta</th>
         <th>Título</th>
         <th>Mostrar</th>
         <th>Admin</th>
       </tr>
     </thead>
     <tbody>';
     while ($line = mysqli_fetch_array($result)){

       switch($line["estatus"]){
         case 'Entregado': $color = '#D1ECF1';
          break;
         case 'Pendiente': $color = '#FFF3CD';
          break;
         case 'Cancelado': $color = '#F8D7DA';
          break;
         case 'En seguimiento': $color = '#E2E3E5';
          break;
         case 'Completado': $color = '#C3E6CB';
       }

       echo '<tr style="background-color:'.$color.'">
              <td>'.$i.'</td>
              <td><center>'.$line["fecha_acta"].'</center></td>
              <td>'.$line["etiqueta"].'</td>
              <td>'.$line["titulo"].'</td>
              <td><center>
              <button onclick="show_acuerdo('.$line["id"].')" type="button" class="btn btn-primary" >
                Ver contenido
              </button></center></td>
              <td><a href="?id='.$line["id"].'">Editar</a></br><a href="'.$line["id"].'">Eliminar</a></td>
            </tr>';
      $i = $i+1;
     }

     echo '
      </tbody>
    </table>';

    /*----------------------------------------------------------------
                    Creación de botones de paginación
    ----------------------------------------------------------------*/
    echo'
    <center>
    <nav aria-label="Page navigation example">
      <ul class="pagination">';

      if($pag>0){
        echo'<li class="page-item"><a class="page-link" onclick="change_page('.($pag-1).')">Anterior</a></li>';
      }
      else{
        echo'<li class="page-item"><a class="page-link" onclick="change_page('.($pag).')">Anterior</a></li>';
      }

      for($li = 0; $li < ($pages+1); $li++){
            echo'<li class="page-item"><a class="page-link" onclick="change_page('.$li.')">'.$li.'</a></li>';
      }

      if($pages>20){
          echo'<li class="page-item"><a class="page-link" href="#">...</a></li>';
      }

      echo'<li class="page-item"><a class="page-link" onclick="change_page('.($pag+1).')">Siguiente</a></li>
      </ul>
    </nav>
    </center>';

    ?>

    <!--Ventana modal para mostrar la información completa de un acuerdo
     ------------------------------------------------------------------>
    <div id="modal_acuerdo">

    </div>
