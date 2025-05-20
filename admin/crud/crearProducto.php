<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

// Obtener las categorías desde la base de datos
$categorias = $conn->query("SELECT * FROM categorias");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto - Kánova</title>
    <link rel="icon" href="../../css/resources/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/crear-editar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
<div class="crear-container">
        <div class="volver-btn">
            <a href="../dashboard.php">← Volver al dashboard</a>
        </div>

        <div class="crear-titulo">
            <h1>Crear nuevo producto</h1>
        </div>
        
        <form action="guardarProducto.php" method="POST" enctype="multipart/form-data" class="crear-formulario">
            <div class="campo">
                <label for="imagen">Imagen 1:</label>
                <input type="file" name="imagen" id="imagen" required>
            </div>

            <div class="campo">
                <label for="imagen2">Imagen 2:</label>
                <input type="file" name="imagen2" id="imagen2" required>
            </div>

            <div class="campo">
                <label for="categoria">Categoría:</label>
                <select name="categoria" id="categoria" required>
                    <option value="">Selecciona una categoría</option>
                    <?php while($cat = $categorias->fetch_assoc()): ?>
                        <option value="<?= $cat['id'] ?>"><?= $cat['nombre'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="campo">
                <label for="precio">Precio:</label>
                <input type="number" name="precio" id="precio" min="0" required>
            </div>

            <div class="crear-btn">
                <input type="submit" value="Guardar producto">
            </div>
        </form>
    </div>
</body>
</html>
