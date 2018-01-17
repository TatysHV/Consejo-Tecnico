<?php
	$server="localhost";
	$username="tflores";
	$password="CT3cn1c06102";
	$db='consejo_tecnico';
	$con=@mysql_connect($server,$username,$password)or die("no se ha podido establecer la conexion");
	$sdb=@mysql_select_db($con,$db)or die("la base de datos no existe");

	/*---------------PERMITE UTILIZAR ACENTOS ---------------*/
	//$acentos = $con->query("SET NAMES 'utf-8'");
	/*------------------------------------------------------*/

?>
