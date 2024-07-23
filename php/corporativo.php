<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/cards.css" type="text/css">
    <title>Bobeda fiscal</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: auto;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%; /* Ajusta el tamaño como necesites */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3); /* Sombra */
            border-radius: 10px;
            text-align: center;
        }

        .modal h2 {
            margin-top: 0;
        }

        .login-form {
            margin-top: 20px;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Estilos para las letras en la parte superior */
        .modal-header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        /* Estilos para el botón de cerrar */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

    </style>
</head>
<body>
<?php require_once '../componentes/Menu.php'; ?>
<!--Margen-->
<div class="p-4 sm:ml-64" style="margin-top: -250px;">
    <div class="p-2 border-2 border-dashed rounded-lg mt-14 custom-border-blue">

        <div class="container mx-auto px-4">

            <div class="grid grid-cols-1 sm:grid-cols-5 lg:grid-cols-4 xl:grid-cols-4 gap-1">
                <div class="card">
                    <div class="face front">
                        <img src="../img/corpo.jpg" alt="">
                        <h3>Coorporativo</h3>
                    </div>
                    <div class="face back">
                        <h3>Corporativo</h3>
                        <p>Esta información se encuentra en la caja 725 anaquel 3 estante 5a</p>
                        <div class="link">
                            <a onclick="openModal('modal-coorporativo')">Ver información Digital</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="face front">
                        <img src="../img/impuestos1.jpg" alt="">
                        <h3>Impuestos Federales</h3>
                    </div>
                    <div class="face back">
                        <h3>Otros estudios adquiridos</h3>
                        <p>Complemente su perfil ingresando estudios de posgrado a su perfil</p>
                        <div class="link">
                            <a onclick="openModal('modal-impuestos-federales')">Editar información</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="face front">
                        <img src="../img/locales.jpg" alt="">
                        <h3>Impuestos Locales</h3>
                    </div>
                    <div class="face back">
                        <h3>Otros estudios adquiridos</h3>
                        <p>Complemente su perfil ingresando estudios de posgrado a su perfil</p>
                        <div class="link">
                            <a onclick="openModal('modal-impuestos-locales')">Editar información</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="face front">
                        <img src="../img/social.jpg" alt="">
                        <h3>Seguridad Social</h3>
                    </div>
                    <div class="face back">
                        <h3>Otros estudios adquiridos</h3>
                        <p>Complemente su perfil ingresando estudios de posgrado a su perfil</p>
                        <div class="link">
                            <a onclick="openModal('modal-seguridad-social')">Editar información</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<script src="https://cdn.lordicon.com/lordicon.js"></script>
</body>
</html>
