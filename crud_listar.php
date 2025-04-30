<?php
require_once 'conexion.php';

header('Content-Type: application/json');

try {
    $stmt = $conn->prepare("SELECT ID, Identificacion, Nombres, Direccion, Celular, Congregacion, Cargo FROM PENTECOSTES_ASISTENTES ORDER BY Creado_date DESC");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al listar: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error general: ' . $e->getMessage()]);
} ?>
