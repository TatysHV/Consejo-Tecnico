<?php
    session_start();
    include "conexiones/conexion.php";
    if(isset($_SESSION['usuario'])){
        echo '<script> window.location="/2016/consejo_tecnico/portal.php"</script>';
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="imagenes/logoUnam.jpg"/>

    <title>H. Consejo Técnico</title>

    <!-- Bootstrap Core CSS -->
    <link href="Bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="style.css"/>

    <!-- Theme CSS -->
    <link href="css/clean-blog.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    
    <div id="contenedor">

        <div id="cabecera">
            <div id="nombre">
                <img src="imagenes/logo-shct.png" style="display: inline-block;">           
            </div>
        </div>
        
        
        <div id="principal">
      
            <!-- Main Content -->
            <div class="contenedor">
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-md-offset-4">
                        <h1 class="text-center login-title">Acceso al Sitio</h1>
                        <div class="account-wall">
                            <center>
                                <img class="profile-img" src="imagenes/perfil.png" alt="">
                            </center>
                            <form class="form-signin" method="post" action="conexiones/validar_usuario.php">
                                <input type="text" class="form-control" placeholder="Usuario" id="user" name="user" required autofocus>
                                <input type="password" class="form-control" placeholder="Password" id="pwd" name="pwd" required>
                                <button class="btn btn-lg btn-primary btn-block" type="submit">
                                    Sign in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer>
                <hr>
                <div class="contenedor">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                            <p class="copyright text-muted">Copyright &copy; Israel Calderon 2016</p>
                            <p class="copyright text-muted">H. Consejo Técnico ENES Morelia</p>
                        </div>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/clean-blog.min.js"></script>

</body>

</html>
