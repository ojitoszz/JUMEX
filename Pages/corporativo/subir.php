<?php
// Conectar a la base de datos (reemplazar con tus propios datos de conexión)
$servidor = "142.44.135.132";
$usuario = "bdcgb";
$contrasena = "717684CtS77#n";
$base_datos = "file_system";

$conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

if (isset($_POST['subir'])) {
    $nombreCarpeta = $_POST['nombre_carpeta'];
    $tamanoCarpeta = $_FILES['archivo_carpeta']['size'];
    $rutaTemporal = $_FILES['archivo_carpeta']['tmp_name'];

    // Guardar la carpeta en una ubicación específica en el servidor
    $rutaDestino = "carpetas/" . basename($_FILES['archivo_carpeta']['name']);
    move_uploaded_file($rutaTemporal, $rutaDestino);

    // Guardar la información de la carpeta en la base de datos
    $sql = "INSERT INTO carpetas (nombre, tamano, ruta_archivo) VALUES ('$nombreCarpeta', '$tamanoCarpeta', '$rutaDestino')";
    
    if ($conexion->query($sql) === TRUE) {
        echo "Carpeta subida correctamente.";
    } else {
        echo "Error al subir la carpeta: " . $conexion->error;
    }
}

// Cerrar la conexión
$conexion->close();
?>
