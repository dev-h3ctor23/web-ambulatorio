<?php
header('Content-Type: application/json');

// Conexión a la base de datos
include '../server/base-datos.php';

// Verificar la conexión
if ($conn->connect_error) {
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit;
}

// Obtener los datos enviados desde el cliente
$consultaId = isset($_POST['id']) ? intval($_POST['id']) : 0;
$diagnostico = isset($_POST['diagnostico']) ? $_POST['diagnostico'] : '';

if ($consultaId <= 0 || empty($diagnostico)) {
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
}

// Consulta SQL para actualizar los datos de la consulta
$sql = "UPDATE consulta SET diagnostico = ? WHERE id_consulta = ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['error' => 'Error en la preparación de la consulta']);
    exit;
}

$stmt->bind_param("si", $diagnostico, $consultaId);
if ($stmt->execute()) {
    echo json_encode(['success' => 'Consulta actualizada correctamente']);
} else {
    echo json_encode(['error' => 'Error al actualizar la consulta']);
}

$stmt->close();
$conn->close();
?>