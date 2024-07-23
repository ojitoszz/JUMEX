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

// Obtener el ID de la carpeta desde la URL
if (isset($_GET['carpeta'])) {
    $carpeta_id = $_GET['carpeta'];
} else {
    die("Error: No se proporcionó el ID de la carpeta.");
}

// Consultar la información de la carpeta específica
$sql = "SELECT nombre, tamano FROM carpetas WHERE id = $carpeta_id";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $nombre_carpeta = $fila['nombre'];
    $tamano_carpeta = $fila['tamano'];
} else {
    die("Error: No se encontró la carpeta en la base de datos.");
}

// Procesamiento del formulario de creación de subcarpetas
if (isset($_POST['crear_subcarpeta'])) {
    $nombreSubcarpeta = $_POST['nombre_subcarpeta'];
    $rutaBase = "carpetas/$nombre_carpeta";
    $rutaSubcarpeta = "$rutaBase/$nombreSubcarpeta";

    // Verificar si la subcarpeta ya existe
    if (!file_exists($rutaSubcarpeta)) {
        if (mkdir($rutaSubcarpeta, 0777, true)) {
            // Guardar información de la subcarpeta en la base de datos
            $sqlInsert = "INSERT INTO carpetas (nombre, tamano, ruta_archivo, carpeta_padre_id) VALUES ('$nombreSubcarpeta', 0, '$rutaSubcarpeta', $carpeta_id)";
            if ($conexion->query($sqlInsert) === TRUE) {
                echo "<p class='success-message'>Subcarpeta creada correctamente.</p>";
            } else {
                echo "Error al guardar la información de la subcarpeta en la base de datos: " . $conexion->error;
            }
        } else {
            echo "Error al crear la subcarpeta en el servidor.";
        }
    } else {
        echo "La subcarpeta ya existe.";
    }
}

// Procesamiento de subida de archivos
if (isset($_POST['subir_archivo'])) {
    $nombreArchivo = $_FILES['archivo']['name'];
    $rutaArchivo = "carpetas/$nombre_carpeta/" . $nombreArchivo;

    // Verificar si el archivo ya existe
    if (!file_exists($rutaArchivo)) {
        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaArchivo)) {
            // Guardar información del archivo en la base de datos
            $sqlInsert = "INSERT INTO archivos (nombre, tamano, ruta_archivo, carpeta_id) VALUES ('$nombreArchivo', " . $_FILES['archivo']['size'] . ", '$rutaArchivo', $carpeta_id)";
            if ($conexion->query($sqlInsert) === TRUE) {
                echo "<p class='success-message'>Archivo subido correctamente.</p>";
            } else {
                echo "Error al guardar la información del archivo en la base de datos: " . $conexion->error;
            }
        } else {
            echo "Error al subir el archivo.";
        }
    } else {
        echo "El archivo ya existe en la carpeta.";
    }
}

// Procesamiento de eliminación de subcarpeta
if (isset($_POST['eliminar_subcarpeta'])) {
    $subcarpeta = $_POST['subcarpeta'];
    $rutaSubcarpeta = "carpetas/$nombre_carpeta/" . $subcarpeta;

    // Verificar si la subcarpeta existe antes de eliminarla
    if (file_exists($rutaSubcarpeta)) {
        // Eliminar la subcarpeta físicamente
        if (rmdir($rutaSubcarpeta)) {
            // Eliminar la entrada de la subcarpeta de la base de datos
            $sqlDelete = "DELETE FROM carpetas WHERE nombre = '$subcarpeta' AND carpeta_padre_id = $carpeta_id";
            if ($conexion->query($sqlDelete)) {
                echo "<p class='success-message'>Subcarpeta eliminada correctamente.</p>";
            } else {
                echo "Error al eliminar la subcarpeta de la base de datos: " . $conexion->error;
            }
        } else {
            echo "Error al eliminar la subcarpeta en el servidor.";
        }
    } else {
        echo "La subcarpeta no existe en el servidor.";
    }
}

// Procesamiento de eliminación de archivo
if (isset($_POST['eliminar_archivo'])) {
    $archivo = $_POST['archivo'];
    $rutaArchivo = "carpetas/$nombre_carpeta/" . $archivo;

    // Verificar si el archivo existe antes de eliminarlo
    if (file_exists($rutaArchivo)) {
        // Eliminar el archivo físicamente
        if (unlink($rutaArchivo)) {
            // Eliminar la entrada del archivo de la base de datos
            $sqlDelete = "DELETE FROM archivos WHERE nombre = '$archivo' AND carpeta_id = $carpeta_id";
            if ($conexion->query($sqlDelete)) {
                echo "<p class='success-message'>Archivo eliminado correctamente.</p>";
            } else {
                echo "Error al eliminar el archivo de la base de datos: " . $conexion->error;
            }
        } else {
            echo "Error al eliminar el archivo en el servidor.";
        }
    } else {
        echo "El archivo no existe en el servidor.";
    }
}


// Función para obtener el tamaño del directorio
function obtenerTamanoDirectorio($ruta)
{
    $tamano = 0;
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($ruta)) as $archivo) {
        $tamano += $archivo->getSize();
    }
    return $tamano;
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Carpeta - <?php echo $nombre_carpeta; ?></title>
    <link rel="stylesheet" href="../../CSS/vista.css">
    <style>
        /* Estilos CSS adicionales pueden ser definidos aquí */
    </style>
