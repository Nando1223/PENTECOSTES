<?php
require_once 'conexion.php';

header('Content-Type: application/json');

try {
    $id = $_POST['ID'];

    $sql = "DELETE FROM PENTECOSTES_ASISTENTES WHERE ID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Asistente eliminado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $e->getMessage()]);
}
