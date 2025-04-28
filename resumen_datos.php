<?php
require_once 'conexion.php'; // conexión limpia

try {
    $stmtTotal = $conn->prepare("SELECT COUNT(*) AS total_registrados FROM PENTECOSTES_ASISTENTES");
    $stmtTotal->execute();
    $totalRegistrados = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total_registrados'];

    $stmtAsistidos = $conn->prepare("SELECT COUNT(*) AS total_asistidos FROM PENTECOSTES_ASISTENTES WHERE Estado = 1");
    $stmtAsistidos->execute();
    $totalAsistidos = $stmtAsistidos->fetch(PDO::FETCH_ASSOC)['total_asistidos'];

    echo json_encode([
        'total_registrados' => $totalRegistrados,
        'total_asistidos' => $totalAsistidos
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'total_registrados' => 0,
        'total_asistidos' => 0,
        'error' => $e->getMessage()
    ]);
}
?>
