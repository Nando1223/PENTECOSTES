<?php
$serverName = "DESKTOP-2ARJ21M\\SQLFERNANDO";
$database = "FERNANDOBD";
$username = "fernando";
$password = "Fernando2304";

header('Content-Type: application/json');

try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recibir los datos del POST
    $cedula = $_POST['cedula'];
    $nombres = $_POST['nombres'];
    $direccion = $_POST['direccion'];
    $celular = $_POST['celular'];
    $congregacion = $_POST['congregacion'];
    $cargo = $_POST['cargo'];

    // Función para validar si la cédula ya existe
    function validarCedula($conn, $cedula)
    {
        $sql = "SELECT ID, Nombres FROM PENTECOSTES_ASISTENTES WHERE Cedula = :cedula";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna la fila encontrada
    }

    function guardarAsistente($conn, $cedula, $nombres, $direccion, $celular, $congregacion, $cargo)
    {
        // PRIMERO hacer el INSERT normal
        $sqlInsert = "
        INSERT INTO PENTECOSTES_ASISTENTES 
            (Cedula, Nombres, Direccion, Celular, Congregacion, Cargo, Creado_date) 
        VALUES 
            (:cedula, :nombres, :direccion, :celular, :congregacion, :cargo, GETDATE());
    ";

        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bindParam(':cedula', $cedula);
        $stmtInsert->bindParam(':nombres', $nombres);
        $stmtInsert->bindParam(':direccion', $direccion);
        $stmtInsert->bindParam(':celular', $celular);
        $stmtInsert->bindParam(':congregacion', $congregacion);
        $stmtInsert->bindParam(':cargo', $cargo);

        if (!$stmtInsert->execute()) {
            return null; // Error al guardar
        }

        // AHORA buscar el ID por cédula
        $sqlSelect = "SELECT ID FROM PENTECOSTES_ASISTENTES WHERE Cedula = :cedula";
        $stmtSelect = $conn->prepare($sqlSelect);
        $stmtSelect->bindParam(':cedula', $cedula);
        $stmtSelect->execute();

        $result = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        return $result['ID'] ?? null;
    }

    // ==========================
// PROCESO PRINCIPAL
// ==========================

    // Validar primero si la cédula ya existe
    $asistenteExistente = validarCedula($conn, $cedula);

    if ($asistenteExistente) {
        echo json_encode([
            'success' => false,
            'message' => 'La cédula ya fue registrada para el asistente: ' . $asistenteExistente['Nombres']
        ]);
    } else {
        $idNuevo = guardarAsistente($conn, $cedula, $nombres, $direccion, $celular, $congregacion, $cargo);

        if ($idNuevo) {
            // 🔥 CODIFICAR el ID aquí después de guardar
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