<?php
session_start();

if($_SESSION){
  session_destroy();
  header('Location:/PSMYSQL/Poolshop/index.php');
}
else{
  header("location:login.php");
}
?>
