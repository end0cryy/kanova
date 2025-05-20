<?php
session_start();
include("config/conexion.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

// Paginación
$por_pagina = 10;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $por_pagina;

// Búsqueda libre
$busqueda = isset($_GET['busqueda']) ? $conn->real_escape_string($_GET['busqueda']) : '';
$where = '';

if ($busqueda !== '') {
    $where = "WHERE 
        p.id LIKE '%$busqueda%' OR 
        c.nombre LIKE '%$busqueda%'";
}

// Contar total
$total_sql = "SELECT COUNT(*) as total
              FROM productos p
              INNER JOIN categorias c ON p.idCategoria = c.id
              $where";
$total_result = $conn->query($total_sql);
$total_filas = $total_result->fetch_assoc()['total'];
$total_paginas = ceil($total_filas / $por_pagina);

// Consulta con paginación
$sql = "SELECT p.id, p.imagen, c.nombre AS categoria, p.precio
        FROM productos p
        INNER JOIN categorias c ON p.idCategoria = c.id
        $where
        ORDER BY p.id DESC
        LIMIT $inicio, $por_pagina";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kánova</title>
    <link rel="icon" href="../resources/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="opciones">
        <div class="volver-btn">
            <a href="logout.php"><button>Cerrar sesión</button></a>
        </div>
        <h1 class="titulo">Catálogo de productos</h1>
        <div class="crear-btn">
            <a href="crud/crearProducto.php"><button>Crear producto</button></a>
        </div>
    </div>

    <div class="barra-busqueda">
        <form method="GET" class="busqueda-form">
            <input type="text" name="busqueda" placeholder="Buscar por ID o categoría" value="<?php echo htmlspecialchars($busqueda); ?>">
            <button type="submit">Buscar</button>
        </form>
    </div>

    <div class="tabla-contenedor">
        <table class="tabla-productos">
            <thead>
                <tr class="fila-tabla">
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultado->fetch_assoc()): ?>
                    <tr class="fila-tabla">
                        <td><?php echo $row['id']; ?></td>
                        <td><img src="../resources/productos/<?php echo $row['imagen']; ?>" alt="Producto" width="200px"></td>
                        <td><?php echo $row['categoria']; ?></td>
                        <td>$<?php echo number_format($row['precio'], 0, ',', '.'); ?></td>
                        <td class="acciones">
                            <a href="crud/editarProducto.php?id=<?php echo $row['id']; ?>" class="editar"><i class="fas fa-edit"></i>Editar</a>
                            <a href="crud/eliminarProducto.php?id=<?php echo $row['id']; ?>" class="eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')"><i class="fas fa-trash"></i>Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="paginacion">
        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <a href="?pagina=<?php echo $i; ?>&busqueda=<?php echo urlencode($busqueda); ?>" class="pagina <?php echo ($i == $pagina) ? 'activa' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>
</body>

</html>