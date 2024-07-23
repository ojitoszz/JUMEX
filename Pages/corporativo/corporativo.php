<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iconos de Carpeta con Imagen</title>
    <!-- Incluimos FontAwesome para otros íconos, pero no lo usaremos para la carpeta -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-JNZm1oQUha3+5K4cBm4U7r8zvXe5gbPz31jcbnGxnuS2V1FPHw+YFOMwB6l2Zlp3JFVGrql01+4P5AehosFO6g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5; /* Color de fondo */
            margin: 0;
            padding: 0;
        }

        /* Estilos específicos para los iconos */
        .icon-wrapper {
            background-color: #fff; /* Fondo blanco */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            max-width: 800px;
            margin: 20px auto;
        }

        .icon {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .icon img {
            width: 24px; /* Ajusta el tamaño de la imagen según sea necesario */
            margin-right: 10px;
        }

        .icon a {
            color: #333;
            text-decoration: none;
        }

        .icon a:hover {
            text-decoration: underline;
        }

        /* Estilos para el modal */
        .modal {
            display: none; /* Ocultar modal por defecto */
            position: fixed; /* Fijar posición */
            z-index: 1; /* Z-index alto para estar por encima del contenido */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Habilitar desplazamiento si el contenido es demasiado largo */
            background-color: rgba(0,0,0,0.6); /* Fondo semi-transparente oscuro */
        }

        .modal-content {
            background-color: #fefefe; /* Fondo blanco */
            margin: 15% auto;
            padding: 20px;
            border-radius: 12px; /* Bordes más redondeados */
            width: 100%;
            max-width: 400px;
            box-shadow: 10px 24px 138px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            padding: 15px;
            border-bottom: 1px solid #ccc; /* Borde inferior más suave */
            background-color: #f0f0f0; /* Color de fondo más claro */
            border-radius: 12px 12px 0 0; /* Bordes redondeados en la parte superior */
        }

        .modal-header h2 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .close {
            color: red;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover,
        .close:focus {
            color: #333; /* Color más oscuro al pasar el mouse */
            text-decoration: none;
        }

        /* Estilos para el botón */
        .modal-button {
            background: blue; /* Gradiente de colores */
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px; /* Bordes redondeados */
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra suave */
            transition: background 0.3s ease;
        }

        .modal-button:hover {
            background: linear-gradient(to bottom, #45a049, #4CAF50); /* Cambio de gradiente al pasar el mouse */
        }
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
                    <form action="../../../../Jumex1/Jumex/Pages/corporativo/crear.php" method="post">
                        <div class="text-3xl font-bold mb-5">
                            <h2>Crear nueva carpeta</h2>
                        </div>
                        <div class="modal-body">
                            <label class="text font-medium text-gray-900">Nombre de la carpeta</label><br><br>
                            <input type="text" name="nombre_carpeta" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"  placeholder="Nombre" required><br>
                            <button type="submit" name="crear" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Crear Carpeta</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Listado de carpetas existentes -->
            <?php require_once '../../../../Jumex1/Jumex/Pages/corporativo/listar.php'; ?>

        </div>
    </div>

    <script>
    // Obtener el modal
    var modal = document.getElementById('myModal');

    // Obtener el botón que abre el modal
    var btn = document.getElementById("openModal");

    // Obtener el elemento span que cierra el modal
    var span = document.getElementsByClassName("close")[0];

    // Cuando el usuario haga clic en el botón, abrir el modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // Cuando el usuario haga clic en <span> (x), cerrar el modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Cuando el usuario haga clic fuera del modal, cerrarlo
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>
</body>
</html>
