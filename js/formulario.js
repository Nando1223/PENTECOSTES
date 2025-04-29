


document.addEventListener('DOMContentLoaded', function () {

    const formulario = document.getElementById('formulario_asistente');

    formulario.addEventListener('submit', function (event) {

        event.preventDefault(); // Prevenir el submit normal

        // Validaciones: que todos los campos estén llenos
        const identificacion = document.getElementById('identificacion').value.trim();
        const nombres = document.getElementById('nombres').value.trim();
        const direccion = document.getElementById('direccion').value.trim();
        const celular = document.getElementById('celular').value.trim();
        const congregacion = document.getElementById('congregacion').value.trim();
        const cargo = document.querySelector('input[name="cargo"]:checked');

        if (nombres === '' || direccion === '' || celular === '' || congregacion === '' || !cargo || identificacion === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor, llena todos los campos antes de guardar.'
            });
            return;
        }

        // Confirmación antes de guardar
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas guardar este asistente?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(formulario);

                fetch('guardar_asistente.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                '¡Guardado!',
                                data.message,
                                'success'
                            ).then(() => {
                                window.location.href = 'qr_asistente.php?id=' + data.id; // Ir al QR directamente
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                data.message,
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error',
                            'Ocurrió un error al guardar.',
                            'error'
                        );
                        console.error('Error:', error);
                    });
            }
        });
    });
});

