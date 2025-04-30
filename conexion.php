<?php

// $serverName = "DESKTOP-2ARJ21M\SQLFERNANDO";
// $database = "FERNANDOBD";
// $username = "fernando"; // Usuario 'sa' de SQL Server
// $password = "Fernando2304"; // Contraseña de usuario 'sa' de SQL Server

// try {
//     $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die(json_encode(['success' => false, 'message' => 'Error en la conexión: ' . $e->getMessage()]));
// }

$serverName = "localhost";
$database = "pentecostes";
$username = "root";      // el usuario por defecto de XAMPP
$password = "";          // sin contraseña por defecto

try {
    $conn = new PDO("mysql:host=$serverName;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['success' => false, 'message' => 'Error en la conexión: ' . $e->getMessage()]));
}
?>