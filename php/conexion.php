<?php

function conectar(){


// Datos de conexión a la base de datos
$servername = "142.44.135.132"; // Puede ser localhost si está en el mismo servidor
$username = "bdcgb";
$password = "717684CtS77#n";
$database = "file_system"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
return $conn;
}
$conn = conectar();
?>
