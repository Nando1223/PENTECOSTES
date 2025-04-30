<?php
require_once 'conexion.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=asistentes_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

$stmt = $conn->prepare("SELECT Identificacion, Nombres, Direccion, Celular, Congregacion, Cargo, Creado_date FROM PENTECOSTES_ASISTENTES ORDER BY Creado_date DESC");
$stmt->execute();
$asistentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<table border='1'>";
echo "<tr>
        <th>Identificación</th>
        <th>Nombres</th>
        <th>Dirección</th>
        <th>Celular</th>
        <th>Congregación</th>
        <th>Cargo</th>
        <th>Fecha de Registro</th>
      </tr>";

foreach ($asistentes as $a) {
    echo "<tr>
            <td>{$a['Identificacion']}</td>
            <td>{$a['Nombres']}</td>
            <td>{$a['Direccion']}</td>
            <td>{$a['Celular']}</td>
            <td>{$a['Congregacion']}</td>
            <td>{$a['Cargo']}</td>
            <td>{$a['Creado_date']}</td>
          </tr>";
}
echo "</table>";
