<?php
include("../config/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];

    // Obtener las imágenes anteriores
    $stmt = $conn->prepare("SELECT imagen, imagen2 FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $producto = $resultado->fetch_assoc();

    $nombreImagen1 = $producto['imagen'];  // Imagen 1 actual por defecto
    $nombreImagen2 = $producto['imagen2']; // Imagen 2 actual por defecto

    // Procesar imagen 1 (si se sube una nueva)
    if (!empty($_FILES['imagen']['name'])) {
        $nuevaImagen1 = $_FILES['imagen']['name'];
        $tmp1 = $_FILES['imagen']['tmp_name'];
        $ruta1 = "../../resources/productos/" . basename($nuevaImagen1);

        if (move_uploaded_file($tmp1, $ruta1)) {
            // Borrar imagen anterior 1
            $anteriorRuta1 = "../../resources/productos/" . $nombreImagen1;
            if (file_exists($anteriorRuta1)) {
                unlink($anteriorRuta1);
            }
            $nombreImagen1 = $nuevaImagen1;
        } else {
            echo "Error al subir la nueva imagen 1.";
            exit;
        }
    }

    // Procesar imagen 2 (si se sube una nueva)
    if (!empty($_FILES['imagen2']['name'])) {
        $nuevaImagen2 = $_FILES['imagen2']['name'];
        $tmp2 = $_FILES['imagen2']['tmp_name'];
        $ruta2 = "../../resources/productos/" . basename($nuevaImagen2);

        if (move_uploaded_file($tmp2, $ruta2)) {
            // Borrar imagen anterior 2
            $anteriorRuta2 = "../../resources/productos/" . $nombreImagen2;
            if (file_exists($anteriorRuta2)) {
                unlink($anteriorRuta2);
            }
            $nombreImagen2 = $nuevaImagen2;
        } else {
            echo "Error al subir la nueva imagen 2.";
            exit;
        }
    }

    // Actualizar en la base de datos
    $stmt = $conn->prepare("UPDATE productos SET imagen = ?, imagen2 = ?, idCategoria = ?, precio = ? WHERE id = ?");
    $stmt->bind_param("ssidi", $nombreImagen1, $nombreImagen2, $categoria, $precio, $id);

    if ($stmt->execute()) {
        echo "Producto actualizado correctamente. <a href='../dashboard.php'>Volver al dashboard</a>";
    } else {
        echo "Error al actualizar producto.";
    }
}
?>
