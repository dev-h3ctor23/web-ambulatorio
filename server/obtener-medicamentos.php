<?php

// ? Header para especificar el tipo de contenido que se enviará

header('Content-Type: application/json');

// ? Include para importar la conexión a la base de datos
include '../server/base-datos.php';

// ? Verificar la conexión a la base de datos
if ($conn->connect_error) {
    echo json_encode(['error' => 'Error de conexión a la base de datos']); // ! Enviar un JSON con un mensaje de error
    exit;
}

// * Consulta SQL para obtener los medicamentos
$sql = "SELECT id_medicacion, nombre FROM medicacion";
$result = $conn->query($sql);

$medicamentos = []; // ? Array para almacenar los medicamentos

// * fetch_assoc() obtiene una fila de resultados como un array asociativo
// * $result->fetch_assoc() devuelve un array asociativo de la fila actual del conjunto de resultados

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $medicamentos[] = $row;
    }
    echo json_encode($medicamentos);
} else {
    echo json_encode(['error' => 'No se encontraron medicamentos']); // ! Enviar un JSON con un mensaje de error
}

$conn->close();
?>