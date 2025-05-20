<?php
include("../config/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];

    // Guardar primera imagen
    $nombreImagen1 = $_FILES['imagen']['name'];
    $tmp1 = $_FILES['imagen']['tmp_name'];
    $ruta1 = "../../resources/productos/" . basename($nombreImagen1);

    // Guardar segunda imagen
    $nombreImagen2 = $_FILES['imagen2']['name'];
    $tmp2 = $_FILES['imagen2']['tmp_name'];
    $ruta2 = "../../resources/productos/" . basename($nombreImagen2);

    // Subir ambas imágenes
    $subioImagen1 = move_uploaded_file($tmp1, $ruta1);
    $subioImagen2 = move_uploaded_file($tmp2, $ruta2);

    if ($subioImagen1 && $subioImagen2) {
        // Insertar en la base de datos ambas imágenes
        $stmt = $conn->prepare("INSERT INTO productos (imagen, imagen2, idCategoria, precio) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $nombreImagen1, $nombreImagen2, $categoria, $precio);

        if ($stmt->execute()) {
            echo "Producto guardado correctamente. <a href='../dashboard.php'>Volver al dashboard</a>";
        } else {
            echo "Error al guardar producto.";
        }
    } else {
        echo "Error al subir las imágenes.";
    }
}
?>
