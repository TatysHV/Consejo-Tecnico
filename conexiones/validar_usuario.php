<?php

//AQUI CONECTAMOS A LA BASE DE DATOS DE POSTGRES
include "conexion.php";
session_start();

$conexion = mysqli_connect($server, $username, $password)or die("Error en el servidor:". mysqli_connect_error());

if(trim($_POST['user']) != "" && trim($_POST['pwd']) != ""){

  if (!mysqli_select_db($conexion, $db))
  {
    echo "<h2>Error al seleccionar la base de datos!!!";
    	echo '<script> window.location="http://localhost/SHCT/index.php"</script>';
	exit;
  }

     // Puedes utilizar la funcion para eliminar algun caracter en especifico
     //$usuario = strtolower(quitar($HTTP_POST_VARS["usuario"]));
     //$password = $HTTP_POST_VARS["password"];
     // o puedes convertir los a su entidad HTML aplicable con htmlentities
     //htmlentities($_POST['correo'], ENT_QUOTES);
     $user = $_POST['user'];
     $passwd =($_POST['pwd']);//sha1($_POST['pass']);

     $sql = "SELECT usuario, password, tipo FROM users WHERE usuario='$user' and password=SHA1('$passwd')";

     $result=mysqli_query($conexion, $sql) or die("Error en la consulta: ".mysqli_error($conexion));
     //echo $result;
     $tuplas = mysqli_num_rows($result);
     if($tuplas != null) {
        $row = mysqli_fetch_array($result);
        //Creación de variables de sesión
        $_SESSION['usuario'] = $row['usuario'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['tipo'] = $row['tipo'];
	      mysqli_close($conexion);

        header("Location:../../consejo_tecnico/portal.php");
       //Elimina el siguiente comentario si quieres que re-dirigir automáticamente a index.php
       /*Ingreso exitoso, ahora sera dirigido a la pagina principal.
       <SCRIPT LANGUAGE="javascript">
       location.href = "index.php";
       </SCRIPT>*/

     }else{
	mysqli_close($conexion);
      echo '<script> alert("Usuario o contraseña incorrectos");</script>';
      echo '<script> window.location="../../consejo_tecnico/index.php"</script>';
      /*header("Location: /servidor/index.html");*/
     }
     mysqli_free_result($result);
    /*}else{
	mysqli_close($conexion);
      echo '<script> alert("Debe especificar un usuario y password");</script>';
      echo '<script> window.location="../2016/consejo_tecnico/index.php"</script>';
     header("Location: /servidor/index.html");
   }*/
}
?>
