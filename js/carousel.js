let imagenes = [
    {
        "url" : "resources/img1.jpeg"
    },

    {
        "url" : "resources/img2.jpeg"    
    },
    
    {
        "url" : "resources/img3.jpg"
    },

    {
        "url" : "resources/img4.jpg"
    }
]

let atras = document.getElementById("atras");
let siguiente = document.getElementById("siguiente");
let imagen = document.getElementById("carousel-img");
let puntos = document.getElementById("puntos");

let actual = 0;

posicionCarousel()

atras.addEventListener("click", function () {
    cambiarImagen(-1);
});

siguiente.addEventListener("click", function () {
    cambiarImagen(1);
});

function cambiarImagen(direccion) {
    const imgTag = imagen.querySelector("img");
    imgTag.style.opacity = 0;

    setTimeout(() => {
        actual += direccion;

        if (actual < 0) actual = imagenes.length - 1;
        if (actual >= imagenes.length) actual = 0;

        imgTag.src = imagenes[actual].url;

        posicionCarousel();
        imgTag.style.opacity = 1;
    }, 300);
}

function posicionCarousel() {
    puntos.innerHTML = ""
    for (var i = 0; i <imagenes.length; i++){
        if (i == actual){
            puntos.innerHTML += '<p class="bold">•</p>'
        }
        else{
            puntos.innerHTML += '<p>•</p>'
        }
    }
}