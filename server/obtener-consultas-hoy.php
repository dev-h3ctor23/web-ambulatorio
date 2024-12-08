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

    $id_doctor = isset($_GET['id_doctor']) ? intval($_GET['id_doctor']) : 0;

    if ($id_doctor <= 0) {
        throw new Exception("ID de doctor no válido");
    }

    // Obtener las consultas de hoy del doctor
    $sql = "SELECT c.id_consulta, p.nombre_paciente, c.sintomas 
            FROM consulta c 
            JOIN paciente p ON c.id_paciente = p.id_paciente 
            WHERE c.id_doctor = ? AND c.fecha = CURDATE() 
            ORDER BY c.fecha ASC";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $id_doctor);
    $stmt->execute();
    $result = $stmt->get_result();

    $consultas = [];
    while ($row = $result->fetch_assoc()) {
        $consultas[] = $row;
    }

    echo json_encode($consultas);

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>