
document.addEventListener("DOMContentLoaded", function () {
    //filtrado por DNI
    const filterDniInput = document.getElementById("filter_dni");
    const aplicarFiltroButton = document.getElementById("aplicarFiltro");
    const tablaResultado = document.getElementById("Tabla").getElementsByTagName('tbody')[0];

    aplicarFiltroButton.addEventListener("click", function () {
        const dni = filterDniInput.value.toLowerCase();
        filtrarTabla(dni);
    });

    function filtrarTabla(dni) {
        const filas = tablaResultado.getElementsByTagName("tr");
        for (let i = 0; i < filas.length; i++) {
            const fila = filas[i];
            const columnas = fila.getElementsByTagName("td");
            const dniColumna = columnas[3   ].textContent.toLowerCase(); // Columna de DNI
            if ((dniColumna.includes(dni) || dni === "") ) {
                fila.style.display = "table-row";
            } else {
                fila.style.display = "none";
            }
        }
    }
});
