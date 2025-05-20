<?php 
include("admin/config/conexion.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="resources/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/catalogo.css">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Silkscreen:wght@400;700&display=swap" rel="stylesheet">
    <title>Catálogo | KÁNOVA CLOTHING</title>
</head>

<body>
    <header class="custom-header">
    <div class="header-container">
        <div class="logo">
        <img src="resources/logo.png" alt="Logo" class="logo-img">
        </div>

        <nav class="nav-links">
        <a href="index.html#inicio" class="nav-link">Inicio</a>
        <a href="index.html#nosotros" class="nav-link">Nosotros</a>
        <a href="catalogo.php" class="nav-link">Catálogo</a>
        </nav>

        <div class="contact-button">
        <a href="https://api.whatsapp.com/send/?phone=573016573867&text=Hola%2C+me+gustaría+obtener+más+información+de+las+prendas&type=phone_number&app_absent=0" class="btn-contact">Contáctanos</a>
        </div>
    </div>
    </header>

    <main>

        <h1 class="titulo" id="titulo">Todos los productos</h1>

                <div class="buttons-container">
            <div class="categorias">
                <button data-categoria="Todos">Todos</button>
                <button data-categoria="Camisetas">Camisetas</button>
                <button data-categoria="Pantalones">Pantalones</button>
                <button data-categoria="Buzos">Buzos</button>
                <button data-categoria="Chaquetas">Chaquetas</button>
                <button data-categoria="Accesorios">Accesorios</button>
                <button class="carrito-btn"><i class="fas fa-cart-shopping"></i> Carrito</button>
            </div>            
        </div>

        <div class="productos-container">
        <?php
        $sql = "SELECT productos.*, categorias.nombre AS categoria 
                FROM productos 
                INNER JOIN categorias ON productos.idCategoria = categorias.id";

        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            while($producto = $resultado->fetch_assoc()) {
                echo '<div class="tarjeta-producto" data-categoria="' . $producto["categoria"] . '">';
                echo '<div class="producto-img">';
                echo '    <img class="imagen1" src="resources/productos/' . $producto["imagen"] . '" alt="">';
                echo '    <img class="imagen2" src="resources/productos/' . $producto["imagen2"] . '" alt="">';
                echo '</div>';
                echo '  <div class="producto-info">';
                echo '      <h2>$' . number_format($producto["precio"], 0, ',', '.') . '</h2>';
                echo '      <button class="btn-carrito"><i class="fas fa-cart-plus"></i></button>';
                echo '  </div>';
                echo '</div>';
            }
        } else {
            echo "<h2>No hay productos disponibles.</h2>";
        }

        $conn->close();
        ?>

        </div>
    </main>

    <aside class="carrito">
        <div class="carrito-container">
            <div class="carrito-top">
                <i class="fas fa-x cerrar-carrito"></i>
                <h1 class="titulo-carrito">Carrito</h1>
            </div>
            <div class="carrito-vacio"><h2>Tu carrito está vacío. <i class="fas fa-face-frown"></i></h2></div>
            <div class="carrito-items">

            </div>
            
            <div class="carrito-opciones">
                <h2><strong>Total:</strong> $0</h2>
                <button id="btnHacerPedido">Hacer pedido</button>
            </div>

        </div>
    </aside>

    <script>
  document.addEventListener('DOMContentLoaded', function () {
    const botones = document.querySelectorAll('.btn-carrito');

    botones.forEach(boton => {
      boton.addEventListener('click', function () {
        const tarjeta = boton.closest('.tarjeta-producto');

        // Evita múltiples mensajes simultáneos en la misma tarjeta
        if (tarjeta.querySelector('.mensaje-carrito')) return;

        const mensaje = document.createElement('div');
        mensaje.textContent = 'Se ha añadido al carrito';
        mensaje.className = 'mensaje-carrito';

        // Insertar al final de la tarjeta
        tarjeta.appendChild(mensaje);

        // Añadir clase para desvanecer después de un momento
        setTimeout(() => {
          mensaje.classList.add('fade-out');
        }, 0); // empieza a desvanecer después de 1 segundo

        // Eliminar completamente después de la animación
        setTimeout(() => {
          mensaje.remove();
        }, 1000); // total 2 segundos
      });
    });
  });

        // Reproducir sonido al hacer clic en el logo
        const logo = document.querySelector('.logo-img');
        const clickSound = new Audio('resources/kirby.wav');

        logo.addEventListener('click', () => {
            clickSound.play();
        });
    </script>

    <footer class="custom-footer">
    <div class="footer-grid">
        <div class="footer-column">
        <h4>Contactos</h4>
        <p><i class="fas fa-envelope"></i> nexoragroupcontact@gmail.com</p>
        <p>
            <i class="fab fa-instagram"></i> 
            <a href="https://www.instagram.com/nexoragroup">@nexoragroup</a>
        </p>
        <p>
            <i class="fab fa-tiktok"></i> 
            <a href="https://www.tiktok.com/@nexoragroup">@nexoragroup</a>
        </p>
        <p><i class="fas fa-phone"></i> +57 301 6573867</p>
        </div>

        <div class="footer-column">
        <h4>Medios de pago</h4>
        <p><i class="fas fa-credit-card"></i> Nequi, Transfiya</p>
        <p>301 6573867</p>
        </div>

        <div class="footer-section nexora-group">
            <h3>
            <a href="admin/login.php">Copyright © 2025 Nexora Group</a>
            </h3>
            <div class="nexora-members">
                <div class="member">
                <p><strong>Front End:</strong></p>
                <a href="https://www.tiktok.com/@nexoragroup"><i class="fab fa-instagram"></i> end0cryy</a>
                <p>end0cryy@gmail.com</p>
                </div>
                <div class="member">
                <p><strong>Back End:</strong></p>
                <a href="https://www.tiktok.com/@nexoragroup"><i class="fab fa-instagram"></i> nikorasu985</a>
                <p>alvaradonicolas985@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
    </footer>

    <div id="mensaje-carrito" style="display: none; position: fixed; top: 20px; right: 20px; background-color: #4CAF50; color: white; padding: 10px 20px; border-radius: 5px; z-index: 1000;">
    Se ha añadido al carrito
    </div>


</body>
<script src="js/carrito.js"></script>
</html>