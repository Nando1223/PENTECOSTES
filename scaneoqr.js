

function onScanSuccess(decodedText, decodedResult) {

    console.log(`Código escaneado: ${decodedText}`);

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
            console.error('Error:', error);
        });
}

const html5QrCode = new Html5Qrcode("reader");

// 🚀 Primero listar las cámaras disponibles
Html5Qrcode.getCameras().then(cameras => {
    if (cameras && cameras.length) {
        let cameraId = null;

        // Buscar si hay una cámara trasera disponible
        const backCamera = cameras.find(camera => camera.label.toLowerCase().includes('back'));

        if (backCamera) {
            cameraId = backCamera.id; // Si hay cámara trasera, usarla
        } else {
            cameraId = cameras[0].id; // Si no, usar la primera cámara disponible
        }

        // Iniciar la cámara seleccionada
        html5QrCode.start(
            cameraId,
            {
                fps: 10,
                qrbox: 250
            },
            onScanSuccess
        );
    } else {
        alert("No se encontraron cámaras disponibles.");
    }
}).catch(err => {
    console.error("Error al obtener cámaras:", err);
});
