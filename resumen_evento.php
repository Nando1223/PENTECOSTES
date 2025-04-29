<?php
require_once 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resumen de Asistentes</title>
    <link rel="icon" href="icono.ico" type="image/x-icon">

    <link rel="stylesheet" href="css/resumen.css">
</head>

<body>

    <img src="RD LOGO.png" alt="Logo" class="logo-fijo"> <!-- 🔥 Aquí sí -->


    <h1>Resumen del Evento</h1>

    <div class="contadores">
        <div class="contador">
            <h2>Total Registrados</h2>
            <p id="registrados">0</p> <!-- 🔥 ID para actualizar -->
        </div>
        <div class="contador">
            <h2>Total Asistidos</h2>
            <p id="asistidos">0</p> <!-- 🔥 ID para actualizar -->
        </div>
    </div>

    <div class="boton-descarga">
        <a href="exportar_excel.php" target="_blank">📥 Descargar Excel</a>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/resumen.js"></script> <!-- ✅ AQUÍ CORREGIDO -->

</body>

</html>