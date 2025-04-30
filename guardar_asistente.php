<?php
require_once 'conexion.php';

header('Content-Type: application/json');

try {

    $conn = new PDO("mysql:host=$serverName;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recibir los datos del POST
    $identificacion = $_POST['identificacion'];
    $nombres = $_POST['nombres'];
    $direccion = $_POST['direccion'];
    $celular = $_POST['celular'];
    $congregacion = $_POST['congregacion'];
    $cargo = $_POST['cargo'];

    // Validar si ya existe el asistente con esa identificación
    function validarIdentificacion($conn, $identificacion)
    {
        $sql = "SELECT ID, identificacion FROM PENTECOSTES_ASISTENTES WHERE identificacion = :identificacion";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':identificacion', $identificacion);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Guardar asistente
    function guardarAsistente($conn, $identificacion, $nombres, $direccion, $celular, $congregacion, $cargo)
    {
        $sqlInsert = "
          INSERT INTO PENTECOSTES_ASISTENTES 
    (Identificacion, Nombres, Direccion, Celular, Congregacion, Cargo, Creado_date) 
VALUES 
    (:identificacion, :nombres, :direccion, :celular, :congregacion, :cargo, NOW());
        ";

        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bindParam(':identificacion', $identificacion);
        $stmtInsert->bindParam(':nombres', $nombres);
        $stmtInsert->bindParam(':direccion', $direccion);
        $stmtInsert->bindParam(':celular', $celular);
        $stmtInsert->bindParam(':congregacion', $congregacion);
        $stmtInsert->bindParam(':cargo', $cargo);

        if (!$stmtInsert->execute()) {
            return null;
        }

        $sqlSelect = "SELECT ID FROM PENTECOSTES_ASISTENTES WHERE Identificacion = :identificacion";
        $stmtSelect = $conn->prepare($sqlSelect);
        $stmtSelect->bindParam(':identificacion', $identificacion);
        $stmtSelect->execute();

        $result = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        return $result['ID'] ?? null;
    }

    // Validar si ya existe
    $asistenteExistente = validarIdentificacion($conn, $identificacion);

    if ($asistenteExistente) {
        echo json_encode([
            'success' => false,
            'message' => 'Ya existe un asistente registrado con esa identificación: ' . $asistenteExistente['identificacion']
        ]);
    } else {
        $idNuevo = guardarAsistente($conn, $identificacion, $nombres, $direccion, $celular, $congregacion, $cargo);

        if ($idNuevo) {
            echo json_encode([
                'success' => true,
                'message' => 'Asistente registrado exitosamente',
                'id' => base64_encode($idNuevo)
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar el asistente']);
        }
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión: ' . $e->getMessage()]);
}

?>