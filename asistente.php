<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Asistentes</title>
    <link rel="icon" href="icono.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(135deg, #0a0f2c, #011442);
            color: white;
            padding: 30px;
        }

        .container {
            background: white;
            color: black;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.4);
        }

        .table th {
            background-color: #011442;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mb-4">Lista de Asistentes</h2>

        <div class="d-flex justify-content-end mb-3">
            <div class="col-12 col-md-4">
                <input type="text" id="buscador" class="form-control" placeholder="🔍 Buscar asistente...">
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Identificación</th>
                    <th>Nombres</th>
                    <th>Dirección</th>
                    <th>Celular</th>
                    <th>Congregación</th>
                    <th>Cargo</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody id="tablaAsistentes">
                <!-- Filas dinámicas -->
            </tbody>
        </table>
    </div>


    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Asistente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId">
                    <div class="mb-2">
                        <label>Identificación</label>
                        <input type="text" id="editIdentificacion" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Nombres</label>
                        <input type="text" id="editNombres" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Dirección</label>
                        <input type="text" id="editDireccion" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Celular</label>
                        <input type="text" id="editCelular" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Congregación</label>
                        <input type="text" id="editCongregacion" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Cargo</label>
                        <input type="text" id="editCargo" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCambios()">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Cargar asistentes al cargar la página
        window.onload = () => cargarAsistentes();

        function cargarAsistentes() {
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

    </script>




</body>

</html>