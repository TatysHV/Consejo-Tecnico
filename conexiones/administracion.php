<?php

// Motrar todos los errores de PHP
error_reporting(E_ALL);

  include "conexion.php";

  $funcion = $_POST['funcion'];

  switch ($funcion) {
      case 0: //Registrar nuevo usuario
        RegistrarUsuario();
      break;

      case 1:
        ShowEditUser();
      break;

      case 2:
        editUser();
      break;

      case 3:
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

 ?>
