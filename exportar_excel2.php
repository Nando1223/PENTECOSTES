<?php
require_once 'conexion.php';

// Encabezados para exportar como Excel
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=asistentes_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Agrega BOM UTF-8 para que Excel abra con caracteres especiales correctamente
echo "\xEF\xBB\xBF";

// Consulta
$stmt = $conn->prepare("SELECT Identificacion, Nombres, Direccion, Celular, Congregacion, Cargo, Creado_date FROM PENTECOSTES_ASISTENTES ORDER BY Creado_date DESC");
$stmt->execute();
$asistentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tabla
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
            <td style='mso-number-format:\"\\@\"'>" . htmlspecialchars($a['Identificacion'], ENT_QUOTES, 'UTF-8') . "</td>
            <td style='mso-number-format:\"\\@\"'>" . htmlspecialchars($a['Nombres'], ENT_QUOTES, 'UTF-8') . "</td>
            <td style='mso-number-format:\"\\@\"'>" . htmlspecialchars($a['Direccion'], ENT_QUOTES, 'UTF-8') . "</td>
            <td style='mso-number-format:\"\\@\"'>" . htmlspecialchars($a['Celular'], ENT_QUOTES, 'UTF-8') . "</td>
            <td style='mso-number-format:\"\\@\"'>" . htmlspecialchars($a['Congregacion'], ENT_QUOTES, 'UTF-8') . "</td>
            <td style='mso-number-format:\"\\@\"'>" . htmlspecialchars($a['Cargo'], ENT_QUOTES, 'UTF-8') . "</td>
            <td style='mso-number-format:\"\\@\"'>" . htmlspecialchars($a['Creado_date'], ENT_QUOTES, 'UTF-8') . "</td>
          </tr>";
}
echo "</table>";
?>