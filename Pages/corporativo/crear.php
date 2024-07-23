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

// Verificar si se ha enviado el formulario para crear la carpeta
if (isset($_POST['crear'])) {
    $nombreCarpeta = $_POST['nombre_carpeta'];
    

    // Crear la carpeta en el servidor (ajustar la ruta según la estructura de archivos deseada)
    $rutaCarpeta = "carpetas/" . $nombreCarpeta;
    if (!file_exists($rutaCarpeta)) {
        mkdir($rutaCarpeta, 0777, true);
    }

    // Guardar la información de la carpeta en la base de datos
    $sql = "INSERT INTO carpetas (nombre, tamano, ruta_archivo) VALUES ('$nombreCarpeta', 0, '$rutaCarpeta')";
    
    if ($conexion->query($sql) === TRUE) {
        // Redireccionar a corporativo.php
        header("Location: ../../../../Jumex1/Jumex/Pages/corporativo/corporativo.php");
        exit(); // Asegura que el script se detenga después de la redirección
    } else {
        echo "Error al crear la carpeta: " . $conexion->error;
    }
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
