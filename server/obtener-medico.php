<?php

// ? Establecer el tipo de contenido de la respuesta (JSON)
header('Content-Type: application/json');

// * Variables para la conexión a la base de datos

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ambulatorio";

// ? Manejo de excepciones con try...catch para detectar errores de conexión y consultas SQL 

try {
    // ? Crear la conexión con la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // ? Verificar la conexión a la base de datos
    if ($conn->connect_error) {
        throw new Exception("Conexión fallida: " . $conn->connect_error); // ! Enviar un mensaje de error
    }
    
    // * Obtener el ID del paciente de la URL
    $id_paciente = isset($_GET['id_paciente']) ? intval($_GET['id_paciente']) : 0;


    if ($id_paciente <= 0) { // ? Verificar si el ID del paciente es válido
        throw new Exception("ID de paciente no válido"); // ! Enviar un mensaje de error
    }

    // * Consulta SQL para obtener el médico asignado al paciente con el ID proporcionado en la URL
    $sql = "SELECT d.id_doctor, d.nombre_doctor 
            FROM medico_cabecera mc 
            JOIN doctor d ON mc.id_doctor = d.id_doctor 
            WHERE mc.id_paciente = ?";

    // ? Preparar la consulta SQL para ejecutarla con parámetros 
    $stmt = $conn->prepare($sql);

    if ($stmt === false) { // ? Verificar si la preparación de la consulta falla
        throw new Exception("Error en la preparación de la consulta: " . $conn->error); // ! Enviar un mensaje de error
    }

    // ? Vincular los parámetros de la consulta

    $stmt->bind_param("i", $id_paciente);
    $stmt->execute();
    $result = $stmt->get_result();

    // ? Verificar si se encontró el médico asignado

    if ($result->num_rows > 0) {
        $medico = $result->fetch_assoc();
        echo json_encode($medico);
    } else {
        throw new Exception("No se encontró el médico asignado"); // ! Enviar un mensaje de error
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]); // ! Enviar un mensaje de error en formato JSON
}
