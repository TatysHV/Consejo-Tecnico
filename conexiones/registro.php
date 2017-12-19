<?php

        $server="localhost";
        $username="tflores";
        $password="CT3cn1c06102";
        $db='consejo_tecnico';
        $con=@mysql_connect($server,$username,$password)or die("no se ha podido establecer la conexion");
        $sdb=@mysql_select_db($db,$con)or die("la base de datos no existe");

echo 'Conexion realizada';
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$pass = ($_POST['pass']);//sha1($_POST['pass']);
$direc = $_POST['direc'];
$curp = $_POST['curp'];
$rfc = $_POST['rfc'];

		$result =mysqli_query($conexion,"INSERT INTO usuarios (nombre, correo, pass, curp, rfc, direccion) values ('$nombre','$email','$pass','$curp','$rfc','$direc')");

			if (!$result) {
 				echo "An error occurred.";
  				exit;
			}
      else{
			echo $nombre;
      }
?>
