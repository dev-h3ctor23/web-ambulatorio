<?php
header('Content-Type: application/json');

// ! NO TOCAR: Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ambulatorio";

try {
    // * Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // ? Verificar conexión
    if ($conn->connect_error) {
        throw new Exception("Conexión fallida: " . $conn->connect_error);
    }

    // * Obtener el ID del doctor desde la URL
    $id_doctor = isset($_GET['id_doctor']) ? intval($_GET['id_doctor']) : 0;

    if ($id_doctor <= 0) {
        throw new Exception("ID de doctor no válido");
    }

    // ? $sql: Consulta SQL para obtener las consultas de hoy del doctor
    $sql = "SELECT c.id_consulta, p.nombre_paciente, c.sintomas 
            FROM consulta c 
            JOIN paciente p ON c.id_paciente = p.id_paciente 
            WHERE c.id_doctor = ? AND c.fecha = CURDATE() 
            ORDER BY c.fecha ASC";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) { // ! Si la preparación de la consulta falla, se lanza una excepción
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $id_doctor);
    $stmt->execute();
    $result = $stmt->get_result();

    // * Almacenar los resultados en un array
    $consultas = [];
    while ($row = $result->fetch_assoc()) {
        $consultas[] = $row;
    }

    // * Devolver los resultados en formato JSON
    echo json_encode($consultas);

    $stmt->close();
    $conn->close(); // ! Cerrar la conexión aquí
} catch (Exception $e) {
    // * Manejar excepciones y devolver un mensaje de error en formato JSON
    echo json_encode(['error' => $e->getMessage()]);
    if ($conn) {
        $conn->close(); // ! Cerrar la conexión aquí en caso de error
    }
}
?>