<?php
require_once 'conexion.php'; // conexión limpia

// Configurar la descarga como archivo CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="asistentes_evento.csv"');

$output = fopen('php://output', 'w');

// Cambiar el delimitador a punto y coma ;
$delimiter = ';';

// Escribir los encabezados del archivo
fputcsv($output, ['Nombres', 'Dirección', 'Celular', 'Congregación', 'Cargo', 'Estado', 'Fecha Registro'], $delimiter);

try {
    $stmt = $conn->query("SELECT Nombres, Direccion, Celular, Congregacion, Cargo, Estado, Creado_date FROM PENTECOSTES_ASISTENTES");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, [
            $row['Nombres'],
            $row['Direccion'],
            $row['Celular'],
            $row['Congregacion'],
            $row['Cargo'],
            $row['Estado'] == 1 ? 'ASISTIDO' : 'REGISTRADO',
            $row['Creado_date']
        ], $delimiter);
    }
} catch (PDOException $e) {
    echo 'Error al generar el archivo: ' . $e->getMessage();
}
fclose($output);
exit;
?>