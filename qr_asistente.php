<?php
if (!isset($_GET['id'])) {

    die('ID de asistente no proporcionado.');
}
$id = base64_decode($_GET['id']);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>QR de Asistente</title>
    <link rel="icon" href="icono.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/stylo.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
            min-height: 100vh;
        }

        .qr-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 0px 10px #aaa;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        h2 {
            margin-bottom: 20px;
        }

        canvas {
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            background: #fff;
        }

        .buttons {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        button {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #218838;
        }

        a {
            margin-top: 20px;
            display: inline-block;
            text-decoration: none;
            color: white;
            background: #007bff;
            padding: 10px 20px;
            border-radius: 10px;
        }

        a:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

    <div class="qr-container">
        <h2>Esta es tu entrada Digital</h2>

        <canvas id="codigoQR"></canvas>

        <p style="margin-top: 15px;"># Entrada:</p>
        <p style="word-break: break-all;"><strong><?php echo htmlspecialchars($id); ?></strong></p>

        <!-- 🔥 Nueva Nota Importante -->
        <div
            style="margin-top: 20px; background: #fff3cd; color: #856404; padding: 15px; border-radius: 10px; border: 1px solid #ffeeba; font-size: 16px;">
            ⚠️ <strong>Nota Importante:</strong><br>
            Por favor, guarda esta imagen o toma una captura de pantalla.<br>
            Este código QR será requerido para ingresar al evento. 📱🎟️
        </div>

        <div class="buttons" style="margin-top: 20px;">
            <button onclick="descargarQR()">Descargar QR</button>
            <button onclick="imprimirQR()">Imprimir QR</button>
        </div>

        <a href="formulario.php">Registrar otro asistente</a>
    </div>


    <script>
        // Generar el QR usando QRious
        var qr = new QRious({
            element: document.getElementById('codigoQR'),
            size: 250,
            value: "<?php echo $id; ?>"
        });

        // Función para descargar el QR como imagen
        function descargarQR() {
            var qrCanvas = document.getElementById('codigoQR');
            var enlace = document.createElement('a');
            enlace.href = qrCanvas.toDataURL("image/png");
            enlace.download = 'qr_asistente.png';
            enlace.click();
        }

        // Función para imprimir el QR
        function imprimirQR() {
            var ventana = window.open('', '_blank');
            var contenido = `
        <html>
            <head>
                <title>Imprimir QR</title>
            </head>
            <body style="display:flex;justify-content:center;align-items:center;height:100vh;">
                <img src="${document.getElementById('codigoQR').toDataURL('image/png')}" style="width:300px;height:300px;">
            </body>
        </html>
    `;
            ventana.document.write(contenido);
            ventana.document.close();
            ventana.focus();
            ventana.print();
        }
    </script>

</body>

</html>