</head>

<body>

    <?php require_once '../../Componentes/menu.php'; ?>

    <div class="p-4 sm:ml-64">
        <div class="p-12 border-2 border-dashed rounded-lg mt-14 custom-border-blue">
            <!-- Botón para abrir el modal -->
            <button id="openModal" class="modal-button">Nuevo</button>

            <!-- Modal -->
            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Crear subcarpeta en "<?php echo $nombre_carpeta; ?>"</h2>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo $_SERVER['PHP_SELF'] . '?carpeta=' . $carpeta_id; ?>" method="post">
                            <label for="nombre_subcarpeta">Nombre de la subcarpeta:</label><br><br>
                            <input type="text" id="nombre_subcarpeta" name="nombre_subcarpeta" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Nombre" required><br>
                            <button type="submit" name="crear_subcarpeta" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Crear Subcarpeta</button>
                        </form>
                        <br>
                        <form action="<?php echo $_SERVER['PHP_SELF'] . '?carpeta=' . $carpeta_id; ?>" method="post" enctype="multipart/form-data">
                            <label for="archivo">Subir archivo:</label><br>
                            <input type="file" id="archivo" name="archivo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required><br><br>
                            <button type="submit" name="subir_archivo" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Subir Archivo</button>
                        </form>
                    </div>
                </div>
            </div><br><br>

            <div class="text-3xl font-bold mb-5">
                <h2><?php echo $nombre_carpeta; ?></h2>
            </div>
            <div class="subfolder-wrapper">
                <div class="subfolder-wrapper">
                    <div class="subfolder-info">
                        <div class="subfolder-details">
                            <strong>Nombre de la Carpeta</strong>
                        </div>
                        <div class="subfolder-size"><strong>Tamaño del Archivo</strong></div>
                        <div class="subfolder-actions"><strong>Acción</strong></div>
                    </div>
                </div>





                <!-- Listado de subcarpetas y archivos dentro de la carpeta actual -->
                <?php
                $ruta_carpeta = "carpetas/$nombre_carpeta"; // Ajustar según tu estructura de archivos
                if (is_dir($ruta_carpeta)) {
                    $subcarpetas = scandir($ruta_carpeta);
                    foreach ($subcarpetas as $elemento) {
                        $ruta_elemento = $ruta_carpeta . '/' . $elemento;

                        // Verificar si es una subcarpeta
                        if (is_dir($ruta_elemento) && $elemento != '.' && $elemento != '..') {
                            echo "<div class='subfolder-wrapper'>";
                            echo "<div class='subfolder-info'>";
                            echo "<div class='folder-icon'><img src='../../../Jumex1/Jumex/IMG/carpeta (1).png' alt='Icono de carpeta'></div>";
                            echo "<div class='subfolder-name'><a href='../../../Jumex1/Jumex/Pages/corporativo-ver.php?carpeta_id=$carpeta_id&subcarpeta=" . urlencode($elemento) . "'>$elemento</a></div>";
                            echo "<div class='subfolder-size'>(" . round(obtenerTamanoDirectorio($ruta_elemento) / 1024, 2) . " KB)</div>";
                            echo "<div class='subfolder-actions'>";
                            echo "<form action='' method='post' onsubmit='return confirm(\"¿Estás seguro de que quieres eliminar esta subcarpeta?\");'>";
                            echo "<input type='hidden' name='carpeta_id' value='$carpeta_id'>";
                            echo "<input type='hidden' name='subcarpeta' value='$elemento'>";
                            echo "<button type='submit' name='eliminar_subcarpeta' class='delete-button bg-green'>Eliminar</button>"; // Botón para eliminar subcarpeta
                            echo "</form>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }

                        // Verificar si es un archivo
                        if (is_file($ruta_elemento)) {
                            echo "<div class='subfolder-wrapper'>";
                            echo "<div class='subfolder-info'>";
                            echo "<div class='folder-icon'><img src='../../../Jumex1/Jumex/IMG/documentos.png' alt='Icono de archivo'></div>"; // Reemplazar con tu icono de archivo
                            echo "<div class='subfolder-name'>$elemento</div>";
                            echo "<div class='subfolder-size'>(" . round(filesize($ruta_elemento) / 1024, 2) . " KB)</div>"; // Obtener tamaño del archivo
                            echo "<div class='subfolder-actions'>";
                            echo "<a href='$ruta_elemento' download class='download-link'>Descargar</a>";
                            echo "<button type='submit' name='eliminar_archivo' class='delete-button bg-green'>Eliminar</button>"; // Botón para eliminar subcarpeta
                            // Puedes agregar más acciones como visualizar o eliminar según tus necesidades
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    }
                } else {
                    echo "No se encontraron subcarpetas en esta carpeta.";
                }
                ?>

                <script>
                    // Obtener el modal
                    var modal = document.getElementById('myModal');

                    // Obtener el botón que abre el modal
                    var btn = document.getElementById("openModal");

                    // Cuando el usuario haga clic en el botón, abrir el modal
                    btn.onclick = function() {
                        modal.style.display = "block";
                    }

                    // Cuando el usuario haga clic fuera del modal, cerrarlo
                    window.onclick = function(event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }
                </script>

            </div>
        </div>

</body>

</html>