<?php

include "../conexiones/conexion.php";

$year = $_POST['year'];
$asunto = $_POST['asunto'];
$estatus = $_POST['estatus'];
$nombre = $_POST['nombre'];
$folio = $_POST['folio'];
$fecha = $_POST['fecha_emision'];
$dirigido = $_POST['dirigido'];

$color = ''; //Variable para guardar un string hexadecimal
$pag = $_POST['pag']; /* $pag es la pagina actual*/
$cantidad = 10; // cantidad de resultados por página
$inicial = $pag * $cantidad;

$i = $inicial+1; // índice de fila


/*--------------------------------------------------------------------
 Crear la vista de oficios por año para reducir la búsqueda
--------------------------------------------------------------------*/
$query = "CREATE OR REPLACE VIEW vista_oficios AS SELECT * FROM oficios WHERE year(fecha_emision) = '$year'";
$result = mysqli_query($con,$query) or die('Error al crear vista de oficios');


/*-------------------------------------------------------------------
  Creación de la cadena que será usada como consulta para la base de datos
---------------------------------------------------------------------*/
/* Es necesario ir identificando los campos del formulario que fueron
seleccionados para realizar la búsqueda, de este modo se irá concate-
nando en la variable $consulta lo que se necesitará para obtener los
resultados.*/

$consulta = "SELECT * FROM vista_oficios WHERE year(fecha_emision) = '$year'";

if($asunto!=""){
  $consulta = $consulta." AND asunto = '$asunto'";
}

if($estatus!=""){
  $consulta = $consulta." AND estatus = '$estatus'";
}

if($nombre!=""){
  $consulta = $consulta." AND nombre LIKE '%$nombre%'";
}

if($fecha!=""){
  $consulta = $consulta." AND fecha_emision = '$fecha_emision'";
}

if($dirigido!=""){
  $consulta = $consulta." AND dirigidoA LIKE '%$dirigido%'";
}


/*--------------------------------------------------------------------
 Realizar consulta de oficios del año en curso, mostrando de 10 en 10
---------------------------------------------------------------------*/
$contador = $consulta; //Guardamos la sentencia sin delimitar por número de páginas
$consulta = $consulta." LIMIT $inicial, $cantidad"; // Se agrega a la cadena el delimitador de páginas

$result = mysqli_query($con, $consulta) or die('Error al consultar oficios');

/*--------------------------------------------------------------------
 Obtener el total de resultados para crear la paginacion
 ---------------------------------------------------------------------*/

$result2= mysqli_query($con, $contador);
$num_resultados = mysqli_num_rows($result2);
$pages = intval($num_resultados / $cantidad); //Total/numero de filas

/*---------------------------------------------------------------------
 Creación de la tabla HTML con el resultado de la búsqueda
 ---------------------------------------------------------------------*/

echo '
    <div style="float: left"><img src="imagenes/indicecolores.png" style="width: 390px; height: auto;" /></div>
    <div style="float: right;"><h5><b>Total de resultados: </b>'.$num_resultados.'</h5></div>
    <table class="table thead-dark table-bordered" id="acuerdos">
     <thead>
       <tr>
         <th>N°</th>
         <th>Folio</th>
         <th>Fecha oficio</th>
         <th>Nombre</th>
         <th>Asunto</th>
         <th>Dirigido a:</th>
         <th>Sesión</th>
         <th>Oficio</th>
         <th>Anexos</th>
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

       echo '<tr style="background-color:'.$color.'">
              <td><strong>'.$i.'</strong></td>
              <td>'.$line["folio"].'</td>
              <td>'.$line["fecha_emision"].'</td>
              <td>'.$line["nombre"].'</td>
              <td>'.$line["asunto"].'</td>
              <td>'.$line["dirigidoA"].'</td>
              <td><center>'.$line["tipo_sesion"].' '.$line['numero_sesion'].'</br>'.$line["fecha_sesion"].'</center></td>
              <td><span title="Ver oficio PDF"><a href="conexiones/uploads/'.$line["oficio_pdf"].'" target="_blank"><img src="imagenes/flaticons/pdf.png"></a></span><br><a href="conexiones/uploads/'.$line["oficio_word"].'" target="_blank"><img title="Ver oficio Word" src="imagenes/flaticons/doc.png"></a></td>
              <td><span title="Ver archivos anexos"><a type="button" class="onKlic" onclick="show_anexos('.$line["id_oficio"].')"><img src="imagenes/flaticons/folder.png"></a></span></td>
              <td><center><img src="imagenes/flaticons/folder.png" onclick="show_seguimiento('.$line["id_oficio"].')" class="onKlic"><br><span title="Agregar seguimiento"><img src="imagenes/flaticons/plus.png" style="width: 20px; height:auto;" class="onKlic" onclick="show_add_seguimiento('.$line["id_oficio"].')"></a></span></center></td>
              <td><a href="editacuerdo.php? ">Editar</a></br><a href="" onclick = "">Eliminar</a></td>
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
        echo'<li class="page-item"><a class="page-link" href="oficios.php?pag='.($pag-1).'">Anterior</a></li>';
      }
      else{
        echo'<li class="page-item"><a class="page-link" href="oficios.php?pag='.($pag).'">Anterior</a></li>';
      }

      for($li = 0; $li < ($pages+1); $li++){
            echo'<li class="page-item"><a class="page-link" href="oficios.php?pag='.$li.'">'.$li.'</a></li>';
      }

      if($pages>60){ //Es necesario programar lo que sucede en este caso
          echo'<li class="page-item"><a class="page-link" href="#">...</a></li>';
      }

      echo'<li class="page-item"><a class="page-link" href="oficios.php?pag='.($pag+1).'">Siguiente</a></li>
      </ul>
    </nav>
    </center>';

    ?>
