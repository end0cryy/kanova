<?php
include "config/conexion.php";

session_start();
$error = '';

if (!empty($_POST["login"])){
    if (empty($_POST["usuario"]) || empty($_POST["contrasena"])){
        $error = '<div class="mensaje-error">Por favor, llene todos los campos.</div>';
    } else {
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];

        $stmt = $conn -> prepare("SELECT * FROM admins WHERE usuario = ?");
        $stmt -> bind_param("s", $usuario);
        $stmt -> execute();

        $resultado = $stmt -> get_result();
        $admin = $resultado -> fetch_assoc();

        if ($resultado -> num_rows == 1) {
            if ($admin["contrasena"] == $contrasena) {
                $_SESSION["usuario"] = $admin["usuario"];
                header("Location: dashboard.php");
            } else {
                $error = '<div class="mensaje-error">Usuario o contraseña incorrectos.</div>';
            }
            
        } else {
            $error = '<div class="mensaje-error">Usuario o contraseña incorrectos.</div>';
        }
    }
}

?>