<?php
header('Content-Type: application/json');

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

    // * Obtener los datos del formulario
    $id_paciente = isset($_POST['id_paciente']) ? intval($_POST['id_paciente']) : 0;
    $id_doctor = isset($_POST['medico']) ? intval($_POST['medico']) : 0;
    $fecha = isset($_POST['fecha-cita']) ? $_POST['fecha-cita'] : '';
    $sintomas = isset($_POST['sintomas']) ? $_POST['sintomas'] : '';

    if ($id_paciente <= 0 || $id_doctor <= 0 || empty($fecha) || empty($sintomas)) {
        throw new Exception("Datos del formulario no válidos");
    }

    // ? $sql: Insertar los datos en la tabla consulta
    $sql = "INSERT INTO consulta (id_paciente, id_doctor, fecha, sintomas) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) { // ! Si la preparación de la consulta falla, se lanza una excepción
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("iiss", $id_paciente, $id_doctor, $fecha, $sintomas);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // * Devolver un mensaje de éxito en formato JSON
        echo json_encode(["success" => "Consulta guardada correctamente"]);
    } else {
        throw new Exception("Error al guardar la consulta");
    }

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