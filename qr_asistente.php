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
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <link rel="stylesheet" href="css/qrsistente.css">

</head>

<body>

    <div class="qr-container">
        <h2>Esta es tu entrada Digital</h2>

        <canvas id="codigoQR"></canvas>

        <p style="margin-top: 15px;"># Entrada:</p>
        <p style="word-break: break-all;"><strong><?php echo htmlspecialchars($id); ?></strong></p>

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

        var qr = new QRious({
            element: document.getElementById('codigoQR'),
            size: 250,
            value: "<?php echo $id; ?>"
        });


        function descargarQR() {

            const contenedor = document.querySelector('.qr-container');
            const elementosOcultos = document.querySelectorAll('.no-export');

            elementosOcultos.forEach(el => el.style.display = 'none');

            html2canvas(contenedor).then(canvas => {
                const enlace = document.createElement('a');
                enlace.href = canvas.toDataURL("image/png");
                enlace.download = 'entrada_digital.png';
                enlace.click();

                elementosOcultos.forEach(el => el.style.display = '');
            });
        }



        function imprimirQR() {
            window.print();
        }
    </script>

</body>


</html>