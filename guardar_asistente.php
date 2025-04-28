<?php
require_once 'conexion.php';

header('Content-Type: application/json');

try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recibir los datos del POST
    $nombres = $_POST['nombres'];
    $direccion = $_POST['direccion'];
    $celular = $_POST['celular'];
    $congregacion = $_POST['congregacion'];
    $cargo = $_POST['cargo'];

    // Función para validar si el nombre ya existe
    function validarNombre($conn, $nombres)
    {
        $sql = "SELECT ID, Nombres FROM PENTECOSTES_ASISTENTES WHERE Nombres = :nombres";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombres', $nombres);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna la fila encontrada
    }

    // Función para guardar un nuevo asistente
    function guardarAsistente($conn, $nombres, $direccion, $celular, $congregacion, $cargo)
    {
        // Insertar
        $sqlInsert = "
            INSERT INTO PENTECOSTES_ASISTENTES 
                (Nombres, Direccion, Celular, Congregacion, Cargo, Creado_date) 
            VALUES 
                (:nombres, :direccion, :celular, :congregacion, :cargo, GETDATE());
        ";

        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bindParam(':nombres', $nombres);
        $stmtInsert->bindParam(':direccion', $direccion);
        $stmtInsert->bindParam(':celular', $celular);
        $stmtInsert->bindParam(':congregacion', $congregacion);
        $stmtInsert->bindParam(':cargo', $cargo);

        if (!$stmtInsert->execute()) {
            return null; // Error al guardar
        }

        // Buscar el ID por el nombre
        $sqlSelect = "SELECT ID FROM PENTECOSTES_ASISTENTES WHERE Nombres = :nombres";
        $stmtSelect = $conn->prepare($sqlSelect);
        $stmtSelect->bindParam(':nombres', $nombres);
        $stmtSelect->execute();

        $result = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        return $result['ID'] ?? null;
    }

    // ==========================
    // PROCESO PRINCIPAL
    // ==========================

    // Validar si ya existe el asistente con ese nombre
    $asistenteExistente = validarNombre($conn, $nombres);

    if ($asistenteExistente) {
        echo json_encode([
            'success' => false,
            'message' => 'El asistente ya fue registrado: ' . $asistenteExistente['Nombres']
        ]);
    } else {
        $idNuevo = guardarAsistente($conn, $nombres, $direccion, $celular, $congregacion, $cargo);

        if ($idNuevo) {
            // 🔥 CODIFICAR el ID para enviar seguro
            $idCodificado = base64_encode($idNuevo);

            echo json_encode([
                'success' => true,
                'message' => 'Asistente registrado exitosamente',
                'id' => $idCodificado
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar el asistente']);
        }
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $e->getMessage()]);
}
?>