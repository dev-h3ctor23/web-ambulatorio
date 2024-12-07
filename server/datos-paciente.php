<?php

// ? Header para permitir el acceso desde cualquier origen 
header('Content-Type: application/json');

try { // ! NO TOCAR: Inicio del bloque try-catch

    // ? Las variables de conexión a la base de datos deben ser declaradas en este bloque

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ambulatorio";

    // ? Creamos la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        throw new Exception("Conexión fallida: " . $conn->connect_error);
    }

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id <= 0) {
        throw new Exception("ID de paciente no válido");
    }

    // Asegúrate de que los nombres de las columnas coincidan con los nombres reales en la base de datos
    $sql = "SELECT p.nombre_paciente AS nombre, p.correo_paciente AS correo, u.dni 
            FROM paciente p 
            JOIN usuario u ON u.id_usuario = u.id_usuario 
            WHERE p.id_paciente = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "No se encontró el paciente"]);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>