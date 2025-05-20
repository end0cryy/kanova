document.addEventListener("DOMContentLoaded", () => {
    const carritoBtn = document.querySelector(".carrito-btn");
    const carrito = document.querySelector(".carrito");
    const cerrarCarrito = document.querySelector(".cerrar-carrito");
    const tarjetas = document.querySelectorAll(".tarjeta-producto");
    const categoriasBtns = document.querySelectorAll("button[data-categoria]");
    const productosContainer = document.querySelector(".productos-container");
    const carritoItems = document.querySelector(".carrito-items");
    const carritoVacio = document.querySelector(".carrito-vacio");
    const carritoTotal = document.querySelector(".carrito-opciones h2");

    let carritoData = JSON.parse(localStorage.getItem("carritoData")) || [];

    carritoBtn.addEventListener("click", () => carrito.classList.add("active"));
    cerrarCarrito.addEventListener("click", () => carrito.classList.remove("active"));

    function guardarCarrito() {
        localStorage.setItem("carritoData", JSON.stringify(carritoData));
    }

    function renderizarCarrito() {
        carritoItems.innerHTML = "";

        if (carritoData.length === 0) {
            carritoVacio.style.display = "block";
            carritoTotal.textContent = `Total: $0`;
            localStorage.removeItem("carritoData");
            return;
        }

        carritoVacio.style.display = "none";

        let total = 0;

        carritoData.forEach((item, index) => {
            const tarjeta = document.createElement("div");
            tarjeta.classList.add("tarjeta-carrito");

            tarjeta.innerHTML = `
                <div class="producto-carrito-img">
                    <img src="${item.imagen}" alt="">
                </div>
                <div class="producto-carrito-info">
                    <div class="producto-carrito-categoria">
                        <h2>Categoría:</h2>
                        <p>${item.categoria}</p>
                    </div>
                    <div class="producto-carrito-precio">
                        <h2>Precio</h2>
                        <p>${item.precio}</p>
                    </div>
                    <div class="producto-carrito-cantidad">
                        <h2>Cantidad:</h2>
                        <div class="producto-carrito-cantidad-acciones">
                            <button data-index="${index}" class="btn-mas"><i class="fas fa-plus"></i></button>
                            <p>${item.cantidad}</p>
                            <button data-index="${index}" class="btn-menos"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="producto-carrito-eliminar">
                        <button data-index="${index}" class="btn-eliminar"><i class="fas fa-trash"></i> <span>Eliminar</span></button>
                    </div>
                </div>
            `;

            carritoItems.appendChild(tarjeta);

            total += parseInt(item.precio.replace(/\D/g, '')) * item.cantidad;
        });

        carritoTotal.textContent = `Total: $${total.toLocaleString()}`;
        guardarCarrito();

        document.querySelectorAll(".btn-mas").forEach(btn => {
            btn.addEventListener("click", () => {
                const index = parseInt(btn.dataset.index);
                carritoData[index].cantidad++;
                renderizarCarrito();
            });
        });

        document.querySelectorAll(".btn-menos").forEach(btn => {
            btn.addEventListener("click", () => {
                const index = parseInt(btn.dataset.index);
                if (carritoData[index].cantidad > 1) {
                    carritoData[index].cantidad--;
                }
                renderizarCarrito();
            });
        });

        document.querySelectorAll(".btn-eliminar").forEach(btn => {
            btn.addEventListener("click", () => {
                const index = parseInt(btn.dataset.index);
                carritoData.splice(index, 1);
                renderizarCarrito();
            });
        });
    }

    tarjetas.forEach(tarjeta => {
        const boton = tarjeta.querySelector("button");
        boton.addEventListener("click", (e) => {
            e.stopPropagation();

            const imagen = tarjeta.querySelector("img").src;
            const precio = tarjeta.querySelector("h2").textContent;
            const categoria = tarjeta.dataset.categoria;

            const existente = carritoData.find(item => item.imagen === imagen);

            if (existente) {
                existente.cantidad++;
            } else {
                carritoData.push({
                    imagen,
                    precio,
                    categoria,
                    cantidad: 1
                });
            }

            renderizarCarrito();
        });
    });

    const btnHacerPedido = document.getElementById("btnHacerPedido");

    btnHacerPedido.addEventListener("click", () => {
        if (carritoData.length === 0) {
            alert("Tu carrito está vacío.");
            return;
        }
        
        let mensaje = "¡Hola! Me gustaría hacer el siguiente pedido:\n\n";

        carritoData.forEach((item, i) => {
            mensaje += `*Producto ${i + 1}*\n`;
            mensaje += `*Imagen:* ${item.imagen}\n\n`;
            mensaje += `*Categoría:* ${item.categoria}\n`;
            mensaje += `*Precio:* ${item.precio}\n`;
            mensaje += `*Cantidad:* ${item.cantidad}\n\n`;
        });

        const total = carritoData.reduce((acc, item) => {
            return acc + parseInt(item.precio.replace(/\D/g, '')) * item.cantidad;
        }, 0);

        mensaje += `-- *Total:* $${total.toLocaleString()} --`

        const numero = "573016573867";
        const url = `https://wa.me/${numero}?text=${encodeURIComponent(mensaje)}`;

        window.open(url, "_blank");
    });

    categoriasBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            const categoria = btn.dataset.categoria;
            const titulo = document.getElementById("titulo");
            titulo.textContent = categoria === "Todos" ? "Todos los productos" : categoria;

            tarjetas.forEach(tarjeta => {
                tarjeta.style.display =
                    categoria === "Todos" || tarjeta.dataset.categoria === categoria
                        ? "block"
                        : "none";
            });
        });
    });

    // Mostrar carrito si ya había productos guardados
    renderizarCarrito();
});
