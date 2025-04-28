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
            text-align: center;
            background: #f5f5f5;
            padding: 20px;
        }
        #reader {
            width: 300px;
            margin: auto;
            margin-top: 20px;
            display: none;
        }
        h2 {
            color: #333;
        }
        button {
            background: #28a745;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            margin-top: 20px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<h2>Escanea el Código QR del Asistente</h2>

<button id="btnScan">Iniciar Escaneo</button>

<div id="reader"></div>

<!-- 🔥 Ahora tu script para manejar el escaneo -->
<script>
// Esperar que el navegador cargue todo
document.addEventListener('DOMContentLoaded', function() {

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
    document.getElementById('btnScan').addEventListener('click', function() {
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
