<?php
header('Content-Type: application/json');

// Conexión a la base de datos
include '../server/base-datos.php';

// Verificar la conexión
if ($conn->connect_error) {
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit;
}

// Consulta SQL para obtener los doctores
$sql = "SELECT id_doctor, nombre_doctor FROM doctor";
$result = $conn->query($sql);

$doctores = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctores[] = $row;
    }
    echo json_encode($doctores);
} else {
    echo json_encode(['error' => 'No se encontraron doctores']);
}

$conn->close();
?>