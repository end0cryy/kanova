<?php
include("config/conexion.php");
include("verificarLogin.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard</title>
    <link rel="icon" href="../resources/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="login-container">
        <div class="tituloLogin">
            <h1>Iniciar sesión</h1>
        </div>
        <form action="login.php" method="POST">
            <?php
                echo $error;
            ?>
            
            <div class="user">
                <h2>Usuario <i class="fas fa-user"></i></h2>
                <input type="text" name="usuario" id="usuario" placeholder="Ingrese su usuario.">
            </div>
            <div class="password">
                <h2>Contraseña <i class="fas fa-key"></i></h2>
                <input type="password" name="contrasena" id="contrasena" placeholder="Ingrese su contraseña.">
            </div>
            <div class="login-btn">
                <input type="submit" name="login" value="Iniciar Sesión">
            </div>
        </form>
    </div>
</body>

</html>