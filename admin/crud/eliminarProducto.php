<?php
session_start();
include("../config/conexion.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Obtener las dos imágenes del producto para borrarlas del servidor
    $stmt = $conn->prepare("SELECT imagen, imagen2 FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $producto = $resultado->fetch_assoc();
        $imagen1 = $producto["imagen"];
        $imagen2 = $producto["imagen2"];
        $rutaImagen1 = "../../resources/productos/" . $imagen1;
        $rutaImagen2 = "../../resources/productos/" . $imagen2;

        // Eliminar el producto de la base de datos
        $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            // Eliminar la primera imagen si existe
            if (file_exists($rutaImagen1)) {
                unlink($rutaImagen1);
            }
            // Eliminar la segunda imagen si existe
            if (file_exists($rutaImagen2)) {
                unlink($rutaImagen2);
            }
            header("Location: ../dashboard.php?mensaje=eliminado");
            exit();
        } else {
            echo "Error al eliminar el producto.";
        }
    } else {
        echo "Producto no encontrado.";
    }
} else {
    echo "ID no especificado.";
}
?>
