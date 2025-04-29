<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Escanear Código QR</title>
    <link rel="icon" href="icono.ico" type="image/x-icon">

    <!-- 🔥 PRIMERO cargamos html5-qrcode -->
    <script src="https://unpkg.com/html5-qrcode"></script>

    <!-- 🔥 Luego SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #0a0f2c, #011442);
            /* 🔥 Fondo azul oscuro degradado */
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            /* 🔥 Contenedor blanco semi-transparente */
            padding: 80px 0px;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.4);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        .logo-formulario {
            width: 150px;
            /* 🔥 Tamaño del logo */
            margin-bottom: -60px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        #reader {
            width: 300px;
            margin: auto;
            margin-top: 20px;
            display: none;
            /* Se mostrará cuando den clic */
        }

        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(90deg, #0a0f2c, #011442);
            /* 🔥 Botón azul degradado */
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            margin-top: 20px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.4s ease;
        }

        button:hover {
            background: linear-gradient(90deg, #011442, #0a0f2c);
        }

        /* Responsivo */
        @media (max-width: 600px) {
            .container {
                padding: 20px 15px;
                max-width: 90%;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <img src="RD LOGO.png" alt="Logo" class="logo-formulario" style="margin-top: -50px;"> <!-- 🔥 Logo arriba -->

        <h2>Escanea el Código QR del Asistente</h2>

        <button id="btnScan">Iniciar Escaneo</button>

        <div id="reader"></div>
    </div>

    <!-- 🔥 Ahora tu script para manejar el escaneo -->
    <script>
        // Esperar que el navegador cargue todo
        document.addEventListener('DOMContentLoaded', function () {

            // Función para validar QR
            function validarQR(decodedText) {
                fetch('validar_qr.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id=' + encodeURIComponent(decodedText)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '✅ Acceso permitido',
                                html: `
                        <b>Nombre:</b> ${data.nombre}<br>
                        <b>Celular:</b> ${data.celular}<br>
                        <b>Congregación:</b> ${data.congregacion}<br>
                        <b>Cargo:</b> ${data.cargo}
                    `
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '⚠️ QR ya utilizado',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error al validar:', error);
                    });
            }

            // Iniciar escaneo al hacer clic
            document.getElementById('btnScan').addEventListener('click', function () {
                document.getElementById('reader').style.display = 'block';
                const html5QrCode = new Html5Qrcode("reader");
                html5QrCode.start(
                    { facingMode: "environment" },
                    { fps: 10, qrbox: 250 },
                    function onScanSuccess(decodedText, decodedResult) {
                        console.log(`Código escaneado: ${decodedText}`);
                        html5QrCode.stop(); // Detener lector
                        validarQR(decodedText);
                    }
                );
            });

        });
    </script>

</body>

</html>