const btnform = document.getElementById("mostrarFormulario");
const formulario = document.getElementById("formDoc");

btnform.addEventListener("click", function () {
    if (formulario.style.transform === "translateX(-1000px)") {
        formulario.style.transform = "translateX(0)";
    } else {
        formulario.style.transform = "translateX(-1000px)";
    }
});


document.addEventListener("DOMContentLoaded", function () {
    const filterInput = document.getElementById("filter");
    const tabla = document.getElementById("Tabla");
    const filas = tabla.getElementsByTagName("tr");

    filterInput.addEventListener("input", function () {
        const filtro = this.value.toLowerCase();

        for (let i = 1; i < filas.length; i++) {
            const celdas = filas[i].getElementsByTagName("td");
            let coincide = false;

            for (let j = 0; j < celdas.length; j++) {
                const textoCelda = celdas[j].textContent.toLowerCase();

                if (textoCelda.includes(filtro)) {
                    coincide = true;
                    break;
                }
            }

            if (coincide) {
                filas[i].style.display = "";
            } else {
                filas[i].style.display = "none";
            }
        }
    });
});