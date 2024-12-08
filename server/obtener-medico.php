<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ambulatorio";

try {
    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        throw new Exception("Conexión fallida: " . $conn->connect_error);
    }

    $id_paciente = isset($_GET['id_paciente']) ? intval($_GET['id_paciente']) : 0;

    if ($id_paciente <= 0) {
        throw new Exception("ID de paciente no válido");
    }

    // Obtener el médico asignado al paciente
    $sql = "SELECT d.id_doctor, d.nombre_doctor 
            FROM medico_cabecera mc 
            JOIN doctor d ON mc.id_doctor = d.id_doctor 
            WHERE mc.id_paciente = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $id_paciente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $medico = $result->fetch_assoc();
        echo json_encode($medico);
    } else {
        throw new Exception("No se encontró el médico asignado");
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>