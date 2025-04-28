<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Escanear Código QR</title>
    <link rel="icon" href="icono.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode"></script> <!-- Librería para leer QR -->
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
            margin-top: 50px;
        }

        h2 {
            color: #333;
        }
    </style>
</head>

<body>

    <h2>Escanea el Código QR del Asistente</h2>

    <div id="reader"></div>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Cuando se escanea un QR
            console.log(`Código escaneado: ${decodedText}`);

            // Enviar el ID al servidor para validar
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
                    <b>Cédula:</b> ${data.cedula}<br>
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
                    console.error('Error:', error);
                });
        }

        // Inicializar el lector de QR
        const html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start(
            { facingMode: "environment" }, // Cámara trasera del celular
            {
                fps: 10,
                qrbox: 250
            },
            onScanSuccess
        );
    </script>

</body>

</html>