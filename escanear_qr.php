<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Escanear Código QR</title>
    <link rel="icon" href="icono.ico" type="image/x-icon">
    <!-- ✅ RUTA DIRECTA -->
    <link rel="stylesheet" href="css/scanearqr.css">
    <!-- 🔥 PRIMERO cargamos html5-qrcode -->

    <script src="https://unpkg.com/html5-qrcode"></script>

    <!-- 🔥 Luego SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <div class="container">
        <img src="RD LOGO.png" alt="Logo" class="logo-formulario" style="margin-top: -50px;"> <!-- 🔥 Logo arriba -->

        <h2>Escanea el Código QR del Asistente</h2>

        <button id="btnScan">Iniciar Escaneo</button>

        <div id="reader"></div>
    </div>



    <script src="js/scanearqr.js"></script> <!-- ✅ AQUÍ CORREGIDO -->
</body>

</html>