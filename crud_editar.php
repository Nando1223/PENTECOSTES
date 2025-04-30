<?php
require_once 'conexion.php';

header('Content-Type: application/json');

try {
    $id = $_POST['ID'];
    $identificacion = $_POST['Identificacion'];
    $nombres = $_POST['Nombres'];
    $direccion = $_POST['Direccion'];
    $celular = $_POST['Celular'];
    $congregacion = $_POST['Congregacion'];
    $cargo = $_POST['Cargo'];

    $sql = "UPDATE PENTECOSTES_ASISTENTES 
            SET Identificacion = :identificacion,
                Nombres = :nombres,
                Direccion = :direccion,
                Celular = :celular,
                Congregacion = :congregacion,
                Cargo = :cargo
            WHERE ID = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':identificacion', $identificacion);
    $stmt->bindParam(':nombres', $nombres);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':celular', $celular);
    $stmt->bindParam(':congregacion', $congregacion);
    $stmt->bindParam(':cargo', $cargo);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Asistente actualizado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $e->getMessage()]);
}
