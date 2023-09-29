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
    const filterDniInput = document.getElementById("filter_dni");
    const filterEstadoSelect = document.getElementById("filter_estado");
    const aplicarFiltroButton = document.getElementById("aplicarFiltro");
    const tablaResultado = document.getElementById("Tabla").getElementsByTagName('tbody')[0];

    aplicarFiltroButton.addEventListener("click", function () {
        const dni = filterDniInput.value.toLowerCase();
        const estado = filterEstadoSelect.value.toLowerCase();

        filtrarTabla(dni, estado);
    });

    function filtrarTabla(dni, estado) {
        const filas = tablaResultado.getElementsByTagName("tr");

        for (let i = 0; i < filas.length; i++) {
            const fila = filas[i];
            const columnas = fila.getElementsByTagName("td");

            const dniColumna = columnas[3].textContent.toLowerCase(); // Columna de DNI
            const estadoColumna = columnas[7].textContent.toLowerCase(); // Columna de Estado

            if ((dniColumna.includes(dni) || dni === "") && (estadoColumna.includes(estado) || estado === "")) {
                fila.style.display = "table-row";
            } else {
                fila.style.display = "none";
            }
        }
    }
});
