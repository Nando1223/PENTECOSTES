
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