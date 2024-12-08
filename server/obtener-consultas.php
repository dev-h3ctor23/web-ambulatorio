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

    // Obtener las próximas consultas del paciente
    $sql = "SELECT c.id_consulta, d.nombre_doctor, c.fecha, c.sintomas 
            FROM consulta c 
            JOIN doctor d ON c.id_doctor = d.id_doctor 
            WHERE c.id_paciente = ? AND c.fecha >= CURDATE() 
            ORDER BY c.fecha ASC";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $id_paciente);
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