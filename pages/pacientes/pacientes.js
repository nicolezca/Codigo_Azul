
document.addEventListener("DOMContentLoaded", function () {
    const btnform = document.getElementById("mostrarFormulario");
    const formulario = document.getElementById("formDoc");

    // Establece un valor predeterminado para el estilo transform
    formulario.style.transform = "translateX(-100%)";
    
    btnform.addEventListener("click", function () {
        if (formulario.style.transform === "translateX(-100%)") {
            formulario.style.transform = "translateX(0)";
        } else {
            formulario.style.transform = "translateX(-100%)";
        }
    });

    
    
    //filtrado por DNI y NOMBRE
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
