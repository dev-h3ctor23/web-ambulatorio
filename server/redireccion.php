<?php

// ! NO TOCAR: Incluimos el archivo de conexión a la base de datos
include 'base-datos.php';

// ? Verificamos si el método de la petición es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // * Obtenemos los valores de DNI y contraseña del formulario
    $dni = $_POST['dni'];
    $password = $_POST['password'];

    // ? $sql: Consulta SQL para obtener el tipo de usuario a partir del DNI y la contraseña.
    
    $sql = "SELECT tipo_usuario FROM usuario WHERE dni = ? AND contrasena = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) { // ! Si la preparación de la consulta falla, se muestra un mensaje de error.
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // * bind_param: Une variables a una sentencia SQL para la ejec
    // * execute: Ejecuta la consulta preparada.
    // * bind_result: Vincula variables a una sentencia preparada para el almacenamiento de resultados.
    // * fetch: Obtiene los resultados de la consulta y los almacena en las variables vinculadas.
    // * close: Cierra la consulta preparada.

    $stmt->bind_param("ss", $dni, $password); 
    $stmt->execute();
    $stmt->bind_result($tipo_usuario);
    $stmt->fetch();
    $stmt->close();

    if ($tipo_usuario) { // * Si el tipo de usuario es válido, redirigimos a la página correspondiente.
        if ($tipo_usuario == 'doctor') { // ! NO TOCAR: Si el tipo de usuario es doctor, redirigimos a la página del médico.
            header("Location: ../medico.html");
        } else if ($tipo_usuario == 'paciente') { // ! NO TOCAR: Si el tipo de usuario es paciente, redirigimos a la página del paciente.
            header("Location: ../paciente.html");
        }
        exit();
    } else { // * Si el tipo de usuario no es válido, mostramos un mensaje de error.
        //// Mensaje para comprobar en caso de que se equivoque de usuario o contrasela : echo "DNI o contraseña incorrectos.";
    }

    $conn->close(); // Cerrar la conexión aquí
}
?>
