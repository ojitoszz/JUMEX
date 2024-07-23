<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Carpetas</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
        }
        /* Estilos específicos para los iconos y la lista de carpetas */
        .folder-wrapper {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }

        .folder-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .folder-icon img {
            width: 44px;
            margin-right: 30px; /* Aumenta el margen entre el icono y el nombre */
        }

        .folder-name {
            flex-grow: 1; /* Para que el nombre ocupe todo el espacio disponible */
            margin-right: 20px; /* Añade margen a la derecha del nombre */
        }

        .folder-size {
            color: #666;
            margin-left: 10px; /* Reduce el margen a la izquierda del tamaño */
        }

        .folder-name a {
            color: #333;
            text-decoration: none;
        }

        .folder-name a:hover {
            text-decoration: underline;
        }

        .delete-button {
            color: red;
            cursor: pointer;
        }

        .delete-button:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<?php
$servidor = "142.44.135.132";
$usuario = "bdcgb";
$contrasena = "717684CtS77#n";
$base_datos = "file_system";

$conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

$sql = "SELECT id, nombre, tamano FROM carpetas WHERE carpeta_padre_id IS NULL";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        echo "<div class='folder-wrapper'>";
        echo "<div class='folder-info'>";
        echo "<div class='folder-icon'><img src='../../../Jumex1/Jumex/IMG/carpeta (1).png' alt='Icono de carpeta'></div>";
        echo "<div class='folder-name'><a href='../../../../Jumex1/Jumex/Pages/corporativo/ver.php?carpeta=" . $fila['id'] . "'>" . $fila['nombre'] . "</a></div>";
        echo "<div class='folder-size'>(" . round($fila['tamano'] / 1024, 2) . " KB)</div>";
        echo "<form action='../../../../Jumex1/Jumex/Pages/corporativo/eliminar.php' method='post' onsubmit='return confirm(\"¿Estás seguro de que quieres eliminar esta carpeta?\");'>";
        echo "<input type='hidden' name='id' value='" . $fila['id'] . "'>";
        echo "<button type='submit' class='delete-button'>Eliminar</button>"; // Botón para eliminar
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No se encontraron carpetas.";
}

$conexion->close();
?>

</body>
</html>
