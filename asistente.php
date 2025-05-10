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


    <link rel="stylesheet" href="css/crud.css">
</head>

<body>
    <div class="container py-4">
        <h2 class="mb-4 text-center">Lista de Asistentes</h2>

        <div class="d-flex justify-content-end mb-3">
            <a href="exportar_excel2.php" class="btn btn-success">
                <i class="fa-solid fa-file-excel"></i> Descargar Excel
            </a>
        </div>

        <div class="d-flex justify-content-end mb-3">
            <div class="col-12 col-md-6 col-lg-4">
                <input type="text" id="buscador" class="form-control" placeholder="🔍 Buscar asistente...">
            </div>
        </div>

        <div id="loading" class="text-center my-3" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p>Cargando datos, por favor espera...</p>
        </div>


        <div class="table-responsive">
            <table class="table table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Identificación</th>
                        <th>Nombres</th>
                        <th>Dirección</th>
                        <th>Celular</th>
                        <th>Congregación</th>
                        <th>Cargo</th>
                        <th><i class="fa-solid fa-pen-to-square"></i></th>
                        <th><i class="fa-solid fa-trash"></i></th>
                    </tr>
                </thead>
                <tbody id="tablaAsistentes">
                    <!-- Filas dinámicas -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
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

    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/crud.js"></script>
</body>

</html>