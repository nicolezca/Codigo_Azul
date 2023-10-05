
//filtrado por DNI
document.addEventListener("DOMContentLoaded", function () {
    const filterDniInput = document.getElementById("filter_dni");
    const filternameInput = document.getElementById("filter_name");
    const aplicarFiltroButton = document.getElementById("aplicarFiltro");
    const tablaResultado = document.getElementById("Tabla").getElementsByTagName('tbody')[0];

    aplicarFiltroButton.addEventListener("click", function () {
        const dni = filterDniInput.value.toLowerCase();
        const nombre = filternameInput.value.toLowerCase();
        filtrarTabla(dni,nombre);
    });

    function filtrarTabla(dni, nombre) {
        const filas = tablaResultado.getElementsByTagName("tr");
        for (let i = 0; i < filas.length; i++) {
            const fila = filas[i];
            const columnas = fila.getElementsByTagName("td");
            const dniColumna = columnas[3].textContent.toLowerCase(); // Columna de DNI
            const nombreColumna = columnas[1].textContent.toLowerCase(); // Columna del nombre
            if ((dniColumna.includes(dni) || dni === "") && (nombreColumna.includes(nombre) || nombre ==="") ) {
                fila.style.display = "table-row";
            } else {
                fila.style.display = "none";
            }
        }
    }
});
