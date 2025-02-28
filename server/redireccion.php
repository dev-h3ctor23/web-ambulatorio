<?php

// ! NO TOCAR: Incluimos el archivo de conexión a la base de datos
include 'base-datos.php';

// ? Verificamos si el método de la petición es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // * Obtenemos los valores de DNI y contraseña del formulario
    $dni = $_POST['dni'];
    $password = $_POST['password'];

    // ? $sql: Consulta SQL para obtener el tipo de usuario a partir del DNI y la contraseña.
    $sql = "SELECT id_usuario, tipo_usuario FROM usuario WHERE dni = ? AND contrasena = ?"; // ! NO TOCAR: Consulta SQL para obtener el tipo de usuario a partir del DNI y la contraseña.
    $stmt = $conn->prepare($sql);
    if ($stmt === false) { // ! Si la preparación de la consulta falla, se muestra un mensaje de error.
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("ss", $dni, $password); 
    $stmt->execute();
    $stmt->bind_result($id_usuario, $tipo_usuario);
    $stmt->fetch();
    $stmt->close();

    if ($tipo_usuario) { // * Si el tipo de usuario es válido, redirigimos a la página correspondiente.
        if ($tipo_usuario == 'doctor') { // ! NO TOCAR: Si el tipo de usuario es doctor, redirigimos a la página del médico.
            header("Location: ../medico.html?id=$id_usuario");
        } else if ($tipo_usuario == 'paciente') { // ! NO TOCAR: Si el tipo de usuario es paciente, redirigimos a la página del paciente con el ID del usuario.
            header("Location: ../paciente.html?id=$id_usuario");
        }
        $conn->close(); // ! Cerrar la conexión aquí
        exit();
    } else { // * Si el tipo de usuario no es válido, redirigimos con un mensaje de error.
        $conn->close(); // ! Cerrar la conexión aquí
        header("Location: ../inicio-sesion.html?error=1"); // ! Redirigir a la página de inicio de sesión con un mensaje de error.
        exit();
    }
}
?>
