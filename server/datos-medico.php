<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ambulatorio";

try {
    // * Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // * Verificar conexión
    if ($conn->connect_error) {
        throw new Exception("Conexión fallida: " . $conn->connect_error);
    }

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id <= 0) {
        throw new Exception("ID de médico no válido");
    }

    // * Obtener información del médico y su especialidad
    $sql = "SELECT d.nombre_doctor AS nombre, d.correo_doctor AS correo, e.nombre_especialidad AS especialidad 
            FROM doctor d 
            JOIN doctor_especialidad de ON d.id_doctor = de.id_doctor 
            JOIN especialidad e ON de.id_especialidad = e.id_especialidad 
            WHERE d.id_doctor = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $medico = $result->fetch_assoc();
    } else {
        throw new Exception("No se encontró el médico");
    }

    $stmt->close();

    // ! Obtener número de consultas en los próximos 7 días
    $sql = "SELECT COUNT(*) AS numero_consultas FROM consulta WHERE id_doctor = ? AND fecha >= CURDATE() AND fecha < DATE_ADD(CURDATE(), INTERVAL 8 DAY)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $consultas_semana = $result->fetch_assoc();
    } else {
        $consultas_semana = ["numero_consultas" => 0];
    }

    $stmt->close();

    // * Obtener consultas de hoy
    $sql = "SELECT c.id_consulta AS id, p.nombre_paciente AS paciente, c.sintomas 
            FROM consulta c 
            JOIN paciente p ON c.id_paciente = p.id_paciente 
            WHERE c.id_doctor = ? AND c.fecha = CURDATE()";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) { // ! Si la preparación de la consulta falla, se lanza una excepción
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // * Almacenar los resultados en un array
    $consultas_hoy = [];
    while ($row = $result->fetch_assoc()) {
        $consultas_hoy[] = $row;
    }

    $stmt->close();
    $conn->close(); // ! Cerrar la conexión aquí

    // * Devolver los datos del médico y las consultas de hoy en formato JSON
    echo json_encode([
        "nombre" => $medico["nombre"],
        "correo" => $medico["correo"],
        "especialidad" => $medico["especialidad"],
        "numero_consultas" => $consultas_semana["numero_consultas"],
        "consultas_hoy" => $consultas_hoy
    ]);
} catch (Exception $e) {
    // * Manejar excepciones y devolver un mensaje de error en formato JSON
    echo json_encode(["error" => $e->getMessage()]);
}
?>