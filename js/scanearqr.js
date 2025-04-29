

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

