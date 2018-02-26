<?php
	session_start();
	session_destroy();
	echo '<script> alert("Cerrando sesion");</script>';
    echo '<script> window.location="../../consejo_tecnico/index.php"</script>';
?>
