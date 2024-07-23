<?php

require_once 'conexion.php';
$conexion = conectar();

// Verificar si se enviaron los datos del formulario
if (isset($_POST['username'], $_POST['password'])) {
    // Recibir datos del formulario
    $username = $_POST['username']; // Nombre de usuario
    $password = $_POST['password']; // Contraseña

    $sql = "INSERT INTO usuarios (username, pass) VALUES ('$username', '$password')";

    // Ejecutar la consulta y comprobar si se registró correctamente
    if (mysqli_query($conexion, $sql)) {
        // Usuario registrado correctamente
        header("Location: ../index.html");
        exit();
    } else {
        // Verificar si es un error de duplicidad de clave única
        if (mysqli_errno($conexion) == 1062) {
            echo "Error: El nombre de usuario ya existe.";
        } else {
            echo "Error al registrar el usuario: " . mysqli_error($conexion); // Mostrar error
        }
    }
} else {
    echo "Error: Datos del formulario no recibidos.";
}

$conexion->close();
?>
