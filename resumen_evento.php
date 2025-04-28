<?php
require_once 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resumen de Asistentes</title>
    <link rel="icon" href="icono.ico" type="image/x-icon">

    <style>
        .logo-fijo {
            position: fixed;
            top: -250px;
            left: -100px;
            width: 100%;
            max-width: 580px;
            /* 🔥 Controlas el tamaño máximo */
            opacity: 0.7;
            z-index: 999;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #0a0f2c, #011442);
            /* 🔥 Fondo degradado azul */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        h1 {
            margin-bottom: 40px;
            color: #fff;
            /* 🔥 Texto blanco */
            background: rgba(0, 0, 0, 0.4);
            /* 🔥 Fondo oscuro transparente */
            padding: 10px 20px;
            border-radius: 10px;
        }

        .contador {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 0px 10px #000;
            text-align: center;
            margin: 20px;
            width: 300px;
        }

        .contador h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .contador p {
            font-size: 60px;
            margin: 10px 0;
            color: #28a745;
            font-weight: bold;
        }

        .contadores {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .boton-descarga {
            margin-top: 30px;
        }

        .boton-descarga a {
            background: #ffffff;
            /* 🔥 Botón blanco */
            color: #0a0f2c;
            /* 🔥 Texto azul */
            padding: 15px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            border: 2px solid #0a0f2c;
            /* 🔥 Borde azul */
            transition: all 0.4s ease;
        }

        .boton-descarga a:hover {
            background: #0a0f2c;
            /* 🔥 Botón azul al pasar mouse */
            color: white;
            border: 2px solid white;
        }
    </style>


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

    <script>
        function actualizarContadores() {
            fetch('resumen_datos.php') // Llamamos a un archivo PHP pequeño
                .then(response => response.json())
                .then(data => {
                    document.getElementById('registrados').innerText = data.total_registrados;
                    document.getElementById('asistidos').innerText = data.total_asistidos;
                })
                .catch(error => {
                    console.error('Error al actualizar:', error);
                });
        }

        // Actualizar cada 5 segundos
        setInterval(actualizarContadores, 5000);

        // Llamar una vez cuando carga la página
        actualizarContadores();
    </script>

</body>

</html>