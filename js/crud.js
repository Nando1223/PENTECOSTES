
// Cargar asistentes al cargar la página
window.onload = () => cargarAsistentes();

function cargarAsistentes() {
    // Mostrar loading
    document.getElementById('loading').style.display = 'block';

    fetch('crud_listar.php')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('tablaAsistentes');
            tbody.innerHTML = '';
            data.forEach(asistente => {
                tbody.innerHTML += `
        <tr>
            <td>${asistente.ID}</td>
            <td>${asistente.Identificacion}</td>
            <td>${asistente.Nombres}</td>
            <td>${asistente.Direccion}</td>
            <td>${asistente.Celular}</td>
            <td>${asistente.Congregacion}</td>
            <td>${asistente.Cargo}</td>
            <td>
                <button class="btn btn-sm btn-warning" onclick='editar(${JSON.stringify(asistente)})' title="Editar">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
            </td>
            <td>
                <button class="btn btn-sm btn-danger" onclick="eliminar('${asistente.ID}')" title="Eliminar">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>
    `;
            });

            // Ocultar loading
            document.getElementById('loading').style.display = 'none';
        })
        .catch(error => {
            console.error('Error al cargar los datos:', error);
            document.getElementById('loading').innerHTML = '<p class="text-danger">Error al cargar los datos.</p>';
        });
}


function editar(asistente) {
    document.getElementById('editId').value = asistente.ID;
    document.getElementById('editIdentificacion').value = asistente.Identificacion;
    document.getElementById('editNombres').value = asistente.Nombres;
    document.getElementById('editDireccion').value = asistente.Direccion;
    document.getElementById('editCelular').value = asistente.Celular;
    document.getElementById('editCongregacion').value = asistente.Congregacion;
    document.getElementById('editCargo').value = asistente.Cargo;
    new bootstrap.Modal(document.getElementById('modalEditar')).show();
}

function guardarCambios() {
    const formData = new FormData();
    formData.append('ID', document.getElementById('editId').value);
    formData.append('Identificacion', document.getElementById('editIdentificacion').value);
    formData.append('Nombres', document.getElementById('editNombres').value);
    formData.append('Direccion', document.getElementById('editDireccion').value);
    formData.append('Celular', document.getElementById('editCelular').value);
    formData.append('Congregacion', document.getElementById('editCongregacion').value);
    formData.append('Cargo', document.getElementById('editCargo').value);

    fetch('crud_editar.php', {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Guardado', data.message, 'success');
                cargarAsistentes();
                bootstrap.Modal.getInstance(document.getElementById('modalEditar')).hide();
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        });
}

function eliminar(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(result => {
        if (result.isConfirmed) {
            fetch('crud_eliminar.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'ID=' + id
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Eliminado', data.message, 'success');
                        cargarAsistentes();
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                });
        }
    });
}

function eliminar(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Este asistente será eliminado permanentemente.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('crud_eliminar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'ID=' + encodeURIComponent(id)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Eliminado', data.message, 'success');
                        cargarAsistentes(); // Recarga la tabla
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'No se pudo eliminar', 'error');
                    console.error(error);
                });
        }
    });
}

document.getElementById('buscador').addEventListener('input', function () {
    const filtro = this.value.toLowerCase();
    const filas = document.querySelectorAll('#tablaAsistentes tr');

    filas.forEach(fila => {
        const textoFila = fila.innerText.toLowerCase();
        fila.style.display = textoFila.includes(filtro) ? '' : 'none';
    });
});

