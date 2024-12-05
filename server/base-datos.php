<?php

// ? base-datos.php: Este archivo se encarga de crear la base de datos y las tablas necesarias para el funcionamiento del sistema.

// * servervname: Nombre del servidor.
// * username: Nombre de usuario.
// * password: Contraseña.
// * sqlFile: Ruta del archivo SQL.

$servername = "localhost";
$username = "root";
$password = "";

// * sqlFile: Ruta del archivo SQL.
// * __DIR__: Devuelve el directorio del archivo actual.

$sqlFile = __DIR__ . '/../database/ambulatorio.sql'; // ! NO TOCAR: Funciona para obtener la ruta del archivo SQL.

// * conn: Conexión a la base de datos utilizando los datos de conexión declarados anteriormente.

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) { // ! Si la conexión falla, se muestra un mensaje de error.
    die("Conexión fallida: " . $conn->connect_error);
}

// * sql: Lee el contenido del archivo SQL y lo almacena en la variable $sql.
// * file_get_contents: Lee el contenido de un archivo y lo devuelve como una cadena.

$sql = file_get_contents($sqlFile);

if ($sql === false) { // ! Si no se puede leer el archivo SQL, se muestra un mensaje de error.
    die("Error al leer el archivo SQL");
}

// * multi_query: Ejecuta una o múltiples consultas SQL en la base de datos.

if ($conn->multi_query($sql) === TRUE) { // * Si la consulta SQL se ejecuta correctamente, se muestra un mensaje de éxito.

    // ? Procesar todos los resultados de las consultas anteriores.

        // * more_results: Comprueba si hay más resultados de las consultas.
        // * next_result: Avanza al siguiente resultado de la consulta.
        // * store_result: Transfiere un conjunto de resultados de la última consulta.
        // * free: Libera la memoria del resultado.

    while ($conn->more_results() && $conn->next_result()) { // * Mientras haya más resultados, se procesan.
        
        if ($res = $conn->store_result()) { // * Si hay un resultado, se libera la memoria.
            $res->free(); // * Libera la memoria del resultado.
        }
    }
    //// Mensaje de test para comprobar que se crea la DB y se crean las tablas: echo "Base de datos y tablas creadas exitosamente";
} else {
    die("Error al crear la base de datos y las tablas: " . $conn->error); // ! Si hay un error al crear la base de datos y las tablas, se muestra un mensaje de error.
}

// ? Logica para insertar datos en la base de datos a partir de un archivo SQL.

    // * insertarDatosPath: Ruta del archivo insertar-datos.sql.

$insertarDatosPath = realpath(__DIR__ . '/../database/insertar-datos.sql'); // ! NO TOCAR: Funciona para obtener la ruta del archivo insertar-datos.sql.
if ($insertarDatosPath === false) {
    die("Error: No se pudo encontrar el archivo insertar-datos.sql"); // ! Si no se puede encontrar el archivo insertar-datos.sql, se muestra un mensaje de error.
} else {
    $sqlInsertarDatos = file_get_contents($insertarDatosPath); // * Lee el contenido del archivo insertar-datos.sql y lo almacena en la variable $sqlInsertarDatos.
    if ($sqlInsertarDatos === false) { // ! Si no se puede leer el archivo insertar-datos.sql, se muestra un mensaje de error.
        die("Error al leer el archivo insertar-datos.sql"); // ! Si no se puede leer el archivo insertar-datos.sql, se muestra un mensaje de error.
    }

    if ($conn->multi_query($sqlInsertarDatos) === TRUE) { // * Si la consulta SQL se ejecuta correctamente, se muestra un mensaje de éxito.
        
        while ($conn->more_results() && $conn->next_result()) { // * Mientras haya más resultados, se procesan.
            
            if ($res = $conn->store_result()) { // * Si hay un resultado, se libera la memoria.
                $res->free(); // * Libera la memoria del resultado.
            }
        }
        //// Mensaje de test para comprobar que se insertan los datos en las tablas: echo "Datos insertados exitosamente";
    } else {
        die("Error al insertar los datos: " . $conn->error); // ! Si hay un error al insertar los datos, se muestra un mensaje de error.
    }
}

// ! Cerrar la conexión a la base de datos.
$conn->close();
?>