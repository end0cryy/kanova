const activo = document.querySelectorAll(".faq");
const pregunta = document.querySelectorAll(".pregunta");

pregunta.forEach((cadaPregunta, i) => {
    cadaPregunta.addEventListener("click", () => {
        activo.forEach((cadaActivo, j) => {
            if (i !== j) {
                cadaActivo.classList.remove("activo");
            }
        });
        activo[i].classList.toggle("activo");
    });
});