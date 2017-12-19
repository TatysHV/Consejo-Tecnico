<?php
	$server="localhost";
	$username="root";
	$password="";
	$db='consejo_tecnico';
	$con=@mysqli_connect($server,$username,$password)or die("no se ha podido establecer la conexion");
	$sdb=@mysqli_select_db($con,$db)or die("la base de datos no existe");

	/*------------ PERMITE UTILIZAR ACENTOS ---------- */
	  $acentos = $con->query("SET NAMES 'utf8'");
	/*-------------------------------------------------*/
?>
