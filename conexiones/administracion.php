<?php

// Motrar todos los errores de PHP
error_reporting(E_ALL);

  include "conexion.php";

  $funcion = $_POST['funcion'];

  switch ($funcion) {
      case 0: RegistrarUsuario();
      break;
      case 1: ShowEditUser();
      break;
      case 2: editUser();
      break;
      case 3: showUsersTable();
      break;
      case 4: deleteUser();
      break;
      case 5: subirCalendario();
      break;
      case 6: registrarRegGral();
      break;
      case 7: registrarRegCT();
      break;
      case 8: deleteReg();
      break;
      case 9: registrarComiteA();
      break;
      case 10: registrarComiteO();
      break;
      case 11: deleteCom();
      break;
      case 12: registrarComisionD();
      break;
      case 13: registrarComisionE();
      break;
      case 14: deleteComision();
      break;
      case 15: editComision();
      break;
      case 16: editComite();
      break;
      case 17: registrarComiteP();
      break;
  }

  function RegistrarUsuario(){
    include "conexion.php";

    $username = $_POST['username'];
    $password = $_POST['password'];
    $type = $_POST['type'];
    $note = $_POST['nota'];
    echo "Tipo = ".$type;

    $query= mysqli_query($con, "INSERT INTO users( usuario, password, tipo, nota) VALUES ('$username', SHA('$password'), '$type','$note')");

  }

  function ShowEditUser(){
    include "conexion.php";

    $id_user = $_POST['id_user'];

    $query= 'SELECT * FROM users WHERE id = '.$id_user.'';
    $result = mysqli_query($con, $query) or die();

    if($line = mysqli_fetch_array($result)){
      $username = $line['usuario'];
      $usertype = $line['tipo'];
      $userdesc = $line['nota'];
    }

    echo '
    <div class="bloque_desplegable" style="background-color: #fff9d6; width: 80%;">

    <div class ="titular" style="background-color: #ff9f13;"><center>EDITAR USUARIO</center></div></br>

    <form enctype="multipart/form-data" action="" method="POST" class="forma">
      <div class="auxiliar">

      <center><!--<legend>Datos del usuario</legend>-->
        <br><br>

      <table id="newUser" style="width: 400px;">
        <tr>
          <td colspan="2"><label class="Lform">Nombre: </label></td>
          <td colspan="2"><input type="text" class="fsesion" style="width:100%;" id="newuserName" name="newnombre" value="'.$username.'"></td>
        </tr>
        <tr>
          <td colspan="2"><label>Contraseña: </label></td>
          <td colspan="2"><input type="text" class="fsesion" style="width:100%;" id="newuserPass" name="newpassword" placeholder="Ingresar nueva contraseña"></td>
        </tr>
        <tr>
          <td colspan="2"><label>Descripción: </label></td>
          <td colspan="2"><input type="text" class="fsesion" style="width:100%;" id="newuserDesc" name="newdescripcion" value="'.$userdesc.'"></td>
        </tr>
        <tr>
          <td colspan="2"><label>Permisos: </label></td>
          <td colspan="2"><select id="newuserType" >';
          if ($usertype == 0){ //En caso de ser usuario tipo 0 aparecerá en primera posición opción de TODOS los permisos
            echo '<option value="0">Todos</option>
            <option value="1">Limitados</option>';
          }else{ //En caso de ser usuario tipo 1 aparecerá en primera posición opción de LIMITADOS los permisos.
            echo '<option value="1">Limitados</option>
            <option value="0">Todos</option>';
          }
          echo'
          </select>
          </td>
        </tr>
      </table>
      </br></br>
      <center><input class="btn btn-warning" onclick="updateUser('.$id_user.')" value="Realizar cambios"></center>
    </center>
      </div>
      </form>
        </br></br>
      </div>
    ';

  }

  function editUser(){
    include "conexion.php";

    $id_user = $_POST['id'];
    $nombre = $_POST['username'];
    $tipo = $_POST['type'];
    $nota = $_POST['nota'];
    $flagPass = $_POST['flagPass'];
    $pass = "";

    if($flagPass == true){//Se requiere hacer un cambio de contraseña
        $pass = $_POST['password'];
        $query= mysqli_query($con, "UPDATE users SET usuario='$nombre', password=SHA('$pass'), tipo='$tipo', nota='$nota' WHERE id ='$id_user'");

    }else{
      $query= mysqli_query($con, "UPDATE users SET usuario='$nombre', tipo='$tipo', nota='$nota' WHERE id ='$id_user'");
    }
  }

  function showUsersTable(){
    include "conexion.php";

    $query= 'SELECT * FROM users WHERE 1'; //Consulta para obtener todos los usuarios registrados
    $result = mysqli_query($con, $query) or die();

    echo '
    <legend>Tabla de usuarios registrados</legend>
    <table border=1 color=grey id="Users" style="width: 800px; class="tabla_usuarios">
      <tr>
        <th>Nombre de usuario</th>
        <th>Permisos</th>
        <th>Descripción</th>
        <th>Acción</th>
      </tr>';

      while ($usuario = mysqli_fetch_array($result)){

        if($usuario['tipo'] == 0){
          $permisos = "Todos";
        }
        elseif($usuario['tipo']== 1){
          $permisos = "Limitados";
        }

        echo '
        <tr>
          <td><center>'.$usuario['usuario'].'</center></td>
          <td><center>'.$permisos.'</center></td>
          <td><center>'.$usuario['nota'].'</center></td>
          <td><center><a onclick="show_edit_user('.$usuario['id'].')" style="cursor: pointer">Editar</a>&nbsp;&nbsp;&nbsp;<a onclick="deleteUser('.$usuario['id'].')" style="color: red; cursor:pointer">Eliminar</a></center></td>
        </tr>
        ';
        }
    echo'
    </table>';

  }

  function deleteUser(){
    include "conexion.php";
    $id_user = $_POST['id'];

    $query= mysqli_query($con, "DELETE FROM users WHERE id ='$id_user'");

    if(!$query){
      die('Consulta no válida: ' . mysql_error());
    }
  }

  function subirCalendario(){
    include "conexion.php";
    /*Existen dos tipos de calendarios que se pueden subir desde el panel de control, el js de down_value nos
    ayuda a distingir entre el calendario general y el calendario de sesiones, las siguientes condiciones
    sube uno u otro dependiendo del que se desea modificar.*/

    $tipo = $_POST["tipo"];
    $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

    if($tipo == 'calgeneral'){
      //----------Subir cada uno de los archivos a la carpeta del servidor
      foreach ($_FILES['cal_gral']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
        //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

        //----------- Subir la info de cada archivo a la base de datos------------
        $nombre = basename($_FILES['cal_gral']['name'][$i]);

        $url=basename($_FILES['cal_gral']['name'][$i]);

        //El query necesita ser un update ya que sólo se debe contar con 1 archivo del tipo 'calgeneral' y 'calsesiones'. (no son acumulables, son reemplazables)
        $query = mysqli_query($con, "UPDATE admin_files set name = '$nombre', url = '$url' WHERE type = '$tipo'");

        if (strlen($_FILES['cal_gral']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
          if (move_uploaded_file($_FILES['cal_gral']['tmp_name'][$i], $target_path.$name)) {

          }else{echo "Error, no se han subido los archivos";}
        }
      }

    }
    if($tipo == 'calsesiones'){

        //----------Subir cada uno de los archivos a la carpeta del servidor
        foreach ($_FILES['cal_ses']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
          //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

          //----------- Subir la info de cada archivo a la base de datos------------
          $nombre = basename($_FILES['cal_ses']['name'][$i]);

          $url=basename($_FILES['cal_ses']['name'][$i]);

          $query = mysqli_query($con, "UPDATE admin_files set name= '$nombre', url = '$url' WHERE type = '$tipo'");

          if (strlen($_FILES['cal_ses']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
            if (move_uploaded_file($_FILES['cal_ses']['tmp_name'][$i], $target_path.$name)) {

            }else{echo "Error, no se han subido los archivos";}
          }
        }
    }
  }

  function registrarRegGral(){
    include "conexion.php";


    $nombre = $_POST["nameNormGral"];
    $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

    //----------Subir cada uno de los archivos a la carpeta del servidor
    foreach ($_FILES['reg_gral']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      //  $nombre = basename($_FILES['reg_gral']['name'][$i]);

      $url=basename($_FILES['reg_gral']['name'][$i]);

      //El query necesita ser un update ya que sólo se debe contar con 1 archivo del tipo 'calgeneral' y 'calsesiones'. (no son acumulables, son reemplazables)
      $query = mysqli_query($con, "INSERT INTO normatividad (nombre, url, tipo) VALUES ('$nombre','$url','G')"); //Tipo G = General

      if (strlen($_FILES['reg_gral']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['reg_gral']['tmp_name'][$i], $target_path.$name)) {

        }else{echo "Error, no se han subido los archivos";}
      }
    }

  }

  function registrarRegCT(){
    include "conexion.php";

    $nombre = $_POST["nameNormCT"];
    $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos
    $fechareg = $_POST["fechaReg"];

    //----------Subir cada uno de los archivos a la carpeta del servidor
    foreach ($_FILES['reg_ct']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      //$nombre = basename($_FILES['reg_gral']['name'][$i]);

      $url=basename($_FILES['reg_ct']['name'][$i]);

      //El query necesita ser un update ya que sólo se debe contar con 1 archivo del tipo 'calgeneral' y 'calsesiones'. (no son acumulables, son reemplazables)
      $query = mysqli_query($con, "INSERT INTO normatividad (nombre, url, tipo, fecha) VALUES ('$nombre','$url','C', '$fechareg')"); //Tipo C = Consejo

      if (strlen($_FILES['reg_ct']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['reg_ct']['tmp_name'][$i], $target_path.$name)) {

        }else{echo "Error, no se han subido los archivos";}
      }
    }
  }

    function deleteReg(){
      include "conexion.php";

      $id_reg = $_POST['id'];

      $query = mysqli_query($con, "DELETE FROM normatividad WHERE id='$id_reg'");

      if(!$query){
        echo 'Error al eliminar el reglamento';
      }

    }


  function registrarComiteA(){
    include "conexion.php";


    $nombre = $_POST["nameNomrA"];
    $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

    //----------Subir cada uno de los archivos a la carpeta del servidor
    foreach ($_FILES['reg_a']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      //  $nombre = basename($_FILES['reg_a']['name'][$i]);

      $url=basename($_FILES['reg_a']['name'][$i]);

      //El query necesita ser un update ya que sólo se debe contar con 1 archivo del tipo 'calgeneral' y 'calsesiones'. (no son acumulables, son reemplazables)
      $query = mysqli_query($con, "INSERT INTO comites (nombre, url, tipo) VALUES ('$nombre','$url','A')"); //Tipo A = Académico

      if (strlen($_FILES['reg_a']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['reg_a']['tmp_name'][$i], $target_path.$name)) {

        }else{echo "Error, no se han subido los archivos";}
      }
    }

  }

  function registrarComiteO(){
    include "conexion.php";


    $nombre = $_POST["nameNomrO"];
    $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

    //----------Subir cada uno de los archivos a la carpeta del servidor
    foreach ($_FILES['reg_o']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      //  $nombre = basename($_FILES['reg_a']['name'][$i]);

      $url=basename($_FILES['reg_o']['name'][$i]);

      //El query necesita ser un update ya que sólo se debe contar con 1 archivo del tipo 'calgeneral' y 'calsesiones'. (no son acumulables, son reemplazables)
      $query = mysqli_query($con, "INSERT INTO comites (nombre, url, tipo) VALUES ('$nombre','$url','O')"); //Tipo O = Otros

      if (strlen($_FILES['reg_o']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['reg_o']['tmp_name'][$i], $target_path.$name)) {

        }else{echo "Error, no se han subido los archivos";}
      }
    }

  }


  function registrarComiteP(){
    include "conexion.php";


    $nombre = $_POST["nameNomrP"];
    $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

    //----------Subir cada uno de los archivos a la carpeta del servidor
    foreach ($_FILES['reg_P']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      //  $nombre = basename($_FILES['reg_a']['name'][$i]);

      $url=basename($_FILES['reg_P']['name'][$i]);

      //El query necesita ser un update ya que sólo se debe contar con 1 archivo del tipo 'calgeneral' y 'calsesiones'. (no son acumulables, son reemplazables)
      $query = mysqli_query($con, "INSERT INTO comites (nombre, url, tipo) VALUES ('$nombre','$url','P')"); //Tipo A = Académico

      if (strlen($_FILES['reg_P']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['reg_P']['tmp_name'][$i], $target_path.$name)) {

        }else{echo "Error, no se han subido los archivos";}
      }
    }

  }


 function deleteCom(){
      include "conexion.php";

      $id_com = $_POST['id'];

      $query = mysqli_query($con, "DELETE FROM comites WHERE id='$id_com'");

      if(!$query){
        echo 'Error al eliminar el comité';
      }

    }



  function registrarComisionD(){
    include "conexion.php";


    $nombre = $_POST["nameNomrD"];
    $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

    //----------Subir cada uno de los archivos a la carpeta del servidor
    foreach ($_FILES['reg_d']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      //  $nombre = basename($_FILES['reg_a']['name'][$i]);

      $url=basename($_FILES['reg_d']['name'][$i]);

      //El query necesita ser un update ya que sólo se debe contar con 1 archivo del tipo 'calgeneral' y 'calsesiones'. (no son acumulables, son reemplazables)
      $query = mysqli_query($con, "INSERT INTO comisiones (nombre, url, tipo) VALUES ('$nombre','$url','D')"); //Tipo D = Dictaminadoras

      if (strlen($_FILES['reg_d']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['reg_d']['tmp_name'][$i], $target_path.$name)) {

        }else{echo "Error, no se han subido los archivos";}
      }
    }

  }

  function registrarComisionE(){
    include "conexion.php";


    $nombre = $_POST["nameNomrE"];
    $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos

    //----------Subir cada uno de los archivos a la carpeta del servidor
    foreach ($_FILES['reg_e']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
      //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

      //----------- Subir la info de cada archivo a la base de datos------------
      //  $nombre = basename($_FILES['reg_a']['name'][$i]);

      $url=basename($_FILES['reg_e']['name'][$i]);

      //El query necesita ser un update ya que sólo se debe contar con 1 archivo del tipo 'calgeneral' y 'calsesiones'. (no son acumulables, son reemplazables)
      $query = mysqli_query($con, "INSERT INTO comisiones (nombre, url, tipo) VALUES ('$nombre','$url','E')"); //Tipo E = Evaluadoras

      if (strlen($_FILES['reg_e']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
        if (move_uploaded_file($_FILES['reg_e']['tmp_name'][$i], $target_path.$name)) {

        }else{echo "Error, no se han subido los archivos";}
      }
    }

  }

 function deleteComision(){
      include "conexion.php";

      $id_comi = $_POST['id'];

      $query = mysqli_query($con, "DELETE FROM comisiones WHERE id='$id_comi'");

      if(!$query){
        echo 'Error al eliminar el comité';
      }

    }


function editComision(){
  include "conexion.php";

    $id = $_POST["id"];
    $nombre = $_POST["nameNomr"];
    $tipo = $_POST["tipo"];
    $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos
    $fichero="".basename($_FILES['reg']['name'][0]);
    if($fichero =! ""){
            //----------Subir cada uno de los archivos a la carpeta del servidor
      foreach ($_FILES['reg']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
        //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

        //----------- Subir la info de cada archivo a la base de datos------------
        //  $nombre = basename($_FILES['reg_a']['name'][$i]);

        $url=basename($_FILES['reg']['name'][$i]);

        //El query necesita ser un update ya que sólo se debe contar con 1 archivo del tipo 'calgeneral' y 'calsesiones'. (no son acumulables, son reemplazables)
        $query = mysqli_query($con, "UPDATE comisiones SET nombre='$nombre', url = '$url', tipo = '$tipo' WHERE id = '$id' "); //Tipo D = Dictaminadoras

        if (strlen($_FILES['reg']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
          if (move_uploaded_file($_FILES['reg']['tmp_name'][$i], $target_path.$name)) {

          }else{echo "Error, no se han subido los archivos";}
        }
      }

    }else{
      $query = mysqli_query($con, "UPDATE comisiones SET nombre='$nombre', tipo = '$tipo' WHERE id = '$id' ");
      if(!$query){
        die('Error al modificar la comision:');
      }
      else{
        echo 'Comisión modificada correctamente';
      }
    }
}


function editComite(){
  include "conexion.php";

    $id = $_POST["id"];
    $nombre = $_POST["nameNomr"];
    $tipo = $_POST["tipo"];
    $target_path = "../conexiones/uploads/"; // carpeta donde se guardarán los archivos
    $fichero="".basename($_FILES['reg']['name'][0]);
    if($fichero =! ""){
            //----------Subir cada uno de los archivos a la carpeta del servidor
      foreach ($_FILES['reg']['name'] as $i => $name) { //Evita el uso del array y garantiza su ejecución
        //mientras haya un uno o más archivos en el array y obtiene el nombre del archivo en la posición $i del array.

        //----------- Subir la info de cada archivo a la base de datos------------
        //  $nombre = basename($_FILES['reg_a']['name'][$i]);

        $url=basename($_FILES['reg']['name'][$i]);

        //El query necesita ser un update ya que sólo se debe contar con 1 archivo del tipo 'calgeneral' y 'calsesiones'. (no son acumulables, son reemplazables)
        $query = mysqli_query($con, "UPDATE comites SET nombre='$nombre', url = '$url', tipo = '$tipo' WHERE id = '$id' "); //Tipo D = Dictaminadoras

        if (strlen($_FILES['reg']['name'][$i]) > 1) { //Garantiza que la cant de caracteres del nombre sea mayor a 1 (No es esencial).
          if (move_uploaded_file($_FILES['reg']['tmp_name'][$i], $target_path.$name)) {

          }else{echo "Error, no se han subido los archivos";}
        }
      }

    }else{
      $query = mysqli_query($con, "UPDATE comites SET nombre='$nombre', tipo = '$tipo' WHERE id = '$id' ");
      if(!$query){
        die('Error al modificar comité:');
      }
      else{
        echo 'Comité modificado correctamente';
      }
    }
}

 ?>
