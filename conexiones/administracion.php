<?php
  include "conexion.php";

  $funcion = $_POST['funcion'];

  switch ($funcion) {
      case 0: //Registrar nuevo usuario
        RegistrarUsuario();
      break;

      case 1:
      break;

      case 2:
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

 ?>
