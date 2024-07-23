<?php
$servidor = "142.44.135.132";
$usuario = "bdcgb";
$contrasena = "717684CtS77#n";
$base_datos = "file_system";

$conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

if (isset($_POST['id'])) {
    $idCarpeta = $_POST['id'];

    // Obtener el nombre de la carpeta desde la base de datos
    $sql = "SELECT ruta_archivo FROM carpetas WHERE id = $idCarpeta";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $rutaCarpeta = "../../../Jumex1/Jumex/Pages/corporativo/carpetas/" . $fila['ruta_archivo'];

        // Eliminar físicamente la carpeta y su contenido
        if (eliminar_directorio($rutaCarpeta)) {
            // Eliminar la carpeta de la base de datos
            $sqlEliminar = "DELETE FROM carpetas WHERE id = $idCarpeta";
            if ($conexion->query($sqlEliminar) === TRUE) {
                // Redireccionar a corporativo.php
                header("Location: ../../../../Jumex1/Jumex/Pages/corporativo/corporativo.php");
                exit(); // Asegura que el script se detenga después de la redirección
            } else {
                echo "Error al eliminar la carpeta de la base de datos: " . $conexion->error;
            }
        } else {
            echo "Error al eliminar la carpeta del servidor.";
        }
    } else {
        echo "Carpeta no encontrada en la base de datos.";
    }
}

function eliminar_directorio($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!eliminar_directorio($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }

    return rmdir($dir);
}

$conexion->close();
?>
