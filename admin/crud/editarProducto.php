<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}
// Verifica si se pasó un ID por la URL
if (!isset($_GET['id'])) {
    die("ID de producto no especificado.");
}

$id = $_GET['id'];

// Consulta los datos actuales del producto
$stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$producto = $resultado->fetch_assoc();

if (!$producto) {
    die("Producto no encontrado.");
}

// Obtener categorías
$categorias = $conn->query("SELECT * FROM categorias");
?>

<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Kánova</title>
    <link rel="icon" href="../../resources/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/crear-editar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="crear-container">
        <div class="volver-btn">
            <a href="../dashboard.php">← Volver al dashboard</a>
        </div>

        <div class="crear-titulo">
            <h1>Editar producto</h1>
        </div>

        <form action="actualizarProducto.php" method="POST" enctype="multipart/form-data" class="crear-formulario">
            <input type="hidden" name="id" value="<?= $producto['id'] ?>">

            <div class="campo">
                <label>Imagen actual 1:</label><br>
                <img src="../../resources/productos/<?= $producto['imagen'] ?>" alt="Imagen del producto" class="imagen-preview">
            </div>

            <div class="campo">
                <label for="imagen">Nueva imagen 1 (opcional):</label>
                <input type="file" name="imagen" id="imagen">
            </div>

            <div class="campo">
                <label>Imagen actual 2:</label><br>
                <img src="../../resources/productos/<?= $producto['imagen2'] ?>" alt="Imagen 2 del producto" class="imagen-preview">
            </div>

            <div class="campo">
                <label for="imagen2">Nueva imagen 2 (opcional):</label>
                <input type="file" name="imagen2" id="imagen2">
            </div>

            <div class="campo">
                <label for="categoria">Categoría:</label>
                <select name="categoria" id="categoria" required>
                    <?php while ($cat = $categorias->fetch_assoc()): ?>
                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $producto['idCategoria'] ? 'selected' : '' ?>>
                            <?= $cat['nombre'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="campo">
                <label for="precio">Precio:</label>
                <input type="number" name="precio" id="precio" min="0" value="<?= $producto['precio'] ?>" required>
            </div>

            <div class="crear-btn">
                <input type="submit" value="Actualizar producto">
            </div>
        </form>
    </div>
</body>

</html>
