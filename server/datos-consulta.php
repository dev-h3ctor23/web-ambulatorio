<?php
header('Content-Type: application/json');

// Conexión a la base de datos
include '../server/base-datos.php';

// Verificar la conexión
if ($conn->connect_error) {
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit;
}

// Obtener el ID de la consulta desde la URL
$consultaId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($consultaId <= 0) {
    echo json_encode(['error' => 'ID de consulta inválido']);
    exit;
}

// Consulta SQL para obtener los datos de la consulta
$sql = "SELECT doctor.nombre_doctor AS nombre_medico, paciente.nombre_paciente AS nombre_paciente, consulta.fecha, consulta.sintomas, consulta.diagnostico
        FROM consulta
        JOIN doctor ON consulta.id_doctor = doctor.id_doctor
        JOIN paciente ON consulta.id_paciente = paciente.id_paciente
        WHERE consulta.id_consulta = ?";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['error' => 'Error en la preparación de la consulta']);
    exit;
}

$stmt->bind_param("i", $consultaId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Consulta no encontrada']);
}

$stmt->close();
$conn->close();
?>