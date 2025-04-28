<?php
require_once 'conexion.php';

header('Content-Type: application/json');

try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_POST['id'])) {
        echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
        exit;
    }

    $id = $_POST['id'];

    // Buscar el asistente por ID (ya sin campo Cedula)
    $sql = "SELECT Nombres, Direccion, Celular, Congregacion, Cargo, Estado 
            FROM PENTECOSTES_ASISTENTES 
            WHERE ID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $asistente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$asistente) {
        echo json_encode(['success' => false, 'message' => 'Asistente no encontrado']);
        exit;
    }

    if ($asistente['Estado'] == 1) {
        // Ya fue escaneado
        echo json_encode([
            'success' => false,
            'message' => 'Este QR ya fue utilizado por ' . $asistente['Nombres']
        ]);
    } else {
        // Marcar como escaneado (Estado = 1)
        $sqlUpdate = "UPDATE PENTECOSTES_ASISTENTES SET Estado = 1 WHERE ID = :id";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':id', $id);
        $stmtUpdate->execute();

        // Devolver los datos del asistente (sin cedula)
        echo json_encode([
            'success' => true,
            'nombre' => $asistente['Nombres'],
            'celular' => $asistente['Celular'],
            'congregacion' => $asistente['Congregacion'],
            'cargo' => $asistente['Cargo']
        ]);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $e->getMessage()]);
}
?>
