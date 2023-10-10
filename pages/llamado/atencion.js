document.addEventListener("DOMContentLoaded", function () {

    //filtrado por DNI y ESTADO(alta,baja,espera)
    const filterEstadoInput = document.getElementById("filter_estado");
    const aplicarFiltroButton = document.getElementById("aplicarFiltro");
    const tablaResultado = document.getElementById("Tabla").getElementsByTagName('tbody')[0];

    aplicarFiltroButton.addEventListener("click", function () {
        const estado = filterEstadoInput.value.toLowerCase();
        filtrarTabla(estado);
    });

    function filtrarTabla( estado) {
        const filas = tablaResultado.getElementsByTagName("tr");
        for (let i = 0; i < filas.length; i++) {
            const fila = filas[i];
            const columnas = fila.getElementsByTagName("td");
            const estadoColumna = columnas[5].textContent.toLowerCase(); // Columna del estado
            if ((estadoColumna.includes(estado) || estado ==="") ) {
                fila.style.display = "table-row";
            } else {
                fila.style.display = "none";
            }
        }
    }
});
