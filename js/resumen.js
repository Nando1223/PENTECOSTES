
function actualizarContadores() {
    fetch('resumen_datos.php') // Llamamos a un archivo PHP pequeño
        .then(response => response.json())
        .then(data => {
            document.getElementById('registrados').innerText = data.total_registrados;
            document.getElementById('asistidos').innerText = data.total_asistidos;
        })
        .catch(error => {
            console.error('Error al actualizar:', error);
        });
}

// Actualizar cada 5 segundos
setInterval(actualizarContadores, 5000);

// Llamar una vez cuando carga la página
actualizarContadores();
