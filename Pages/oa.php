<?php
require_once '../../../Jumex1/Jumex/Componentes/menu.php'; // Asegúrate de que la ruta sea correcta
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablero</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    
    <style>
        /* Estilos CSS para ajustar el contenido hacia la derecha */
        body {
            background-color: #f3f4f6; /* Color de fondo */
            margin-left: 25%; /* Margen izquierdo del 25% */
            padding: 20px; /* Padding general */
        }
        
        .container {
            max-width: 1200px; /* Ancho máximo del contenedor */
            margin: 0 auto; /* Centrar horizontalmente */
        }
        
        @media (max-width: 1024px) {
            body {
                margin-left: 0; /* Eliminar margen en pantallas más pequeñas */
            }
        }
    </style>
</head>

<body>

<div class="container">
        <div>
    <h1 class="text-3xl font-bold mb-4">Botomex</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <button class="bg-green-500 text-white p-4 rounded">Empresa 1</button>
        <button class="bg-red-500 text-white p-4 rounded">Empresa 2</button>
        <button class="bg-red-500 text-white p-4 rounded">Empresa 3</button>
        <button class="bg-green-500 text-white p-4 rounded">Empresa 4</button>
        <button class="bg-red-500 text-white p-4 rounded">Empresa 5</button>
    </div>

    <div class="flex flex-wrap mb-8">
        <div class="w-full lg:w-2/3 bg-white p-6 rounded-lg shadow-lg mb-4 lg:mb-0">
            <h2 class="text-2xl font-bold mb-4">Progreso de la Empresa</h2>
            <p class="mb-4">Aquí se mostrará el progreso de la empresa seleccionada.</p>
            <div class="bg-gray-100 p-4 rounded shadow mb-4">
                <h3 class="font-bold mb-2">Actividades</h3>
                <ul class="list-disc pl-5">
                    <li>Actividad 1 Completada</li>
                    <li>Actividad 2 Completada</li>
                    <li>Actividad 3 Completada</li>
                </ul>
            </div>
            <div class="bg-gray-100 p-4 rounded shadow">
                <h3 class="font-bold mb-2">Registros</h3>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2">Sistema</th>
                            <th class="py-2">Hora</th>
                            <th class="py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-4 py-2">Juan Romana</td>
                            <td class="border px-4 py-2">10:00 AM</td>
                            <td class="border px-4 py-2">Cargar datos</td>
                        </tr>
                        <!-- Añadir más filas según sea necesario -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="w-full lg:w-1/3 bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Gráfica de Progreso</h2>
            <div id="chart"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
        <!-- Sección de Usuario con Gráfica -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-lg mb-4">
            <h2 class="text-2xl font-bold mb-4">Usuario</h2>
            <div class="flex flex-wrap items-center">
                <div class="w-full lg:w-1/2 bg-gray-100 p-4 rounded shadow-lg mb-4">
                    <h3 class="font-bold mb-2">Juan Romana</h3>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2">Fecha</th>
                                <th class="py-2">Acción</th>
                                <th class="py-2">Descarga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border px-4 py-2">29-07-2024</td>
                                <td class="border px-4 py-2">Cargar</td>
                                <td class="border px-4 py-2">Sí</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">29-07-2024</td>
                                <td class="border px-4 py-2">Editar</td>
                                <td class="border px-4 py-2">No</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">29-07-2024</td>
                                <td class="border px-4 py-2">Consultar</td>
                                <td class="border px-4 py-2">Sí</td>
                            </tr>
                        </tbody>
                    </table>
                    <canvas id="chart4" class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8"></canvas>
                </div>
                <div class="w-full lg:w-1/2 bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold mb-4">Juan Romana</h2>
                    <div id="chart1"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Datos de ejemplo para las gráficas
    const options = {
        series: [{
            name: 'Progreso',
            data: [30, 40, 45, 50, 49, 60, 70, 91, 125]
        }],
        chart: {
            height: 350,
            type: 'area'
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre']
        }
    };

    const chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

    // Datos de ejemplo para las gráficas adicionales
    const chart1Options = {
        series: [{
            name: 'Progreso',
            data: [30, 40, 45, 50, 49, 60, 70, 91, 125]
        }],
        chart: {
            height: 350,
            type: 'area'
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre']
        }
    };

    const chart2Options = {
        series: [{
            name: 'Entradas',
            data: [10, 20, 15, 25, 30, 35, 40, 45, 50]
        }],
        chart: {
            height: 350,
            type: 'line'
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre']
        }
    };

    const chart3Options = {
        series: [{
            name: 'Acciones',
            data: [5, 15, 10, 20, 25, 30, 35, 40, 45]
        }],
        chart: {
            height: 350,
            type: 'bar'
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre']
        }
    };

    const chart1 = new ApexCharts(document.querySelector("#chart1"), chart1Options);
    const chart2 = new ApexCharts(document.querySelector("#chart2"), chart2Options);
    const chart3 = new ApexCharts(document.querySelector("#chart3"), chart3Options);
    chart1.render();
    chart2.render();
    chart3.render();

    // Gráfico adicional para Usuario
    const chart4Options = {
        series: [{
            name: 'Progreso',
            data: [30, 40, 45, 50, 49, 60, 70, 91, 125]
        }],
        chart: {
            height: 200,
            type: 'area'
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre']
        }
    };

    const chart4 = new ApexCharts(document.querySelector("#chart4"), chart4Options);
    chart4.render();
</script>

</body>
</html>
