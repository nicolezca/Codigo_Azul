
//filtrado por nombre de sala y estado
document.addEventListener("DOMContentLoaded", function () {
    const filternameInput = document.getElementById("filter_name");
    const filterEstadoInput = document.getElementById("filter_estado");
    const aplicarFiltroButton = document.getElementById("aplicarFiltro");
    const tablaResultado = document.getElementById("Tabla").getElementsByTagName('tbody')[0];

    aplicarFiltroButton.addEventListener("click", function () {
        const estado = filterEstadoInput.value.toLowerCase();
        const nombre = filternameInput.value.toLowerCase();
        filtrarTabla(estado,nombre);
    });

    function filtrarTabla(estado, nombre) {
        const filas = tablaResultado.getElementsByTagName("tr");
        for (let i = 0; i < filas.length; i++) {
            const fila = filas[i];
            const columnas = fila.getElementsByTagName("td");
            const nombreColumna = columnas[1].textContent.toLowerCase(); // Columna del nombre
            const estadoColumna = columnas[6].textContent.toLowerCase(); // Columna de estado
            if ((estadoColumna.includes(estado) || estado === "") && (nombreColumna.includes(nombre) || nombre ==="") ) {
                fila.style.display = "table-row";
            } else {
                fila.style.display = "none";
            }
        }
    }
});
