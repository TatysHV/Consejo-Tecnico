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
$pag = $_POST['pag'];
$cantidad = 5; // cantidad de resultados por página
$inicial = $pag * $cantidad;
$sql = $_POST['query'];
$query = $sql.' LIMIT '.$inicial.','.$cantidad.''; //Se agrega la limitante de resultados para hacer la paginación
$sql2 = $_POST['query2'];
//echo ''.$query.' -->2:'.$sql2.''; //auxiliar en la visualización de las consultas a realizar
$result = mysqli_query($con, $query) or die('Error al consultar acuerdos');

$result2 = mysqli_query($con, $sql2) or die('Error al consultar acuerdos'); // Necesario para obtener el total de resultados



$i = $inicial+1;


//Obtener el total de resultados de la consulta para crear páginas
$num_resultados = mysqli_num_rows($result2);

$pages = intval($num_resultados / $cantidad); //Total/numero de filas


echo '
    <div style="float: right;"><h5><b>Total de resultados: </b>'.$num_resultados.'</h5></div>
    <table class="table thead-dark table-bordered" id="acuerdos">
     <thead>
       <tr>
         <th>N°</th>
         <th>Etiqueta</th>
         <th>Título</th>
         <th>Acuerdo</th>
         <th>Sesión</th>
         <th>Oficios</th>
         <th>Actas</th>
         <th>Notas</th>
         <th>Seguimiento</th>
         <th>Admin</th>
       </tr>
     </thead>
     <tbody>';
     while ($line = mysqli_fetch_array($result)){

       switch($line["estatus"]){
         case 'Finalizado': $color = '#D1ECF1';
          break;
         case 'Pendiente': $color = '#FFF3CD';
          break;
         case 'Cancelado': $color = '#F8D7DA';
          break;
         case 'En seguimiento': $color = '#E2E3E5';
          break;
         case 'Completado': $color = '#C3E6CB';
       }

     /*echo '<tr style="background-color:'.$color.'">
             <td><strong>'.$i.'</strong></td>
             <td>'.$line["etiqueta"].'</td>
             <td>'.$line["titulo"].'</td>
             <td>'.$line["acuerdo"].'</td>
             <td><center>'.$line["tipo"].' '.$line['numero_sesion'].'</br>'.$line["fecha_acta"].'</center></td>
             <td><span title="Ver oficio PDF"><img src="imagenes/flaticons/pdf.png"></span><br><a href="conexiones/uploads/'.$line["oficio"].'" target="_blank"><img title="Ver oficio Word" src="imagenes/flaticons/doc.png"></td>
             <td><span title="Ver acta"><a href="conexiones/uploads/'.$line["acta_admin"].'" target="_blank"><img src="imagenes/flaticons/pdf.png"></a></span></td>
             <td><center><a onclick ="show_notes('.$line["id"].')" class="onKlic"><img src="imagenes/flaticons/notepad.png"></a></center></td>
             <td><center><img src="imagenes/flaticons/folder.png" onclick="show_acuerdo('.$line["id"].')" class="onKlic"></center></td>
             <td><a href="editacuerdo.php?id='.$line["id"].'">Editar</a></br><a href="" onclick="delete_acuerdo('.$line["id"].')">Eliminar</a></td>
           </tr>';
     $i = $i+1;*/

     echo '<tr style="background-color:'.$color.'">
            <td><strong>'.$i.'</strong></td>
            <td>'.$line["etiqueta"].'</td>
            <td>'.$line["titulo"].'</td>
            <td>'.$line["acuerdo"].'</td>
            <td><center>'.$line["tipo"].' '.$line['numero_sesion'].'</br>'.$line["fecha_acta"].'</center></td>
            <td><span title="Ver oficio PDF"><a href="conexiones/uploads/'.$line["oficio"].'" target="_blank"><img src="imagenes/flaticons/pdf.png"></a></span><br><a href="conexiones/uploads/'.$line["oficio_word"].'" target="_blank"><img title="Ver oficio Word" src="imagenes/flaticons/doc.png"></a></td>
            <td><span title="Ver acta"><a href="conexiones/uploads/'.$line["acta_admin"].'" target="_blank"><img src="imagenes/flaticons/pdf.png"></a></span></td>
            <td><center><a onclick ="show_notes('.$line["id"].')" class="onKlic"><img src="imagenes/flaticons/notepad.png"></a></center></td>
            <td><center><img src="imagenes/flaticons/folder.png" onclick="show_acuerdo('.$line["id"].')" class="onKlic"></center></td>
            <td><a href="editacuerdo.php?id='.$line["id"].'">Editar</a></br><a href="" onclick = "delete_acuerdo('.$line["id"].')">Eliminar</a></td>
          </tr>';

     }

     echo '
      </tbody>
    </table>

    <div>
      <div>
      <center>
        <form action="conexiones/create_table2.php" method="POST">
          <input type="hidden" name="qry" value="'.$sql2.'">
          <input type="submit" class="btn btn-success" value="Descargar tabla en Excel" />
        </form>
      </center>
      </div>
    </div>';
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

      if($pages>60){ //Es necesario programar lo que sucede en este caso
          echo'<li class="page-item"><a class="page-link" href="#">...</a></li>';
      }

      echo'<li class="page-item"><a class="page-link" onclick="change_page('.($pag+1).')">Siguiente</a></li>
      </ul>
    </nav>
    </center>

    <!--Ventana modal para mostrar la información completa de un acuerdo
     ------------------------------------------------------------------>

     <div id="modal_acuerdo">

     </div>

     <!-- Ventana modal para mostrar NOTAS de acuerdos ----------------->

     <div id="modal_notes">

     </div>

    ';

    ?>
