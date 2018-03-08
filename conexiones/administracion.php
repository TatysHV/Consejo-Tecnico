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
    <table border=1 color=grey id="Users" style="width: 800px;">
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

 ?>
