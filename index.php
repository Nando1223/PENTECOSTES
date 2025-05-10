<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Asistencia</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="icono.ico" type="image/x-icon">

    <link rel="stylesheet" href="css/stylo.css">
    <link rel="stylesheet" href="css/icono.css">
    <link rel="stylesheet" href="css/titulo.css">
</head>



<body>
    <div class="form-container">

        <img src="RD LOGO.png" alt="Logo" class="logo-formulario" style="margin-top: -120px;">
        <h1 class="titulo-invitados">Apóstol Carlos Macías y Profeta Tatiana Martínez</h1>


        <h2>Registro de Asistencia PENTECOSTÉS</h2>

        <div class="flyer-container">
            <img src="FLYER.jpg" alt="Flyer Pentecostés" class="flyer-img">
        </div>


        <form id="formulario_asistente">

            <div class="form-group">
                <label for="identificacion">Cédula o Pasaporte:</label>
                <input type="text" id="identificacion" name="identificacion" required>
            </div>

            <div class="form-group">
                <label for="nombres">Nombres:</label>
                <input type="text" id="nombres" name="nombres" required>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required>
            </div>

            <div class="form-group">
                <label for="celular">Celular:</label>
                <input type="number" id="celular" name="celular" required>
            </div>

            <div class="form-group">
                <label for="congregacion">Nombre de la Congregación:</label>
                <input type="text" id="congregacion" name="congregacion" required>
            </div>

            <div class="form-group">
                <label>Cargo:</label>
                <div class="cargos">
                    <label><input type="radio" name="cargo" value="PASTOR, PROFETA, EVANGELISTA, MAESTRO, APÓSTOL"
                            required> PASTOR, PROFETA, EVANGELISTA, MAESTRO, APÓSTOL</label>
                    <label><input type="radio" name="cargo" value="LÍDER" required> LÍDER</label>
                    <label><input type="radio" name="cargo" value="MIEMBRO DE UNA CONGREGACIÓN" required> MIEMBRO DE UNA
                        CONGREGACIÓN</label>
                </div>
            </div>

            <button type="submit">Registrarme</button>
        </form>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/formulario.js"></script>

</body>

</html>